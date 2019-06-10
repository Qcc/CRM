<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>报表统计-{{ $scope }} - 深圳市沟通科技有限公司</title>

  <!-- Styles -->
 
  <style>
body{
  margin: 0;
  padding: 0;
  background-color: #F2F2F2;
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #212529;
  text-align: left;
}
table {
  display: table;
  border-collapse: separate;
  border-spacing: 2px;
  border-color: grey;
}
thead {
  display: table-header-group;
  vertical-align: middle;
  border-color: inherit;
}
tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.05);
}
.table-info, .table-info>td, .table-info>th {
    background-color: #bee5eb;
}
tbody {
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit;
}
.body{
    margin: 20px 50px;
}
.table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
}
a{
    text-decoration: none;
}
  </style>
  
</head>

<body>
    <div class="body">
    <div id="topAnchor"></div>
    <h2>统计区间({{ $scope }})</h2>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">序号</th>
            <th scope="col">姓名</th>
            <th scope="col">拨打电话</th>
            <th scope="col">有效商机</th>
            <th scope="col">拨打效率</th>
            <th scope="col">成交客户</th>
            <th scope="col">跟进效率</th>
            <th scope="col">成交金额</th>
          </tr>
        </thead>
        <tbody>
        @foreach($statistics as $line)
        @if (!$loop->last)
        <tr>
          <th scope="row">{{ $line->id }}</th>
          <td> {{ $line->name }}</td>
          <td> <a href="#{{$line->name}}-callCount">{{ $line->callCount }}</a></td>
          <td> <a href="#{{$line->name}}-businessCount">{{ $line->businessCount }}</a></td>
          <td> {{ $line->busEfficiency }}%</td>
          <td> <a href="#{{$line->name}}-cusCount">{{ $line->cusCount }}</a></td>
          <td> {{ $line->cusEfficiency }}%</td>
          <td> ￥{{ $line->money }}</td>
        </tr>
        @else
        <tr class="table-info">
            <td colspan="7">{{ $line->name}}</td>
            <td>￥{{ $line->total}}</td>
        </tr>
        @endif
        @endforeach
        </tbody>
    </table>
    @foreach($details as $index => $employee)
    <h3>详细信息({{ $employee->user->name }})</h3>
    <h5 id="{{ $employee->user->name }}-callCount">拨打电话</h5>
    <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">公司名称</th>
                <th scope="col">拨打反馈</th>
                <th scope="col">情况说明</th>
                <th scope="col">拨打时间</th>
              </tr>
            </thead>
            <tbody>
            @foreach($employee->records as $index => $record)
            <tr>
              <td> {{ $record->company->name }}</td>
              <td> {{ callResult($record->feed) }}</td>
              <td> {!! $record->content !!}</td>
              <td> {{ $record->created_at }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    <h5 id="{{ $employee->user->name }}-businessCount">有效商机</h5>
    <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">公司名称</th>
                <th scope="col">联系人</th>
                <th scope="col">意向产品</th>
                <th scope="col">预计成交金额</th>
                <th scope="col">公关难点</th>
                <th scope="col">预计成交时间</th>
              </tr>
            </thead>
            <tbody>
            @foreach($employee->follows as $index => $follow)
            <tr>
              <td> {{ $follow->company->name }}</td>
              <td> {{ $follow->contact }}</td>
              <td> {{ $follow->product }}</td>
              <td> {{ $follow->contract_money }}</td>
              <td> {!! $follow->difficulties !!}</td>
              <td> {{ $follow->expected_at }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    <h5 id="{{ $employee->user->name }}-cusCount">成交客户</h5>
    <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">公司名称</th>
                <th scope="col">联系人</th>
                <th scope="col">成交产品</th>
                <th scope="col">成交金额</th>
                <th scope="col">成交说明</th>
                <th scope="col">合同下载</th>
                <th scope="col">售后到期</th>
              </tr>
            </thead>
            <tbody>
            @foreach($employee->customers as $index => $customer)
            <tr>
              <td> {{ $customer->company->name }}</td>
              <td> {{ $customer->contact }}</td>
              <td> {{ $customer->product }}</td>
              <td> {{ $customer->contract_money }}</td>
              <td> {!! $customer->comment !!}</td>
              <td> <a href="{{ $customer->contract }}">下载</a></td>
              <td> {{ $customer->expired_at }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
    </div>
    <a href="#topAnchor" style="position:fixed;right:20px;bottom:30px">回到顶部</a>
</div>
</body>
</html>