<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'code' => $this->code,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'brand' => $this->brand,
            'serial_number' => $this->serial_number,
            'location' => $this->location,
            'stock' => $this->stock,
            'unit' => $this->unit,
            'description' => $this->description,
            'specifications' => $this->specifications,
            'status' => $this->status?->value ?? $this->status,
            'status_label' => $this->status?->label() ?? $this->status,
            'entry_date' => $this->entry_date?->format('Y-m-d'),
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'qr_url' => route('products.show.public', ['code' => $this->code]),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
