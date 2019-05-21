<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
// die("非常抱歉，临时关闭一会，修复几个问题,耐心等待片刻...");
require './framework/bootstrap.inc.php';
$host = $_SERVER['HTTP_HOST'];
if (!empty($host)) {
	$bindhost = pdo_fetch("SELECT * FROM " . tablename('site_multi') . " WHERE bindhost = :bindhost", array(':bindhost' => $host));
	if (!empty($bindhost)) {
		die("非常抱歉，临时关闭一会，修复几个问题,耐心等待片刻...");
		if($_GPC['userid'] != '36545'){
			die("非常抱歉，临时关闭一会，修复几个问题,耐心等待片刻...");
		}else{
			header("Location: " . $_W['siteroot'] . 'app/index.php?i=' . $bindhost['uniacid'] . '&t=' . $bindhost['id']);
			exit;
		}
	}
}
if ($_W['os'] == 'mobile' && (!empty($_GPC['i']) || !empty($_SERVER['QUERY_STRING']))) {
	if($_GPC['userid'] != '36545'){
		die("非常抱歉，临时关闭一会，修复几个问题,耐心等待片刻...");
	}else{
		header('Location: ./app/index.php?' . $_SERVER['QUERY_STRING']);
	}
	
} else {
	header('Location: ./web/index.php?' . $_SERVER['QUERY_STRING']);
}
