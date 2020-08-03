<?php

use App\Item;
use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            '99SSP04230',
            'APSSP02311',
            'APSSP04241',
            'APTMS04205',
            'BDSSP04241',
            'BTSSP04241',
            'FFSSP04238',
            'SCSSP04241',
            'SJSSP04238',
            'SLSSP02220',
            'SLSSP02313',
            'SLSSP02410',
            'SLSSP04241',
            'SLTMS04204',
            'TRSSP04230',
            'TYRVE12345',
            'VPFTP15050',
            'VPFTP15091',
            'VPFTP15662',
            'VPFTP15671',
            'VPFTP15691',
            'VPFTP15771',
            'VPFTP15791',
            'VPFTP15891',
            "VPSPE03081",
        ];

        foreach ($items as $item) {
            Item::create([
                'name' => $item
            ]);
        }
    }
}
