<?php defined('IN_IA') or exit('Access Denied');?>﻿<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>

    <title><img src="<?php  if(!empty($_W['setting']['copyright']['blogo'])) { ?><?php  echo tomedia($_W['setting']['copyright']['blogo'])?><?php  } else { ?><?php  } ?>" class="pull-left" width="110px" height="35px"></title>

    <link href="./resource/affordable/css/popnews.css" rel="stylesheet" />

    <link href="./resource/affordable/css/iconfont.css" rel="stylesheet" />

    <link href="./resource/affordable/css/style.css" rel="stylesheet" />

    <script src="./resource/affordable/js/jquery.min.js" type="text/javascript"></script>	
<style type="text/css">
	.input-group .input-group-addon{
	    position: absolute;
	    z-index: 99;
	    left: 2px;
	    top: 4px;
	    background: transparent;
	    border:none;
	}
</style>
</head>

<body>        
<form  class="form-box" method="post" role="form">    
	<div class="new-bg">
		<img src="../web/resource/affordable/images/logo.png" alt="logo" style="width: 166px;position: absolute;left: 1%;top: 5%;">
	</div>


    <div class="xiaokeduo-login-container" style="top:40%">

        <!-- <div class="qr-code">

            <div class="qr-code-content">

                <h3 class="qr-code-title"><?php  echo $_W['setting']['copyright']['notice'];?></h3>

                <img class="qr-code-img" src="<?php  if(!empty($_W['setting']['copyright']['qrcode'])) { ?><?php  echo tomedia($_W['setting']['copyright']['qrcode'])?><?php  } else { ?><?php  } ?>" width="145" height="145" />

                <p class="text">扫一扫加入官方公众号立即体验1</p>

            </div>

        </div> -->

        <div class="login-content">

            <!-- <div class="login-logo"></div> -->
            <div><h4>账号登录</h4></div>

            <div class="form-group">

				<form action="" method="post" role="form" id="form1" onsubmit="return formcheck();">

					<div class="form-group input-group">

						<span id="message" class="text-danger"></span>

					</div>

					<div class="form-group input-group">

						<div class="input-group-addon"><img src="./resource/images/icon-user.png" alt="" /></div>

						<input name="username" type="text" class="form-control" placeholder="请输入用户名登录">

					</div>

					<div class="form-group input-group">

						<div class="input-group-addon"><img src="./resource/images/icon-pass.png" alt="" /></div>

						<input name="password" type="password" class="form-control" placeholder="请输入登录密码">

					</div>

					<?php  if(!empty($_W['setting']['copyright']['verifycode'])) { ?>

					<div class="form-group input-group">

						<div class="input-group-addon"><img src="./resource/images/icon-code.png" alt="" /></div>

						<input name="verify" type="text" class="form-control" placeholder="请输入验证码">

						<a href="javascript:;" id="toggle" class="input-group-btn imgverify"><img id="imgverify" src="<?php  echo url('utility/code')?>" title="点击图片更换验证码" /></a>

					</div>

					<?php  } ?>
					<p><input type="checkbox" name="" id="remePass"> </p><label for="remePass">记住密码</label>
					<div class="login-submit text-center">

						<input type="submit" id="submit" name="submit" value="登录" class="btn btn-primary" />

						<input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />

					</div>

					</div>

                        <div class="other-operations">

                        <!-- <a class="fl" href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $_W['setting']['copyright']['qq'];?>&site=qq&menu=yes">忘记密码？</a> -->

                        <p class="fr">还没有账号? <a href="<?php  echo url('user/register');?>">免费注册</a></p>

					</div>

				</form>

			</div>

		</div>

	</div>

</div>
</form>
<script>

function formcheck() {

	if($('#remember:checked').length == 1) {

		cookie.set('remember-username', $(':text[name="username"]').val());

	} else {

		cookie.del('remember-username');

	}

	return true;

}

var h = document.documentElement.clientHeight;

$(".login").css('min-height',h);

$('#toggle').click(function() {

	$('#imgverify').prop('src', '<?php  echo url('utility/code')?>r='+Math.round(new Date().getTime()));

	return false;

});

<?php  if(!empty($_W['setting']['copyright']['verifycode'])) { ?>

	$('#form1').submit(function() {

		var verify = $(':text[name="verify"]').val();

		if (verify == '') {

			alert('请填写验证码');

			return false;

		}

	});

<?php  } ?>

</script>

				

  <!--   <div class="subfooter">

        <p><small class="text-muted"><font color="#FFFFFF" size="2.5"><?php  echo $_W['setting']['copyright']['footerright'];?></small></p>

        <p><small class="text-muted"><font color="#NaNNaNNaN"><?php  if(empty($_W['setting']['copyright']['footerleft'])) { ?>Powered by v<?php echo IMS_VERSION;?> &copy; 2014-2015 <?php  } else { ?><?php  echo $_W['setting']['copyright']['footerleft'];?><?php  } ?></small></p>

		<p><small class="text-muted"><font color="#NaNNaNNaN"><?php  echo $_W['setting']['copyright']['icp'];?></small></p>

    </div> -->

    </div>

</body>

</html>

