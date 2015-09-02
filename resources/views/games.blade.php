
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
    <div class="row">
        @foreach ($games as $game)
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" style="height: 500px">
                    <img style="max-height: 300px" src="{{ $game->small_image !== null ? $game->small_image : asset('img/nocover.png') }}">
                    <div style="position: absolute; bottom: 20px" class="caption">
                        <h3>{{ $game->name }}</h3>
                        <p>...</p>
                        <p>
                            @if (!$game->own)
                                <a href="{{ url('/user/library/add/' . $game->id) }}" class="btn btn-success" role="button">Add to library</a>
                            @else
                                <a href="{{ url('/user/library/remove/' . $game->id) }}" class="btn btn-danger" role="button">Remove from library</a>
                            @endif
                            <a href="#" class="btn btn-default" role="button">Details</a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{!! $games->render() !!}
<a href="{{ url('/') }}">Home</a> <a href="{{ url('/user') }}">Library</a> <a href="{{ url('/user/logout') }}">Log out</a>
