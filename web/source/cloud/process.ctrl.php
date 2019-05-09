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
load()->func('db');
$_W['page']['title'] = '一键更新 - 云服务';
$dos = array('process', 'download');
$do = in_array($do, $dos) ? $do : 'process';
if ($do == 'process') {
	$version = IMS_VERSION;
	$release = IMS_RELEASE_DATE;
	$domain = trim( preg_replace( "/http(s)?:\/\//", "", rtrim($_W['siteroot'],"/") )  );
	$ip = getUserIP();
	$code = getVerifyCode();
	$resp = ihttp_post(APIHOST,array('type' => 'check','module' => MODULE,'ip' => $ip,'domain' => $domain,'code' => $code,'version' => $version));
	$upgrade = json_decode($resp['content'], true);
	if ($upgrade['result'] != 1){
		itoast($upgrade['message'], url('cloud/verify'), 'refresh');
	}	
	template('cloud/process');
}

if ($do == 'download') {
	$domain = trim( preg_replace( "/http(s)?:\/\//", "", rtrim($_W['siteroot'],"/") )  );
	$ip = getUserIP();
	$code = getVerifyCode();	
	$tmpdir  = IA_ROOT.'/data/temp';
    $f       = file_get_contents($tmpdir.'/file.txt');
    $upgrade = json_decode($f, true);
    $files   = $upgrade['files'];
    $path = "";
    foreach ($files as $f) {
      if (empty($f['download'])) {
        $path = $f['path'];
        break;
      }
    }
	$resp = ihttp_post(APIHOST,array('type' => 'download','ip' => $ip,'domain' => $domain,'code' => $code,'module' => MODULE,'path' => $path));
	$ret = @json_decode($resp['content'], true);
	if (!empty($ret['message'])){
		itoast($ret['message'], url('cloud/verify'), 'error');
		}else{
			global $_GPC;
			$tmpdir  = IA_ROOT.'/data/temp';
			$f       = file_get_contents($tmpdir.'/file.txt');
			$upgrade = json_decode($f, true);
			$files   = $upgrade['files'];
			$path = "";
			foreach ($files as $f) {
				if (empty($f['download'])) {
					$path = $f['path'];
					break;
					}
				}
			if ( ! empty($path)) { 
				if (is_array($ret)) {
					$path    = $ret['path'];
					$dirpath = dirname($path);
					if ( ! is_dir(IA_ROOT.'/'.$dirpath)) {
						mkdirs(IA_ROOT.'/'.$dirpath, '0777');
					}
					$content = base64_decode($ret['content']);
					file_put_contents(IA_ROOT.'/'.$path, $content);
					$success = 1;
					foreach ($files as & $f) {
						if ($f['path'] == $path) {
							$f['download'] = 1;
							break;
						}
						if ($f['download']) {
							$success++;
						}
					}
					unset($f);
					$upgrade['files'] = $files;
					$tmpdir           = IA_ROOT.'/data/temp';
					if ( ! is_dir($tmpdir)) {
						mkdirs($tmpdir);
					}
					file_put_contents($tmpdir.'/file.txt', json_encode($upgrade));
					die(json_encode(array('result'  => 1,'total' => count($files),'success' => $success,'path' => $path,)));
				}

			}else{
				$updatefile = IA_ROOT.'/upgrade.php';
				if (file_exists($updatefile)) {
					require $updatefile;
				}
				$tmpdir = IA_ROOT.'/data/temp';
				@rmdirs($tmpdir);
				itoast('恭喜您，系统更新成功！', url('cloud/upgrade'));
				exit();			
			}
		}
}