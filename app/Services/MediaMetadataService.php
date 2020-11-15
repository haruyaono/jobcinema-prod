<?php

namespace App\Services;

use function App\Helpers\jobitem_image_path;
use function App\Helpers\jobitem_movie_path;
use App\Models\JobItem;
use Exception;
use Storage;
use Illuminate\Http\UploadedFile;
use App\Services\S3Service;
use Psr\Log\LoggerInterface;

class MediaMetadataService
{
    private $imageWriter;
    private $s3Service;
    private $logger;

    public function __construct(
        ImageWriter $imageWriter,
        LoggerInterface $logger,
        S3Service $s3Service
    ) {
        $this->imageWriter = $imageWriter;
        $this->s3Service = $s3Service;
        $this->logger = $logger;
    }

    /**
     * Write an jobitem image file with binary data and update the jobitem with the new image attribute.
     *
     * @param string $destination The destination path. Automatically generated if empty.
     */
    public function writeJobItemImage(
        JobItem $jobitem,
        UploadedFile $data,
        string $extension,
        string $flag,
        string $destination = '',
        bool $cleanUp = true
    ): void {
        try {
            $destination = $destination ?: $this->generateJobItemImagePath($extension);
            $this->imageWriter->writeFromData($destination, $data, ['max_width' => 280]);

            if ($cleanUp) {
                $this->deleteJobItemImageFiles($jobitem, $flag);
            }

            $jobitem->update(['job_img_' . $flag => basename($destination)]);
        } catch (Exception $e) {
            $this->logger->error($e);
        }
    }

    private function generateJobItemImagePath(string $extension): string
    {
        return jobitem_image_path(sprintf('%s.%s', sha1(uniqid()), $extension));
    }

    public function getJobItemImagelUrl(JobItem $jobitem, string $flag): ?string
    {
        if (!$jobitem->{"job_img_" . $flag}) {
            return null;
        }

        $url = jobitem_image_path($jobitem->{"job_img_" . $flag});

        if (!file_exists($url)) {
            return null;
        }

        return $url;
    }

    public function deleteJobItemImageFiles(JobItem $jobitem, $flag): void
    {
        if (!$jobitem->{"job_img_" . $flag}) {
            return;
        }

        @unlink($this->getJobItemImagelUrl($jobitem, $flag));
        Storage::disk('s3')->delete(config('jobcinema.jobitem_image_dir') . $jobitem->{"job_img_" . $flag});
    }

    public function writeJobItemMovie(
        JobItem $jobitem,
        UploadedFile $data,
        string $flag,
        string $identifier,
        string $destination = '',
        bool $cleanUp = true
    ): void {
        try {
            $this->generateJobItemMovieDerectory($jobitem, $identifier);

            $destination = $destination ?: config('jobcinema.jobitem_movie_dir') . $jobitem->id . '/' . $identifier;
            $path = $data->store($destination, 'local');

            if ($cleanUp) {
                $this->deleteJobItemMovieFiles($jobitem, $identifier, $flag);
            }

            $jobitem->update(['job_mov_' . $flag => basename($path)]);
        } catch (Exception $e) {
            $this->logger->error($e);
        }
    }


    public function getJobItemMovielUrl(JobItem $jobitem, string $identifier, string $flag): ?string
    {
        if (!$jobitem->{"job_mov_" . $flag}) {
            return null;
        }

        $url = jobitem_movie_path($jobitem->id, $identifier) . $jobitem->{"job_mov_" . $flag};

        if (!file_exists($url)) {
            return null;
        }

        return $url;
    }

    private function generateJobItemMovieDerectory(JobItem $jobitem, string $identifier): void
    {
        if (!file_exists(jobitem_movie_path($jobitem->id, $identifier))) {
            mkdir(jobitem_movie_path($jobitem->id, $identifier), 0777, TRUE);
        }
    }

    public function deleteJobItemMovieFiles(JobItem $jobitem, $identifier, $flag): void
    {
        if (!$jobitem->{"job_mov_" . $flag}) {
            return;
        }

        @unlink($this->getJobItemMovielUrl($jobitem, $identifier, $flag));
    }
}
