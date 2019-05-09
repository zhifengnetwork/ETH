<?php 



if (!defined('IN_IA')){

    exit('Access Denied');

}

global $_W, $_GPC;

$openid = m('user') -> getOpenid();

if(empty($openid)){

   // $openid='oY2AEvxeZ0Krk8pHimhfA6dNPc_o';

}

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index'; 

$member = m('member') -> getMember($openid);



$sql="select yiji,openid,time from ".tablename('sz_yi_tudi_shxx')." where yiopenid='".$openid."' order by time desc";

$yiji=pdo_fetchall($sql);
$sql="select sum(yiji) from ".tablename('sz_yi_tudi_shxx')." where yiopenid='".$openid."' ";
$count_yiji=pdo_fetchcolumn($sql);


$sql="select erji,openid,time from ".tablename('sz_yi_tudi_shxx')." where eropenid='".$openid."' order by time desc";

$erji=pdo_fetchall($sql);
$sql="select sum(erji) from ".tablename('sz_yi_tudi_shxx')." where yiopenid='".$openid."' ";
$count_erji=pdo_fetchcolumn($sql);


$sql="select sanji,openid,time from ".tablename('sz_yi_tudi_shxx')." where sanopenid='".$openid."' order by time desc";

$sanji=pdo_fetchall($sql);
$sql="select sum(sanji) from ".tablename('sz_yi_tudi_shxx')." where yiopenid='".$openid."' ";
$count_sanji=pdo_fetchcolumn($sql);
if(!empty($yiji)){

    foreach ($yiji as &$v){

        $v['nickname']=pdo_fetchcolumn("select nickname from ".tablename('sz_yi_member')." where openid='".$v['openid']."'");

    

    }unset($v);

}

if(!empty($erji)){

    foreach ($erji as &$v){

        $v['nickname']=pdo_fetchcolumn("select nickname from ".tablename('sz_yi_member')." where openid='".$v['openid']."'");



    }unset($v);

}

if(!empty($sanji)){

    foreach ($sanji as &$v){

        $v['nickname']=pdo_fetchcolumn("select nickname from ".tablename('sz_yi_member')." where openid='".$v['openid']."'");



    }unset($v);

}



include $this -> template('shop/fanguo');



?>