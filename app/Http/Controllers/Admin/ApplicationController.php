<?php

namespace App\Http\Controllers\Admin;

use function App\Helpers\getIdentifier;
use App\Models\Apply;
use App\Services\JobItemService;
use App\Services\S3Service;
use App\Services\MediaMetadataService;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Application\ApplicationUpdateRequest;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
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
        $model = Apply::query();

        if ($request->filled('id')) {
            $ids = explode(',', $request->get('id'));
            $model->whereIn('id', $ids);
        }

        $this->getCalendarQuery($model, $request->input('created_at.start'), $request->input('created_at.end'), 'created_at');
        $this->getCalendarQuery($model, $request->input('e_first_attendance_at.start'), $request->input('e_first_attendance_at.end'), 'e_first_attendance');

        if ($request->filled('s_recruit_status')) {
            $model->where('s_recruit_status', $request->get('s_recruit_status'));
        }
        if ($request->filled('e_recruit_status')) {
            $model->where('e_recruit_status', $request->get('e_recruit_status'));
        }

        switch ($flag = $request->input('recruit_status_flag')) {
            case '0':
                $model->whereColumn('s_recruit_status', '<>', 'e_recruit_status');
                break;
            case '1':
                $model->whereColumn('s_recruit_status', 'e_recruit_status');
                break;
        }

        switch ($flag = $request->input('first_attendance_flag')) {
            case '0':
                $model->whereColumn('s_first_attendance', '!=', 'e_first_attendance')->orWhereNull('s_first_attendance')->orWhereNull('e_first_attendance');
                break;
            case '1':
                $model->whereColumn('s_first_attendance', 'e_first_attendance');
                break;
        }

        $applies = $model->get();
        $param = $request->all();

        return view('admin.application.index', compact('applies', 'param'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apply = Apply::find($id);
        return view('admin.application.show', compact('apply'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $apply = Apply::find($id);
        return view('admin.application.edit', compact('apply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationUpdateRequest $request, $id)
    {
        $apply = Apply::find($id);
        $param = $request->all();

        $apply->update(Arr::except($param['data']['Application'], ['id']));

        return redirect()->back()->with('status', '保存しました！');
    }
}
