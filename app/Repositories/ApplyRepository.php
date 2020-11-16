<?php

namespace App\Repositories;

use App\Models\Employer;
use App\Models\Apply;
use Illuminate\Support\Collection;

class ApplyRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return Apply::class;
    }

    public function getAppliedForEmployer(Employer $employer): Collection
    {
        $ids = $employer->jobitems->pluck('id')->toArray();
        return $this->getByIds($ids, 'job_item_id');
    }
}
