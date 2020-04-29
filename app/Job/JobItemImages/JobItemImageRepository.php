<?php 

namespace App\Job\JobItemImages;

use App\Job\JobItems\JobItem;

class JobItemImageRepository 
{
    /**
     * JobItemImageRepository constructor
     * @param JobItemImage $jobItemImage
     */

     public function __construct(JobItemImage $jobItemImage)
     {
         $this->model = $jobItemImage;
     }

     /**
      * @return mixed
      */
      public function findJobItem() : JobItem
     {
         return $this->model->jobitem;
     }
}