<?php
global $_W, $_GPC;

$operation = $_GET['op'];

$uniacid = $_W['uniacid']; 

$id = intval($_GPC['id']);
$commission_level = pdo_fetchall("SELECT * FROM " . tablename('sz_yi_commission_level') . " WHERE uniacid = '$uniacid'");//分销
/* $updatelevel = @json_decode($level['updatelevel'], true); */
$bonus_level = pdo_fetchall("SELECT * FROM " . tablename('sz_yi_bonus_level') . " WHERE uniacid = '$uniacid'");//分红
$dis_level = pdo_fetchall("SELECT * FROM " . tablename('sz_yi_dis_level') . " WHERE uniacid = '$uniacid'");//经销商查询

//开启与关闭前端开关
$rule = pdo_fetch("select * from " . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => "sz_yi经销商中心入口设置"));
if ($operation == 'update') {
	ca('dis.notice.update');
	if($_POST){
		$browser       = intval($_GPC['browser']);
		pdo_update('rule', array( 'status' => $browser), array( 'id' => $rule['id'],'uniacid' => $_W['uniacid'] ));
		$rule = pdo_fetch("select * from " . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => "sz_yi经销商中心入口设置"));
		/* file_put_contents(dirname(__FILE__).'/dasdsadsa',json_encode($browser ));   */
	}

}

if ($operation == 'insert') {
 
if($_POST){
 		print_r(222222);
		foreach( $dis_level  as $row){ 
		   if($_POST['level'] == $row['commission_level'] || $_POST['level'] == '0'   ){
					$a = 2;
					break;
		   }
		}
		
		if($a!=2){ 
			  $level = $_POST['level'];
			  $level_name = $_POST['level_name'];
			  $thumb = $_POST['thumb'];
			  $dis = array('uniacid' => $_W['uniacid'],'commission_level' => $level,'bonus_level' => $level_name,'thumb' => $thumb);
			 /* $distri = array_merge($dis,$cover); */
			 pdo_insert('sz_yi_dis_level', $dis); 
			  message('添加数据成功!', $this->createPluginWebUrl('dis/notice', array('op' => 'post'))); 
		}else{
			 message('已添加该分销等级，或没添加分销等级！', referer(), 'success'); 
		}	

}

}

ca('dis.set');
$set = $this->getSet(); 
$dir    = IA_ROOT . "/addons/sz_yi/plugin/" . $this->pluginname . "/template/mobile/";
/*  print_r($this->pluginname);  */
//Author:Y.yang Date:2016-04-08 Content:成为分销商条件（购买条件）
$goods = false;
if (!empty($set['become_goodsid'])) {
    $goods = pdo_fetch('select id,title from ' . tablename('sz_yi_goods') . ' where id=:id and uniacid=:uniacid limit 1 ', array(
        ':id' => $set['become_goodsid'],
        ':uniacid' => $_W['uniacid']
    ));
}
// END





load()->func('tpl');
include $this->template('set');
