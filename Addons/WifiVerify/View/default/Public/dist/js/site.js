$(document).ready(function() {
	//随机背景

//	var random_bg = Math.floor(Math.random() * 13 + 1);
	//var bg='url(./dist/css/img/bg'+random_bg+'.jpg) no-repeat center top fixed)';
//	$("#main").css({
//		"background": "url(./dist/css/img/bg" + random_bg + ".jpg) no-repeat center top fixed",
//		"-webkit-background-size": "cover",
//		"-moz-background-size": "cover",
//		"-o-background-size": "cover",
//		"background-size": "cover"
//	});

	//直接认证
	$("#ikLogin").click(function() {
		ikLogin();
	});
	//固定密码认证
	$("#ikGdpass").click(function() {
		$("#title").remove();
		$(".row").replaceWith('<h3>请输入固定密码</h3><div class="col-sm-4 col-sm-offset-4">\n' + '<input id="ikPassword" class="form-control" type="password" placeholder="固定密码"><br>\n' + '<button id="btngdpass" type="button" class="btn btn-lg btn-primary btn-block">确定</button>\n<button id="goback" type="button" class="btn btn-lg btn-default btn-block">返回</button>\n' + '</div>\n');
		$("#ikPassword").focus();
		$("#goback").click(function() {
			window.location.href = '';
		});
		$("#btngdpass").click(function() {
			var password = $("#ikPassword").val();
			if (!password) {
				alert("请输入密码");
				return false;
			}
			//授权认证
			ikPasswordLogin(password);
		});
	});
	//QQ认证
	$("#ikQQLogin").click(function() {
		ikQQLogin();
	});
	//微信认证
	$("#ikWechatLogin").click(function() {
		$("#title").remove();

		$(".row").replaceWith('<div class="col-sm-4 col-sm-offset-4">\n' + '<div id="wxthum" class="thumbnail">\n' + '<img src="./dist/css/img/wx.png" alt="" style="height:128px;width:128px;">\n' + '<div class="caption">\n' + '<h3>微信认证方法</h3>\n' + '<p>请打开微信，搜索并关注服务号</p>\n' + '<p style="color:rgb(177,207,28);">「诺言法式旅馆」</p>\n' + '<p>回复"wifi"或"上网"后点击认证链接即完成认证并可访问网络。</p>\n' + '</div>\n' + '</div>\n' + '</div>\n');
		if (ik.core.isIOS()) {
			$("#wxthum").append('<button id="btnGotoWechat" type="button" class="btn btn-lg btn-success btn-block">点击跳转微信</button><button id="goback" type="button" class="btn btn-lg btn-default btn-block">返回</button>');
		} else {
			$("#wxthum").append('<button id="goback" type="button" class="btn btn-lg btn-default btn-block">返回</button></form></div>');
		}
		$("#goback").click(function() {
			window.location.href = '';
		});
		$("h2").replaceWith('');
		$("#btnGotoWechat").click(function() {
			if (ik.core.isIOS()) {
				ik.core.goWechat();
			} else {
				alert('请通过IOS系统设备使用');
				return false;
			}
		});
		//ikLogin();
	});
	//帐号密码认证
	$("#ikGotoAccount").click(function() {
		$("#title").remove();
		$(".row").replaceWith('<div class="col-sm-4 col-sm-offset-4"><h3>用户密码验证限内部员工使用</h3>\n' + '<form role="form">\n' + '<div class="form-group"><input type="text" class="form-control" id="InputAccount" placeholder="帐号"></div>\n' + '<div class="form-group"><input type="password" class="form-control" id="InputPassword" placeholder="密码"></div>\n' + '<button id="btnAcpassword" type="button" class="btn btn-lg btn-info btn-block">登录</button><button id="goback" type="button" class="btn btn-lg btn-default btn-block">返回</button></form></div>\n');
		$("#InputAccount").focus();
		$("#goback").click(function() {
			window.location.href = '';
		});
		$("#btnAcpassword").click(function() {
			var account = $("#InputAccount").val();
			var password = $("#InputPassword").val();
			if (!account) {
				alert("请输入用户名");
				return false;
			}
			if (!password) {
				alert("请输入密码");
				return false;
			}
			//授权认证
			ikAccountLogin(account, password);
		});
	});
	//优惠券认证
	$("#ikGotoCouponPage").click(function() {
		$("h2").replaceWith('');
		$(".row").replaceWith('<h3>请输入优惠券</h3><div class="col-sm-4 col-sm-offset-4">\n' + '<input id="ikCoupon" class="form-control" type="text" placeholder="优惠券"><br><button id="btncoupon" type="button" class="btn btn-lg btn-warning btn-block">确定</button><button id="goback" type="button" class="btn btn-lg btn-default btn-block">返回</button>' + '</div>\n');
		$("#ikCoupon").focus();
		$("#goback").click(function() {
			window.location.href = '';
		});
		$("#btncoupon").click(function() {
			var coupon = $("#ikCoupon").val();
			if (!coupon) {
				alert("请输入优惠券");
				return false;
			}
			//授权认证
			ikCouponLogin(coupon);
		});
	});
});