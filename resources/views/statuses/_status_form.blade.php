<form action="{{ route('statuses.store') }}" method="post">
  @include('shared._errors')

  {{ csrf_field() }}
  <textarea name="content" class="form-control" placeholder="聊聊新鲜事..." rows="3">{{ old('content') }}</textarea>
  <div>
    <button type="submit" class="btn btn-primary mt-3">发布</button>
  </div>
</form>
