<?php 

if (!defined('IN_IA')){
    exit('Access Denied');
}
global $_W, $_GPC;
$openid = m('user') -> getOpenid();
if(empty($openid)){
    //$openid='oY2AEv8tgKppRT5ILpTgQSyUjVdg';
}
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$sql="select gengzhongguo from ".tablename('sz_yi_member')." where openid='".$openid."'";
$gengzhongguo=pdo_fetchcolumn($sql);

if ($_W['isajax']){
    if($op=="zengsong"){
        $zeng=$_GPC['zeng'];
        $shouid=$_GPC['userid'];
        $sql="select * from ".tablename('sz_yi_member')."where id='".$shouid."'";
        $shou=pdo_fetch($sql);
        if($zeng>$gengzhongguo){
            show_json(-1,"请输入正确的数量！");
        }
        if($openid==$shou['openid']){
            show_json(-1,"请输入正确id！");
        }
        if(empty($shou)){
            show_json(-1,'请填写正确的ID');
        }else{
            $arr=array(
                'uniacid'=>$_W['uniacid'],
                'zhuanopenid'=>$openid,
                'shouopenid'=>$shou['openid'],
                'time'=>time(),
                'jine'=>$zeng,
                'leibie'=>2
            );
            pdo_update('sz_yi_member',array('gengzhongguo'=>$gengzhongguo-$zeng),array('openid'=>$openid));
            pdo_update('sz_yi_member',array('gengzhongguo'=>$shou['gengzhongguo']+$zeng),array('openid'=>$shou['openid']));
            pdo_insert('sz_yi_zengsong', $arr);
            
        }
        show_json(1,$shou['nickname']);
    }
 }
include $this -> template('shop/zengsong');

?>