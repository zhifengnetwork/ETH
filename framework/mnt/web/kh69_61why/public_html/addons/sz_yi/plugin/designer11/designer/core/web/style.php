<?php
//多级分销商城 QQ:1084070868
global $_W, $_GPC;
load()->func('tpl');

$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$tempdo = empty($_GPC['tempdo']) ? "" : $_GPC['tempdo'];
$pageid = empty($_GPC['pageid']) ? "" : $_GPC['pageid'];
$apido  = empty($_GPC['apido']) ? "" : $_GPC['apido'];

include $this->template('style');
