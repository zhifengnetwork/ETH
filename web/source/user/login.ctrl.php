<?php

/**
 * [ZhiFun System] Copyright (c) 2016 ZHIFUN.CC
 * WeiShiHui is NOT a free software, it under the license terms, visited http://www.zhifun.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
define('IN_GW', true);

if (checksubmit() || $_W['isajax'] || $_W['ispost']) {
	// echo 222222;
	_login($_GPC['referer']);
}
// echo 333333;

$setting = $_W['setting'];
// print_r($setting);
// print_r($_GPC['referer']);
// die;
template('user/login');

function _login($forward = '') {
	// echo 111;
	// die;
	global $_GPC, $_W;
	load()->model('user');
	$member = array();
	$username = trim($_GPC['username']);
	pdo_query('DELETE FROM'.tablename('users_failed_login'). ' WHERE lastupdate < :timestamp', array(':timestamp' => TIMESTAMP-300));
	$failed = pdo_get('users_failed_login', array('username' => $username, 'ip' => CLIENT_IP));
	if ($failed['count'] >= 5) {
		message('输入密码错误次数超过5次，请在5分钟后再登录',referer(), 'info');
	}
	if (!empty($_W['setting']['copyright']['verifycode'])) {
		$verify = trim($_GPC['verify']);
		if (empty($verify)) {
			message('请输入验证码', '', '');
		}
		$result = checkcaptcha($verify);
		if (empty($result)) {
			message('输入验证码错误', '', '');
			//itoast('输入验证码错误', '', '');
		}
	}
	if (empty($username)) {
		message('请输入要登录的用户名', '', '');
	}
	$member['username'] = $username;
	$member['password'] = $_GPC['password'];
	if (empty($member['password'])) {
		message('请输入密码', '', '');
	}	
	$record = user_single($member);
	if (!empty($record)) {
		if ($record['status'] == 1) {
			message('您的账号正在审核或是已经被系统禁止，请联系网站管理员解决！', '', '');
		}
		$_W['uid'] = $record['uid'];
		$_W['isfounder'] = user_is_founder($record['uid']);

		if (empty($_W['isfounder'])) {
			if (!empty($record['endtime']) && $record['endtime'] < TIMESTAMP) {
				message('您的账号有效期限已过，请联系网站管理员解决！', '', '');
			}
		}
		if (!empty($_W['siteclose']) && empty($_W['isfounder'])) {
			message('站点已关闭，关闭原因：' . $_W['setting']['copyright']['reason'], '', '');
		}
		$cookie = array();
		$cookie['uid'] = $record['uid'];
		$cookie['lastvisit'] = $record['lastvisit'];
		$cookie['lastip'] = $record['lastip'];
		$cookie['hash'] = md5($record['password'] . $record['salt']);
		$session = authcode(json_encode($cookie), 'encode');
		isetcookie('__session', $session, !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
		$status = array();
		$status['uid'] = $record['uid'];
		$status['lastvisit'] = TIMESTAMP;
		$status['lastip'] = CLIENT_IP;
		user_update($status);
		if ($record['type'] == ACCOUNT_OPERATE_CLERK) {
			isetcookie('__uniacid', $record['uniacid'], 7 * 86400);
			isetcookie('__uid', $record['uid'], 7 * 86400);
			//message('登录成功！' ,url('site/entry/clerkdesk', array('uniacid' => $record['uniacid'], 'op' => 'index', 'm' => 'we7_coupon')), 'success');
		}
		if (empty($forward)) {
			// $forward = user_login_forward($_GPC['forward']);
			$forward = './index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=sysset.account';	//小道 10/8
			//$forward = './index.php?c=account&a=display&';										//  11.21 mc
		}
		
		 
		
		
		if ($record['uid'] != $_GPC['__uid']) {
			isetcookie('__uniacid', '', -7 * 86400);
			isetcookie('__uid', '', -7 * 86400);
		}
		pdo_delete('users_failed_login', array('id' => $failed['id']));
		itoast("欢迎回来，{$record['username']}。", $forward, 'success');
	} else {
		if (empty($failed)) {
			pdo_insert('users_failed_login', array('ip' => CLIENT_IP, 'username' => $username, 'count' => '1', 'lastupdate' => TIMESTAMP));
		} else {
			pdo_update('users_failed_login', array('count' => $failed['count'] + 1, 'lastupdate' => TIMESTAMP), array('id' => $failed['id']));
		}
		message('登录失败，请检查您输入的用户名和密码！', '', '');
	}
}