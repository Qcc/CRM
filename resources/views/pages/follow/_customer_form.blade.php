<form class="layui-form customer-form" id="customer-form" lay-filter="customer-form" method="POST" action="{{ route('customers.store') }}" style="display:none;margin: 10px 40px 10px 20px;">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

          <div class="layui-form-item" id="aetherupload-wrapper"><!--组件最外部需要一个名为aetherupload-wrapper的id，用以包装组件-->
            <div class="controls">
                <div class="layui-upload-drag upload-contract-warp">
                    <i class="layui-icon layui-icon-upload"></i>
                    <p>点击上传合同(只支持PDF或者RAR文件上传)</p>
                  </div>

                <input type="file" style="display: none;" id="aetherupload-resource" onchange="aetherupload(this).setGroup('contract').setSavedPathField('#aetherupload-savedpath').setPreprocessRoute('/aetherupload/preprocess').setUploadingRoute('/aetherupload/uploading').success(uploadDoneCallback).upload();"/>
                <!--需要一个名为aetherupload-resource的id，用以标识上传的文件，setGroup(...)设置分组名，setSavedPathField(...)设置资源存储路径的保存节点，setPreprocessRoute(...)设置预处理路由，setUploadingRoute(...)设置上传分块路由，success(...)可用于声名上传成功后的回调方法名。默认为选择文件后触发上传，也可根据需求手动更改为特定事件触发，如点击提交表单时-->
                <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 200px;">
                    <div id="aetherupload-progressbar" style="background:#5FB878;height:6px;width:0;"></div><!--需要一个名为aetherupload-progressbar的id，用以标识进度条-->
                </div>
                <span style="font-size:12px;color:#aaa;" id="aetherupload-output"></span><!--需要一个名为aetherupload-output的id，用以标识提示信息-->
                <input type="hidden" lay-verify="contract" name="contract" id="aetherupload-savedpath"><!--需要一个自定义名称的id，以及一个自定义名称的name值, 用以标识资源储存路径自动填充位置，默认id为aetherupload-savedpath，可根据setSavedPathField(...)设置为其它任意值-->
            </div>
            <div id="upload-contract-result"></div>
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
        <button class="layui-btn layui-btn-normal layui-btn-fluid" lay-submit="" lay-filter="more-info">确认，并转为正式客户</button>
      </div>
    </div>

  </form>

    