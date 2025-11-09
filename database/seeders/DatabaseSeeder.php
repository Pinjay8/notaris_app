<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notaris')->insert([
            [
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
        ]);

        // === INSERT USERS (masing-masing notaris 1 user) ===
        DB::table('users')->insert([
            [
                'notaris_id' => 1,
                'username' => 'admin_john',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('secret'),
                'phone' => '081234567890',
                'address' => '456 Main St, Cityville',
                'signup_at' => now()->addDay(30),
                'active_at' => now(),
                'status' => 'active',
            ],
            [
                'notaris_id' => 2,
                'username' => 'admin_maria',
                'email' => 'admin2@gmail.com',
                'password' => bcrypt('secret'),
                'signup_at' => now(),
                'active_at' => now(),
                'phone' => '081234567890',
                'address' => '456 Main St, Cityville',
                'status' => 'active',
            ],
            [
                'notaris_id' => 3,
                'username' => 'Admin 3',
                'email' => 'admin3@gmail.com',
                'password' => bcrypt('secret'),
                'phone' => '081234567890',
                'address' => '456 Main St, Cityville',
                'signup_at' => now()->subDay(),
                'active_at' => now()->subDay(),
                'status' => 'pending',
            ],
        ]);

        DB::table('plans')->insert([
            'id' => 1,
            'name' => 'Free Plan',
            'description' => 'Free plan for testing purposes',
            'price' => 150000,
            'duration_days' => 30,
            'active' => true,
        ]);

        DB::table('subscriptions')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'plan_id' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'payment_date' => now(),
                'status' => 'active',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'plan_id' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'payment_date' => now(),
                'status' => 'active',
            ],
        ]);



        // DB::table('products')->insert([
        //     'id' => 1,
        //     'code_products' => 'abc-1',
        //     'name' => 'abc',
        //     'description' => 'abc abc abc',
        //     'image' => 'https://example.com/images/abc.jpg',
        //     'status' => true
        // ]);

        DB::table('clients')->insert([
            [
                'notaris_id' => 1,
                'uuid' => '',
                'fullname' => 'Jane Smith',
                'nik' => '1234567890123456',
                'birth_place' => 'Jakarta',
                'gender' => 'Perempuan',
                'marital_status' => 'Menikah',
                'job' => 'Pengacara',
                'address' => 'Jl. Mawar No. 1',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'postcode' => '12345',
                'phone' => '081234567890',
                'email' => 'jane@example.com',
                'npwp' => '12.345.678.9-012.345',
                'type' => 'company',
                'company_name' => 'PT AA',
                'status' => 'pending',
                'note' => 'Klien tetap',
                'created_at' => now(),
            ],
            [
                'notaris_id' => 1,
                'uuid' => '',
                'fullname' => 'PT Maju Jaya',
                'nik' => '9876543210987654',
                'birth_place' => 'Bandung',
                'gender' => 'Perempuan',
                'marital_status' => 'Menikah',
                'job' => 'Pengacara',
                'address' => 'Jl. Melati No. 2',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'postcode' => '40234',
                'phone' => '085678901234',
                'email' => 'admin@majujaya.co.id',
                'npwp' => '98.765.432.1-987.654',
                'type' => 'personal',
                'company_name' => 'PT Maju Jaya',
                'status' => 'pending',
                'note' => 'Klien korporat',
                'created_at' => now(),
            ]
        ]);
    }
}
