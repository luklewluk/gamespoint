
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

Hi {{ Auth::user()->name }}
<br>
Your library:<br>
<div class="container">
    <div class="row">

        @foreach ($games as $game)
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail" style="height: 500px">
                <img style="max-height: 300px" src="{{ $game->small_image !== null ? $game->small_image : asset('img/nocover.png') }}">
                <div style="position: absolute; bottom: 20px" class="caption">
                    <h3>{{ $game->name }}</h3>
                    <p>...</p>
                    <p><a href="#" class="btn btn-primary" role="button">Details</a> <a href="{{ url('/user/library/remove/' . $game->id) }}" class="btn btn-danger" role="button">Remove</a></p>
                </div>
            </div>
        </div>
        @endforeach

    </div>

</div>

{!! $games->render() !!}
<br>
<a href="{{ url('/') }}">Home</a> <a href="{{ url('/games') }}">All games</a> <a href="{{ url('/user/logout') }}">Log out</a>