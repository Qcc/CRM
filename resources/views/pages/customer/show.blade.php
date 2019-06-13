@extends('layouts.app')
@section('title', $customer->company->name)

@section('content')
<div class="layui-row" style="padding: 15px;background-color: #F2F2F2;">
    <div class="layui-col-xs10 layui-col-xs-offset1">
      <div class="layui-row layui-col-space5">
          <div class="layui-col-xs4">
              <div class="layui-card">
                <div class="layui-card-header">订单信息</div>
                <div class="layui-card-body">
                  <h2>成交产品 <strong>{{ $customer->product }}</strong></h2>
                  @if($customer->check == 'check')
                  <p>订单状态 <span class="color-ind">审核中</span></p>
                  @elseif($customer->check == 'dismissed')
                  <p>订单状态 <span class="color-red">已驳回</span></p>
                  @elseif($customer->check == 'complate')
                  <p>订单状态 <span class="color-gre">已完成</span></p>
                  @elseif($customer->check == 'delete')
                  <p>订单状态 <span class="color-drak">已删除</span></p>
                  @endif
                  <p>联系人 {{ $customer->contact }}</p>
                  <p >{{ format_phone($customer->phone,'-') }}</p>
                  <p >收款金额 ￥{{ $customer->contract_money }}</p>
                  <p>成交日期 {{ $customer->completion_at->toDateString() }}</p>
                  <p>售后到期 {{ $customer->expired_at->toDateString() }}</p>
                  <p>合同 <a class="color-blue" href="{{ $customer->contract }}">{{ substr(strrchr($customer->contract,'/'),1) }}</a></p>
                  <p>{!! $customer->comment !!}</p>
                </div>  
              </div> 

            <div class="layui-card">
              <div class="layui-card-header">客户资料</div>
              <div class="layui-card-body">
                  <h2>{{ $customer->company->name }}</h2>
                  <p>联系人 <strong>{{ $customer->company->boss }}</strong></p>
                  <p class="phone">{{ format_phone($customer->company->phone,'-') }}</p>
                  <p >{{ $customer->company->morePhone }}</p>
                  <p>{{ $customer->company->email }}</p>
                  <p>注册资金 {{ $customer->company->money }}万{{ $customer->company->moneyType }}</p>
                  <p>成立日期 {{ $customer->company->registration }}</p>
                  <p>{{ $customer->company->address }}</p>
                  <p>{{ $customer->company->webAddress }}</p>
                  <p>{{ $customer->company->businessScope }}</p>
              </div>  
            </div>  
             
          </div>
          <div class="layui-col-xs8">
              <div class="layui-card">
                  <div class="layui-card-header">客户维系</div>
                  <div class="layui-card-body">
                      <form class="layui-form" method="POST" action="{{ route('customer.keep') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="company_id" value="{{ $customer->company->id }}">
                          <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                          <div class="layui-form-item">
                                <textarea name="content" class="form-control" id="record-editor" rows="1" cols="10" placeholder="请填入联系客户反馈。">{{ old('content' ) }}</textarea>
                          </div>
                          <div class="layui-form-item">
                              <div class="layui-input-block" style="margin-left: 0;">
                                <div class="layui-col-xs6">
                                  <div class="layui-inline" style="margin-right: 100px;">
                                    <p>下次联系客户时间 <span class="layui-word-aux">{{ $customer->relationship_at->toDateString() }}</span></p>  
                                  </div>
                                </div>
                                <div class="layui-col-xs6" style="text-align: right;">
                                  <button class="layui-btn" lay-submit="" lay-filter="follow-btn">提交联系反馈</button>
                                </div>
                              </div>
                            </div>
                      </form>
                  </div>  
                </div>

                <div class="layui-card">
                    <div class="layui-card-header">以往跟进记录</div>
                    <div class="layui-card-body">
                        @include('pages.company._records',['records'=>$customer->company->records()->orderBy('created_at','desc')->get()])
              </div>
          </div>
      </div>
    </div>
</div>
@stop
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('lib/styles/simditor.css') }}">
@stop

@section('script')
<script type="text/javascript" src="{{ asset('lib/scripts/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/scripts/module.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/scripts/hotkeys.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/scripts/uploader.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/scripts/simditor.js') }}"></script>
<!-- aetherupload文件上传组件 -->
<script src="{{ URL::asset('vendor/aetherupload/js/spark-md5.min.js') }}"></script>
<!--需要引入spark-md5.min.js-->
<script src="{{ URL::asset('vendor/aetherupload/js/aetherupload.js') }}"></script>
<!--需要引入aetherupload.js-->
@stop