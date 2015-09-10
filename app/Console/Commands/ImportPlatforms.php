<?php

namespace App\Console\Commands;

use App\Platform;
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

    protected $apiKey;

    protected $platformList = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->apiKey = env('GIANTBOMB_KEY');
    }

    protected function downloadPlatformList($offset = 0, $limit = 0)
    {
        $json = file_get_contents("http://www.giantbomb.com/api/platforms/?api_key=$this->apiKey&format=json&limit=$limit&offset=$offset&field_list=id,name");
        $obj = json_decode($json);
        if ($obj->error !== "OK") throw new \Exception($obj->error);
        return $obj;
    }

    protected function updatePlatforms()
    {
        $last = 0;
        $obj = $this->downloadPlatformList();
        $newarr = [];
        $sites = (int)(($obj->number_of_total_results-$last)/100);
        for ($site = 0; $site <= $sites; $site++) {
            $obj = $this->downloadPlatformList(($site * 100) + $last);
            for ($i = 0; $i < $obj->number_of_page_results; $i++) {
                $newarr[$obj->results[$i]->id] = $obj->results[$i]->name;
            }
        }
        $this->platformList = $newarr;
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
        if (!empty($this->apiKey)) {
            $this->updatePlatforms();
            $platformTxt = $this->choice('What platform do you want get?', $this->platformList);
            $platform = $this->getPlatformFromTxt($platformTxt);
            Platform::firstOrCreate(['id' => $platform, 'name' => $platformTxt]);
            $this->info('Platform ' . $platformTxt . ' added successfully!');
        }
        else {
                $this->error('No API Key provided in .env file');
        }
    }
}
