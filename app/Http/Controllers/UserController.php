<?php

namespace App\Http\Controllers;

use App\Game;
use App\User;
use App\UserGames;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $games = $user->games()->orderBy('name')->paginate(8);
        return view('library', ['games' => $games]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function compare()
    {
        //
    }

    public function search()
    {
        //
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function gameAdd(Request $request, $id)
    {
        if (Game::find($id) === null) return 'Bad request';
        $user = Auth::user();
        if ($user->games()->where('game_id', $id)->first() === null){
            $user->games()->save(Game::find($id));
            return back()->with('added', $id);
        }

        return back();
    }

    public function gameRemove(Request $request, $id)
    {
        if (Game::find($id) === null) return 'Bad request';
        $user = Auth::user();
        $game = $user->games()->where('game_id', $id)->first();
        if ($game === null){
            return back();
        }

        $user->games()->detach($id);
        return back()->with('deleted', $id);
    }
}
