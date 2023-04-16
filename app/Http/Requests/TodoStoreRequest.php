<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TodoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'min:1', 'string'],
            'image' => ['mimes:png,jpg,jpeg', 'max:6000'],
        ];
    }
}
