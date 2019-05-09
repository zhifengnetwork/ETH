<?php
/**
 * [ZhiFun System] Copyright (c) 2016 ZHIFUN.CC
 * WeiShiHui is NOT a free software, it under the license terms, visited http://www.zhifun.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if (!in_array($action, array('display', 'post'))) {
	checkwxapp();
}

if (($action == 'version' && ($do == 'home' || $do == 'module_link_uniacid' || $do == 'front_download')) || ($action == 'payment')) {
	define('FRAME', 'wxapp');
}
