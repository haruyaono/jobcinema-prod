<?php

namespace App\Job\JobItems\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\JobItems\JobItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface JobItemRepositoryInterface extends BaseRepositoryInterface
{

    public function listJobItems(string $order = 'id', string $sort = 'desc', array $columns = ['*'], string $active): Collection;

    public function listJobitemCount(): int;

    public function createJobItem(array $data): JobItem;

    public function updateJobItem(array $data): bool;

    public function updateAppliedJobItem(int $applyId,  array $data): bool;

    public function searchJobItem(array $data = [], string $orderBy = 'created_at', string $sortBy = 'desc', $columns = ['*']): Collection;

    public function listRecentJobItemId(int $historyFlag = 0);

    public function createRecentJobItemIdList($req, int $id): void;

    public function baseSearchJobItems(array $searchParam = []);

    public function findJobItemById($id);

    public function findAllJobItemById($id);

    public function getJobBaseUrl(): string;

    public function associateCategory(array $category);
}
