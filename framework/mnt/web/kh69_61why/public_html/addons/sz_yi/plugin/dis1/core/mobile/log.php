<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation  = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid     = m('user')->getOpenid();
$mid        = m('member')->getMid();
$uniacid    = $_W['uniacid'];
$agentLevel = $this->model->getLevel($openid);
$level      = intval($this->set['level']);

$dis_thumb = pdo_fetchall("SELECT * FROM " . tablename('sz_yi_dis_level') . " WHERE uniacid = '$uniacid'");//经销商表的数据

if($_POST){
    
	
     $condition .= ' and dm.mobile=' . $_GPC['thumb'] .' or dm.weixin=' . $_GPC['thumb'];
	
	
	 $bonus_name = pdo_fetchall("select dm.agentlevel,dm.nickname,dm.mobile,l.id,l.thumb from " . tablename('sz_yi_member') . " dm " . " left join " . tablename('sz_yi_dis_level') . " l on l.commission_level = dm.agentlevel" . " where  dm.uniacid = " . $_W['uniacid'] . "  {$condition}  ORDER BY l.id desc "); 
	
/* 	 print_r('<pre>');
	 
	 print_r($bonus_name);
	 */
	


}


if ($operation == 'display') {
    include $this->template('log');
}

