<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}
class Bonusjilu1_EweiShopV2Page extends MobileLoginPage
{
	protected $member;
	public function __construct()
	{
		global $_W;
		global $_GPC;
		parent::__construct();
		$this->member = m('member')->getInfo($_W['openid']);
	}

	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_GPC['type']) $type = $_GPC['type'];
		else $type = 4;


		include $this->template();
	}

	public function record()
	{
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];

		//今日开始时间和结束时间戳
		$start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;


		if ($type == 4) {		//积分记录

			$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_receive_hongbao") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.time>=$start and g.time<=$end and g.openid=:openid order by g.time desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			foreach ($list as $key => $val) {
				$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['time']);
			}

			$count =  pdo_fetch("select sum(g.money) as money,sum(g.money2) as money2 from" . tablename("ewei_shop_receive_hongbao") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.time>=$start and g.time<=$end  and g.openid=:openid", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			if (!$count['money'] && !$count['money2']) {
				$summoeny = 0;
			} else {
				$summoeny = $count['money'] + $count['money2'];
			}

			$data = array('list' => $list, 'money' => $summoeny);

			show_json(1, $data);
		}

		$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_order_goods1") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.createtime>=$start and g.createtime<=$end and g.type='$type' and g.openid=:openid order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
			$list[$key]['money3'] = $val['money'] + $val['money2'];
		}

		$count =  pdo_fetch("select sum(g.money) as money,sum(g.money2) as money2  from" . tablename("ewei_shop_order_goods1") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.createtime>=$start and g.createtime<=$end and g.type='$type' and g.openid=:openid", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		$data = array('list' => $list, 'money' => $count['money'] + $count['money2']);

		show_json(1, $data);
	}
}
