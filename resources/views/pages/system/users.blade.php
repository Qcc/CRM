@extends('layouts.app')
@section('title', '设置中心')

@section('content')
    <div class="layui-row">
        <div class="layui-col-xs10 layui-col-xs-offset1">
                <form class="layui-form" method="get" action="{{ route('system.users') }}">
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <input type="text" name="name" lay-verify="required|title" autocomplete="off" placeholder="请输入姓名"
                                class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <button class="layui-btn" lay-submit="" lay-filter="search-user">查找用户</button>
                        </div>
                    </div>
                </form>
                <table lay-filter="users-table" id="users-table">
                    <thead>
                        <tr>
                            <th lay-data="{field:'id', width:50}">ID</th>
                            <th lay-data="{field:'avatar', width:60}">头像</th>
                            <th lay-data="{field:'name', width:150}">姓名</th>
                            <th lay-data="{field:'delete_at', width:150}">状态</th>
                            <th lay-data="{field:'email', width:250}">邮箱</th>
                            <th lay-data="{field:'created_at', minWidth: 180}">注册时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><img src="{{ $user->avatar }}" alt="头像" style="width:24px;height:24px"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->delete_at }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            <div class="pagination-box">
                    {!! $users->appends(Request::except('page'))->render() !!}
            </div>
        </div>
    </div>

<form class="layui-form" method="POST" id="user-form" action="{{ route('user.setStore') }}" lay-filter="user-form" style="display:none;margin-right: 80px;">
    <input type="hidden" name="id">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="layui-form-item">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-block">
            <input type="text" name="name" autocomplete="off" placeholder="请输入姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-block">
            <input type="text" name="email" autocomplete="off" placeholder="请输入邮箱" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="text" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item" pane="">
        <div class="layui-input-block">
            <input type="radio" name="delete_at" value="1" title="正常">
            <input type="radio" name="delete_at" value="0" title="禁用">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn submit" lay-submit="" lay-filter="form-btn">确认修改</button>
        </div>
    </div>
</form>

@stop