@extends('layouts.app')
@section('title', '公海目标')

@section('content')
<div class="layui-row">
    <div class="layui-col-xs10 layui-col-xs-offset1">
        <table lay-filter="customers-table" id="customers-table" lay-filter="customers-table">
            <thead>
              <tr>
                  <th lay-data="{type:'checkbox', fixed: 'left'}"></th>
                  <th lay-data="{field:'id', width:80, hide:true}">ID</th>
                  <th lay-data="{field:'name', width:200}">公司</th>
                  <th lay-data="{field:'contacted', width:86, hide:true,templet: function(d){ return d.contacted==1?'<span class=color-red>有</span>':'无'} }">跟进记录</th>
                  <th lay-data="{field:'follow', width:86, hide:true,templet: function(d){ 
                    if(d.follow == 'target'){
                      return '<span class=color-gre>可跟进</span>';
                    }else if(d.follow == 'locking'){
                      return '<span class=color-red>锁定中</span>';
                    }else if(d.follow == 'follow'){
                      return '<span class=color-ind>跟进中</span>';
                    }else if(d.follow == 'complate'){
                      return '<span class=color-blue>已成交</span>';
                    }else{
                      return '无';
                    } }}">状态</th>
                  <th lay-data="{field:'boss', width:80}">法人</th>
                  <th lay-data="{field:'money', width:86,templet: function(d){return d.money+'万'} }">注册资金</th>
                  <th lay-data="{field:'moneyType', width:86,hide:true}">资本类型</th>
                  <th lay-data="{field:'registration', width:105}">成立日期</th>
                  <th lay-data="{field:'status', width:86, hide:true}">经营状态</th>
                  <th lay-data="{field:'province', width:86, hide:true}">所属省份</th>
                  <th lay-data="{field:'city', width:86}">所属城市</th>
                  <th lay-data="{field:'area', width:86, hide:true}">所属区县</th>
                  <th lay-data="{field:'type', width:115, hide:true}">公司类型</th>
                  <th lay-data="{field:'socialCode', width:140, hide:true}">社会信用代码</th>
                  <th lay-data="{field:'address', width:200, hide:true}">地址</th>
                  <th lay-data="{field:'webAddress', width:130, hide:true}">网址</th>
                  <th lay-data="{field:'businessScope'}">经营范围</th>
              </tr> 
            </thead>
            <tbody>
              @foreach($customers as $index => $customer)
              <tr>
                <td></td>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->company->name }}</td>
                <td>{{ $customer->company->contacted }}</td>
                <td>{{ $customer->company->follow }}</td>
                <td>{{ $customer->company->boss }}</td>
                <td>{{ $customer->company->money }}</td>
                <td>{{ $customer->company->moneyType }}</td>
                <td>{{ $customer->company->registration }}</td>
                <td>{{ $customer->company->status }}</td>
                <td>{{ $customer->company->province }}</td>
                <td>{{ $customer->company->city }}</td>
                <td>{{ $customer->company->area }}</td>
                <td>{{ $customer->company->type }}</td>
                <td>{{ $customer->company->socialCode }}</td>
                <td>{{ $customer->company->address }}</td>
                <td>{{ $customer->company->webAddress }}</td>
                <td>{{ $customer->company->businessScope }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        <div class="pagination-box">
        {!! $customers->appends(Request::except('page'))->render() !!}
        </div>
    </div>
</div>
@stop