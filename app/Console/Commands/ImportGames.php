<?php

namespace App\Console\Commands;

use App\Game;
use App\Platform;
use Illuminate\Console\Command;

class ImportGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new games to database';

    /**
     * API key provided by Giant Bomb
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Supported platforms and their unique IDs
     * @var array
     */
    private $platformList = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->apiKey = env('GIANTBOMB_KEY');
        $platforms = Platform::all();
        foreach ($platforms as $platform)
        {
            $this->platformList[$platform->id] = $platform->name;
        }
    }

    /**
     * Save or overwrite game into database
     * @param $id
     * @param $name
     * @param $platform
     * @param $original_release_date
     */
    protected function saveGame($gameData, $platform)
    {
        $game = Game::find($gameData->id);

        if ($game === null) {
            $game = new Game();
            $game->id = $gameData->id;
            $game->name = $gameData->name;
            $game->platforms()->save(Platform::find($platform));
            $game->original_release_date = $gameData->original_release_date;
            $game->small_image = $gameData->image !== null ? $gameData->image->small_url : null;
            $game->save();
        }
        else {
            $game->platforms()->save(Platform::find($platform));
            $game->save();
        }
    }

    /**
     * Get current game list from GiantBomb
     * @param int $platform
     * @param int $offset
     * @param int $limit
     * @return object
     * @throws \Exception
     */
    protected function downloadGameList($platform, $offset = 0, $limit = 0)
    {
        $json = file_get_contents("http://www.giantbomb.com/api/games/?api_key=$this->apiKey&format=json&limit=$limit&offset=$offset&filter=platforms:$platform&field_list=id,name,original_release_date,image");
        $obj = json_decode($json);
        if ($obj->error !== "OK") throw new \Exception($obj->error);
        return $obj;
    }

    /**
     * Get number of total games for a platform
     * @param int $platform
     * @return int
     * @throws \Exception
     */
    protected function checkGamesQty($platform)
    {
        $obj = $this->downloadGameList($platform, 0, 1);
        return (int)$obj->number_of_total_results;
    }

    /**
     * Update game list in local database
     * @param int $platform
     * @param int $last
     * @throws \Exception
     */
    protected function updateGameList($platform, $last)
    {
        $obj = $this->downloadGameList($platform, $last, 1);
        $sites = (int)(($obj->number_of_total_results-$last)/100);
        $bar = $this->output->createProgressBar($sites+1);
        for ($site = 0; $site <= $sites; $site++) {
            $obj = $this->downloadGameList($platform, ($site * 100) + $last);
            for ($i = 0; $i < $obj->number_of_page_results; $i++) {
                $this->saveGame($obj->results[$i], $platform);
            }
            $bar->advance();
        }
        $bar->finish();
    }

    /**
     * Convert console name to its unique ID
     * @param string $txt
     * @return int
     */
    protected function getPlatformFromTxt($txt)
    {
        return array_search($txt, $this->platformList);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!empty($this->apiKey)){
            $platformTxt = $this->choice('What platform do you want update?', array_values($this->platformList));
            $platform = $this->getPlatformFromTxt($platformTxt);

            $lastGame = Platform::find($platform)->games()->count();
            $gamesQty = $this->checkGamesQty($platform);
            $this->info('Quantity of games for platform ' . $platform . ':');
            $this->info('Local database: ' . $lastGame);
            $this->info('GiantBomb database: ' . $gamesQty);

            if ($gamesQty > $lastGame) {
                if ($this->confirm('Do you wish to update? [y|N]')) {
                    $this->updateGameList($platform, $lastGame);
                    $this->info('Updated successfully!');
                }
            }
            else{
                $this->info('Everything is up to date!');
            }
        }
        else {
            $this->error('No API Key provided in .env file');
        }
    }
}
