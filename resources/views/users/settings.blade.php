@extends('layouts.app')
@section('title', '设置中心')

@section('content')
<div class="layui-row layui-col-space10" style="padding: 15px;background-color: #F2F2F2;">
    <div class="layui-col-xs2 layui-col-xs-offset1">
        <div class="layui-card">
          <div class="layui-card-header">个人资料</div>
          <div class="layui-card-body">
            <form class="layui-form" method="post" action="{{ route('user.uploadAvatar') }}" accept-charset="UTF-8" 
            enctype="multipart/form-data">
                <div class="layui-form-item">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              @if(Auth::user()->avatar)
              <br>
              <img src="{{ Auth::user()->avatar }}" width="180" />
              @endif
              <input type="file" name="avatar">
              </div>
              
              <div class="layui-form-item">
                  <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
                  </div>
                </div>
            </form>
              <div class="userinfo">
                <p>姓名：<span>{{ Auth::user()->name }}</span></p>
                <p>邮箱：<span>{{ Auth::user()->email }}</span></p>
              </div>
          </div>
        </div>
    </div>  
    <div class="layui-col-xs8">
        <div class="layui-card">
          <div class="layui-card-header">
            个人设置
          </div>
          <div class="layui-card-body">
               <p>暂无设置!</p>
          </div>
        </div>
    </div>
</div>
@stop