<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php  if(isset($title)) $_W['page']['title'] = $title?><?php  if(!empty($_W['page']['title'])) { ?><?php  echo $_W['page']['title'];?> - <?php  } ?><?php  if(empty($_W['page']['copyright']['sitename'])) { ?><?php  if(IMS_FAMILY != 'x') { ?><?php  echo $site['sitetitle'];?><?php  } ?><?php  } else { ?><?php  echo $_W['page']['copyright']['sitename'];?><?php  } ?></title>
<meta name="keywords" content="<?php  if(empty($_W['page']['copyright']['keywords'])) { ?><?php  if(IMS_FAMILY != 'x') { ?><?php  echo $site['sitetitle'];?>QQ：583489939<?php  } ?><?php  } else { ?><?php  echo $_W['page']['copyright']['keywords'];?><?php  } ?>" />
<meta name="description" content="<?php  if(empty($_W['page']['copyright']['description'])) { ?><?php  if(IMS_FAMILY != 'x') { ?><?php  echo $site['sitetitle'];?>QQ：583489939<?php  } ?><?php  } else { ?><?php  echo $_W['page']['copyright']['description'];?><?php  } ?>" />
<link rel="shortcut icon" href="<?php  echo $_W['siteroot'];?><?php  echo $_W['config']['upload']['attachdir'];?>/<?php  if(!empty($_W['setting']['copyright']['icon'])) { ?><?php  echo $_W['setting']['copyright']['icon'];?><?php  } else { ?>images/global/wechat.jpg<?php  } ?>" />

<link href="./resource/css/bootstrap.min.css" rel="stylesheet">
<link href="./resource/css/font-awesome.min.css" rel="stylesheet">
<link href="./resource/css/register.css" rel="stylesheet">
<script>var require = { urlArgs: 'v=2016041115' };</script>

<!--<script src="./resource/js/lib/jquery-1.11.1.min.js"></script>-->
<script src="./resource/js/lib/jquery-1.7.2.min.js"></script>
<!--[if lt IE 9]>
    <script src="./resource/js/html5shiv.min.js"></script>
    <script src="./resource/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
if(navigator.appName == 'Microsoft Internet Explorer'){
    if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
        alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
    }
}

window.sysinfo = {
    'siteroot': 'http://wx176021.biezao.com/',
    'siteurl': 'http://yfx.biezao.com/web/index.php?c=user&a=register&',
    'attachurl': 'http://yfx.biezao.com/attachment/',
    'cookie' : {'pre': 'baca_'}
};
</script>
</head>
<body>
<script src="./resource/js/require.js"></script> 
<script src="./resource/js/app/config.js"></script> 
<script>
require(['jquery', 'util'], function($, u){
	$('#form1').submit(function(){
		if($.trim($(':text[name="username"]').val()) == '') {
			u.message('没有输入用户名.', '', 'error');
			return false;
		}
		if($('#password').val() == '') {
			u.message('没有输入密码.', '', 'error');
			return false;
		}
		if($('#password').val() != $('#repassword').val()) {
			u.message('两次输入的密码不一致.', '', 'error');
			return false;
		}
/* 		<?php  if(is_array($extendfields)) { foreach($extendfields as $item) { ?>
		<?php  if($item['required']) { ?>
			if (!$.trim($('[name="<?php  echo $item['field'];?>"]').val())) {
				util.message('<?php  echo $item['title'];?>为必填项，请返回修改！', '', 'error');
				return false;
			}
		<?php  } ?>
		<?php  } } ?>
		*/
		<?php  if($setting['register']['code']) { ?>
			if($.trim($(':text[name="code"]').val()) == '') {
				u.message('没有输入验证码.', '', 'error');
				return false;
			}
		<?php  } ?>
	});
});
</script>
<style>
	body{ background-color: #fff;}
</style>
<div class="register">
  <div class="registerCont registerHeader clearfix">
    <div class="logo"><a href="./?refresh" ><img src="<?php  if($site['sitelogo']) { ?>../attachment/<?php  echo $site['sitelogo'];?><?php  } else { ?>./resource/images/logo.png<?php  } ?>" alt="" /></a></div>
    <div class="header_text">免费注册</div>
    <div class="header_text_right">已有账号 <a href="<?php  echo url('user/login');?>">登录</a></div>
  </div>
  <div class="clearfix">
    <div class="registerCont registerForm">
      <div class="panel-body">
        <form action="" method="post" role="form" id="form1">
          <div class="form-group">
            <label> <span style="color:red">*</span> 用户名:</label>
            <input name="username" type="text" class="form-control" placeholder="请输入用户名">
          </div>
          <div class="form-group">
            <label> <span style="color:red">*</span> 密码:</label>
            <input name="password" type="password" id="password" class="form-control" placeholder="请输入密码">
          </div>
          <div class="form-group">
            <label> <span style="color:red">*</span> 确认密码:</label>
            <input name="password" type="password" id="repassword" class="form-control" placeholder="请再次输入密码">
          </div>
          <?php  if($extendfields) { ?>
          <?php  if(is_array($extendfields)) { foreach($extendfields as $item) { ?>
          <div class="form-group">
            <label><?php  if($item['required']) { ?><span style="color:red">*</span><?php  } ?><?php  echo $item['title'];?>：</label>
            <?php  echo tpl_fans_form($item['field'])?> </div>
          <?php  } } ?>
          <?php  } ?> 
          <?php  if($setting['register']['code']) { ?>
          <div class="form-group">
            <label style="display:block;"> <span style="color:red">*</span> 验证码:</label>
            <div class="formGroup-right">
              <input name="code" type="text" class="form-control" placeholder="请输入验证码" style="width:50%;display:inline;">
              <img src="<?php  echo url('utility/code');?>" class="img-rounded pull-right" style="cursor:pointer;max-width:120px;" onclick="this.src='<?php  echo url('utility/code');?>' + Math.random();" /></div>
          </div>
          <?php  } ?> 
          <!--div class="form-group">
						<label> <span style="color:red">*</span> 邀请码:</label>
						<input name="invitation" type="text" class="form-control" placeholder="请输入邀请码">
					</div-->
          <div class="form-group">
            <label style="display:block;">&nbsp;</label>
            <input type="submit" name="submit" value="注册" class="btn btn-blue" />
            <input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="footer-register clearfix">
    <div class="registerCont"> <?php  if($site['copyrights']) { ?><?php  echo $site['copyrights'];?><?php  } else { ?>Copyright ©2015-2016 All Rights Reserved. 广州海生网络科技有限公司 版本所有<?php  } ?><br><?php  if($site['registercode']) { ?><?php  echo $site['registercode'];?><?php  } else { ?><?php  } ?> </div>
  </div>
  
</div>
<script src="./resource/default/js/animations.js"></script>
</body>
</html>