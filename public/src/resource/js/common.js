/**
 * 后台通用js
 */
define('common', ['jquery', 'showloading'], function($){
	var doc = $(document);
	var pageWrapper = $('#page-wrapper'), myModal = $('#myModal');
	var common = {
		confirm: function(options){
			options = $.extend({
				title: '提示',
				content: '确认？'
			}, options);
			$('.modal-title', myModal).text(options.title);
			$('.modal-body', myModal).text(options.content);
			myModal.modal('show')
			$('.confirm-ok', myModal).off().on('click', function(){
				myModal.modal('hide');
				setTimeout(function(){options.callback();}, 500);
			});
			
		},
		queryForm: function(formSelector, options){
			options = options || {};
			formSelector = formSelector || '.query-form';
			var form = $(formSelector),
			url = form.attr("action"), arrays = form.serializeArray();
			$.each(options.data, function(k, v){
				arrays.push({
					name: k,
					value: v
				})
			});
			pageWrapper.hideLoading();
			pageWrapper.showLoading();
			$.post(url, arrays, function(html){
				pageWrapper.hideLoading();
				pageWrapper.html(html);
			});
		},
		loadData: function(currPage, pageContainer, options){
			var form = pageContainer.parents('form');
			common.queryForm(form, {
				data: {
					page: ++currPage
				}
			});
		},
		goUrl: function(url){
			pageWrapper.hideLoading();
			pageWrapper.showLoading();
			pageWrapper.load(url, function(){
				pageWrapper.hideLoading();
			});
		},
		ueditor: function(container, options){
			options = $.extend({
				UEDITOR_HOME_URL: '/resource/js/plugins/ueditor1_4_3_1/',
				serverUrl: "/ueditor/config"
			}, options);
			
			return UE.getEditor(container, options);
		},
		/**
		 * Bootstrap Tree View
		 */
		treeview: function(options){
			options = $.extend({
				container: '.tree-view'
			}, options);
			require(['treeview'], function(){
				var _treeview = $(options.container).treeview(options);
				if(options.init){
					options.init(_treeview);
				}
			});
		}
	};
	// 防止查询表单提交
	doc.on('submit', '.query-form', function(){
		common.queryForm();
		return false;
	});
	
	// 防止a标签链接页面跳转
	pageWrapper.on('click', 'a', function(e){
		var _target = $(e.target);
		var confirm = _target.attr('confirm');
		if(confirm){
			common.confirm({
				content: confirm,
				callback: function(e){
					common.goUrl(_target.attr('href'));
				}
			})
		}else{
			common.goUrl(_target.attr('href'));
		}
		return false;
	});
	
	// 防止a标签链接页面跳转
	doc.on('click', '.btn-ok', function(e){
		common.goUrl($(e.target).attr('href'));
		return false;
	});
	return common;
});