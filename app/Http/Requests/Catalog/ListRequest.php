<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $category_id
 * @property ?int $page
 * @property ?int $per_page
 * @property ?string $query
 */
class ListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'numeric|nullable',
            'page' => 'numeric|nullable',
            'per_page' => 'numeric|nullable',
            'query' => 'string|nullable'
        ];
    }
}
