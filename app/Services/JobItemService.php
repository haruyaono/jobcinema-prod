<?php

namespace App\Services;

use App\Models\JobItem;
use App\Repositories\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class JobItemService
{
    private $CategoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->CategoryRepository = $categoryRepository;
    }

    /**
     * create recent jobitems id list
     *
     * @param int $id
     * @return void
     */
    public function createRecentJobItemIdList(int $id): void
    {
        if (session()->has('recent_jobs') && is_array(session()->get('recent_jobs'))) {

            $historyLimit = '';
            $jobitem_id_list = array(
                'limit_list' => [],
                'all_list' => []
            );

            $jobitem_id_list['limit_list'] = session()->get('recent_jobs.limit_list');
            $jobitem_id_list['all_list'] = session()->get('recent_jobs.all_list');

            foreach ($jobitem_id_list as $listKey => $idList) {
                if ($listKey === 'limit_list') {
                    if (in_array($id, $idList) == false) {
                        if (count($idList) >= $historyLimit) {
                            array_shift($idList);
                        }
                        array_push($idList, $id);
                    } else {
                        while (($index = array_search($id, $idList)) !== false) {
                            unset($idList[$index]);
                        };
                        array_push($idList, $id);
                    }

                    session()->put('recent_jobs.limit_list', $idList);
                } else {
                    if (in_array($id, $idList) == false) {
                        session()->push('recent_jobs.all_list', $id);
                    } else {
                        while (($index = array_search($id, $idList)) !== false) {
                            unset($idList[$index]);
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
                if (session()->has('recent_jobs.limit_list') && is_array(session()->get('recent_jobs.limit_list'))) {
                    $jobitem_id_list = session()->get('recent_jobs.limit_list');
                }
                break;
            case 1:
                if (session()->has('recent_jobs.all_list') && is_array(session()->get('recent_jobs.all_list'))) {
                    $jobitem_id_list = session()->get('recent_jobs.all_list');
                }
                break;
        }

        if ($jobitem_id_list !== []) {
            $jobitem_id_rv_list = array_reverse($jobitem_id_list);
            $placeholder = '';
            foreach ($jobitem_id_rv_list as $key => $value) {
                $placeholder .= ($key == 0) ? $value : ',' . $value;
            }

            if ($historyFlag === 0) {
                return JobItem::whereIn('id', $jobitem_id_rv_list)->orderByRaw("FIELD(id, $placeholder)", $jobitem_id_rv_list)->get();
            } elseif ($historyFlag === 1) {
                return JobItem::whereIn('id', $jobitem_id_rv_list)->orderByRaw("FIELD(id, $placeholder)", $jobitem_id_rv_list)->paginate(20);
            }
        } else {
            return $jobitem_id_list;
        }
    }

    public function processingCategoryArray(array $dataArray)
    {
        $createData = [];

        foreach ($dataArray as $key => $data) {
            if ($key == 'salary') {
                foreach ($dataArray[$key] as $data) {
                    if (!array_key_exists('id', $data)) {
                        $category = $this->CategoryRepository->getFirstWhere(['slug' => $data['parent_slug']]);
                        $data['id'] = $category->descendants()->where('slug', 'unregistered')->first()->id;
                        $data['parent_id'] = $category->id;
                    }
                    array_push($createData, [
                        'id' => (int) $data['id'],
                        'ancestor_id' => (int) $dataArray['salary_ancestor']['id'],
                        'ancestor_slug' => $dataArray['salary_ancestor']['slug'],
                        'parent_id' =>  (int) $data['parent_id'],
                        'parent_slug' => $data['parent_slug'],
                    ]);
                }
                unset($dataArray[$key]);
                unset($dataArray['salary_ancestor']);
                continue;
            }
            if ($key == 'salary_ancestor') {
                continue;
            }
            $createData[$key] = [
                'id' => (int) $dataArray[$key]['id'],
                'ancestor_id' => (int) $dataArray[$key]['ancestor_id'],
                'ancestor_slug' => $dataArray[$key]['ancestor_slug'],
            ];
        }

        return $createData;
    }

    public function processingCategoryArrayForUpdate(array $dataArray, string $flag)
    {
        $createData = [];

        if ($flag == 'salary') {
            foreach ($dataArray[$flag] as $key => $data) {
                if (!array_key_exists('id', $data)) {
                    $category = $this->CategoryRepository->getFirstWhere(['slug' => $data['parent_slug']]);
                    $data['id'] = $category->descendants()->where('slug', 'unregistered')->first()->id;
                    $data['parent_id'] = $category->id;
                }
                array_push($createData, [
                    'id' => (int) $data['id'],
                    'ancestor_id' => (int) $dataArray['salary_ancestor']['id'],
                    'ancestor_slug' => $dataArray['salary_ancestor']['slug'],
                    'parent_id' =>  (int) $data['parent_id'],
                    'parent_slug' => $data['parent_slug'],
                ]);
            }
        } else {
            array_push($createData, [
                'id' => (int) $dataArray[$flag]['id'],
                'ancestor_id' => (int) $dataArray[$flag]['ancestor_id'],
                'ancestor_slug' => $dataArray[$flag]['ancestor_slug'],
            ]);
        }

        return $createData;
    }


    public function associateCategory(int $id, array $data)
    {
        JobItem::find($id)->categories()->attach($data['id'], [
            'ancestor_id' => $data['ancestor_id'],
            'ancestor_slug' => $data['ancestor_slug'],
            'parent_id' => array_key_exists('parent_id', $data) ? $data['parent_id'] : null,
            'parent_slug' => array_key_exists('parent_slug', $data) ? $data['parent_slug'] : null,
        ]);
    }
}
