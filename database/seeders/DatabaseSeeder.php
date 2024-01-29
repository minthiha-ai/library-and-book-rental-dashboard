<?php

namespace Database\Seeders;

use App\Models\DeliveryFee;
use App\Models\Package;
use App\Models\Region;
use App\Models\ReturnDay;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create the admin user


        $this->call([
            // UserSeeder::class,
            // PackageSeeder::class,
            // PaymentSeeder::class,
            // RegionSeeder::class,
            // DeliFeeSeeder::class,
            // CreditPointSeeder::class
            // SettingSeeder::class

        ]);
        $data = new ReturnDay();
        $data->day = 7;
        $data->save();
    }
}
