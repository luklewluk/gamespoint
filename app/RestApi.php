<?php

namespace App;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestApi {

    protected $status_code;
    protected $error;
    protected $number_of_total_results;
    protected $number_of_page_results;
    protected $limit;
    protected $offset;
    protected $result;

    public function allGames(Request $request)
    {
        try {
            $this->setLimit($request->get('limit'));
            $this->setOffset($request->get('offset'));
            $this->number_of_total_results = Game::all()->count();

            $games = Game::with('platforms')->skip($this->offset)->take($this->limit)->get();

            foreach ($games as $game)
            {
                $temp = $game->toArray();
                unset($temp['platforms']);
                $platforms = $game->getRelation('platforms');
                foreach ($platforms as $platform) {
                    $temp['platforms'][] = $platform->getAttributeValue('id');
                }
                $this->result[] = $temp;
                unset($temp);
            }

            $this->number_of_page_results = sizeof($this->result);
            $this->status_code = 1;
            $this->error = 'OK';
        } catch (\Exception $e) {
            $this->status_code = 101;
            $this->error = $e;
        }
    }

    public function getResponse()
    {
        return [
            'error' => $this->error,
            'limit' => $this->limit,
            'offset' => $this->offset,
            'number_of_page_results' => $this->number_of_page_results,
            'number_of_total_results' => $this->number_of_total_results,
            'status_code' => $this->status_code,
            'result' => $this->result
        ];
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit <= 100 && !empty($limit) ? $limit : 100;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param mixed $offset
     */
    public function setOffset($offset)
    {
        $this->offset = !empty($offset) ? $offset : 0;
    }

}