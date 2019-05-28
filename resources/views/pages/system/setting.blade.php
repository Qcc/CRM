@extends('layouts.app')
@section('title', ' 通用设置')

@section('content')
<div class="layui-row" style="padding: 15px;background-color: #F2F2F2;">
    <div class="layui-col-xs10 layui-col-xs-offset1">
        <div class="layui-row layui-col-space10">
            <div class="layui-col-xs4">
            <div class="layui-card" >
                <div class="layui-card-header">商机管理</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="layui-form-item">
                            <label class="layui-form-label">商机默认保留天数</label>
                            <div class="layui-input-block">
                              <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
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
                              <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">每次延期天数</label>
                            <div class="layui-input-block">
                              <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="layui-col-xs8">
            <div class="layui-card">
                <div class="layui-card-header">动态通知</div>
                <div class="layui-card-body">
                    <blockquote class="layui-elem-quote">欢迎管理员：
                        <span class="x-red">test</span>！王力，本月当前完成11222业绩，继续努力冲刺宗师级别，祝你成功！
                    </blockquote>
                    <form class="layui-form" action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <textarea placeholder="请填写公告" autocomplete="off" name="difficulties"  class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                          <div class="layui-input-block">
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
                    <div class="layui-card-header">业绩等级</div>
                    <div class="layui-card-body">
                            宗师 掌门 大侠 少侠 师兄 路人
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@stop