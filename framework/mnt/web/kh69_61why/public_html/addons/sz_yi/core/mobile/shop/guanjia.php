<?php 

/* if (!defined('IN_IA')){
    exit('Access Denied');
}
global $_W, $_GPC;
$time=time();
$sql="select id,openid,etime,status from ".tablename('sz_yi_guanjia')." where uniacid=".$_W['uniacid'];
$openids=pdo_fetchall($sql);

//凌晨10分钟
foreach ($openids as $z=>$zyw){
    if($zyw['status']==0){
        if($zyw['etime']<$time){
           unset($openids[$z]); 
        }
    }
}

foreach ($openids as $row){
    $sql="select * from ".tablename('sz_yi_tudi_1')." where openid='".$row['openid']."' and status=1 and sta=0";
    $shu=pdo_fetchall($sql);

    foreach ($shu as $k=>$v){
        if($v['status']==1){
            $sql="select thumb,thumb_url,title from ".tablename('sz_yi_goods')." where id='".$v['goodsid']."'";
            $a=pdo_fetch($sql);
            $shu[$k]['thumb']=$a['thumb'];
            $shu[$k]['thumb_url']=$a['thumb_url'];
            $shu[$k]['title']=$a['title'];
            $shu[$k]['zyw']=1;
        }else{
            $shu[$k]['zyw']=0;
        }
    
    }
   
    foreach ($shu as &$v){
    
        //每日任务
        if($v['renwu']==1){
            $v['renwu']=$v['shunum']*0.05;
        }
        //施肥
        if($v['shifei']==1){
            $v['shifei']=$v['shifei']*0.1;
        }
        //土地
        if($v['level']==1){
            $v['level1']=$v['shunum'];
        }else if($v['level']==2){
            $v['level1']=$v['shunum']*0.2;
        }else if($v['level']==3){
            $v['level1']=$v['shunum']*0.4;
        }else if($v['level']==4){
            $v['level1']=$v['shunum']*0.6;
        }else if($v['level']==5){
            $v['level1']=$v['shunum']*0.8;
        }else if($v['level']==6){
            $v['level1']=$v['shunum']*1;
        }
        if($v['sta']==0){
            $v['shunum']=$v['csnum']+$v['tnum']+$v['renwu']+$v['shifei']+$v['level1'];
        }else{
            $v['shunum']=0;
        }
    
    }
    unset($v);

    $num=0;
    foreach ($shu as $v){
      
        if($v['status']==1 && $v['sta']==0){
            $yiji=$v['shunum']*0.1; //一级
            $erji=$v['shunum']*0.05;//二级
            $sanji=$v['shunum']*0.02;//三级
    
            $arr=array(
                'openid'=>$row['openid'],
                'uniacid'=>$uniacid,
                'tudiname'=>$v['pid'],
                'guoshi'=>$v['shunum'],
                'time'=>time(),
                'yiji'=>$yiji,
                'erji'=>$erji,
                'sanji'=>$sanji
            );
             
    
            $num+=$v['shunum']+$v['renwu']+$v['shifei'];
            $id= pdo_insert('sz_yi_tudi_shxx', $arr);
            if(!empty($row['id'])){
                pdo_update('sz_yi_tudi_1',array('sta'=>1,'shcishu'=>$v['shcishu']+1),array('openid'=>$row['openid'],'id'=>$v['id']));
            }
    
        }
    
    }
   
}





     */
 
?> 