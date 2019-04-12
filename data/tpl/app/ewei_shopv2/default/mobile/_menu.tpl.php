<?php defined('IN_IA') or exit('Access Denied');?>
<style>
.fui-navbar .nav-item img{
    width: 20px;;
}
</style>

<div class="fui-navbar">

    <a href="<?php  if(empty($_GPC['merchid'])) { ?><?php  echo mobileUrl()?><?php  } else { ?><?php  echo mobileUrl('merch')?><?php  } ?>"
        class="external nav-item <?php  if($_W['routes']=='' ||  $_W['routes']=='shop' ||  $_W['routes']=='commission.myshop') { ?>active<?php  } ?>">

        <!-- <span class="icon icon-sponsorfill"></span> -->
        <?php  if($_W['routes']=='' ||  $_W['routes']=='shop' ||  $_W['routes']=='commission.myshop') { ?>
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/shouye1.png" alt="" width="16">
        <?php  } else { ?>
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/shouye0.png" alt="" width="16">
        <?php  } ?>


        <span class="label">首页</span>

    </a>

    <?php  if($member['type'] == 2) { ?>

    <?php  } else { ?>
    <?php  if($member['suoding'] == 1) { ?>
    <?php  } else { ?>

    <a href="<?php  echo mobileUrl('member/qipai')?>" class="external nav-item <?php  if($_W['routes']=='member.qipai') { ?>active<?php  } ?>" id="menucart">
    <!-- <a href="<?php  echo mobileUrl('member/lottery')?>" class="external nav-item <?php  if($_W['routes']=='member.lottery') { ?>active<?php  } ?>" id="menucart"> -->
        <!-- <span class="icon icon-browser"></span> -->
        <?php  if($_W['routes']=='member.qipai') { ?>
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/qipaiyule1.png" alt="" width="16">
        <?php  } else { ?>
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/qipaiyule0.png" alt="" width="16">
        <?php  } ?>
        <span class="label">棋牌娱乐</span>
    </a>
    <?php  } ?>
    <?php  } ?>


    <?php  if($member['type'] == 2) { ?>

    <?php  } else { ?>
    <?php  if($member['suoding'] == 1) { ?>
    <?php  } else { ?>
    <a href="<?php  echo mobileUrl('member/guamai')?>"
        class="external nav-item <?php  if($_W['routes']=='member.guamai') { ?>active<?php  } ?>">

        <!-- <span class="icon icon-taoxiaopu"></span> -->
        <?php  if($_W['routes']=='member.guamai') { ?>
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/C2C1.png" alt="" width="16">
        <?php  } else { ?>
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/C2C0.png" alt="" width="16">
        <?php  } ?>
        <span class="label">C2C</span>

    </a>
    <?php  } ?>
    <?php  } ?>








    <!-- <?php  if(!empty($commission)) { ?>

    <a href="<?php  echo $commission['url'];?>" class="external nav-item <?php  if($_W['routes']=='commission.register') { ?>active<?php  } ?>">

        <span class="icon icon-fenxiao2"></span>

        <span class="label"><?php  echo $commission['text'];?></span>

    </a>

    <?php  } ?> -->



    <!-- <a href="<?php  echo mobileUrl('member/cart')?>" class="external nav-item <?php  if($_W['routes']=='member.cart') { ?>active<?php  } ?>" id="menucart">

        <span class="icon icon-cart"></span>

        <span class="label">购物车</span>

        <?php  if($cartcount>0) { ?><span class="badge"><?php  echo $cartcount;?></span><?php  } ?>

    </a> -->

    <!-- <a href="<?php  echo mobileUrl('member/assets')?>" class="external nav-item <?php  if($_W['routes']=='member.assets') { ?>active<?php  } ?>"
        id="menucart">

        <span class="icon icon-daifukuan1"></span>

        <span class="label">资产</span>

    </a> -->

    <a href="<?php  echo mobileUrl('member')?>" class="external nav-item  <?php  if($_W['routes']=='member') { ?>active<?php  } ?>">

        <!-- <span class="icon icon-person2"></span> -->
        <?php  if($_W['routes']=='member') { ?>
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/wode1.png" alt="" width="16">
        <?php  } else { ?>
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/wode0.png" alt="" width="16">
        <?php  } ?>
        <span class="label">我的</span>

    </a>

</div>



<!--NDAwMDA5NzgyNw==-->
