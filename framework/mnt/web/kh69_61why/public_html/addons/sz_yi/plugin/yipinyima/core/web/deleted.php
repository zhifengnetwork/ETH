<?php
/**
 * 
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.cocogd.com.cn)
 * @license    http://www.cocogd.com.cn
 * @link       http://www.cocogd.com.cn
 * @since      File available since Release v1.1
 */

global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$id=$_GPC['id'];
$goodsid=$_GPC['goodsid'];
$list=pdo_fetchall('select * from ' .tablename('yipinyimaerwei').' where yipin_id=:id and uniacid=:uniacid',array(
	':id'=>$id,
	':uniacid'=>$_W['uniacid']
));
foreach($list as $key=>$var){
	$msl=$var['erweiurl'];
	$data=IA_ROOT .$msl;
	$result=@unlink($data);
	//$url=$this->model->shanchu($data);
}
if($result=='false'){
	foreach($list as $key=>$var){
	$cid=$var['id'];
	$retule1=pdo_delete('yipinyimaerwei',array('id'=>$cid));
	}
	$mld=pdo_fetch('select * from ' .tablename('yipinyima').' where id=:id and uniacid=:uniacid',array(
	':id'=>$id,
	':uniacid'=>$_W['uniacid']
));
	$retule=pdo_delete('yipinyima',array('id'=>$mld['id']));
	if(!empty($retule)){
		 message('保存成功！', $this->createPluginWebUrl('yipinyima/temp', array('op' => 'display','goodsid' => $_GPC['goodsid'])));
	}
}else{
	foreach($list as $key=>$var){
	$cid=$var['id'];
	$retule1=pdo_delete('yipinyimaerwei',array('id'=>$cid));
	}
	$mld=pdo_fetch('select * from ' .tablename('yipinyima').' where id=:id and uniacid=:uniacid',array(
	':id'=>$id,
	':uniacid'=>$_W['uniacid']
));
	$retule=pdo_delete('yipinyima',array('id'=>$mld['id']));
	if(!empty($retule)){
		    message('保存成功！', $this->createPluginWebUrl('yipinyima/temp', array('op' => 'display','goodsid' => $_GPC['goodsid'])));
	}
}

