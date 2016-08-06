<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class GameController extends Controller
{
    /**
     * Display listing all games
     *
     * @return Response
     */
    public function index()
    {
        $games = Game::orderBy('name')
            ->leftjoin('game_user', function ($join) {
                $join->on('games.id', '=', 'game_user.game_id')->where('game_user.user_id', '=', Auth::user()->id);
            })
            ->paginate(16)
        ;

        return view('games', ['games' => $games]);
    }
}
