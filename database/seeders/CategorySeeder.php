<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $globals = ['Alimentation', 'Loyer', 'Électricité', 'Internet', 'Transport'];

        foreach ($globals as $name) {
            Category::create([
                'name' => $name,
                'colocation_id' => null,
            ]);
        }
    }
}
