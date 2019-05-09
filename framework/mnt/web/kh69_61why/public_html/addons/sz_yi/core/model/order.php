<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
class Sz_DYi_Order{
    function getDispatchPrice($dephp_0, $dephp_1, $dephp_2 = -1){
        if (empty($dephp_1)){
            return 0;
        }
        $dephp_3 = 0;
        if ($dephp_2 == -1){
            $dephp_2 = $dephp_1['calculatetype'];
        }
        if ($dephp_2 == 1){
            if ($dephp_0 <= $dephp_1['firstnum']){
                $dephp_3 = floatval($dephp_1['firstnumprice']);
            }else{
                $dephp_3 = floatval($dephp_1['firstnumprice']);
                $dephp_4 = $dephp_0 - floatval($dephp_1['firstnum']);
                $dephp_5 = floatval($dephp_1['secondnum']) <= 0 ? 1 : floatval($dephp_1['secondnum']);
                $dephp_6 = 0;
                if ($dephp_4 % $dephp_5 == 0){
                    $dephp_6 = ($dephp_4 / $dephp_5) * floatval($dephp_1['secondnumprice']);
                }else{
                    $dephp_6 = ((int) ($dephp_4 / $dephp_5) + 1) * floatval($dephp_1['secondnumprice']);
                }
                $dephp_3 += $dephp_6;
            }
        }else{
            if ($dephp_0 <= $dephp_1['firstweight']){
                $dephp_3 = floatval($dephp_1['firstprice']);
            }else{
                $dephp_3 = floatval($dephp_1['firstprice']);
                $dephp_4 = $dephp_0 - floatval($dephp_1['firstweight']);
                $dephp_5 = floatval($dephp_1['secondweight']) <= 0 ? 1 : floatval($dephp_1['secondweight']);
                $dephp_6 = 0;
                if ($dephp_4 % $dephp_5 == 0){
                    $dephp_6 = ($dephp_4 / $dephp_5) * floatval($dephp_1['secondprice']);
                }else{
                    $dephp_6 = ((int) ($dephp_4 / $dephp_5) + 1) * floatval($dephp_1['secondprice']);
                }
                $dephp_3 += $dephp_6;
            }
        }
        return $dephp_3;
    }
    function getCityDispatchPrice($dephp_7, $dephp_8, $dephp_0, $dephp_1){
        if (is_array($dephp_7) && count($dephp_7) > 0){
            foreach ($dephp_7 as $dephp_9){
                $dephp_10 = explode(';', $dephp_9['citys']);
                if (in_array($dephp_8, $dephp_10) && !empty($dephp_10)){
                    return $this -> getDispatchPrice($dephp_0, $dephp_9);
                    // return $this -> getDispatchPrice($dephp_0, $dephp_9, $dephp_1['calculatetype']);
                }
            }
        }
        return $this -> getDispatchPrice($dephp_0, $dephp_1);
    }
    public function payResult($dephp_11){
        global $_W;



        $dephp_12 = $dephp_11['fee'];
        $dephp_13 = array('status' => $dephp_11['result'] == 'success' ? 1 : 0);
        $dephp_14 = $dephp_11['tid'];
    
        $dephp_15 = pdo_fetch('select * from ' . tablename('sz_yi_order') . ' where  ordersn=:ordersn and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':ordersn' => $dephp_14));
       
      //  $dephp_15 = pdo_fetch('select * from ' . tablename('sz_yi_order') . " where  ordersn='{$dephp_14}' and uniacid='{$_W['uniacid']}' limit 1 ");

 
        $dephp_16 = pdo_fetch('select * from ' . tablename('core_paylog') . ' where `uniacid`=:uniacid and fee=:fee and `module`=:module and `tid`=:tid limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'sz_yi', ':fee' => $dephp_12, ':tid' => $dephp_15['ordersn']));

    

        if (empty($dephp_16)){
            show_json(-1, '订单金额错误, 请重试!');
            exit;
        }



 
        $dephp_17 = $dephp_15['id'];
        if ($dephp_11['from'] == 'return'){
            $dephp_18 = false;
            if (empty($dephp_15['dispatchtype'])){
                $dephp_18 = pdo_fetch('select realname,mobile,address from ' . tablename('sz_yi_member_address') . ' where id=:id limit 1', array(':id' => $dephp_15['addressid']));
            }
            $dephp_19 = false;
            if ($dephp_15['dispatchtype'] == 1 || $dephp_15['isvirtual'] == 1){
                $dephp_19 = unserialize($dephp_15['carrier']);
            }
            if ($dephp_11['type'] == 'cash'){
                return array('result' => 'success', 'order' => $dephp_15, 'address' => $dephp_18, 'carrier' => $dephp_19);
            }else{
                if ($dephp_15['status'] == 0){
                    $dephp_20 = p('virtual');
                    if (!empty($dephp_15['virtual']) && $dephp_20){
                        $dephp_20 -> pay($dephp_15);
                    }else{
                    //zyw
                        $sql="select a.*,b.cstime,b.guoshi from ".tablename('sz_yi_order_goods')." a left join ".tablename('sz_yi_goods')." b on a.goodsid=b.id where a.orderid=:orderid limit 1";
                        $dephp_zyw=pdo_fetch($sql,array(':orderid'=>$dephp_15['id']));
                        
                                    if($dephp_15['zyw']==1){
                                        //种子
                                       
                                         //添加到种植表里面去
                                       
                                        $time_zyw =time();
                                        $zyw_0= $this->zyw($dephp_15['openid']);//获得未种植土地字段名pid
                                        $sql="select * from ".tablename('sz_yi_tudi_1'). "where openid=:openid and pid=:pid and status=0";
                                        $zyw_tudi=pdo_fetch($sql,array(':openid'=>$dephp_15['openid'],':pid'=>$zyw_0));
                                                if(empty($zyw_tudi)){
                                                    $arr_zyw = array(
                                                        'uniacid' => $_W['uniacid'],
                                                        'openid' => $dephp_15['openid'],
                                                        'goodsid' => $dephp_zyw['goodsid'],
                                                        'zztime' =>$time_zyw,
                                                        'cstime' =>$dephp_zyw['cstime'],
                                                        'total'=>$dephp_zyw['total'],
                                                        'pid'=>$zyw_0,
                                                        'orderid' => $dephp_15['id'],
                                                        'num'=>$dephp_zyw['total']*$dephp_zyw['guoshi'],
                                                        'csnum'=>$dephp_zyw['total']*$dephp_zyw['guoshi']/$dephp_zyw['cstime'],
                                                        'csshijian'=>$time_zyw+3600*24,
                                                        'shcishu'=>0
                                                    );
                                                  
                                                    $res = pdo_insert('sz_yi_tudi_1', $arr_zyw);
                                                    if(!empty($res)){
                                                        pdo_update("sz_yi_tudi",array($zyw_0=>2),array('openid'=>$dephp_15['openid']));
                                                    }
                                                }else{
                                                    $arr_zyw=array(
                                                        'goodsid' => $dephp_zyw['goodsid'],
                                                        'zztime' =>$time_zyw,
                                                        'cstime' =>$dephp_zyw['cstime'],
                                                        'total'=>$dephp_zyw['total'],
                                                        'orderid' => $dephp_15['id'],
                                                        'status'=>1,
                                                        'num'=>$dephp_zyw['total']*$dephp_zyw['guoshi'],
                                                        'csnum'=>$dephp_zyw['total']*$dephp_zyw['guoshi']/$dephp_zyw['cstime'],
                                                        'tnum'=>0,
                                                        'shcishu'=>0,
                                                        'csshijian'=>$time_zyw+(24*3600)
                                                                                                        

                                                    );
                                                    pdo_update("sz_yi_tudi_1",$arr_zyw,array('id'=>$zyw_tudi['id'],'openid'=>$dephp_15['openid']));
                                                    pdo_update("sz_yi_tudi",array($zyw_0=>2),array('openid'=>$dephp_15['openid']));
                                                }
                                        
                                                
                                        pdo_update('sz_yi_order', array('status' => 3, 'paytime' => time(),'sendtime'=>time(),'finishtime'=>time()), array('id' => $dephp_17));
                                    }elseif($dephp_15['zyw']==2){
                                             //土地
                                                if($dephp_zyw['goodsid']==9){
                                                    //黄土地
                                                    $level=2;
                                                }else if($dephp_zyw['goodsid']==17){
                                                    //红土地
                                                    $level=3;
                                                }else if($dephp_zyw['goodsid']==10){
                                                    //蓝土地
                                                    $level=4;
                                                }else if($dephp_zyw['goodsid']==11){
                                                    //紫土地
                                                    $level=5;
                                                }else if($dephp_zyw['goodsid']==12){
                                                    //金土地
                                                    $level=6;
                                                }
                                        
                                        $sql="select id from ".tablename('sz_yi_tudi_1')."where openid='".$dephp_15['openid']."' order by level LIMIT 1";
                                        $level_id=pdo_fetchcolumn($sql);//拿最低等级的
                                        pdo_update('sz_yi_order', array('status' => 3, 'paytime' => time(),'sendtime'=>time(),'finishtime'=>time()), array('id' => $dephp_17));
                                        pdo_update('sz_yi_tudi_1', array('level' => $level), array('id' => $level_id));
                                        
                                    }elseif($dephp_15['zyw']==3){
                                        //施肥
                                      //$sql="select id,pid from ".tablename('sz_yi_tudu_1')." where openid='".$dephp_15['openid']."' and status=1 and shifei=0";
                                      $shifei= pdo_fetchall("SELECT id,pid FROM ".tablename("sz_yi_tudi_1")." WHERE openid=:openid AND status=1 AND shifei=0 ",array(":openid"=>$dephp_15['openid']));
                                      foreach ($shifei as $v){
                                          pdo_update('sz_yi_tudi_1', array('shifei' =>1), array('openid' => $dephp_15['openid'],id=>$v['id']));
                                      }
                                        
                                        //种植表添加施肥状态
                                        pdo_update('sz_yi_order', array('status' => 3, 'paytime' => time(),'sendtime'=>time(),'finishtime'=>time()), array('id' => $dephp_17));
                                    }elseif($dephp_15['zyw']==4){
                                        //狗
                                        $arr=array(
                                            'uniacid'=>$_W['uniacid'],
                                            'openid'=>$dephp_15['openid'],
                                            'level'=>1

                                        );
                                        $res = pdo_insert('sz_dog', $arr);
                                       //添加狗表去（待创建）
                                       if(!empty($res)){
                                           pdo_update('sz_yi_order', array('status' => 3, 'paytime' => time(),'sendtime'=>time(),'finishtime'=>time()), array('id' => $dephp_17));
                                       }
                                        
                                    }elseif($dephp_15['zyw']==5){
                                        //成年狗粮
                                        $sql="select * from ".tablename('sz_dog')." where openid='".$dephp_15['openid']."'";
                                        $a=pdo_fetch($sql);
                                         pdo_update('sz_dog', array('stime' => time(), 'etime' => time()+30*24*3600), array('id' => $a['id']));
                                         pdo_update('sz_yi_order', array('status' => 3, 'paytime' => time(),'sendtime'=>time(),'finishtime'=>time()), array('id' => $dephp_17));
                                    }elseif($dephp_15['zyw']==6){
                                        //狗王粮
                                        $sql="select * from ".tablename('sz_dog')." where openid='".$dephp_15['openid']."'";
                                        $a=pdo_fetch($sql);
                                        pdo_update('sz_dog', array('stime' => time(), 'etime' => time()+30*24*3600), array('id' => $a['id']));
                                        pdo_update('sz_yi_order', array('status' => 3, 'paytime' => time(),'sendtime'=>time(),'finishtime'=>time()), array('id' => $dephp_17));
                                    }elseif($dephp_15['zyw']==7){
                                        //管家
                                        $sql="select id from ".tablename('sz_yi_guanjia')." where openid='".$dephp_15['openid']."'";
                                        $a=pdo_fetchcolumn($sql);
                                        pdo_update('sz_yi_guanjia', array('status' => 1), array('id' => $a));
                                        pdo_update('sz_yi_order', array('status' => 1, 'paytime' => time()), array('id' => $dephp_17));
                                    }else{
                                        pdo_update('sz_yi_order', array('status' => 1, 'paytime' => time()), array('id' => $dephp_17));
                                    } 
                                    
                                  /*   if ($dephp_15['deductcredit'] > 0 && $dephp_15['zyw']>0){
                                        $sql="select gengzhongguo from ".tablename('sz_yi_member')." where openid='".$dephp_15['openid']."'";
                                        $gengzhongguo=pdo_fetchcolumn($sql);
                                        pdo_update('sz_yi_member', array('gengzhongguo' => $gengzhongguo-$dephp_15['deductcredit']), array('openid' => $dephp_15['openid']));
                                         
                                    } */
                                    
                                 /*    if ($dephp_15['deductcredit'] >0 && $dephp_15['zyw']==0){
                                        $sql="select xianguo from ".tablename('sz_yi_member')." where openid='".$dephp_15['openid']."'";
                                        $xianguo=pdo_fetchcolumn($sql);
                                        pdo_update('sz_yi_member', array('xianguo' => $xianguo-$dephp_15['deductcredit']), array('openid' => $dephp_15['openid']));
                                    
                                    } */
                         if ($dephp_15['deductcredit'] > 0 && $dephp_15['zyw']>0){
                                   $sql="select gengzhongguo from ".tablename('sz_yi_member')." where openid='".$dephp_15['openid']."'";
                                   $gengzhongguo=pdo_fetchcolumn($sql);
                                   if($gengzhongguo<$dephp_15['deductcredit']){
                                        show_json(-1, '耕种果数量不够!');
                                        exit;
                                   }
                                   pdo_update('sz_yi_member', array('gengzhongguo' => $gengzhongguo-$dephp_15['deductcredit']), array('openid' => $dephp_15['openid']));
                                       
                         }
                        
                         if ($dephp_15['deductcredit'] >0 && $dephp_15['zyw']==0){
                             $sql="select xianguo from ".tablename('sz_yi_member')." where openid='".$dephp_15['openid']."'";
                             $xianguo=pdo_fetchcolumn($sql);
                             if($xianguo<$dephp_15['deductcredit']){
                                 show_json(-1, '鲜果数量不够!');
                                 exit;
                             }
                             pdo_update('sz_yi_member', array('xianguo' => $xianguo-$dephp_15['deductcredit']), array('openid' => $dephp_15['openid']));
                              
                         }
                        if ($dephp_15['deductcredit2'] > 0){
                            $dephp_21 = m('common') -> getSysset('shop');
                            m('member') -> setCredit($dephp_15['openid'], 'credit2', - $dephp_15['deductcredit2'], array(0, $dephp_21['name'] . "余额抵扣: {$dephp_15['deductcredit2']} 订单号: " . $dephp_15['ordersn']));
                        }
                        $this -> setStocksAndCredits($dephp_17, 1);
                        if (p('coupon') && !empty($dephp_15['couponid'])){
                            p('coupon') -> backConsumeCoupon($dephp_15['id']);
                        }
                        m('notice') -> sendOrderMessage($dephp_17);
                        if (p('commission')){
                            p('commission') -> checkOrderPay($dephp_15['id']);
                        }
                    }
                }
                if(p('supplier')){
                    p('supplier') -> order_split($dephp_17);
                }
                $dephp_22 = pdo_fetch('select o.dispatchprice,o.ordersn,o.price,og.optionname as optiontitle,og.optionid,og.total from ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_order_goods') . 'og on og.orderid = o.id  where o.id = :id and o.uniacid=:uniacid', array(':id' => $dephp_17, ':uniacid' => $_W['uniacid']));
                $dephp_23 = 'SELECT og.goodsid,og.total,g.title,g.thumb,og.price,og.optionname as optiontitle,og.optionid FROM ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on og.goodsid = g.id ' . ' where og.orderid=:orderid order by og.id asc';
                $dephp_22['goods1'] = set_medias(pdo_fetchall($dephp_23, array(':orderid' => $dephp_17)), 'thumb');
                $dephp_22['goodscount'] = count($dephp_22['goods1']);
                return array('result' => 'success', 'order' => $dephp_15, 'address' => $dephp_18, 'carrier' => $dephp_19, 'virtual' => $dephp_15['virtual'], 'goods' => $dephp_22);
            }
        }
    } 
   function zyw($openid){
        global $_W;
        $zyw_1="tudi_";
        for($a=1;$a<21;$a++){
            $zyw_0=$zyw_1.$a;
            $sql="select ".$zyw_0." from ".tablename('sz_yi_tudi')." where openid='".$openid."'";
            $zyw=pdo_fetchcolumn($sql);
            if($zyw==1){
                return $zyw_0;
            }
        }
        return false;
    } 
    function gengxing($openid){
        global $_W;
       $sql="select id from ".tablename('sz_yi_member')." where openid='".$openid."'";
       $userid= pdo_fetchcolumn($sql);
      
       $sql="select count(*) from ".tablename('sz_yi_member')." where agentid=".$userid." and status=1 and isagent=1";
       $num=pdo_fetchcolumn($sql);//自己的下级
  
       $sql="select id,openid from ".tablename('sz_yi_member')." where agentid=".$userid." and status=1 and isagent=1";
       $list_zyw=pdo_fetchall($sql);
     
       foreach ($list_zyw as $v){
           $sql="select * from  ".tablename('sz_yi_tudi_shxx')." where openid='".$openid."'";
           $z=pdo_fetchall($sql);
           if(empty($z)){
               $num-=1;
           }
       }
      
       if($num>0){
           $zyw_1="tudi_";
                for($a=1;$a<10;$a++){
                    $zyw_0=$zyw_1.$a;
                    $sql="select ".$zyw_0." from ".tablename('sz_yi_tudi')." where openid='".$openid."'";
                    $zyw=pdo_fetchcolumn($sql);
                    if($zyw == 0){
                       break;
                    }
                }
               
                $yinggai=($num+4)>10?9:$num+4;
                $xianyou=$a-1;
           
               if($yinggai>$xianyou && $yinggai<=9){
                  pdo_update('sz_yi_tudi', array($zyw_0 => 1), array('openid' => $openid));
                  $arr=array(
                      'openid'=>$openid,
                      'pid'=>$zyw_0,
                      'uniacid'=>$_W['uniacid']

                  );
                
                  pdo_insert('sz_yi_tudi_1', $arr);
                  $this->gengxing($openid);
               } 
              if($yinggai==$xianyou){
                  return 1;
              }
       }
            
    }
    function shenji($openid){
        global $_W;
        $sql="select * from ".tablename('sz_dog')." where openid='".$openid."' and etime<>0";
        $a=pdo_fetch($sql);
        if(!empty($a)){
            if($a['etime']<=time()){
                pdo_update('sz_dog',array('stime'=>0,'etime'=>0,'level'=>$a['level']+1),array('openid'=>$openid));
               
            }
           
        }
       
    }
    function getTudi($openid){
        global $_W;
        $sql="select tudi_1,tudi_2,tudi_3,tudi_4,tudi_5,tudi_6,tudi_7,tudi_8,tudi_9 from "
            .tablename('sz_yi_tudi')." where openid='".$openid."' and uniacid=".$_W['uniacid'];
        $tudi= pdo_fetch($sql);
        foreach ($tudi as $k=>$row){
            if($row==1){
               return 1; 
            }
        }
        return 0;
    }
    function fanshangji($openid,$num){
        global $_W;
        $agentopenid=array();
        $sql="select agentid from ".tablename('sz_yi_member')." where openid='".$openid."'";
        $agentid= pdo_fetchcolumn($sql);
        $yiji=$num*0.1; //一级
        $erji=$num*0.05;//二级
        $sanji=$num*0.02;//三级
        $zhou=1;
        for ($a=0;$a<3;$a++){
            
            if(empty($agentid)){
                break;
            }
        
            $zyw= $this->getAgentOpenid($agentid); 
       
            if($zhou==1){
                pdo_update('sz_yi_member',array("yuanguo"=>$zyw['yuanguo']+$yiji),array('openid'=>$zyw['openid']));
                
            }else if($zhou==2){
                pdo_update('sz_yi_member',array("yuanguo"=>$zyw['yuanguo']+$erji),array('openid'=>$zyw['openid']));
               
            }elseif($zhou==3){
                pdo_update('sz_yi_member',array("yuanguo"=>$zyw['yuanguo']+$sanji),array('openid'=>$zyw['openid']));
               
            }
            $zhou+=1;
            $agentid=$zyw['agentid'];
        }
   
        
    }
    function fanshangji1($openid){
        global $_W;
        $agentopenid=array();
        $sql="select agentid from ".tablename('sz_yi_member')." where openid='".$openid."'";
        $agentid= pdo_fetchcolumn($sql);
      
      
        for ($a=0;$a<3;$a++){
    
            if(empty($agentid)){
                break;
            }
    
            $zyw= $this->getAgentOpenid($agentid);
           
            $agentopenid[]=$zyw['openid'];
            $agentid=$zyw['agentid'];
        }
         return $agentopenid;
    
    }
   
    function getAgentOpenid($agentid){
        $sql="select openid,agentid,yuanguo from ".tablename('sz_yi_member')." where id=".$agentid." limit 1";
        $zyw= pdo_fetch($sql);
          return $zyw;
    }
    function duihuan($openid,$num){
        global $_W;
        $sql="select yuanguo,credit2,xianguo,gengzhongguo from ".tablename('sz_yi_member')." where openid='".$openid."'";
        $member=pdo_fetch($sql);
        if($num>$member['yuanguo']){
            return false;
        }else{
           $guoshi=$member['yuanguo']-$num;//剩余的果实
           //按照比例兑换 ７０％金果（余额）　２０％鲜果　１０％耕种果
           $jinguo=$num*0.7; //兑换的金果
           //金果
           $xianguo=$num*0.2;//兑换的鲜果
           $xianguo1=$member['xianguo']+$xianguo;  //鲜果         
           $gengzhongguo=$num*0.1;    //兑换的耕种果
           $gengzhongguo1=$member['gengzhongguo']+$gengzhongguo;//耕种果
           $arr=array(
               'uniacid'=>$_W['uniacid'],
               'openid'=>$openid,
               'yuanguo'=>$num,
               'jinguo'=>$jinguo,
               'xianguo'=>$xianguo,
               'gengzhongguo'=>$gengzhongguo,
               'time'=>time()

           );
           pdo_insert('sz_yi_member_duihuan',$arr);
           m('member') -> setCredit($openid, 'credit2', + $jinguo,array(0,'总兑换原果:'.$num.'兑换金果：'.$jinguo));
           pdo_update('sz_yi_member',array("yuanguo"=>$guoshi,'xianguo'=>$xianguo1,'gengzhongguo'=>$gengzhongguo1),array('openid'=>$openid));
            return true;
        }
        
    }
    function setStocksAndCredits($dephp_17 = '', $dephp_24 = 0){
        global $_W;
        $dephp_15 = pdo_fetch('select id,ordersn,price,openid,dispatchtype,addressid,carrier,status from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $dephp_17));
        $dephp_25 = pdo_fetchall('select og.goodsid,og.total,g.totalcnf,og.realprice, g.credit,og.optionid,g.total as goodstotal,og.optionid,g.sales,g.salesreal from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $dephp_17));
        $dephp_26 = 0;
        foreach ($dephp_25 as $dephp_27){
            $dephp_28 = 0;
            if ($dephp_24 == 0){
                if ($dephp_27['totalcnf'] == 0){
                    $dephp_28 = -1;
                }
            }else if ($dephp_24 == 1){
                if ($dephp_27['totalcnf'] == 1){
                    $dephp_28 = -1;
                }
            }else if ($dephp_24 == 2){
                if ($dephp_15['status'] >= 1){
                    if ($dephp_27['totalcnf'] == 1){
                        $dephp_28 = 1;
                    }
                }else{
                    if ($dephp_27['totalcnf'] == 0){
                        $dephp_28 = 1;
                    }
                }
            }
            if (!empty($dephp_28)){
                if (!empty($dephp_27['optionid'])){
                    $dephp_29 = m('goods') -> getOption($dephp_27['goodsid'], $dephp_27['optionid']);
                    if (!empty($dephp_29) && $dephp_29['stock'] != -1){
                        $dephp_30 = -1;
                        if ($dephp_28 == 1){
                            $dephp_30 = $dephp_29['stock'] + $dephp_27['total'];
                        }else if ($dephp_28 == -1){
                            $dephp_30 = $dephp_29['stock'] - $dephp_27['total'];
                            $dephp_30 <= 0 && $dephp_30 = 0;
                        }
                        if ($dephp_30 != -1){
                            pdo_update('sz_yi_goods_option', array('stock' => $dephp_30), array('uniacid' => $_W['uniacid'], 'goodsid' => $dephp_27['goodsid'], 'id' => $dephp_27['optionid']));
                        }
                    }
                }
                if (!empty($dephp_27['goodstotal']) && $dephp_27['goodstotal'] != -1){
                    $dephp_31 = -1;
                    if ($dephp_28 == 1){
                        $dephp_31 = $dephp_27['goodstotal'] + $dephp_27['total'];
                    }else if ($dephp_28 == -1){
                        $dephp_31 = $dephp_27['goodstotal'] - $dephp_27['total'];
                        $dephp_31 <= 0 && $dephp_31 = 0;
                    }
                    if ($dephp_31 != -1){
                        pdo_update('sz_yi_goods', array('total' => $dephp_31), array('uniacid' => $_W['uniacid'], 'id' => $dephp_27['goodsid']));
                    }
                }
            }
            $dephp_32 = trim($dephp_27['credit']);
            if (!empty($dephp_32)){
                if (strexists($dephp_32, '%')){
                    $dephp_26 += intval(floatval(str_replace('%', '', $dephp_32)) / 100 * $dephp_27['realprice']);
                }else{
                    $dephp_26 += intval($dephp_27['credit']) * $dephp_27['total'];
                }
            }
            if ($dephp_24 == 0){
                pdo_update('sz_yi_goods', array('sales' => $dephp_27['sales'] + $dephp_27['total']), array('uniacid' => $_W['uniacid'], 'id' => $dephp_27['goodsid']));
            }elseif ($dephp_24 == 1){
                if ($dephp_15['status'] >= 1){
                    $dephp_33 = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where og.goodsid=:goodsid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':goodsid' => $dephp_27['goodsid'], ':uniacid' => $_W['uniacid']));
                    pdo_update('sz_yi_goods', array('salesreal' => $dephp_33), array('id' => $dephp_27['goodsid']));
                }
            }
        }
        if ($dephp_26 > 0){
            $dephp_21 = m('common') -> getSysset('shop');
            if ($dephp_24 == 1){
                m('member') -> setCredit($dephp_15['openid'], 'credit1', $dephp_26, array(0, $dephp_21['name'] . '购物积分 订单号: ' . $dephp_15['ordersn']));
            }elseif ($dephp_24 == 2){
                if ($dephp_15['status'] >= 1){
                    m('member') -> setCredit($dephp_15['openid'], 'credit1', - $dephp_26, array(0, $dephp_21['name'] . '购物取消订单扣除积分 订单号: ' . $dephp_15['ordersn']));
                }
            }
        }
    }
    function getDefaultDispatch(){
        global $_W;
        $dephp_34 = 'select * from ' . tablename('sz_yi_dispatch') . ' where isdefault=1 and uniacid=:uniacid and enabled=1 Limit 1';
        $dephp_35 = array(':uniacid' => $_W['uniacid']);
        $dephp_36 = pdo_fetch($dephp_34, $dephp_35);
        return $dephp_36;
    }
    function getNewDispatch(){
        global $_W;
        $dephp_34 = 'select * from ' . tablename('sz_yi_dispatch') . ' where uniacid=:uniacid and enabled=1 order by id desc Limit 1';
        $dephp_35 = array(':uniacid' => $_W['uniacid']);
        $dephp_36 = pdo_fetch($dephp_34, $dephp_35);
        return $dephp_36;
    }
    function getOneDispatch($dephp_37){
        global $_W;
        $dephp_34 = 'select * from ' . tablename('sz_yi_dispatch') . ' where id=:id and uniacid=:uniacid and enabled=1 Limit 1';
        $dephp_35 = array(':id' => $dephp_37, ':uniacid' => $_W['uniacid']);
        $dephp_36 = pdo_fetch($dephp_34, $dephp_35);
        return $dephp_36;
    }
}
