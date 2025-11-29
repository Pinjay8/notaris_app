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

        $this->call([
            NotarisSeeder::class,
            UserSeeder::class,
            ClientSeeder::class,
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
                'user_id' => 2,
                'plan_id' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'payment_date' => now(),
                'status' => 'active',
            ],
        ]);
    }
}
