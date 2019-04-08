<?php defined('IN_IA') or exit('Access Denied');?><div class="we7-page-title">用户管理 </div>
<ul class="we7-page-tab">
	<li <?php  if($action == 'display' && $_GPC['do'] == '') { ?>class="active"<?php  } ?>><a href="<?php  echo url('user/display');?>">用户管理</a></li>
	<?php  if($_W['isfounder'] && $_W['user']['founder_groupid'] != ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) { ?>
	<li <?php  if($_GPC['do'] == ACCOUNT_MANAGE_NAME_VICE_FOUNDER) { ?>class="active"<?php  } ?>><a href="<?php  echo url('user/display/vice_founder');?>">副创始人管理</a></li>
	<?php  } ?>
	<li <?php  if($_GPC['do'] == 'check_display') { ?>class="active"<?php  } ?>><a href="<?php  echo url('user/display/check_display');?>">审核用户</a></li>
	<li <?php  if($_GPC['do'] == 'recycle_display') { ?>class="active"<?php  } ?>><a href="<?php  echo url('user/display/recycle_display');?>">用户回收站</a></li>
	<li <?php  if($action == 'fields') { ?>class="active"<?php  } ?>><a href="<?php  echo url('user/fields/display');?>">用户属性设置</a></li>
	<li <?php  if($action == 'registerset') { ?>class="active"<?php  } ?>><a href="<?php  echo url('user/registerset');?>">用户注册设置</a></li>
</ul>