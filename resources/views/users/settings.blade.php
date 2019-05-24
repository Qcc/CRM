@extends('layouts.app')
@section('title', '设置中心')

@section('content')
<div class="layui-row layui-col-space10" style="padding: 15px;background-color: #F2F2F2;">
    <div class="layui-col-xs2 layui-col-xs-offset1">
        <div class="layui-card">
          <div class="layui-card-header">个人资料</div>
          <div class="layui-card-body">
              <div class="layui-upload">
                <div class="layui-upload-list">
                  <img class="layui-upload-img" src="{{ Auth::user()->avatar }}" id="avatar">
                  <p id="demoText"></p>
                </div>
                <button type="button" class="layui-btn" id="test1">上传头像</button>
              </div>
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