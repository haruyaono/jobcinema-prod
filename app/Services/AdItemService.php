<?php


namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Models\AdItem;

class AdItemService
{
    private $AdItem;

    public function __construct(
        AdItem $AdItem
    ) {
        $this->AdItem = $AdItem;
    }

    private function getDefaultAdItem(): array
    {
        return [
            [
                "href" => "/beginners",
                "src" => "/img/common/jobcinema_hedd_sam4_aのコピー.png",
                "alt" => "JOBCiNEMAとは"
            ],
            [
                "href" => "/lp",
                "src" => "/img/common/jobcinema_hedd_sam5_aのコピー.png",
                "alt" => "広告掲載企業募集について"
            ],
            [
                "href" => "/reward_request",
                "src" => "/img/common/jobcinema_hedd_sam6_aのコピー.png",
                "alt" => "お祝い金申請について"
            ]
        ];
    }

    /**
     * @param Collection $adItem
     * @return array
     */
    private function transArray(Collection $adItem): array
    {
        return $adItem->map(function($item, $key) {
            return [
                "id" => $item["id"],
                "href" => "/job_sheet/".$item["job_item_id"],
                "src" => $item["image_path"],
                "alt" => $item["description"],
            ];
        })->toArray();
    }

    /**
     * @param string $date Y-m-d H:i:s
     * @return array
     */
    public function getCurrentItems(string $date): array
    {
        $adItemCollection = $this->AdItem->where("started_at", "<=", $date)->where("ended_at", ">", $date)->where("is_view", true)->get();
        return array_slice(array_merge($this->transArray($adItemCollection), $this->getDefaultAdItem()), 0, 3);
    }

    /**
     * @param string $date Y-m-d H:i:s
     * @return array
     */
    public function getCurrentAds(string $date): array
    {
        $adItemCollection = $this->AdItem->where("started_at", "<=", $date)->where("ended_at", ">", $date)->where("is_view", true)->get();
        return $this->transArray($adItemCollection);
    }

    /**
     * @return object
     */
    public function getAllAds(): object
    {
        return $this->AdItem->all();
    }

    /**
     * @param string $date Y-m-d H:i:s
     * @return int
     */
    public function getCurrentAdCount(string $date): int
    {
        return $this->AdItem->where("started_at", "<=", $date)->where("ended_at", ">", $date)->where("is_view", true)->count();
    }
}