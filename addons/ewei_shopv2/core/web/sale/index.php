<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}
class Index_EweiShopV2Page extends ComWebPage
{
	public function __construct()
	{
		parent::__construct('sale');
	}
	public function main()
	{
		if (cv('sale.enough')) {
			header('location: ' . webUrl('sale/enough'));
		} else if (cv('sale.enoughfree')) {
			header('location: ' . webUrl('sale/enoughfree'));
		} else if (cv('sale.deduct')) {
			header('location: ' . webUrl('sale/deduct'));
		} else if (cv('sale.recharge')) {
			header('location: ' . webUrl('sale/recharge'));
		} else if (cv('sale.coupon')) {
			header('location: ' . webUrl('sale/coupon'));
		} else {
			header('location: ' . webUrl());
		}
	}
	public function deduct()
	{
		global $_W;
		global $_GPC;
		if (!(function_exists('redis')) || is_error(redis())) {
			$this->message('请联系系统管理员设置 Redis 才能使用抵扣!', '', 'error');
		}
		if ($_W['ispost']) {
			$post = ((is_array($_GPC['data']) ? $_GPC['data'] : array()));
			$data['creditdeduct'] = intval($post['creditdeduct']);
			$data['credit'] = 1;
			$data['moneydeduct'] = intval($post['moneydeduct']);
			$data['money'] = round(floatval($post['money']), 2);
			$data['dispatchnodeduct'] = intval($post['dispatchnodeduct']);
			plog('sale.deduct', '修改抵扣设置');
			m('common')->updatePluginset(array('sale' => $data));
			show_json(1);
		}
		$data = m('common')->getPluginset('sale');
		load()->func('tpl');
		include $this->template('sale/index');
	}
	//TRX资产
	public function appeal()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$select = 'SELECT og.*,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				,m2.id as m2id,m2.realname as m2realname,m2.mobile as m2mobile,m2.nickname as m2nickname,m2.avatar as m2avatar,g.trx,g.money,g.status FROM ';
		$tablename = 	tablename('guamai_appeal') . ' og left join ' . tablename('ewei_shop_member') . ' m ON m.openid=og.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=og.openid2 left join ' . tablename('guamai') . ' g ON g.id=og.order_id';
		$where = ' where og.id>0';

		if (!empty($_GPC['status'])) {
			$where .= ' AND og.status=:status';
			$params[':status'] = $_GPC['status'];
		}
		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'logno') {
			$where .= ' AND o.ordersn=:ordersn';
			$params[':ordersn'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'member') {
			$where .= ' AND (m.id=:info OR m.realname =:info OR m.mobile=:info OR m.nickname=:info OR m2.id=:info OR m2.realname =:info OR m2.mobile=:info OR m2.nickname=:info)';
			$params[':info'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$time = $_GPC['time'];
			$params[':start'] = strtotime($time['start']);
			$params[':end'] = strtotime($time['end']);
			$where .= ' AND og.createtime BETWEEN :start AND :end ';
		}

		$where .= ' ORDER BY og.id DESC ';
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$params[':uniacid'] = $_W['uniacid'];

		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		dump($list);die;
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM ' . $tablename . $where, $params);
		$total = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	//申诉操作guamai_appeal表
	public function appeal_list()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if (!empty($_GPC['id'])) {
			$guamai_appeal = pdo_fetch('select * from ' . tablename('guamai_appeal') . "where id= " . $_GPC['id']);
			$guamai_appeal['files'] = json_decode($guamai_appeal['files']);
			$guamai = pdo_fetch('select * from ' . tablename('guamai') . "where id= " . $guamai_appeal['order_id']);
			
		}
		
		if ($_W['ispost']) {
			//type=1 卖出判断
			if($guamai_appeal['type']==1){
				$openid = substr($guamai_appeal['openid2'], -11);
				$name_list = pdo_fetch('select * from ' . tablename('ewei_shop_member') . "where mobile= " . $openid);
				$money = $name_list['credit2']+$guamai['trx2'];
				pdo_update("ewei_shop_member",array("credit2"=>$money),array("openid"=>$name_list['openid']));
			}
			//type=0 买入判断
			if($guamai_appeal['type']==0){
				$openid = substr($guamai_appeal['openid'], -11);
				$name_list = pdo_fetch('select * from ' . tablename('ewei_shop_member') . "where mobile= " . $openid);
				$money = $name_list['credit2']+$guamai['trx2'];
				pdo_update("ewei_shop_member",array("credit2"=>$money),array("openid"=>$name_list['openid']));
			}
			if ($_GPC['type'] == 1) {
				// $user_id = $guamai_appeal['appeal_name'];
				// $user = pdo_fetch('select id,openid,credit2 from '.tablename('ewei_shop_member')."where id= ".$user_id);
				$data = array('stuas' => 1);
			} else {
				$data = array('stuas' => 2);
			}
			// dump($guamai_appeal['id']);die;
			$appral_log = pdo_update("guamai_appeal", $data, array('id' => $id));
			if ($appral_log) {
				show_json(1, "申诉成功");
			} else {
				show_json(1, "申诉失败");
			}
		}
		include $this->template();
	}

	//TRX资产
	public function enough()
	{
		global $_W;
		global $_GPC;
		$sale = pdo_fetch("select trxprice,trxsxf from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		if ($_W['ispost']) {
			$data = array('trxprice' => $_GPC['trxprice'], 'trxsxf' => $_GPC['trxsxf']);
			$list = pdo_update("ewei_shop_sysset", $data, array('uniacid' => $_W['uniacid']));
			if ($list)
				show_json(1, "操作成功");
		}
		$areas = m('common')->getAreas();
		$data = m('common')->getPluginset('sale');
		load()->func('tpl');
		include $this->template();
	}

	//卖出记录
	public function sellout()
	{
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;

		$select = 'SELECT og.id,og.money,og.createtime,og.price,og.type,og.status,og.trx,og.trx2,og.file,og.endtime
				,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				,m2.id as m2id,m2.realname as m2realname,m2.mobile as m2mobile,m2.nickname as m2nickname,m2.avatar as m2avatar FROM ';
		$tablename = 	tablename('guamai') . ' og left join ' . tablename('ewei_shop_member') . ' m ON m.openid=og.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=og.openid2';
		$where = ' WHERE og.uniacid=:uniacid and og.type=1';
		if (!empty($_GPC['status'])) {
			$where .= ' AND og.status=:status';
			$params[':status'] = $_GPC['status'];
		}
		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'logno') {
			$where .= ' AND o.ordersn=:ordersn';
			$params[':ordersn'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'member') {
			$where .= ' AND (m.id=:info OR m.realname =:info OR m.mobile=:info OR m.nickname=:info OR m2.id=:info OR m2.realname =:info OR m2.mobile=:info OR m2.nickname=:info)';
			$params[':info'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$time = $_GPC['time'];
			$params[':start'] = strtotime($time['start']);
			$params[':end'] = strtotime($time['end']);
			$where .= ' AND og.createtime BETWEEN :start AND :end ';
		}
		$where .= ' ORDER BY og.id DESC ';
		$params[':uniacid'] = $_W['uniacid'];
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;



		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		// var_dump($list);exit();
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM ' . $tablename . $where, $params);
		$pager = pagination2($total, $pindex, $psize);


		include $this->template();
	}

	//卖入记录
	public function purchase()
	{
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;

		$select = 'SELECT og.id,og.money,og.createtime,og.price,og.type,og.status,og.trx,og.trx2,og.file,og.endtime
				,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				,m2.id as m2id,m2.realname as m2realname,m2.mobile as m2mobile,m2.nickname as m2nickname,m2.avatar as m2avatar FROM ';
		$tablename = 	tablename('guamai') . ' og left join ' . tablename('ewei_shop_member') . ' m ON m.openid=og.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=og.openid2';
		$where = ' WHERE og.uniacid=:uniacid and og.type=0';
		if (!empty($_GPC['status'])) {
			$where .= ' AND og.status=:status';
			$params[':status'] = $_GPC['status'];
		}
		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'logno') {
			$where .= ' AND o.ordersn=:ordersn';
			$params[':ordersn'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'member') {
			$where .= ' AND (m.id=:info OR m.realname =:info OR m.mobile=:info OR m.nickname=:info OR m2.id=:info OR m2.realname =:info OR m2.mobile=:info OR m2.nickname=:info)';
			$params[':info'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$time = $_GPC['time'];
			$params[':start'] = strtotime($time['start']);
			$params[':end'] = strtotime($time['end']);
			$where .= ' AND og.createtime BETWEEN :start AND :end ';
		}
		$where .= ' ORDER BY og.id DESC ';
		$params[':uniacid'] = $_W['uniacid'];
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;



		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		// var_dump($list);exit();
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM ' . $tablename . $where, $params);
		$pager = pagination2($total, $pindex, $psize);


		include $this->template();
	}

	//福彩3D设置
	public function lottery()
	{
		global $_W;
		global $_GPC;
		$sale = pdo_fetch("select * from" . tablename("ewei_shop_lottery2") . "where uniacid=" . $_W['uniacid']);
		$investment = unserialize($sale['investment']);

		if ($_W['ispost']) {
			$number = $_GPC['number'];
			if ($number) {
				if (is_numeric($number)) {
					if (strlen($number) != 3)  show_json(-1, "开奖号必须为3位数字");
				} else {
					show_json(-1, "开奖号必须为3位数字");
				}
			}


			//投资人获得彩票的额度
			$investment = serialize(array('investment1' => $_GPC['investment1'], 'investment2' => $_GPC['investment2'], 'investment3' => $_GPC['investment3'], 'investment4' => $_GPC['investment4'], 'investment5' => $_GPC['investment5'], 'investment6' => $_GPC['investment6'], 'investment7' => $_GPC['investment7'], 'investment8' => $_GPC['investment8'], 'investment9' => $_GPC['investment9'], 'investment10' => $_GPC['investment10']));
			// show_json($investment);
			$data = array('number' => $_GPC['number'], 'price' => $_GPC['price'], 'winner' => $_GPC['winner'], "investment" => $investment, 'time' => $_GPC['time']);
			if (!$sale) {
				$data['uniacid'] = $_W['uniacid'];
				$list = pdo_insert("ewei_shop_lottery2", $data);
			} else {
				$list = pdo_update("ewei_shop_lottery2", $data, array('uniacid' => $_W['uniacid']));
			}

			if ($list)
				show_json(1, "操作成功");
			else
				show_json(1, "操作成功未进行修改");
		}
		$areas = m('common')->getAreas();
		$data = m('common')->getPluginset('sale');
		load()->func('tpl');
		include $this->template();
	}

	public function lotteryis()
	{	//开奖

		global $_W;
		global $_GPC;

		if ($_W['ispost']) {

			if ($_GPC['type'] == 1) {

				// dump($_GPC);
				pdo_update("ewei_shop_lottery2", array('number' => $_GPC['number'], 'time' => $_GPC['time']), array('uniacid' => $_W['uniacid']));

				//查出中奖的人数
				$sale = pdo_fetch("select * from" . tablename("ewei_shop_lottery2") . "where uniacid=" . $_W['uniacid']);
				// dump($sale);die;
				if (!$sale['number'] && !$sale['sum'] && !$sale['winner'])  show_json(-1, "请完善开奖信息");
				// exit();

				$list = pdo_fetchall("select openid,sum(multiple) as multiple,group_concat(id SEPARATOR ',') as id from" . tablename("stakejilu") . "where uniacid=" . $_W['uniacid'] . " and thigh=0 and number=:number group by openid", array(':number' => $sale['number']));

				//查出中奖的总倍注
				$listsum = pdo_fetch("select sum(multiple) as multiple from" . tablename("stakejilu") . "where uniacid=" . $_W['uniacid'] . " and thigh=0 and number=:number", array(':number' => $sale['number']));

				//今日开始时间和结束时间戳
				$start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				$end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;

				//查出今日投资的前10名
				$investment = pdo_fetchall("select openid,sum(money) as money from " . tablename("stakejilu") . "where uniacid=" . $_W['uniacid'] . " and thigh=0 and createtime>'$start' and createtime<'$end' group by openid order by money desc limit 0,10");

				//给投注中奖的人打钱
				$danprice = round(($sale['sum'] * $sale['winner'] * 0.01) / $listsum['multiple'], 6);    //单注的中奖金额
				
				foreach ($list as $key => $val) {

					$data = array('uniacid' => $_W['uniacid'], 'openid' => $val['openid'], 'numberid' => $val['id'], 'stakesum' => $val['multiple'], 'money' => $val['multiple'] * $danprice, 'createtime' => time(), 'type' => 1, 'number' => $sale['number']);
					
					pdo_insert("winningrecord", $data);

					m('member')->setCredit($val['openid'], 'credit2', $val['multiple'] * $danprice);
				}

				//投资排名的中奖额度
				$touzi = unserialize($sale['investment']);

				$i = 1;
				foreach ($investment as $key => $val) {
					if ($touzi['investment' . $i]) {

						$data = array('uniacid' => $_W['uniacid'], 'openid' => $val['openid'], 'money' => $sale['sum'] * $touzi['investment' . $i] * 0.01, 'createtime' => time(), 'type' => 2, 'ranking' => $i);

						pdo_insert("winningrecord", $data);

						m('member')->setCredit($val['openid'], 'credit2', $sale['sum'] * $touzi['investment' . $i] * 0.01);
					}

					$i++;
				}

				//修改这次的所有的押注记录
				pdo_update("stakejilu", array('thigh' => 1, 'endtime' => time()), array('uniacid' => $_W['uniacid'], 'thigh' => 0));

				pdo_update("ewei_shop_lottery2", array('number' => '', 'sum' => 0, 'sums' => $sale['sum'], 'numberis' => $sale['number'], 'time' => ''), array('uniacid' => $_W['uniacid']));
				$array_data = array('number' => $sale['number'], 'time' => $sale['time'], 'datetime' => time());
				pdo_insert("ewei_shop_lottery2_log", $array_data);
				show_json(1, "开奖成功");
			}
		}
	}

	//一键包号
	function number($op)
	{

		$yes = array();

		foreach ($op as $key => $val) {

			$kn = "";
			$kn .= $val;

			foreach ($op as $key => $val2) {

				$kn .= $val2;

				foreach ($op as $key => $val3) {

					$kn .= $val3;
					$yes[] = $kn;
					$kn = substr($kn, 0, -1);
				}

				$kn = substr($kn, 0, -1);
			}
		}

		return $yes;
	}



	//押注记录
	public function stakejilu()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$select = 'SELECT og.id,og.money,og.createtime,og.number,og.thigh,og.multiple,og.endtime,og.lottery
				,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				 FROM ';
		$tablename = 	tablename('stakejilu') . ' og left join ' . tablename('ewei_shop_member') . ' m ON m.openid=og.openid ';
		$where = ' WHERE og.uniacid=:uniacid';
		if (!empty($_GPC['type'])) {
			if ($_GPC['type'] == '-1') $_GPC['type'] = 0;
			$where .= ' AND og.thigh=:type';
			$params[':type'] = $_GPC['type'];
		}

		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'member') {
			$where .= ' AND (m.id=:info OR m.realname =:info OR m.mobile=:info OR m.nickname=:info )';
			$params[':info'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$time = $_GPC['time'];
			$params[':start'] = strtotime($time['start']);
			$params[':end'] = strtotime($time['end']);
			$where .= ' AND og.createtime BETWEEN :start AND :end ';
		}
		$where .= ' ORDER BY og.id DESC ';
		$params[':uniacid'] = $_W['uniacid'];
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM ' . $tablename . $where, $params);
		$pager = pagination2($total, $pindex, $psize);

		include $this->template();
	}

	//中奖记录
	public function winningrecord()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$select = 'SELECT og.id,og.money,og.createtime,og.numberid,og.stakesum,og.type,og.ranking,og.number
				,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				 FROM ';
		$tablename = tablename('winningrecord') . ' og left join ' . tablename('ewei_shop_member') . ' m ON m.openid=og.openid ';
		$where = ' WHERE og.uniacid=:uniacid';
		if (!empty($_GPC['type'])) {
			$where .= ' AND og.type=:type';
			$params[':type'] = $_GPC['type'];
		}

		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'member') {
			$where .= ' AND (m.id=:info OR m.realname =:info OR m.mobile=:info OR m.nickname=:info )';
			$params[':info'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$time = $_GPC['time'];
			$params[':start'] = strtotime($time['start']);
			$params[':end'] = strtotime($time['end']);
			$where .= ' AND og.createtime BETWEEN :start AND :end ';
		}
		$where .= ' ORDER BY og.id DESC ';
		$params[':uniacid'] = $_W['uniacid'];
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM ' . $tablename . $where, $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function enoughfree()
	{
		global $_W;
		global $_GPC;
		if ($_W['ispost']) {
			$data = ((is_array($_GPC['data']) ? $_GPC['data'] : array()));
			$data['enoughfree'] = intval($data['enoughfree']);
			$data['enoughorder'] = round(floatval($data['enoughorder']), 2);
			$data['goodsids'] = $_GPC['goodsids'];
			plog('sale.enough', '修改满额包邮优惠');
			m('common')->updatePluginset(array('sale' => $data));
			show_json(1);
		}
		$data = m('common')->getPluginset('sale');
		if (!(empty($data['goodsids']))) {
			$goods = pdo_fetchall('SELECT id,uniacid,title,thumb FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid=:uniacid AND id IN (' . implode(',', $data['goodsids']) . ')', array(':uniacid' => $_W['uniacid']));
		}
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$areas = m('common')->getAreas();
		include $this->template();
	}
	public function recharge()
	{
		global $_W;
		global $_GPC;
		if ($_W['ispost']) {
			$recharges = array();
			$datas = ((is_array($_GPC['enough']) ? $_GPC['enough'] : array()));
			foreach ($datas as $key => $value) {
				$enough = trim($value);
				if (!(empty($enough))) {
					$recharges[] = array('enough' => trim($_GPC['enough'][$key]), 'give' => trim($_GPC['give'][$key]));
				}
			}
			$data['recharges'] = iserializer($recharges);
			m('common')->updatePluginset(array('sale' => $data));
			plog('sale.recharge', '修改充值优惠设置');
			show_json(1);
		}
		$data = m('common')->getPluginset('sale');
		$recharges = iunserializer($data['recharges']);
		include $this->template();
	}
	public function credit1()
	{
		global $_W;
		global $_GPC;
		if ($_W['ispost']) {
			$enough1 = array();
			$postenough1 = ((is_array($_GPC['enough1_1']) ? $_GPC['enough1_1'] : array()));
			foreach ($postenough1 as $key => $value) {
				$enough = floatval($value);
				if (0 < $enough) {
					$enough1[] = array('enough1_1' => floatval($_GPC['enough1_1'][$key]), 'enough1_2' => floatval($_GPC['enough1_2'][$key]), 'give1' => floatval($_GPC['give1'][$key]));
				}
			}
			$data['enough1'] = $enough1;
			$enough2 = array();
			$postenough2 = ((is_array($_GPC['enough2_1']) ? $_GPC['enough2_1'] : array()));
			foreach ($postenough2 as $key => $value) {
				$enough = floatval($value);
				if (0 < $enough) {
					$enough2[] = array('enough2_1' => floatval($_GPC['enough2_1'][$key]), 'enough2_2' => floatval($_GPC['enough2_2'][$key]), 'give2' => floatval($_GPC['give2'][$key]));
				}
			}
			if (!(empty($enough2))) {
				m('common')->updateSysset(array('trade' => array('credit' => 0)));
			}
			$data['enough1'] = $enough1;
			$data['enough2'] = $enough2;
			$data['paytype'] = ((is_array($_GPC['paytype']) ? $_GPC['paytype'] : array()));
			m('common')->updatePluginset(array('sale' => array('credit1' => iserializer($data))));
			plog('sale.credit1.edit', '修改基本积分活动配置');
			show_json(1, array('url' => webUrl('sale/credit1', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}
		$data = m('common')->getPluginset('sale');
		$credit1 = iunserializer($data['credit1']);
		$enough1 = ((empty($credit1['enough1']) ? array() : $credit1['enough1']));
		$enough2 = ((empty($credit1['enough2']) ? array() : $credit1['enough2']));
		include $this->template();
	}

	public function contract()
	{

		global $_W;
		global $_GPC;
		$data = pdo_fetch("select * from " . tablename("ewei_shop_lottery2") . "where id=1");
		if ($_W['ispost']) {


			$content = m('common')->html_images($_GPC['content']);
			pdo_update("ewei_shop_lottery2", array('contract' => $content), array('uniacid' => $_W['uniacid']));
			show_json(1);
		}

		include $this->template();
	}
}
