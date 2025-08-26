<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ([
            '商品の問い合わせ',
            '商品の交換',
            '商品トラブル',
            'ショップへのお問い合わせ',
            'その他',
        ] as $label) {
            Category::create(['content' => $label]);
        }
    }
}