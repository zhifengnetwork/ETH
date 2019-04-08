<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}
class Log_EweiShopV2Page extends WebPage
{
	protected function main($type = 0)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and log.uniacid=:uniacid and log.type=:type and log.money<>0';
		$condition1 = '';
		if ($type == 0) $type = 4;
		$params = array(':uniacid' => $_W['uniacid'], ':type' => $type);
		// echo $type;
		if (!(empty($_GPC['keyword']))) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			if ($_GPC['searchfield'] == 'logno') {
				$condition .= ' and (log.id like :keyword or log.logno like :keyword)';
			}
			if ($_GPC['status']) {
				$condition .= ' and log.status like :keyword ';
			} else if ($_GPC['searchfield'] == 'member') {
				$condition .= ' and (m.nickname like :keyword or m.mobile like :keyword)';
			}
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}
		if (!(empty($_GPC['time']['start'])) && !(empty($_GPC['time']['end']))) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}
		if (!(empty($_GPC['level']))) {
			$condition1 .= ' and level=' . intval($_GPC['level']);
		}
		if (!(empty($_GPC['groupid']))) {
			$condition1 .= ' and groupid=' . intval($_GPC['groupid']);
		}

		$sql = 'select log.url,log.id,log.add,log.url,log.credit,log.openid,log.logno,log.title,log.type,log.status,log.rechargetype,log.sendmoney,log.money,log.createtime,log.realmoney,log.deductionmoney,log.charge,log.remark,log.alipay,log.bankname,log.bankcard,log.realname as applyrealname,log.applytype,m.nickname,m.id as mid,m.avatar,m.level,m.groupid,m.realname,m.mobile,g.groupname,l.levelname from ' . tablename('ewei_shop_member_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = log.openid ' . ' left join ' . tablename('ewei_shop_member_group') . ' g on g.id = m.groupid ' . ' left join ' . tablename('ewei_shop_member_level') . ' l on l.id = m.level ' . ' where 1 ' . $condition . ' ORDER BY log.createtime DESC ';
		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		}
		$list = pdo_fetchall($sql, $params);
		// var_dump($list);exit();
		$apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');
		if (!(empty($list))) {
			$openids = array();
			foreach ($list as $key => $value) {
				$list[$key]['typestr'] = $apply_type[$value['applytype']];
				if ($value['deductionmoney'] == 0) {
					// $list[$key]['realmoney'] = $value['money'];
				}
				if (!(strexists($value['openid'], 'sns_wa_'))) {
					array_push($openids, $value['openid']);
				} else {
					array_push($openids, substr($value['openid'], 7));
				}
			}
			$members_sql = 'select id as mid, realname,avatar,weixin,nickname,mobile,openid,openid_wa from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid and openid IN (\'' . implode('\',\'', array_unique($openids)) . '\') OR openid_wa IN (\'' . implode('\',\'', array_unique($openids)) . '\')';
			$members = pdo_fetchall($members_sql, array(':uniacid' => $_W['uniacid']), 'openid');
			$rs = array();
			if (!(empty($members))) {
				foreach ($members as $key => &$row) {
					if (!(empty($row['openid_wa']))) {
						$rs['sns_wa_' . $row['openid_wa']] = $row;
					} else {
						$rs[] = $row;
					}
				}
			}
			$member_openids = array_keys($members);
			$money_ETH_1 = 0;
			$money_ETH_2 = 0;
			$money_ETH_3 = 0;
			$credit = 0;
			foreach ($list as $key => $value) {
				if ($value['status'] == 1) {
					$money_ETH_1 += $value['money'];
					$money_ETH_2 += $value['realmoney'];
					$money_ETH_3 += $value['charge'];
					$credit += $value['credit'];
				}
				if (in_array($list[$key]['openid'], $member_openids)) {
					$list[$key] = array_merge($list[$key], $members[$list[$key]['openid']]);
				} else {
					$list[$key] = array_merge($list[$key], (isset($rs[$list[$key]['openid']]) ? $rs[$list[$key]['openid']] : array()));
				}
			}
			$money = array('money_ETH_1' => $money_ETH_1, 'money_ETH_2' => $money_ETH_2, 'money_ETH_3' => $money_ETH_3, 'credit' => $credit);
		}
		if ($_GPC['export'] == 1) {
			if ($_GPC['type'] == 1) {
				plog('finance.log.withdraw.export', '导出提现记录');
			} else {
				plog('finance.log.recharge.export', '导出充值记录');
			}
			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['groupname'] = ((empty($row['groupname']) ? '无分组' : $row['groupname']));
				$row['levelname'] = ((empty($row['levelname']) ? '普通会员' : $row['levelname']));
				$row['typestr'] = $apply_type[$row['applytype']];
				if ($row['status'] == 0) {
					if ($row['type'] == 0) {
						$row['status'] = '未充值';
					} else {
						$row['status'] = '申请中';
					}
				} else if ($row['status'] == 1) {
					if ($row['type'] == 0) {
						$row['status'] = '充值成功';
					} else {
						$row['status'] = '完成';
					}
				} else if ($row['status'] == -1) {
					if ($row['type'] == 0) {
						$row['status'] = '';
					} else {
						$row['status'] = '失败';
					}
				}
				if ($row['rechargetype'] == 'system') {
					$row['rechargetype'] = '后台';
				} else if ($row['rechargetype'] == 'wechat') {
					$row['rechargetype'] = '微信';
				} else if ($row['rechargetype'] == 'alipay') {
					$row['rechargetype'] = '支付宝';
				}
			}
			unset($row);
			$columns = array();
			$columns[] = array('title' => '昵称', 'field' => 'nickname', 'width' => 12);
			$columns[] = array('title' => '姓名', 'field' => 'realname', 'width' => 12);
			$columns[] = array('title' => '手机号', 'field' => 'mobile', 'width' => 12);
			$columns[] = array('title' => '会员等级', 'field' => 'levelname', 'width' => 12);
			$columns[] = array('title' => '会员分组', 'field' => 'groupname', 'width' => 12);
			$columns[] = array('title' => (empty($type) ? '充值金额' : '提现金额'), 'field' => 'money', 'width' => 12);
			if (!(empty($type))) {
				$columns[] = array('title' => '到账金额', 'field' => 'realmoney', 'width' => 12);
				$columns[] = array('title' => '手续费金额', 'field' => 'deductionmoney', 'width' => 12);
				$columns[] = array('title' => '提现方式', 'field' => 'typestr', 'width' => 12);
				$columns[] = array('title' => '提现姓名', 'field' => 'applyrealname', 'width' => 24);
				$columns[] = array('title' => '支付宝', 'field' => 'alipay', 'width' => 24);
				$columns[] = array('title' => '银行', 'field' => 'bankname', 'width' => 24);
				$columns[] = array('title' => '银行卡号', 'field' => 'bankcard', 'width' => 24);
				$columns[] = array('title' => '申请时间', 'field' => 'applytime', 'width' => 24);
			}
			$columns[] = array('title' => (empty($type) ? '充值时间' : '提现申请时间'), 'field' => 'createtime', 'width' => 12);
			if (empty($type)) {
				$columns[] = array('title' => '充值方式', 'field' => 'rechargetype', 'width' => 12);
			}
			$columns[] = array('title' => '备注', 'field' => 'remark', 'width' => 24);
			m('excel')->export($list, array('title' => ((empty($type) ? '会员充值数据-' : '会员提现记录')) . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}


		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = log.openid ' . ' where 1 ' . $condition . ' ' . $member_sql, $params);
		$pager = pagination2($total, $pindex, $psize);
		$groups = m('member')->getGroups();
		$levels = m('member')->getLevels();
		include $this->template();
	}
	public function commission()
	{
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$select = 'SELECT og.id,og.money,og.money2,og.createtime,og.jifen,og.type,og.status
				,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				,m2.id as m2id,m2.realname as m2realname,m2.mobile as m2mobile,m2.nickname as m2nickname,m2.avatar as m2avatar FROM ';
		$tablename = 	tablename('ewei_shop_order_goods1') . ' og left join ' . tablename('ewei_shop_order')
			. ' o ON o.id=og.orderid left join ' . tablename('ewei_shop_member') . ' m ON m.openid=og.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=og.openid2';
		$where = ' WHERE og.uniacid=:uniacid';
		if (!empty($_GPC['type'])) {
			$where .= ' AND og.type=:type';
			$params[':type'] = $_GPC['type'];
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

		if ($_GPC['export'] == 1) {
			$list = pdo_fetchall($select . $tablename . $where, $params);
			foreach ($list as $key => $value) {
				if (!$value['m1realname']) {
					$list[$key]['m1realname'] = '匿名';
				}

				if ($value['type'] == 1) {
					$list[$key]['type'] = '分销';
				} else if ($value['type'] == 2) {
					$list[$key]['type'] = '业绩';
				} else {
					$list[$key]['type'] = '总业绩';
				}

				if ($value['status'] == '0') {
					$list[$key]['status'] = '上级条件不符合，上上级领取';
				} else if ($value['status'] == 1) {
					$list[$key]['status'] = '一级';
				} else {
					$list[$key]['status'] = '二级';
				}

				$list[$key]['createtime'] = date("Y-m-d H:i:s", $value['createtime']);
			}
			if ($_GPC['type'] == 1) {
				plog('finance.log.withdraw.export', '导出佣金明细');
			}
			$columns = array();
			$columns[] = array('title' => '订单单号', 'field' => 'ordersn', 'width' => 24);
			$columns[] = array('title' => '获利会员', 'field' => 'm1realname', 'width' => 12);
			$columns[] = array('title' => '来源会员', 'field' => 'm2realname', 'width' => 12);
			$columns[] = array('title' => '佣金金额', 'field' => 'money', 'width' => 12);
			$columns[] = array('title' => '类型', 'field' => 'type', 'width' => 12);

			$columns[] = array('title' => ("业绩产生时间"), 'field' => 'createtime', 'width' => 24);

			$columns[] = array('title' => '状态', 'field' => 'status', 'width' => 24);
			m('excel')->export($list, array('title' => ("佣金明细") . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}


		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM ' . $tablename . $where, $params);
		$pager = pagination2($total, $pindex, $psize);
		// echo '<pre>';
		// pdo_debug();
		// var_dump($total);
		include $this->template();
	}

	public function zhuanzhang()
	{
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$select = 'SELECT og.id,og.money,og.createtime,og.money2
				,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				,m2.id as m2id,m2.realname as m2realname,m2.mobile as m2mobile,m2.nickname as m2nickname,m2.avatar as m2avatar FROM ';
		$tablename = 	tablename('ewei_zhuanzhang') . ' og left join ' . tablename('ewei_shop_member') . ' m ON m.openid=og.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=og.openid2';
		$where = ' WHERE og.uniacid=:uniacid';
		// exit();
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

		if ($_GPC['export'] == 1) {
			$list = pdo_fetchall($select . $tablename . $where, $params);
			foreach ($list as $key => $value) {
				if (!$value['m1realname']) {
					$list[$key]['m1realname'] = '匿名';
				}

				if ($value['type'] == 1) {
					$list[$key]['type'] = '分销';
				} else if ($value['type'] == 2) {
					$list[$key]['type'] = '业绩';
				} else {
					$list[$key]['type'] = '总业绩';
				}

				if ($value['status'] == '0') {
					$list[$key]['status'] = '上级条件不符合，上上级领取';
				} else if ($value['status'] == 1) {
					$list[$key]['status'] = '一级';
				} else {
					$list[$key]['status'] = '二级';
				}

				$list[$key]['createtime'] = date("Y-m-d H:i:s", $value['createtime']);
			}
			if ($_GPC['type'] == 1) {
				plog('finance.log.withdraw.export', '导出佣金明细');
			}
			$columns = array();
			$columns[] = array('title' => '订单单号', 'field' => 'ordersn', 'width' => 24);
			$columns[] = array('title' => '获利会员', 'field' => 'm1realname', 'width' => 12);
			$columns[] = array('title' => '来源会员', 'field' => 'm2realname', 'width' => 12);
			$columns[] = array('title' => '佣金金额', 'field' => 'money', 'width' => 12);
			$columns[] = array('title' => '类型', 'field' => 'type', 'width' => 12);

			$columns[] = array('title' => ("业绩产生时间"), 'field' => 'createtime', 'width' => 24);

			$columns[] = array('title' => '状态', 'field' => 'status', 'width' => 24);
			m('excel')->export($list, array('title' => ("佣金明细") . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}


		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		foreach ($list as $key => $value) {
			$list[$key]['moneysd'] = number_format($value['money'] - $value['money2'], 6);
		}
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM ' . $tablename . $where, $params);
		$pager = pagination2($total, $pindex, $psize);
		// exit();
		include $this->template();
	}

	public function hongbao()
	{
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$select = 'SELECT rh.money,rh.money2,rh.time,rh.type,rh.id,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar FROM ';
		$tablename = 	tablename('ewei_shop_receive_hongbao') . 'rh left join ' . tablename('ewei_shop_member') . ' m ON rh.openid=m.openid ';
		$where = ' WHERE rh.uniacid=:uniacid';

		if (!empty($_GPC['keyword']) && $_GPC['searchfield'] == 'member') {
			$where .= ' AND (m.realname =:info OR m.mobile=:info OR m.nickname=:info)';
			$params[':info'] = $_GPC['keyword'];
		}
		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$time = $_GPC['time'];
			$params[':start'] = strtotime($time['start']);
			$params[':end'] = strtotime($time['end']);
			$where .= ' AND rh.time BETWEEN :start AND :end ';
		}
		$where .= ' ORDER BY rh.id DESC ';
		$params[':uniacid'] = $_W['uniacid'];
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		$total = pdo_fetchcolumn('SELECT count(rh.id) FROM ' . $tablename . $where, $params);
		$pager = pagination2($total, $pindex, $psize);
		// echo '<pre>';
		// pdo_debug();
		// var_dump($total);
		include $this->template();
	}

	public function refund($tid = 0, $fee = 0, $reason = '')
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['shop'];
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_member_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (empty($log)) {
			show_json(0, '未找到记录!');
		}
		if (!(empty($log['type']))) {
			show_json(0, '非充值记录!');
		}
		if ($log['rechargetype'] == 'system') {
			show_json(0, '后台充值无法退款!');
		}
		$current_credit = m('member')->getCredit($log['openid'], 'credit2');
		if ($current_credit < $log['money']) {
			show_json(0, '会员账户余额不足，无法进行退款!');
		}
		$out_refund_no = 'RR' . substr($log['logno'], 2);
		if ($log['rechargetype'] == 'wechat') {
			if (empty($log['isborrow'])) {
				$result = m('finance')->refund($log['openid'], $log['logno'], $out_refund_no, $log['money'] * 100, $log['money'] * 100, (!(empty($log['apppay'])) ? true : false));
			} else {
				$result = m('finance')->refundBorrow($log['openid'], $log['logno'], $out_refund_no, $log['money'] * 100, $log['money'] * 100);
			}
		} else if ($log['rechargetype'] == 'alipay') {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			if (!(empty($log['apppay']))) {
				if (empty($sec['app_alipay']['private_key']) || empty($sec['app_alipay']['appid'])) {
					show_json(0, '支付参数错误，私钥为空或者APPID为空!');
				}
				$params = array('out_trade_no' => $log['logno'], 'refund_amount' => $log['money'], 'refund_reason' => '会员充值退款: ' . $log['money'] . '元 订单号: ' . $log['logno'] . '/' . $out_refund_no);
				$config = array('app_id' => $sec['app_alipay']['appid'], 'privatekey' => $sec['app_alipay']['private_key'], 'publickey' => '', 'alipublickey' => '');
				$result = m('finance')->newAlipayRefund($params, $config);
			} else {
				if (empty($log['transid'])) {
					show_json(0, '仅支持 升级后此功能后退款的订单!');
				}
				$setting = uni_setting($_W['uniacid'], array('payment'));
				if (!(is_array($setting['payment']))) {
					return error(1, '没有设定支付参数');
				}
				$alipay_config = $setting['payment']['alipay'];
				$batch_no_money = $log['money'] * 100;
				$batch_no = date('Ymd') . 'RC' . $log['id'] . 'MONEY' . $batch_no_money;
				$res = m('finance')->AlipayRefund(array('trade_no' => $log['transid'], 'refund_price' => $log['money'], 'refund_reason' => '会员充值退款: ' . $log['money'] . '元 订单号: ' . $log['logno'] . '/' . $out_refund_no), $batch_no, $alipay_config);
				if (is_error($res)) {
					show_json(0, $res['message']);
				}
				show_json(1, array('url' => $res));
			}
		} else {
			$result = m('finance')->pay($log['openid'], 1, $log['money'] * 100, $out_refund_no, $set['name'] . '充值退款');
		}
		if (is_error($result)) {
			show_json(0, $result['message']);
		}
		pdo_update('ewei_shop_member_log', array('status' => 3), array('id' => $id, 'uniacid' => $_W['uniacid']));
		$refundmoney = $log['money'] + $log['gives'];
		m('member')->setCredit($log['openid'], 'credit2', -$refundmoney, array(0, $set['name'] . '充值退款'));
		$money = com_run('sale::getCredit1', $log['openid'], (double)$log['money'], 21, 2, 1);
		if (0 < $money) {
			m('notice')->sendMemberPointChange($log['openid'], $money, 1);
		}
		m('notice')->sendMemberLogMessage($log['id']);
		$member = m('member')->getMember($log['openid']);
		plog('finance.log.refund', '充值退款 ID: ' . $log['id'] . ' 金额: ' . $log['money'] . ' <br/>会员信息:  ID: ' . $member['id'] . ' / ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
		show_json(1, array('url' => referer()));
	}
	public function wechat()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_member_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (empty($log)) {
			show_json(0, '未找到记录!');
		}
		if ($log['deductionmoney'] == 0) {
			$realmoney = $log['money'];
		} else {
			$realmoney = $log['realmoney'];
		}
		$set = $_W['shopset']['shop'];
		$data = m('common')->getSysset('pay');
		if (!(empty($data['paytype']['withdraw']))) {
			$result = m('finance')->payRedPack($log['openid'], $realmoney * 100, $log['logno'], $log, $set['name'] . '余额提现', $data['paytype']);
			pdo_update('ewei_shop_member_log', array('sendmoney' => $result['sendmoney'], 'senddata' => json_encode($result['senddata'])), array('id' => $log['id']));
			if ($result['sendmoney'] == $realmoney) {
				$result = true;
			} else {
				$result = $result['error'];
			}
		} else {
			$result = m('finance')->pay($log['openid'], 1, $realmoney * 100, $log['logno'], $set['name'] . '余额提现');
		}
		if (is_error($result)) {
			show_json(0, array('message' => $result['message']));
		}
		pdo_update('ewei_shop_member_log', array('status' => 1), array('id' => $id, 'uniacid' => $_W['uniacid']));
		m('notice')->sendMemberLogMessage($log['id']);
		$member = m('member')->getMember($log['openid']);
		plog('finance.log.wechat', '余额提现 ID: ' . $log['id'] . ' 方式: 微信 提现金额: ' . $log['money'] . ' ,到账金额: ' . $realmoney . ' ,手续费金额 : ' . $log['deductionmoney'] . '<br/>会员信息:  ID: ' . $member['id'] . ' / ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
		show_json(1);
	}
	public function alipay()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_member_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (empty($log)) {
			show_json(0, '未找到记录!');
		}
		if ($log['deductionmoney'] == 0) {
			$realmoeny = $log['money'];
		} else {
			$realmoeny = $log['realmoney'];
		}
		$set = $_W['shopset']['shop'];
		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);
		if (!(empty($sec['alipay_pay']['open']))) {
			$batch_no_money = $realmoeny * 100;
			$batch_no = 'D' . date('Ymd') . 'RW' . $log['id'] . 'MONEY' . $batch_no_money;
			$res = m('finance')->AliPay(array('account' => $log['alipay'], 'name' => $log['realname'], 'money' => $realmoeny), $batch_no, $sec['alipay_pay'], $log['title']);
			if (is_error($res)) {
				show_json(0, $res['message']);
			}
			show_json(1, array('url' => $res));
		}
		show_json(0, '未开启,支付宝打款!');
	}
	public function manual()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_member_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (empty($log)) {
			show_json(0, '未找到记录!');
		}
		$member = m('member')->getMember($log['openid']);
		pdo_update('ewei_shop_member_log', array('status' => 1), array('id' => $id, 'uniacid' => $_W['uniacid']));
		m('notice')->sendMemberLogMessage($log['id']);
		plog('finance.log.manual', '余额提现 方式: 手动 ID: ' . $log['id'] . ' <br/>会员信息: ID: ' . $member['id'] . ' / ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
		show_json(1);
	}
	public function refuse()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_member_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (empty($log)) {
			show_json(0, '未找到记录!');
		}
		pdo_update('ewei_shop_member_log', array('status' => -1), array('id' => $id, 'uniacid' => $_W['uniacid']));
		if (0 < $log['money']) {
			m('member')->setCredit($log['openid'], 'credit2', $log['money'], array(0, $set['name'] . '余额提现退回'));
		}
		m('notice')->sendMemberLogMessage($log['id']);
		plog('finance.log.refuse', '拒绝余额度提现 ID: ' . $log['id'] . ' 金额: ' . $log['money'] . ' <br/>会员信息:  ID: ' . $member['id'] . ' / ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
		show_json(1);
	}
	public function recharge()
	{
		$this->main(0);
	}
	public function turnout()
	{
		$this->main(2);
	}
	public function withdraw()
	{
		$this->main(1);
	}
	/**
	 * 同意投资申请
	 *
	 * @return json
	 */
	public function apply()
	{
		global $_W, $_GPC;
		$id = $_GPC['id'];
		if (empty($_GPC['id']))
			show_json(0);
		$apply = pdo_fetch('SELECT openid,money,credit FROM ' . tablename('ewei_shop_member_log') . ' WHERE uniacid=:uniacid AND id=:id', [':id' => $id, ':uniacid' => $_W['uniacid']]);
		$level = m('member')->level12($apply['openid'], $apply['money']);
		// show_json($level);exit();
		if ($member['type'] == 0) {
			pdo_update("ewei_shop_member", " type='1' ", array('openid' => $apply['openid'], 'uniacid' => $_W['uniacid']));
		}
		//动态奖金
		m('common')->comm($apply['openid'], $apply['money']);

		//领导奖奖金
		m('common')->leader($apply['openid'], $apply['money']);
		m('member')->setCredit($apply['openid'], 'credit1', $apply['money']);
		pdo_update('ewei_shop_member_log', ['status' => '1'], ['id' => $id]);

		show_json(1);
	}

	/**
	 * 提现申请
	 *
	 * @return json
	 */
	public function apply2()
	{
		global $_W, $_GPC;
		$id = $_GPC['id'];
		if (empty($_GPC['id']))
			show_json(0);
		$apply = pdo_fetch('SELECT openid,money,credit FROM ' . tablename('ewei_shop_member_log') . ' WHERE uniacid=:uniacid AND id=:id', [':id' => $id, ':uniacid' => $_W['uniacid']]);

		if ($_GPC['type'] == 1) { //同意
			pdo_update('ewei_shop_member_log', ['status' => '1'], ['id' => $id]);
		} else { //拒绝
			//返钱
			m('member')->setCredit($apply['openid'], 'credit2', $apply['money']);
			pdo_update('ewei_shop_member_log', ['status' => '2'], ['id' => $id]);
		}

		show_json(1);
	}
}
