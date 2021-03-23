<a href="{{ route('users.show', $user->id) }}">
  <img src="{{ URL::asset('images/users/ery.png') }}" alt="{{ $user->name }}" class="gravatar" />
</a>
<h1>{{ $user->name }}</h1>
