<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OffersTableSeeder extends Seeder
{
    public function run()
    {
        Offer::factory(10)->create([
            'user_id' => 1,
            'title' => 'Примерный заголовок',
            'target_url' => 'https://example.com', 
            'payout' => 0.5
        ]);
    }
}