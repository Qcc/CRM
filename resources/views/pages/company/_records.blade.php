@if(count($records) == 0)
<p class="color-drak">该客户还没有联系过，加油↖(^ω^)↗!!!</p>
@else
<ul class="layui-timeline">
    @foreach($records as $record)
      <li class="layui-timeline-item">
        <i class="layui-icon layui-timeline-axis"></i>
        <div class="layui-timeline-content layui-text">
          <h3 class="layui-timeline-title">{{ $record->created_at }}</h3>
          <div class="rich-text-body">
            {!! $record->content !!}
          </div>
        </div>
      </li>
    @endforeach
</ul> 
@endif