<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Common_EweiShopV2Model 
{
	public $public_build;
	public function getSetData($uniacid = 0) 
	{
		global $_W;
		if (empty($uniacid)) 
		{
			$uniacid = $_W['uniacid'];
		}
		$set = m('cache')->getArray('sysset', $uniacid);
		if (empty($set)) 
		{
			$set = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
			if (empty($set)) 
			{
				$set = array();
			}
			m('cache')->set('sysset', $set, $uniacid);
		}
		return $set;
	}



	  // //查上级
   //  public function shangji($id,$level){    //$id 上级的id  $level上级能获得佣金的等级
   //      global $_W;
   //      global $_GPC;
   //      $ass = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=:uniacid and id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));
   //      $arr = pdo_fetch("select * from ".tablename("ewei_shop_commission_level")."where uniacid=:uniacid and id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$ass['agentlevel']));
   //      if($ass['level']){  //获得分销商的条件等级必须在一星会员及以上
   //          if($ass['agentlevel']>=$level){   //当上级等级达到分销条件时
   //              $list = array('status'=>'1','data'=>$ass,'level'=>$arr);
   //              return $list;
   //          }else{
   //              $list = array('status'=>'-1','data'=>$ass,'level'=>$arr);
   //              return $list;
   //          }
   //      }else{
   //          $list = array('status'=>'-1','data'=>$ass,'level'=>$arr);
   //          return $list;
   //      }
   //  }

    //查无限下级
    public function memberxiaji($members,$mid){

      global $_W;

      global $_GPC;

      $Teams = array();//最终结果

      $op=1;

      $mids = array($mid);//第一次执行时候的用户id

      do {

        $othermids = array();

        $state = false;

        foreach ($mids as $valueone) {

          foreach ($members as $key => $valuetwo) {

            if($valuetwo['agentid'] == $valueone){

              $Teams[]=array('id' => $valuetwo['id'],'type'=>$op);//找到我的下级立即添加到最终结果中

              $othermids[] = $valuetwo['id'];//将我的下级id保存起来用来下轮循环他的下级


              $state=true;

            }

          }

        }

        $op = $op+1;

        $mids=$othermids;//foreach中找到的我的下级集合,用来下次循环

      } while ($state==true);

      return $Teams;
    }

    //佣金打款
    public function commission_dakuan($arr,$type,$id,$user_openid){ //$arr打款人信息  $type代数  $id订单id
        global $_W;
				global $_GPC;
				// dump($arr['isblack']);
				if($arr['isblack']==1){
					// dump($arr['isblack']);
					return 1;
				}else{
					if($arr['status']==1){  //达到分销打款的等级
							$order = pdo_fetch("select * from".tablename("ewei_shop_member_log")."where id='".$id."'");
							$level_list = pdo_fetch("select id,type,levelname,commission1 from".tablename("ewei_shop_commission_level")."where type='".$type."'");
							if($order['money']>=$arr['credit1']){
								$jifen_money = $arr['credit1']*$level_list['commission1']*0.01;         //代数积分
							}
							if($order['money'] < $arr['credit1']){
								$jifen_money = $order['money']*$level_list['commission1']*0.01; 
							}
							if($jifen_money){   //该代数的现金积分不为空
	
								//到达投资等级倍数自动退出出局
								$out_user_money = $this->out_user_money($arr['openid']);
								if ($out_user_money) {
									$data = array('title'=>'您的收益已经超过投资倍数。暂停收益','openid'=>$arr['openid'],'createtime'=>time(),'uniacid'=>$_W['uniacid']);
									pdo_insert("ewei_shop_member_log",$data);
								}else{
									m('member')->setCredit($arr['openid'],'credit2',$jifen_money);
									$data = array('orderid'=>$order['id'],'price'=>$order['price'],'openid'=>$arr['openid'],'openid2'=>$user_openid,'money'=>$jifen_money,'jifen'=>$jifen_money,'status'=>$type,'createtime'=>time(),'type'=>'1','uniacid'=>$_W['uniacid']);
									pdo_insert("ewei_shop_order_goods1",$data);
									// dump($arr['openid']);
									$moneber = pdo_fetch("select * from".tablename("ewei_shop_member")."where id = '".$arr['agentid']."'");
									// dump($moneber['openid']);die;
									//动态奖金
									$this->comm($arr['openid'],$jifen_money);
								}
							}
					}
				}
    }

   
    //递归
    public function digui($id){
        global $_W;
        global $_GPC;
        $result_1 = pdo_fetch("select m.*,l.levelname,l.id as lid from ".tablename("ewei_shop_member")."m left join ".tablename("ewei_shop_member_level")."l on m.level=l.id where m.uniacid=:uniacid and m.id=:id",array(':uniacid' => $_W['uniacid'],':id'=>$id));
        if($result_1['levelname'] && $result_1['levelname']!="商家"){
            return $this->digui($result_1['agentid']);
        }else if($result_1['levelname']=="商家"){
            return $result_1;
        }else if(!$result_1['levelname']){
            return null;
        }
    }

    //查上级，管理奖
    public function shangji1($id,$openid2,$money,$status,$type){
    	  global $_W;
        global $_GPC;

				$member = pdo_fetch("select m.openid,m.agentid,m.agentlevel2,l.* from ".tablename("ewei_shop_member")."m left join".tablename("ewei_shop_commission_level2")."l on m.agentlevel2=l.id "." where m.uniacid=".$_W['uniacid']." and m.id='$id'");
        if($member['agentlevel2']){
          //静态账户获得金额
        	$cmoney1 = round($money*$member['commission1']*0.01*0.8,6);
          //复投·账户获钱
					$cmoney2 = round($money*$member['commission1']*0.01*0.2,6);
					$cmoney3 = $cmoney1 + $cmoney2;
        	$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'2','status'=>$status,'price'=>$money,'jindongtai'=>$type);
        	pdo_insert("ewei_shop_order_goods1",$data);

          //充值
					m('member')->setCredit($member['openid'],'credit2',$cmoney3);
					return $cmoney3;
          // m('member')->setCredit($member['openid'],'credit4',$cmoney2);
				}
    }


    //查询上级 动态奖
    public function shangji($id,$openid2,$money,$type){
    	global $_W;
        global $_GPC;

       $member = pdo_fetch("select m.openid,m.agentid,m.credit1,m.agentlevel,m.type,l.* from ".tablename("ewei_shop_member")."m left join".tablename("ewei_shop_commission_level")."l on m.agentlevel=l.id "." where m.uniacid=".$_W['uniacid']." and m.id='$id'");

       if($member['type']==2){
       		return $member['agentid'];
       }

       if($member['agentlevel']){

       		//查询该上级投资金额
       		if($member['credit1'] && $member['commission'.$type]){
       			if($member['credit1']>=$money){   //上级总投资大于下级的单笔投资
              //静态账户获得金额
       				$cmoney1 = round($money*$member['commission'.$type]*0.01*0.8,6);
              //复投账户获得金额 
              $cmoney2 = round($money*$member['commission'.$type]*0.01*0.2,6);    
                    
							$cmoney3 = $ $cmoney1 + $ $cmoney2;
       				$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1 ,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'1','status'=>$type,'price'=>$money);

       				pdo_insert("ewei_shop_order_goods1",$data);

       				//充值
       				m('member')->setCredit($member['openid'],'credit2',$cmoney3);
              // m('member')->setCredit($member['openid'],'credit4',$cmoney2);

       				//判断该上级是否有拿管理奖的资格
              $agentidis = pdo_fetch("select clickcount from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id=:id",array(':id'=>$member['agentid']));
              if($agentidis['clickcount']>=5){
                  //当获得分销奖时，上级能得到一个管理奖
                  $this->shangji1($member['agentid'],$member['openid'],$cmoney1+$cmoney2,$type,2);
              }

       			}else if($member['commission'.$type]){	//上级总投资小于下级的单笔投资(烧伤机制)
       				 //静态账户获得金额
              $cmoney1 = round($money*$member['commission'.$type]*0.01*0.8,6);
              //复投账户获得金额 
              $cmoney2 = round($money*$member['commission'.$type]*0.01*0.2,6);    
							$cmoney3 = $ $cmoney1 + $ $cmoney2;
       				$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'1','status'=>$type,'price'=>$money);
       				pdo_insert("ewei_shop_order_goods1",$data);

       			  //充值
              m('member')->setCredit($member['openid'],'credit2',$cmoney3);
              // m('member')->setCredit($member['openid'],'credit4',$cmoney2);

              //判断该上级是否有拿管理奖的资格
              $agentidis = pdo_fetch("select clickcount from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id=:id",array(':id'=>$member['agentid']));
              if($agentidis['clickcount']>=5){
                  //当获得分销奖时，上级能得到一个管理奖
                  $this->shangji1($member['agentid'],$member['openid'],$cmoney1+$cmoney2,$type,2);
              }
       				

       			}
       		}
       		return $member['agentid'];  //上级

       }
       	

		}
		//获取推荐上级
		public function get_uper_user($data)
		{
				$recUser = $this->getAllUp($data);
				return array('recUser' => $recUser);
		}
		/*
		* 获取所有上级
		*/
		public function getAllUp($invite_id, &$userList = array())
		{
				global $_W;
				// $field = "user_id, first_leader, agent_user, is_lock, is_agent";
				// $UpInfo = M('users')->field($field)->where(['user_id' => $invite_id])->find();
				$UpInfo = pdo_fetch("select id,agentid,openid,type,agentlevel2,agentlevel3,suoding,mobile,isblack,status from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id= '$invite_id' ");
				if ($UpInfo)  //有上级
				{
						$userList[] = $UpInfo;
						$this->getAllUp($UpInfo['agentid'], $userList);
				}
				return $userList;
		}

    public function comm($openid,$money){   //单笔购买投资commission_dakuan
        /*
         * 8  三代会员(id)
         * 9  五代会员(id)
         * 10 九代会员(id)
         * */
        global $_W;
				global $_GPC;

				//查询投资人id
				$member = pdo_fetch("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and openid= '$openid' ");
				$user_list = $this->get_uper_user($member['id']);
				// dump($user_list);
				$money = $money;
				foreach($user_list['recUser'] as $key=>$value){
					//到达投资等级倍数自动退出出局
					$out_user_money = $this->out_user_money($value['openid']);
					if ($out_user_money) {
						$data = array('title'=>'您的收益已经超过投资倍数。暂停收益','openid'=>$arr['openid'],'createtime'=>time(),'uniacid'=>$_W['uniacid']);
						pdo_insert("ewei_shop_member_log",$data);
						continue;
					}else{
						if($key <= 0)
						{
								continue;
						}
						$member1 = pdo_fetchall("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and agentid= '".$value['id']."' and type = 1");
						//直推人数
						$nums = count($member1);
						if($nums>=5){
								$agentid = $value['id'];
								// dump('1111111-------------'.$agentid.'========'.$money);
								$list111 = m('common')->shangji1($agentid,$member['openid'],$money,$key+1,2);
								$money = $list111;
						}else{
								break;
						}
					}
				}
				
    }
	//动态管理奖
	public function comm1($openid){   //单笔购买投资commission_dakuan
		/*
			* 8  三代会员(id)
			* 9  五代会员(id)
			* 10 九代会员(id)
			* */
		global $_W;
		global $_GPC;
		//查询投资人id
		$member = pdo_fetch("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and openid= '$openid' ");
		//获取所有上级
		$user_list = $this->get_uper_user($member['id']);
		if($member['openid'] == "wap_user_12_18228178866"){
			dump($user_list);
		}
		foreach($user_list['recUser'] as $key=>$value){
			if($key>=1){
				$member1 = pdo_fetchall("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and agentid= '".$value['id']."' and type = 1");
				//直推人数
				$nums = count($member1);
				if($nums>=5){
					return true;
				}
			}
		// 	if($key>=1){
		// 		$member1 = pdo_fetchall("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and agentid= '".$value['id']."' and type = 1");
		// 		//直推人数
		// 		$nums = count($member1);
		// 		dump($value['openid'].'--------'.$value['id'].'-------'.$nums);
		// 		dump($git);
		// 		if($git==1){
		// 			break;
		// 		}
		// 		if($nums<5){
		// 			$git = 1;
		// 			continue;
		// 		}
		// 		if($nums>=5){
		// 				$agentid = $value['id'];
		// 				$list = $this->shangji1($agentid,$member['openid'],$money,$key+1);
		// 		}
		// 		$money = $list;
		// 	} 
		}
			
	}

    //领导奖所属人
   	public function leaderdigui($id,$openid2,$money,$type){

   		global $_W;
    	global $_GPC;
    	$member = pdo_fetch("select m.openid,m.agentid,m.agentlevel3,m.suoding,l.* from ".tablename("ewei_shop_member")."m left join".tablename("ewei_shop_commission_level3")."l on m.agentlevel3=l.id "." where m.uniacid=".$_W['uniacid']." and m.id='$id'");
		if($member['suoding']==1){
			if($id==0){
				return 1;
			}
		// return $this->leaderdigui($member['agentid'],$openid2,$money,$type);
		}else{

			
	    	if($member['agentlevel3']){

	    		$member2 = pdo_fetch("select m.openid,m.agentid,m.agentlevel3,l.* from ".tablename("ewei_shop_member")."m left join".tablename("ewei_shop_commission_level3")."l on m.agentlevel3=l.id "." where m.uniacid=".$_W['uniacid']." and m.id=:id",array(":id"=>$member['agentid']));
	    		//第一种情况----------------------
	    		if($member['type']==1 && $type==1){

		       		//静态账户获得金额
	            $cmoney1 = round($money*$member['commission1']*0.01*0.8,6);
	            //复投·账户获钱
				$cmoney2 = round($money*$member['commission1']*0.01*0.2,6);
				$cmoney3 = $cmoney1 + $$cmoney2;
	       		$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'1','price'=>$money);
	       		pdo_insert("ewei_shop_order_goods1",$data);

 				//充值
 				m('member')->setCredit($member['openid'],'credit2',$cmoney3);
	            // m('member')->setCredit($member['openid'],'credit4',$cmoney2);

		       		//查看是否有同级领导收益
	       		if($member2['type']==$member['type']){

	       			$cmoney1  = round($cmoney3*$member['commission1']*0.01*0.8*0.1,6);
	                $cmoney2  = round($cmoney3*$member['commission1']*0.01*0.2*0.1,6);
		       		$cmoney3  = $cmoney1 + $cmoney2;
	       			$data2 = array('uniacid'=>$_W['uniacid'],'openid'=>$member2['openid'],'openid2'=>$openid2,'money'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'2','price'=>$money);

	       			pdo_insert("ewei_shop_order_goods1",$data2);

	   				//充值
	   				m('member')->setCredit($member['openid'],'cmoney3',$cmoney1);
	            	// m('member')->setCredit($member['openid'],'credit4',$cmoney2);

	       			//查询第二次团队奖
	       			return $this->leaderdigui($member2['agentid'],$openid2,$money,2);
		       			
	       		}else{
	       			//查询第二次团队奖
	       			return $this->leaderdigui($member['agentid'],$openid2,$money,2);
	       		}

		       		

		        }
		        
		        if($member['type']==2 && $type==2){
		        		
		        	$ass = pdo_fetch("select commission1 from ".tablename("ewei_shop_commission_level3")."where uniacid=".$_W['uniacid']." and type='1'");	

		        	$cmoney1 = round($money*($member['commission1']-$ass['commission1'])*0.01*0.8,6);
	            	$cmoney2 = round($money*($member['commission1']-$ass['commission1'])*0.01*0.2,6);
		       				
		       		$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'1','price'=>$money);

		       		pdo_insert("ewei_shop_order_goods1",$data);

	   				  //充值
	   				  m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	            m('member')->setCredit($member['openid'],'credit4',$cmoney2);


		       		
		       		//查看是否有同级领导收益
		       		if($member2['type']==$member['type']){

		       			$cmoney1 = round($money*($member['commission1']-$ass['commission1'])*0.01*0.8*0.1,6);
	              $cmoney2 = round($money*($member['commission1']-$ass['commission1'])*0.01*0.2*0.1,6);
		       				
		       			$data2 = array('uniacid'=>$_W['uniacid'],'openid'=>$member2['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'2','price'=>$money);

		       			pdo_insert("ewei_shop_order_goods1",$data2);

		   				//充值
		   				m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	            m('member')->setCredit($member['openid'],'credit4',$cmoney2);

		       			//查询第三次团队奖
		       			return $this->leaderdigui($member2['agentid'],$openid2,$money,3);
		       			
		       		}else{

		       			//查询第三次团队奖
		       			return $this->leaderdigui($member['agentid'],$openid2,$money,3);

		       		}

		        }

		        if($member['type']==3 && $type==3){
		        		
		        	$ass = pdo_fetch("select commission1 from ".tablename("ewei_shop_commission_level3")."where uniacid=".$_W['uniacid']." and type='1'");
		        	$ass2 = pdo_fetch("select commission1 from ".tablename("ewei_shop_commission_level3")."where uniacid=".$_W['uniacid']." and type='2'");		

		        	$cmoney1 = round($money*($member['commission1']-$ass['commission1']-($ass2['commission1']-$ass['commission1']))*0.01*0.8,6);
	            $cmoney2 = round($money*($member['commission1']-$ass['commission1']-($ass2['commission1']-$ass['commission1']))*0.01*0.2,6);
		       				
		       		$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'1','price'=>$money);

		       		pdo_insert("ewei_shop_order_goods1",$data);

	   				//充值
	   				m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	          m('member')->setCredit($member['openid'],'credit4',$cmoney2);
		       		
		       		//查看是否有同级领导收益
		       		if($member2['type']==$member['type']){

		       			$cmoney1 = round($money*($member['commission1']-$ass['commission1']-($ass2['commission1']-$ass['commission1']))*0.01*0.8*0.1,6);
	            $cmoney2 = round($money*($member['commission1']-$ass['commission1']-($ass2['commission1']-$ass['commission1']))*0.01*0.2*0.1,6);
		       				
		       			$data2 = array('uniacid'=>$_W['uniacid'],'openid'=>$member2['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'2','price'=>$money);

		       			pdo_insert("ewei_shop_order_goods1",$data2);

		   				//充值
		   				m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	            m('member')->setCredit($member['openid'],'credit4',$cmoney2);
		     			return 1;	
		       			
		       		}

		        }

		        //第一种情况----------------------

		        //第二种情况----------------------
		        if($member['type']==2 && $type==1){
		        		
		        	$cmoney1 = round($money*$member['commission1']*0.01*0.8,6);
	            $cmoney2 = round($money*$member['commission1']*0.01*0.2,6);
		       				
		       		$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'1','price'=>$money);

		       		pdo_insert("ewei_shop_order_goods1",$data);

	   				//充值
	   				m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	          m('member')->setCredit($member['openid'],'credit4',$cmoney2);

		       		//查看是否有同级领导收益
		       		if($member2['type']==$member['type']){

		       			$cmoney1 = round($money*$member['commission1']*0.01*0.8*0.1,6);
	              $cmoney2 = round($money*$member['commission1']*0.01*0.2*0.1,6);
		       				
		       			$data2 = array('uniacid'=>$_W['uniacid'],'openid'=>$member2['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'2','price'=>$money);

		       			pdo_insert("ewei_shop_order_goods1",$data2);

		   				//充值
		   				m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	            m('member')->setCredit($member['openid'],'credit4',$cmoney2);

		       			//查询第二次团队奖
		       			return $this->leaderdigui($member2['agentid'],$openid2,$money,2);
		       			
		       		}else{

		       			//查询第二次团队奖
		       			return $this->leaderdigui($member['agentid'],$openid2,$money,2);
		       		}

		        }

		        if($member['type']==3 && $type==2){

		        	$ass = pdo_fetch("select commission1 from ".tablename("ewei_shop_commission_level3")."where uniacid=".$_W['uniacid']." and type='2'");	

		        	$cmoney1 = round($money*($member['commission1']-$ass['commission1'])*0.01*0.8,6);
		       		$cmoney2 = round($money*($member['commission1']-$ass['commission1'])*0.01*0.2,6);

		       		$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'1','price'=>$money);

		       		pdo_insert("ewei_shop_order_goods1",$data);

	   				//充值
	   				m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	          m('member')->setCredit($member['openid'],'credit4',$cmoney2);
		       		
		       		//查看是否有同级领导收益
		       		if($member2['type']==$member['type']){

		       		  $cmoney1 = round($money*($member['commission1']-$ass['commission1'])*0.01*0.8*0.1,6);
	              $cmoney2 = round($money*($member['commission1']-$ass['commission1'])*0.01*0.2*0.1,6);
		       				
		       			$data2 = array('uniacid'=>$_W['uniacid'],'openid'=>$member2['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'2','price'=>$money);

		       			pdo_insert("ewei_shop_order_goods1",$data2);

		   				//充值
	          m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	          m('member')->setCredit($member['openid'],'credit4',$cmoney2);
						return 1;	
		       			
		       		}
		        }
		        //第二种情况----------------------

		        //第三种情况----------------------
		        if($member['type']==3 && $type==1){
		        	
		        	$cmoney1 = round($money*$member['commission1']*0.01*0.8,6);
	            $cmoney2 = round($money*$member['commission1']*0.01*0.2,6);
		       				
		       		$data = array('uniacid'=>$_W['uniacid'],'openid'=>$member['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'1','price'=>$money);

		       		pdo_insert("ewei_shop_order_goods1",$data);

	   				//充值
	          m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	          m('member')->setCredit($member['openid'],'credit4',$cmoney2);

		       		//查看是否有同级领导收益
		       		if($member2['type']==$member['type']){

	             $cmoney1 = round($money*$member['commission1']*0.01*0.8*0.1,6);
	             $cmoney2 = round($money*$member['commission1']*0.01*0.2*0.1,6);
		       				
		       			$data2 = array('uniacid'=>$_W['uniacid'],'openid'=>$member2['openid'],'openid2'=>$openid2,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'2','price'=>$money);

		       			pdo_insert("ewei_shop_order_goods1",$data2);

		   				//充值
	           m('member')->setCredit($member['openid'],'credit2',$cmoney1);
	           m('member')->setCredit($member['openid'],'credit4',$cmoney2);
		   				return 1;		
		       			
		       		}
		        }
		        return $this->leaderdigui($member['agentid'],$openid2,$money,$type);
	    	}else{
	    		if($id==0){
	    			return 1;
	    		}
	    		return $this->leaderdigui($member['agentid'],$openid2,$money,$type);
				}
			}
    	

   	}

		 //到达投资等级倍数自动退出出局
		public function out_user_money($openid)
		{
			global $_W;
			$credit = 0;
			$credit1 = 0;
			$receive_hongbao = pdo_fetchall("select * from" . tablename("ewei_shop_receive_hongbao") . "where openid='" . $openid . "'");
			$receive_logs    = pdo_fetchall("select * from" . tablename("ewei_shop_order_goods1") . "where openid='" . $openid . "'");
			foreach ($receive_logs as $key1 => $value1){
					$credit1 += $value1['money']+$value1['money2'];
			}
			foreach ($receive_hongbao as $k => $val) {
					$credit += $val['money'] + $val['money2'];
			}
			$credit = $credit1 + $credit;
			 //获取该会员最高的投资倍率
			 $arr1 = m('member')->getMember($openid, true);

			 //最高倍率相应的释放比例
			 $result  = pdo_fetch("select * from" . tablename("ewei_shop_commission_level4") . "where uniacid=" . $_W['uniacid'] . " and start<=" . $arr1['credit1'] . " and end>=" . $arr1['credit1']);

			  //收益总币数
				$money_propor = $result['multiple'] * $arr1['credit1'];
				if($arr1['credit1']>0){
					if ($credit >= $money_propor) {
						pdo_update("ewei_shop_member", " suoding='1' ", array('openid' => $openid));
						return true;
					}else{
						return false;
					}
				}

		}

    public function leader($openid,$money){

    	global $_W;
    	global $_GPC;

    	//查询投资人id
			$member = pdo_fetch("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and openid= '$openid' ");
			// $agentid = $member['agentid'];
			//获取用户上级所有上级
			$user_list = $this->get_uper_user($member['agentid']);
			$this->bonus($user_list['recUser'],$money,$openid);
			// foreach($user_list['recUser'] as $key=>$value)
			// {
			// 	if($value['suoding'] == 1)
			// 	{
			// 		return 1;
			// 	}
				// $user_level = pdo_fetch("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and openid= '$openid' ");
				// $user_level = pdo_fetch("select * from".tablename("ewei_shop_commission_level3")."where id='".$value['agentlevel3']."'");
			// 	dump($user_level['type']);
			// }
			// dump($user_list);
			// //查该投资人所属团队(谁拿第一笔团队奖)
			// $list = $this->leaderdigui($id,$openid,$money,1);
			// return $list;


		}
		//根据等级判断用户是否获取领导收益

		public function bonus($meetUser,$price,$openid)
		{
			// dump($meetUser);die;
			global $_W;
			$logName  = '级差奖';
			// //获取分红比例
			// $rateArr  = $this->get_js_rate();
			$useRate = 0;
			$pj_money = 0;
			$userLevel = 0;
			$sourceType = 4;
			$is_top = false;
			foreach($meetUser as $k => $user){
				if($user['type']==0 || $user['suoding'] == 1 || $user['isblack'] == 1) continue;
				// $grade  = $user['agent_user'];
				// if($grade < $userLevel) continue;
				//获取分红比例
				$user_level = pdo_fetch("select * from".tablename("ewei_shop_commission_level3")."where id='".$user['agentlevel3']."'");
				$jsRate = intval($user_level['commission1']) - $useRate;
				
				// if($jsRate<0) continue;
				$money = ($price*$jsRate/100);
				
				if($jsRate==0) 
				{

				// 	$jsRate  = $rateArr[127];
				// 	$logName = '平级奖';
				// 	$sourceType = 5;
					$money = ($pj_money*10/100);
					if($money<0){
						load()->func('logging');
						logging_run(array("data"=>$pj_money,"id"=>json_encode($user)));
					}
				// 	$is_top = true;
				}
				$useRate = $user_level['commission1'];
				// $userLevel = $grade;
				$pj_money = $money;
				
				//静态账户获得金额
				$cmoney1 = round($money*0.8,6);
				//复投·账户获钱
				$cmoney2 = round($money*0.2,6);
				$cmoney3 = $cmoney1 + $cmoney2;
				if($cmoney1<0){
					load()->func('logging');
					logging_run('数据为负数');
				}
				if($cmoney2<0){
					load()->func('logging');
					logging_run('数据为负数');
				}
				$data = array('uniacid'=>$_W['uniacid'],'openid'=>$user['openid'],'openid2'=>$openid,'money'=>$cmoney1,'money2'=>$cmoney2,'createtime'=>time(),'type'=>'3','status'=>'1','price'=>$money);
				pdo_insert("ewei_shop_order_goods1",$data);

				//充值
				m('member')->setCredit($user['openid'],'credit2',$cmoney3);
				// dump($jsRate.'+++++++++++++'.$money.'++++++++++++'.$user['openid']);
				// $users = $this->first_leader($user['user_id']);
				// $data = array(
				// 	'user_money'=>$users['user_money']+$money
				// );
				// $res = M('users')->where(['user_id'=>$users['user_id']])->update($data);
				// if($res)
				// {
				// 	$this->writeLog($users['user_id'],$money,$logName,101);
				// }
				//平级脱离
				// if($is_top){
				// 	break;
				// }
			}
		}



	public function getSysset($key = '', $uniacid = 0) 
	{
		global $_W;
		global $_GPC;
		$set = $this->getSetData($uniacid);
		$allset = iunserializer($set['sets']);
		$retsets = array();
		if (!(empty($key))) 
		{
			if (is_array($key)) 
			{
				foreach ($key as $k ) 
				{
					$retsets[$k] = ((isset($allset[$k]) ? $allset[$k] : array()));
				}
			}
			else 
			{
				$retsets = ((isset($allset[$key]) ? $allset[$key] : array()));
			}
			return $retsets;
		}
		return $allset;
	}
	public function getPluginset($key = '', $uniacid = 0) 
	{
		global $_W;
		global $_GPC;
		$set = $this->getSetData($uniacid);
		$allset = iunserializer($set['plugins']);
		$retsets = array();
		if (!(empty($key))) 
		{
			if (is_array($key)) 
			{
				foreach ($key as $k ) 
				{
					$retsets[$k] = ((isset($allset[$k]) ? $allset[$k] : array()));
				}
			}
			else 
			{
				$retsets = ((isset($allset[$key]) ? $allset[$key] : array()));
			}
			return $retsets;
		}
		return $allset;
	}
	public function updateSysset($values, $uniacid = 0) 
	{
		global $_W;
		global $_GPC;
		if (empty($uniacid)) 
		{
			$uniacid = $_W['uniacid'];
		}
		$setdata = pdo_fetch('select id, sets from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		if (empty($setdata)) 
		{
			pdo_insert('ewei_shop_sysset', array('sets' => iserializer($values), 'uniacid' => $uniacid));
		}
		else 
		{
			$sets = iunserializer($setdata['sets']);
			$sets = ((is_array($sets) ? $sets : array()));
			foreach ($values as $key => $value ) 
			{
				foreach ($value as $k => $v ) 
				{
					$sets[$key][$k] = $v;
				}
			}
			pdo_update('ewei_shop_sysset', array('sets' => iserializer($sets)), array('id' => $setdata['id']));
		}
		$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		m('cache')->set('sysset', $setdata, $uniacid);
		$this->setGlobalSet($uniacid);
	}
	public function deleteSysset($key, $uniacid = 0) 
	{
		global $_W;
		global $_GPC;
		if (empty($uniacid)) 
		{
			$uniacid = $_W['uniacid'];
		}
		$setdata = pdo_fetch('select id, sets from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		if (!(empty($setdata))) 
		{
			$sets = iunserializer($setdata['sets']);
			$sets = ((is_array($sets) ? $sets : array()));
			if (!(empty($key))) 
			{
				if (is_array($key)) 
				{
					foreach ($key as $k ) 
					{
						unset($sets[$k]);
					}
				}
				else 
				{
					unset($sets[$key]);
				}
			}
			pdo_update('ewei_shop_sysset', array('sets' => iserializer($sets)), array('id' => $setdata['id']));
		}
		$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		m('cache')->set('sysset', $setdata, $uniacid);
		$this->setGlobalSet($uniacid);
	}
	public function updatePluginset($values, $uniacid = 0) 
	{
		global $_W;
		global $_GPC;
		if (empty($uniacid)) 
		{
			$uniacid = $_W['uniacid'];
		}
		$setdata = pdo_fetch('select id, plugins from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		if (empty($setdata)) 
		{
			pdo_insert('ewei_shop_sysset', array('plugins' => iserializer($values), 'uniacid' => $uniacid));
		}
		else 
		{
			$plugins = iunserializer($setdata['plugins']);
			if (!(is_array($plugins))) 
			{
				$plugins = array();
			}
			foreach ($values as $key => $value ) 
			{
				foreach ($value as $k => $v ) 
				{
					if (!(isset($plugins[$key])) || !(is_array($plugins[$key]))) 
					{
						$plugins[$key] = array();
					}
					$plugins[$key][$k] = $v;
				}
			}
			pdo_update('ewei_shop_sysset', array('plugins' => iserializer($plugins)), array('id' => $setdata['id']));
		}
		$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		m('cache')->set('sysset', $setdata, $uniacid);
		$this->setGlobalSet($uniacid);
	}
	public function setGlobalSet($uniacid = 0) 
	{
		$sysset = $this->getSysset('', $uniacid);
		$sysset = ((is_array($sysset) ? $sysset : array()));
		$pluginset = $this->getPluginset('', $uniacid);
		if (is_array($pluginset)) 
		{
			foreach ($pluginset as $k => $v ) 
			{
				$sysset[$k] = $v;
			}
		}
		m('cache')->set('globalset', $sysset, $uniacid);
		return $sysset;
	}
	public function alipay_build($params, $alipay = array(), $type = 0, $openid = '') 
	{
		global $_W;
		$tid = $params['tid'];
		$set = array();
		$set['service'] = 'alipay.wap.create.direct.pay.by.user';
		$set['partner'] = $alipay['partner'];
		$set['_input_charset'] = 'utf-8';
		$set['sign_type'] = 'MD5';
		if (empty($type)) 
		{
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('order/pay_alipay/complete', array('openid' => $openid, 'fromwechat' => (is_weixin() ? 1 : 0)), true);
		}
		else if ($type == 20) 
		{
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('creditshop/detail/creditshop_complete', array('openid' => $openid, 'fromwechat' => (is_weixin() ? 1 : 0)), true);
		}
		else if ($type == 21) 
		{
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('creditshop/log/dispatch_complete', array('openid' => $openid, 'fromwechat' => (is_weixin() ? 1 : 0)), true);
		}
		else if ($type == 22) 
		{
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('threen/register/threen_complete', array('openid' => $openid, 'fromwechat' => (is_weixin() ? 1 : 0)), true);
		}
		else 
		{
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('order/pay_alipay/recharge_complete', array('openid' => $openid, 'fromwechat' => (is_weixin() ? 1 : 0)), true);
		}
		$set['out_trade_no'] = $tid;
		$set['subject'] = $params['title'];
		$set['total_fee'] = $params['fee'];
		$set['seller_id'] = $alipay['account'];
		$set['app_pay'] = 'Y';
		$set['payment_type'] = 1;
		$set['body'] = $_W['uniacid'] . ':' . $type;
		$prepares = array();
		foreach ($set as $key => $value ) 
		{
			if (($key != 'sign') && ($key != 'sign_type')) 
			{
				$prepares[] = $key . '=' . $value;
			}
		}
		sort($prepares);
		$string = implode($prepares, '&');
		$string .= $alipay['secret'];
		$set['sign'] = md5($string);
		return array('url' => ALIPAY_GATEWAY . '?' . http_build_query($set, '', '&'));
	}
	public function publicAliPay($params = array(), $return = NULL) 
	{
		$public = array('app_id' => $params['app_id'], 'method' => $params['method'], 'format' => 'JSON', 'charset' => 'utf-8', 'sign_type' => 'RSA', 'timestamp' => date('Y-m-d H:i:s'), 'version' => '1.0');
		if (!(empty($params['return_url']))) 
		{
			$public['return_url'] = $params['return_url'];
		}
		if (!(empty($params['app_auth_token']))) 
		{
			$public['app_auth_token'] = $params['app_auth_token'];
		}
		if (!(empty($params['notify_url']))) 
		{
			$public['notify_url'] = $params['notify_url'];
		}
		if (!(empty($params['biz_content']))) 
		{
			$public['biz_content'] = ((is_array($params['biz_content']) ? json_encode($params['biz_content']) : $params['biz_content']));
		}
		ksort($public);
		$string1 = '';
		foreach ($public as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 = rtrim($string1, '&');
		$pkeyid = openssl_pkey_get_private($this->chackKey($params['privatekey'], false));
		if ($pkeyid === false) 
		{
			return error(-1, '提供的私钥格式不对');
		}
		$signature = '';
		openssl_sign($string1, $signature, $pkeyid, OPENSSL_ALGO_SHA1);
		openssl_free_key($pkeyid);
		$signature = base64_encode($signature);
		$public['sign'] = $signature;
		load()->func('communication');
		$url = ((EWEI_SHOPV2_DEBUG ? 'https://openapi.alipaydev.com/gateway.do' : 'https://openapi.alipay.com/gateway.do'));
		if ($return !== NULL) 
		{
			return $public;
		}
		$response = ihttp_post($url, $public);
		$result = json_decode(iconv('GBK', 'UTF-8//IGNORE', $response['content']), true);
		return $result;
	}
	public function chackKey($key, $public = true) 
	{
		if (empty($key)) 
		{
			return $key;
		}
		if ($public) 
		{
			if (strexists($key, '-----BEGIN PUBLIC KEY-----')) 
			{
				$key = str_replace(array('-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----'), '', $key);
			}
			$head_end = '-----BEGIN PUBLIC KEY-----' . "\n" . '{key}' . "\n" . '-----END PUBLIC KEY-----';
		}
		else if (strexists($key, '-----BEGIN RSA PRIVATE KEY-----')) 
		{
			$key = str_replace(array('-----BEGIN RSA PRIVATE KEY-----', '-----END RSA PRIVATE KEY-----'), '', $key);
		}
		else 
		{
			$head_end = '-----BEGIN RSA PRIVATE KEY-----' . "\n" . '{key}' . "\n" . '-----END RSA PRIVATE KEY-----';
		}
		$key = str_replace(array("\r\n", "\r", "\n"), '', trim($key));
		$key = wordwrap($key, 64, "\n", true);
		return str_replace('{key}', $key, $head_end);
	}
	public function AliPayBarcode($params, $config) 
	{
		global $_W;
		$biz_content = array();
		$biz_content['out_trade_no'] = $params['out_trade_no'];
		$biz_content['scene'] = 'bar_code';
		$biz_content['auth_code'] = $params['auth_code'];
		$biz_content['seller_id'] = $config['seller_id'];
		$biz_content['total_amount'] = $params['total_amount'];
		$biz_content['subject'] = $params['subject'];
		$biz_content['body'] = $params['body'];
		$biz_content['timeout_express'] = '90m';
		$biz_content = array_filter($biz_content);
		$config['method'] = 'alipay.trade.pay';
		$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config);
		if (is_error($result)) 
		{
			return $result;
		}
		$key = str_replace('.', '_', $config['method']) . '_response';
		if ($result[$key]['code'] == '10000') 
		{
			return $result[$key];
		}
		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}
	public function AliPayWap($params, $config) 
	{
		global $_W;
		$biz_content = array();
		$biz_content['out_trade_no'] = $params['out_trade_no'];
		$biz_content['seller_id'] = $config['seller_id'];
		$biz_content['total_amount'] = $params['total_amount'];
		$biz_content['subject'] = $params['subject'];
		$biz_content['body'] = $params['body'];
		$biz_content['product_code'] = 'QUICK_WAP_PAY';
		$biz_content['timeout_express'] = '90m';
		$biz_content = array_filter($biz_content);
		$config['method'] = 'alipay.trade.wap.pay';
		$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config, 1);
		return $result;
	}
	public function AliPayQuery($out_trade_no, $config) 
	{
		$biz_content = array();
		$biz_content['out_trade_no'] = $out_trade_no;
		$config['method'] = 'alipay.trade.query';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config);
		if (is_error($result)) 
		{
			return $result;
		}
		$key = str_replace('.', '_', $config['method']) . '_response';
		if (($result[$key]['code'] == '10000') && ($result[$key]['trade_status'] == 'TRADE_SUCCESS')) 
		{
			return $result[$key];
		}
		if (!(empty($result[$key]['trade_status'])) && ($result[$key]['trade_status'] == 'TRADE_CLOSED')) 
		{
			return error($result[$key]['code'], '该订单已经关闭或者已经退款');
		}
		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}
	public function AliPayRefundQuery($out_trade_no, $config) 
	{
		$biz_content = array();
		$biz_content['out_trade_no'] = $out_trade_no;
		$biz_content['out_request_no'] = $out_trade_no;
		$config['method'] = 'alipay.trade.fastpay.refund.query';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config);
		if (is_error($result)) 
		{
			return $result;
		}
		$key = str_replace('.', '_', $config['method']) . '_response';
		if (($result[$key]['code'] == '10000') && ($result[$key]['msg'] == 'Success')) 
		{
			return $result[$key];
		}
		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}
	public function AlipayOpenAuthTokenAppRequest($app_code, $config) 
	{
		$biz_content = array();
		$biz_content['grant_type'] = 'authorization_code';
		$biz_content['code'] = $app_code;
		$config['method'] = 'alipay.open.auth.token.app';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config);
		if (is_error($result)) 
		{
			return $result;
		}
		$key = str_replace('.', '_', $config['method']) . '_response';
		if (($result[$key]['code'] == '10000') && ($result[$key]['msg'] == 'Success')) 
		{
			return $result[$key];
		}
		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}
	public function AlipayOpenAuthTokenAppQueryRequest($app_auth_token, $config) 
	{
		$biz_content = array();
		$biz_content['app_auth_token'] = $app_auth_token;
		$config['method'] = 'alipay.open.auth.token.app.query';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config);
		if (is_error($result)) 
		{
			return $result;
		}
		$key = str_replace('.', '_', $config['method']) . '_response';
		if (($result[$key]['code'] == '10000') && ($result[$key]['msg'] == 'Success')) 
		{
			return $result[$key];
		}
		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}
	public function ToXml($arr) 
	{
		if (!(is_array($arr)) || (count($arr) <= 0)) 
		{
			return error(-1, '数组数据异常！');
		}
		$xml = '<xml>';
		foreach ($arr as $key => $val ) 
		{
			if (is_numeric($val)) 
			{
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else 
			{
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}
		$xml .= '</xml>';
		return $xml;
	}
	public function FromXml($xml) 
	{
		if (!($xml)) 
		{
			return error(-1, 'xml数据异常！');
		}
		libxml_disable_entity_loader(true);
		$arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $arr;
	}
	public function ToUrlParams($arr) 
	{
		$buff = '';
		foreach ($arr as $k => $v ) 
		{
			if (($k != 'sign') && ($v != '') && !(is_array($v))) 
			{
				$buff .= $k . '=' . $v . '&';
			}
		}
		$buff = trim($buff, '&');
		return $buff;
	}
	public function changeTitle($title) 
	{
		$title = preg_replace('/[^\\x{4e00}-\\x{9fa5}A-Za-z0-9_]/u', '', $title);
		return $title;
	}
	public function public_build($isapp = false) 
	{
		global $_W;
		if (!(empty($this->public_build))) 
		{
			return $this->public_build;
		}
		$set = $this->getSysset('pay');
		if (!(empty($set['weixin_id'])) && ($isapp == false)) 
		{
			$payments = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_payment') . ' WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $set['weixin_id']));
			if (empty($payments)) 
			{
				error(-1, '支付参数不存在!');
			}
			$payments['is_new'] = 1;
		}
		else 
		{
			$payments = m('common')->getSec();
			$payments = iunserializer($payments['sec']);
			$payments['is_new'] = 0;
		}
		$this->public_build = array($set, $payments);
		return $this->public_build;
	}
	public function wechat_build($params, $wechat, $type = 0) 
	{
		global $_W;
		list(, $payment) = $this->public_build();
		if (is_error($payment)) 
		{
			return $payment;
		}
		$params['title'] = $this->changeTitle($params['title']);
		if (($payment['is_new'] == 0) && !(empty($payment['weixin_sub']))) 
		{
			$wechat = array('appid' => $payment['appid_sub'], 'mch_id' => $payment['mchid_sub'], 'sub_appid' => (!(empty($payment['sub_appid_sub'])) ? $payment['sub_appid_sub'] : ''), 'sub_mch_id' => $payment['sub_mchid_sub'], 'apikey' => $payment['apikey_sub']);
			$params['openid'] = ((isset($params['user']) ? $params['user'] : $_W['openid']));
			return $this->wechat_child_build($params, $wechat, $type);
		}
		if ($payment['is_new'] == 1) 
		{
			if (empty($payment['type'])) 
			{
				return $this->wechat_jspay($params, $payment, $type);
			}
			if ($payment['type'] == 1) 
			{
				$params['openid'] = ((isset($params['user']) ? $params['user'] : $_W['openid']));
				return $this->wechat_child_build($params, $payment, $type);
			}
			if ($payment['type'] == 2) 
			{
				$wechat = array('appid' => $payment['sub_appid'], 'mchid' => $payment['sub_mch_id'], 'apikey' => $payment['apikey']);
				if (!(empty($payment['sub_appsecret']))) 
				{
					$wxuser = m('member')->wxuser($payment['sub_appid'], $payment['sub_appsecret']);
					$params['openid'] = $wxuser['openid'];
				}
				return $this->wechat_native_build($params, $wechat, $type);
			}
			if ($payment['type'] == 3) 
			{
				return $this->wechat_native_child_build($params, $payment, $type);
			}
			if ($payment['type'] == 4) 
			{
				$params = array('service' => 'pay.weixin.jspay', 'body' => $params['title'], 'out_trade_no' => $params['tid'], 'total_fee' => $params['fee'], 'openid' => (empty($params['openid']) ? $_W['openid'] : $params['openid']));
				$payRes = m('pay')->build($params, $payment, $type);
				if (is_error($payRes)) 
				{
					return $payRes;
				}
				return json_decode($payRes['pay_info'], true);
			}
		}
		$payment['sub_appid'] = $wechat['appid'];
		$payment['sub_mch_id'] = $wechat['mchid'];
		$payment['apikey'] = $wechat['apikey'];
		return $this->wechat_jspay($params, $payment, $type);
	}
	public function wechat_jspay($params, $wechat, $type = 0) 
	{
		global $_W;
		load()->func('communication');
		$wOpt = array();
		$package = array();
		$package['appid'] = $wechat['sub_appid'];
		$package['mch_id'] = $wechat['sub_mch_id'];
		$package['nonce_str'] = random(32);
		$package['body'] = $params['title'];
		$package['device_info'] = 'ewei_shopv2';
		$package['attach'] = $_W['uniacid'] . ':' . $type;
		$package['out_trade_no'] = $params['tid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		if (!(empty($params['goods_tag']))) 
		{
			$package['goods_tag'] = $params['goods_tag'];
		}
		$package['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php';
		$package['trade_type'] = 'JSAPI';
		$package['openid'] = ((empty($params['openid']) ? $_W['openid'] : $params['openid']));
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
		if (is_error($response)) 
		{
			return $response;
		}
		$xml = @simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		if (strval($xml->return_code) == 'FAIL') 
		{
			return error(-1, strval($xml->return_msg));
		}
		if (strval($xml->result_code) == 'FAIL') 
		{
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}
		$prepayid = $xml->prepay_id;
		$wOpt['appId'] = $wechat['sub_appid'];
		$wOpt['timeStamp'] = TIMESTAMP . '';
		$wOpt['nonceStr'] = random(32);
		$wOpt['package'] = 'prepay_id=' . $prepayid;
		$wOpt['signType'] = 'MD5';
		ksort($wOpt, SORT_STRING);
		$string = '';
		foreach ($wOpt as $key => $v ) 
		{
			$string .= $key . '=' . $v . '&';
		}
		$string .= 'key=' . $wechat['apikey'];
		$wOpt['paySign'] = strtoupper(md5($string));
		return $wOpt;
	}
	public function wechat_child_build($params, $wechat, $type = 0) 
	{
		global $_W;
		load()->func('communication');
		$package = array();
		$package['appid'] = $wechat['appid'];
		$package['mch_id'] = $wechat['mch_id'];
		$package['sub_mch_id'] = $wechat['sub_mch_id'];
		$package['nonce_str'] = random(32);
		$package['body'] = $params['title'];
		$package['device_info'] = ((isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2'));
		$package['attach'] = ((isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid'])) . ':' . $type;
		$package['out_trade_no'] = $params['tid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['product_id'] = $params['goods_id'];
		if (!(empty($params['goods_tag']))) 
		{
			$package['goods_tag'] = $params['goods_tag'];
		}
		$package['time_start'] = date('YmdHis', TIMESTAMP);
		$package['time_expire'] = date('YmdHis', TIMESTAMP + 3600);
		$package['notify_url'] = ((empty($params['notify_url']) ? $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php' : $params['notify_url']));
		$package['trade_type'] = 'JSAPI';
		if (!(empty($wechat['sub_appid']))) 
		{
			$package['sub_appid'] = $wechat['sub_appid'];
			$package['sub_openid'] = $params['openid'];
		}
		else 
		{
			$package['openid'] = $params['openid'];
		}
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
		if (is_error($response)) 
		{
			return $response;
		}
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		if (strval($xml->return_code) == 'FAIL') 
		{
			return error(-1, strval($xml->return_msg));
		}
		if (strval($xml->result_code) == 'FAIL') 
		{
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}
		libxml_disable_entity_loader(true);
		$prepayid = $xml->prepay_id;
		$wOpt = array('appId' => $wechat['sub_appid'], 'timeStamp' => TIMESTAMP . '', 'nonceStr' => random(32), 'package' => 'prepay_id=' . $prepayid, 'signType' => 'MD5');
		ksort($wOpt, SORT_STRING);
		$string = '';
		foreach ($wOpt as $key => $v ) 
		{
			$string .= $key . '=' . $v . '&';
		}
		$string .= 'key=' . $wechat['apikey'];
		$wOpt['paySign'] = strtoupper(md5($string));
		return $wOpt;
	}
	public function wechat_native_build($params, $wechat, $type = 0, $diy = NULL) 
	{
		global $_W;
		if ($diy === NULL) 
		{
			list(, $payment) = $this->public_build();
			if (is_error($payment)) 
			{
				return $payment;
			}
			if (($payment['is_new'] == 0) && !(empty($payment['weixin_jie_sub']))) 
			{
				$wechat = array('appid' => $payment['appid_jie_sub'], 'mch_id' => $payment['mchid_jie_sub'], 'sub_appid' => (!(empty($payment['sub_appid_jie_sub'])) ? $payment['sub_appid_jie_sub'] : ''), 'sub_appsecret' => (!(empty($payment['sub_secret_jie_sub'])) ? $payment['sub_secret_jie_sub'] : ''), 'sub_mch_id' => $payment['sub_mchid_jie_sub'], 'apikey' => $payment['apikey_jie_sub']);
				return $this->wechat_native_child_build($params, $wechat, $type);
			}
			if ($payment['is_new'] == 1) 
			{
				if ($payment['type'] == 3) 
				{
					return $this->wechat_native_child_build($params, $payment, $type);
				}
				if ($payment['type'] == 4) 
				{
					$params = array('service' => 'pay.weixin.jspay', 'body' => $params['title'], 'out_trade_no' => $params['tid'], 'total_fee' => $params['fee'], 'openid' => (empty($params['openid']) ? $_W['openid'] : $params['openid']));
					$payRes = m('pay')->build($params, $payment, 0);
					if (is_error($payRes)) 
					{
						return $payRes;
					}
					return $payRes;
				}
			}
		}
		if (!(empty($params['openid']))) 
		{
			$wechat['sub_appid'] = $wechat['appid'];
			$wechat['sub_mch_id'] = $wechat['mchid'];
			return $this->wechat_jspay($params, $wechat, $type);
		}
		$package = array();
		$package['appid'] = $wechat['appid'];
		$package['mch_id'] = $wechat['mchid'];
		$package['nonce_str'] = random(32);
		$package['body'] = $params['title'];
		$package['device_info'] = ((isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2'));
		$package['attach'] = ((isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid'])) . ':' . $type;
		$package['out_trade_no'] = $params['tid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['product_id'] = $params['tid'];
		if (!(empty($params['goods_tag']))) 
		{
			$package['goods_tag'] = $params['goods_tag'];
		}
		$package['time_start'] = date('YmdHis', TIMESTAMP);
		$package['time_expire'] = date('YmdHis', TIMESTAMP + 3600);
		$package['notify_url'] = ((empty($params['notify_url']) ? $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php' : $params['notify_url']));
		$package['trade_type'] = 'NATIVE';
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
		if (is_error($response)) 
		{
			return $response;
		}
		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		if (strval($xml->return_code) == 'FAIL') 
		{
			return error(-1, strval($xml->return_msg));
		}
		if (strval($xml->result_code) == 'FAIL') 
		{
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}
		$result = json_decode(json_encode($xml), true);
		return $result;
	}
	public function wechat_native_child_build($params, $wechat, $type = 0) 
	{
		global $_W;
		if (!(empty($wechat['sub_appsecret']))) 
		{
			$wxuser = m('member')->wxuser($wechat['sub_appid'], $wechat['sub_appsecret']);
			$params['openid'] = $wxuser['openid'];
			return $this->wechat_child_build($params, $wechat, $type);
		}
		$package = array();
		$package['appid'] = $wechat['appid'];
		if (!(empty($wechat['sub_appid']))) 
		{
			$package['sub_appid'] = $wechat['sub_appid'];
		}
		$package['mch_id'] = $wechat['mch_id'];
		$package['sub_mch_id'] = $wechat['sub_mch_id'];
		$package['nonce_str'] = random(32);
		$package['body'] = $params['title'];
		$package['device_info'] = ((isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2'));
		$package['attach'] = ((isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid'])) . ':' . $type;
		$package['out_trade_no'] = $params['tid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['product_id'] = $params['tid'];
		if (!(empty($params['goods_tag']))) 
		{
			$package['goods_tag'] = $params['goods_tag'];
		}
		$package['time_start'] = date('YmdHis', TIMESTAMP);
		$package['time_expire'] = date('YmdHis', TIMESTAMP + 3600);
		$package['notify_url'] = ((empty($params['notify_url']) ? $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php' : $params['notify_url']));
		$package['trade_type'] = 'NATIVE';
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
		if (is_error($response)) 
		{
			return $response;
		}
		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		if (strval($xml->return_code) == 'FAIL') 
		{
			return error(-1, strval($xml->return_msg));
		}
		if (strval($xml->result_code) == 'FAIL') 
		{
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}
		$result = json_decode(json_encode($xml), true);
		return $result;
	}
	public function authCodeToOpenid($auth_code, $wechat) 
	{
		$package = array();
		$package['appid'] = $wechat['appid'];
		$package['mch_id'] = $wechat['mch_id'];
		$package['auth_code'] = $auth_code;
		$package['nonce_str'] = random(32);
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_post('https://api.mch.weixin.qq.com/tools/authcodetoopenid', $dat);
		if (is_error($response)) 
		{
			return $response;
		}
		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		if (strval($xml->return_code) == 'FAIL') 
		{
			return error(-1, strval($xml->return_msg));
		}
		if (strval($xml->result_code) == 'FAIL') 
		{
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}
		$result = json_decode(json_encode($xml), true);
		return $result;
	}
	public function sendredpack($params) 
	{
		global $_W;
		$payment = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_payment') . ' WHERE uniacid=:uniacid AND `type`=\'0\'', array(':uniacid' => $_W['uniacid']));
		if (empty($payment)) 
		{
			$payment = array();
			$setting = uni_setting($_W['uniacid'], array('payment'));
			if (!(is_array($setting['payment']))) 
			{
				return error(1, '没有设定支付参数');
			}
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$wechat = $setting['payment']['wechat'];
			$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
			$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
			$payment['sub_appid'] = $row['key'];
			$payment['sub_mch_id'] = $wechat['mchid'];
			$payment['apikey'] = $wechat['apikey'];
			$certs = $sec;
		}
		else 
		{
			$certs = array('cert' => $payment['cert_file'], 'key' => $payment['key_file'], 'root' => $payment['root_file']);
		}
		$package = array();
		$package['wxappid'] = $payment['sub_appid'];
		$package['mch_id'] = $payment['sub_mch_id'];
		$package['mch_billno'] = $params['tid'];
		$package['send_name'] = $params['send_name'];
		$package['nonce_str'] = random(32);
		$package['re_openid'] = $params['openid'];
		$package['total_amount'] = $params['money'] * 100;
		$package['total_num'] = 1;
		$package['wishing'] = ((isset($params['wishing']) ? $params['wishing'] : '恭喜发财,大吉大利'));
		$package['client_ip'] = CLIENT_IP;
		$package['act_name'] = $params['act_name'];
		$package['remark'] = ((isset($params['remark']) ? $params['remark'] : '暂无备注'));
		$package['scene_id'] = ((isset($params['scene_id']) ? $params['scene_id'] : 'PRODUCT_1'));
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $k => $v ) 
		{
			$string1 .= $k . '=' . $v . '&';
		}
		$string1 .= 'key=' . $payment['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$xml = array2xml($package);
		$extras = array();
		$errmsg = '未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!';
		if (is_array($certs)) 
		{
			if (empty($certs['cert']) || empty($certs['key']) || empty($certs['root'])) 
			{
				if ($_W['ispost']) 
				{
					show_json(0, array('message' => $errmsg));
				}
				show_message($errmsg, '', 'error');
			}
			$certfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(128);
			file_put_contents($certfile, $certs['cert']);
			$keyfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(128);
			file_put_contents($keyfile, $certs['key']);
			$rootfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(128);
			file_put_contents($rootfile, $certs['root']);
			$extras['CURLOPT_SSLCERT'] = $certfile;
			$extras['CURLOPT_SSLKEY'] = $keyfile;
			$extras['CURLOPT_CAINFO'] = $rootfile;
		}
		else 
		{
			if ($_W['ispost']) 
			{
				show_json(0, array('message' => $errmsg));
			}
			show_message($errmsg, '', 'error');
		}
		load()->func('communication');
		$resp = ihttp_request($url, $xml, $extras);
		@unlink($certfile);
		@unlink($keyfile);
		@unlink($rootfile);
		if (is_error($resp)) 
		{
			return error(-2, $resp['message']);
		}
		if (empty($resp['content'])) 
		{
			return error(-2, '网络错误');
		}
		$arr = json_decode(json_encode(simplexml_load_string($resp['content'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		if (($arr['return_code'] == 'SUCCESS') && ($arr['result_code'] == 'SUCCESS')) 
		{
			return true;
		}
		if ($arr['return_msg'] == $arr['err_code_des']) 
		{
			$error = $arr['return_msg'];
		}
		else 
		{
			$error = $arr['return_msg'] . ' | ' . $arr['err_code_des'];
		}
		return error(-2, $error);
	}
	public function wechat_micropay_build($params, $wechat, $type = 0) 
	{
		global $_W;
		if (empty($params['old'])) 
		{
			list(, $payment) = $this->public_build();
			if (is_error($payment)) 
			{
				return $payment;
			}
			$wechat = array();
			if ($payment['is_new'] == 1) 
			{
				if (empty($payment['type']) || ($payment['type'] == 2)) 
				{
					$wechat['appid'] = $payment['sub_appid'];
					$wechat['mch_id'] = $payment['sub_mch_id'];
					$wechat['apikey'] = $payment['apikey'];
				}
				else 
				{
					if (($payment['type'] == 1) || ($payment['type'] == 3)) 
					{
						$wechat = $payment;
					}
					else if ($payment['type'] == 4) 
					{
						$params = array('service' => 'unified.trade.micropay', 'body' => $params['title'], 'out_trade_no' => $params['tid'], 'total_fee' => $params['fee'], 'auth_code' => $params['auth_code']);
						$payRes = m('pay')->build($params, $payment, $type);
						if (is_error($payRes)) 
						{
							return $payRes;
						}
						return $payRes;
					}
				}
			}
		}
		load()->func('communication');
		$package = array();
		$package['appid'] = $wechat['appid'];
		$package['mch_id'] = $wechat['mch_id'];
		$package['nonce_str'] = random(32);
		$package['body'] = $params['title'];
		$package['device_info'] = ((isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2'));
		$package['attach'] = ((isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid'])) . ':' . $type;
		$package['out_trade_no'] = $params['tid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['auth_code'] = $params['auth_code'];
		if (!(empty($wechat['sub_mch_id']))) 
		{
			$package['sub_mch_id'] = $wechat['sub_mch_id'];
		}
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/micropay', $dat);
		if (is_error($response)) 
		{
			return $response;
		}
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		libxml_disable_entity_loader(true);
		$result = json_decode(json_encode($xml), true);
		if ($result['return_code'] == 'FAIL') 
		{
			return error(-1, $result['return_msg']);
		}
		if ($result['result_code'] == 'FAIL') 
		{
			return error(-2, $result['err_code'] . ': ' . $result['err_code_des']);
		}
		return $result;
	}
	public function wechat_order_query($out_trade_no, $money = 0, $wechat) 
	{
		$package = array();
		$package['appid'] = $wechat['appid'];
		$package['mch_id'] = $wechat['mch_id'];
		$package['nonce_str'] = random(32);
		$package['out_trade_no'] = $out_trade_no;
		if (!(empty($wechat['sub_mch_id']))) 
		{
			$package['sub_mch_id'] = $wechat['sub_mch_id'];
		}
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/orderquery', $dat);
		if (is_error($response)) 
		{
			return $response;
		}
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		if (strval($xml->return_code) == 'FAIL') 
		{
			return error(-1, strval($xml->return_msg));
		}
		if (strval($xml->result_code) == 'FAIL') 
		{
			return error(-2, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}
		libxml_disable_entity_loader(true);
		$result = json_decode(json_encode($xml), true);
		if (($result['total_fee'] != $money * 100) && ($money != 0)) 
		{
			return error(-1, '金额出错');
		}
		return $result;
	}
	public function getAccount() 
	{
		global $_W;
		load()->model('account');
		if (!(empty($_W['acid']))) 
		{
			return WeAccount::create($_W['acid']);
		}
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		return WeAccount::create($acid);
	}
	public function createNO($table, $field, $prefix) 
	{
		$billno = date('YmdHis') . random(6, true);
		while (1) 
		{
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_' . $table) . ' where ' . $field . '=:billno limit 1', array(':billno' => $billno));
			if ($count <= 0) 
			{
				break;
			}
			$billno = date('YmdHis') . random(6, true);
		}
		return $prefix . $billno;
	}
	public function html_images($detail = '', $enforceQiniu = false) 
	{
		$detail = htmlspecialchars_decode($detail);
		preg_match_all('/<img.*?src=[\\\\\'| \\"](.*?(?:[\\.gif|\\.jpg|\\.png|\\.jpeg]?))[\\\\\'|\\"].*?[\\/]?>/', $detail, $imgs);
		$images = array();
		if (isset($imgs[1])) 
		{
			foreach ($imgs[1] as $img ) 
			{
				$im = array('old' => $img, 'new' => save_media($img, $enforceQiniu));
				$images[] = $im;
			}
		}
		foreach ($images as $img ) 
		{
			$detail = str_replace($img['old'], $img['new'], $detail);
		}
		return $detail;
	}
	public function html_to_images($detail = '') 
	{
		$detail = htmlspecialchars_decode($detail);
		preg_match_all('/<img.*?src=[\\\\\'| \\"](.*?(?:[\\.gif|\\.jpg|\\.png|\\.jpeg]?))[\\\\\'|\\"].*?[\\/]?>/', $detail, $imgs);
		$images = array();
		if (isset($imgs[1])) 
		{
			foreach ($imgs[1] as $img ) 
			{
				$im = array('old' => $img, 'new' => tomedia($img));
				$images[] = $im;
			}
		}
		foreach ($images as $img ) 
		{
			$detail = str_replace($img['old'], $img['new'], $detail);
		}
		return $detail;
	}
	public function array_images($arr) 
	{
		foreach ($arr as &$a ) 
		{
			$a = save_media($a);
		}
		unset($a);
		return $arr;
	}
	public function getSec($uniacid = 0) 
	{
		global $_W;
		if (empty($uniacid)) 
		{
			$uniacid = $_W['uniacid'];
		}
		$set = pdo_fetch('select sec from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		if (empty($set)) 
		{
			$set = array();
		}
		return $set;
	}
	public function paylog($log = '') 
	{
		global $_W;
		$openpaylog = m('cache')->getString('paylog', 'global');
		if (!(empty($openpaylog))) 
		{
			$path = IA_ROOT . '/addons/ewei_shopv2/data/paylog/' . $_W['uniacid'] . '/' . date('Ymd');
			if (!(is_dir($path))) 
			{
				load()->func('file');
				@mkdirs($path, '0777');
			}
			$file = $path . '/' . date('H') . '.log';
			file_put_contents($file, $log, FILE_APPEND);
		}
	}
	public function getAreas() 
	{
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		if (!(empty($new_area))) 
		{
			$file = IA_ROOT . '/addons/ewei_shopv2/static/js/dist/area/AreaNew.xml';
		}
		else 
		{
			$file = IA_ROOT . '/addons/ewei_shopv2/static/js/dist/area/Area.xml';
		}
		$file_str = file_get_contents($file);
		$areas = json_decode(json_encode(simplexml_load_string($file_str)), true);
		if (!(empty($new_area)) && !(empty($areas['province']))) 
		{
			foreach ($areas['province'] as $k => &$row ) 
			{
				if (0 < $k) 
				{
					if (empty($row['city'][0])) 
					{
						$row['city'][0]['@attributes'] = $row['city']['@attributes'];
						$row['city'][0]['county'] = $row['city']['county'];
						unset($row['city']['@attributes']);
						unset($row['city']['county']);
					}
				}
				else 
				{
					unset($areas['province'][0]);
				}
				foreach ($row['city'] as $k1 => $v1 ) 
				{
					if (empty($v1['county'][0])) 
					{
						$row['city'][$k1]['county'][0]['@attributes'] = $v1['county']['@attributes'];
						unset($row['city'][$k1]['county']['@attributes']);
					}
				}
			}
			unset($row);
		}
		return $areas;
	}
	public function getWechats() 
	{
		return pdo_fetchall('SELECT  a.uniacid,a.name FROM ' . tablename('ewei_shop_sysset') . ' s  ' . ' left join ' . tablename('account_wechats') . ' a on a.uniacid = s.uniacid' . ' left join ' . tablename('account') . ' acc on acc.uniacid = a.uniacid where acc.isdeleted=0 GROUP BY uniacid');
	}
	public function getCopyright($ismanage = false) 
	{
		global $_W;
		$copyrights = m('cache')->getArray('systemcopyright', 'global');
		if (!(is_array($copyrights))) 
		{
			$copyrights = pdo_fetchall('select *  from ' . tablename('ewei_shop_system_copyright'));
			m('cache')->set('systemcopyright', $copyrights, 'global');
		}
		$copyright = false;
		foreach ($copyrights as $cr ) 
		{
			if ($cr['uniacid'] == $_W['uniacid']) 
			{
				if ($ismanage && ($cr['ismanage'] == 1)) 
				{
					$copyright = $cr;
					break;
				}
				if (!($ismanage) && ($cr['ismanage'] == 0)) 
				{
					$copyright = $cr;
					break;
				}
			}
		}
		if (!($copyright)) 
		{
			foreach ($copyrights as $cr ) 
			{
				if ($cr['uniacid'] == -1) 
				{
					if ($ismanage && ($cr['ismanage'] == 1)) 
					{
						$copyright = $cr;
						break;
					}
					if (!($ismanage) && ($cr['ismanage'] == 0)) 
					{
						$copyright = $cr;
						break;
					}
				}
			}
		}
		return $copyright;
	}
	public function keyExist($key = '') 
	{
		global $_W;
		if (empty($key)) 
		{
			return;
		}
		$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid limit 1 ', array(':content' => trim($key), ':uniacid' => $_W['uniacid']));
		if (!(empty($keyword))) 
		{
			$rule = pdo_fetch('SELECT * FROM ' . tablename('rule') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $keyword['rid'], ':uniacid' => $_W['uniacid']));
			if (!(empty($rule))) 
			{
				return $rule;
			}
		}
	}
	public function createStaticFile($url, $regen = false) 
	{
		global $_W;
		if (empty($url)) 
		{
			return;
		}
		$url = preg_replace('/(&|\\?)mid=[^&]+/', '', $url);
		$cache = md5($url) . '_html';
		$content = m('cache')->getString($cache);
		if (empty($content) || $regen) 
		{
			load()->func('communication');
			$resp = ihttp_request($url, array('site' => 'createStaticFile'));
			$content = $resp['content'];
			m('cache')->set($cache, $content);
		}
		return $content;
	}
	public function delrule($rids) 
	{
		if (!(is_array($rids))) 
		{
			$rids = array($rids);
		}
		foreach ($rids as $rid ) 
		{
			$rid = intval($rid);
			load()->model('reply');
			$reply = reply_single($rid);
			if (pdo_delete('rule', array('id' => $rid))) 
			{
				pdo_delete('rule_keyword', array('rid' => $rid));
				pdo_delete('stat_rule', array('rid' => $rid));
				pdo_delete('stat_keyword', array('rid' => $rid));
				$module = WeUtility::createModule($reply['module']);
				if (method_exists($module, 'ruleDeleted')) 
				{
					$module->ruleDeleted($rid);
				}
			}
		}
	}
	public function deleteFile($attachment, $fileDelete = false) 
	{
		global $_W;
		$attachment = trim($attachment);
		if (empty($attachment)) 
		{
			return false;
		}
		$media = pdo_get('core_attachment', array('uniacid' => $_W['uniacid'], 'attachment' => $attachment));
		if (empty($media)) 
		{
			return false;
		}
		if (empty($_W['isfounder']) && ($_W['role'] != 'manager')) 
		{
			return false;
		}
		if ($fileDelete) 
		{
			load()->func('file');
			if (!(empty($_W['setting']['remote']['type']))) 
			{
				$status = file_remote_delete($media['attachment']);
			}
			else 
			{
				$status = file_delete($media['attachment']);
			}
			if (is_error($status)) 
			{
				exit($status['message']);
			}
		}
		pdo_delete('core_attachment', array('uniacid' => $_W['uniacid'], 'id' => $media['id']));
		return true;
	}
}
?>