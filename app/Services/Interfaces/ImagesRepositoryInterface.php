<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface ImagesRepositoryInterface
{
    public function save(string $id, UploadedFile $file): bool;

    public function delete(string $id);
}
