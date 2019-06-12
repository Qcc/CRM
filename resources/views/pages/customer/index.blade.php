@extends('layouts.app')
@section('title', '我的客户')

@section('content')
<div class="layui-row">
    <div class="layui-col-xs10 layui-col-xs-offset1">
        <table lay-filter="customers-table" id="customers-table" lay-filter="customers-table">
            <thead>
              <tr>
                  <th lay-data="{type:'checkbox', fixed: 'left'}"></th>
                  <th lay-data="{field:'id', width:80, hide:true}">序号</th>
                  <th lay-data="{field:'name', width:200}">公司</th>
                  <th lay-data="{field:'user', width:80, hide:true}">销售</th>
                  <th lay-data="{field:'check', width:100,templet: function(d){ 
                    if(d.check == 'delete'){
                      return '<span class=color-drak>已删除</span>';
                    }else if(d.check == 'dismissed'){
                      return '<span class=color-red>已驳回</span>';
                    }else if(d.check == 'complate'){
                      return '<span class=color-gre>已完成</span>';
                    }else if(d.check == 'check'){
                      return '<span class=color-ind>审核中</span>';
                    }else{
                      return '无';
                    } }}">审核</th>
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
                  <th lay-data="{field:'follow_id',width:80, hide:true}">订单ID</th>               
                  <th lay-data="{field:'company_id',width:80, hide:true}">公司ID</th>               
                  <th lay-data="{field:'contact',width:80, hide:true}">联系人</th>
                  <th lay-data="{field:'phone',width:120, hide:true}">电话</th>
                  <th lay-data="{field:'product',width:100}">已购产品</th>
                  <th lay-data="{field:'contract',width:100,templet: function(d){
                    return '<a class=download href=' + d.contract + '>' + d.contract.substr((d.contract.lastIndexOf('/')) + 1) + '</a>'
                    }}">合同</th>
                  <th lay-data="{field:'completion_at',width:105, hide:true}">购买日期</th>
                  <th lay-data="{field:'expired_at',width:105}">续费/售后到期</th>
                  <th lay-data="{field:'contract_money',width:100}">合同金额</th>
                  <th lay-data="{field:'comment'}">项目备注</th>
                  <th lay-data="{field:'boss', hide:true, width:80}">公司法人</th>
                  <th lay-data="{field:'money', hide:true, width:86,templet: function(d){return d.money+'万'} }">注册资金</th>
                  <th lay-data="{field:'moneyType', hide:true, width:86,hide:true}">资本类型</th>
                  <th lay-data="{field:'registration', hide:true, width:105}">成立日期</th>
                  <th lay-data="{field:'status', width:86, hide:true}">经营状态</th>
                  <th lay-data="{field:'province', width:86, hide:true}">所属省份</th>
                  <th lay-data="{field:'city', width:86, hide:true}">所属城市</th>
                  <th lay-data="{field:'area', width:86, hide:true}">所属区县</th>
                  <th lay-data="{field:'type', width:115, hide:true}">公司类型</th>
                  <th lay-data="{field:'socialCode', width:140, hide:true}">社会信用代码</th>
                  <th lay-data="{field:'address', width:200, hide:true}">地址</th>
                  <th lay-data="{field:'webAddress', width:130, hide:true}">网址</th>
                  <th lay-data="{field:'businessScope', hide:true,}">经营范围</th>
                  <th lay-data="{fixed: 'right', width:120,toolbar:'#customersEdit'}">操作</th>
              </tr> 
            </thead>
            <tbody>
              @foreach($customers as $index => $customer)
              <tr>
                <td></td>
                <td>{{ $customer->id }}</td>
                <td> <a href="{{ route('customer.show',$customer->id) }}">{{ $customer->company->name }}</a></td>
                <td>{{ $customer->user->name }}</td>
                <td>{{ $customer->check }}</td>
                <td>{{ $customer->company->contacted }}</td>
                <td>{{ $customer->company->follow }}</td>
                <td>{{ $customer->follow_id }}</td>
                <td>{{ $customer->company->id }}</td>
                <td>{{ $customer->contact  }}</td>
                <td>{{ $customer->phone  }}</td>
                <td>{{ $customer->product  }}</td>
                <td>{{ $customer->contract  }}</td>
                <td>{{ $customer->completion_at  }}</td>
                <td>{{ $customer->expired_at  }}</td>
                <td>{{ $customer->contract_money  }}</td>
                <td>{{ $customer->comment  }}</td>
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
<div id="customersEdit-box">

</div>
<script type="text/html" id="toolbarTarget">
  <form class="layui-form">
    <div class="layui-form-item">
      <div class="layui-input-inline">
        <input type="text" name="name" placeholder="请输入公司名称" autocomplete="off" class="layui-input">
      </div>
      <div class="layui-input-inline" style="width: 250px;">
        <button class="layui-btn" lay-submit lay-filter="">查找</button>
        @can('manager')
        <button class="layui-btn layui-btn-normal" type='button' lay-event="CheckStatus">审核</button>
        @endcan
      </div>
    </div>
  </form>
</script>
<form id="check-form" action="{{ route('customers.check') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
    <input id='check-ids' type="hidden" name="ids">
    <input id='check-type' type="hidden" name="type">
</form>
<form id="destroy-form" action="{{ route('customers.destroy') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
    <input id='destroy-id' type="hidden" name="id">
</form>
<form id="restore-form" action="{{ route('customers.restore') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
    <input id='restore-id' type="hidden" name="id">
</form>
<form id="agent-form" action="{{ route('follow.agent') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
    <input id='follow_id' type="hidden" name="follow_id">
    <input id='customer_id' type="hidden" name="customer_id">
</form>
@stop
@include('pages.customer._customer_form')
@section('script')
<script type="text/javascript" src="{{ asset('lib/scripts/jquery.min.js') }}"></script>
<!-- aetherupload文件上传组件 -->
<script src="{{ URL::asset('vendor/aetherupload/js/spark-md5.min.js') }}"></script>
<!--需要引入spark-md5.min.js-->
<script src="{{ URL::asset('vendor/aetherupload/js/aetherupload.js') }}"></script>
<!--需要引入aetherupload.js-->
@stop