<?php

namespace Database\Seeders;

use App\Models\DeliveryFee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $deliFees = [
            [
                "region_id" => 1,
                "city" => "Ahlon",
                "fee" => "2000",

            ],
            [
                "region_id" => 1,
                "city" => "Bahan",
                "fee" => "2000",

            ],
            [
                "region_id" => 1,
                "city" => "Botataung",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Dagon (Downtown)",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Dawbon",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "East Dagon",
                "fee" => "3000",
            ],
            [
                "region_id" => 1,
                "city" => "Hlaing",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Hlaing Tha Ya",
                "fee" => "3000",
            ],
            [
                "region_id" => 1,
                "city" => "Kamayut",
                "fee" => "2000",

            ],
            [
                "region_id" => 1,
                "city" => "Kyauktada",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Kyimyindaing",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Lanmadaw",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Latha",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Mayangon",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Mingalar Taungnyunt",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Mingalardon",
                "fee" => "3000",
            ],
            [
                "region_id" => 1,
                "city" => "North Okkalapa",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Pabedan",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Pazundaung",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Sanchaung",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Shwepyitha",
                "fee" => "3000",
            ],
            [
                "region_id" => 1,
                "city" => "South Okkalapa",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Tamwe",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Thaketa",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Thingangyun",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Yankin",
                "fee" => "2000",
            ],
            [
                "region_id" => 1,
                "city" => "Insein",
                "fee" => "2000",
            ]
        ];

        foreach ($deliFees as $data) {
            DeliveryFee::create($data);
        }
    }
}
