<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT.'/framework/version.inc.php';
load()->func('communication');
load()->model('cloud');
load()->func('file');
$dos = array('upgrade');
$do = in_array($do, $dos) ? $do : 'upgrade';
if ($do == 'upgrade') {
	$_W['page']['title'] = '一键更新 - 云服务';
	$version = IMS_VERSION;
	$release = IMS_RELEASE_DATE;
	$domain = trim( preg_replace( "/http(s)?:\/\//", "", rtrim($_W['siteroot'],"/") )  );
	$ip = getUserIP();
	$code = getVerifyCode();
	$resp = ihttp_post(APIHOST,array('type' => 'check','module' => MODULE,'ip' => $ip,'domain' => $domain,'code' => $code,'version' => $version));
	$upgrade = json_decode($resp['content'], true);
	if (is_array($upgrade)) {
		if ($upgrade['result'] == 1) {
			$files = [];
			if ( ! empty($upgrade['files'])) {
				foreach ($upgrade['files'] as $file) {
					$entry = IA_ROOT.'/'.$file['path'];
					if ( ! is_file($entry) || md5_file($entry) != $file['md5']) {
						$files[] = [
						'path'     => $file['path'],
						'download' => 0,
						'entry'    => $entry,
						];
					}
                }
            }
			if ( ! empty($files)) {
				$upgrade['files'] = $files;
				$tmpdir = IA_ROOT.'/data/temp';
				if ( ! is_dir($tmpdir)) {
					mkdirs($tmpdir);
					}
					file_put_contents($tmpdir.'/file.txt', json_encode($upgrade));
				} else {
					unset($upgrade);
					}
            }
        }
	if (checksubmit()) {
		if ($upgrade['result'] != 1) {
			itoast($upgrade['message']);
		}
	}
	template('cloud/upgrade');
}