<?php 
/**
 * 站点相关操作
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('copyright');
$do = in_array($do, $dos) ? $do : 'copyright';
$_W['page']['title'] = '站点设置 - 工具  - 系统管理';

$settings = $_W['setting']['copyright'];

if(empty($settings) || !is_array($settings)) {
	$settings = array();
} else {
	$settings['slides'] = iunserializer($settings['slides']);
}

$path = IA_ROOT . '/web/themes/';
if(is_dir($path)) {
	if ($handle = opendir($path)) {
		while (false !== ($templatepath = readdir($handle))) {
			if ($templatepath != '.' && $templatepath != '..') {
				if(is_dir($path.$templatepath)){
					$template[] = $templatepath;
				}
			}
		}
	}
}

if ($do == 'copyright') {
	if (checksubmit('submit')) {
		$data = array(
			'status' => intval($_GPC['status']),
			'verifycode' => intval($_GPC['verifycode']),
			'reason' => trim($_GPC['reason']),
			'sitename' => trim($_GPC['sitename']),
			'url' => (strexists($_GPC['url'], 'http://') || strexists($_GPC['url'], 'https://')) ? $_GPC['url'] : "http://{$_GPC['url']}",
			'statcode' => htmlspecialchars_decode($_GPC['statcode']),
			'footerleft' => htmlspecialchars_decode($_GPC['footerleft']),
			'footerright' => htmlspecialchars_decode($_GPC['footerright']),
			'icon' => trim($_GPC['icon']),
			'flogo' => trim($_GPC['flogo']),
			'background_img' => trim($_GPC['background_img']),
			'slides' => iserializer($_GPC['slides']),
			'notice' => trim($_GPC['notice']),
			'blogo' => trim($_GPC['blogo']),
			'qrcode' => $_GPC['qrcode'],
			'baidumap' => $_GPC['baidumap'],
			'company' => trim($_GPC['company']),
			'companyprofile' => htmlspecialchars_decode($_GPC['companyprofile']),
			'address' => trim($_GPC['address']),
			'person' => trim($_GPC['person']),
			'phone' => trim($_GPC['phone']),
			'qq' => trim($_GPC['qq']),
			'email' => trim($_GPC['email']),
			'keywords' => trim($_GPC['keywords']),
			'icp' => $_GPC['icp'],
			'description' => trim($_GPC['description']),
			'showhomepage' => intval($_GPC['showhomepage']),
			'leftmenufixed' => (!empty($_GPC['leftmenu_fixed'])) ? 1 : 0,
		);
		$test = setting_save($data, 'copyright');
		$template = trim($_GPC['template']);
		setting_save(array('template' => $template), 'basic');
		itoast('更新设置成功！', url('system/site'), 'success');
	}
}

template('system/site');