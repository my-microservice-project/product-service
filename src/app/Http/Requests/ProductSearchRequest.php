<?php

namespace App\Http\Requests;

use App\Data\ProductSearchDTO;
use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keyword'    => 'required|string|min:2',
            'category' => 'nullable|integer',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
        ];
    }

    public function toDTO(): ProductSearchDTO
    {
        return ProductSearchDTO::from($this->validated());
    }
}
