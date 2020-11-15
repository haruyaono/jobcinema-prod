<?php

namespace App\Services;

use App\Models\JobItem;

interface ObjectStorageInterface
{
    /**
     * 求人メディアのオブジェクトストレージURLを取得
     */
    public function getJobItemImagePublicUrl(JobItem $jobitem): array;

    public function getJobItemMoviePublicUrl(JobItem $jobitem): array;
}
