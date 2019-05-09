<?php 

if (!defined('IN_IA')){
    exit('Access Denied');
}
global $_W, $_GPC;
$openid = m('user') -> getOpenid();
if(empty($openid)){
  //  $openid='oY2AEv8tgKppRT5ILpTgQSyUjVdg';
}
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$member = m('member') -> getMember($openid);

$jinguo=$member['credit2'];
if ($_W['isajax']){
    
    if($op=="zengsong"){
       
        if($jinguo<$zeng){
            show_json(-1,'请填写正确的数字');
        }
        $zeng=$_GPC['zeng'];
        $shouid=$_GPC['userid'];
    
          
        
        $sql="select * from ".tablename('sz_yi_member')."where id='".$shouid."'";
        $shou=pdo_fetch($sql);
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
                'leibie'=>1
            );
            m('member')->setCredit($openid, 'credit2', -$zeng);
            m('member')->setCredit($shou['openid'], 'credit2', $zeng);
            //pdo_update('mc_members',array('credit2'=>$shou['credit2']+$zeng),array('openid'=>$shou['openid']));
            pdo_insert('sz_yi_zengsong', $arr);
            
        }
        show_json(1,$shou['nickname']);
    }else if($op=="zengsongren"){
        $id = $_GPC['id'];
        $sql="select * from ".tablename('sz_yi_member')." where id={$id} and uniacid={$_W['uniacid']}";
        $res=pdo_fetch($sql);
        $zyw=!empty($res['nickname'])?$res['nickname']:$res['realname'];
        if(empty($zyw)){
            $zyw=$id;
        }
       if(!empty($zyw)){
        show_json(1,$zyw);
       }else{
        show_json(-1);
       }
    }
 }
include $this -> template('shop/jinguo');

?>
