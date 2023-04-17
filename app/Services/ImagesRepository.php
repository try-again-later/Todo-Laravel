<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\ImagesRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImagesRepository implements ImagesRepositoryInterface
{
    public function save(string $id, UploadedFile $file): bool
    {
        $fileName = $file->getRealPath();
        $imageMimeType = $file->getMimeType();

        if (! in_array($imageMimeType, ['image/jpeg', 'image/png'], strict: true)) {
            return false;
        }
        $image = match ($imageMimeType) {
            'image/jpeg' => imagecreatefromjpeg($fileName),
            'image/png' => imagecreatefrompng($fileName),
        };

        ob_start();
        imagejpeg($image);
        $imageData = ob_get_contents();
        ob_end_clean();

        $thumbnail = imagecreatetruecolor(150, 150);
        $resizingResult = imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, 150, 150, imagesx($image), imagesy($image));
        if (! $resizingResult) {
            return false;
        }

        ob_start();
        imagejpeg($thumbnail);
        $thumbnailData = ob_get_contents();
        ob_end_clean();

        Storage::disk('images')->put($id, $imageData);
        Storage::disk('thumbnails')->put($id, $thumbnailData);

        return true;
    }

    public function delete(string $id)
    {
        Storage::disk('images')->delete($id);
        Storage::disk('thumbnails')->delete($id);
    }
}
