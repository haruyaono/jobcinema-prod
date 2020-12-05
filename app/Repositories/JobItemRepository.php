<?php

namespace App\Repositories;

use App\Models\JobItem;

class JobItemRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return JobItem::class;
    }
}
