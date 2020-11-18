<?php

namespace App\Services;

use function App\Helpers\getIdentifier;
use App\Models\JobItem;
use Aws\S3\S3ClientInterface;
use App\Services\ObjectStorageInterface;
use Psr\Log\LoggerInterface;

class S3Service implements ObjectStorageInterface
{
    private $s3Client;
    private $logger;
    private const MEDIA_COUNT = 3;

    public function __construct(?S3ClientInterface $s3Client, LoggerInterface $logger)
    {
        $this->s3Client = $s3Client;
        $this->logger = $logger;
    }

    public function getJobItemImagePublicUrl(JobItem $jobitem): array
    {
        $list = [];
        for ($i = 1; $i < self::MEDIA_COUNT + 1; $i++) {
            if ($jobitem->{'job_img_' . $i}) {
                array_push($list, $this->s3Client->getObjectUrl(
                    config('app.bucket'),
                    config('jobcinema.jobitem_image_dir') . $jobitem->{'job_img_' . $i}
                ));
            } else {
                array_push($list, asset(config('jobcinema.jobitem_noimage_url')));
            }
        }
        return $list;
    }

    public function getJobItemMoviePublicUrl(JobItem $jobitem): array
    {
        $list = [];
        $identifier = '';
        for ($i = 1; $i < self::MEDIA_COUNT + 1; $i++) {
            $identifier = getIdentifier((string) $i);
            if ($jobitem->{'job_mov_' . $i}) {

                if (config('app.env') == 'production' || config('app.env') == 'stage') {
                    $path = pathinfo($jobitem->{'job_mov_' . $i});
                    $filename = $path['filename'] . '_hls.m3u8';
                    if ($this->s3Client->doesObjectExist(config('app.bucket'), config('jobcinema.jobitem_movie_dir') . $jobitem->id . '/' . $identifier . '/' .  $filename)) {
                        array_push($list, $this->s3Client->getObjectUrl(
                            config('app.bucket'),
                            config('jobcinema.jobitem_movie_dir') . $jobitem->id . '/' . $identifier . '/' .  $filename
                        ));
                        continue;
                    }
                } else {
                    array_push($list, $this->s3Client->getObjectUrl(
                        config('app.bucket'),
                        config('jobcinema.jobitem_movie_dir') . $jobitem->id . '/' . $identifier . '/' . $jobitem->{'job_mov_' . $i}
                    ));
                    continue;
                }
            }
            array_push($list, "");
        }
        return $list;
    }

    public function uploadJobItemImage(JobItem $jobitem, $data, string $flag): void
    {
        try {
            $this->s3Client->putObject([
                'ACL' => 'public-read',
                'Bucket' => config('app.bucket'),
                'Key'    => config('jobcinema.jobitem_image_dir') . $jobitem->{"job_img_" . $flag},
                'Body'   => $data,
                'ContentType' => 'image/jpeg'
            ]);
        } catch (Exception $e) {
            $this->logger->error($e);
        }
    }

    public function uploadJobItemMovie(JobItem $jobitem, $data, string $flag, string $identifier): void
    {
        $bucket = config('app.env') == 'production' || config('app.env') == 'stage' ? config('app.tmp_bucket') : config('app.bucket');
        try {
            $this->s3Client->putObject([
                'ACL' => 'public-read',
                'Bucket' =>  $bucket,
                'Key'    => config('jobcinema.jobitem_movie_dir') . $jobitem->id . '/' . $identifier . '/' .  $jobitem->{"job_mov_" . $flag},
                'Body'   => $data,
                'ContentType' => 'video/mp4'
            ]);
        } catch (Exception $e) {
            $this->logger->error($e);
        }
    }

    public function deleteJobItemMovie(JobItem $jobitem, string $flag, string $identifier): void
    {
        $bucket = config('app.env') == 'production' || config('app.env') == 'stage' ? config('app.tmp_bucket') : config('app.bucket');

        try {
            if ($this->s3Client->doesObjectExist($bucket, config('jobcinema.jobitem_movie_dir') . $jobitem->id . '/' . $identifier . '/' . $jobitem->{"job_mov_" . $flag})) {
                $objects = $this->s3Client->listObjects([
                    'Bucket' =>  $bucket,
                    'Prefix' => config('jobcinema.jobitem_movie_dir') . $jobitem->id . '/' . $identifier
                ]);
                foreach ($objects['Contents'] as $object) {
                    $this->s3Client->deleteObject([
                        'Bucket' =>  $bucket,
                        'Key' => $object['Key']
                    ]);
                }
            }

            if (config('app.env') != 'local') {
                $objects2 = $this->s3Client->listObjects([
                    'Bucket' =>  config('app.bucket'),
                    'Prefix' => config('jobcinema.jobitem_movie_dir') . $jobitem->id . '/' . $identifier
                ]);
                foreach ($objects2['Contents'] as $object) {
                    $this->s3Client->deleteObject([
                        'Bucket' =>  config('app.bucket'),
                        'Key' => $object['Key']
                    ]);
                }
            }
        } catch (Exception $e) {
            $this->logger->error($e);
        }
    }
}
