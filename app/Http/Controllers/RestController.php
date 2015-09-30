<?php

namespace App\Http\Controllers;

use App\RestApi;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;

class RestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('rest');
    }

    public function games(Request $request)
    {
        $rest = app('RestApi');

        $rest->allGames($request);
        // Debug:
        //var_dump($rest->getResponse());
        //return view('rest', $rest->getResponse());
        return response()->json($rest->getResponse());
    }
}
