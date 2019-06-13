@extends('layouts.app')

@section('content')
<div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
          <h2>CRM</h2>
          <p>深圳市沟通科技有限公司</p>
        </div>
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
      </div>
@endsection
