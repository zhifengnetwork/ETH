<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Refund_EweiShopV2Page extends MobilePage
{
	public function main() 
	{
		global $_W;
		global $_GPC;

		$this->diypage('member');
		//当月第一天的日期
		$monthday = date('Y-m-01', strtotime(date("Y-m-d")));
		//今天的年月日
		$day= date("Y-m-d",time());
        
		//今日开始和结束的时间戳
		$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

        if($day == $monthday){   //退出机制的退还投资每月1号发放
            //获取会员等级为商家的用户
            $ass = pdo_fetchall("select openid,credit5,refund from ".tablename("ewei_shop_member")." where uniacid=:uniacid and type='2' and refund<5  ",array(':uniacid'=>$_W['uniacid']));
            // var_dump($ass);

            
            foreach ($ass as $key => $value) {
                //向退还投资日志表中查询该会员今日是否退还
                $arr = pdo_fetch("select * from ".tablename("refund")."where uniacid=:uniacid and openid=:openid and time>=$beginToday and time<=$endToday ",array(':uniacid'=>$_W['uniacid'],'openid'=>$value['openid']));
               
                if(!$arr){  //无日志的情况下给商家发放周业绩
                        // $data = array('openid'=>$value['openid'],'summoney'=>$value['monthyeji'],'money'=>$value['monthyeji']*$value['fenhong']*0.01,'status'=>'0','createtime'=>time(),'type'=>'3','uniacid'=>$_W['uniacid']);
                        $money = $value['credit5']*0.2;
                        //打款日志
                        $data2 = array('openid'=>$value['openid'],'summoney'=>$value['credit5'],'money'=>$value['credit5']*0.2,'time'=>time(),'uniacid'=>$_W['uniacid']);

                        //充值
                        m('member')->setCredit($value['openid'],'credit2',$value['credit5']*0.2);

                        pdo_update("ewei_shop_member",array('refund'=>$value['refund']+1),array('uniacid'=>$_W['uniacid'],'openid'=>$value['openid']));

                        //日志记录
                        pdo_insert("refund",$data2);
                }

            }
           
        }else{

            echo "投资退还时间为每月1号"."<br/>";
        }
		
	}
}
?>