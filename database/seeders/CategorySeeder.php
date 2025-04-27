<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Technology',
            'slug' => Str::slug('technology'),
            'description' => 'All about technology',
        ]);

        Category::create([
            'name' => 'Frontend',
            'slug' => Str::slug('Frontend'),
            'description' => 'All about frontend',
        ]);

        Category::create([
            'name' => 'Backend',
            'slug' => Str::slug('Backend'),
            'description' => 'All about backend',
        ]);

        Category::create([
            'name' => 'DevOps',
            'slug' => Str::slug('DevOps'),
            'description' => 'All about DevOps',
        ]);

        Category::create([
            'name' => 'AI',
            'slug' => Str::slug('AI'),
            'description' => 'All about AI',
        ]);

        Category::create([
            'name' => 'Machine Learning',
            'slug' => Str::slug('Machine Learning'),
            'description' => 'All about Machine Learning',
        ]);

        Category::create([
            'name' => 'Data Science',
            'slug' => Str::slug('Data Science'),
            'description' => 'All about Data Science',
        ]);

        Category::create([
            'name' => 'Cloud Computing',
            'slug' => Str::slug('Cloud Computing'),
            'description' => 'All about Cloud Computing',
        ]);

        Category::create([
            'name' => 'Cyber Security',
            'slug' => Str::slug('Cyber Security'),
            'description' => 'All about Cyber Security',
        ]);

        Category::create([
            'name' => 'Blockchain',
            'slug' => Str::slug('Blockchain'),
            'description' => 'All about Blockchain',
        ]);

        Category::create([
            'name' => 'Web Development',
            'slug' => Str::slug('Web Development'),
            'description' => 'All about Web Development',
        ]);

        Category::create([
            'name' => 'Mobile Development',
            'slug' => Str::slug('Mobile Development'),
            'description' => 'All about Mobile Development',
        ]);

        Category::create([
            'name' => 'Game Development',
            'slug' => Str::slug('Game Development'),
            'description' => 'All about Game Development',
        ]);

        Category::create([
            'name' => 'Software Development',
            'slug' => Str::slug('Software Development'),
            'description' => 'All about Software Development',
        ]);

        Category::create([
            'name' => 'Database Management',
            'slug' => Str::slug('Database Management'),
            'description' => 'All about Database Management',
        ]);

        Category::create([
            'name' => 'Networking',
            'slug' => Str::slug('Networking'),
            'description' => 'All about Networking',
        ]);
    }
}
