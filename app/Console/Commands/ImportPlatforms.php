<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportPlatforms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:platforms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check list of supported platforms.';

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
        //
    }
}
