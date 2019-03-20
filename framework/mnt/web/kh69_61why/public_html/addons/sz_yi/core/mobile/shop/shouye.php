<?php

 if (!defined('IN_IA')){

    exit('Access Denied');

}

global $_W, $_GPC;

$openid = m('user') -> getOpenid();



$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';



if(!empty($_COOKIE['member_mobile'])){
    $info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where  mobile ="' . $_COOKIE['member_mobile'] . '"');
}




$year =  date('y') ;

$month =   date('m') ;

$day  = date('d');

$stime = strtotime(date('Y-m-d 00:00:00', strtotime(date($year.'-'.$month.'-'.$day.' 00:00:00'))));

$etime = strtotime(date('Y-m-d 23:59:59', strtotime(date($year.'-'.$month.'-'.$day.' 00:00:00'))));


if(empty($openid)){
  if(!empty($info['openid'])){
     $openid = $info['openid'];
  }else{
    //$openid="oY2AEv2L7RuPZe7bVI2WitnPsgPg";
  }
}


p('commission')->upgradeLevelByOrder($openid);//刷新分销商等级

$sql="select level from ".tablename('sz_dog')." where openid='".$openid."'";



$doglevel=pdo_fetchcolumn($sql);

if(empty($doglevel)){

    $doglevel=0;

}
$uniacid = $_W['uniacid'];




//查有没有土地

$tudi = pdo_fetchcolumn('select id from' . tablename('sz_yi_tudi') . ' where uniacid=:uniacid and openid=:openid', array(':uniacid' => $_W['uniacid'],':openid'=>$openid));

//没有给他加土地
if(empty($tudi) && !empty($openid)){
   

     $data = array(

         'uniacid' => $uniacid,

         'openid' => $openid

     );

    

     pdo_insert('sz_yi_tudi', $data);

     $zyw_11="tudi_";

     for($b1=1;$b1<5;$b1++){
         $zyw_10=$zyw_11.$b1;

             $arr=array(

                 'openid'=>$openid,

                  'pid'=>$zyw_10,

                 'uniacid'=>$_W['uniacid']

           );

      pdo_insert('sz_yi_tudi_1',$arr);

     }

  

     

  

}

/* $san=m('order')->fanshangji1($openid);

print_r($san);die; */

/* $sql="select id from ".tablename('sz_yi_guanjia')." where openid='".$openid."'";

$guanjia =pdo_fetchcolumn($sql);

if(empty($guanjia)){

    $gj=array(

        'uniacid' => $uniacid,

        'openid' => $openid,

        'ttime'=>time(),

        'etime'=>time()+10*24*3600

    );

    pdo_insert('sz_yi_guanjia', $gj);

} */

/* $sql="select id from ".tablename('sz_yi_guanjia')." where openid='".$openid."' and status=1";

$guanjia1 =pdo_fetchcolumn($sql); */

m('order')->shenji($openid);//刷新狗等级

$zyw11=m('order')->gengxing($openid);//刷新土地

$sql="select tudi_1,tudi_2,tudi_3,tudi_4,tudi_5,tudi_6,tudi_7,tudi_8,tudi_9 from "

    .tablename('sz_yi_tudi')." where openid='".$openid."' and uniacid=".$_W['uniacid'];

$tudi= pdo_fetch($sql);
$zyw_111 = pdo_fetchall("SELECT * FROM ".tablename("sz_yi_tudi_1")." WHERE openid=:openid AND uniacid=:uniacid ",array(":uniacid"=>$_W['uniacid'],":openid"=>$openid));
if(empty($zyw_111)){
     $zyw_11="tudi_";
    
         for($b1=1;$b1<5;$b1++){
             $zyw_10=$zyw_11.$b1;
    
                 $arr=array(
    
                     'openid'=>$openid,
    
                      'pid'=>$zyw_10,
    
                     'uniacid'=>$_W['uniacid']
    
               );
    
                  pdo_insert('sz_yi_tudi_1',$arr);
    
         }
         $sql="select tudi_1,tudi_2,tudi_3,tudi_4,tudi_5,tudi_6,tudi_7,tudi_8,tudi_9 from "
         
             .tablename('sz_yi_tudi')." where openid='".$openid."' and uniacid=".$_W['uniacid'];
         
         $tudi= pdo_fetch($sql);
}

 // $tudi_zyw=array();//可使用的土地

  $zhongzhi=array();//以种植的土地

  $dqtime=time();

 /*  $sql="select a.*,b.thumb,b.thumb_url,b.title from ".tablename('sz_yi_tudi_1')." a left join ".tablename('sz_yi_goods')." b on a.goodsid=b.id where a.openid='".$openid."' and a.uniacid=".$uniacid."  order by a.zztime";

  $shu=pdo_fetchall($sql); */

  $sql="select * from ".tablename('sz_yi_tudi_1')." where openid='".$openid."'";

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

$time=time();


  foreach ($shu as &$v){

      

      //每日任务

     if($v['csshijian']<=$time){

         $v['zyw_time']=0;

     }else{

         $v['zyw_time']=$v['csshijian']-$time;

     }

   
     /*  //任务
      if($v['renwu']==1){

          $v['renwu']=0;

      } 

      //施肥

      if($v['shifei']==1){

          $v['shifei']=0;

      }   */

      //土地

      if($v['level']==1){

          $v['level1']=0;

      }else if($v['level']==2){

          $v['level1']=$v['csnum']*0.2;

      }else if($v['level']==3){

          $v['level1']=$v['csnum']*0.4;

      }else if($v['level']==4){

          $v['level1']=$v['csnum']*0.6;

      }else if($v['level']==5){

          $v['level1']=$v['csnum']*0.8;

      }else if($v['level']==6){

          $v['level1']=$v['csnum']*1;

      }
 
      if($v['zyw_time']==0){

          $v['shunum']=$v['csnum']+$v['tnum']+$v['level1'];

      }else{

          $v['shunum']=0;

      }

    

  }

  unset($v);

  

/*  print_r($shu);die; */ 

  if ($_W['isajax']){

      if($op=="shouhuo"){
		
          //收获

          $num=0;
			
          foreach ($shu as $v){
          	
                if($v['status']==1 && $v['zyw_time']==0){

                    $yiji=$v['shunum']*0.1; //一级

                    $erji=$v['shunum']*0.05;//二级

                    $sanji=$v['shunum']*0.02;//三级

                 

                    $arr=array(      

                        'openid'=>$openid,

                        'uniacid'=>$uniacid,

                        'tudiname'=>$v['pid'],

                        'guoshi'=>$v['shunum'],

                        'time'=>time(),

                        'yiji'=>$yiji,

                        'erji'=>$erji,

                        'sanji'=>$sanji

                    );
					
                    $san=m('order')->fanshangji1($openid);

                   if(!empty($san[0])){

                       $arr['yiopenid']=$san[0];

                   }

                   if(!empty($san[1])){

                       $arr['eropenid']=$san[1];

                   }

                   if(!empty($san[2])){

                       $arr['sanopenid']=$san[2];

                   }

                    

                    $num+=$v['shunum'];
                    
                    $row= pdo_insert('sz_yi_tudi_shxx', $arr);
                    
                    if(!empty($row)){

                        pdo_update('sz_yi_tudi_1',array('sta'=>1,'shcishu'=>$v['shcishu']+1,'shifei'=>0,'renwu'=>0,'csshijian'=>time()+86400,'tnum'=>0),array('openid'=>$openid,'id'=>$v['id']));

                        $sql="select * from ".tablename('sz_yi_tudi_1')." where id=".$v['id'];

                       $zyw_shu= pdo_fetch($sql);

                       if($zyw_shu['cstime']==$zyw_shu['shcishu']){

                           pdo_update('sz_yi_tudi_1',array('status'=>0),array('openid'=>$v['openid'],'id'=>$v['id']));

                           pdo_update('sz_yi_tudi',array($zyw_shu['pid']=>1),array('openid'=>$v['openid']));

                 

                       }

                    

                    }

                    

                }

            

           }

           

             if($num==0){

                show_json(-1,"没有可收获的果实");  

              }else{

                  $sql="select yuanguo from ".tablename('sz_yi_member')." where openid='".$openid."'";

                   $yuanguo=pdo_fetchcolumn($sql);

                   m('order')->fanshangji($openid,$num);//给三级返果实

                   pdo_update('sz_yi_member',array("yuanguo"=>$yuanguo+$num),array('openid'=>$openid));

                   show_json(1,$num);

              }

      }elseif ($op=="jiaoshui"){

          //浇水

          

         $sql="select id,jiaoshui from ".tablename('sz_yi_tudi_log')." where openid='".$openid."' and ".$stime."< time and time < ".$etime."";

         

         $log=pdo_fetch($sql);

      

      

         if(!empty($log)){

             if(!empty($log['jiaoshui'])){

                 show_json(0,"没有可浇水的树苗了，明天再来吧！");

             }else{

                 pdo_update('sz_yi_tudi_log',array('jiaoshui'=>time()),array('id'=>$log['id']));

                

                 show_json(1,"树苗经过您的精心灌溉，正在茁壮成长！");

             }

             

         }else{

             $arr=array(

                 'openid'=>$openid,

                 'uniacid'=>$uniacid,

                 'jiaoshui'=>time(),

                 'time'=>time()

             );

             $row=pdo_insert('sz_yi_tudi_log', $arr);

             if(!empty($row)){

                 show_json(1,"树苗经过您的精心灌溉，正在茁壮成长！");

             }else{

                 show_json(-1,"浇水失败！");

             }

         }

         

      }elseif ($op=="chuchong"){

          //除虫

          $sql="select id,chuchong from ".tablename('sz_yi_tudi_log')." where openid='".$openid."' and ".$stime."< time and time < ".$etime."";

           

          $log=pdo_fetch($sql);

           

          if(!empty($log)){

              if(!empty($log['chuchong'])){

                  show_json(0,"没有可除虫的树苗了，明天再来吧！");

              }else{

                  pdo_update('sz_yi_tudi_log',array('chuchong'=>time()),array('id'=>$log['id']));

                  $sql="select * from ".tablename('sz_yi_tudi_1')." where renwu=0 and status=1";

                  $list= pdo_fetchall($sql);

                  foreach ($list as $v){

                      pdo_update('sz_yi_tudi_1',array('renwu'=>1),array('id'=>$v['id']));

                  }

                  show_json(1,"树苗经过您的精心照顾，正在茁壮成长！");

              }

               

          }else{

              $arr=array(

                  'openid'=>$openid,

                  'uniacid'=>$uniacid,

                  'chuchong'=>time(),

                  'time'=>time()

              );

              $row=pdo_insert('sz_yi_tudi_log', $arr);

              if(!empty($row)){

                  show_json(1,"树苗经过您的精心照顾，正在茁壮成长！");

                  $sql="select * from ".tablename('sz_yi_tudi_1')." where renwu=0 and status=1";

                  $list= pdo_fetchall($sql);

                  foreach ($list as $v){

                      pdo_update('sz_yi_tudi_1',array('renwu'=>1),array('id'=>$v['id']));

                  }

              }else{

                  show_json(-1,"除虫失败！");

              }

          }

      }elseif ($op=="chucao"){

          //除草

     

          $sql="select id,chucao from ".tablename('sz_yi_tudi_log')." where openid='".$openid."' and ".$stime."< time and time < ".$etime."";

           

          $log=pdo_fetch($sql);

           

          if(!empty($log)){

              if(!empty($log['chucao'])){

                  show_json(0,"没有可除草的树苗了，明天再来吧！");

              }else{

                  pdo_update('sz_yi_tudi_log',array('chucao'=>time()),array('id'=>$log['id']));

                   $sql="select * from ".tablename('sz_yi_tudi_1')." where renwu=0 and status=1";

                   $list= pdo_fetchall($sql);

                   foreach ($list as $v){

                       pdo_update('sz_yi_tudi_1',array('renwu'=>1),array('id'=>$v['id']));

                   }

                  show_json(1,"树苗经过您的精心照顾，正在茁壮成长！");

              }

               

          }else{

              $arr=array(

                  'openid'=>$openid,

                  'uniacid'=>$uniacid,

                  'chucao'=>time(),

                  'time'=>time()

              );

              $row=pdo_insert('sz_yi_tudi_log', $arr);

              if(!empty($row)){

                  show_json(1,"树苗经过您的精心照顾，正在茁壮成长！");

              }else{

                  show_json(-1,"除草失败！");

              }

          }

      }elseif ($op=="shifei"){

          //施肥

      }

  }

 

include $this -> template('shop/shouye');



