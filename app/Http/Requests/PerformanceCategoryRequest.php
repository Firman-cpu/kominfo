<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerformanceCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categories' => ['required', 'array', 'min:1'],
            'categories.*.id' => ['required', 'exists:performance_categories,id'],
            'categories.*.name' => ['required', 'string', 'max:100'],
            'categories.*.min_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'categories.*.description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
