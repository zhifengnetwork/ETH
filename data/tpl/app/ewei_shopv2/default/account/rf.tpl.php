<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?><link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/account/default/style.css?v=2.0.0"><style type="text/css">    .account-top .logo img { border:2px solid <?php  echo $set['wap']['color'];?>;}    .account-login-link { color:<?php  echo $set['wap']['color'];?>;  }    .fui-cell-group .fui-cell-info .fui-input { color:<?php  echo $set['wap']['color'];?>; }    .btn.account-btn { border:1px solid <?php  echo $set['wap']['color'];?>;color:<?php  echo $set['wap']['color'];?>;}    .fui-cell-group .fui-cell:before {    border-top: 1px solid<?php  echo $set['wap']['color'];?>;    color: <?php  echo $set['wap']['color'];?>;    }</style><div class="fui-page">    <?php  if(is_h5app()) { ?>    <div class="fui-header">        <div class="fui-header-left">            <a class="back"> </a>        </div>        <div class="title"><?php  if(empty($type)) { ?>立即注册<?php  } else { ?>立即找回<?php  } ?></div>        <div class="fui-header-right" data-nomenu="true"></div>    </div>    <?php  } ?>    <div class="fui-content">        <div class="account-bg">            <img src="<?php echo empty($set['wap']['bg'])?'../addons/ewei_shopv2/static/images/wapbg.jpg':tomedia($set['wap']['bg'])?>" />        </div>        <div class="account-top">            <div class="logo">                <img src="<?php  echo tomedia($set['shop']['logo'])?>" />            </div>        </div>        <div class="fui-cell-group fui-cell-group-o account-cell-group">           <?php  if(empty($_GPC['mid'])) { ?>            
         
        <?php  } else { ?>
        <div class="fui-cell">                
                <div class="fui-cell-info account-cell"><input type="mid" class="fui-input" name="mid" id="mid" placeholder="推荐人ID" value="推荐人ID:<?php  echo trim($_GPC['mid'])?>" maxlength="11" readonly/></div>            </div>
        <?php  } ?> <div class="fui-cell">                <div class="fui-cell-info account-cell"><input type="tel" class="fui-input" name="mobile" id="mobile" placeholder="您的手机号码" value="<?php  echo trim($_GPC['mobile'])?>" maxlength="11" /></div>            </div>            <?php  if(!empty($set['wap']['smsimgcode'])) { ?>                <div class="fui-cell">                    <div class="fui-cell-info account-cell"><input type="tel" class="fui-input" name="verifycode" id="verifycode2" placeholder="图形验证码" maxlength="4" /></div>                    <div class="fui-cell-remark noremark">                        <img src="../web/index.php?c=utility&a=code&r=<?php  echo time()?>" style="width: 4.5rem; vertical-align: middle;" id="btnCode2">                    </div>                </div>            <?php  } ?>            <div class="fui-cell" id="cell-verifycode">                <div class="fui-cell-info account-cell"><input type="tel" class="fui-input" value="" name="verifycode" id="verifycode" placeholder="5位短信验证码" maxlength="5" /></div>                <div class="fui-cell-remark noremark"><a class="btn btn-default btn-default-o  btn-sm account-btn" id="btnCode" >获取验证码</a></div>            </div>            <div class="fui-cell">                <div class="fui-cell-info account-cell"><input type="password" class="fui-input"  name="pwd" id="pwd" placeholder="请输入登录密码" value=""/></div>            </div>            <div class="fui-cell">                <div class="fui-cell-info account-cell"><input type="password" class="fui-input"  name="pwd1" id="pwd1" placeholder="请重新输入登录密码" value=""/></div>            </div>            <div class="fui-cell">                <div class="fui-cell-info ">                    <div class="btn btn-default btn-default-o block account-btn" id="btnSubmit"><?php  if(empty($type)) { ?>立即注册<?php  } else { ?>立即找回<?php  } ?></div>                </div>            </div>            <div class="fui-cell-title" style="padding:0rem 1rem;;">                <a href="<?php  echo $set['wap']['loginurl'];?>" class="account-login-link external pull-right">立即登录</a>                <?php  if(empty($type)) { ?>                    <a href="<?php  echo $set['wap']['forgeturl'];?>" class="account-login-link  external">忘记密码 </a>                <?php  } else { ?>                    <a href="<?php  echo $set['wap']['regurl'];?>" class="account-login-link  external">立即注册 </a>                <?php  } ?>            </div>        </div>        <script language='javascript'>            require(['biz/member/account'], function (modal) {                modal.initRf({backurl:'<?php  echo $backurl;?>', type: <?php  echo intval($type)?>, endtime: <?php  echo intval($endtime)?>, imgcode: <?php  echo intval($set['wap']['smsimgcode'])?>});            });        </script>    </div></div><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>