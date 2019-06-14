@extends('layouts.app')
@section('title', '首页')

@section('content')
<div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
          <div class="logo"><img src="/images/logo-gre.png" alt="深圳市沟通科技有限公司logo"></div>
        </div>
        @auth
        <div class="auth">
          <div class="avatar"><img src="{{Auth::user()->avatar}}" alt=""></div>
          <div class="info">
            <p>{{ Auth::user()->name }} 欢迎你! 请按照下列步骤使用CRM。</p>
          </div>
        </div>
</div>
        <div class="step">
          <div class="step-item">
            <div class="step-body">第一步</div>
            <div class="step-header">搜索“<a href="{{ route('company.secrch') }}">公海目标</a>”选择目标客户进行跟进</div>
          </div>

          <div class="arrow-right arrow-box">
              <b class="right"><i class="right-arrow1"></i><i class="right-arrow2"></i></b>
          </div>

          <div class="step-item">
            <div class="step-body">第二步</div>
            <div class="step-header">拨打“<a href="{{ route('company.follow') }}">今日目标</a>”电话，反馈联系结果</div>
          </div>

          <div class="arrow-right arrow-box">
              <b class="right"><i class="right-arrow1"></i><i class="right-arrow2"></i></b>
          </div>

          <div class="step-item">
            <div class="step-body">第三步</div>
            <div class="step-header">持续跟进“<a href="{{ route('follow.follow') }}">客户跟进</a>”有效商机，反馈跟进过程</div>
          </div>
          
          <div class="arrow-right arrow-box">
              <b class="right"><i class="right-arrow1"></i><i class="right-arrow2"></i></b>
          </div>

          <div class="step-item">
            <div class="step-body">完成</div>
            <div class="step-header">“<a href="{{ route('customers.index') }}">我的客户</a>”完成订单，继续寻找更多商机</div>
          </div>
        @endauth
        @guest
        <form method="POST" action="{{ route('login') }}" class="layadmin-user-login-box layadmin-user-login-body layui-form">
                        @csrf
          <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
            <input type="text" name="email" id="LAY-user-login-username" lay-verify="required" placeholder="{{ __('E-Mail Address') }}" class="layui-input{{ $errors->has('email') ? ' layui-form-danger' : '' }}">
            @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
          </div>
          <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
            <input type="password" name="password" id="LAY-user-login-password" lay-verify="required" placeholder="{{ __('Password') }}" class="layui-input{{ $errors->has('password') ? ' layui-form-danger' : '' }}">
            @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
          </div>
          <div class="layui-form-item" style="margin-bottom: 20px;">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} lay-skin="primary" title="{{ __('Remember Me') }}"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>{{ __('Remember Me') }}</span><i class="layui-icon layui-icon-ok"></i></div>
            <a href="{{ route('password.request') }}" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">{{ __('Forgot Your Password?') }}</a>
          </div>
          <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="LAY-user-login-submit">{{ __('Login') }}</button>
          </div>
          <!-- <div><span><a href="{{ route('register') }}">还没有帐号，点击注册。</a></span></div> -->
        </form>
        @endguest
      </div>
@stop