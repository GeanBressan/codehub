<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create([
            'name' => 'Laravel',
            'slug' => Str::slug('laravel'),
        ]);

        Tag::create([
            'name' => 'PHP',
            'slug' => Str::slug('php'),
        ]);

        Tag::create([
            'name' => 'JavaScript',
            'slug' => Str::slug('javascript'),
        ]);

        Tag::create([
            'name' => 'Python',
            'slug' => Str::slug('python'),
        ]);

        Tag::create([
            'name' => 'Java',
            'slug' => Str::slug('java'),
        ]);

        Tag::create([
            'name' => 'C#',
            'slug' => Str::slug('c-sharp'),
        ]);

        Tag::create([
            'name' => 'Ruby',
            'slug' => Str::slug('ruby'),
        ]);

        Tag::create([
            'name' => 'Go',
            'slug' => Str::slug('go'),
        ]);

        Tag::create([
            'name' => 'Swift',
            'slug' => Str::slug('swift'),
        ]);

        Tag::create([
            'name' => 'Kotlin',
            'slug' => Str::slug('kotlin'),
        ]);

        Tag::create([
            'name' => 'Dart',
            'slug' => Str::slug('dart'),
        ]);

        Tag::create([
            'name' => 'TypeScript',
            'slug' => Str::slug('typescript'),
        ]);
    }
}
