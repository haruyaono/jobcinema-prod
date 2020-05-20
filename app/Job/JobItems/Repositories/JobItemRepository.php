<?php

namespace App\Job\JobItems\Repositories;

use App\Job\JobItemImages\JobItemImage;
use App\Job\JobItems\JobItem;
use Jsdecena\Baserepo\BaseRepository;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Image;
use Storage;
use File;

class JobItemRepository extends BaseRepository implements JobItemRepositoryInterface
{

    // private $disk;
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
     * @return Collection
     */
    public function listJobItems(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    public function listJobitemCount() : int
    {
        return $this->model->ActiveJobitem()->count();
    }

    /**
     * base search the jobitems
     *
     * @param string $searchParam
     * @return $query
     */
    public function baseSearchJobItems(array $searchParam = [])
    {

        $query = $this->model::query();

         // ステータス・掲載期限
        $today = date("Y-m-d");
        $query->where('status', 2)
            ->where(function($query) use ($today){
            $query->orWhere('pub_end', '>', $today)
                    ->orWhere('pub_end','無期限で掲載');
            })->where(function($query) use ($today){
            $query->orWhere('pub_start', '<', $today)
                    ->orWhere('pub_start','最短で掲載');
        });
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