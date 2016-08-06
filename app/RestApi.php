<?php

namespace App;

use Exception;
use Illuminate\Http\Request;

class RestApi
{
    /** @var Game $game */
    protected $game;

    protected $status_code;
    protected $error;
    protected $number_of_total_results;
    protected $number_of_page_results;
    protected $limit;
    protected $offset;
    protected $result;

    /**
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Set status code by result data
     */
    protected function handleStatusCode()
    {
        if (!empty($this->result)){
            $this->status_code = 200;
        }
        else {
            $this->status_code = 404;
        }
        if ($this->error !== "OK") $this->status_code = 500;
    }

    /**
     * Get all games from the library
     * @param Request $request
     */
    public function allGames(Request $request)
    {
        try {
            $this->setLimit($request->get('limit'));
            $this->setOffset($request->get('offset'));
            $this->number_of_total_results = $this->game->all()->count();
            $games = $this->game->with('platforms')->skip($this->offset)->take($this->limit)->get();

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
            $this->error = 'OK';
        } catch (Exception $e) {
            $this->error = $e;
        }
        $this->handleStatusCode();
    }

    /**
     * Get array of JSON response
     * @return array
     */
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
     * Determine how many titles are to process
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
     * Set how many titles are to skip
     * @param mixed $offset
     */
    public function setOffset($offset)
    {
        $this->offset = !empty($offset) ? $offset : 0;
    }

}
