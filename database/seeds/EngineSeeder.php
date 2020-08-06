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
        //--SOFTWINDING--//
        Engine::create([
            'name' => 'S1',
            'capacity' => 100,
            'category_id' => 1
        ]);

        Engine::create([
            'name' => 'S2',
            'capacity' => 100,
            'category_id' => 1
        ]);

        Engine::create([
            'name' => 'S3',
            'capacity' => 100,
            'category_id' => 1
        ]);

        Engine::create([
            'name' => 'S4',
            'capacity' => 100,
            'category_id' => 1
        ]);

        Engine::create([
            'name' => 'S5',
            'capacity' => 100,
            'category_id' => 1
        ]);

        //--CENTRIFUGAL--//
        Engine::create([
            'name' => 'S1',
            'capacity' => 50,
            'category_id' => 3
        ]);

        Engine::create([
            'name' => 'S2',
            'capacity' => 100,
            'category_id' => 3
        ]);

        Engine::create([
            'name' => 'S2',
            'capacity' => 100,
            'category_id' => 3
        ]);

        //--DYEING--//
        Engine::create([
            'name' => 'A1',
            'capacity' => 1,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A2',
            'capacity' => 2.5,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A3',
            'capacity' => 5,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A4',
            'capacity' => 10,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A5',
            'capacity' => 20,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A6',
            'capacity' => 50,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A7',
            'capacity' => 50,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A8',
            'capacity' => 100,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A9',
            'capacity' => 100,
            'category_id' => 2
        ]);

        Engine::create([
            'name' => 'A10',
            'capacity' => 100,
            'category_id' => 2
        ]);

        //--REWIND--//
        Engine::create([
            'name' => 'S1',
            'capacity' => 100,
            'category_id' => 4
        ]);

        Engine::create([
            'name' => 'S2',
            'capacity' => 100,
            'category_id' => 4
        ]);

        Engine::create([
            'name' => 'S3',
            'capacity' => 100,
            'category_id' => 4
        ]);

        Engine::create([
            'name' => 'S4',
            'capacity' => 100,
            'category_id' => 4
        ]);

        Engine::create([
            'name' => 'S5',
            'capacity' => 100,
            'category_id' => 4
        ]);

        //--PACKING--//
        Engine::create([
            'name' => 'S1',
            'capacity' => 100,
            'category_id' => 5
        ]);

        Engine::create([
            'name' => 'S2',
            'capacity' => 100,
            'category_id' => 5
        ]);

        Engine::create([
            'name' => 'S3',
            'capacity' => 100,
            'category_id' => 5
        ]);

        Engine::create([
            'name' => 'S4',
            'capacity' => 100,
            'category_id' => 5
        ]);

        Engine::create([
            'name' => 'S5',
            'capacity' => 100,
            'category_id' => 5
        ]);
    }
}
