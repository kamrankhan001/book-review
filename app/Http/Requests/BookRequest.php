<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s.,!?()\'"-]+$/',
            'author' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s.,!?()\'"-]+$/',
            'cover_image' => request()->routeIs('books.store') ? 'required|image|mimes:jpeg,png,jpg,gif|max:2048' : 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|regex:/^[a-zA-Z0-9\s.,!?()\'"\-@#&:;\/\[\]]*$/',
        ];
    }
}
