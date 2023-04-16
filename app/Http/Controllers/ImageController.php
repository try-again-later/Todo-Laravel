<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function showThumbnail(Todo $todo): Response
    {
        $image = Storage::disk('thumbnails')->get(strval($todo->id));
        if ($image === null) {
            return response(status: 404);
        }

        return response($image, headers: ['Content-Type' => 'image/jpeg']);
    }

    public function showImage(Todo $todo): Response
    {
        $image = Storage::disk('images')->get(strval($todo->id));
        if ($image === null) {
            return response(status: 404);
        }

        return response($image, headers: ['Content-Type' => 'image/jpeg']);
    }
}
