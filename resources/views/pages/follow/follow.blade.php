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
        <div class="layui-col-xs3">
            <div class="layui-card">
                <div class="layui-card-header" title="预约跟进中的客户，到期前这里会有提醒">预约联系 <span> 提前1天提醒</span></div>
                <div class="layui-card-body"> 
                  <ul>
                      @foreach($schedules as $follow)
                        <li>
                          <a href="{{ route('follow.show',$follow->id) }}" title= "{{$follow->schedule_at}} 需要联系客户，请不要忘记">{{ $follow->company->name }}</a>
                          @if($follow->schedule_at->gt(now()))
                          <span title="{{ $follow->schedule_at }} 过期"><i class="layui-icon layui-icon-log"></i> {{ $follow->schedule_at->diffForHumans(null, true)}}</span> 
                          @else
                          <span class="color-red" title="{{ $follow->schedule_at }} 过期"><i class="layui-icon layui-icon-face-cry"></i> 已过期</span> 
                          @endif
                        </li>
                      @endforeach
                  </ul>
              </div>
            </div>
        </div>

        <div class="layui-col-xs3">
            <div class="layui-card">
                <div class="layui-card-header" title="商机跟进保留会有期限，到期前这里会有提醒">跟进到期 <span> 提前10天提醒</span></div>
                <div class="layui-card-body"> 
                  <ul>
                    @foreach($countdowns as $follow)
                    <li><a href="{{ route('follow.show',$follow->id) }}" title= "该商机还可保留至{{ $follow->countdown_at }}，请尽快完成或申请延期">{{ $follow->company->name }}</a>
                      @if($follow->countdown_at->gt(now()))
                        <span title="{{ $follow->countdown_at }} 终止跟进"><i class="layui-icon layui-icon-log"></i> {{ $follow->countdown_at->diffForHumans(null, true) }}</span> 
                      @else
                        <span class="color-red" title="{{ $follow->countdown_at }} 终止跟进"><i class="layui-icon layui-icon-face-cry"></i> 已过期</span> 
                      @endif
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
        </div>

        <div class="layui-col-xs3">
            <div class="layui-card">
                <div class="layui-card-header" title="已成交的老客户需要定时联系维护客户关系">老客户维系 <span> 提前5天提醒</span></div>
                <div class="layui-card-body"> 
                  <ul>
                    @foreach($relationships as $customer)
                    <li><a href="{{ route('customer.show',$customer->id) }}" title= "你已经很久没有联系该客户了，请尽快联系客户，维持良好的客户关系">{{ $customer->company->name }}</a>
                      @if($customer->relationship_at->gt(now()))
                         <span title="{{ $customer->relationship_at }} 前联系"><i class="layui-icon layui-icon-log"></i> {{ $customer->relationship_at->diffForHumans(null, true) }}</span> 
                      @else
                        <span class="color-red" title="{{ $customer->relationship_at }} 过期，请尽快联系客户"><i class="layui-icon layui-icon-face-cry"></i> 已过期</span> 
                      @endif
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
        </div>
        
        <div class="layui-col-xs3">
            <div class="layui-card">
                <div class="layui-card-header" title="售后/续费到期的客户，会在这里提醒到期">售后续费到期 <span> 提前30天提醒</span></div>
                <div class="layui-card-body"> 
                  <ul>
                    @foreach($expireds as $customer)
                    <li><a href="{{ route('customer.show',$customer->id) }}" title= "该客户的售后/续费将于{{$customer->expired_at}}到期，请提前联系客户商议续费事宜">{{ $customer->company->name }}</a>
                      @if($customer->expired_at->gt(now()))
                      <span title="{{ $customer->expired_at }} 售后到期"><i class="layui-icon layui-icon-log"></i> {{ $customer->expired_at->diffForHumans(null, true) }}</span> 
                      @else
                        <span class="color-red" title="{{ $customer->expired_at }} 售后过期，请联系客户续费"><i class="layui-icon layui-icon-face-cry"></i> 已过期</span> 
                      @endif
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
        </div>
    </div>

  </div>
@stop