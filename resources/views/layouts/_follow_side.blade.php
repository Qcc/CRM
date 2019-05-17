<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree"  lay-filter="test">
          <li class="layui-nav-item" lay-unselect><a href="javascript:void(0)">客户跟进( {{ count($companys) }}家 )</a></li>
          @foreach($companys as $company)
          <li class="layui-nav-item" lay-unselect><a href="{{ route('follow.show',$company->id) }}" title="{{ $company->name }}">{{ $company->name }}</a></li>
          @endforeach
        </ul>
    </div>
</div>