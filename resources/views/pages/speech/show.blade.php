@extends('layouts.app')
@section('title', ' 销售话术')

@section('content')

<div class="layui-row">
    <div class="layui-col-xs10 layui-col-xs-offset1">
        <div class="layui-row">
            <div class="layui-col-xs6">
            <form class="layui-form" method="get" action="{{ route('speechs.index') }}">
                <div class="layui-form-item">
                    <div class="layui-input-inline">
                        <input type="text" name="ask" lay-verify="required|title" autocomplete="off" placeholder="请输入内容"
                            class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="search-speechs">查找话术</button>
                    </div>
                </div>
            </form>
            </div>
            <div class="layui-col-xs6" style="text-align: right;">
                    <button class="layui-btn layui-btn-normal add-speechs">添加话术</button>
            </div>
        </div>
        <table lay-filter="speechs-table" id="speechs-table">
            <thead>
                <tr>
                    <th lay-data="{field:'id', width:50}">ID</th>
                    <th lay-data="{field:'user_id', width:150}">职员</th>
                    <th lay-data="{field:'ask', width:150}">客户提问</th>
                    <th lay-data="{field:'answer', width:250}">标准回答</th>
                    <th lay-data="{field:'product', width:150}">适用产品</th>
                    <th lay-data="{field:'updated_at', minWidth: 100}">更新时间</th>
                    <th lay-data="{fixed: 'right',toolbar:'#speechsEdit'}">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($speechs as $index => $speech)
                <tr>
                    <td>{{ $speech->id }}</td>
                    <td>{{ $speech->user_id }}</td>
                    <td>{{ $speech->ask }}</td>
                    <td>{{ $speech->answer }}</td>
                    <td>{{ $speech->product }}</td>
                    <td>{{ $speech->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-box">
                {!! $speechs->appends(Request::except('page'))->render() !!}
        </div>
    </div>
</div>
<script type="text/html" id="speechsEdit">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
  </script>
<form class="layui-form" method="POST" id="speech-form" action="{{ route('speech.update') }}" lay-filter="speech-form" style="display:none;margin-right: 80px;">
    <input type="hidden" name="id">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="layui-form-item">
        <label class="layui-form-label">客户问题</label>
        <div class="layui-input-block">
            <input type="text" name="ask" lay-verify="required|title" value="{{ old('ask') }}" autocomplete="off" placeholder="请输入客户问题" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">适用产品</label>
        <div class="layui-input-block">
            <input type="text" name="product" lay-verify="required|title" autocomplete="off" placeholder="请输入适用产品" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">标准回答</label>
        <div class="layui-input-block">
                <textarea name="answer" placeholder="请输入标准回答" class="layui-textarea"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn submit" lay-submit="" lay-filter="form-btn">确认修改</button>
        </div>
    </div>
</form>
<form class="layui-form" method="POST" id="speech-add-form" action="{{ route('speech.store') }}" lay-filter="speech-add-form" style="display:none;margin-right: 80px;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="layui-form-item">
            <label class="layui-form-label">客户问题</label>
            <div class="layui-input-block">
                <input type="text" name="ask" lay-verify="required|title" autocomplete="off" placeholder="请输入客户提问" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">适用产品</label>
            <div class="layui-input-block">
                <input type="text" name="product" lay-verify="required|title" autocomplete="off" placeholder="请输入适用产品" class="layui-input">
            </div>
        </div>
    
        <div class="layui-form-item">
            <label class="layui-form-label">标准回答</label>
            <div class="layui-input-block">
                    <textarea name="answer"  placeholder="请输入标准回答" class="layui-textarea"></textarea>
            </div>
        </div>
    
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn submit" lay-submit="" lay-filter="form-btn">确认添加</button>
            </div>
        </div>
    </form>
    <form id="speech-destroy" action="{{ route('speech.destroy') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="text" id="speech_id" name="id" >
    </form>
@stop