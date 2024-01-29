<?php

namespace Database\Seeders;

use App\Models\CreditPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'point' => '10',
                'price' => '5000',
            ],
            [
                'point' => '22',
                'price' => '10000',
            ],
        ];

        foreach ($data as $value) {
            CreditPoint::create($value);
        }
    }
}
