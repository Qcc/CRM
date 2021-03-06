<form class="layui-form" method="POST" action="{{ route('follow.store',$follow->id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" class="company_id" name="company_id" value="{{ $follow->company->id }}">
        <div class="layui-form-item">
          <div class="layui-input-block">
            <input type="text" name="contact" lay-verify="title" autocomplete="off" value="{{ old('contact',$follow->contact) }}" placeholder="关键联系人" class="layui-input">
          </div>
        </div>
        <div class="layui-form-item">
          <div class="layui-input-block">
            <input type="text" name="phone" lay-verify="phone" autocomplete="off" value="{{ old('phone',$follow->phone) }}" placeholder="电话" class="layui-input">
          </div>
        </div>
        <div class="layui-form-item">
          <div class="layui-input-inline short-input">
            <input type="text" name="product" lay-verify="title" autocomplete="off" value="{{ old('product', $follow->product) }}" placeholder="意向产品" class="layui-input">
          </div>
          <div class="layui-input-inline short-input no-right">
            <input type="text" name="contract_money" lay-verify="number" autocomplete="off" value="{{ old('contract_money', $follow->contract_money) }}" placeholder="预计金额" class="layui-input">
          </div>
        </div>
        <div class="layui-form-item">
          <div class="layui-input-inline short-input">
              <input type="text" name="expected_at" autocomplete="off" class="layui-input" id="expected_at" value="{{ old('expected_at', $follow->expected_at) }}" placeholder="预计成交时间">
          </div>
          <div class="layui-input-inline short-input no-right">
              <input type="text" name="schedule_at" autocomplete="off" class="layui-input" id="schedule_at" value="{{ old('schedule_at',$follow->schedule_at) }}" placeholder="下次联系提醒">
          </div>
        </div>
         
        <div class="layui-form-item">
          <div class="layui-input-block">
              <textarea placeholder="公关难点" autocomplete="off" name="difficulties"  class="layui-textarea">{{ old('difficulties',$follow->difficulties) }}</textarea>
          </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn layui-btn-normal" lay-submit="" style="width: 100%;" lay-filter="more-info">保存信息</button>
            </div>
          </div>
    </form>