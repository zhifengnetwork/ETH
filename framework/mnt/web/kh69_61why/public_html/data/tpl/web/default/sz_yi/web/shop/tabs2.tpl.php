<?php defined('IN_IA') or exit('Access Denied');?><div class="ulleft-nav">
<ul class="nav nav-tabs">
    <?php if(cv('shop.zyw.view')) { ?><li <?php  if($_GPC['p'] == 'goods' || empty($_GPC['op'])) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop/zyw')?>">赠送金果明细</a></li><?php  } ?>
    <?php if(cv('shop.zyw.view')) { ?><li <?php  if($_GPC['op'] == 'zyw') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop/zyw',array('op'=>'zyw'))?>">赠送耕种果明细</a></li><?php  } ?>
    
</div>
