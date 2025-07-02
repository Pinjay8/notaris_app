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
            'first_name' => 'John',
            'last_name' => 'Doe',
            'display_name' => 'John Doe',
            'office_name' => 'Doe Notary Office',
            'office_address' => '123 Notary Lane, Cityville',
            'image' => 'https://example.com/images/john_doe.jpg',
            'background' => 'https://example.com/images/background.jpg',
            'address' => '456 Main St, Cityville',
            'phone' => '123-456-7890',
            'email' => 'john@gmail.com',
            'gender' => 'Laki-Laki'
        ]);

        DB::table('users')->insert([
            'notaris_id' => 1, // Assuming a Notaris with ID 1 exists
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('secret'),
            'signup_at' => now(),
            'active_at' => now(),
            'status' => 'active',
        ]);
    }
}
