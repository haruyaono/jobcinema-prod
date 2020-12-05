<?php

namespace App\Job\ApplyDetails\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\ApplyDetails\ApplyDetail;

interface ApplyDetailRepositoryInterface extends BaseRepositoryInterface
{
   public function createApplyDetail(array $params): ApplyDetail;
}
