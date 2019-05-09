 <?php 

/* if (!defined('IN_IA')){
    exit('Access Denied');
}
global $_W, $_GPC;

$sql="select * from ".tablename('sz_yi_tudi_1')." where uniacid=".$_W['uniacid']." and status>0 ";
$shu=pdo_fetchall($sql);
//凌晨
    
   foreach ($shu as $v){
      if($v['cstime']<=$v['shcishu']){
          //收获总数量==收获数量     重置
          pdo_update('sz_yi_tudi',array($v['pid']=>1),array('openid'=>$v['openid']));
          pdo_update('sz_yi_tudi_1',array('status'=>0,'sta'=>0),array('openid'=>$v['openid'],'id'=>$v['id']));
      }else{
          if($v['sta']==0){
              //没收获
              pdo_update('sz_yi_tudi_1',array('shcishu'=>$v['shcishu']+1,'tnum'=>0,),array('openid'=>$v['openid'],'id'=>$v['id']));
              
          }else{
              //已收获
              pdo_update('sz_yi_tudi_1',array('sta'=>0,'tnum'=>0),array('openid'=>$v['openid'],'id'=>$v['id']));
          }
         
      } 
   } */
?> 