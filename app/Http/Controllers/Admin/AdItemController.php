<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\AdItem\StoreAdItemRequest;
use App\Http\Requests\Admin\AdItem\UpdateAdItemRequest;
use App\Models\AdItem;
use App\Services\AdItemService;
use App\Models\Company;
use App\Models\JobItem;
use Illuminate\Support\Arr;

class AdItemController
{
    private $AdItem;
    private $AdItemService;
    private $Company;
    private $JobItem;

    public function __construct(
        AdItem $adItem,
        AdItemService $adItemService,
        Company $company,
        JobItem $jobItem
    ) {
        $this->AdItem = $adItem;
        $this->AdItemService = $adItemService;
        $this->Company = $company;
        $this->JobItem = $jobItem;
    }

    public function index()
    {
        $adItems = collect($this->AdItemService->getAllAds());
        return view('admin.ad_item.index', compact('adItems'));
    }

    public function create()
    {
        $companies = $this->Company->all();
        return view('admin.ad_item.create', compact('companies'));
    }

    public function store(StoreAdItemRequest $request)
    {
        $file = $request->getFileContent();
        $path = Storage::disk("s3")->putFile("img/uploads/AdItem/".$file->getFilename(), $file, 'public');
        $data = $request->input('data.AdItem');
        $data['image_path'] = Storage::disk("s3")->url($path);
        AdItem::create($data);
        return redirect()->route('ad_item.index')->with('status', '作成しました！');
    }

    public function show(int $id)
    {
        return view('admin.ad_item.show', [
            'adItem' =>  AdItem::find($id)
        ]);
    }

    public function edit(int $id)
    {
        $adItem = $this->AdItem->find($id);
        $companies = $this->Company->all();
        $jobItems = $this->JobItem->where('company_id', $adItem->company_id)->get();
        return view('admin.ad_item.edit', compact('adItem', 'companies', 'jobItems'));
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

        return redirect()->route('ad_item.index')->with('status', '保存しました！');
    }

    public function destroy(int $id)
    {
        $adItem = AdItem::find($id);

        Storage::disk("s3")->delete(parse_url($adItem->image_path)["path"]);
        $adItem->delete();
        $message = '削除しました！';
        $status = 1;

        return response()->json([
            'message' => $message,
            'status' => $status,
        ]);}

    public function jobItem($company)
    {
        return json_encode($this->JobItem->where("company_id", $company)->get());
    }
}
