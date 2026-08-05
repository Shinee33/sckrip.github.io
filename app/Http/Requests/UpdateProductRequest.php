<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    protected function prepareForValidation(): void
    {
        $product = $this->route('product');
        $existingCode = is_object($product) ? $product->code : null;
        $existingStock = is_object($product) ? $product->stock : 1;
        $existingStatus = is_object($product) ? ($product->status?->value ?? $product->status) : ProductStatus::ACTIVE->value;

        $this->merge([
            'code' => $this->code ?: ($existingCode ?: 'BRS-' . strtoupper(Str::random(6))),
            'stock' => ($this->stock !== null && $this->stock !== '') ? (int) $this->stock : $existingStock,
            'status' => $this->status ?: ($existingStatus ?: ProductStatus::ACTIVE->value),
        ]);
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id ?? $this->route('product');

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', Rule::unique('products', 'code')->ignore($productId)],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:150'],
            'stock' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'specifications' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(ProductStatus::class)],
            'entry_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama beras wajib diisi.',
            'code.required' => 'Kode beras wajib diisi.',
            'code.unique' => 'Kode beras sudah digunakan oleh data lain.',
            'stock.required' => 'Jumlah stok wajib diisi.',
            'unit.required' => 'Estimasi masa simpan wajib dipilih.',
            'status.required' => 'Status barang wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
