<?php

namespace App\Job\JobItems\Repositories;

use App\Models\JobItem;
use Jsdecena\Baserepo\BaseRepository;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\JobItems\Exceptions\JobItemNotFoundException;
use App\Job\JobItems\Exceptions\JobItemCreateErrorException;
use App\Job\JobItems\Exceptions\JobItemUpdateErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

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
    public function listJobItems(string $order = 'id', string $sort = 'desc', array $columns = ['*'], string $active = 'on'): Collection
    {
        if ($active === 'on') {
            return $this->model->ActiveJobitem()->orderBy($order, $sort)->get($columns);
        } elseif ($active === 'off') {
            return $this->model->orderBy($order, $sort)->get($columns);
        }
    }

    /**
     * count active jobitems
     *
     * @return integer
     */
    public function listJobitemCount(): int
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
    public function createJobItem(array $data): JobItem
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
    public function updateAppliedJobItem(int $applyId,  array $data): bool
    {
        return $this->model->applies()->updateExistingPivot($applyId, $data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function searchJobItem(array $data = [], string $orderBy = 'created_at', string $sortBy = 'desc', $columns = ['*']): Collection
    {
        if ($data !== []) {
            return $this->queryBy($this->model::query(), $data)->orderBy($orderBy, $sortBy)->get($columns);
        } else {
            return $this->listJobItems($orderBy, $sortBy, ['*'], 'off');
        }
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
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new JobItemNotFoundException($e);
        }
    }

    /**
     * @param void
     *
     * @return $jobImageBaseUrl
     */
    public function getJobBaseUrl(): string
    {
        $jobBaseUrl = '';
        if (config('app.env') == 'production') {
            $jobBaseUrl = config('app.s3_url');
        } else {
            $jobBaseUrl = config('app.s3_url_local');
        }

        return $jobBaseUrl;
    }

    /**
     * @param array $category
     */
    public function associateCategory(array $category)
    {
        $this->model->categories()->attach($category['id'], [
            'ancestor_id' => $category['ancestor_id'],
            'ancestor_slug' => $category['ancestor_slug'],
            'parent_id' => array_key_exists('parent_id', $category) ? $category['parent_id'] : null,
            'parent_slug' => array_key_exists('parent_slug', $category) ? $category['parent_slug'] : null,
        ]);
    }

    /**
     * @param int $categoryId
     */
    public function dissociateCategory(int $categoryId)
    {
        $this->model->categories()->detach($categoryId);
    }
}
