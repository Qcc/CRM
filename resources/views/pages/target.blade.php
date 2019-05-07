@extends('layouts.app')
@section('title', '公海目标')

@section('content')
  <div class="layui-row">
    <div class="layui-col-xs10 layui-col-xs-offset1">
      <div class="grid-demo grid-demo-bg1">
          <form class="layui-form" action="">
              <div class="layui-form-item">
                <label class="layui-form-label">关键字查询</label>
                <div class="layui-input-block">
                  <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                </div>
              </div>

              <div class="layui-form-item">
                  <label class="layui-form-label">所属市区</label>
                  <div class="layui-input-inline">
                    <select name="city">
                      <option value="">请选择市</option>
                      <option value="杭州">深圳</option>
                      <option value="宁波">北京</option>
                      <option value="温州">上海</option>
                      <option value="温州">广州</option>
                      <option value="温州">武汉</option>
                      <option value="温州">杭州</option>
                      <option value="温州">成都</option>
                      <option value="温州">西安</option>
                    </select>
                  </div>
                </div>
                
              <div class="layui-form-item">
                  <label class="layui-form-label">成立时间</label>
                  <div class="layui-input-block">
                    <input type="radio" name="registration" value="1" title="成立1年内">
                    <input type="radio" name="registration" value="5" title="成立1~5年">
                    <input type="radio" name="registration" value="10" title="成立5~10年">
                    <input type="radio" name="registration" value="15" title="成立10~15年">
                    <input type="radio" name="registration" value="16" title="成立15年以上">
                  </div>
              </div>

              <div class="layui-form-item">
                  <label class="layui-form-label">注册资金</label>
                  <div class="layui-input-block">
                    <input type="radio" name="money" value="100" title="0~100万">
                    <input type="radio" name="money" value="200" title="100~200万">
                    <input type="radio" name="money" value="500" title="200~500万">
                    <input type="radio" name="money" value="1000" title="500~1000万">
                    <input type="radio" name="money" value="1001" title="1000万以上">
                  </div>
              </div>

              <div class="layui-form-item">
                  <label class="layui-form-label">行业分类</label>
                  <div class="layui-input-block">
                      <input type="radio" name="businessScope" value="1" title="电力、热力、燃气及水生产和供应业">
                      <input type="radio" name="businessScope" value="2" title="建筑业">
                      <input type="radio" name="businessScope" value="3" title="批发和零售业">
                      <input type="radio" name="businessScope" value="4" title="交通运输、仓储和邮政业">
                      <input type="radio" name="businessScope" value="5" title="农、林、牧、渔业">
                      <input type="radio" name="businessScope" value="6" title="采矿业">
                      <input type="radio" name="businessScope" value="7" title="制造业">
                      <input type="radio" name="businessScope" value="8" title="租赁和商务服务业">
                      <input type="radio" name="businessScope" value="9" title="科学研究和技术服务业">
                      <input type="radio" name="businessScope" value="10" title="水利、环境和公共设施管理业">
                      <input type="radio" name="businessScope" value="11" title="居民服务、修理和其他服务业">
                      <input type="radio" name="businessScope" value="12" title="住宿和餐饮业">
                      <input type="radio" name="businessScope" value="13" title="信息传输、软件和信息技术服务业">
                      <input type="radio" name="businessScope" value="14" title="金融业">
                      <input type="radio" name="businessScope" value="15" title="房地产业">
                      <input type="radio" name="businessScope" value="16" title="国际组织卫生和社会工作">
                      <input type="radio" name="businessScope" value="17" title="教育">
                      <input type="radio" name="businessScope" value="18" title="公共管理、社会保障和社会组织">
                      <input type="radio" name="businessScope" value="20" title="文化、体育和娱乐业">
                </div>
              </div>
              
              <table lay-filter="parse-table-demo">
                  <thead>
                    <tr>
                      <th lay-data="{field:'username', width:200}">昵称</th>
                      <th lay-data="{field:'joinTime', width:150}">加入时间</th>
                      <th lay-data="{field:'sign', minWidth: 180}">签名</th>
<th lay-data="{field:'id', width:200}">ID</th>
<th lay-data="{field:'company', width:200}">公司</th>
<th lay-data="{field:'boss', width:200}">法人</th>
<th lay-data="{field:'money', width:200}">注册资金</th>
<th lay-data="{field:'registration', width:200}">成立日期</th>
<th lay-data="{field:'province', width:200}">所属省份</th>
<th lay-data="{field:'city', width:200}">所属城市</th>
<th lay-data="{field:'type', width:200}">公司类型</th>
<th lay-data="{field:'businessScope', width:200}">经营范围</th>
                    </tr> 
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>深圳市瑞房网络有限公司</td>
                      <td>王林波</td>
                      <td>100万人民币</td>
                      <td>2016-10-13</td>
                      <td>广东省</td>
                      <td>深圳市</td>
                      <td>有限责任公司</td>
                      <td>房地产开发（在合法取得土地使用权的范围内进行房地产开发），投资市场营销策划、销售代理、装修设计、房地产经纪服务、物业租售信息服务、物业管理；网络科技研发设计；广告设计与策划；装饰材料、五金材料的销售；国内贸易。(法律、行政法规、国务院决定规定在登记前须经批准的项目除外）^室内外装修工程、园林绿化工程的...</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>深圳市瑞房网络有限公司</td>
                      <td>王林波</td>
                      <td>100万人民币</td>
                      <td>2016-10-13</td>
                      <td>广东省</td>
                      <td>深圳市</td>
                      <td>有限责任公司</td>
                      <td>房地产开发（在合法取得土地使用权的范围内进行房地产开发），投资市场营销策划、销售代理、装修设计、房地产经纪服务、物业租售信息服务、物业管理；网络科技研发设计；广告设计与策划；装饰材料、五金材料的销售；国内贸易。(法律、行政法规、国务院决定规定在登记前须经批准的项目除外）^室内外装修工程、园林绿化工程的...</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>深圳市瑞房网络有限公司</td>
                      <td>王林波</td>
                      <td>100万人民币</td>
                      <td>2016-10-13</td>
                      <td>广东省</td>
                      <td>深圳市</td>
                      <td>有限责任公司</td>
                      <td>房地产开发（在合法取得土地使用权的范围内进行房地产开发），投资市场营销策划、销售代理、装修设计、房地产经纪服务、物业租售信息服务、物业管理；网络科技研发设计；广告设计与策划；装饰材料、五金材料的销售；国内贸易。(法律、行政法规、国务院决定规定在登记前须经批准的项目除外）^室内外装修工程、园林绿化工程的...</td>
                    </tr>
                    
                  </tbody>
                </table>
              
      </div>
    </div>
  </div>
@stop