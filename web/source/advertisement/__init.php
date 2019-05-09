<?php
/**
 * [ZhiFun System] Copyright (c) 2016 ZHIFUN.CC
 * WeiShiHui is NOT a free software, it under the license terms, visited http://www.zhifun.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
define('FRAME', 'advertisement');
if ($do == 'display') {
	define('ACTIVE_FRAME_URL', url('advertisement/content-provider/account_list'));
}

