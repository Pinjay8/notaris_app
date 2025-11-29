<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'client_code'     => 'N-251112-1-1-1',
            'notaris_id'      => 1,
            'uuid'            => '',
            'fullname'        => 'Jane Smith',
            'nik'             => '1234567890123456',
            'birth_place'     => 'Jakarta',
            'gender'          => 'Perempuan',
            'marital_status'  => 'Menikah',
            'job'             => 'Pengacara',
            'address'         => 'Jl. Mawar No. 1',
            'city'            => 'Jakarta Selatan',
            'province'        => 'DKI Jakarta',
            'postcode'        => '12345',
            'phone'           => '081234567890',
            'email'           => 'jane@example.com',
            'npwp'            => '12.345.678.9-012.345',
            'type'            => 'company',
            'company_name'    => 'PT AA',
            'status'          => 'pending',
            'note'            => 'Klien tetap',
            'created_at'      => now(),
        ]);

        Client::create([
            'client_code'     => 'N-251112-1-1-2',
            'notaris_id'      => 1,
            'uuid'            => '',
            'fullname'        => 'PT Maju Jaya',
            'nik'             => '9876543210987654',
            'birth_place'     => 'Bandung',
            'gender'          => 'Perempuan',
            'marital_status'  => 'Menikah',
            'job'             => 'Pengacara',
            'address'         => 'Jl. Melati No. 2',
            'city'            => 'Bandung',
            'province'        => 'Jawa Barat',
            'postcode'        => '40234',
            'phone'           => '085678901234',
            'email'           => 'admin@majujaya.co.id',
            'npwp'            => '98.765.432.1-987.654',
            'type'            => 'personal',
            'company_name'    => 'PT Maju Jaya',
            'status'          => 'pending',
            'note'            => 'Klien korporat',
            'created_at'      => now(),
        ]);
    }
}
