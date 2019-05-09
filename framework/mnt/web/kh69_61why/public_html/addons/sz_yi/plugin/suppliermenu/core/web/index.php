<?php

if (!defined('IN_IA')) {
    print ('Access Denied');
}
global $_W, $_GPC;
load()->func('tpl');



$url = "{$_W['siteroot']}app/index.php?i={$_W['uniacid']}&c=entry&do=shop&m=sz_yi&supplier={$_W['uid']}";

include $this->template('index');


