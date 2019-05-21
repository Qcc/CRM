<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree"  lay-filter="test">
          <li class="layui-nav-item" lay-unselect><a href="javascript:void(0)">目标客户( {{ count($companys) }}家 )</a></li>
          @foreach($companys as $company)
          <li class="layui-nav-item {{ active_class(if_route_param('company', $company->id),'layui-this') }}" lay-unselect><a href="{{ route('company.show',$company->id) }}" title="{{ $company->name }}">{{ $company->name }}</a></li>
          @endforeach
        </ul>
    </div>
</div>