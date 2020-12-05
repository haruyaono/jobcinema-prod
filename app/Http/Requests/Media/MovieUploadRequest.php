<?php

namespace App\Http\Requests\Media;

class MovieUploadRequest extends AbstractMediaUploadRequest
{
    private $dataArr;
    private $option;

    public function __construct(array $data = [], array $option = [])
    {
        $this->dataArr = $data;
        $this->option = $option;
    }

    protected function getMediaFieldName(): string
    {
        return 'data.File.movie';
    }

    protected function getMediaValidateParams(): array
    {
        return ['required', 'max:80000', 'mimes:mp4,qt,x-ms-wmv,mpeg,x-msvideo'];
    }

    protected function isArray(): bool
    {
        if (array_key_exists('File', $this->dataArr) && array_key_exists('movie', $this->dataArr['File'])) {

            return is_array($this->dataArr['File']['movie']);
        }

        if (count($this->dataArr) === 0) return false;

        return true;
    }

    protected function getRules(): array
    {
        $data = [];
        if (!array_key_exists('File', $this->dataArr)) return $data;

        if ($this->isArray() && array_key_exists('movie', $this->dataArr['File'])) {
            foreach ($this->dataArr['File']['movie'] as $key => $value) {
                $param = ['nullable', 'max:80000', 'mimes:mp4,qt,x-ms-wmv,mpeg,x-msvideo'];
                if (count($this->option) > 0) {
                    $param = array_merge($param, $this->option);
                }
                $data[$this->getMediaFieldName() . '.' . $key . '.movie'] = $param;
            }
        }

        return $data;
    }
}
