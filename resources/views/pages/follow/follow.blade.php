@extends('layouts.app')
@section('title', '今日目标')

@section('content')
@include('layouts._follow_side')
   <div style="padding: 15px;background-color: #F2F2F2;">
    <div class="layui-card">
      <div class="layui-card-body ">
          <blockquote class="layui-elem-quote">
              <i class="layui-icon layui-icon-speaker"></i>  
              {!! $achievement['notice'] !!}
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
                <div class="layui-col-xs2">
                  <a href="javascript:;" class="taday-body">
                    <h3>合同金额</h3>
                    <p>
                        <cite>￥{{ $achievement['moneyOfMonth'] }}</cite></p>
                </a>
                </div>
                <div class="layui-col-xs2">
                  <a href="javascript:;" class="taday-body">
                    <h3>本月称号</h3>
                    <p>
                        <cite>{{ $achievement['levelOfMonth'] }}</cite>
                        <span>提成 {{ $achievement['commissionOfMonth'] }}%</span>
                      </p>
                </a>
                </div>
                <div class="layui-col-xs2">
                  <a href="javascript:;" class="taday-body">
                    <h3>下个月预计</h3>
                    <p>
                        <cite>{{ $achievement['nextMonthLevel'] }}</cite>
                        <span>提成 {{ $achievement['nextMonthCommission'] }}%</span>
                    </p>
                </a>
                </div>
            </div>
      </div>
    </div>
    <div class="layui-row layui-col-space10">
        <div class="layui-col-xs4">
            <div class="layui-card">
                <div class="layui-card-header">预约联系</div>
                <div class="layui-card-body"> 
                    
                </div>
              </div>
        </div>

        <div class="layui-col-xs4">
            <div class="layui-card">
                <div class="layui-card-header">跟进到期</div>
                <div class="layui-card-body"> 
                    
                </div>
              </div>
        </div>

        <div class="layui-col-xs4">
            <div class="layui-card">
                <div class="layui-card-header">老客户维系</div>
                <div class="layui-card-body"> 
                    
                </div>
              </div>
        </div>
    </div>

  </div>
@stop