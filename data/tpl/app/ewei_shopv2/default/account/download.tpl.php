<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	body{
		background: url(../addons/ewei_shopv2/static/images/xiazaibg.jpg);
		background-size:100% 100%; 
	}
	.main{
		position: absolute;
	    top: 2.2rem;
	    bottom: 0;
	    background: url(../addons/ewei_shopv2/static/images/xiazaibg.jpg);
	    background-size: 100% 100%;
	    width: 100%;
	    z-index: 1;
	}
	.main a{
		position: absolute;
		line-height: 35px;
		border:1px solid white;
		border-radius: 10px;color:white;
		width: 80%;left:10%;text-align: center;
		top:30%;
	}
	.main a:nth-of-type(2){
		top:40%;
	}
	#share{
		top:50%;
	}
</style>
<script type="text/javascript" src="//res.cdn.openinstall.io/openinstall.js"></script>
<!-- <body> -->
<div class='fui-page  fui-page-current'>
	<div class="fui-header">

        <div class="fui-header-left">

            <a class="back"> </a>

        </div>

        <div class="title">下载</div>

        <div class="fui-header-right" data-nomenu="true"></div>

    </div>
	<div class="main">
		<a href="javascript:;" id="btn_down" class="button">安卓下载</a>
		<!-- <a href="https://copy.im/a/X488ZK">IOS下载</a> -->
		<!-- <a href="javascript:;">IOS下载</a> -->

		<!-- <a href="#" id="share" ids="123">点击分享</a> -->
		<input type="text" name="" value="" id="shareVal" style="opacity: 0">
	</div>
<!-- </body> -->
</div>
<script type="text/javascript">
	// $('.main > a').click(function () {
	// 	alert('暂未开放！')
	// })
	//openinstall初始化时将与openinstall服务器交互，应尽可能早的调用
	/*web页面向app传递的json数据(json string/js Object)，应用被拉起或是首次安装时，通过相应的android/ios api可以获取此数据*/
	var data = OpenInstall.parseUrlParams(); //openinstall.js中提供的工具函数，解析url中的所有查询参数
	console.log(data);
	new OpenInstall({
	/*appKey必选参数，openinstall平台为每个应用分配的ID*/
	appKey: "kpi7rj",
	/*可选参数，自定义android平台的apk下载文件名，只有apk在openinstall托管时才有效；个别andriod浏览器下载时，中文文件名显示乱码，请慎用中文文件名！*/
	//apkFileName : 'com.fm.openinstalldemo-v2.2.0.apk',
	/*可选参数，是否优先考虑拉起app，以牺牲下载体验为代价*/
	preferWakeup: true,
	/*自定义遮罩的html*/
	mask: function() {
	return "<div id='openinstall_shadow' style='position:fixed;left:0;top:0;filter:alpha(opacity=50);width:100%;height:100%;z-index:10000;'></div>"
	},
	/*openinstall初始化完成的回调函数，可选*/

	//暂时没有使用拉起参数
	onready: function() {
	var m = this,
	button = document.getElementById("btn_down");
	button.style.visibility = "visible";
	/*在app已安装的情况尝试拉起app*/
	m.schemeWakeup();
	/*用户点击某个按钮时(假定按钮id为downloadButton)，安装app*/
	button.onclick = function() {
	m.wakeupOrInstall();
	// // setTimeout(function(){
	// if(/android/.test(navigator.userAgent.toLowerCase())){
	// window.location.href = android;
	// }else{
	// window.location.href = "itms-services:///?action=download-manifest&url=" + ios;
	// setTimeout(function(){
	// $(".btn_down")[0].innerHTML = "返回桌面查看下载进度！";
	// }, 3000);
	// }
	// // }, 500);
	return false;
	}
	}
	}, data);

	// require(['core'],function(core){
	// 	$(function(){
	// 	var str = location.href;
	// 	console.log(str);
	// 	$('#shareVal').val(str);


	// 	$('#share').click(function(){
	// 		copyNum();
	// 	})

    //     function copyNum(){
    //         var NumClip=document.getElementById("shareVal");
    //         var NValue=NumClip.value;
    //         var valueLength = NValue.length;
    //         selectText(NumClip, 0, valueLength);
    //         if(document.execCommand('copy', false, null)){
    //             document.execCommand('copy', false, null)// 执行浏览器复制命令
    //            	alert('已成功复制网址，发给好友即刻分享')
    //         }else{
    //             console.log("不兼容");
    //         }

    //         }
    //     // input自带的select()方法在苹果端无法进行选择，所以需要自己去写一个类似的方法
    //     // 选择文本。createTextRange(setSelectionRange)是input方法
    //     function selectText(textbox, startIndex, stopIndex) {
    //         if(textbox.createTextRange) {//ie
    //             var range = textbox.createTextRange();
    //             range.collapse(true);
    //             range.moveStart('character', startIndex);//起始光标
    //             range.moveEnd('character', stopIndex - startIndex);//结束光标
    //             range.select();//不兼容苹果
    //         }else{//firefox/chrome
    //             textbox.setSelectionRange(startIndex, stopIndex);
    //             textbox.focus();
    //         }
    //     }
	// })
	// })
	
		
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>




