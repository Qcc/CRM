<div class="layui-header">
    <div class="layui-logo">沟通科技商机管理</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    @auth
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item {{ active_class(if_route('company.secrch'),'layui-this') }}"><a href="{{ route('company.secrch') }}">公海目标</a></li>
      <li class="layui-nav-item {{ active_class(if_route('company.follow') || if_route('company.show'),'layui-this') }}"><a href="{{ route('company.follow') }}">今日目标</a></li>
      <li class="layui-nav-item {{ active_class(if_route('follow.follow') || if_route('follow.show'),'layui-this') }}"><a href="{{ route('follow.follow') }}">客户跟进</a></li>
      <li class="layui-nav-item {{ active_class(if_route('customers.show'),'layui-this') }}"><a href="{{ route('customers.show') }}">我的客户</a></li>
      <li class="layui-nav-item {{ active_class(if_route('company.upload'),'layui-this') }}">
          <a href="javascript:;">系统管理</a>
          <dl class="layui-nav-child">
            <dd><a href="{{ route('company.upload') }}">资料上传</a></dd>
            <dd><a href="">用户管理</a></dd>
            <dd><a href="">权限管理</a></dd>
            <dd><a href="">销售话术</a></dd>
            <dd><a href="">系统设置</a></dd>
          </dl>
        </li>
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
          <dd><a href="">修改密码</a></dd>
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
