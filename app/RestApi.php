<?php

namespace App;


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

    public function games(Request $request)
    {
        try {
            $this->setLimit($request->get('limit'));
            $this->setOffset($request->get('offset'));
            $this->number_of_total_results = DB::table('games')->count();
            $this->result = DB::table('games')->skip($this->offset)->take($this->limit)->get();
            // TODO: Optimise the method below! 202 queries per 100 games!!!
            foreach ($this->result as $single)
            {
                $platforms = Game::find($single->id)->platforms()->get();
                foreach ($platforms as $platform)
                {
                    $single->platforms[] = $platform->id;
                }
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