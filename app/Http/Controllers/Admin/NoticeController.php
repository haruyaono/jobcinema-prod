<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $adItems = collect($this->AdItemService->getAllAds());
        return view('admin.notice.index', compact('adItems'));
    }

    public function create()
    {
        $companies = $this->Company->all();
        return view('admin.notice.create', compact('companies'));
    }

    public function store(StoreAdItemRequest $request)
    {
        $file = $request->getFileContent();
        $path = Storage::disk("s3")->putFile("img/uploads/AdItem/".$file->getFilename(), $file, 'public');
        $data = $request->input('data.AdItem');
        $data['image_path'] = Storage::disk("s3")->url($path);
        AdItem::create($data);
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
        $adItem = $this->AdItem->find($id);
        $companies = $this->Company->all();
        $jobItems = $this->JobItem->where('company_id', $adItem->company_id)->get();
        return view('admin.notice.edit', compact('adItem', 'companies', 'jobItems'));
    }

    public function update(UpdateAdItemRequest $request, int $id)
    {
        $adItem = AdItem::find($id);
        $data = $request->input('data.AdItem');
        if($request->exists("data.AdItem.image")) {
            Storage::disk("s3")->delete(parse_url($adItem->image_path)["path"]);
            $file = $request->getFileContent();
            $path = Storage::disk("s3")->putFile("img/uploads/AdItem", $file, 'public');
            $data['image_path'] = Storage::disk("s3")->url($path);
        }
        $adItem->update(Arr::except($data, ['id']));

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
