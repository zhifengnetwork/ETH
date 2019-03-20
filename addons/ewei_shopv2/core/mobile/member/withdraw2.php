<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Withdraw2_EweiShopV2Page extends MobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['trade'];

		$status = 1;
		$openid = $_W['openid'];
		$member = m('member')->getMember($_W['openid'], true);
		if (empty($set['withdraw'])) 
		{
			$this->message('系统未开启提现!', '', 'error');
		}
		$withdrawcharge = $set['withdrawcharge1'];
		$withdrawbegin = floatval($set['withdrawbegin']);
		$withdrawend = floatval($set['withdrawend']);
		$credit = m('member')->getCredit($_W['openid'], 'credit3');
		$last_data = $this->getLastApply($openid);
		// var_dump($last_data);
		// $canusewechat = !(strexists($openid, 'wap_user_')) && !(strexists($openid, 'sns_qq_')) && !(strexists($openid, 'sns_wx_')) && !(strexists($openid, 'sns_wa_'));
		$type_array = array();
		if (($set['withdrawcashweixin'] == 1)) 
		{
			$type_array[0]['title'] = '提现到微信钱包';
		}
		if ($set['withdrawcashalipay'] == 1) 
		{
			$type_array[2]['title'] = '提现到支付宝';
			if (!(empty($last_data))) 
			{
				if ($last_data['applytype'] != 2) 
				{
					$type_last = $this->getLastApply($openid, 2);
					if (!(empty($type_last))) 
					{
						$last_data['alipay'] = $type_last['alipay'];
					}
				}
			}
		}
		if ($set['withdrawcashcard'] == 1) 
		{
			$type_array[3]['title'] = '提现到银行卡';
			if (!(empty($last_data))) 
			{
				if ($last_data['applytype'] != 3) 
				{
					$type_last = $this->getLastApply($openid, 3);
					if (!(empty($type_last))) 
					{
						$last_data['bankname'] = $type_last['bankname'];
						$last_data['bankcard'] = $type_last['bankcard'];
					}
				}
			}
			$condition = ' and uniacid=:uniacid';
			$params = array(':uniacid' => $_W['uniacid']);
			$banklist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_bank') . ' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC', $params);
		}
		if (!(empty($last_data))) 
		{
			if (array_key_exists($last_data['applytype'], $type_array)) 
			{
				$type_array[$last_data['applytype']]['checked'] = 1;
			}
		}
		// echo '<pre>';
		// var_dump($set,$type_array);
		// exit;
		include $this->template();
	}
	public function submit() 
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['trade'];
		if (empty($set['withdraw'])) 
		{
			show_json(0, '系统未开启提现!');
		}
		$set_array = array();
		$set_array['charge'] = $set['withdrawcharge1'];
		$set_array['begin'] = floatval($set['withdrawbegin']);
		$set_array['end'] = floatval($set['withdrawend']);
		$money = floatval($_GPC['money']);
		$credit = m('member')->getCredit($_W['openid'], 'credit3');
		if ($money <= 0) 
		{
			show_json(0, '提现金额错误!');
		}
		if ($credit < $money) 
		{
			show_json(0, '提现金额过大!');
		}
		$apply = array();
		$type_array = array();
		
		$realmoney = $money;
		if (!(empty($set_array['charge']))) 
		{
			$money_array = m('member')->getCalculateMoney($money, $set_array);
			if ($money_array['flag']) 
			{
				$realmoney = $money_array['realmoney'];
				$deductionmoney = $money_array['deductionmoney'];
			}
		}
		m('member')->setCredit($_W['openid'], 'credit3', -$money, array(0, $_W['shopset']['set'][''] . '余额提现预扣除: ' . $money . ',实际到账金额:' . $realmoney . ',手续费金额:' . $deductionmoney));
		m('member')->setCredit($member['openid'],'credit2',$money);
		$logno = m('common')->createNO('member_log', 'logno', 'RW');
		$apply['uniacid'] = $_W['uniacid'];
		$apply['logno'] = $logno;
		$apply['openid'] = $_W['openid'];
		$apply['title'] = '转出至TRX';
		$apply['type'] = 2;
		$apply['createtime'] = time();
		$apply['status'] = 0;
		$apply['money'] = $money;
		$apply['realmoney'] = $realmoney;
		
		$ass = pdo_insert('ewei_shop_member_log', $apply);
		
		$logid = pdo_insertid();
		m('notice')->sendMemberLogMessage($logid);
		show_json(1);
	}
	public function getLastApply($openid, $applytype = -1) 
	{
		global $_W;
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		$sql = 'select applytype,alipay,bankname,bankcard,realname from ' . tablename('ewei_shop_member_log') . ' where openid=:openid and uniacid=:uniacid';
		if (-1 < $applytype) 
		{
			$sql .= ' and applytype=:applytype';
			$params[':applytype'] = $applytype;
		}
		$sql .= ' order by id desc Limit 1';
		$data = pdo_fetch($sql, $params);
		return $data;
	}
}
?>