<?php

namespace Database\Seeders;

use App\Models\PostTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostTag::create([
            'post_id' => 1,
            'tag_id' => 1,
        ]);
        PostTag::create([
            'post_id' => 1,
            'tag_id' => 2,
        ]);
        PostTag::create([
            'post_id' => 1,
            'tag_id' => 3,
        ]);
        PostTag::create([
            'post_id' => 2,
            'tag_id' => 1,
        ]);
        PostTag::create([
            'post_id' => 2,
            'tag_id' => 2,
        ]);
        PostTag::create([
            'post_id' => 2,
            'tag_id' => 3,
        ]);
        PostTag::create([
            'post_id' => 3,
            'tag_id' => 1,
        ]);
        PostTag::create([
            'post_id' => 3,
            'tag_id' => 2,
        ]);
        PostTag::create([
            'post_id' => 3,
            'tag_id' => 3,
        ]);
        PostTag::create([
            'post_id' => 4,
            'tag_id' => 1,
        ]);
        PostTag::create([
            'post_id' => 4,
            'tag_id' => 2,
        ]);
        PostTag::create([
            'post_id' => 4,
            'tag_id' => 3,
        ]);
        PostTag::create([
            'post_id' => 5,
            'tag_id' => 1,
        ]);
        PostTag::create([
            'post_id' => 5,
            'tag_id' => 2,
        ]);
        PostTag::create([
            'post_id' => 5,
            'tag_id' => 3,
        ]);
    }
}
