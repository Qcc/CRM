@extends('layouts.app')

@section('content')
<div class="layui-row">
        <div class="layui-col-md4 layui-col-md-offset4">
          
        <div class="layui-card">
            <div class="layui-card-header">{{ __('Verify Your Email Address') }}</div>
            <div class="layui-card-body">
                @if (session('resent'))
                <blockquote class="layui-elem-quote">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </blockquote>
                @endif
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
            </div>
        </div>
    </div>
</div>
@endsection
