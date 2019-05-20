@foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(session()->has($msg))
    <div class="flash-message">
      <p class="alert alert-{{ $msg }}">
        {{ session()->get($msg) }}
        <i class="layui-icon layui-icon-close"></i>
      </p>
    </div>
  @endif
@endforeach