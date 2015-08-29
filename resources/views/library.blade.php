Hi {{ Auth::user()->name }}
<br>
Your library:<br>
<div class="container">
    @foreach ($games as $game)
        {{ $game->name }}
        <a href="{{ url('/user/library/remove/' . $game->id) }}">Remove from library</a>
        <br>
    @endforeach
</div>
<br>
<a href="{{ url('/') }}">Home</a> <a href="{{ url('/games') }}">All games</a> <a href="{{ url('/user/logout') }}">Log out</a>