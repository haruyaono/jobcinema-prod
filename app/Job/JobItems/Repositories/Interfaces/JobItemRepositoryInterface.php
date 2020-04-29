<?php

namespace App\Job\JobItems\Repositories\Interfaces;

use App\Job\JobItems\JobItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface JobItemRepositoryInterface
{

    // public function findJobItemImages() : Collection;

    public function existJobItemImageAndDeleteOnPost(string $imageFlag, int $editFlag = 0);

    public function saveJobItemImages(UploadedFile $file, string $imageFlag) : string;

    public function existJobItemImageAndDeleteOnDelete($imageFlag, int $editFlag = 0, $job = '');


    public function existJobItemMovieAndDeleteOnPost(string $movieFlag);

    public function saveJobItemMovies(UploadedFile $file, string $movieFlag) : string;

    public function existJobItemMovieAndDeleteOnDelete($movieFlag);
 
}