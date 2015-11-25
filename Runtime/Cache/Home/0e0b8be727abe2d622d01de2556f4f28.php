<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo empty($page_title) ? C('WEB_SITE_TITLE') : $page_title; ?></title>
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="shortcut icon" href="<?php echo SITE_URL;?>/favicon.ico">
    
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/style.css" rel="stylesheet" type="text/css">
	<style>
		#nav {
			visibility: hidden;
		}
	</style>
</head>
<body style="overflow: hidden;">
	<div id="loading" style="position: absolute; z-index: 888888; width: 100%; height: 100%;">
		<div class="container" style="height: 100%; background:-webkit-linear-gradient(#f1aba0, #f4a478); linear-gradient(#f1aba0, #f4a478);">
			<div class="main-top"></div>
			<br><br>
			<div class="spinner">
			   <div class="rect1"></div>
			   <div class="rect2"></div>
			   <div class="rect3"></div>
			   <div class="rect4"></div>
			   <div class="rect5"></div>
			</div>
			<br><br>
			<div style="text-align: center; color: #FFF; line-height: 42px;">
				制作方有点<span style="font-size: 24px;">穷</span><br>
				服务器有点<span style="font-size: 24px;">卡</span><br>
				载入速度嘛...<br>
				<span style="font-size: 24px;">你懂的~~~</span><br>
				（长时间没响应，请关闭重新进入。。。）
				<br>
				<div style="position: relative;">
					<div class="loadingfloatWord" style="left: 100%;">(ノ=Д=)ノ┻━┻     坑爹哇~~~~~~~~~</div><br>
					<div class="loadingfloatWord" style="left: 150%;">(╯°Д°)╯︵┴┴    还没好~~~~~~~~~</div>
				</div>
			</div>
		</div>
	</div>
	<div id="bg" class="bg" style="visibility: hidden;">
		<div class="container">
			<img id="bgimg" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/BG.png" style="position: fixed; width: 100%; top: 0; z-index: -1;" />
		</div>
	</div>
		<div id="nav" class="nav nav-fixed">
		<div class="container" style="position: relative; overflow: inherit;">
			<div class="nav-table">
				<div class="nav-td nav_item active" data="lottery" onclick="location.href='http://www.onesword.cn/addon/Scratch/Scratch/show/id/<?php echo ($_GET['id']); ?>.html'">
					<img class="no" src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/IconLottery.png" style="width: 20.833333%;" />
					<div class="title"><span>抽</span>奖</div>
				</div>
				<div class="nav-td" data="onesword" onclick="location.href='<?php echo ($img_res["link"]); ?>'">
					<img class="no" src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/IconInfo.png" style="width: 20.833333%;" />
					<div class="title"><span>实</span>景</div>
				</div>
				<div class="nav-td" data="exchange_temp" onclick="location.href='/addon/Scratch/Scratch/exchange_online/id/<?php echo ($_GET['id']); ?>/wechat_card_js=1'">
					<img class="no" src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/IconAbout.png" style="width: 20.833333%;" />
					<div class="title"><span>兑</span>换</div>
				</div>
			</div>
			<div style="position: absolute; width: 20px; height: 200%; left: -20px; top: 0; background-color: #FFF;"></div>
			<div style="position: absolute; width: 20px; height: 200%; right: -20px; top: 0; background-color: #FFF;"></div>
		</div>
	</div>
	<div class="main-top"></div>
	
	<div id="main" class="main" style="visibility: hidden;">
		<div id="content-box" class="container">
			<div id="lottery" class="content">
				<div style="position: relative; z-index: 1000;">
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/EnterBG.png" style="width: 78.333333%; left: 10.833333%; top: 20%;" />
						<?php if(empty($img_res["img00"])): $img_src = ADDON_PUBLIC_PATH.'/imgs/Word1.png'; ?>
						<?php else: ?>
							<?php $img_src = get_cover($img_res['img00'],'path'); $img_src = ''.$img_src; endif; ?>
					<img class="animate-word1" _src="<?php echo ($img_src); ?>" style="width: 26.388889%; left: 35.9%; top: 47.5%;" />
						<?php if(empty($img_res["img01"])): $img_src = ADDON_PUBLIC_PATH.'/imgs/Word2.png'; ?>
						<?php else: ?>
							<?php $img_src = get_cover($img_res['img01'],'path'); $img_src = ''.$img_src; endif; ?>
					<img class="animate-word2" _src="<?php echo ($img_src); ?>" style="width: 26.388889%; left: 35.9%; top: 47.5%;" />
					<img class="gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Gift.png" style="width: 31.527778%; left: 2.5%; top: 54.1%;" />
					<div class="gravity-sensor" style="position: absolute; width: 34.722222%; left: 30.6%; top: 6.8%;">
						<?php if(empty($img_res["img02"])): $img_src = ADDON_PUBLIC_PATH.'/imgs/FirstPrize.png'; ?>
						<?php else: ?>
							<?php $img_src = get_cover($img_res['img02'],'path'); $img_src = ''.$img_src; endif; ?>
						<img _src="<?php echo ($img_src); ?>" style="width: 100%; left: 0;" />
						<img class="animate-rotate" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/FirstPrize0.png" style="width: 100%; left: 0;" onclick="setTop();" />
					</div>
					<div class="gravity-sensor" style="position: absolute; width: 34.722222%; left: 63.7%; top: 20.3%;">
						<?php if(empty($img_res["img03"])): $img_src = ADDON_PUBLIC_PATH.'/imgs/SecondPrize.png'; ?>
						<?php else: ?>
							<?php $img_src = get_cover($img_res['img03'],'path'); $img_src = ''.$img_src; endif; ?>
						<img _src="<?php echo ($img_src); ?>" style="width: 100%; left: 0;" />
						<img class="animate-rotate" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/SecondPrize0.png" style="width: 100%; left: 0;" onclick="setTop();" />
					</div>
					<div class="gravity-sensor" style="position: absolute; width: 34.722222%; left: 63.7%; top: 60.3%;">
						<?php if(empty($img_res["img04"])): $img_src = ADDON_PUBLIC_PATH.'/imgs/ThirdPrize.png'; ?>
						<?php else: ?>
							<?php $img_src = get_cover($img_res['img04'],'path'); $img_src = ''.$img_src; endif; ?>
						<img _src="<?php echo ($img_src); ?>" style="width: 100%; left: 0;" />
						<img class="animate-rotate" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/ThirdPrize0.png" style="width: 100%; left: 0;" onclick="setTop();" />
					</div>
				</div>
				<div class="animate" style="position: relative; z-index: 900; overflow: hidden;">
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/rape.png" style="width: 0.555556%; left: 45.6%; top: 4%;" />
					<img class="up" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/WhaleBig.png" style="width: 92.638889%; left: 3.7%; top: 22.5%;" />
					<div id="guajang" class="expand delay0_5" style="position: absolute; width: 72.222222%; left: 18.4%; top: 27.8%;">
						<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/BubbleBG.png" style="position: relative; width: 100%; left: 0; top: 0;" />
						<div id="scratch" style="position: absolute; left: 11%; top: 41.5%; -webkit-transform-origin: left top; transform-origin: left top;">
							<?php if ($error) { ?>
								<div class="prize_text" style="position: absolute; width: 405px; height: 82px; line-height: 82px; font-size: 32px; color: #FB3814;"><?php echo ($error); ?></div>
								<img id="areaImg" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Area.png" style="width: 405px; height: 82px; display:none;" />
								<canvas style="display:none" />
							<?php } else { ?>
								<!-- 抽奖信息 -->
								<div class="prize_text" style="display:none; position: absolute; width: 405px; height: 82px; line-height: 82px; font-size: 32px; color: #FF4B64;"><?php echo ($prize["title"]); ?></div>
								<img id="areaImg" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Area.png" style="width: 405px; height: 82px;" />
								<canvas width="405" height="82" style="position: relative;"></canvas>
							<?php } ?>
						</div>
					</div>
					<img class="expand delay1 gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/WhaleLittle.png" style="width: 22.083333%; left: 72%; top: 76.8%;" />
					<img class="float delay1_5" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Bubble.png" style="width: 4.388889%; left: 51.4%; top: 32.2%;" />
					<img class="float delay2" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Bubble.png" style="width: 6.144444%; left: 14.6%; top: 76.3%;" />
					<img class="float delay2_5" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Bubble.png" style="width: 10.972222%; left: 53.1%; top: 87.2%;" />
				</div>
				<div class="animate" style="position: relative; z-index: 800; overflow: hidden;">
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/rape.png" style="width: 0.555556%; left: 65.4%; top: -19.1%;" />
					<div class="up" style="position: absolute; width: 100%; left: 0; top: 0; text-align: left;">
						<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/AddBG.png" style="position: relative; width: 84.166667%; left: 2%; top: 0;" />
						<div class="word" style="position: absolute; width: 70px; left: 50%; top: 27.4%; color: #FB3814; font-size: 56px; line-height: 36px; text-align: center;"><?php echo ((isset($remain_count) && ($remain_count !== ""))?($remain_count):0); ?></div>
						<div class="word" style="position: absolute; width: 396px; left: 22%; top: 54.4%;color: #BE5B17; font-size: 28px; line-height: 30px; text-align: left;">♪ 关注『诺言法式旅馆』公众号，可获得<span style="color: #FB3814;"><?php echo ($data['addNum1']); ?></span>次刮奖机会
						<br>♪ 首次分享到朋友圈，可获得<span style="color: #FB3814;"><?php echo ($data['addNum2']); ?></span>次刮奖机会
						<br>♪ 每召唤<span style="color: #FB3814;"><?php echo ($data['addNum3']); ?></span>个小伙伴扫描神秘代码关注『诺言法式旅馆』公众号，可获得<span style="color: #FB3814;">1</span>次刮奖机会</div>
						<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Follow<?php echo ((isset($userInfo["subscribe"]) && ($userInfo["subscribe"] !== ""))?($userInfo["subscribe"]):0); ?>.png" style="width: 24.027778%; left: 75.8%%; top: 47%;" onclick="<?php if($userInfo["subscribe"] == 0): ?>window.location.href='http://mp.weixin.qq.com/s?__biz=MzA4ODc1MDMwMQ==&mid=201184917&idx=1&sn=173422068c56979c86e00cb7f785ed3d#rd';<?php endif; ?>" />
						<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Share<?php echo ((isset($ScratchMember["share"]) && ($ScratchMember["share"] !== ""))?($ScratchMember["share"]):0); ?>.png" style="width: 24.027778%; left: 73.8%%; top: 60%;" onclick="<?php if($ScratchMember["share"] == 0): ?>share_timeline();<?php endif; ?>" />
					</div>
				</div>
				<div class="animate" style="position: relative; z-index: 700; overflow: hidden;">
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/rape.png" style="width: 0.555556%; left: 12.8%; top: -2.1%;" />
					<div class="up" style="position: absolute; width: 17.777778%; left: 6.6%; top: 26.4%;">
						<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Moon.png" style="position: static; width: 100%;" />
					</div>
					<img class="gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Star.png" style="width: 3.2%; left: 4%; top: 23%;" />
					<img class="gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Star.png" style="width: 4%; left: 26%; top: 40%;" />
					<img class="gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Star.png" style="width: 6.111111%; left: 28.6%; top: 26.4%;" />
					<img class="gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Phone.png" style="width: 22.361111%; left: 9.5%; top: 59.2%;" />
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/QRCode.png" style="width: 73.611111%; left: 34.2%; top: 0;" />
					<div style="position: absolute; width: 42.916667%; left: 41%; top: 40.035%; -webkit-transform: rotateZ(15.5deg); transform: rotateZ(15.5deg);">
						<img id="" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/XiaoHuoBan.png" style="width: 100%; left: 0%; top: 0%;" />
						<div class="word" style="position: absolute; width: 70px; left: 39.6%; top: 22%; color: #FB3814; font-size: 56px; line-height: 56px; text-align: center;"><?php echo ((isset($ScratchMember["subscribeNum"]) && ($ScratchMember["subscribeNum"] !== ""))?($ScratchMember["subscribeNum"]):0); ?></div>
						<div id="loading-qrcode" class="spinner qrcode" style="position: absolute; width: 100%; height: 40%; padding: 30% 0; background-color: #FFF; display: none;">
						   <div class="rect1"></div>
						   <div class="rect2"></div>
						   <div class="rect3"></div>
						   <div class="rect4"></div>
						   <div class="rect5"></div>
						</div>
						<img id="qrcode" class="no"  style="width: 100%; left: 0; top: 0;" _src='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='>
						<img id="qrcodeMask" style="position: relative; width: 100%; left: 0; top: 0;" _src='<?php echo ADDON_PUBLIC_PATH;?>/imgs/QRCodeClover.png'>
					</div>
				</div>
				<div class="animate" style="position: relative; z-index: 600; overflow: hidden;">
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/rape.png" style="width: 0.555556%; left: 49.8%; top: -3.8%;" />
					<img class="gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Cloud2.png" style="width: 12.361111%; left: 6.8%; top: 52%;" />
					<div class="up" style="position: absolute; width: 100%; height: 100%; left: 0; top: 0;">
						<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Bird.png" style=" width: 97.777778%; left: 2.3%; top: 13.8%;" />
						
						<div class="word" style="position: absolute; width: 72px; left: 49.2%; top: 49.4%; color: #FB3814; font-size: 56px; line-height: 36px; text-align: center;"><?php echo ((isset($myPrizesArray[$prizes[0]['id']]) && ($myPrizesArray[$prizes[0]['id']] !== ""))?($myPrizesArray[$prizes[0]['id']]):0); ?></div>
						<div class="word" style="position: absolute; width: 72px; left: 49.2%; top: 61.6%; color: #FB3814; font-size: 56px; line-height: 36px; text-align: center;"><?php echo ((isset($myPrizesArray[$prizes[1]['id']]) && ($myPrizesArray[$prizes[1]['id']] !== ""))?($myPrizesArray[$prizes[1]['id']]):0); ?></div>
						<div class="word" style="position: absolute; width: 72px; left: 49.2%; top: 73.4%; color: #FB3814; font-size: 56px; line-height: 36px; text-align: center;"><?php echo ((isset($myPrizesArray[$prizes[2]['id']]) && ($myPrizesArray[$prizes[2]['id']] !== ""))?($myPrizesArray[$prizes[2]['id']]):0); ?></div>
					</div>
					<img class="gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Cloud1.png" style="width: 17.361111%; left: 76.8%; top: 76.2%;" />
					<img class="animate-cloud3" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Cloud3.png" style="width: 22.777778%; left: -22.777778%; top: 63%;" />
				</div>
				<div style="position: relative; z-index: 500; overflow: hidden;">
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/AwardDisplay.png" style="width: 17.777778%; left: 10.6%; top: 13.4%;" />
						<?php if(empty($img_res["img05"])): $img_src = ADDON_PUBLIC_PATH.'/imgs/Award1.png'; ?>
						<?php else: ?>
							<?php $img_src = get_cover($img_res['img05'],'path'); $img_src = ''.$img_src; endif; ?>
					<img _src="<?php echo ($img_src); ?>" style="width: 58.333333%; left: 33.9%; top: -0.7%;" onclick="window.location.href='<?php echo ((isset($img_res["link01"]) && ($img_res["link01"] !== ""))?($img_res["link01"]):'/addon/Weicj/Weicj/index/id/2.html'); ?>';" />
						<?php if(empty($img_res["img07"])): $img_src = ADDON_PUBLIC_PATH.'/imgs/Award3.png'; ?>
						<?php else: ?>
							<?php $img_src = get_cover($img_res['img07'],'path'); $img_src = ''.$img_src; endif; ?>
					<img _src="<?php echo ($img_src); ?>" style="width: 40.128889%; left: 56.7%; top: 54.3%;" onclick="window.location.href='<?php echo ((isset($img_res["link01"]) && ($img_res["link01"] !== ""))?($img_res["link01"]):'/addon/Weicj/Weicj/index/id/1.html'); ?>';" />
					<img class="gravity-sensor" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/ChristmasHat.png" style="width: 18.75%; left: 22.2%; top: 8.2%;" />
						<?php if(empty($img_res["img06"])): $img_src = ADDON_PUBLIC_PATH.'/imgs/Award2.png'; ?>
						<?php else: ?>
							<?php $img_src = get_cover($img_res['img06'],'path'); $img_src = ''.$img_src; endif; ?>
					<img _src="<?php echo ($img_src); ?>" style="width: 37.638889%; left: 30.8%; top: 40.4%;" onclick="window.location.href='<?php echo ((isset($img_res["link01"]) && ($img_res["link01"] !== ""))?($img_res["link01"]):'/addon/Weicj/Weicj/index/id/2.html'); ?>';" />
				</div>
				<div style="position: relative; z-index: 400; overflow: hidden;">
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Grace.png" style="width: 100%; left: 0; top: 43%;" />
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/LastAward.png" style="width: 86.666667%; left: 5.5%; top: 0;" />
					<div class="word" style="position: absolute; width: 360px; left: 23%; top: 26%; font-size: 34px; line-height: 58px; text-align: left; color: #81914D; font-weight: bold; text-shadow: #FFF -1px -1px 0;">
						参与人数 <span style="float: right;"><?php echo ((isset($num_join) && ($num_join !== ""))?($num_join):0); ?></span><br>
						<?php if(is_array($prizes)): $i = 0; $__LIST__ = $prizes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>中<?php echo ($vo["title"]); ?> <span style="float: right;"><?php echo ((isset($prizes_count_array[$vo[id]]) && ($prizes_count_array[$vo[id]] !== ""))?($prizes_count_array[$vo[id]]):0); ?>/<?php echo ($vo['num']); ?></span><br><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Grass1.png" style="width: 29.166667%; left: 18%; top: 61.4%;" />
					<img class="animate-flower" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Flower.png" style="width: 13.75%; left: 10.3%; top: 52.5%;" />
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Grass2.png" style="width: 20.833333%; left: 10.3%; top: 65.3%;" />
					<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Tortoise.png" style="width: 52.083333%; left: 43.3%; top: 33.8%;" />
					<div class="word" style="position: absolute; width: 720px; left: 0%; top: 90%; font-size: 28px; line-height: 58px; text-align: center; color: #EDFDB9;">
						本活动最终解释权归「合肥诺言旅馆管理有限公司」所有
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="alert-good" style="position: fixed; z-index: 999999; display: none; width: 100%; height: 100%; left: 0; top: 0; background-color: rgba(0, 0, 0, .5);" onclick="this.style.display='none';window.location.href='';">
		<div class="container" style="height: 100%;">
			<div style="position: relative; top: 20%;">
				<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/GoodLuck.png" style="position: relative; width: 93.333333%; left: 3.333333%; top: 0;" onclick="event.stopPropagation();"/>
				<img _src="<?php echo (get_picture_url($prize["img_notice"])); ?>" style="position: absolute; width: 35.138889%; left: 25%; top: 33%; font-size: 60px; color: #FFF; line-height: 60px;" onclick="event.stopPropagation();">
				<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/close.png" style="position: absolute; width: 20%; left: 72%; top: 0;"/>
				<img id="batchAddCard" _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Exchange.png" style="position: absolute; width: 15.555556%; left: 41%; top: 102%;" onclick="event.stopPropagation();" />
			</div>
		</div>
	</div>
	<div id="alert-bad" style="position: fixed; z-index: 999999; display: none; width: 100%; height: 100%; left: 0; top: 0; background-color: rgba(0, 0, 0, .5);" onclick="this.style.display='none';window.location.href='';">
		<div class="container" style="height: 100%;">
			<div style="position: relative; top: 30%;">
				<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/BadLuck.png" style="position: relative; width: 82.777778%; left: 6.611111%; top: 0;" onclick="event.stopPropagation();" />
				<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/close.png" style="position: absolute; width: 20%; left: 73%; top: -16%;"/>
			</div>
		</div>
	</div>
	
	<div id="share-timeline" style="position: fixed; z-index: 999999; display: none; width: 100%; height: 100%; left: 0; top: 0;" onclick="this.style.display='none';">
		<div class="container" style="height: 100%; background: rgba(235,172,122,0.8);">
			<div style="position: relative; height: 100%;">
				<img _src="<?php echo ADDON_PUBLIC_PATH;?>/imgs/Point.png" style="position: absolute; width: 91.527778%; right: 0; top: 0;" onclick="event.stopPropagation();" />
			</div>
		</div>
	</div>
	
	<div id="prompt" style="position: fixed; z-index: 999999; display: none; width: 100%; height: 100%; left: 0; top: 0;" onclick="this.style.display='none';">
		<div class="container" style="height: 100%; background: rgba(235,172,122,0.8);">
			<div style="position: relative; height: 100%;">
				<div class="box">
					<div onclick="event.stopPropagation();">
						<div class="title">请输入兑换密码</div>
						<input type="text" />
						<span class="error">Ⅹ</span>
					</div>
					<div class="btns">
						<div class="close">取消</div>
						<div class="ok"><div style="border-left: 1px solid #EEE;">确定</div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		var indexUrl = window.location.href;
		var indexTitle = document.title;
		
		//document.write(unescape("%3Cscript src='/Public/static/jquery-2.0.3.min.js' type='text/javascript'%3E%3C/script%3E"));
		var prize_id = <?php echo (intval($prize["id"])); ?>;
		var prize_count = <?php echo (intval($prize["count"])); ?>;
		var prize_title = '<?php echo ($prize["title"]); ?>';
		var prize_name = '<?php echo ($prize["name"]); ?>';
		var data_id = '<?php echo ($data["id"]); ?>';
		var set_sn_code_url = "<?php echo addons_url('Scratch://Scratch/set_sn_code');?>";
		var get_temp_ticket_url = "<?php echo addons_url('Scratch://Scratch/getTempTicket', array('scene_id' => $scene_id, 'token' => $token));?>";
		var exchange_url = "<?php echo addons_url('Scratch://Scratch/exchange_check');?>";
		//document.write(unescape("%3Cscript src='<?php echo ADDON_PUBLIC_PATH;?>/js/show.js?v=1.0' type='text/javascript'%3E%3C/script%3E"));
		
        var url = "<?php echo addons_url('Scratch://Scratch/shareTimeline');?>";
        var one = <?php echo ((isset($myPrizesArray['38']) && ($myPrizesArray['38'] !== ""))?($myPrizesArray['38']):0); ?>;
        var remain_count = <?php echo ((isset($remain_count) && ($remain_count !== ""))?($remain_count):0); ?>;
		var openid  = "<?php echo ($ScratchMember["openid"]); ?>";
        var token = "<?php echo ($ScratchMember["token"]); ?>";
        var target_id = "<?php echo ($ScratchMember["target_id"]); ?>";
        var urlreturn = "<?php echo ($urlreturn); ?>";
		//document.write(unescape("%3Cscript src='<?php echo ADDON_PUBLIC_PATH;?>/js/weixin.js' type='text/javascript'%3E%3C/script%3E"));
		
		var body = document.getElementsByTagName('body')[0];
		var js = ['/Public/static/jquery-2.0.3.min.js', '<?php echo ADDON_PUBLIC_PATH;?>/js/show.js?v=<?php echo SITE_VERSION;?>'];
		dynamicLoad(0);
		function dynamicLoad(i) {
			if(i >= js.length) {
				return false;
			}
			var script = document.createElement('script');
			script.setAttribute('type', 'text/javascript');
			script.setAttribute('src', js[i]);
			body.appendChild(script); 
			script.onload = script.onreadystatechange=function(){  
			   	if(!this.readyState || this.readyState=='loaded' || this.readyState == 'complete'){  
			   		dynamicLoad(i + 1); 
			   	}  
			   	script.onload = script.onreadystatechange = null;  
			}  
		} 
		
		<?php if(empty($img_res["share_img"])): $img_src = SITE_URL.'/Addons/Scratch/View/default/Public/comeon-1.jpg'; ?>
		<?php else: ?>
			<?php $img_src = get_cover($img_res['share_img'],'path'); $img_src = SITE_URL.$img_src; endif; ?>
		
		<?php if(empty($img_res["share_text"])): $share_text = '诺言法式旅馆-合肥大学城店特邀嘉宾专用抽奖链接(限内部发,记得删除括弧内容)'; ?>
		<?php else: ?>
			<?php $share_text = $img_res['share_text']; endif; ?>
		
		var imgUrl = "<?php echo ($img_src); ?>";
        var lineLink = "<?php echo SITE_URL;?>/addon/Scratch/Scratch/show/id/"+data_id+".html";
        var descContent = '此为VIP通道，中奖率超高，切忌外传，否则中奖人数过多会导致公司发奖不过来资金断链倒闭。切记切记！';
        var shareTitle = "<?php echo ($share_text); ?>";
        var appid = 0;
        
	</script>
	
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
		function batchAddCard(obj){
			var timestamp = $(obj).attr('timestamp');
			var signature = $(obj).attr('signature');
			var card_id = $(obj).attr('card_id');
			var sn_id = $(obj).attr('sn_id');
			if(!timestamp || !signature || !card_id || !sn_id) {
				return false;
			}
			wx.addCard({
				cardList: [{
					cardId: card_id,
				    cardExt: '{"code":"","openid":"","timestamp":"'+timestamp+'","signature":"'+signature+'"}'
				}], // 需要添加的卡券列表
				success: function (res) {
					$('#alert-good').hide();
					var cardList = res.cardList; // 添加的卡券列表信息
					//alert('ajax:' + sn_id);
					$.ajax({
						type: "GET",
						url: "<?php echo addons_url('Scratch://Sn/set_use');?>",
						data: {id:sn_id},
						dataType: "json",
						success: function(data){
							//alert('ajax-ok:' + JSON.stringify(data));
							if(data.status)
								location.reload();						             		
						}
					});
				}
			});
		}
		
		wx.config({
		    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		    appId: '<?php echo ($signPackage["appId"]); ?>', // 必填，公众号的唯一标识
		    timestamp: <?php echo ($signPackage["timestamp"]); ?>, // 必填，生成签名的时间戳
		    nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>', // 必填，生成签名的随机串
		    signature: '<?php echo ($signPackage["signature"]); ?>',// 必填，签名，见附录1
		    jsApiList: [
		    	'onMenuShareTimeline',
		    	'onMenuShareAppMessage',
		    	'addCard'
		    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
		});
		
		wx.ready(function(){
			//发送给朋友
			wx.onMenuShareAppMessage({
			    title: shareTitle, // 分享标题
			    desc: descContent, // 分享描述
			    link: lineLink, // 分享链接
			    imgUrl: imgUrl, // 分享图标
			    //type: '', // 分享类型,music、video或link，不填默认为link
			    //dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			    success: function () { 
			        // 用户确认分享后执行的回调函数
			        
			    },
			    cancel: function () { 
			        // 用户取消分享后执行的回调函数
			    }
			});
			//分享到朋友圈
			wx.onMenuShareTimeline({
			    title: shareTitle, // 分享标题
			    link: lineLink, // 分享链接
			    imgUrl: imgUrl, // 分享图标
			    success: function () { 
			        // 用户确认分享后执行的回调函数
			        $.get(url,{"openid":openid,"token":token,"target_id":target_id},function(data){
						alert(data.info);
						if(data.status){
							location.href='';
						}
					},'json');
			    },
			    cancel: function () { 
			        // 用户取消分享后执行的回调函数
			    }
			});
			// 添加卡券
			document.querySelector('#batchAddCard').addEventListener('click', function(e) {
		        batchAddCard(this);
		    });
		});
		
	</script>
</body>
</html>