@extends('layouts.app')
@section('title', '公海目标')

@section('content')
  <div class="layui-row">
    <div class="layui-col-xs10 layui-col-xs-offset1">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-normal" id="testList">选择多文件</button> 
            <div class="layui-upload-list">
              <table class="layui-table">
                <thead>
                  <tr><th>文件名</th>
                  <th>大小</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr></thead>
                <tbody id="demoList"></tbody>
              </table>
            </div>
            <button type="button" class="layui-btn" id="uploadAction">开始上传</button>
          </div> 
    </div>
</div>

@stop