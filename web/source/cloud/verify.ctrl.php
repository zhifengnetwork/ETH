<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$dos = array('verify');
$do = in_array($do, $dos) ? $do : 'verify';
global $_W,$_GPC;
set_time_limit(0);
load()->model('cloud');
load()->func('communication');
if($do == 'verify') {
	$_W['page']['title'] = '注册站点 - 云服务';
	$domain = getDomain();
	$ip     = getUserIP();
	$code   = getVerifyCode();
	$status = hasVerify();
	if (checksubmit('submit')) {
		$domain = $_GPC['domain'];
		$ip     = $_GPC['ip'];
		$code   = $_GPC['code'];
		$data = [
			'ip'     => $ip,
			'domain' => $domain,
			'siteid' => 1,
			'code'   => $code,
		];
		setVerifyCode($code);
		$resp = ihttp_request(APIHOST,array('type'=> 'grant','module' => MODULE,'website' => 1,'domain' => $domain,'code' => $code),null,1);
		$resp = @json_decode($resp['content'], true);
		if ($resp['errno'] === 0) {
			itoast($resp['message']);
			}else{
				itoast($resp['message']);
				}
	}
	template('cloud/verify');
}