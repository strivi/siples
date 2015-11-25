var $imgs = $('img');
var count = $imgs.length;
var comi = 0;
var loadi = 0;
$imgs.each(function() {
	if($(this).hasClass('no')) {
		--count;
	} else {
		if(!this.getAttribute('_src').length) {
			--count;
		} else {
			this.src = this.getAttribute('_src') + '?v=1.1';
			if(!this.complete){
				this.addEventListener('load',function(){
					--count;
					loadi++;
				});
			} else {
				--count;
				comi++;
			}
		}
	}
});
var flag = false;
var loaded = function() {
	if (flag) {
		return;
	}
	flag = true;
	$(window).resize();
	try{
		initCanvas(document.body.style); //刮奖
	}catch(e){ 
		alert('您的手机不支持刮刮卡效果哦~!'); 
	}
	$('#loading').hide();
	$('#bg, #nav, #main').css('visibility', 'visible');
	$('body').css({'overflow': 'auto'});
	$(window).scroll();
	
}

var imgTimer = setInterval(function() {
	if(count == 0) {
		clearInterval(imgTimer);
		loaded();
	}
}, 500);

var setTop = function() {
	var top = $(window).height() - $("#guajang").height();
	$("html,body").animate({scrollTop:$("#guajang").offset().top - top / 2}, 500);
}

$('#qrcodeMask').bind('click', function() {
	$('#loading-qrcode').show();
	$(this).unbind('click');
	$userPhoto = $('#userPhoto');
	$userPhoto.addClass('loadingUserPhoto');
	var qrcode = document.getElementById('qrcode');
	qrcode.addEventListener('load',function(){
		$userPhoto.hide();
	});
	
	$.get(get_temp_ticket_url, function(data) {
		if(data.status) {
			qrcode.src = qrcode.getAttribute('_src') + data.info;
		} else {
			alert('无法获取二维码，请刷新页面重试...');
		}
	}, 'json');
});

var share_timeline = function() {
	var $share = $('#share-timeline');
	$share.show();
	setTimeout(function() {
		$share.hide();
	}, 3000)
};

var divsAttr = [ 
	{'height' : 680},
	{'height' : 576, 'marginTop' : -130},
	{'height' : 618, 'marginTop' : -56},
	{'height' : 622, 'marginTop' : -176},
	{'height' : 496, 'marginTop' : -56},
	{'height' : 654},
	{'height' : 778, 'marginTop' : -40}
];

var $divs = $('#lottery>div');
var scale;
// console.log();
$(window).resize(function() {
	scale = $('.container').width() / 720;
	var index = 0;
	$divs.each(function() {
		if (index >= divsAttr.length) {
			return;
		}
		var currAttr = {};
		for ( var attr in divsAttr[index]) {
			currAttr[attr] = divsAttr[index][attr] * scale;
		}
		$(this).css(currAttr);
		++index;
	});
	$('.main-top').height($('#nav').height());
	$('#bgimg').width($('#bgimg').parent().width());
	var scaleCss = {'WebkitTransform': 'scale(' + scale + ')'};
	$('#scratch').css(scaleCss);
	$('.word').css(scaleCss);
	$(window).scroll();
});

// 重力感应
var $gravitySensor = $('.gravity-sensor');
var devicemotionHandle = function(event) {
	var i = 3;
	var x = parseInt(event.gamma / i);
	// var z = parseInt(event.alpha);
	var y = parseInt(event.beta / i);
	var max = 30;
	x = x > max ? max: (x < -max) ? -max : x;
	y = y > max ? max: (y < -max) ? -max : y;
	$gravitySensor.each(function() {
		$(this).css({
			'marginLeft' : -x,
			'marginTop' : -y
		});
	});
}
window.addEventListener('deviceorientation', devicemotionHandle, false);

// 滚动检测
var $animates = $('.animate');
$(window).bind('scroll', function() {
	var scrollTop = $(document).scrollTop();
	var wh = $(window).height();
	var is_over = true;
	$animates.each(function() {
		var animate1ScrollTop = $(this).offset().top;
		if (scrollTop + wh - animate1ScrollTop >= wh / 6) {
			if(!$(this).hasClass('animate-over')) {
				addAnimate($(this));
				$(this).addClass('animate-over');
			}
		} else {
			is_over = false;
		}
	});
	if (is_over) {
		$(window).unbind('scroll');
	}

});
var addAnimate = function($obj) {
	$('.up', $obj).each(function() {
		$(this).addClass('animate-up');
	});
	$('.expand', $obj).each(function() {
		$(this).addClass('animate-expand');
	});
	$('.float', $obj).each(function() {
		$(this).addClass('animate-float');
	});
}


//抽奖
var is_set = 0;
var is_alert =0;
function initCanvas(bodyStyle) {
	bodyStyle.mozUserSelect = 'none';         
	bodyStyle.webkitUserSelect = 'none';
	         
	var areaImg = document.getElementById('areaImg');         
	var $canvas = $('canvas');
	var w = $canvas.width(); 
	var h =  $canvas.height();
	if(!areaImg.complete){
		areaImg.addEventListener('load',function(){
			areaHadle();
		});
	} else {
		areaHadle();
	}
	
	function areaHadle() {
		var ctx=$canvas[0].getContext('2d');
		ctx.drawImage(areaImg, 0, 0);
		ctx.globalCompositeOperation = 'destination-out';
		var offsetX, offsetY;
		var mousedown = false;
		 
		function eventDown(e){
			e.preventDefault();
			mousedown=true;
			offsetX = $canvas.offset().left;
			offsetY = $canvas.offset().top;
		}
		
		function eventUp(e){             
			e.preventDefault();                 
			mousedown = false;
			var data = ctx.getImageData(124, 28, 158, 28).data;
			var len = data.length;
			for(var i = 0, j = 0; i < len; i += 4){
				if(!data[i] && !data[i+1] && !data[i+2] && !data[i+3]){
					j++;
				}
			}
			if(j>0&& is_set==0){
				set_sn_code(); //刮开记录中奖情况
				is_set = 1; 
			}
			if(j >= len / 4 * 0.7 && is_alert==0){
				//set_sn_code(); //刮开记录中奖情况
				if(prize_id>0){
					//中奖
					openGoodDialog();
				}else{
					openBadDialog();
				}
				is_alert = 1;
			}    
		}
		  
		function eventMove(e){              
			e.preventDefault();                 
			if(mousedown) {
				if(e.changedTouches) {
					e=e.changedTouches[e.changedTouches.length-1];                     
				}
				var x = parseInt(e.pageX - offsetX) / scale; 
				var y = parseInt(e.pageY - offsetY) / scale;
				with(ctx){
					beginPath();
					arc(x, y, 10, 0, Math.PI * 2);
					fill();
					//ctx.clearRect(x - 10, y - 10, 20, 20);
					$(areaImg).hide();
					$('.prize_text').show();
					$('canvas').css("opacity",0.99);
					setTimeout(function(){
						$('canvas').css("opacity",1);  
						},5);
				}
			}
		}
		       
		$canvas[0].addEventListener('touchstart', eventDown);
		$canvas[0].addEventListener('touchend', eventUp);             
		$canvas[0].addEventListener('touchmove', eventMove);
		$canvas[0].addEventListener('mousedown', eventDown);             
		$canvas[0].addEventListener('mouseup', eventUp);             
		$canvas[0].addEventListener('mousemove', eventMove);
		
	};
};
function openGoodDialog(){
	var $alertGood = $('#alert-good');
	$alertGood.show();
}
function openBadDialog(){
	var $alertBad = $('#alert-bad');
	$alertBad.show();
}

function set_sn_code(){
	$.post(set_sn_code_url, {id: data_id, prize_id: prize_id}, function(data) {
		//alert(JSON.stringify(data));
		var $batchAddCard = $('#batchAddCard');
		$batchAddCard.attr('card_id', data.card_id);
		$batchAddCard.attr('timestamp', data.timestamp);
		$batchAddCard.attr('signature', data.signature);
		$batchAddCard.attr('sn_id', data.sn_id);
	}, 'json');
}

var switchPages = function(pageId) {
	var $pageActive = $('.nav_item.active');
	$pageActive.removeClass('active').attr('scrollTop', $(document).scrollTop());
	$('#' + $pageActive.attr('data')).height(0);
	
	var $currPage = $(".nav_item[data='" + pageId + "']");
	$currPage.addClass('active');
	
	var $page = $('#' + pageId);
	if(!$page.length) {
		$page = $('<div id="' + pageId + '" class="content" style="line-height: 24px;"></div>');
		$('#loading').show();
		$('#content-box').append($page);
		$page.load(window.location.href.replace('show', pageId), function() {
			loading(pageId);
		});
	} else {
		$page.height('auto');
		$(document).scrollTop($currPage.attr('scrollTop'));
	}
}

$('.nav_item').bind('click', function() {
	var pageId = $(this).attr('data');
	if(!pageId) {
		return false;
	}
	switchPages(pageId);
	var state = {
		'pageId': pageId,
		'title': indexTitle
	};
	//history.pushState(state, null, indexUrl + '?step=' + pageId);
});

var state = {
	'pageId': 'lottery',
	'title': indexTitle
};
//history.replaceState(state, null, indexUrl);
/*
window.addEventListener("popstate",function(event){
	if(event && event.state){
		document.title = event.state.title;
		pageId = event.state.pageId;
		switchPages(pageId);
	}
});
*/

var divsAttrObj = {
	'exchange': [
		{'height': 580},
		{'marginTop' : -40, 'marginBottom': 72, 'paddingTop': 50},
		{'height': 376},
		{'marginBottom': 50},
		{'marginBottom': 50},
		{'marginBottom': 72}
	]
}

var loading = function(pageId) {
	var $imgs = $('#' + pageId + ' img');
	var count = $imgs.length;
	$imgs.each(function() {
		if($(this).hasClass('no')) {
			--count;
		} else {
			if(!this.getAttribute('_src').length) {
				--count;
			} else {
				this.src = this.getAttribute('_src') + '?v=2.0';
				if(!this.complete){
					this.addEventListener('load',function(){
						--count;
					});
				} else {
					--count;
				}
			}
		}
	});
	var flag = false;
	var loaded = function() {
		if (flag) {
			return;
		}
		flag = true;
		$(window).resize();
		$('#loading').hide();
		$(window).scroll();
	}
	
	var imgTimer = setInterval(function() {
		if(count == 0) {
			clearInterval(imgTimer);
			loaded();
		}
	}, 500);
	
	var divsAttr = divsAttrObj[pageId];
	
	var $divs = $('#' + pageId + ' .scaleAttr');
	var scale;
	
	$(window).resize(function() {
		scale = $('#' + pageId).width() / 720;
		var index = 0;
		$divs.each(function() {
			if (index >= divsAttr.length) {
				return;
			}
			var currAttr = {};
			for ( var attr in divsAttr[index]) {
				currAttr[attr] = divsAttr[index][attr] * scale;
			}
			$(this).css(currAttr);
			++index;
		});
		var $box = $($('#prompt .box')[0]);
		var top = ($(window).height() - $box.height()) / 2;
		$box.css('top', top);
	});
}

var exchange = function(obj, sn, pwd) {
	var $img = $(obj);
	var $prompt = $('#prompt');
	$prompt.show();
	var $box = $($('#prompt .box')[0]);
	var top = ($(window).height() - $box.height()) / 2;
	$box.css('top', top);
	var $ok = $('#prompt .ok');
	var $input = $('#prompt input');
	var $error = $('#prompt .error');
	$ok.unbind('click').bind('click', function() {
		if($input.val() == pwd) {
			$error.hide();
			$.post(exchange_url, {'sn': sn}, function(data) {
				if(data.status) {
					$img.remove();
				}
				alert(data.info);
			}, 'json');
		} else {
			$error.show();
			$input.unbind('keyup').bind('keyup', function() {
				if($input.val() == pwd) {
					$error.hide();
				} else {
					$error.show();
				}
			});
			event.stopPropagation();
		}
	});
}