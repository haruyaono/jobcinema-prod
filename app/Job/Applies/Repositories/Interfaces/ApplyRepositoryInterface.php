<?php

namespace App\Job\Applies\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\Applies\Apply;
use App\Job\JobItems\JobItem;
use Illuminate\Support\Collection;

interface ApplyRepositoryInterface extends BaseRepositoryInterface
{ 

   public function createApply(array $params, int $id) : Apply;

   public function findApplyById(int $id) : Apply; 

   public function listApplies(string $order = '', string $sort = 'desc', array $columns = ['*']) : Collection;

   public function findJobItems(Apply $apply) : Collection; 

   public function associateJobItem(JobItem $jobitem);
 
}