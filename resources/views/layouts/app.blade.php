<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', '沟通科技商机管理') - 深圳市沟通科技有限公司</title>

  <!-- Styles -->
  <link href="/layui/css/layui.css" rel="stylesheet">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>

<body class="layui-layout-body">
  <div id="app" class="{{ route_class() }}-page layui-layout layui-layout-admin">
      @include('layouts._header')
      <div class="layui-body">
        @include('shared._messages')
        @yield('content')
      </div>
      @include('layouts._footer')
  </div>
  <!-- Scripts -->
  <script src="/layui/layui.js"></script>
  <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>