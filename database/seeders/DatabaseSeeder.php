<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            OmanStateSeeder::class,
            OmanCitySeeder::class,
            CategorySeeder::class,
            ListingSeeder::class, // يحتاج listings + listing_images موجودين (migrate قبل)
        ]);
    }
}