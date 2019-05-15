@extends('layouts.app')
@section('title', '今日目标')

@section('content')
@include('layouts._side')
   <div style="padding: 15px;background-color: #F2F2F2;">
      <div class="layui-row layui-col-space10">
          <div class="layui-col-xs8">
              <div class="layui-card">
                  <div class="layui-card-header">客户跟进</div>
                  <div class="layui-card-body">
                      <form class="layui-form" method="POST" action="{{ route('company.followUp') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="company" value="{{ $company->id }}">
                          <input type="hidden" name="next" value="{{ nextCompany($company,$companys) }}">
                          <div class="layui-form-item">
                                <textarea name="content" class="form-control" id="record-editor" rows="1" cols="10" placeholder="请填入客户跟进内容。">{{ old('content' ) }}</textarea>
                          </div>
                          <div class="layui-form-item">
                              <div class="layui-input-block" style="text-align: right;">
                                  <input type="checkbox" name="wrongnumber" lay-skin="primary" title="号码不正确">
                                  <input type="checkbox" name="noneed" lay-skin="primary" title="没有需要">
                                  <input type="checkbox" name="email" lay-skin="primary" checked="" title="发送邮件">
                                <button class="layui-btn" lay-submit="" lay-filter="record-btn">提交反馈</button>
                              </div>
                            </div>
                      </form>
                      <ul class="layui-timeline">
                          <li class="layui-timeline-item">
                            <i class="layui-icon layui-timeline-axis"></i>
                            <div class="layui-timeline-content layui-text">
                              <h3 class="layui-timeline-title">8月18日</h3>
                              <p>
                                layui 2.0 的一切准备工作似乎都已到位。发布之弦，一触即发。
                                <br>不枉近百个日日夜夜与之为伴。因小而大，因弱而强。
                                <br>无论它能走多远，抑或如何支撑？至少我曾倾注全心，无怨无悔 <i class="layui-icon"></i>
                              </p>
                            </div>
                          </li>
                          <li class="layui-timeline-item">
                            <i class="layui-icon layui-timeline-axis"></i>
                            <div class="layui-timeline-content layui-text">
                              <h3 class="layui-timeline-title">8月16日</h3>
                              <p>杜甫的思想核心是儒家的仁政思想，他有<em>“致君尧舜上，再使风俗淳”</em>的宏伟抱负。个人最爱的名篇有：</p>
                              <ul>
                                <li>《登高》</li>
                                <li>《茅屋为秋风所破歌》</li>
                              </ul>
                            </div>
                          </li>
                          <li class="layui-timeline-item">
                            <i class="layui-icon layui-timeline-axis"></i>
                            <div class="layui-timeline-content layui-text">
                              <h3 class="layui-timeline-title">8月15日</h3>
                              <p>
                                中国人民抗日战争胜利日
                                <br>常常在想，尽管对这个国家有这样那样的抱怨，但我们的确生在了最好的时代
                                <br>铭记、感恩
                                <br>所有为中华民族浴血奋战的英雄将士
                                <br>永垂不朽
                              </p>
                            </div>
                          </li>
                          <li class="layui-timeline-item">
                            <i class="layui-icon layui-timeline-axis"></i>
                            <div class="layui-timeline-content layui-text">
                              <div class="layui-timeline-title">过去</div>
                            </div>
                          </li>
                        </ul>  
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