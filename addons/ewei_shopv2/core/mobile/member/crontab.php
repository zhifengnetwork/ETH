<?php
class Crontab_EweiShopV2Page
{
	// protected $member;
	// public function __construct()
	// {
	// 	global $_W;
	// 	global $_GPC;
	// 	parent::__construct();
	// 	$this->member = m('member')->getInfo($_W['openid']);
	// }

	//订单倒计时
	public function main(){

		$data = date('Y-m-d H:i:s',time());
		$guamai = pdo_fetchall("select * from".tablename("guamai")." where status=1");
		if(empty($guamai)){
			return false;
		}
		foreach($guamai as $key=>$val){
			$createtime = $val['apple_time'];
			$time = time();
			if($time<=$createtime){
				continue;
			}
			$openid = $val['openid'];
			$openid2 = $val['openid2'];
			$users = pdo_fetch("select id,openid,credit2 from".tablename("ewei_shop_member")." where openid='".$openid."'");
			$users2 = pdo_fetch("select id,openid,credit2 from".tablename("ewei_shop_member")." where openid='".$openid2."'");
			if(empty($users)){
				continue;
			}
			$appeal_money = $val['trx'];
			if($val['type'] == 1){
				$appeal_money = $val['trx2'];
			}else if($val['type']==0){
				$appeal_money2 = $val['trx'];
			}
			$users['credit2'] = $users['credit2'] + $appeal_money;
			$users2['credit2'] = $users2['credit2'] + $appeal_money2;
			$updeta_order = pdo_update("guamai",array("status"=>3),array("openid"=>$val['openid'],"id"=>$val['id']));
			if($updeta_order){
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
