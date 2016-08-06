<?php

namespace App\Http\Controllers;

use App\Http\RestResponse;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RestController extends Controller
{
    /**
     *
     * Display API manual
     *
     * @return Response
     */
    public function index()
    {
        return view('rest');
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \App\Http\RestResponse
     */
    public function games(Request $request)
    {
        $rest = app('RestApi');
        $rest->allGames($request);

        return RestResponse::make($rest->getResponse());
    }
}
