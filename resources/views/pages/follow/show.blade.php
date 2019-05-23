@extends('layouts.app')
@section('title', '今日目标')

@section('content')
@include('layouts._follow_side')
   <div style="padding: 15px;background-color: #F2F2F2;">
      <div class="layui-row layui-col-space10">
          <div class="layui-col-xs8">
              <div class="layui-card">
                  <div class="layui-card-header">跟进反馈</div>
                  <div class="layui-card-body">
                      <form class="layui-form" method="POST" action="{{ route('follow.storeRecord') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="company_id" value="{{ $follow->company->id }}">
                          <div class="layui-form-item">
                                <textarea name="content" class="form-control" id="record-editor" rows="1" cols="10" placeholder="请填入客户跟进内容。">{{ old('content' ) }}</textarea>
                          </div>
                          <div class="layui-form-item">
                              <div class="layui-input-block" style="margin-left: 0;">
                                <div class="layui-col-xs6">
                                  <div class="layui-inline" style="margin-right: 100px;" title="请在商机保护期内完成订单，到期后商机将被放入公海目标">
                                    <p>商机保留 <span class="layui-word-aux" id="countdown" now="{{ now() }}" endTime="{{ $follow->countdown }}"></span></p>  
                                  </div>
                                </div>
                                <div class="layui-col-xs6" style="text-align: right;">
                                  <button class="layui-btn" lay-submit="" lay-filter="follow-btn">提交反馈</button>
                                  <button class="layui-btn layui-btn-warm customer-btn">成交</button>
                                </div>
                              </div>
                            </div>
                      </form>
                  </div>
              </div>
                      <div class="layui-card">
                        <div class="layui-card-header">跟进记录</div>
                        <div class="layui-card-body">
                            @include('pages.company._records',['records'=>$follow->company->records()->orderBy('created_at','desc')->get()])
                  </div>
              </div>
          </div>
          <div class="layui-col-xs4">
              <div class="layui-card">
                  <div class="layui-card-header">完善客户信息</div>
                  <div class="layui-card-body company-info">
                      @include('pages.follow._follow_form')
                  </div>
              </div>
              <div class="layui-card">
                  <div class="layui-card-header">基本资料</div>
                  <div class="layui-card-body company-info">
                    <h2>{{ $follow->company->name }}</h2>
                    <p>联系人 <strong>{{ $follow->company->boss }}</strong></p>
                    <p class="phone">{{ format_phone($follow->company->phone,'-') }}</p>
                    <p >{{ $follow->company->morePhone }}</p>
                    <p>{{ $follow->company->email }}</p>
                    <p>注册资金 {{ $follow->company->money }}万{{ $follow->company->moneyType }}</p>
                    <p>成立日期 {{ $follow->company->registration }}</p>
                    <p>{{ $follow->company->address }}</p>
                    <p>{{ $follow->company->webAddress }}</p>
                    <p>{{ $follow->company->businessScope }}</p>
                  </div>
              </div>
          </div>
      </div>
  </div>
@stop

@include('pages.follow._customer_form')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('lib/styles/simditor.css') }}">
@stop

@section('script')
<script type="text/javascript" src="{{ asset('lib/scripts/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/scripts/module.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/scripts/hotkeys.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/scripts/uploader.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/scripts/simditor.js') }}"></script>
@stop