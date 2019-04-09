<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}
class Withdraw_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['trade'];
		// var_dump($set);exit();
		$status = 1;
		$openid = $_W[''];
		if (empty($set['withdraw'])) {
			$this->message('系统未开启提现!', '', 'error');
		}
		$withdrawcharge = $set['withdrawcharge'];
		$withdrawbegin = floatval($set['withdrawbegin']);
		$withdrawend = floatval($set['withdrawend']);
		$credit = m('member')->getCredit($_W['openid'], 'credit2');
		$last_data = $this->getLastApply($openid);
		$canusewechat = !(strexists($openid, 'wap_user_')) && !(strexists($openid, 'sns_qq_')) && !(strexists($openid, 'sns_wx_')) && !(strexists($openid, 'sns_wa_'));
		$type_array = array();
		if (($set['withdrawcashweixin'] == 1) && $canusewechat) {
			$type_array[0]['title'] = '提现到微信钱包';
		}
		if ($set['withdrawcashalipay'] == 1) {
			$type_array[2]['title'] = '提现到支付宝';
			if (!(empty($last_data))) {
				if ($last_data['applytype'] != 2) {
					$type_last = $this->getLastApply($openid, 2);
					if (!(empty($type_last))) {
						$last_data['alipay'] = $type_last['alipay'];
					}
				}
			}
		}
		if ($set['withdrawcashcard'] == 1) {
			$type_array[3]['title'] = '提现到银行卡';
			if (!(empty($last_data))) {
				if ($last_data['applytype'] != 3) {
					$type_last = $this->getLastApply($openid, 3);
					if (!(empty($type_last))) {
						$last_data['bankname'] = $type_last['bankname'];
						$last_data['bankcard'] = $type_last['bankcard'];
					}
				}
			}
			$condition = ' and uniacid=:uniacid';
			$params = array(':uniacid' => $_W['uniacid']);
			$banklist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_bank') . ' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC', $params);
		}
		if (!(empty($last_data))) {
			if (array_key_exists($last_data['applytype'], $type_array)) {
				$type_array[$last_data['applytype']]['checked'] = 1;
			}
		}
		include $this->template();
	}
	public function submit()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['trade'];

		if (empty($set['withdraw'])) {
			show_json(0, '系统未开启提现!');
		}
		$set_array = array();

		//判断该会员是否绑定钱包地址和二维码
		$member = m('member')->getMember($_W['openid'], true);
		if (!$member['walletcode'] || !$member['walletaddress']) {
			show_json(-1, '请完善您的资料!');
		}

		$money = floatval($_GPC['money']);
		if (!floor($money / $set['withdrawmoney']))  show_json(0, "提现的金额必须是" . $set['withdrawmoney'] . "的倍数");
		$credit = m('member')->getCredit($_W['openid'], 'credit2');

		$apply = array();
		$type_array = array();

		$realmoney = $money;

		if (!(empty($set_array['charge']))) {
			$money_array = m('member')->getCalculateMoney($money, $set_array);
			if ($money_array['flag']) {
				$realmoney = $money_array['realmoney'];
				$deductionmoney = $money_array['deductionmoney'];
			}
		}

		m('member')->setCredit($_W['openid'], 'credit2', -$money, array(0, $_W['shopset']['set'][''] . '余额提现预扣除: ' . $money . ',实际到账金额:' . $realmoney . ',手续费金额:' . $deductionmoney));
		$logno = m('common')->createNO('member_log', 'logno', 'RW');
		$apply['uniacid'] = $_W['uniacid'];
		$apply['logno'] = $logno;
		$apply['openid'] = $_W['openid'];
		$apply['title'] = 'ETH提现余额';
		$apply['type'] = 4;
		$apply['createtime'] = time();
		$apply['status'] = 0;
		$apply['money'] = $money;
		$apply['front_money'] = $member['credit2'];
		$apply['after_money'] = $member['credit2'] - $money;
		$apply['add'] = $member['walletaddress'];
		$apply['url'] = $member['walletcode'];
		$apply['realmoney'] = $_GPC['realmoney'];
		$apply['charge'] = $_GPC['charge'];
		// show_json($apply);
		pdo_insert('ewei_shop_member_log', $apply);
		$logid = pdo_insertid();
		m('notice')->sendMemberLogMessage($logid);
		show_json(1);
	}
	public function getLastApply($openid, $applytype = -1)
	{
		global $_W;
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		$sql = 'select applytype,alipay,bankname,bankcard,realname from ' . tablename('ewei_shop_member_log') . ' where openid=:openid and uniacid=:uniacid';
		if (-1 < $applytype) {
			$sql .= ' and applytype=:applytype';
			$params[':applytype'] = $applytype;
		}
		$sql .= ' order by id desc Limit 1';
		$data = pdo_fetch($sql, $params);
		return $data;
	}
}
