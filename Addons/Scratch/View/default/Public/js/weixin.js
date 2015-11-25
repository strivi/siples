var imgUrl = "http://www.promisehotel.cn/Addons/Scratch/View/default/Public/comeon.png";
        var lineLink = "http://www.promisehotel.cn/addon/Scratch/Scratch/show/id/" + target_id + ".html";
        var descContent = '0元入住啦！万元大礼等你来拿。。。';
        var shareTitle = '「诺言法式旅馆-合肥大学城店」开业免费啦，小伙伴们，速度来抽奖！';
        var appid = 0;
         
        //发送给朋友 
        function shareFriend() {
            WeixinJSBridge.invoke('sendAppMessage',{
                "appid": appid,
                "img_url": imgUrl,
                "img_width": "200",
                "img_height": "200",
                "link": lineLink,
                "desc": descContent,
                "title": shareTitle
            }, function(res) {
                //_report('send_msg', res.err_msg);
            })
        }
        
        //分享到朋友圈     
        function shareTimeline() {
            WeixinJSBridge.invoke('shareTimeline',{
                "appid": appid,
                "img_url": imgUrl,
                "img_width": 200,
                "img_height": 200,
                "link": lineLink,
                "desc": descContent,
                "title": shareTitle
            }, function(res) {
                //分享成功后进行的操作
                //alert(res.err_msg);
                $.get(url,{"openid":openid,"token":token,"target_id":target_id},function(data){
					alert(data.info);
					if(data.status){
						location.href='';
					}
                },'json');
            });
        }
        // 当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。
        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
            // 发送给好友
            WeixinJSBridge.on('menu:share:appmessage', function(argv){
                shareFriend();
            });
            // 分享到朋友圈
            WeixinJSBridge.on('menu:share:timeline', function(argv){
                shareTimeline();
            });
        }, false);