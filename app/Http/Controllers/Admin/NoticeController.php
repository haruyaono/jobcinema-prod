<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notice\StoreNoticeRequest;
use App\Http\Requests\Admin\Notice\UpdateNoticeRequest;
use App\Models\Notice;
use App\Services\NoticeService;
use App\Services\NoticeReadService;
use Illuminate\Support\Arr;

class NoticeController extends Controller
{
    private $NoticeService;
    private $NoticeReadService;

    public function __construct(
        NoticeService $noticeService,
        NoticeReadService $noticeReadService
    ) {
        $this->NoticeService = $noticeService;
        $this->NoticeReadService = $noticeReadService;
    }

    public function index()
    {
        $notices = collect(Notice::all());
        return view('admin.notice.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notice.create');
    }

    public function store(StoreNoticeRequest $request)
    {
        Notice::create($request->input('data.Notice'));
        return redirect()->route('notice.index')->with('status', '作成しました！');
    }

    public function show(int $id)
    {
        return view('admin.notice.show', [
            'notice' =>  Notice::find($id)
        ]);
    }

    public function edit(int $id)
    {
        $notice = Notice::find($id);
        return view('admin.notice.edit', compact('notice'));
    }

    public function update(UpdateNoticeRequest $request, int $id)
    {
        $notice = Notice::find($id);
        $notice->update(Arr::except($request->input('data.Notice'), ['id']));

        return redirect()->route('notice.index')->with('status', '保存しました！');
    }

    public function destroy(int $id)
    {
        $adItem = Notice::find($id);

        $adItem->delete();
        $message = '削除しました！';
        $status = 1;

        return response()->json([
            'message' => $message,
            'status' => $status,
        ]);
    }
}
