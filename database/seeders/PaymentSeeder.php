<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
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

                "payment_logo" => "default.jpg",
                "payment_type" => "AYA Mobile Banking",
                "name" => "Nang San Mawe Phong",
                "number" => "20009678891",
                "qr" => "default.jpg",
            ],
            [
                "payment_logo" => "default.jpg",
                "payment_type" => "Kpay",
                "name" => "Nang San Mawe Phong",
                "number" => "09795269061",
                "qr" => "default.jpg",

            ]
        ];
        foreach ($data as $value) {
            Payment::create($value);
        }

    }
}
