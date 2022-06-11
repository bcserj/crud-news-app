<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CronTruncate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:truncate {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate table ';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument("table");

        if (Schema::hasTable($table)) {
            info('['.now().'] Start cron job: truncate '.$table);
            DB::table($table)->truncate();
            info('['.now().'] End cron job: truncate '.$table);
        }
        return 0;
    }
}
