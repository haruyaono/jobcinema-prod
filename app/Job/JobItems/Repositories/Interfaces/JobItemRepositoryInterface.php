<?php

namespace App\Job\JobItems\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Models\JobItem;
use Illuminate\Support\Collection;

interface JobItemRepositoryInterface extends BaseRepositoryInterface
{

    public function listJobItems(string $order = 'id', string $sort = 'desc', array $columns = ['*'], string $active): Collection;

    public function listJobitemCount(): int;

    public function createJobItem(array $data): JobItem;

    public function updateJobItem(array $data): bool;

    public function updateAppliedJobItem(int $applyId,  array $data): bool;

    public function findJobItemById($id);

    public function findAllJobItemById($id);

    public function getJobBaseUrl(): string;

    public function associateCategory(array $category);
}
