<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class ReturnMobile extends Plugin
{
    protected $set = null;
    public function __construct()
    {
        parent::__construct('return');
        $this->set = $this->getSet();
        global $_GPC;
    }
    

  /*   public function api(){


            global $_W;
            $_var_0 = $this->getSet();

            //返利队列
            $data_money = pdo_fetchall("select * from " . tablename('sz_yi_return') . " where uniacid = '". $_W['uniacid'] ."' and status = 0 and returnrule = '".$_var_0['returnrule']."'");

            foreach ($data_money as $key => $value) {
                $r_each = $value['money'] * $_var_0['percentage'] / 100;//可返利金额
                
                $member = pdo_fetch("select * from " . tablename('sz_yi_member') . " where uniacid = '". $_W['uniacid'] ."' and id = '".$value['mid']."'");

                if(($value['money']-$value['return_money']) < $r_each){
                    pdo_update('sz_yi_return', array('return_money'=>$value['money'],'status'=>'1'), array('id' => $value['id'], 'uniacid' => $_W['uniacid']));
                    m('member')->setCredit($member['openid'],'credit2',$value['money']-$value['return_money']);

                    $messages = array(
                        'keyword1' => array('value' => '返现通知', 
                            'color' => '#73a68d'),
                            'keyword2' => array('value' => '本次返现金额'.$value['money']-$value['return_money']."元！",
                                            'color' => '#73a68d'
                             ),
                            'keyword3' => array('value' => '此返单已经全部返现完成！',
                                            'color' => '#73a68d'
                             )
                        );
                    m('message')->sendCustomNotice($member['openid'], $messages);

                }else
                {
                    pdo_update('sz_yi_return', array('return_money'=>$value['return_money']+$r_each), array('id' => $value['id'], 'uniacid' => $_W['uniacid']));
                    m('member')->setCredit($member['openid'],'credit2',$r_each);

                    $surplus = $value['money']-$value['return_money']-$r_each;
                    $messages = array(
                        'keyword1' => array(
                            'value' => '返现通知',
                            'color' => '#73a68d'),
                        'keyword2' =>array(
                            'value' => '本次返现金额'.$r_each,
                            'color' => '#73a68d'),
                        'keyword3' => array(
                            'value' => "此返单剩余返现金额".$surplus,
                            'color' => '#73a68d')
                        );
                    m('message')->sendCustomNotice($member['openid'], $messages);
                }
            }


    } */
	
	
    public function api(){
            
			ini_set('memory_limit','128M');
			 set_time_limit(0);

            global $_W;
			
			$set = $this->getSet();
			$returntime = $set['returntime'];//按时间来算
			
			//$return = pdo_fetchall("select id,return_money,uid,mid,openid from " . tablename('sz_yi_return'). " where uniacid=:uniacid  order by id asc" , array(':uniacid' =>$_W['uniacid']));
			
			$return = pdo_fetchall("SELECT r.id,r.return_money,r.uid,r.mid,r.openid  from " . tablename('sz_yi_return') . " r left join " . tablename('sz_yi_order_goods_queue') . " q  on q.id = r.uid left join " . tablename("sz_yi_order") . " o  on o.id = q.orderid  where  o.status = 3 and q.uniacid = :uniacid and o.uniacid = :uniacid and r.uniacid = :uniacid ",array( ':uniacid' => $_W['uniacid']));
			
		
			/* if($set['returnlaw']==1){} */// 按天返
				
					foreach($return as $val){
					$return_money = $val['return_money'] * $set['percentage']/100;
					$spare  =      $val['return_money'] - $return_money;
					
					$member = m('member') ->getMember($val['openid']);
					$credit2 = $member['credit2'];
					$addmoney = $me_credit2 + $credit2;
						$data = array(
							'uniacid' => $_W['uniacid'],
							'mid' => $val['mid'],
							'money' => $return_money,
							'createtime' => time(),
							 'rid' => $val['id'], 
						);
						
						$return_money = pdo_fetch('select createtime from ' . tablename('sz_yi_return_money') . " where uniacid=:uniacid  and mid=:mid order by id desc limit 1" ,array(':uniacid' =>$_W['uniacid'],':mid' =>$val['mid']));
						
						$day = date('Ymd',time());
						
						$return_day = date('Ymd',$return_money['createtime']);
					
						  if($day != $return_day){
						 
								  if(empty($member['uid'])){
										//member表
											if($spare !=0){
												pdo_insert('sz_yi_return_money',$data);
												pdo_update('sz_yi_member',array('credit2' => $addmoney),array('uniacid' => $_W['uniacid'],'openid' => $val['openid']));
												pdo_update('sz_yi_return',array('return_money' => $spare),array('uniacid' => $_W['uniacid'],'openid' => $val['openid']));
											
											}else{
												pdo_insert('sz_yi_return_money',$data);
												pdo_update('sz_yi_member',array('credit2' => $addmoney),array('uniacid' => $_W['uniacid'],'openid' => $val['openid']));
												pdo_update('sz_yi_return',array('return_money' => $spare,'status' =>1),array('uniacid' => $_W['uniacid'],'openid' => $val['openid']));
												pdo_update('sz_yi_order_goods_queue',array('status' =>1),array('uniacid' => $_W['uniacid'],'openid' => $val['openid'],'id' => $val['uid']));
											}
										
								}else{
										//mc用户表
										if($spare !=0){
											pdo_insert('sz_yi_return_money',$data);
											pdo_update('mc_members',array('credit2' => $addmoney),array('uniacid' => $_W['uniacid'],'openid' => $val['openid']));
											pdo_update('sz_yi_return',array('return_money' => $spare),array('uniacid' => $_W['uniacid'],'openid' => $val['openid']));
										}else{
											pdo_insert('sz_yi_return_money',$data);
											pdo_update('mc_members',array('credit2' => $addmoney),array('uniacid' => $_W['uniacid'],'openid' => $val['openid']));
											pdo_update('sz_yi_return',array('return_money' => $spare,'status' =>1),array('uniacid' => $_W['uniacid'],'openid' => $val['openid']));
											pdo_update('sz_yi_order_goods_queue',array('status' =>1),array('uniacid' => $_W['uniacid'],'openid' => $val['openid'],'id' => $val['uid']));
										}
								
								
								} 
						
						  } 
					}




    }



    public function task()
    {    
        $this->_exec_plugin(__FUNCTION__, false);
    }
    public function return_log()
    {    
        $this->_exec_plugin(__FUNCTION__, false);
    } 

}