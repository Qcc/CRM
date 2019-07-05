@extends('layouts.app')
@section('title', ' 通用设置')

@section('content')
<div class="layui-row" style="padding: 15px;background-color: #F2F2F2;">
    <div class="layui-col-xs10 layui-col-xs-offset1">
        <div class="layui-row layui-col-space10">
            <div class="layui-col-xs4">
            <div class="layui-card business" >
                <div class="layui-card-header">商机管理</div>
                <div class="layui-card-body">
                    <form class="layui-form" method="POST" action="{{ route('settings.store') }}" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type" value="business">
                        <div class="layui-form-item">
                            <label class="layui-form-label">商机默认保留天数</label>
                            <div class="layui-input-block">
                              <input type="text" name="days" value="{{ $business->days }}" lay-verify="required|number" autocomplete="off" placeholder="请输入天数" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                          <label class="layui-form-label">是否可延期</label>
                          <div class="layui-input-block">
                            <input type="checkbox" name="delay" lay-text="1|0" lay-skin="primary" title="延期" {{ $business->delay == 1 ? "checked":"" }} >
                          </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">延期次数</label>
                            <div class="layui-input-block">
                              <input type="text" name="pics" value="{{ $business->pics }}" lay-verify="required|number" autocomplete="off" placeholder="请输入可延期次数" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">每次延期天数</label>
                            <div class="layui-input-block">
                              <input type="text" name="picOfdays" value="{{ $business->picOfdays }}" lay-verify="required|number" autocomplete="off" placeholder="请输入每次延期天数" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                          <div class="layui-input-block btn">
                            <button class="layui-btn layui-btn-normal" lay-submit="" lay-filter="more-info">保存</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>




                <div class="layui-card customer" >
                    <div class="layui-card-header">老客户维系</div>
                    <div class="layui-card-body">
                        <form class="layui-form" method="POST" action="{{ route('settings.store') }}" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="type" value="customer">
                            <div class="layui-form-item">
                                <div class="layui-input-inline days">
                                  <input type="text" name="days" value="{{ old('days', $customer->days) }}" lay-verify="required|number" autocomplete="off" placeholder="联系频率（天）" class="layui-input">
                                </div>
                              <div class="layui-input-inline btn">
                                <button class="layui-btn layui-btn-normal" lay-submit="" lay-filter="more-info">保存</button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>


        </div>
        <div class="layui-col-xs8">
            <div class="layui-card notice">
                <div class="layui-card-header">动态通知</div>
                <div class="layui-card-body">
                    <blockquote class="layui-elem-quote">
                            <i class="layui-icon layui-icon-speaker"></i>  
                        {!! $notice !!}
                    </blockquote>
                    <form class="layui-form" method="POST" action="{{ route('settings.store') }}" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type" value="notice" >
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <textarea placeholder="请填写公告" lay-verify="required|title" autocomplete="off" name="notice"  class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                          <div class="layui-input-block btn">
                            <button class="layui-btn layui-btn-normal" lay-submit="" lay-filter="more-info">发布新公告</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="layui-card report">
                <div class="layui-card-header">报表订阅</div>
                <div class="layui-card-body">
                    <form class="layui-form"  method="POST" action="{{ route('settings.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type" value="report">
                        <div class="layui-form-item">
                          <div class="layui-input-inline scope">
                            <input type="text" name="scope" id="reportScope"  autocomplete="off" placeholder="请选择日期范围" class="layui-input">
                          </div>
                          <div class="layui-input-inline employee"  title="ID用“,”号隔开，默认发送全部">
                            <input type="text" id="reportEmployee" name="employee" autocomplete="off" value="{{ old('employee', $report->employee) }}" placeholder="请输入员工ID" class="layui-input">
                          </div>
                          <div class="layui-input-inline inbox"  title="多个邮箱用“;”号隔开">
                            <input type="text" id="reportInbox" name="inbox" autocomplete="off" value="{{ old('inbox', $report->inbox) }}" placeholder="请输入报表接收邮箱" class="layui-input">
                          </div>
                          <div class="layui-input-inline repeat" >
                              <label class="layui-form-label">自动发送业绩</label>
                            <span title="每天8点自动发送前一天业绩统计">
                              <input type="checkbox" name="repeat[day]" lay-text="1|0" lay-skin="primary" title="每天" {{ $report->repeat->day == 1 ? "checked":"" }}>
                            </span>  
                            <span title="每周一早上8点自动发送前一周业绩统计">
                              <input type="checkbox" name="repeat[week]" lay-text="1|0" lay-skin="primary" title="每周" {{ $report->repeat->week == 1 ? "checked":"" }}>
                            </span>
                            <span title="每月1日8点自动发送前一月业绩统计">
                              <input type="checkbox" name="repeat[month]" lay-text="1|0" lay-skin="primary" title="每月" {{ $report->repeat->month == 1 ? "checked":"" }}>
                            </span>
                          </div>
                          <div class="layui-input-inline btn">
                              <button class="layui-btn layui-btn-normal" lay-submit="" >保存</button>
                              <button class="layui-btn layui-btn-normal sendReport-btn">立即发送</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-xs12">
                <div class="layui-card performance">
                    <div class="layui-card-header">动态业绩等级</div>
                    <div class="layui-card-body">
                        <form class="layui-form" method="POST" action="{{ route('settings.store') }}" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type" value="level">
                            <div class="layui-form-item">
                                <label class="layui-form-label">业绩要求</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_1_performance" value="{{ $level->level_1->performance }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <label class="layui-form-label">等级称号</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_1_name" value="{{ $level->level_1->name }}" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <label class="layui-form-label">提成点数</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_1_commission" value="{{ $level->level_1->commission }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                                <label class="layui-form-label">拨打电话</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_1_call" value="{{ $level->level_1->call }}" lay-verify="required|number" autocomplete="off" placeholder="请输入拨打电话次数" class="layui-input">
                                </div>
                                <label class="layui-form-label">有效商机</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_1_effective" value="{{ $level->level_1->effective }}" lay-verify="required|number" autocomplete="off" placeholder="请输入有效商机数量" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">业绩要求</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_2_performance" value="{{ $level->level_2->performance }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <label class="layui-form-label">等级称号</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_2_name" value="{{ $level->level_2->name }}" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <label class="layui-form-label">提成点数</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_2_commission" value="{{ $level->level_2->commission }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                                <label class="layui-form-label">拨打电话</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_2_call" value="{{ $level->level_2->call }}" lay-verify="required|number" autocomplete="off" placeholder="请输入拨打电话次数" class="layui-input">
                                </div>
                                <label class="layui-form-label">有效商机</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_2_effective" value="{{ $level->level_2->effective }}" lay-verify="required|number" autocomplete="off" placeholder="请输入有效商机数量" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">业绩要求</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_3_performance" value="{{ $level->level_3->performance }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <label class="layui-form-label">等级称号</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_3_name" value="{{ $level->level_3->name }}" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <label class="layui-form-label">提成点数</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_3_commission" value="{{ $level->level_3->commission }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                                <label class="layui-form-label">拨打电话</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_3_call" value="{{ $level->level_3->call }}" lay-verify="required|number" autocomplete="off" placeholder="请输入拨打电话次数" class="layui-input">
                                </div>
                                <label class="layui-form-label">有效商机</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_3_effective" value="{{ $level->level_3->effective }}" lay-verify="required|number" autocomplete="off" placeholder="请输入有效商机数量" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">业绩要求</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_4_performance" value="{{ $level->level_4->performance }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <label class="layui-form-label">等级称号</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_4_name" value="{{ $level->level_4->name }}" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <label class="layui-form-label">提成点数</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_4_commission" value="{{ $level->level_4->commission }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                                <label class="layui-form-label">拨打电话</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_4_call" value="{{ $level->level_4->call }}" lay-verify="required|number" autocomplete="off" placeholder="请输入拨打电话次数" class="layui-input">
                                </div>
                                <label class="layui-form-label">有效商机</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_4_effective" value="{{ $level->level_4->effective }}" lay-verify="required|number" autocomplete="off" placeholder="请输入有效商机数量" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">业绩要求</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_5_performance" value="{{ $level->level_5->performance }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <label class="layui-form-label">等级称号</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_5_name" value="{{ $level->level_5->name }}" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <label class="layui-form-label">提成点数</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_5_commission" value="{{ $level->level_5->commission }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                                <label class="layui-form-label">拨打电话</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_5_call" value="{{ $level->level_5->call }}" lay-verify="required|number" autocomplete="off" placeholder="请输入拨打电话次数" class="layui-input">
                                </div>
                                <label class="layui-form-label">有效商机</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_5_effective" value="{{ $level->level_5->effective }}" lay-verify="required|number" autocomplete="off" placeholder="请输入有效商机数量" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">业绩要求</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_6_performance" value="{{ $level->level_6->performance }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <label class="layui-form-label">等级称号</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_6_name" value="{{ $level->level_6->name }}" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <label class="layui-form-label">提成点数</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_6_commission" value="{{ $level->level_6->commission }}" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                                <label class="layui-form-label">拨打电话</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_6_call" value="{{ $level->level_6->call }}" lay-verify="required|number" autocomplete="off" placeholder="请输入拨打电话次数" class="layui-input">
                                </div>
                                <label class="layui-form-label">有效商机</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_6_effective" value="{{ $level->level_6->effective }}" lay-verify="required|number" autocomplete="off" placeholder="请输入有效商机数量" class="layui-input">
                                </div>
                            </div>
                             
                            <div class="layui-form-item">
                                    <div class="layui-input-block btn">
                                      <button class="layui-btn layui-btn-normal" lay-submit="" lay-filter="more-info">保存</button>
                                    </div>
                                  </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-row">
      <div class="layui-col-xs12">
          <div class="layui-card performance">
              <div class="layui-card-header">邮件营销阅读数</div>
              <div class="layui-card-body">
                <div>
                  <p>当前阅读数 {{ $emailCount?$emailCount->count:0 }}</p>
                  <button class="layui-btn layui-btn-normal" onclick="event.preventDefault(); document.getElementById('reset-email-count').submit();">清零</button>
                  <form id="reset-email-count" action="{{ route('resetEmailCount') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </div>
              </div>
          </div>
        </div>
      </div>
</div>
<form id="sendReport" action="{{ route('report.send') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
    <input id='sendScope' type="hidden" name="scope">
    <input id='sendEmployee' type="hidden" name="employee">
</form>
@stop