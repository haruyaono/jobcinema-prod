<?php

namespace App\Services;

use App\Models\JobItem;
use DB;

class JobItemSearchService
{
    public function __construct()
    { }

    /**
     * base search the jobitems
     *
     * @param string $searchParam
     * @return $query
     */
    public function search(array $searchParam = [])
    {
        $query = JobItem::activeJobitem()->with([
            'categories',
            'categories.congratsMoney'
        ]);

        $newsearchParam = $searchParam;

        foreach ($newsearchParam as $key => $p) {
            if ($p === null) {
                unset($newsearchParam[$key]);
            }
        }

        if ($newsearchParam !== []) {
            $this->searchQuery($query, $searchParam);
        } else {
            $query->latest();
        }

        return $query;
    }

    public function searchQuery($query, array $searchParams)
    {
        if (isset($searchParams['keyword'])) {
            $query->where(function ($query) use ($searchParams) {
                $query->where('job_title', 'like', "%${searchParams['keyword']}%")
                    ->orWhere('job_office', 'like', "%${searchParams['keyword']}%")
                    ->orWhere('job_desc', 'like', "%${searchParams['keyword']}%")
                    ->orWhere('job_intro', 'like', "%${searchParams['keyword']}%");
            });
        }
        foreach ($searchParams as $key => $searchParam) {
            if ($key == 'keyword' || $key == 'salary' || $key == 'ks' || $searchParam === null) {
                continue;
            }
            $query->whereHas('categories', function ($builder) use ($searchParam) {
                $builder->where('categories.id', $searchParam);
            });
        }

        if (!isset($searchParams['ks'])) return;

        $orderFlag = $searchParams['ks'];

        if (array_key_exists('slug', $orderFlag) && $orderFlag['slug'] != '') {

            $query->join('job_item_category', 'job_items.id', '=', 'job_item_category.job_item_id')
                ->select('job_item_category.category_id', 'job_item_category.parent_slug', 'job_item_category.ancestor_slug');

            if ($orderFlag['slug'] == 'salary') {
                $query->where('job_item_category.parent_slug', $orderFlag['parent']);
            } else {
                $query->where('job_item_category.ancestor_slug', $orderFlag['slug'] == 'oiwaikin' ? 'status' : $orderFlag['slug']);
            }

            $query->join('categories', 'job_item_category.category_id', '=', 'categories.id');

            if ($orderFlag['slug'] == 'oiwaikin') {

                $rewards = DB::table('congrats_monies')
                    ->select('category_id', 'amount');

                $query->joinSub($rewards, 'rewards', function ($join) {
                    $join->on('categories.id', '=', 'rewards.category_id');
                })->select('categories.id as category_id', 'rewards.amount');
            }

            $query->addSelect('job_items.*');

            if (array_key_exists('order', $orderFlag) && $orderFlag['order'] != '') {
                $query->orderBy('categories.sort', $orderFlag['order']);
            } else {
                if ($orderFlag['slug'] == 'oiwaikin') {
                    $query->orderBy('rewards.amount', 'desc');
                }
                $query->orderBy('categories.sort', 'desc');
            }
        }
    }
}
