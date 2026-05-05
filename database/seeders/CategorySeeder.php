<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Web Development', 'Graphic Design', 'Writing & Translation', 'Digital Marketing', 'Video & Animation'];
        foreach($categories as $cat) {
            Category::create(['name' => $cat, 'slug' => strtolower(str_replace([' ', '&'], ['-', 'and'], $cat))]);
        }
    }
}
