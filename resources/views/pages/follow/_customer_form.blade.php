<form class="layui-form customer-form" id="customer-form" lay-filter="customer-form" method="POST" action="{{ route('customers.store') }}" style="display:none;margin: 10px 40px 10px 20px;">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" class="contract" lay-verify="contract" name="contract">
  <input type="hidden" class="company_id" name="company_id" value="{{ $follow->company->id }}">
  <div class="layui-row layui-col-space10">
      <div class="layui-col-xs7">
          <div class="layui-form-item">
            <div class="layui-input-block">
              <input type="text" name="contact" autocomplete="off" lay-verify="title" autocomplete="off" value="{{ old('contact',$follow->contact) }}" placeholder="关键联系人" class="layui-input">
            </div>
          </div>
        
          <div class="layui-form-item">
            <div class="layui-input-block">
              <input type="text" name="phone" autocomplete="off" autocomplete="off" value="{{ old('phone',$follow->phone) }}" placeholder="电话" class="layui-input">
            </div>
          </div>
        
          <div class="layui-form-item">
            <div class="layui-input-inline short-input">
              <input type="text" name="product" lay-verify="title" autocomplete="off" value="{{ old('product', $follow->product) }}" placeholder="成交产品" class="layui-input">
            </div>
            <div class="layui-input-inline short-input no-right">
              <input type="text" name="contract_money" lay-verify="number" autocomplete="off" value="{{ old('contract_money', $follow->contract_money) }}" placeholder="合同金额" class="layui-input">
            </div>
          </div>
        
          <div class="layui-form-item">
            <div class="layui-input-inline short-input">
                <input type="text" name="completion_date" autocomplete="off" lay-verify="date" class="layui-input" id="completion_date" value="{{ old('completion_date',$follow->expired) }}" placeholder="成交时间">
            </div>
            <div class="layui-input-inline short-input no-right">
                <input type="text" name="expired" autocomplete="off" lay-verify="date" class="layui-input" id="expired" value="{{ old('expired') }}" placeholder="售后到期">
            </div>
          </div>
      </div>
      <div class="layui-col-xs5">
          <div class="layui-upload-drag" id="contract">
            <i class="layui-icon"></i>
            <p>上传合同（只支持上传PDF或者RAR压缩文件，不超过10MB）</p>
          </div>
          <div class="upload-done">
            <ul></ul>
          </div>
      </div>
  </div>
   
  <div class="layui-form-item">
    <div class="layui-input-block">
        <textarea placeholder="项目备注信息" name="comment"  class="layui-textarea">{{ old('comment',$follow->difficulties) }}</textarea>
    </div>
  </div>
  <div class="layui-form-item">
      <div class="layui-input-block">
        <button class="layui-btn layui-btn-normal" lay-submit="" style="width: 100%;" lay-filter="more-info">确认，并转为正式客户</button>
      </div>
    </div>

  </form>