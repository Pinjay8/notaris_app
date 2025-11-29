<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notaris;

class NotarisSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'user_id' => null,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'display_name' => 'John Doe',
                'office_name' => 'Doe Notary Office',
                'office_address' => '123 Notary Lane, Cityville',
                'image' => '',
                'background' => 'S1 Hukum',
                'address' => '456 Main St, Cityville',
                'phone' => '081234567890',
                'email' => 'john@gmail.com',
                'gender' => 'Laki-Laki'
            ],
            [
                'user_id' => null,
                'first_name' => 'Maria',
                'last_name' => 'Santoso',
                'display_name' => 'Maria Santoso',
                'office_name' => 'Santoso & Partners',
                'office_address' => 'Jl. Merdeka No. 10, Bandung',
                'image' => '',
                'background' => 'S2 Kenotariatan',
                'address' => 'Jl. Mawar No. 7, Bandung',
                'phone' => '082134567890',
                'email' => 'maria@gmail.com',
                'gender' => 'Perempuan'
            ],
            [
                'user_id' => null,
                'first_name' => 'Ahmad',
                'last_name' => 'Hakim',
                'display_name' => 'Ahmad Hakim',
                'office_name' => 'Hakim Notary & Law',
                'office_address' => 'Jl. Diponegoro No. 8, Surabaya',
                'image' => '',
                'background' => 'S1 Hukum Bisnis',
                'address' => 'Jl. Melati No. 2, Surabaya',
                'phone' => '083145678901',
                'email' => 'ahmad@gmail.com',
                'gender' => 'Laki-Laki'
            ],
        ];

        foreach ($data as $item) {
            Notaris::create($item);
        }
    }
}
