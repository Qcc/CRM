@extends('layouts.app')
@section('title', ' 用户管理')

@section('content')

<div class="layui-row" style="padding-top: 10px;">
    <div class="layui-col-xs10 layui-col-xs-offset1">
        <table lay-filter="edms-table" id="edms-table">
            <thead>
                <tr>
                    <th lay-data="{type:'checkbox', fixed: 'left'}"></th>
                    <th lay-data="{field:'id', hide:true}"></th>
                    <th lay-data="{field:'name',minWidth:200, sort: true}">公司</th>
                    <th lay-data="{field:'product', width:150, sort: true}">意向产品</th>
                    <th lay-data="{field:'Unsubscribe', width:150, sort: true}">投诉退订</th>
                    <th lay-data="{field:'created_at', width: 180, sort: true}">时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach($edms as $index => $cus)
                <tr>
                    <td></td>
                    <td>{{ $cus->id }}</td>
                    <td>{{ $cus->name }}</td>
                    <td>{{ $cus->product }}</td>
                    <td>{{ $cus->Unsubscribe }}</td>
                    <td>{{ $cus->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-box">
                {!! $edms->appends(Request::except('page'))->render() !!}
        </div>
    </div>
</div>
<script type="text/html" id="toolbarEdm">
    <div class="layui-btn-container">
      <button class="layui-btn layui-btn-sm" lay-event="deleteData">删除数据</button>
      <form id="edm-delete" action="{{ route('edm.delete') }}" method="POST" style="display: none;">
        <input name='ids' id="edm-ids" type="hidden">
            {{ csrf_field() }}
          </form>
      <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="event.preventDefault(); document.getElementById('reset-email-count').submit();" title="清理阅读计数器">清零</button>
      <div style="display:inline-block; margin：0 20px ;">
          <span style="font-size: 14px;">邮件阅读数 {{ $emailCount?$emailCount->count:0 }}</span>
        </div>
      <form id="reset-email-count" action="{{ route('resetEmailCount') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </div>
    </div>
  </script>
@stop