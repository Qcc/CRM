
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

layui.use(['element','form','table','upload', 'util', 'laydate', 'layer',], function(){
    var $ = layui.$;
    var element = layui.element;
    var upload = layui.upload;
    var form = layui.form;
    var table = layui.table;
    var util = layui.util;
    var laydate = layui.laydate;
    var layer = layui.layer;
  
    // flash 提示信息关闭
    $('.alert>i').on('click',function(){
     $('.flash-message').remove(); 
    });
    //  cookie操作
    var cookie = {
      set: function (key, val, time) { //设置cookie方法
        time = time || 30;
        var date = new Date(); //获取当前时间
        var expiresDays = time; //将date设置为n天以后的时间
        date.setTime(date.getTime() + expiresDays * 24 * 3600 * 1000); //格式化为cookie识别的时间
        document.cookie = key + "=" + val + ";expires=" + date.toGMTString(); //设置cookie
      },
      get: function (key) { //获取cookie方法
        /*获取cookie参数*/
        var getCookie = document.cookie.replace(/[ ]/g, ""); //获取cookie，并且将获得的cookie格式化，去掉空格字符
        var arrCookie = getCookie.split(";") //将获得的cookie以"分号"为标识 将cookie保存到arrCookie的数组中
        var tips = null; //声明变量tips
        for (var i = 0; i < arrCookie.length; i++) { //使用for循环查找cookie中的tips变量
          var arr = arrCookie[i].split("="); //将单条cookie用"等号"为标识，将单条cookie保存为arr数组
          if (key == arr[0]) { //匹配变量名称，其中arr[0]是指的cookie名称，如果该条变量为tips则执行判断语句中的赋值操作
            tips = arr[1]; //将cookie的值赋给变量tips
            break; //终止for循环遍历
          }
        }
        return tips;
      },
      del: function (key) { //删除cookie方法
        var date = new Date(); //获取当前时间
        date.setTime(date.getTime() - 10000); //将date设置为过去的时间
        document.cookie = key + "=v; expires =" + date.toGMTString(); //设置cookie
      }
    }
    // 修改密码
    $('#password-btn').on('click',function(){
      layer.open({
        type: 1,
        area: '500px',
        shade: 0,
        anim: 1,
        title: '添加用户',
        content: $('#user-password'),
      });
      // 表单验证
      form.verify({
        password: [
        /^[\S]{6,25}$/
        ,'密码必须6到25位，且不能出现空格'
        ],
        password_confirmation: function(value) {
          console.log(value);
          if (value === "") 
            return "密码不能为空";
          var pwd = $('input[name=password').val();
          if (pwd !== value) 
            return "两次次输入的密码不一致！";
        },
      }); 
    });
    // 目标客户搜索页面
    if($(".company-secrch-page").length === 1){
      table.init('companys-table', { //转化静态表格
        toolbar: '#toolbarTarget',
        defaultToolbar: ['filter'],
        limit:100,
      });
      var formInput =JSON.parse(decodeURIComponent(cookie.get('querys_for_js')));
      form.val("secrchTarget", formInput);
      
      // 选取目标公司跟进
      $("#getcompany").click(function(e){
        var checkStatus = table.checkStatus('companys-table');// userList即为基础参数id对应的值
        var selectCount = checkStatus.data.length;// 获取选中行数量，可作为是否有选中行的条件

        const data = checkStatus.data.map(function (item, index) {
          return item.logId;
        });
        console.log(data);
        if (selectCount == 0){
          layer.msg('您没有选取任何公司',function(){});
          return false;
        }
        $(this).attr('disabled', true);
        layer.load(2);
        var ids = new Array(selectCount);
        for(var i=0; i<selectCount; i++){
          ids[i]=checkStatus.data[i].id;
        }
        var jsonIds= JSON.stringify(ids);
        $.ajax({
          method: 'POST',
	    		url: '/company/locking',
          ContentType: 'application/json',
          data:{list:jsonIds},
	    		headers: {
	    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    		},
           success : function(data){
             layer.closeAll('loading');
             if (data.code == 0) {
               data.list.forEach(function (id) {
                $("tr[data-index="+(id-1)+"]").remove();
              });
              layer.msg(data.msg);
              //获取客户成功 刷新页面
              window.location.reload();
             }
             $('#getcompany').removeAttr('disabled');
           }
         })
         return false;
        });
    }

  // 资料上传页面
  if($(".company-upload-page").length === 1){
     //多文件列表示例
      var demoListView = $('#demoList')
      ,uploadListIns = upload.render({
        elem: '#testList'
        ,url: '/company/store'
        ,accept: 'file'
        ,data: {
          _token: $('meta[name="csrf-token"]').attr('content')
        }
        ,multiple: true
        ,auto: false
        ,bindAction: '#uploadAction'
        ,choose: function(obj){   
          var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
          //读取本地文件
          obj.preview(function(index, file, result){
            var tr = $(['<tr id="upload-'+ index +'">'
              ,'<td>'+ file.name +'</td>'
              ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
              ,'<td>等待上传</td>'
              ,'<td>'
                ,'<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
                ,'<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
              ,'</td>'
            ,'</tr>'].join(''));

            //单个重传
            tr.find('.demo-reload').on('click', function(){
              obj.upload(index, file);
            });

            //删除
            tr.find('.demo-delete').on('click', function(){
              delete files[index]; //删除对应的文件
              tr.remove();
              uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
            });

            demoListView.append(tr);
          });
        }
        ,done: function(res, index, upload){
          if(res.code == 0){ //上传成功
            var tr = demoListView.find('tr#upload-'+ index)
            ,tds = tr.children();
            tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
            tds.eq(3).html(''); //清空操作
            return delete this.files[index]; //删除文件队列已经上传成功的文件
          }
          this.error(index, upload);
        }
        ,error: function(index, upload){
          var tr = demoListView.find('tr#upload-'+ index)
          ,tds = tr.children();
          tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
          tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
        }
        });
        $('#uploadAction').on('click',function(){
          $(this).addClass('layui-btn-disabled');
          $(this).attr('disabled',true);
        });
  }

  // 反馈页面
  if($('.company-show-page').length == 1 || $('.follow-show-page').length == 1 || $('.customer-show-page').length == 1){
    if ($('#record-editor').length == 1) {
			var editor = new Simditor({
				textarea: $('#record-editor'),
				toolbar: ['title', 'bold', 'italic', 'fontScale', 'color', 'ol', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr'],
				upload: {
					url: "/uploadImage",
					//工具条都包含哪些内容
					params: {
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					fileKey: 'upload_file',
					connectionCount: 3,
					leaveConfirm: '文件上传中，关闭此页面将取消上传。'
				},
				pasteImage: true,
			});
    }
  }

  if($('.follow-show-page').length == 1){
    //商机跟进倒计时
    var thisTimer, setCountdown = function(y, M, d, H, m, s){
      var endTime = new Date($('#countdown_at').attr('endTime')) //结束日期
      ,serverTime = new Date($('#countdown_at').attr('now')); //假设为当前服务器时间，这里采用的是本地时间，实际使用一般是取服务端的

      clearTimeout(thisTimer);
      util.countdown(endTime, serverTime, function(date, serverTime, timer){
        var str = date[0] + '天' + date[1] + '时' +  date[2] + '分' + date[3] + '秒';
        $('#countdown_at').html(str);
        thisTimer = timer;
      });
    };
    setCountdown();
    //预计成交时间
    laydate.render({
      elem: '#expected_at'
    });
    
    //下次联系提醒
    laydate.render({
      elem: '#schedule_at'
      ,type: 'datetime'
    });

    // 完成销售转换为正式客户
    $('.customer-btn').on('click',function(){
      var reportform = layer.open({
        type: 1,
        area: '600px',
        anim: 1,
        title: '提交合同(提交后不能修改，请核对信息是否正确)',
        content: $('#customer-form'),
      });
      //售后到期
      laydate.render({
        elem: '#expired_at',
        trigger: 'click'
      });
      //售后到期
      laydate.render({
        elem: '#completion_at',
        trigger: 'click'
      });
      return false;
    });
    // 自定义表单验证
    form.verify({
      contract: function(value, item){ //value：表单的值、item：表单的DOM对象
        if(value == ""){
          return '合同必须上传';
        }
      }
    });
    // 合同文件上传 回调
    uploadDoneCallback = function(){
      $('#aetherupload-savedpath').val("/aetherupload/download/"+this.savedPath+"/"+this.resourceName.split(".")[0]);
      $('.upload-contract-warp>i').css("color","#ccc");
      $('.upload-contract-warp').css("cursor","not-allowed");
      $('#upload-contract-result').append(
        '<p>' + this.resourceName + '(' + parseFloat(this.resourceSize / (1000 * 1000)).toFixed(2) + 'MB)<i class="layui-icon layui-icon-delete delete-contract" title="删除合同"></i></p>'
      );
      // 删除合同
      $('.delete-contract').on('click',function(e){
        $('#aetherupload-savedpath').val('');
        $('#upload-contract-result').empty();
        $('#aetherupload-progressbar').css('width','0px');
        $('#aetherupload-output').empty();
        var file = document.getElementById('aetherupload-resource');
            file.disabled =false;
            file.value ='';
        $('.upload-contract-warp>i').css("color","#009688");
        $('.upload-contract-warp').css("cursor","pointer");
        e.preventDefault();
        e.stopPropagation();
      });
    }
    $('.upload-contract-warp').on('click',function(){
      if($('#aetherupload-savedpath').val() == ""){
        $('#aetherupload-resource').click();
      }
    });
    
  }
    
    // 正式客户展示
    if($('.customers-index-page').length == 1 ){
      var editBar = `<script type="text/html" id="customersEdit">
        {{#  if(d.check == 0){ }}
            <a class="layui-btn layui-btn-xs" lay-event="edit">修改</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        {{#  }else if(d.check == 3){ }}
            <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="agent">续签</a>
        {{#  }else if(d.check == 4){ }}
            <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="restore">恢复</a>
        {{#  } }}
        </script>`
      $('#customersEdit-box').html(editBar);
      table.init('customers-table', { //转化静态表格
        toolbar: '#toolbarTarget',
        defaultToolbar: ['filter'],
        limit:10,
      });
      // 审核事件
      table.on('toolbar(customers-table)', function(obj){
        var checkStatus = table.checkStatus('customers-table');
        if(obj.event == 'CheckStatus'){
          if(checkStatus.data.length == 0){
            layer.msg('没有选择任何行');
            return false;
          }
          var data = checkStatus.data;
          var ids =[];
          for (let i = 0; i < data.length; i++) {
            ids.push(data[i].id);
          }
          $('#check-ids').val(ids);
          layer.confirm('请审核,共计'+data.length+'行', {
            btn: ['批准','驳回'] //按钮
          }, function(){
            $('#check-type').val('approve');
            $('#check-form').submit();
          }, function(){
            $('#check-type').val('dismissed');
            $('#check-form').submit();
          });
        }
      });

      //监听行工具事件 修改 删除 事件
      table.on('tool(customers-table)', function(obj){
        var data = obj.data;
        //console.log(obj)
        if(obj.event === 'del'){
          $('#destroy-id').val(obj.data.id);
          layer.confirm('真的删除行么', function(index){
            $('#destroy-form').submit();
            obj.del();
            layer.close(index);
          });
        } else if(obj.event === 'edit'){
          form.val("customer-form", obj.data);
          var reportform = layer.open({
            type: 1,
            area: '600px',
            anim: 1,
            title: '修改合同('+ obj.data.name +')',
            content: $('#customer-form'),
          });
          // 修改合同文件上传 回调
          uploadDoneCallback = function(){
            $('#aetherupload-savedpath').val("/aetherupload/download/"+this.savedPath+"/"+this.resourceName.split(".")[0]);
            $('.upload-contract-warp>i').css("color","#ccc");
            $('.upload-contract-warp').css("cursor","not-allowed");
            $('#upload-contract-result').append(
              '<p>' + this.resourceName + '(' + parseFloat(this.resourceSize / (1000 * 1000)).toFixed(2) + 'MB)<i class="layui-icon layui-icon-delete delete-contract" title="删除合同"></i></p>'
            );
            // 删除合同
            $('.delete-contract').on('click',function(e){
              $('#aetherupload-savedpath').val('');
              $('#upload-contract-result').empty();
              $('#aetherupload-progressbar').css('width','0px');
              $('#aetherupload-output').empty();
              var file = document.getElementById('aetherupload-resource');
                  file.disabled =false;
                  file.value ='';
              $('.upload-contract-warp>i').css("color","#009688");
              $('.upload-contract-warp').css("cursor","pointer");
              e.preventDefault();
              e.stopPropagation();
            });
          }

          $('.upload-contract-warp').on('click',function(){
            if($('#aetherupload-savedpath').val() == ""){
              $('#aetherupload-resource').click();
            }
          });
          //售后到期
          laydate.render({
            elem: '#expired_at',
            trigger: 'click'
          });
          //售后到期
          laydate.render({
            elem: '#completion_at',
            trigger: 'click'
          });
          // 自定义表单验证
          form.verify({
            contract: function(value, item){ //value：表单的值、item：表单的DOM对象
              if(value == ""){
                return '合同必须上传';
              }
            }
          });
          var contract = $('#aetherupload-savedpath').val();
          if(contract != ""){
            $('#aetherupload-progressbar').css('width','100%');
            $('.upload-contract-warp>i').css("color","#ccc");
            $('.upload-contract-warp').css("cursor","not-allowed");
            $('#upload-contract-result').empty().append(
              '<p>' + contract.substr((contract.lastIndexOf("/")) + 1) + '<i class="layui-icon layui-icon-delete delete-contract" title="删除合同"></i></p>'
            );
            // 删除合同
            $('.delete-contract').on('click',function(e){
              $('#aetherupload-savedpath').val('');
              $('#upload-contract-result').empty();
              $('#aetherupload-progressbar').css('width','0px');
              $('#aetherupload-output').empty();
              var file = document.getElementById('aetherupload-resource');
                  file.disabled =false;
                  file.value ='';
              $('.upload-contract-warp>i').css("color","#009688");
              $('.upload-contract-warp').css("cursor","pointer");
              e.preventDefault();
              e.stopPropagation();
            });
          }
        }else if(obj.event == 'restore'){
          $('#restore-id').val(obj.data.id);
          layer.confirm('真的恢复行么', function(index){
            $('#restore-form').submit();
            layer.close(index);
          });
        }else if(obj.event == 'agent'){
          $('#follow_id').val(obj.data.follow_id);
          $('#customer_id').val(obj.data.id);
          layer.confirm('确认续签么', function(index){
            $('#agent-form').submit();
            layer.close(index);
          });
        }
      });
    }
    // 用户管理页面
    if($('.system-users-page').length == 1 ){
      table.init('users-table', { //转化静态表格
        // toolbar: '#toolbarTarget',
      });
         //监听行单击事件（单击事件为：rowDouble）
         table.on('row(users-table)', function(obj){
          var data = obj.data;
          // 表单初始赋值
          form.val("user-form", data);
          layer.open({
              type: 1,
              area: '500px',
              shade: 0,
              anim: 1,
              title: '修改用户',
              content: $('#user-form'),
          });
          //标注选中样式
          obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        });
        // 添加用户
        $('.add-users').on('click',function(){
          layer.open({
            type: 1,
            area: '500px',
            shade: 0,
            anim: 1,
            title: '添加用户',
            content: $('#user-add-form'),
          });
        // 表单验证
        form.verify({
          password: [
            /^[\S]{6,25}$/
            ,'密码必须6到25位，且不能出现空格'
          ] 
        }); 
        });
    }
    // 个人设置页面
    if($('.user-settings-page').length == 1 ){
      table.init('smtps-table', { //转化静态表格
        // toolbar: '#toolbarTarget',
      });
    }
    // 通用设置页面
    if($('.settings-show-page').length == 1 ){
      laydate.render({
        elem: '#reportScope'
        ,type: 'datetime'
        ,range: '~'
      });
      $(".sendReport-btn").on("click",function(){
        $("#sendScope").val($("#reportScope").val());
        $("#sendEmployee").val($("#reportEmployee").val());
        $("#sendReport").submit();
        return false;
      });
    }

    //销售话术管理
    if($('.speechs-index-page').length == 1){
      table.init('speechs-table', { //转化静态表格
        // toolbar: '#toolbarTarget',
      });
        // 添加用户
        $('.add-speechs').on('click',function(){
          layer.open({
            type: 1,
            area: '500px',
            shade: 0,
            anim: 1,
            title: '添加标准回答',
            content: $('#speech-add-form'),
          });
        });

        //监听行工具事件
        table.on('tool(speechs-table)', function(obj){
          var data = obj.data;
          //console.log(obj)
          if(obj.event === 'del'){
            $('#speech_id').val(data.id);
            layer.confirm('真的删除行么', function(index){
              event.preventDefault(); document.getElementById('speech-destroy').submit();
              obj.del();
              layer.close(index);
            });
          } else if(obj.event === 'edit'){
              var data = obj.data;
              // 表单初始赋值
              form.val("speech-form", data);
              layer.open({
                  type: 1,
                  area: '500px',
                  shade: 0,
                  anim: 1,
                  title: '修改标准回答',
                  content: $('#speech-form'),
              });
          }
        });
    }

  });

