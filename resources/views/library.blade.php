Hi {{ Auth::user()->name }}
<br>
Your library:<br>
<br>
<a href="{{ url('/') }}">Home</a> <a href="{{ url('/games') }}">All games</a> <a href="{{ url('/user/logout') }}">Log out</a>