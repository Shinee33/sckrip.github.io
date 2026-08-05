<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'code' => 'PRD-' . strtoupper(Str::random(8)),
            'name' => fake()->words(3, true),
            'slug' => fake()->unique()->slug(),
            'category_id' => null,
            'brand' => fake()->company(),
            'serial_number' => 'SN-' . strtoupper(Str::random(10)),
            'location' => fake()->address(),
            'stock' => fake()->numberBetween(0, 100),
            'unit' => 'unit',
            'description' => fake()->sentence(),
            'specifications' => fake()->paragraph(),
            'status' => ProductStatus::ACTIVE,
            'entry_date' => now(),
            'image' => null,
            'qr_code_path' => null,
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}
