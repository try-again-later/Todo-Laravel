<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Models\Todo;
use Auth;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        return TagResource::collection(Tag::where('user_id', Auth::user()->id)->get())->response();
    }

    public function store(Todo $todo, TagRequest $request)
    {
        $validatedData = $request->validated();

        $tag = Tag::where('name', $validatedData['name'])->first();

        if ($tag === null) {
            $tag = Tag::create([
                'name' => $validatedData['name'],
                'user_id' => Auth::user()->id,
            ]);
        }

        if (! $todo->tags()->find($tag->id)) {
            $todo->tags()->attach($tag->id);
        }
    }

    public function deleteFromTodo(Todo $todo, TagRequest $request)
    {
        $validatedData = $request->validated();

        $tag = Tag::where([
            'name' => $validatedData['name'],
            'user_id' => Auth::user()->id,
        ])->first();
        if ($tag === null) {
            return response(status: 404);
        }

        $todo->tags()->detach($tag->id);

        return response(status: 200);
    }
    public function deleteEntirely(TagRequest $request)
    {
        $validatedData = $request->validated();
        Tag::where([
            'name' => $validatedData['name'],
            'user_id' => Auth::user()->id,
        ])->delete();
    }
}
