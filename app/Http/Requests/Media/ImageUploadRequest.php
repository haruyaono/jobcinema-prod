<?php

namespace App\Http\Requests\Media;

class ImageUploadRequest extends AbstractMediaUploadRequest
{
    private $data;
    private $option;

    public function __construct(array $data, array $option = [])
    {
        $this->data = $data;
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
        return array_key_exists('File', $this->data) && array_key_exists('image', $this->data['File']) ? is_array($this->data['File']['image']) : true;
    }

    protected function getRules(): array
    {
        $data = [];
        if (!array_key_exists('File', $this->data)) return $data;

        if ($this->isArray() && array_key_exists('image', $this->data['File'])) {
            foreach ($this->data['File']['image'] as $key => $value) {
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
