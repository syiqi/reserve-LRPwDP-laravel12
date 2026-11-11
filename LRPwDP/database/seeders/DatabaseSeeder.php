<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Perishable::factory(5)->create([
            'sellerID' => 0,
            'name' => 'perishable',
            'quantity' => 2,
            'priceOriginal' => 10.00,
            'priceCurrent' => 7.00,
            'priceLowerBound' => 2.00,
            'description' => 'test perishable',
            'type' => 'a perishable type',
            'halal' => TRUE,
            'expiryDate' => '2025-08-23 14:30:00',
            'status' => TRUE,
            'measurement' => '1mg',
        ]);
    }
}
