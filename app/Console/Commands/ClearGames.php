<?php

namespace App\Console\Commands;

use App\Game;
use Illuminate\Console\Command;

class ClearGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear games table.';

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
        if ($this->confirm('Do you wish to clear games table? [y|N]')) {
            Game::truncate();
            $this->info('Cleared successfully!');
        }
    }
}
