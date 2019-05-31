<div class="layui-header">
    <div class="layui-logo">沟通科技商机管理</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    @auth
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item {{ active_class(if_route('company.secrch'),'layui-this') }}"><a href="{{ route('company.secrch') }}">公海目标</a></li>
      <li class="layui-nav-item {{ active_class(if_route('company.follow') || if_route('company.show'),'layui-this') }}"><a href="{{ route('company.follow') }}">今日目标</a></li>
      <li class="layui-nav-item {{ active_class(if_route('follow.follow') || if_route('follow.show'),'layui-this') }}"><a href="{{ route('follow.follow') }}">客户跟进</a></li>
      @if(Auth::user()->can('manager'))
      <li class="layui-nav-item {{ active_class(if_route('customers.show'),'layui-this') }}"><a href="{{ route('customers.show') }}">所有客户</a></li>
      @else
      <li class="layui-nav-item {{ active_class(if_route('customers.show'),'layui-this') }}"><a href="{{ route('customers.show') }}">我的客户</a></li>
      @endif
      @can('manager')
      <li class="layui-nav-item {{ active_class(if_route('company.upload'),'layui-this') }}">
          <a href="javascript:;">系统管理</a>
          <dl class="layui-nav-child">
            <dd><a href="{{ route('company.upload') }}">资料上传</a></dd>
            <dd><a href="{{ route('system.users') }}">用户管理</a></dd>
            <dd><a href="{{ route('speechs.index') }}">销售话术</a></dd>
            <dd><a href="{{ route('settings.show') }}">系统设置</a></dd>
          </dl>
        </li>
        @endcan
    </ul>
    @endauth
    <ul class="layui-nav layui-layout-right">
        @guest
            <li class="layui-nav-item"><a href="{{ route('login') }}">登录</a></li>
        @endguest
        @auth
      <li class="layui-nav-item {{ active_class(if_route('user.settings'),'layui-this') }}">
        <a href="javascript:;">
          <img src="{{ Auth::user()->avatar }}" class="layui-nav-img">
          {{ Auth::user()->name }}
        </a>
        <dl class="layui-nav-child">
          <dd><a href="{{ route('user.settings') }}">基础资料</a></dd>
          <dd><a href="javascript:;" id="password-btn">修改密码</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">注销</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        </li>
      @endauth
    </ul>
</div>
@auth
<form class="layui-form" method="POST" id="user-password" action="{{ route('user.password',Auth::id()) }}" lay-filter="user-password" style="display:none;margin-right: 80px;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="layui-form-item">
        <label class="layui-form-label">旧密码</label>
        <div class="layui-input-block">
            <input type="password" name="oldPassword" lay-verify="required|password" autocomplete="off" placeholder="请输入旧密码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新密码</label>
        <div class="layui-input-block">
            <input type="password" name="password" lay-verify="required|password" autocomplete="off" placeholder="请输入新密码" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">确认密码</label>
        <div class="layui-input-block">
            <input type="password" name="password_confirmation" lay-verify="required|password_confirmation" placeholder="请再次输入新密码" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn submit" lay-submit="" lay-filter="form-btn">确定</button>
        </div>
    </div>
</form>
@endauth
