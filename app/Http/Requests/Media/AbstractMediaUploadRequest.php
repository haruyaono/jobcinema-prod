<?php

namespace App\Http\Requests\Media;

use App\Http\Requests\Request;

abstract class AbstractMediaUploadRequest extends Request
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isArray()) {
            return $this->getRules();
        }
        return [
            $this->getMediaFieldName() => $this->getMediaValidateParams(),
        ];
    }

    public function getFileContent()
    {
        return $this->file($this->getMediaFieldName());
    }

    public function getFileExtension(): string
    {
        return $this->file($this->getMediaFieldName())->getClientOriginalExtension();
    }

    abstract protected function getMediaFieldName(): string;

    abstract protected function getMediaValidateParams(): array;

    abstract protected function isArray(): bool;

    abstract protected function getRules(): array;
}
