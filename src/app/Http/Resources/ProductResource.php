<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->when($this->resource->name, $this->resource->name),
            'description' => $this->when($this->resource->description, $this->resource->description),
            'category' => $this->resource->category ?? null,
            'price' => $this->resource->price,
            'stock' => $this->resource->stock,
        ];
    }
}
