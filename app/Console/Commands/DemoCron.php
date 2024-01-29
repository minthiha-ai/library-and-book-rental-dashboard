<?php

namespace App\Console\Commands;

use App\Models\Rent;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        info("Cron Job running at ". now());
//        $rents=Rent::where('state','1')->get();
//        foreach ($rents as $rent) {
//            $now = Carbon::now();
//            if (true){
//                $rent->overdue_day+=1;
//            }
//            $rent->update();
//        }
//        \Log::info("Cron is working fine!");
        return 0;
    }
}
