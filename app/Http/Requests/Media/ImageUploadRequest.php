<?php

namespace App\Http\Requests\Media;

class ImageUploadRequest extends AbstractMediaUploadRequest
{
    protected function getMediaFieldName(): string
    {
        return 'data.File.image';
    }

    protected function getMediaValidateParams(): array
    {
        return ['required', 'image', 'max:20000', 'mimes:jpeg,gif,png'];
    }
}
