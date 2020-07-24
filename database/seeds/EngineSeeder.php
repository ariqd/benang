<?php

use App\Engine;
use Illuminate\Database\Seeder;

class EngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Engine::create([
            'name' => 'S1',
            'capacity' => '50',
            'category_id' => 1
        ]);

        Engine::create([
            'name' => 'S2',
            'capacity' => '50',
            'category_id' => 1
        ]);

        Engine::create([
            'name' => 'D1',
            'capacity' => '50',
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'D2',
            'capacity' => '50',
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'C1',
            'capacity' => '50',
            'category_id' => 3
        ]);

        Engine::create([
            'name' => 'C2',
            'capacity' => '50',
            'category_id' => 3
        ]);

        Engine::create([
            'name' => 'R1',
            'capacity' => '50',
            'category_id' => 4
        ]);

        Engine::create([
            'name' => 'R2',
            'capacity' => '50',
            'category_id' => 4
        ]);

        Engine::create([
            'name' => 'P1',
            'capacity' => '50',
            'category_id' => 5
        ]);

        Engine::create([
            'name' => 'P2',
            'capacity' => '50',
            'category_id' => 5
        ]);
    }
}
