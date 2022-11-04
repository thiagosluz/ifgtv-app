<?php

namespace App\Console\Commands;

use App\Models\Birthday;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseDateBirthdayCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:birthday';

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
    public function handle()
    {
        $birts = Birthday::all();

        foreach($birts as $birt){
            $data_format = Carbon::parse($birt->birthday)->year(now()->format('Y'))->format('Y-m-d');
            $birt->birthday = $data_format;
            $birt->update();
        }

        Log::debug('datas convertidas para o ano atual');

        return Command::SUCCESS;
    }
}
