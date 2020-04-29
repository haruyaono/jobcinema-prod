<?php

namespace App\Job\JobItems\Repositories\Interfaces;

use App\Job\JobItems\JobItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface JobItemRepositoryInterface
{

    // public function findJobItemImages() : Collection;

    public function existJobItemImageAndDeleteOnPost($imageFlag);

    public function saveJobItemImages(UploadedFile $file, $imageFlag) : string;

    public function existJobItemImageAndDeleteOnDelete($imageFlag);
 
}