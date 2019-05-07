@extends('layouts.app')

@section('content')
<div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
          <h2>{{ __('Reset Password') }}</h2>
          <p>深圳市沟通科技有限公司</p>
        </div>
        <form method="POST" action="{{ route('password.update') }}" class="layadmin-user-login-box layadmin-user-login-body layui-form">
            @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

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
                                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-reg-password"></label>
                                <input type="password" name="password" id="LAY-user-reg-password" lay-verify="required" placeholder="{{ __('Password') }}" class="layui-input{{ $errors->has('password') ? ' layui-form-danger' : '' }}">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="layui-form-item">
                                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-conf-reg-password"></label>
                                <input type="password" name="password_confirmation" id="LAY-conf-reg-password" lay-verify="required" placeholder="重复密码" class="layui-input{{ $errors->has('password_confirmation') ? ' layui-form-danger' : '' }}">
                                @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="layui-form-item">
                            <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="LAY-user-login-submit">{{ __('Reset Password') }}</button>
                        </div>
                    </form>
                </div>
@endsection
