<?php

use App\Category;
use App\User;
use Illuminate\Database\Seeder;

class PpicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'PPIC'
        ]);

        User::create([
            'name' => 'PPIC',
            'username' => 'ppic',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'category_id' => 7
        ]);
    }
}
