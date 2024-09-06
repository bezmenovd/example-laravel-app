<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $category_id
 * @property ?int $page
 * @property ?int $per_page
 * @property ?int $search
 */
class ProductsRequest extends FormRequest
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
            'search' => 'string|nullable',
        ];
    }
}
