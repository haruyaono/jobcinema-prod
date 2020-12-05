<?php

namespace App\Http\Requests\Media;

class ImageUploadRequest extends AbstractMediaUploadRequest
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
        return 'data.File.image';
    }

    protected function getMediaValidateParams(): array
    {
        return ['required', 'image', 'max:20000', 'mimes:jpeg,gif,png'];
    }

    protected function isArray(): bool
    {
        if (array_key_exists('File', $this->dataArr) && array_key_exists('image', $this->dataArr['File'])) {
            return is_array($this->dataArr['File']['image']);
        }
        if (count($this->dataArr) === 0) return false;

        return true;
    }

    protected function getRules(): array
    {
        $data = [];
        if (!array_key_exists('File', $this->dataArr)) return $data;

        if ($this->isArray() && array_key_exists('image', $this->dataArr['File'])) {
            foreach ($this->dataArr['File']['image'] as $key => $value) {
                $param = ['nullable', 'image', 'max:20000', 'mimes:jpeg,gif,png'];
                if (count($this->option) > 0) {
                    $param = array_merge($param, $this->option);
                }
                $data[$this->getMediaFieldName() . '.' . $key . '.image'] = $param;
            }
        }

        return $data;
    }
}
