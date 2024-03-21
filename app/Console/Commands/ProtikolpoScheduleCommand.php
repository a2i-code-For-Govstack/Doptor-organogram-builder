<?php

namespace App\Console\Commands;

use App\Services\ProtikolpoServices;
use Illuminate\Console\Command;

class ProtikolpoScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:protikolpo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Protikolpo Schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new ProtikolpoServices())->protikolpoTransferByEnd();
        echo "\e[92mProtikolpo Schedule Command Run Successfully";
        echo "\e[39m";
    }
}
