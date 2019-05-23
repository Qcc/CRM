<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree"  lay-filter="test">
          <li class="layui-nav-item" lay-unselect><a href="javascript:void(0)">客户跟进( {{ count($follows) }}家 )</a></li>
          @foreach($follows as $follow)
          <li class="layui-nav-item {{ active_class(if_route_param('follow', $follow->id),'layui-this') }}" lay-unselect><a href="{{ route('follow.show',$follow->id) }}" title="{{ $follow->company->name }}">{{ $follow->company->name }}</a></li>
          @endforeach
        </ul>
    </div>
</div>