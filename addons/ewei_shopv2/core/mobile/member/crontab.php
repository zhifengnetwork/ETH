<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}
class Crontab_EweiShopV2Page extends MobileLoginPage
{
	protected $member;
	public function __construct()
	{
		global $_W;
		global $_GPC;
		parent::__construct();
		$this->member = m('member')->getInfo($_W['openid']);
	}
	//订单倒计时
	public function main()
	{
		$data = date('Y-m-d H:i:s',time());
		$guamai = pdo_fetchall("select * from".tablename("guamai")." where status=1 or status=0");
		if(empty($guamai)){
			return false;
		}
		foreach($guamai as $key=>$val){
			$createtime = $val['createtime']+1800;
			$time = time();
			if($time<=$createtime){
				continue;
			}
			dump($val);
			$openid = $val['openid'];
			$users = pdo_fetch("select id,openid,credit2 from".tablename("ewei_shop_member")." where openid='".$openid."'");
			if(empty($users)){
				continue;
			}
			$appeal_money = $val['trx'];
			if($val['type'] == 1){
				$appeal_money = $val['trx2'];
			}

			$users['credit2'] = $users['credit2'] + $appeal_money;
			$updeta_order = pdo_update("guamai",array("status"=>3),array("openid"=>$val['openid'],"id"=>$val['id']));
			if($updeta_order){
				$result = pdo_update("ewei_shop_member",array("credit2"=>$users['credit2']),array("openid"=>$val['openid']));

				echo('执行成功-----'.$data);
			}else{

				echo('执行失败-----'.$data);
				continue;
			}
		}
		echo('执行-----'.$data);
	}
}
?>
