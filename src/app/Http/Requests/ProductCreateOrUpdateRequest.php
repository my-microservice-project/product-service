<?php

namespace App\Http\Requests;

use App\Data\ProductDTO;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\DataCollection;

class ProductCreateOrUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            '*.id' => 'sometimes|integer|min:1|exists:products,id',
            '*.name' => 'nullable|string|min:3|max:255',
            '*.description' => 'nullable|string|min:3',
            '*.price' => 'required|numeric|min:0',
            '*.stock' => 'required|integer|min:0',
            '*.category' => 'required|integer|min:1',
        ];
    }

    /**
     * @throws Exception
     */
    public function toDTO(): DataCollection
    {
        return ProductDTO::collection($this->validated());
    }
}
