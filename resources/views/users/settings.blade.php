@extends('layouts.app')
@section('title', '设置中心')

@section('content')
<div class="layui-row layui-col-space10" style="padding: 15px;background-color: #F2F2F2;">
    <div class="layui-col-xs2 layui-col-xs-offset1">
        <div class="layui-card">
          <div class="layui-card-header">个人资料</div>
          <div class="layui-card-body">
              <div class="layui-upload">
                <div class="layui-upload-list">
                  <img class="layui-upload-img" src="{{ Auth::user()->avatar }}" id="avatar">
                  <p id="demoText"></p>
                </div>
                <button type="button" class="layui-btn" id="test1">上传头像</button>
              </div>
              <div class="userinfo">
                <p>姓名：<span>{{ Auth::user()->name }}</span></p>
                <p>邮箱：<span>{{ Auth::user()->email }}</span></p>
              </div>
          </div>
        </div>
    </div>  
    <div class="layui-col-xs8">
        <div class="layui-card">
          <div class="layui-card-header">
              <div class="layui-row">
                <div class="layui-col-xs6">发件箱</div>
                <div class="layui-col-xs6" style="text-align: right;">
                  <a class="storeSmtp-action" href="javascript:;" title="添加SMTP服务器"><i class="layui-icon layui-icon-add-1"></i></a>
                </div>
              </div>
          </div>
          <div class="layui-card-body">
              <table lay-filter="smtps-table" id="smtps-table" lay-filter="smtps-table">
                  <thead>
                    <tr>
                        <th lay-data="{field:'id',hide:true}">ID</th>
                        <th lay-data="{field:'name', width:150}">名称</th>
                        <th lay-data="{field:'smtp'}">服务器</th>
                        <th lay-data="{field:'port', width:60}">端口</th>
                        <th lay-data="{field:'username', width:150}">用户名</th>
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
                      <td></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
          </div>
        </div>
    
        <div class="layui-card">
          <div class="layui-card-header">邮件模版</div>
          <div class="layui-card-body">
            卡片式面板面板通常用于非白色背景色的主体内<br>
            从而映衬出边框投影
          </div>
        </div> 
    </div>    
</div>

<form class="layui-form editSmtp-form" method="POST" lay-filter="editSmtp" id="editSmtp" style="display:none;margin: 10px 10px 10px 20px;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id">  
    
    <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="name" lay-verify="title" autocomplete="off" placeholder="名称" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="smtp" lay-verify="required|title" autocomplete="off" placeholder="SMTP服务器" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="port" lay-verify="required|number" autocomplete="off" placeholder="端口" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="username" lay-verify="required|title" autocomplete="off" placeholder="用户名" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="password" lay-verify="required|title" autocomplete="off" placeholder="授权码" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="max" lay-verify="required|number" autocomplete="off" placeholder="每天最大发信量" class="layui-input">
          </div>
      </div>
      
      <div class="layui-form-item">
          <div class="layui-input-block" style="text-align: right">
            <button class="layui-btn" onclick='event.preventDefault();
            var formSave = document.getElementById("editSmtp");formSave.action="{{ route('smtp.edit') }}";formSave.submit()'>保存</button>
            <button class="layui-btn  layui-btn-danger" onclick='event.preventDefault();
            var formDel = document.getElementById("editSmtp");formDel.action="{{ route('smtp.destroy') }}";formDel.submit();'>删除</button>
        </div>
    </div>
</form>
<form class="layui-form editSmtp-form" method="POST" lay-filter="storeSmtp" id="storeSmtp" action="{{ route('smtp.store') }}" style="display:none;margin: 10px 10px 10px 20px;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="name" lay-verify="required|title" autocomplete="off" placeholder="名称" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="smtp" lay-verify="required|title" autocomplete="off" placeholder="SMTP服务器" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="port" lay-verify="required|number" autocomplete="off" placeholder="端口" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="username" lay-verify="required|title" autocomplete="off" placeholder="用户名" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="password" lay-verify="required|title" autocomplete="off" placeholder="授权码" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <div class="layui-input-block">
              <input type="text" name="max" lay-verify="required|number" autocomplete="off" value="100" placeholder="每天最大发信量" class="layui-input">
          </div>
      </div>
      
      <div class="layui-form-item">
          <div class="layui-input-block" style="text-align: right">
            <button class="layui-btn" lay-submit="" lay-filter="storeSmtp-btn">新增</button>
        </div>
    </div>
</form>
@stop