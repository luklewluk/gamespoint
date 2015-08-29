
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@if (session('added'))
    Game {{ session('added') }} added successfully to your library
@endif
@if (session('deleted'))
    Game {{ session('deleted') }} removed from your library
@endif

<div class="container">
    @foreach ($games as $game)
        {{ $game->name }}
        @if (!$game->own)
            <a href="{{ url('/user/library/add/' . $game->id) }}">Add to library</a>
        @else
            <a href="{{ url('/user/library/remove/' . $game->id) }}">Remove from library</a>
        @endif
        <br>
    @endforeach
</div>

{!! $games->render() !!}
<a href="{{ url('/') }}">Home</a> <a href="{{ url('/user') }}">Library</a> <a href="{{ url('/user/logout') }}">Log out</a>
