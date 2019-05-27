@extends('layouts.app')
@section('title', '今日目标')

@section('content')
@include('layouts._company_side')
   <div style="padding: 15px;background-color: #F2F2F2;">
      <div class="layui-row layui-col-space10">
          <div class="layui-col-xs8">
              <div class="layui-card">
                  <div class="layui-card-header">跟进反馈</div>
                  <div class="layui-card-body">
                      <form class="layui-form" method="POST" action="{{ route('record.store') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="company_id" value="{{ $company->id }}">
                          <input type="hidden" name="next" value="{{ nextCompany($company,$companys) }}">
                          <div class="layui-form-item">
                                <textarea name="content" class="form-control" id="record-editor" rows="1" cols="10" placeholder="请填入客户跟进内容。">{{ old('content' ) }}</textarea>
                          </div>
                          <div class="layui-form-item">
                              <div class="layui-input-block" style="text-align: right;">
                                <input type="radio" name="feed" value="lucky" title="保持联系" checked="">
                                <input type="radio" name="feed" value="noneed" title="没有需要">
                                <input type="radio" name="feed" value="wrongnumber" title="号码不正确">
                                <button class="layui-btn" lay-submit="" lay-filter="record-btn">提交反馈</button>
                              </div>
                            </div>
                      </form>
                  </div>
              </div>
                      <div class="layui-card">
                        <div class="layui-card-header">跟进记录</div>
                        <div class="layui-card-body">
                            @include('pages.company._records',['records'=>$company->records()->orderBy('created_at','desc')->get()])
                  </div>
              </div>
          </div>
          <div class="layui-col-xs4">
              <div class="layui-card">
                  <div class="layui-card-header">客户资料</div>
                  <div class="layui-card-body company-info">
                    <h2>{{ $company->name }}</h2>
                    <p>联系人 <strong>{{ $company->boss }}</strong></p>
                    <p class="phone">{{ format_phone($company->phone,'-') }}</p>
                    <p >{{ $company->morePhone }}</p>
                    <p>{{ $company->email }}</p>
                    <p>注册资金 {{ $company->money }}万{{ $company->moneyType }}</p>
                    <p>成立日期 {{ $company->registration }}</p>
                    <p>{{ $company->address }}</p>
                    <p>{{ $company->webAddress }}</p>
                    <p>{{ $company->businessScope }}</p>
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
@stop