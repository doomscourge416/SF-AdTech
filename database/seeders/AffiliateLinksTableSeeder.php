<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AffiliateLink;

class AffiliateLinksTableSeeder extends Seeder
{
    public function run()
    {
        AffiliateLink::factory(20)->create();
    }
}