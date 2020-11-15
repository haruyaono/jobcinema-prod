<?php

namespace App\Http\Requests\Media;

class MovieUploadRequest extends AbstractMediaUploadRequest
{
    protected function getMediaFieldName(): string
    {
        return 'data.File.movie';
    }

    protected function getMediaValidateParams(): array
    {
        return ['required', 'max:80000', 'mimes:mp4,qt,x-ms-wmv,mpeg,x-msvideo'];
    }
}
