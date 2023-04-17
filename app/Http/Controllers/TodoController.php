<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Services\Interfaces\ImagesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TodoController extends Controller
{
    public function index(): JsonResponse
    {
        return TodoResource::collection(Auth::user()->todos)->response();
    }

    public function store(
        TodoStoreRequest $request,
        ImagesRepositoryInterface $imagesRepository
    ): JsonResponse {
        $validatedData = $request->validated();

        $todo = DB::transaction(
            function () use ($validatedData, $request, $imagesRepository): Todo {
                $todo = Todo::create([
                    'content' => htmlspecialchars($validatedData['content']),
                    'done' => false,
                    'has_image' => isset($validatedData['image']),
                    'user_id' => $request->user()->id,
                ]);

                if (! isset($validatedData['image'])) {
                    return $todo;
                }
                if (is_array($request->file('image'))) {
                    throw new RuntimeException('Only single image uploads are allowed');
                }

                if (! $imagesRepository->save(strval($todo->id), $request->file('image'))) {
                    throw new RuntimeException('Error while saving images.');
                }

                return $todo;
            }
        );

        return TodoResource::make($todo)->response();
    }

    public function update(
        Todo $todo,
        TodoUpdateRequest $request,
        ImagesRepositoryInterface $imagesRepository
    ): JsonResponse {
        $validatedData = $request->validated();

        $todo = DB::transaction(
            function () use ($request, $validatedData, $todo, $imagesRepository) {
                if ($request->has('done')) {
                    $todo->done = $validatedData['done'];
                }
                if ($request->has('content')) {
                    $todo->content = htmlspecialchars($validatedData['content']);
                }
                if ($request->has('image')) {
                    $todo->has_image = $validatedData['image'] !== null;

                    if (is_null($validatedData['image'])) {
                        $imagesRepository->delete(strval($todo->id));
                    } else {
                        if (is_array($request->file('image'))) {
                            throw new RuntimeException('Only single image uploads are allowed');
                        }
                        if (! $imagesRepository->save(strval($todo->id), $request->file('image'))) {
                            throw new RuntimeException('Error while saving images.');
                        }
                    }
                }
            }
        );

        return TodoResource::make($todo)->response();
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
    }
}
