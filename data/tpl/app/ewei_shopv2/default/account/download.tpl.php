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
		<a href="javascript:;">安卓下载</a>
		<!-- <a href="https://copy.im/a/X488ZK">IOS下载</a> -->
		<a href="javascript:;">IOS下载</a>

		<!-- <a href="#" id="share" ids="123">点击分享</a> -->
		<input type="text" name="" value="" id="shareVal" style="opacity: 0">
	</div>
<!-- </body> -->
</div>
<script type="text/javascript">
	$('.main > a').click(function () {
		alert('暂未开放！')
	})


	require(['core'],function(core){
		$(function(){
		var str = location.href;
		console.log(str);
		$('#shareVal').val(str);


		$('#share').click(function(){
			copyNum();
		})

        function copyNum(){
            var NumClip=document.getElementById("shareVal");
            var NValue=NumClip.value;
            var valueLength = NValue.length;
            selectText(NumClip, 0, valueLength);
            if(document.execCommand('copy', false, null)){
                document.execCommand('copy', false, null)// 执行浏览器复制命令
               	alert('已成功复制网址，发给好友即刻分享')
            }else{
                console.log("不兼容");
            }

            }
        // input自带的select()方法在苹果端无法进行选择，所以需要自己去写一个类似的方法
        // 选择文本。createTextRange(setSelectionRange)是input方法
        function selectText(textbox, startIndex, stopIndex) {
            if(textbox.createTextRange) {//ie
                var range = textbox.createTextRange();
                range.collapse(true);
                range.moveStart('character', startIndex);//起始光标
                range.moveEnd('character', stopIndex - startIndex);//结束光标
                range.select();//不兼容苹果
            }else{//firefox/chrome
                textbox.setSelectionRange(startIndex, stopIndex);
                textbox.focus();
            }
        }
	})
	})
	
		
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>




