<?php

namespace App\Providers;

use Aws\AwsClientInterface;
use Aws\S3\S3ClientInterface;
use Illuminate\Support\ServiceProvider;

class ObjectStorageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(S3ClientInterface::class, static function (): ?AwsClientInterface {
            // これらの2つの値が.envで設定されていない場合、AWSは初期化を試みる
            // null値を持つクライアントはエラーをスローする
            if (!config('aws.credentials.key') || !config('aws.credentials.secret')) {
                return null;
            }

            return app('aws')->createClient('s3');
        });
    }
}
