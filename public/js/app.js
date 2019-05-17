/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// require('./bootstrap');
layui.use(['element', 'form', 'table', 'upload', 'util', 'laydate', 'layer'], function () {
  var $ = layui.$;
  var element = layui.element;
  var upload = layui.upload;
  var form = layui.form;
  var table = layui.table;
  var util = layui.util;
  var laydate = layui.laydate;
  var layer = layui.layer; //  cookie操作

  var cookie = {
    set: function set(key, val, time) {
      //设置cookie方法
      time = time || 30;
      var date = new Date(); //获取当前时间

      var expiresDays = time; //将date设置为n天以后的时间

      date.setTime(date.getTime() + expiresDays * 24 * 3600 * 1000); //格式化为cookie识别的时间

      document.cookie = key + "=" + val + ";expires=" + date.toGMTString(); //设置cookie
    },
    get: function get(key) {
      //获取cookie方法

      /*获取cookie参数*/
      var getCookie = document.cookie.replace(/[ ]/g, ""); //获取cookie，并且将获得的cookie格式化，去掉空格字符

      var arrCookie = getCookie.split(";"); //将获得的cookie以"分号"为标识 将cookie保存到arrCookie的数组中

      var tips = null; //声明变量tips

      for (var i = 0; i < arrCookie.length; i++) {
        //使用for循环查找cookie中的tips变量
        var arr = arrCookie[i].split("="); //将单条cookie用"等号"为标识，将单条cookie保存为arr数组

        if (key == arr[0]) {
          //匹配变量名称，其中arr[0]是指的cookie名称，如果该条变量为tips则执行判断语句中的赋值操作
          tips = arr[1]; //将cookie的值赋给变量tips

          break; //终止for循环遍历
        }
      }

      return tips;
    },
    del: function del(key) {
      //删除cookie方法
      var date = new Date(); //获取当前时间

      date.setTime(date.getTime() - 10000); //将date设置为过去的时间

      document.cookie = key + "=v; expires =" + date.toGMTString(); //设置cookie
    } // 目标客户搜索页面

  };

  if ($(".company-secrch-page").length === 1) {
    table.init('companys-table', {
      //转化静态表格
      toolbar: '#toolbarTarget',
      defaultToolbar: ['filter'],
      limit: 100
    });
    var formInput = JSON.parse(decodeURIComponent(cookie.get('querys_for_js')));
    form.val("secrchTarget", formInput); // 选取目标公司跟进

    $("#getcompany").click(function (e) {
      var checkStatus = table.checkStatus('companys-table'); // userList即为基础参数id对应的值

      var selectCount = checkStatus.data.length; // 获取选中行数量，可作为是否有选中行的条件

      var data = checkStatus.data.map(function (item, index) {
        return item.logId;
      });
      console.log(data);

      if (selectCount == 0) {
        layer.msg('您没有选取任何公司', function () {});
        return false;
      }

      $(this).attr('disabled', true);
      layer.load(2);
      var ids = new Array(selectCount);

      for (var i = 0; i < selectCount; i++) {
        ids[i] = checkStatus.data[i].id;
      }

      var jsonIds = JSON.stringify(ids);
      $.ajax({
        method: 'POST',
        url: '/company/locking',
        ContentType: 'application/json',
        data: {
          list: jsonIds
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function success(data) {
          layer.closeAll('loading');

          if (data.code == 0) {
            data.list.forEach(function (id) {
              $("tr[data-index=" + (id - 1) + "]").remove();
            });
            layer.msg('成功选取' + data.list.length + '个客户'); //获取客户成功 刷新页面

            window.location.reload();
          }

          $('#getcompany').removeAttr('disabled');
        }
      });
      return false;
    });
  } // 资料上传页面


  if ($(".company-upload-page").length === 1) {
    //多文件列表示例
    var demoListView = $('#demoList'),
        uploadListIns = upload.render({
      elem: '#testList',
      url: '/company/store',
      accept: 'file',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      multiple: true,
      auto: false,
      bindAction: '#testListAction',
      choose: function choose(obj) {
        var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
        //读取本地文件

        obj.preview(function (index, file, result) {
          var tr = $(['<tr id="upload-' + index + '">', '<td>' + file.name + '</td>', '<td>' + (file.size / 1014).toFixed(1) + 'kb</td>', '<td>等待上传</td>', '<td>', '<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>', '<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>', '</td>', '</tr>'].join('')); //单个重传

          tr.find('.demo-reload').on('click', function () {
            obj.upload(index, file);
          }); //删除

          tr.find('.demo-delete').on('click', function () {
            delete files[index]; //删除对应的文件

            tr.remove();
            uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
          });
          demoListView.append(tr);
        });
      },
      done: function done(res, index, upload) {
        if (res.code == 0) {
          //上传成功
          var tr = demoListView.find('tr#upload-' + index),
              tds = tr.children();
          tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
          tds.eq(3).html(''); //清空操作

          return delete this.files[index]; //删除文件队列已经上传成功的文件
        }

        this.error(index, upload);
      },
      error: function error(index, upload) {
        var tr = demoListView.find('tr#upload-' + index),
            tds = tr.children();
        tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
        tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
      }
    });
  } // 反馈页面


  if ($('.company-show-page').length == 1 || $('.follow-show-page').length == 1) {
    if ($('#record-editor').length == 1) {
      var editor = new Simditor({
        textarea: $('#record-editor'),
        toolbar: ['title', 'bold', 'italic', 'fontScale', 'color', 'ol', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr'],
        upload: {
          url: "/topics/upload_image",
          //工具条都包含哪些内容
          params: {
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          fileKey: 'upload_file',
          connectionCount: 3,
          leaveConfirm: '文件上传中，关闭此页面将取消上传。'
        },
        pasteImage: true
      });
    }
  }

  if ($('.follow-show-page').length == 1) {
    //商机跟进倒计时
    var thisTimer,
        setCountdown = function setCountdown(y, M, d, H, m, s) {
      var endTime = new Date($('#countdown').attr('endTime')) //结束日期
      ,
          serverTime = new Date($('#countdown').attr('now')); //假设为当前服务器时间，这里采用的是本地时间，实际使用一般是取服务端的

      clearTimeout(thisTimer);
      util.countdown(endTime, serverTime, function (date, serverTime, timer) {
        var str = date[0] + '天' + date[1] + '时' + date[2] + '分' + date[3] + '秒';
        $('#countdown').html(str);
        thisTimer = timer;
      });
    };

    setCountdown();
  } //预计成交时间


  laydate.render({
    elem: '#expired'
  }); //下次联系提醒

  laydate.render({
    elem: '#schedule',
    type: 'datetime'
  }); // 完成销售转换为正式客户

  $('.customer-btn').on('click', function () {
    var reportform = layer.open({
      type: 1,
      area: '600px',
      title: '提交合同',
      content: $('#customer-form')
    });
    return false;
  });
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/vagrant/code/ktcrm/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/vagrant/code/ktcrm/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });