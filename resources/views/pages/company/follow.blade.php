@extends('layouts.app')
@section('title', '今日目标')

@section('content')
@include('layouts._company_side')
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
          <div class="layui-col-xs2">
              <a href="javascript:;" class="taday-body">
                <h3>拨打电话</h3>
                <p>
                    <cite>{{ $achievement['callCountOfMonth'] }}<span>次</span></cite></p>
              </a>
            </div>
            <div class="layui-col-xs2">
              <a href="javascript:;" class="taday-body">
                <h3>发送邮件</h3>
                <p>
                    <cite>{{ $achievement['emailCountOfMonth'] }}封</cite></p>
            </a>
            </div>
            <div class="layui-col-xs2">
              <a href="javascript:;" class="taday-body">
                <h3>有效商机</h3>
                <p>
                    <cite>{{ $achievement['businessCountOfMonth'] }}条</cite></p>
            </a>
            </div>
            <div class="layui-col-xs2">
              <a href="javascript:;" class="taday-body">
                <h3>成交客户</h3>
                <p>
                    <cite>{{ $achievement['cusCountOfMonth'] }}家</cite></p>
            </a>
            </div>
            <div class="layui-col-xs4">
              <a href="javascript:;" class="taday-body">
                <h3>合同金额</h3>
                <p>
                    <cite>￥{{ $achievement['moneyOfMonth'] }}.00</cite></p>
            </a>
            </div>
        </div>
      </div>
    </div>
    <div class="layui-card">
      <div class="layui-card-header">今日目标</div>
      <div class="layui-card-body"> 
        <span>拨打电话</span>
        <div class="layui-progress" lay-showpercent="true">
          <div class="layui-progress-bar" lay-percent="{{ $achievement['callCountOfDay'] }} / 120"></div>
        </div>
        <br>
        <span>发送邮件</span>
        <div class="layui-progress" lay-showPercent="yes">
          <div class="layui-progress-bar layui-bg-red" lay-percent="{{ $achievement['emailCountOfDay'] }} / 120"></div>
        </div>
         
        <br>
        <span>有效商机</span>
        <div class="layui-progress" lay-showPercent="yes">
          <div class="layui-progress-bar layui-bg-orange" lay-percent="{{ $achievement['businessCountOfDay'] }} / 10"></div>
        </div>
         
        <br>
        <span>成交客户</span>
        <div class="layui-progress" lay-showPercent="yes">
          <div class="layui-progress-bar layui-bg-blue" lay-percent="{{ $achievement['cusCountOfDay'] }} / 1"></div>
        </div>
        <br>

        <span>成交金额</span>
        <div class="layui-progress" lay-showPercent="yes">
          <div class="layui-progress-bar layui-bg-blue" lay-percent="{{ $achievement['moneyOfDay'] }} / 3000"></div>
        </div>
      </div>
    </div>
  </div>
@stop