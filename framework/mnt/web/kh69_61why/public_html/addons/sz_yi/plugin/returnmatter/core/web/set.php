<?php
/**
  * 全返插件基础设置
  * $set['isreturn']    // 全返开关
  * $set['percentage']  //全返比例
  * $set['orderprice']  //订单累计金额
  */
global $_W, $_GPC;
ca('return.set');  
$set = $this->getSet();

/* $this -> model -> selecreturn(); */
$nowday = date('Ymd');//当天
$lastday = $nowday-1;	//昨天
 $beforeday = $nowday-2;	//前天

$lastmoney = pdo_fetchall("select sum(goodsprice) as goodsprice from " . tablename('sz_yi_returnmatter') . " where uniacid=:uniacid  Group by datetime order by id desc limit 2",array('uniacid' => $_W['uniacid']));//最后最近两天的消费额

$last = $lastmoney[0]['goodsprice'];//昨天消费额
$befor = $lastmoney[1]['goodsprice'];//前天消费额

$difmoney = $last / $befor;
/*  $returnmatter = pdo_fetchall("select group_concat(id)as id,group_concat(mid) as mid,group_concat(oid) as oid,group_concat(openid) as openid,group_concat(money) as money from " . tablename('sz_yi_returnmatter')   . " where uniacid=:uniacid and status=0 Group by datetime   order by datetime desc limit 2" , array(':uniacid' => $_W['uniacid']));
  $id = explode(',',$returnmatter[1]['id']); 
   $mid = explode(',',$returnmatter[1]['mid']);  */
  
   $datetime = pdo_fetchall("select id,mid,oid,openid,money,ordersn,datetime from " . tablename('sz_yi_returnmatter')   . " where uniacid=:uniacid and status=0 Group by datetime  order by id desc limit 2" , array(':uniacid' => $_W['uniacid']));
   $returnmatter =  pdo_fetchall("select id,mid,oid,openid,money,ordersn from " . tablename('sz_yi_returnmatter')   . " where uniacid=:uniacid and status=0 and  datetime=:datetime order by id asc " , array(':uniacid' => $_W['uniacid'],':datetime' =>$datetime[1]['datetime']));  
   
 			  




if (checksubmit('submit')) {
    $data          = is_array($_GPC['setdata']) ? array_merge($set, $_GPC['setdata']) : array();
    $this->updateSet($data);
    m('cache')->set('template_' . $this->pluginname, $data['style']);
    plog('return.set', '修改基本设置');
    message('设置保存成功!', referer(), 'success');
}

load()->func('tpl');
include $this->template('set');