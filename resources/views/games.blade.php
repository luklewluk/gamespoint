
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@if (session('success'))
    Game {{ session('success') }} added successfully to your library
@endif

<div class="container">
    @foreach ($games as $game)
        {{ $game->name }} <a href="{{ url('/user/library/add/' . $game->id) }}">Add to library</a><br>
        <?php
            $test = $game->user->id;
            var_dump($test);
        ?>
    @endforeach
</div>

{!! $games->render() !!}
<a href="{{ url('/') }}">Home</a> <a href="{{ url('/user') }}">Library</a> <a href="{{ url('/user/logout') }}">Log out</a>