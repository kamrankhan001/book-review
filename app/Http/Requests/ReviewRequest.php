<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Review;


class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $review = $this->route('review');

        // If it's an update request
        if ($review) {
            return $this->user()->can('update', $review);
        }

        // If it's a create request
        return $this->user()->can('create', Review::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'review' => 'required|string|max:2000|regex:/^[a-zA-Z0-9\s.,!?()\'"-]+$/',
            'rating' => 'required|numeric|between:1,5|regex:/^\d(\.\d)?$/',
        ];
    }
}
