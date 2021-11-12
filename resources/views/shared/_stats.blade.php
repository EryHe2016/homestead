<a href="#" id="followings" class="stat">
  <strong>
    {{ count($user->followings) }}
  </strong>
  关注
</a>

<a href="#" id="followers" class="stat">
  <strong>
    {{ $user->followers()->count() }}
  </strong>
  粉丝
</a>

<a href="#" id="statuses" class="stat">
  <strong>
    {{ $user->statuses()->count() }}
  </strong>
  微博
</a>
