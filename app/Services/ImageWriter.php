<?php

namespace App\Services;

use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Illuminate\Http\UploadedFile;

class ImageWriter
{
    private const DEFAULT_MAX_WIDTH = 500;
    private const DEFAULT_QUALITY = 80;

    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function writeFromData(string $destination, UploadedFile $data, array $config = []): void
    {
        $img = $this->imageManager
            ->make($data)
            ->resize(
                $config['max_width'] ?? self::DEFAULT_MAX_WIDTH,
                null,
                static function (Constraint $constraint): void {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                }
            );

        $img->save($destination, $config['quality'] ?? self::DEFAULT_QUALITY);
    }
}
