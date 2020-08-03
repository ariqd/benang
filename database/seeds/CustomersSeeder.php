<?php

use App\Sales;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            'Wahyuda',
            'Victor',
            'Widy',
            'Sonya',
            'Sri Ayu',
            'Agus',
            'CV Jaya',
            'CV Sinar Abadi',
            'CV Permata',
            'Bagyo',
            'Borneo',
            'Ali',
            'Hendra',
            'Dhani',
            'Chandra',
        ];

        foreach ($customers as $customer) {
            Sales::create([
                'name' => $customer
            ]);
        }
    }
}
