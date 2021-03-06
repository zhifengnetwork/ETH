<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}
class Mywallet_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		$this->diypage('member');

		$member = m('member')->getMember($_W['openid'], true);

		include $this->template();
	}

	public function zhuangzhang()
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid'], true);
		$ass = pdo_fetch("select zhuanzhangsxf from " . tablename("ewei_shop_sysset") . " where uniacid=:uniacid ", array(':uniacid' => $_W['uniacid']));
		// var_dump($ass);
		include $this->template();
	}

	public function openid()
	{

		global $_W;
		global $_GPC;

		$id = $_GPC['id'];

		if (!$id) {
			show_json(0, "请输入转账人的id");
		}

		$member = pdo_fetch("select * from " . tablename("ewei_shop_member") . "where uniacid=" . $_W['uniacid'] . " and id='$id'");

		if (!$member) {
			show_json(0, "该会员不存在");
		} else if ($_W['openid'] == $member['openid']) {
			show_json(0, "转账收款人不能是自己");
		}
		show_json(1);
	}

	public function zhuangzhangis()
	{
		global $_W;
		global $_GPC;

		$money = $_GPC['money'];
		$moneysxf = $_GPC['moneysxf'];
		$moneys = $money-$moneysxf;
		$mid = $_GPC['id'];

		$member = m('member')->getMember($_W['openid'], true);
		$member2 = pdo_fetch("select * from " . tablename("ewei_shop_member") . "where uniacid=" . $_W['uniacid'] . " and id='$mid'");

		if (!$money) show_json(0, "请输入转账金额");
		if (!$mid) show_json(0, "请输入转账人id");
		if ($member['credit2'] < $money) show_json(0, "您输入的转账金额过大，账户余额不足");
		// show_json($mid);
		if ($member2['openid'] == $_W['openid']) show_json(0, "不能对自己进行转账");

		$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'openid2' => $member2['openid'], 'money' => $money, 'money2' => $moneysxf, 'createtime' => time());

		//添加转账记录
		$log = pdo_insert("ewei_zhuanzhang", $data);
		if($log)
		{
			//向对方账户打钱
			m('member')->setCredit($member2['openid'], 'credit2', $moneys,"转账增加ETH");
			//自己扣钱
			m('member')->setCredit($member['openid'], 'credit2', -$money,"转账减少ETH");
		}
		show_json(1, "转账成功");
	}

	public function futou()
	{
		global $_W;
		global $_GPC;

		$type = $_GPC['type'];

		$member = m('member')->getMember($_W['openid'], true);

		include $this->template();
	}

	public function yijianfutou()
	{
		global $_W;
		global $_GPC;
		$money = $_GPC['money'];

		$type = $_GPC['type'];

		if (empty($money)) show_json(0, "复投金额不能为0");

		$member = m('member')->getMember($_W['openid'], true);
		
		if($member['suoding']==1){
			if ($money != $member['credit1']) {
				show_json(-1, "激活复投账户必须等于'" . $member['credit1'] . "'/ETH");
			}
		}
		

		$sys = pdo_fetch("select *from " . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		if($member['suoding'] == 0){
			if (($member['credit1'] + $money) > $sys['bibi']) show_json(0, "您的投资已超过上限");
		}

		$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'type' => 2, 'money' => $money, 'credit' => $money, 'createtime' => time(), 'section' => $ass['id']);

		// show_json($data);
		if ($type == 2) {  //自由账户一键复投

			if ($money > $member['credit2']) show_json(0, "您自由账户余额不足");

			$data['status'] = 1;
			$data['payment'] = 1;
			$data['title'] = "自由账户一键复投";
			$data['front_money'] = $member['credit2'];
			$data['after_money'] = $member['credit2'] - $money;
			m('member')->setCredit($_W['openid'], 'credit2', -$money,"自由账户一键复投");
		} else if ($type == 4) {

			if ($money > $member['credit4']) show_json(0, "您复投账户余额不足");

			$data['status'] = 1;
			$data['payment'] = 2;
			$data['title'] = "复投账户一键复投";
			$data['front_money'] = $member['credit4'];
			$data['after_money'] = $member['credit4'] - $money;


			m('member')->setCredit($_W['openid'], 'credit4', -$money,"复投账户一键复投");
		}
		
		if($member['suoding']==1){
			// "credit1=$money,suoding=0 "
			// $level = m('member')->level12($_W['openid'],$money);
			$levels2 = pdo_fetch("select *  from " . tablename("ewei_shop_commission_level2") . "where uniacid=:uniacid and start<=:credit1 and end>=:credit1 ", array(':uniacid' => $_W['uniacid'], ':credit1' => $money));
			pdo_update("ewei_shop_member",array('credit1'=>$money,'suoding'=>0,'agentlevel'=>$levels2['id']), array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));
			pdo_delete("ewei_shop_receive_hongbao", array('openid' => $_W['openid']));
			pdo_delete("ewei_shop_member_log", array('openid' => $_W['openid']));
			pdo_delete("ewei_zhuanzhang", array('openid' => $_W['openid']));
			pdo_delete("ewei_shop_order_goods1", array('openid' => $_W['openid']));
		}else{
			$level = m('member')->level12($_W['openid'],$money);
			//向投资余额打款
			m('member')->setCredit($_W['openid'], 'credit1', $money,"自由账户一键复投");

		}
		
		if ($member['type'] == 0) {
			pdo_update("ewei_shop_member", " type='1' ", array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));
		}
		//投资人直推上级信息
		$member1 = pdo_fetch("select * from".tablename("ewei_shop_member")."where id='".$member['agentid']."'");
		$type = pdo_fetch("select * from".tablename("ewei_shop_commission_level")."where id='".$member1['agentlevel']."'");
		
		$result = pdo_insert("ewei_shop_member_log", $data);
		if (!empty($result)) {
			$uid = pdo_insertid();
			$apply = pdo_fetch('SELECT openid,money,credit FROM '.tablename('ewei_shop_member_log').' WHERE uniacid=:uniacid AND id=:id',[':id' => $uid,':uniacid' => $_W['uniacid']]);
			if($member1['type'] == 1){
				// //到达投资等级倍数自动退出出局
				// $out_user_money = m('common')->out_user_money($apply['openid']);
				// if ($out_user_money) {
				// 	$data = array('orderid'=>0,'price'=>0,'openid'=>'您的收益已经超过投资倍数。暂停收益','openid2'=>$member['agentid'],'money'=>0,'jifen'=>0,'status'=>$type,'createtime'=>time(),'type'=>'9','uniacid'=>$_W['uniacid']);
				// 	pdo_insert("ewei_shop_order_goods1",$data);
				// }
				//直推奖金
				m('common')->commission_dakuan($member1,$type['type'],$uid,$apply['openid']);
				//动态奖金
				// m('common')->comm($apply['openid'],$apply['money']);
				//领导奖奖金
				// m('common')->leader($apply['openid'],$apply['money']);
				m('common')->leader($apply['openid'],$money);
				
			}
		}
		if ($result) show_json(1, "一键复投成功");
	}

	//倒计时
	public function timer()
	{
		include $this->template();
	}

	public function timers()
	{
		global $_W;
		global $_GPC;
		pdo_insert("timer", array('openid' => $_W['openid'], 'createtime' => time(), 'type' => '1'));
		echo json_encode(array('openid' => $_W['openid'], 'time' => time()));
	}

	public function timeris()
	{
		global $_W;
		global $_GPC;
		$list = pdo_update("timer", " type='123' ", array('openid' => $_GPC['openid']));
		echo json_encode(array('list' => $list));
	}
}
