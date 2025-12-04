<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

trait ImageProcessor
{
    /**
     * Создает и возвращает экземпляр ImageManager.
     * @return ImageManager
     */
    private function getImageManager(): ImageManager
    {
        // Создаем новый менеджер изображений для v3
        return new ImageManager(new GdDriver);
    }

    public function resizeImage($image, int $width, int $height, string $path, int $quality, $watermark = null, string $color = '#ffffff'): void
    {
        $manager = $this->getImageManager();
        $newImage = $manager->read($image);

        // Создание пустого холста/рамки (v2: Image::canvas())
        $frame = $manager->create($width, $height);
        $frame->fill($color);
        
        if ($newImage->width() <= $newImage->height() && $newImage->height() >= $height) {
            $newImage->scale(height: $height); 
        } elseif ($newImage->width() >= $width) {
            $newImage->scale(width: $width);
        }

        if ($newImage->width() > $width || $newImage->height() > $height) {
            $newImage->crop($width, $height);
        }

        $frame->place($newImage, 'center');

        if ($watermark != null) {
            $watermarkImage = $manager->read($watermark);
            // v3: $frame->place($image, $position, $x, $y)
            $frame->place($watermarkImage, 'bottom-left', 65, 65);
        }

        // 7. Сохранение (v3: качество передается в массиве опций)
        $frame->save(public_path() . $path, [
            'quality' => $quality,
            'permissions' => 0644
        ]);
    }

    public function resizeOptimalImage($image, int $width, int $height, string $path, int $quality, $watermark = null, string $color = '#ffffff'): void
    {
        $manager = $this->getImageManager();
        $newImage = $manager->read($image);

        $frame = $manager->create($width, $height);
        $frame->fill($color);
        
        // if ($newImage->width() > $newImage->height()) {
        //     $newImage->scale(height: $height);
        // } elseif ($newImage->width() < $newImage->height()) {
        //     $newImage->scale(width: $width);
        // }

        // $newImage->crop($width, $height);
        $newImage->cover($width, $height);
        $newImage->rotate(0);

        $frame->place($newImage, 'center');
 
        if ($watermark != null) {
            $watermarkImage = $manager->read($watermark);
            $frame->place($watermarkImage, 'bottom-left', 65, 65);
        }

        // dd(public_path().$path);

        $frame->save(public_path($path), [
            'quality' => $quality,
            'permissions' => 0644
        ]);
        
        // Примечание: В v3 этот эффект (масштабирование для заполнения с последующей обрезкой)
        // можно достичь одной командой $newImage->cover($width, $height);
    }

    public function cropImage($image, int $width, int $height, string $path, int $quality): void
    {
        $newImage = $this->getImageManager->read($image);

        if ($newImage->width() > $width || $newImage->height() > $height) {
            $newImage->crop($width, $height);
        }

        $newImage->save(public_path() . $path, [
            'quality' => $quality
        ]);
    }
}