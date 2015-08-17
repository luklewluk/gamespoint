Hi {{ Auth::user()->name }}
<br>
Your library:<br>
<br>
<a href="{{ url('/user/logout') }}">Log out</a>