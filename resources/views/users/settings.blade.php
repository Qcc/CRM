@extends('layouts.app')
@section('title', '设置中心')

@section('content')
    <div class="layui-row" style="padding: 15px;background-color: #F2F2F2;">
        <div class="layui-col-xs10 layui-col-xs-offset1">
            <div class="layui-card">
              <div class="layui-card-header">个人资料</div>
              <div class="layui-card-body">
                卡片式面板面板通常用于非白色背景色的主体内<br>
                从而映衬出边框投影
              </div>
            </div>  
            <div class="layui-row layui-col-space15">
                <div class="layui-col-xs6">
                    <div class="layui-card">
                      <div class="layui-card-header">发件箱</div>
                      <div class="layui-card-body">
                          <table lay-filter="smtps-table" id="smtps-table" lay-filter="smtps-table">
                              <thead>
                                <tr>
                                    <th lay-data="{field:'id', width:80, hide:true}">ID</th>
                                    <th lay-data="{field:'name', width:100}">名称</th>
                                    <th lay-data="{field:'smtp', width:120}">服务器</th>
                                    <th lay-data="{field:'port', width:60}">端口</th>
                                    <th lay-data="{field:'username'}">用户名</th>
                                    <th lay-data="{field:'password', width:86, hide:true}">密码</th>
                                    <th lay-data="{field:'max', width:86}">发件数</th>
                                </tr> 
                              </thead>
                              <tbody>
                                @foreach($smtps as $index => $smtp)
                                <tr>
                                  <td>{{ $smtp->id }}</td>
                                  <td>{{ $smtp->name }}</td>
                                  <td>{{ $smtp->smtp }}</td>
                                  <td>{{ $smtp->port }}</td>
                                  <td>{{ $smtp->username }}</td>
                                  <td>{{ $smtp->password }}</td>
                                  <td>{{ $smtp->max }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="" title="添加SMTP服务器"><i class="layui-icon layui-icon-add-1"></i></a></td>
                                  </tr>
                              </tbody>
                            </table>
                      </div>
                    </div>
                </div>    
                
                <div class="layui-col-xs6">
                    <div class="layui-card">
                      <div class="layui-card-header">邮件模版</div>
                      <div class="layui-card-body">
                        卡片式面板面板通常用于非白色背景色的主体内<br>
                        从而映衬出边框投影
                      </div>
                    </div> 
                </div>    
            </div>
              
             
        </div>
    </div>
@stop