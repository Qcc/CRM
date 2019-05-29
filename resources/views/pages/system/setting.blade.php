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
                    <form class="layui-form" action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="layui-form-item">
                            <label class="layui-form-label">商机默认保留天数</label>
                            <div class="layui-input-block">
                              <input type="text" name="days" lay-verify="required|number" autocomplete="off" placeholder="请输入天数" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                          <label class="layui-form-label">是否可延期</label>
                          <div class="layui-input-block">
                            <input type="checkbox" name="delay" lay-skin="primary" title="延期" checked="">
                          </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">延期次数</label>
                            <div class="layui-input-block">
                              <input type="text" name="pics" lay-verify="required|number" autocomplete="off" placeholder="请输入可延期次数" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">每次延期天数</label>
                            <div class="layui-input-block">
                              <input type="text" name="picOfdays" lay-verify="required|number" autocomplete="off" placeholder="请输入每次延期天数" class="layui-input">
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
        <div class="layui-col-xs8">
            <div class="layui-card notice">
                <div class="layui-card-header">动态通知</div>
                <div class="layui-card-body">
                    <blockquote class="layui-elem-quote">
                            <i class="layui-icon layui-icon-speaker"></i>  
                        欢迎管理员：
                        <span class="x-red">test</span>！王力，本月当前完成11222业绩，继续努力冲刺宗师级别，祝你成功！
                    </blockquote>
                    <fieldset class="layui-elem-field">
                      <legend>可用变量 <span class="tips">发布后分别替换为当前登录人的信息</span></legend>
                      <div class="layui-field-box">
                        %姓名% %本月业绩% %本月拨打% 
                      </div>
                    </fieldset>
                    <form class="layui-form" action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <textarea placeholder="请填写公告" autocomplete="off" name="difficulties"  class="layui-textarea"></textarea>
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
        </div>
        <div class="layui-row">
            <div class="layui-col-xs12">
                <div class="layui-card">
                    <div class="layui-card-header">动态业绩等级</div>
                    <div class="layui-card-body">
                        <form class="layui-form" action="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="layui-form-item">
                                <label class="layui-form-label">级别一</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_1_performance" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_1_name" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_1_commission" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">级别二</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_2_performance" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_2_name" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_2_commission" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">级别三</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_3_performance" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_3_name" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_3_commission" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">级别四</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_4_performance" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_4_name" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_4_commission" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">级别五</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_5_performance" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_5_name" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_5_commission" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">级别六</label>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_6_performance" lay-verify="required|number" autocomplete="off" placeholder="请输入级别业绩" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_6_name" lay-verify="required|title" autocomplete="off" placeholder="请输入级别名称" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                  <input type="text" name="level_6_commission" lay-verify="required|number" autocomplete="off" placeholder="请输入级别提成点数" class="layui-input">
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
</div>
    
@stop