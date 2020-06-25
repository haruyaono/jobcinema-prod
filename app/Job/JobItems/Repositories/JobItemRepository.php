<?php

namespace App\Job\JobItems\Repositories;

use App\Job\JobItemImages\JobItemImage;
use App\Job\JobItems\JobItem;
use Jsdecena\Baserepo\BaseRepository;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\JobItems\Exceptions\JobItemNotFoundException;
use App\Job\JobItems\Exceptions\AppliedJobItemNotFoundException;
use App\Job\JobItems\Exceptions\JobItemCreateErrorException;
use App\Job\JobItems\Exceptions\JobItemUpdateErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Image;
use Storage;
use File;

class JobItemRepository extends BaseRepository implements JobItemRepositoryInterface
{
    /**
     * JobItemRepository constructor.
     * @param JobItem $jobItem
     */
    public function __construct(JobItem $jobItem)
    {
        parent::__construct($jobItem);
        $this->model = $jobItem;
    }

    /**
     * List all the jobitems
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @param string $active
     * @return Collection
     */
    public function listJobItems(string $order = 'id', string $sort = 'desc', array $columns = ['*'], string $active = 'on') : Collection
    {
        if($active === 'on') {
            return $this->model->ActiveJobitem()->orderBy($order, $sort)->get($columns);
        } elseif($active === 'off') {
            return $this->model->orderBy($order, $sort)->get($columns);
        }
    }

    /**
     * count active jobitems
     *
     * @return integer
     */
    public function listJobitemCount() : int
    {
        return $this->model->ActiveJobitem()->count();
    }

     /**
     * Create the jobitem
     *
     * @param array $data
     *
     * @return JobItem
     * @throws JobItemCreateErrorException
     */
    public function createJobItem(array $data) : JobItem
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new JobItemCreateErrorException($e);
        }
    }

   /**
     * @param array $data
     * @return bool
     * 
     * @throws JobItemUpdateErrorException
     */
    public function updateJobItem(array $data): bool
    {
        try {
            return $this->model->where('id', $this->model->id)->update($data);
        } catch (QueryException $e) {
            throw new JobItemUpdateErrorException($e);
        }
    }

    /**
     * @param int $applyId
     * @param array $data
     * @return bool
     */
    public function updateAppliedJobItem(int $applyId,  array $data) : bool
    {
     return $this->model->applies()->updateExistingPivot($applyId, $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function searchJobItem(array $data = [], string $orderBy = 'created_at', string $sortBy = 'desc', $columns = ['*']) : Collection
    {
        if ($data !== []) {
            return $this->queryBy($this->model::query(), $data)->orderBy($orderBy, $sortBy)->get($columns);
        } else {
            return $this->listJobItems($orderBy, $sortBy, ['*'], 'off');
        }
    }

    /**
     * create recent jobitems id list
     *
     * @param array $req
     * @param integer $id
     * @return void
     */
    public function createRecentJobItemIdList($req, int $id) : void
    {
        if(session()->has('recent_jobs') && is_array(session()->get('recent_jobs'))) {
      
            $historyLimit = '';
            $jobitem_id_list = array(
                'limit_list' => [],
                'all_list' => []
            );

            $jobitem_id_list['limit_list'] = session()->get('recent_jobs.limit_list');
            $jobitem_id_list['all_list'] = session()->get('recent_jobs.all_list');
    
            $deviceFrag = $this->model->isMobile($req);
            switch ($deviceFrag) {
                case 'pc':
                    $historyLimit = 5;
                    break;
                case 'mobile':
                    $historyLimit = 3;
                    break;
                default:
                    $historyLimit = '';
                    break;
            }

            foreach($jobitem_id_list as $listKey => $idList) {
                if($listKey === 'limit_list') {
                    if(in_array($id, $idList) == false ) {
                        if(count($idList) >= $historyLimit) {
                            array_shift($idList);
                        } 
                        array_push($idList, $id);
                    } else {
                        while(($index = array_search($id, $idList)) !== false) {
                            unset( $idList[$index] );
                        };
                        array_push($idList, $id);
                    }
        
                    session()->put('recent_jobs.limit_list', $idList);
                } else {
                    if(in_array($id, $idList) == false ) {
                        session()->push('recent_jobs.all_list', $id);
                    } else {
                        while(($index = array_search($id, $idList)) !== false) {
                            unset( $idList[$index] );
                        };
                        array_push($idList, $id);
                        session()->put('recent_jobs.all_list', $idList);
                    }
                }
            }
    
        } else {
            session()->push('recent_jobs.limit_list', $id);
            session()->push('recent_jobs.all_list', $id);
        }
    }
    
     /**
     *  list recent jobitems id
     *
     * @return LengthAwarePaginator|Collection|array
     */
    public function listRecentJobItemId(int $historyFlag = 0) 
    {
        $jobitem_id_list = [];
        switch ($historyFlag) {
            case 0:
                if(session()->has('recent_jobs.limit_list') && is_array(session()->get('recent_jobs.limit_list'))) {
                    $jobitem_id_list = session()->get('recent_jobs.limit_list');
                }
                break;
            case 1:
                if(session()->has('recent_jobs.all_list') && is_array(session()->get('recent_jobs.all_list'))) {
                    $jobitem_id_list = session()->get('recent_jobs.all_list');
                }
                break;
        }

        if($jobitem_id_list !== []) {
            $jobitem_id_rv_list = array_reverse($jobitem_id_list);
            $placeholder = '';
            foreach ($jobitem_id_rv_list as $key => $value) {
                $placeholder .= ($key == 0) ? '?' : ',?';
            }
    
            if($historyFlag === 0) {
                return $this->model->whereIn('id', $jobitem_id_rv_list)->orderByRaw("FIELD(id, $placeholder)",$jobitem_id_rv_list)->get();
            } elseif($historyFlag === 1) {
                return $this->model->whereIn('id', $jobitem_id_rv_list)->orderByRaw("FIELD(id, $placeholder)",$jobitem_id_rv_list)->paginate(20);
            }
        } else {
            return $jobitem_id_list;
        }
    } 

    /**
     * base search the jobitems
     *
     * @param string $searchParam
     * @return $query
     */
    public function baseSearchJobItems(array $searchParam = [])
    {

        $query = $this->model::query()->ActiveJobitem();

        //結合
        if(array_key_exists('title', $searchParam) && !empty($searchParam['title'] )) {
            $query->where(function($query) use ($searchParam) {
                $query->where('job_title','like','%'.$searchParam['title'].'%')
                    ->orWhere('job_type', 'like','%'.$searchParam['title'].'%')
                    ->orWhere('job_hourly_salary', 'like','%'.$searchParam['title'].'%')
                    ->orWhere('job_target', 'like','%'.$searchParam['title'].'%')
                    ->orWhere('job_treatment', 'like','%'.$searchParam['title'].'%')
                    ->orWhere('job_office_address', 'like','%'.$searchParam['title'].'%');
            });
        };
        $query->whereHas('status_cat_get', function ($query) use($searchParam){
            if(array_key_exists('status_cat_id', $searchParam) && !empty($searchParam['status_cat_id'])){
                $query->where('status_categories.id', $searchParam['status_cat_id']);
            }
        });
        $query->whereHas('type_cat_get', function ($query) use($searchParam){
            if(array_key_exists('type_cat_id', $searchParam) && !empty($searchParam['type_cat_id'] )){
                $query->where('type_categories.id', $searchParam['type_cat_id']);
            }
        });
        $query->whereHas('area_cat_get', function ($query) use($searchParam){
            if(array_key_exists('area_cat_id', $searchParam) && !empty($searchParam['area_cat_id'] )){
                $query->where('area_categories.id', $searchParam['area_cat_id']);
            }
        });
        $query->whereHas('hourly_salary_cat_get', function ($query) use($searchParam){
            if(array_key_exists('hourly_salary_cat_id', $searchParam) && !empty($searchParam['hourly_salary_cat_id'] )){
                $query->where('hourly_salary_categories.id', $searchParam['hourly_salary_cat_id']);
            }
        });
        $query->whereHas('date_cat_get', function ($query) use($searchParam){
            if(array_key_exists('date_cat_id', $searchParam) && !empty($searchParam['date_cat_id'] )){
                $query->where('date_categories.id', $searchParam['date_cat_id']);
            }
        });

        return $query;
    }

     /**
     * search query jobitems
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return $query
     */
    public function getSortJobItems($query, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $query->orderBy($order, $sort);
    }

    /**
     * Find the active jobitem by ID
     *
     * @return Collection|JobItem
     * @throws JobItemNotFoundException
     */
    public function findJobItemById($id)
    {
        try {
            // return $this->model->ActiveJobitem()->findOrFail($id);
            return $this->model->ActiveJobitem()->findOrFail($id);
        } catch (ModelNotFoundException $e) { 
            throw new JobItemNotFoundException($e);
        }
    }

    /**
     * Find the jobitem by ID
     *
     * @return Collection|JobItem
     * @throws JobItemNotFoundException
     */
    public function findAllJobItemById($id)
    {
        try {
            // return $this->model->ActiveJobitem()->findOrFail($id);
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) { 
            throw new JobItemNotFoundException($e);
        }
    }

    /**
     * @param JobItem $jobitem
     * @return array
     */
    public function savedDbFilePath(JobItem $jobitem) : array
    {
        $savedFilePath = [];
        $fileSessionKeys = config('const.FILE_SLUG');

        foreach($fileSessionKeys as $fileSessionKey) {
          switch($fileSessionKey) {
            case 'main':
                $savedFilePath['image'][$fileSessionKey] = $jobitem->job_img;
                $savedFilePath['movie'][$fileSessionKey] = $jobitem->job_mov;
                break;
            case 'sub1':
                $savedFilePath['image'][$fileSessionKey] = $jobitem->job_img2;
                $savedFilePath['movie'][$fileSessionKey] = $jobitem->job_mov2;
              break;
            case 'sub2':
                $savedFilePath['image'][$fileSessionKey] = $jobitem->job_img3;
                $savedFilePath['movie'][$fileSessionKey] = $jobitem->job_mov3;
              break;
          }
        }

        return $savedFilePath;
    }

    /**
     * @param string $imageFlag
     *
     * @return void
     */
    public function existJobItemImageAndDeleteOnPost(string $imageFlag, int $editFlag = 0)
    {
        $disk = Storage::disk('s3');

        // 新規作成時か編集時か
        if($editFlag === 0) {
            // 新規作成時
            $image_path_list = session()->get('data.file.image');

            if($imageFlag) {
                if(isset($image_path_list[$imageFlag])) {
                    if (File::exists(public_path() . $image_path_list[$imageFlag])) {
                        File::delete(public_path() . $image_path_list[$imageFlag]);
                    }
    
                    if($disk->exists($image_path_list[$imageFlag])) {
                        $disk->delete($image_path_list[$imageFlag]);
                    }
    
                    unset($image_path_list[$imageFlag]);
                }
                
            } 
    
            return $image_path_list;
    
        } else {
            // 編集時
            $edit_image_path_list = session()->get('data.file.edit_image');

            if($imageFlag) {
                if(isset($edit_image_path_list[$imageFlag])) {
                    if (File::exists(public_path() . $edit_image_path_list[$imageFlag])) {
                        File::delete(public_path() . $edit_image_path_list[$imageFlag]);
                    }
    
                    if($disk->exists($edit_image_path_list[$imageFlag])) {
                        $disk->delete($edit_image_path_list[$imageFlag]);
                    }
    
                    unset($edit_image_path_list[$imageFlag]);
                }
                
            } 
    
            return $edit_image_path_list;
        }
    }

    /**
     * @param UploadedFile $file
     *
     * @return $image_path
     */
    public function saveJobItemImages(UploadedFile $file, $imageFlag) : string
    {
        $disk = Storage::disk('s3');

        $resize_image = Image::make($file)->widen(300);

        if($imageFlag) {
            $image_name = uniqid($imageFlag . "_image").".".$file->guessExtension();
        } else {
            $image_name = $file->hashName();
        }

        // ファイルを保存
        $resize_image->save(public_path(\Config::get('fpath.tmp_img').$image_name));
       
        // ファイルパスを取得
        $image_path = \Config::get('fpath.tmp_img').$image_name;

        // ファイル情報を取得
        $imageContents = File::get(public_path(\Config::get('fpath.tmp_img').$image_name));

        $disk->put($image_path, $imageContents, 'public');

        return $image_path;
    }

    /**
     * @param string $imageFlag
     *
     * @return void
     */
    public function existJobItemImageAndDeleteOnDelete($imageFlag, int $editFlag = 0, $job = '')
    {
        $disk = Storage::disk('s3');

         // 新規作成時か編集時か
         if($editFlag === 0) {
            // 新規作成時

            $image_path_list = session()->get('data.file.image');

            if(isset($image_path_list[$imageFlag])) {

                if (File::exists(public_path() . $image_path_list[$imageFlag])) {
                    File::delete(public_path() . $image_path_list[$imageFlag]);
                  }
                  if($disk->exists($image_path_list[$imageFlag])) {
                    $disk->delete($image_path_list[$imageFlag]);
                  }
    
                  unset($image_path_list[$imageFlag]);
            }
    
            session()->put('data.file.image', $image_path_list);

         } else {
            // 編集時
            
            $edit_image_path_list = session()->get('data.file.edit_image');

            if($edit_image_path_list[$imageFlag] == '') {
                return false;
            }

            if(isset($edit_image_path_list[$imageFlag])) {

                if (File::exists(public_path() . $edit_image_path_list[$imageFlag])) {
                    File::delete(public_path() . $edit_image_path_list[$imageFlag]);
                }
                if($disk->exists($edit_image_path_list[$imageFlag])) {
                    $disk->delete($edit_image_path_list[$imageFlag]);
                }
    
            }

            switch($imageFlag) {
                case $imageFlag == 'main':
                    $jobImagePath = $job->job_img;
                    break;
                case $imageFlag == 'sub1':
                    $jobImagePath = $job->job_img2;
                    break;
                case $imageFlag == 'sub2':
                    $jobImagePath = $job->job_img3;
                    break;
                default:
                    $jobImagePath = null;
            }
    
            if($jobImagePath != null) {
                $edit_image_path_list[$imageFlag] = '';
            } else {
                unset($edit_image_path_list[$imageFlag]);
            }

            session()->put('data.file.edit_image', $edit_image_path_list);
         }
    }

    /**
     * @param string $movieFlag
     *
     * @return array $movie_path_list
     */
    public function existJobItemMovieAndDeleteOnPost(string $movieFlag, int $editFlag = 0) : array
    {
        $disk = Storage::disk('s3');

        // 新規作成時か編集時か
        if($editFlag === 0) {
            // 新規作成時

            $movie_path_list = session()->get('data.file.movie');

            if($movieFlag) {
                if(isset($movie_path_list[$movieFlag])) {
                    if (File::exists(public_path() . $movie_path_list[$movieFlag])) {
                        File::delete(public_path() . $movie_path_list[$movieFlag ]);
                    }
    
                    if($disk->exists($movie_path_list[$movieFlag ])) {
                        $disk->delete($movie_path_list[$movieFlag ]);
                    }
    
                    unset($movie_path_list[$movieFlag]);
                }  
            } 
    
            return $movie_path_list;
        } else {
            // 編集時

            $edit_movie_path_list = session()->get('data.file.edit_movie');

            if($movieFlag) {
                if(isset($edit_movie_path_list[$movieFlag])) {
                    if (File::exists(public_path() . $edit_movie_path_list[$movieFlag])) {
                        File::delete(public_path() . $edit_movie_path_list[$movieFlag ]);
                    }
    
                    if($disk->exists($edit_movie_path_list[$movieFlag ])) {
                        $disk->delete($edit_movie_path_list[$movieFlag ]);
                    }
    
                    unset($edit_movie_path_list[$movieFlag]);
                }  
            } 
    
            return $edit_movie_path_list;
        }
    }

    /**
     * @param UploadedFile $file
     *
     * @return string $movie_path
     */
    public function saveJobItemMovies(UploadedFile $file, string $movieFlag) : string
    {
        $disk = Storage::disk('s3');

        if($movieFlag) {
            $movie_name = uniqid($movieFlag . "_movie").".".$file->guessExtension();
        } else {
            $movie_name = $file->hashName();
        }

        // ファイルを保存
        $file->move(public_path() . \Config::get('fpath.tmp_mov'), $movie_name);
       
        // ファイルパスを取得
        $movie_path = \Config::get('fpath.tmp_mov').$movie_name;

        // ファイル情報を取得
        $movieContents = File::get(public_path(\Config::get('fpath.tmp_mov').$movie_name));

        $disk->put($movie_path, $movieContents, 'public');

        return $movie_path;
    }


    /**
     * @param string $movieFlag
     *
     * @return void
     */
    public function existJobItemMovieAndDeleteOnDelete($movieFlag, int $editFlag = 0, $job = '')
    {
        $disk = Storage::disk('s3');

        // 新規作成時か編集時か
        if($editFlag === 0) {
            // 新規作成時

            $movie_path_list = session()->get('data.file.movie');

            if(isset($movie_path_list[$movieFlag])) {
                if (File::exists(public_path() . $movie_path_list[$movieFlag])) {
                    File::delete(public_path() . $movie_path_list[$movieFlag]);
                }
                if($disk->exists($movie_path_list[$movieFlag])) {
                    $disk->delete($movie_path_list[$movieFlag]);
                }

                unset($movie_path_list[$movieFlag]);
            }

            session()->put('data.file.movie', $movie_path_list);
        } else {
            // 編集時

            $edit_movie_path_list = session()->get('data.file.edit_movie');

            if($edit_movie_path_list[$movieFlag] == '') {
                return false;
            }
                   
            if(isset($edit_movie_path_list[$movieFlag])) {
                if (File::exists(public_path() . $edit_movie_path_list[$movieFlag])) {
                    File::delete(public_path() . $edit_movie_path_list[$movieFlag]);
                }
                if($disk->exists($edit_movie_path_list[$movieFlag])) {
                    $disk->delete($edit_movie_path_list[$movieFlag]);
                }
            }

            switch($movieFlag) {
                case $movieFlag == 'main':
                    $jobMoviePath = $job->job_mov;
                    break;
                case $movieFlag == 'sub1':
                    $jobMoviePath = $job->job_mov2;
                    break;
                case $movieFlag == 'sub2':
                    $jobMoviePath = $job->job_mov3;
                    break;
                default:
                    $jobMoviePath = null;
            }
    
            if($jobMoviePath != null) {
                $edit_movie_path_list[$movieFlag] = '';
            } else {
                unset($edit_movie_path_list[$movieFlag]);
            }

            session()->put('data.file.edit_movie', $edit_movie_path_list);
        }
    }

    /**
     * @param void
     *
     * @return $jobImageBaseUrl
     */
    public function getJobImageBaseUrl() : string
    {
        $jobImageBaseUrl = '';
        if(config('app.env') == 'production') {
            $jobImageBaseUrl = config('app.s3_url');
        } else {
            $jobImageBaseUrl = '';
        }

        return $jobImageBaseUrl;
    }

}