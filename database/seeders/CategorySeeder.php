<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Beras Putih', 'description' => 'Varietas beras putih konsumsi harian dan umum'],
            ['name' => 'Beras Merah', 'description' => 'Beras merah kaya serat dan antioksidan tinggi'],
            ['name' => 'Beras Hitam', 'description' => 'Beras hitam kaya antosianin dan nutrisi'],
            ['name' => 'Beras Organik', 'description' => 'Beras hasil budidaya tanpa pestisida kimia'],
            ['name' => 'Beras Premium', 'description' => 'Beras kualitas tinggi dengan derajat sosoh min 95%'],
            ['name' => 'Beras Medium', 'description' => 'Beras kualitas standar konsumsi masyarakat'],
            ['name' => 'Beras Ketan', 'description' => 'Ketan putih/hitam untuk olahan makanan khas'],
            ['name' => 'Beras Pecah Kulit', 'description' => 'BPM (Brown Rice) dengan kulit ari utuh'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name']],
                [
                    'slug' => Str::slug($cat['name']),
                    'description' => $cat['description'],
                ]
            );
        }
    }
}
