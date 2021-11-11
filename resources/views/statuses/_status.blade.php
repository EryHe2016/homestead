<li class="media mt-4 mb-4">
  <a href="{{ route('users.show', $status->user_id) }}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="mr-3 gravatar" />
  </a>
  <div class="media-body">
    <h5>
      {{ $user->name }} <small>/ {{ $status->created_at->diffForHumans() }}</small>
    </h5>
    {{ $status->content }}
  </div>
</li>
