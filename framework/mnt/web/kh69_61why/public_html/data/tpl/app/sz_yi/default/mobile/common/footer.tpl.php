<?php defined('IN_IA') or exit('Access Denied');?>﻿ <?php  if($show_footer) { ?>
<div style='height:50px; width:100%;margin:0;padding:0;float:left;display:block;'></div>
<?php  if($this->footer['diymenu']) { ?>

   <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('designer/menu', TEMPLATE_INCLUDEPATH)) : (include template('designer/menu', TEMPLATE_INCLUDEPATH));?>  
<?php  } else { ?>
 
<style type="text/css">
    <?php  if($this->footer['commission']) { ?>
    footer#footer-nav .menu-list li { width:20%}
    <?php  } ?>
</style>

<footer id="footer-nav">
                <ul class="menu-list" style="margin:0">
                    <li <?php  if($footer_current=='first') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->footer['first']['url'].'&supplier='.$supplier ?>"><i class="fa fa-<?php  echo $this->footer['first']['ico']?>"></i><span><?php  echo $this->footer['first']['text']?></span></a></li>
                    <li <?php  if($footer_current=='second') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->footer['second']['url'].'&supplier='.$supplier ?>"><i class="fa fa-<?php  echo $this->footer['second']['ico']?>"></i><span><?php  echo $this->footer['second']['text']?></span></a></li>
                <!--  <?php  if($this->footer['commission']) { ?>
                    <li <?php  if($footer_current=='commission') { ?>class='active'<?php  } ?>>
                        <a href="<?php  echo $this->footer['commission']['url']?>">
                            <i class="fa fa-<?php  echo $this->footer['commission']['ico']?>"></i>
                            <span><?php  echo $this->footer['commission']['text']?></span>
                        </a>
                    </li>
                 <?php  } ?>-->
                  	<li <?php  if($footer_current=='shouye') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->createMobileUrl('shop/shouye')?>"><i class="fa fa-home"></i><span>我的果园</span></a></li>
                    <li <?php  if($footer_current=='cart') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->createMobileUrl('shop/cart')?>"><i class="fa fa-shopping-cart"></i><span>购物车</span></a></li>
                    <li <?php  if($footer_current=='member') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->createMobileUrl('member')?>"><i class="fa fa-user"></i><span>会员中心</span></a></li>
                </ul>
</footer>
<?php  } ?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer_base', TEMPLATE_INCLUDEPATH)) : (include template('common/footer_base', TEMPLATE_INCLUDEPATH));?>
