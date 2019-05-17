<form class="layui-form" id="customer-form" lay-filter="customer-form" style="display:none;margin: 10px 40px 10px 20px;">
    <div class="layui-form-item">
      <label class="layui-form-label">举报理由是</label>
      <div class="layui-input-block">
        <input type="radio" name="reason" lay-filter="reason" value="垃圾广告信息" title="垃圾广告信息">
        <input type="radio" name="reason" lay-filter="reason" value="违规类容" title="违规类容">
        <input type="radio" name="reason" lay-filter="reason" value="不友善内容" title="不友善内容">
        <input type="radio" name="reason" lay-filter="reason" value="其他理由" checked="" title="其他理由">
      </div>
    </div>

    <div class="layui-form-item layui-form-text">
      <input type="hidden" name="type" lay-verify="required" class="layui-input report-type">
    </div>
    <div class="layui-form-item layui-form-text">
      <input type="hidden" name="link" lay-verify="required" class="layui-input report-link">
    </div> 

    <div class="layui-form-item layui-form-text">
      <label class="layui-form-label">其他请补充</label>
      <div class="layui-input-block">
        <textarea placeholder="请输入内容" lay-verify="required" name="other" class="layui-textarea report-form-other"></textarea>
      </div>
    </div>

    <div class="layui-form-item">
      <div class="layui-input-block">
        <button class="layui-btn layui-btn-danger report-btn" lay-submit="" lay-filter="report-btn">确认举报</button>
      </div>
    </div>
  </form>