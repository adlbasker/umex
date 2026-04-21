<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

trait ImageProcessor
{
    private function getDestinationPath(string $path): string
    {
        $fullPath = public_path($path);
        $directory = dirname($fullPath);

        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }

        return $fullPath;
    }

    private function getImageManager(): ImageManager
    {
        return new ImageManager(new GdDriver);
    }

    public function resizeImage($image, int $width, int $height, string $path, int $quality, $watermark = null, string $color = '#ffffff'): void
    {
        $manager = $this->getImageManager();
        $newImage = $manager->read($image);

        // Масштабируем и обрезаем по центру, чтобы картинка заполнила все $width и $height
        $newImage->cover($width, $height);

        $frame = $manager->create($width, $height);
        $frame->fill($color);
        $frame->place($newImage, 'center');

        // if ($newImage->width() <= $newImage->height() && $newImage->height() >= $height) {
        //     $newImage->scale(height: $height); 
        // } elseif ($newImage->width() >= $width) {
        //     $newImage->scale(width: $width);
        // }

        // if ($newImage->width() > $width || $newImage->height() > $height) {
        //     $newImage->crop($width, $height);
        // }

        if ($watermark != null) {
            $watermarkImage = $manager->read($watermark);
            // v3: $frame->place($image, $position, $x, $y)
            $frame->place($watermarkImage, 'bottom-left', 65, 65);
        }

        $frame->save($this->getDestinationPath($path), [
            'quality' => $quality,
            // 'permissions' => 0755
        ]);
    }

    public function resizeOptimalImage($image, $width = null, $height = null, string $path, int $quality, $watermark = null, string $color = '#ffffff'): void
    {
        $manager = $this->getImageManager();
        $newImage = $manager->read($image);

        if ($width !== null && $height === null) {
            $newImage->scale(width: $width);
        }
        elseif ($height !== null && $width === null) {
            $newImage->scale(height: $height);
        }
        elseif ($width !== null && $height !== null) {
            $newImage->cover($width, $height);
        }

        $newImage->rotate(0);

        $frame = $manager->create($newImage->width(), $newImage->height());
        $frame->fill($color);

        $frame->place($newImage, 'center');

        if ($watermark != null) {
            $watermarkImage = $manager->read($watermark);
            $frame->place($watermarkImage, 'bottom-left', 65, 65);
        }

        $frame->save($this->getDestinationPath($path), [
            'quality' => $quality,
            // 'permissions' => 0755
        ]);
    }

    public function cropImage($image, $width = null, $height = null, string $path, int $quality): void
    {
        $newImage = $this->getImageManager->read($image);

        if ($newImage->width() > $width || $newImage->height() > $height) {
            $newImage->crop($width, $height);
        }

        $newImage->save(public_path($path), [
            'quality' => $quality
        ]);
    }
}