<?php

namespace App\Http\Controllers;

use App\Game;
use App\RestApi;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $rest = new RestApi();
        $rest->games($request);
        // Debug:
        // var_dump($rest->getResponse());
        // return view('rest', $rest->getResponse());
        return response()->json($rest->getResponse());
    }

}
