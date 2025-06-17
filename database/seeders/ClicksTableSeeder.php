<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Click;

class ClicksTableSeeder extends Seeder
{
    public function run()
    {
        Click::factory(50)->create([
            'affiliate_link_id' => 1
        ]);
    }
}