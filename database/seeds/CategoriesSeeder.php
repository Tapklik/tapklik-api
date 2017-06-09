<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{

    public function run()
    {
        $categories = collect(
            json_decode(
                file_get_contents(
                    public_path('data/json/categories.json')
                )
            )
        );

        $categories->each( function ($iab) {

            Category::create([
                'code' => $iab->code,
                'name' => $iab->type
            ]);
        });
    }

}

