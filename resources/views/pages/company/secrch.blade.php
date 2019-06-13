@extends('layouts.app')
@section('title', '公海目标')

@section('content')
  <div class="layui-row">
    <div class="layui-col-xs10 layui-col-xs-offset1">
          <form class="layui-form" method="GET" lay-filter="secrchTarget" action="{{ route('company.secrch') }}">
              <div class="layui-form-item">
                <div class="layui-row">
                  <div class="layui-col-xs8">
                      <label class="layui-form-label">关键字查询</label>
                      <div class="layui-input-block" style="margin-right: 10px;">
                        <input type="text" name="key" lay-verify="title" autocomplete="off" placeholder="请输入公司名称、行业、注册城市、经营范围等" class="layui-input">
                      </div>
                    </div>
                    <div class="layui-col-xs4">
                      <div class="layui-input-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1">查询</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                      </div>
                    </div>
                </div>
              </div>

              <div class="layui-form-item">
                  <label class="layui-form-label" title="公司注册所属城市">所属市区</label>
                  <div class="layui-input-inline">
                    <select name="city">
                      <option value="">请选择市</option>
                      <option value="深圳市" selected="">深圳市</option>
                      <option value="北京市">北京市</option>
                    </select>
                  </div>
                  <div class="layui-input-inline" title="目标客户是否有业务员跟进过，电话、邮件、拜访等">
                      <label class="layui-form-label">跟进记录</label>
                      <div class="layui-input-block">
                        <input type="checkbox" name="contacted" lay-skin="switch" lay-text="有|无">
                      </div>
                    </div>
                </div>
                
              <div class="layui-form-item" title="公司注册成立时间">
                  <label class="layui-form-label">成立时间</label>
                  <div class="layui-input-block">
                    <input type="radio" name="registration" value="0-1" title="成立1年内">
                    <input type="radio" name="registration" value="1-5" title="成立1~5年">
                    <input type="radio" name="registration" value="5-10" title="成立5~10年">
                    <input type="radio" name="registration" value="10-15" title="成立10~15年">
                    <input type="radio" name="registration" value="15-999" title="成立15年以上">
                  </div>
              </div>

              <div class="layui-form-item" title="公司注册资金规模">
                  <label class="layui-form-label">注册资金</label>
                  <div class="layui-input-block" >
                    <input type="radio" name="money" value="0-100" title="0~100万">
                    <input type="radio" name="money" value="101-200" title="101~200万">
                    <input type="radio" name="money" value="201-500" title="201~500万">
                    <input type="radio" name="money" value="501-1000" title="501~1000万">
                    <input type="radio" name="money" value="1001-999999" title="1000万以上">
                  </div>
              </div>

              <div class="layui-form-item" title="公司所属行业分类">
                  <label class="layui-form-label">行业分类</label>
                  <div class="layui-input-block" >
                      <input type="radio" name="businessScope" value="电力,热力,燃气,水生产,水供应" title="电力、热力、燃气及水生产和供应业">
                      <input type="radio" name="businessScope" value="建筑" title="建筑业">
                      <input type="radio" name="businessScope" value="批发,零售" title="批发和零售业">
                      <input type="radio" name="businessScope" value="交通,运输,仓储,邮政" title="交通运输、仓储和邮政业">
                      <input type="radio" name="businessScope" value="农,林,牧,渔" title="农、林、牧、渔业">
                      <input type="radio" name="businessScope" value="采矿" title="采矿业">
                      <input type="radio" name="businessScope" value="制造" title="制造业">
                      <input type="radio" name="businessScope" value="租赁,商务服务" title="租赁和商务服务业">
                      <input type="radio" name="businessScope" value="科学研究,技术服务" title="科学研究和技术服务业">
                      <input type="radio" name="businessScope" value="水利,环境,公共设施管理" title="水利、环境和公共设施管理业">
                      <input type="radio" name="businessScope" value="居民服务,修理,其他服务" title="居民服务、修理和其他服务业">
                      <input type="radio" name="businessScope" value="住宿,餐饮" title="住宿和餐饮业">
                      <input type="radio" name="businessScope" value="信息传输,软件,信息技术服务" title="信息传输、软件和信息技术服务业">
                      <input type="radio" name="businessScope" value="金融," title="金融业">
                      <input type="radio" name="businessScope" value="房地产," title="房地产业">
                      <input type="radio" name="businessScope" value="国际组织卫生,社会工作" title="国际组织卫生和社会工作">
                      <input type="radio" name="businessScope" value="教育" title="教育">
                      <input type="radio" name="businessScope" value="公共管理,社会保障,社会组织" title="公共管理、社会保障和社会组织">
                      <input type="radio" name="businessScope" value="文化,体育,娱乐" title="文化、体育和娱乐业">
                </div>
              </div>
              
              <table lay-filter="companys-table" id="companys-table" lay-filter="companys-table">
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
                    @foreach($companys as $index => $company)
                    <tr>
                      <td></td>
                      <td>{{ $company->id }}</td>
                      <td>{{ $company->name }}</td>
                      <td>{{ $company->contacted }}</td>
                      <td>{{ $company->follow }}</td>
                      <td>{{ $company->boss }}</td>
                      <td>{{ $company->money }}</td>
                      <td>{{ $company->moneyType }}</td>
                      <td>{{ $company->registration }}</td>
                      <td>{{ $company->status }}</td>
                      <td>{{ $company->province }}</td>
                      <td>{{ $company->city }}</td>
                      <td>{{ $company->area }}</td>
                      <td>{{ $company->type }}</td>
                      <td>{{ $company->socialCode }}</td>
                      <td>{{ $company->address }}</td>
                      <td>{{ $company->webAddress }}</td>
                      <td>{{ $company->businessScope }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
          <div class="pagination-box">
            @if($companys)
              {!! $companys->appends(Request::except('page'))->render() !!}
            @endif
          </div>
    </div>
  </div>
  <script type="text/html" id="toolbarTarget">
    <div class="layui-btn-container">
      <button class="layui-btn layui-btn-sm" id="getcompany">我来跟进</button>
    </div>
  </script>
@stop