<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Manajer',
            'username' => 'manajer',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'category_id' => 6
        ]);

        User::create([
            'name' => 'Kepala Produksi Softwinding Pagi',
            'username' => 'softwinding-1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_PAGI,
            'category_id' => 1
        ]);

        User::create([
            'name' => 'Kepala Produksi Softwinding Siang',
            'username' => 'softwinding-2',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_SIANG,
            'category_id' => 1
        ]);

        User::create([
            'name' => 'Kepala Produksi Softwinding Malam',
            'username' => 'softwinding-3',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_MALAM,
            'category_id' => 1
        ]);

        User::create([
            'name' => 'Kepala Produksi Dyeing Pagi',
            'username' => 'dyeing-1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_PAGI,
            'category_id' => 2
        ]);

        User::create([
            'name' => 'Kepala Produksi Dyeing Siang',
            'username' => 'dyeing-2',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_SIANG,
            'category_id' => 2
        ]);

        User::create([
            'name' => 'Kepala Produksi Dyeing Malam',
            'username' => 'dyeing-3',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_MALAM,
            'category_id' => 2
        ]);

        User::create([
            'name' => 'Kepala Produksi Centrifugal Pagi',
            'username' => 'centrifugal-1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_PAGI,
            'category_id' => 3
        ]);

        User::create([
            'name' => 'Kepala Produksi Centrifugal Siang',
            'username' => 'centrifugal-2',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_SIANG,
            'category_id' => 3
        ]);

        User::create([
            'name' => 'Kepala Produksi Centrifugal Malam',
            'username' => 'centrifugal-3',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_MALAM,
            'category_id' => 3
        ]);

        User::create([
            'name' => 'Kepala Produksi Rewinding Pagi',
            'username' => 'rewinding-1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_PAGI,
            'category_id' => 4
        ]);

        User::create([
            'name' => 'Kepala Produksi Rewinding Siang',
            'username' => 'rewinding-2',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_SIANG,
            'category_id' => 4
        ]);

        User::create([
            'name' => 'Kepala Produksi Rewinding Malam',
            'username' => 'rewinding-3',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_MALAM,
            'category_id' => 4
        ]);

        User::create([
            'name' => 'Kepala Produksi Packing Pagi',
            'username' => 'packing-1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_PAGI,
            'category_id' => 5
        ]);

        User::create([
            'name' => 'Kepala Produksi Packing Siang',
            'username' => 'packing-2',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_SIANG,
            'category_id' => 5
        ]);

        User::create([
            'name' => 'Kepala Produksi Packing Malam',
            'username' => 'packing-3',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shift' => User::SHIFT_MALAM,
            'category_id' => 5
        ]);
    }
}
