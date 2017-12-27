/**
 * 前台通用js
 */
define('frontCommon', [ 'jquery' ], function($) {
	var doc = $(document);

	
	var pageWrapper = $('#page-wrapper');
	var common = {
		queryForm: function(formSelector, options){
			options = options || {};
			formSelector = formSelector || '.query-form';
			var form = $(formSelector),
			url = form.attr("action"), arrays = form.serializeArray();
			
			
			var param;
			$.each(options.data, function(k, v){
				arrays.push({
					name: k,
					value: v
				})
			}); 
			var param='';
			$.each(arrays, function(k, v){
				param = param+v.name+"="+v.value +"&";
				//console.log(v.name+"="+v.value);
				console.log(param);
			});
			
			
			
			location.href=url+'?'+param;
			//pageWrapper.hideLoading();
			//pageWrapper.showLoading();
			//$.post(url, arrays, function(html){
			//	pageWrapper.hideLoading();
			//	pageWrapper.html(html);
			//});
		},
		loadData: function(currPage, pageContainer, options){
			var form = pageContainer.parents('form');
			common.queryForm(form, {
				data: {
					page: ++currPage
				}
			});
		},
		fullpage : function(options) {
			options = $.extend({
				container: '#fullpage',
				anchors: ["section1", "section2", "section3", "section4", "section5", "section6"],
				navigation: true,
				css3:true,
                loopHorizontal: true,
				keyboardScrolling: true,
				afterLoad: function(anchorLink, index) {
					var element = options.id + "-section" + index;
					var iconStyle = $(element).find(".icon").attr("iconStyle");
					var titStyle = $(element).find(".tit").attr("titStyle");
					var linkStyle = $(element).find(".more").attr("linkStyle");
					var hStyle = $(element).find("h3").attr("hStyle");
					if (index == "1") {
						$(element).find("h3").addClass(hStyle);
						$(element).find(".icon").addClass(iconStyle);
						$(element).find(".tit").addClass(titStyle);
						$(element).find(".more").addClass(linkStyle)
					}
					if (index == "2") {
						$(element).find("h3").addClass(hStyle);
						$(element).find(".icon").addClass(iconStyle);
						$(element).find(".tit").addClass(titStyle);
						$(element).find(".more").addClass(linkStyle)
					}
					if (index == "3") {
						$(element).find("h3").addClass(hStyle);
						$(element).find(".icon").addClass(iconStyle);
						$(element).find(".tit").addClass(titStyle);
						$(element).find(".more").addClass(linkStyle)
					}
					if (index == "4") {
						$(element).find("h3").addClass(hStyle);
						$(element).find(".icon").addClass(iconStyle);
						$(element).find(".tit").addClass(titStyle);
						$(element).find(".more").addClass(linkStyle)
					}
					if (index == "5") {
						$(element).find("h3").addClass(hStyle);
						$(element).find(".icon").addClass(iconStyle);
						$(element).find(".tit").addClass(titStyle);
						$(element).find(".more").addClass(linkStyle)
					}
					if (index == "6") {
						$(element).find("h3").addClass(hStyle);
						$(element).find(".icon").addClass(iconStyle);
						$(element).find(".tit").addClass(titStyle);
						$(element).find(".more").addClass(linkStyle)
					}
				},
				onLeave: function(index, direction) {
					var element = options.id + "-section" + index;
					var iconStyle = $(element).find(".icon").attr("iconStyle");
					var titStyle = $(element).find(".tit").attr("titStyle");
					var linkStyle = $(element).find(".more").attr("linkStyle");
					var hStyle = $(element).find("h3").attr("hStyle");
					if (index == "1") {
						$(element).find("h3").removeClass(hStyle);
						$(element).find(".icon").removeClass(iconStyle);
						$(element).find(".tit").removeClass(titStyle);
						$(element).find(".more").removeClass(linkStyle)
					}
					if (index == "2") {
						$(element).find("h3").removeClass(hStyle);
						$(element).find(".icon").removeClass(iconStyle);
						$(element).find(".tit").removeClass(titStyle);
						$(element).find(".more").removeClass(linkStyle)
					}
					if (index == "3") {
						$(element).find("h3").removeClass(hStyle);
						$(element).find(".icon").removeClass(iconStyle);
						$(element).find(".tit").removeClass(titStyle);
						$(element).find(".more").removeClass(linkStyle)
					}
					if (index == "4") {
						$(element).find("h3").removeClass(hStyle);
						$(element).find(".icon").removeClass(iconStyle);
						$(element).find(".tit").removeClass(titStyle);
						$(element).find(".more").removeClass(linkStyle)
					}
					if (index == "5") {
						$(element).find("h3").removeClass(hStyle);
						$(element).find(".icon").removeClass(iconStyle);
						$(element).find(".tit").removeClass(titStyle);
						$(element).find(".more").removeClass(linkStyle)
					}
					if (index == "6") {
						$(element).find("h3").removeClass(hStyle);
						$(element).find(".icon").removeClass(iconStyle);
						$(element).find(".tit").removeClass(titStyle);
						$(element).find(".more").removeClass(linkStyle)
					}
				},
                afterSlideLoad: function (anchorLink,index,slideIndex,direction) {
                    var element = options.id + "-section" + index;
                    var iconStyle = $(element).find(".icon").attr("iconStyle");
                    var titStyle = $(element).find(".tit").attr("titStyle");
                    var linkStyle = $(element).find(".more").attr("linkStyle");
                    var hStyle = $(element).find("h3").attr("hStyle");
                    if (index == "1") {
                        $(element).find("h3").addClass(hStyle);
                        $(element).find(".icon").addClass(iconStyle);
                        $(element).find(".tit").addClass(titStyle);
                        $(element).find(".more").addClass(linkStyle)
                    }
                },
                onSlideLeave: function (anchorLink,index,slideIndex,direction) {
                    var element = options.id + "-section" + index;
                    var iconStyle = $(element).find(".icon").attr("iconStyle");
                    var titStyle = $(element).find(".tit").attr("titStyle");
                    var linkStyle = $(element).find(".more").attr("linkStyle");
                    var hStyle = $(element).find("h3").attr("hStyle");
                    if (index == "1") {
                        $(element).find("h3").removeClass(hStyle);
                        $(element).find(".icon").removeClass(iconStyle);
                        $(element).find(".tit").removeClass(titStyle);
                        $(element).find(".more").removeClass(linkStyle)
                    };
                }
			}, options);
			require([ 'fullPage' ], function() {
			    console.log(options)
				$(options.container).fullpage(options);
			});
			
		},
		touchSilde: function(options){
			options = $.extend({
				slideCell: "#tabBox",
				titCell: ".hd li",
				mainCell: ".bd ul"
			}, options);
			require([ 'touchSlide' ], function() {
				TouchSlide(options);
			});
		}
	};
	return common;
});