<?php

namespace App\Http\Requests\Media;

class MovieUploadRequest extends AbstractMediaUploadRequest
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
        return 'data.File.movie';
    }

    protected function getMediaValidateParams(): array
    {
        return ['required', 'max:80000', 'mimes:mp4,qt,x-ms-wmv,mpeg,x-msvideo'];
    }

    protected function isArray(): bool
    {
        return array_key_exists('File', $this->data) && array_key_exists('movie', $this->data['File']) ? is_array($this->data['File']['movie']) : true;
    }

    protected function getRules(): array
    {
        $data = [];
        if (!array_key_exists('File', $this->data)) return $data;

        if ($this->isArray() && array_key_exists('movie', $this->data['File'])) {
            foreach ($this->data['File']['movie'] as $key => $value) {
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
