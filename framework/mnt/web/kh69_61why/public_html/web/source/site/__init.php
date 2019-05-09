<?php
/**
 * 菜单管理
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.cocogd.com.cn)
 * @license    http://www.cocogd.com.cn
 * @link       http://www.cocogd.com.cn
 * @since      File available since Release v1.1
 */
 
if(!empty($_GPC['f']) && $_GPC['f'] == 'multi') {
	define('ACTIVE_FRAME_URL', url('site/multi/display'));
}
$sysmodules = system_modules();
if(!empty($_GPC['styleid'])) {
	define('ACTIVE_FRAME_URL', url('site/style/styles'));
}

if($controller == 'site') {
	$m = $_GPC['m'];
	if(in_array($m, $sysmodules)) {
		define('FRAME', 'platform');
		define('CRUMBS_NAV', 2);
		define('ACTIVE_FRAME_URL', url('platform/reply/', array('m' => $m)));
	}
}

if($action != 'entry' && $action != 'nav') {
	define('FRAME', 'site');
}elseif($action == 'entry') {

	switch( $_GPC['p'] )
	{		
		case 'poster' : case 'postera' : 
			//分销菜单
			define('FRAME', 'fenxiao');
			break;
		case 'commission':  
			if( $_GPC['method']=='increase' ){
				define('FRAME', 'statistics');
			}else{
				define('FRAME', 'fenxiao');
			}
			break;
			
		case 'supplier' : case 'verify' :
			//供应链菜单
			define('FRAME', 'supplier');
			break;
			
		case 'suppliermenu' :  
		 	//供应商操作台
			define('FRAME', 'suppliermenu');
			break;	
		case 'poster' : case 'returnmatter':  
			//购物返
			define('FRAME', 'bonus');
			break;
			
		case 'poster' : case 'postera' : case 'dis':  
			//经销商查询
			define('FRAME', 'fenxiao');
			break;
		
		case 'postera' : case 'postera' : case 'jszd':  
			//账单流水
			define('FRAME', 'finance');
			break;
			
		case 'bonus' : case 'bonusplus': case 'return' :  
			//分红菜单
			define('FRAME', 'bonus');
			break;	
							
		case 'perm' : case 'system' :
			if( $_GPC['method']=='copyright' ){
				//店铺菜单
				define('FRAME', 'mall');
			}elseif( $_GPC['method']=='commission' ){
				define('FRAME', 'fenxiao');
			}else{
				//权限管理菜单
				define('FRAME', 'authority');
			}
			break;	
		case 'creditshop': case 'virtual': case 'designer':  case 'coupon': case 'taobao': case 'tmessage': case 'article': case 'exhelper': case 'diyform':  case 'choose': case 'list' : case 'yunpay': case 'paihang': case 'transfer': case 'level': case 'group': case 'qiniu':
			//店铺菜单
			define('FRAME', 'mall');
			break;
		case 'yunpay':
			//公众号设置
			define('FRAME', 'platform');
			break;
		/*case 'sale' : 
			if( $do == 'statistics'){
				//统计
				define('FRAME', 'statistics');
			}else{
				//营销宝
				define('FRAME', 'mall﻿');
			}
			break;*/
		case 'sale' : case 'sale_analysis': case 'order': case 'goods': case 'goods_rank': case 'goods_trans': case 'member_cost': case 'tmessage':  case 'member_increase':
		
			if( $do == 'sysset' || $do == 'shop' || $do == 'plugin'){
				//店铺菜单
				define('FRAME', 'mall');
			}else{
				//数据统计
				define('FRAME', 'statistics');
			}
			break;
			
		default: 
			if( $do == 'sysset' || $do == 'shop' || $do == 'order'){
				//店铺菜单
				define('FRAME', 'mall');
			}
			if($do=='finance'){
				//财务管理
				define('FRAME', 'finance');
				
			}
		break;
	}

}
if ($action == 'editor' && $_GPC['type'] == '4') {
	define('ACTIVE_FRAME_URL', url('site/editor/uc'));
}
if (!empty($_GPC['multiid'])) {
	define('ACTIVE_FRAME_URL', url('site/multi/display'));
}
$frames = buildframes(array(FRAME));
$frames = $frames[FRAME];