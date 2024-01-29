<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                "title" => "Basic Package 1",
                "package_duration" => "90",
                "book_per_rent" => "6",
                "rent_duration" => "14",
                "price" => "30000",
                "overdue_price_per_day" => 1000,
                "overdue_price_per_week" => 5000,
                "overdue_price_per_month" => 10000,
                "image" => "default.jpg",
            ],
            [
                "title" => "Basic Package 2",
                "package_duration" => "180",
                "book_per_rent" => "6",
                "rent_duration" => "14",
                "price" => "55000",
                "overdue_price_per_day" => 1000,
                "overdue_price_per_week" => 5000,
                "overdue_price_per_month" => 10000,
                "image" => "default.jpg",
            ],
            [
                "title" => "Premium 1",
                "package_duration" => "90",
                "book_per_rent" => "12",
                "rent_duration" => "14",
                "price" => "55000",
                "overdue_price_per_day" => 2000,
                "overdue_price_per_week" => 8000,
                "overdue_price_per_month" => 20000,
                "image" => "default.jpg",
            ],
            [
                "title" => "Premium 2",
                "package_duration" => "180",
                "book_per_rent" => "12",
                "rent_duration" => "14",
                "price" => "100000",
                "overdue_price_per_day" => 2000,
                "overdue_price_per_week" => 8000,
                "overdue_price_per_month" => 20000,
                "image" => "default.jpg",
            ],
        ];

        foreach ($packages as $packageData) {
            Package::create($packageData);
        }
    }
}
