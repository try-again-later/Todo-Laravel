<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreRequest;
use App\Models\Todo;
use DB;
use RuntimeException;
use Storage;

class TodoController extends Controller
{
    public function store(TodoStoreRequest $request)
    {
        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData, $request) {
            $todo = Todo::create([
                'content' => $validatedData['content'],
                'done' => false,
                'has_image' => isset($validatedData['image']),
                'user_id' => $request->user()->id,
            ]);

            if (! isset($validatedData['image'])) {
                return;
            }
            if (is_array($request->file('image'))) {
                throw new RuntimeException('Only single image uploads are allowed');
            }

            $fileName = $request->file('image')->getRealPath();
            $imageMimeType = $request->file('image')->getMimeType();

            if (! in_array($imageMimeType, ['image/jpeg', 'image/png'], strict: true)) {
                throw new RuntimeException('Invalid image format.');
            }
            $image = match ($request->file('image')->getMimeType()) {
                'image/jpeg' => imagecreatefromjpeg($fileName),
                'image/png' => imagecreatefrompng($fileName),
            };

            ob_start();
            imagejpeg($image);
            $imageData = ob_get_contents();
            ob_end_clean();

            $thumbnail = imagecreatetruecolor(150, 150);
            imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, 150, 150, imagesx($image), imagesy($image));

            ob_start();
            imagejpeg($thumbnail);
            $thumbnailData = ob_get_contents();
            ob_end_clean();

            $imageSaveResult = Storage::disk('images')->put(strval($todo->id), $imageData);
            $thumbnailSaveResult = Storage::disk('thumbnails')->put(strval($todo->id), $thumbnailData);

            if (! $imageSaveResult || ! $thumbnailSaveResult) {
                Storage::disk('images')->delete(strval($todo->id));
                Storage::disk('thumbnails')->delete(strval($todo->id));
                throw new RuntimeException('Error while saving images.');
            }
        });

        return redirect()->route('todos');
    }
}
