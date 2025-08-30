<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Contact, Category};

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->all(); // 先にCategoryがある前提
        Contact::factory(35)->make()->each(function ($c) use ($categoryIds) {
            $c->category_id = collect($categoryIds)->random();
            $c->save();
        });
    }
}
