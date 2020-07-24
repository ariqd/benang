<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Softwinding'
        ]);

        Category::create([
            'name' => 'Dyeing'
        ]);

        Category::create([
            'name' => 'Centrifugal'
        ]);

        Category::create([
            'name' => 'Rewinding'
        ]);

        Category::create([
            'name' => 'Packing'
        ]);

        Category::create([
            'name' => 'Manajer'
        ]);
    }
}
