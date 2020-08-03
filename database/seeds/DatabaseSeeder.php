<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EngineSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(CustomersSeeder::class);
        $this->call(ItemsSeeder::class);
        $this->call(CounterSeeder::class);
    }
}
