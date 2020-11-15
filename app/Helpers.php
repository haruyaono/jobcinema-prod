<?php

namespace App\Helpers;

function jobitem_image_path(string $fileName): string
{
    return public_path(config('jobcinema.jobitem_image_dir') . $fileName);
}

function jobitem_movie_path(int $id, string $identifier): string
{
    return storage_path('app') . '/' . config('jobcinema.jobitem_movie_dir') . $id . '/' . $identifier . '/';
}

function getIdentifier(string $flag): ?string
{
    $identifier = '';
    switch ($flag) {
        case '1':
            $identifier = 'main';
            break;
        case '2':
            $identifier = 'sub1';
            break;
        case '3':
            $identifier = 'sub2';
            break;
        default:
            break;
    }
    return $identifier;
}
