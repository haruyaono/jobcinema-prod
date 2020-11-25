<?php

namespace App\Http\Controllers\Admin;

use function App\Helpers\getIdentifier;
use App\Models\JobItem;
use App\Services\JobItemService;
use App\Services\S3Service;
use App\Services\MediaMetadataService;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Media\ImageUploadRequest;
use App\Http\Requests\Admin\JobItem\JobSheetUpdateRequest;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;

class JobItemController extends Controller
{
    private $JobItemService;
    private $S3Service;
    private $mediaMetadataService;
    private $CategoryRepository;

    public function __construct(
        JobItemService $jobItemService,
        S3Service $s3Service,
        MediaMetadataService $mediaMetadataService,
        CategoryRepository $categoryRepository
    ) {
        $this->JobItemService = $jobItemService;
        $this->S3Service = $s3Service;
        $this->mediaMetadataService = $mediaMetadataService;
        $this->CategoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = JobItem::query();

        if ($request->filled('id')) {
            $ids = explode(',', $request->get('id'));
            $model->whereIn('id', $ids);
        }

        $this->getCalendarQuery($model, $request->input('created_at.start'), $request->input('created_at.end'), 'created_at');
        $this->getCalendarQuery($model, $request->input('updated_at.start'), $request->input('updated_at.end'), 'updated_at');

        if ($request->filled('status')) {
            $model->where('status', $request->get('status'));
        }

        $jobitems = $model->get();
        $param = $request->all();

        return view('admin.job_sheet.index', compact('jobitems', 'param'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobitem = JobItem::find($id);
        $imageArray = $this->S3Service->getJobItemImagePublicUrl($jobitem);
        $movieArray = $this->S3Service->getJobItemMoviePublicUrl($jobitem);

        return view('admin.job_sheet.show', compact('jobitem', 'imageArray', 'movieArray'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobitem = JobItem::find($id);
        $categoryList = $this->CategoryRepository->getCategories();
        $imageArray = $this->S3Service->getJobItemImagePublicUrl($jobitem);
        $movieArray = $this->S3Service->getJobItemMoviePublicUrl($jobitem);

        return view('admin.job_sheet.edit', compact('jobitem', 'categoryList', 'imageArray', 'movieArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobSheetUpdateRequest $request, $id)
    {
        $jobitem = JobItem::find($id);
        $param = $request->all();

        $saveCategoryList = $jobitem->categories()->get(['job_item_category.category_id']);
        if (!$saveCategoryList->isEmpty()) {
            foreach ($saveCategoryList as $saveCategoryItem) {
                $jobitem->categories()->detach($saveCategoryItem->category_id);
            }
        }

        $categoryData = $request->input('data.JobSheet.categories');
        $createData = $this->JobItemService->processingCategoryArray($categoryData);

        foreach ($createData as $createItem) {
            $this->JobItemService->associateCategory($id, $createItem);
        }

        if ($request->has('data.File.image')) {
            foreach ($param['data']['File']['image'] as $index => $media) {
                $index++;
                if (array_key_exists('image', $media) && $media['image']) {
                    $this->mediaMetadataService->writeJobItemImage(
                        $jobitem,
                        $media['image'],
                        $media['image']->getClientOriginalExtension(),
                        (string) $index
                    );
                    $this->S3Service->uploadJobItemImage(
                        $jobitem,
                        file_get_contents($this->mediaMetadataService->getJobItemImagelUrl($jobitem, (string) $index)),
                        (string) $index
                    );
                } else {
                    if (array_key_exists('delete', $media)) {
                        $this->mediaMetadataService->deleteJobItemImageFiles(
                            $jobitem,
                            (string) $index
                        );
                        $jobitem->update(['job_img_' . $index => null]);
                    };
                }
            }
        }
        if ($request->has('data.File.movie')) {

            foreach ($param['data']['File']['movie'] as $index => $media) {
                $index++;
                $identifier = getIdentifier((string) $index);
                if ($identifier == '') continue;

                if ((array_key_exists('movie', $media) && $media['movie']) || array_key_exists('delete', $media)) {
                    $this->S3Service->deleteJobItemMovie(
                        $jobitem,
                        (string) $index,
                        $identifier
                    );
                }

                if (array_key_exists('movie', $media) && $media['movie']) {
                    $this->mediaMetadataService->writeJobItemMovie(
                        $jobitem,
                        $media['movie'],
                        (string) $index,
                        $identifier
                    );
                    $this->S3Service->uploadJobItemMovie(
                        $jobitem,
                        file_get_contents($this->mediaMetadataService->getJobItemMovielUrl($jobitem, $identifier, (string) $index)),
                        (string) $index,
                        $identifier
                    );
                } else {
                    if (array_key_exists('delete', $media)) {
                        $this->mediaMetadataService->deleteJobItemMovieFiles($jobitem, $identifier, (string) $index);
                        $jobitem->update(['job_mov_' . $index => null]);
                    };
                }
            }
        }



        if ($param['data']['JobSheet']['pub_start_flag'] == '0' && !array_key_exists('pub_start_date', $param['data']['JobSheet'])) {
            $param['data']['JobSheet']['pub_start_date'] = null;
        }
        if ($param['data']['JobSheet']['pub_end_flag'] == '0' && !array_key_exists('pub_end_date', $param['data']['JobSheet'])) {
            $param['data']['JobSheet']['pub_end_date'] = null;
        }

        $jobitem->update(Arr::except($param['data']['JobSheet'], ['categories']));

        return redirect()->back()->with('status', '保存しました！');
    }

    /**
     * Get calendar query
     * ex. display: 4/1 - 4/30
     *
     * @param mixed $query
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getCalendarQuery($model, $start, $end, $target_start_column)
    {
        // filter startDate
        // ex. 4/1 - startDate - 4/30
        $model->where(function ($model) use ($target_start_column, $start, $end) {
            if ($start != null) {
                $model->where($target_start_column, '>=', $start);
            }
            if ($end != null) {
                $model->where($target_start_column, '<', $end);
            }
        });
        return $model;
    }
}
