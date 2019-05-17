@extends('layouts.app')
@section('title', '今日目标')

@section('content')
@include('layouts._follow_side')
   <div style="padding: 15px;background-color: #F2F2F2;">
    <div class="layui-card">
      <div class="layui-card-body ">
          <blockquote class="layui-elem-quote">欢迎管理员：
              <span class="x-red">test</span>！当前时间:2018-04-25 20:50:53
          </blockquote>
      </div>
    </div>
    <div class="layui-card">
      <div class="layui-card-header">本月完成</div>
      <div class="layui-card-body">
        <div class="layui-row layui-col-space30">
          <div class="layui-col-xs3">
              <a href="javascript:;" class="taday-body">
                <h3>拨打电话</h3>
                <p>
                    <cite>66</cite></p>
              </a>
            </div>
            <div class="layui-col-xs3">
              <a href="javascript:;" class="taday-body">
                <h3>发送邮件</h3>
                <p>
                    <cite>66</cite></p>
            </a>
            </div>
            <div class="layui-col-xs3">
              <a href="javascript:;" class="taday-body">
                <h3>有效商机</h3>
                <p>
                    <cite>66</cite></p>
            </a>
            </div>
            <div class="layui-col-xs3">
              <a href="javascript:;" class="taday-body">
                <h3>成交客户</h3>
                <p>
                    <cite>66</cite></p>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="layui-row layui-col-space10">
        <div class="layui-col-xs6">
            <div class="layui-card">
                <div class="layui-card-header">预约联系</div>
                <div class="layui-card-body"> 
                    
                </div>
              </div>
        </div>

        <div class="layui-col-xs6">
            <div class="layui-card">
                <div class="layui-card-header">跟进到期</div>
                <div class="layui-card-body"> 
                    
                </div>
              </div>
        </div>
    </div>

  </div>
@stop