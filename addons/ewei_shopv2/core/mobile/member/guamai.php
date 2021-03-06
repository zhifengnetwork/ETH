<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}
class Guamai_EweiShopV2Page extends MobileLoginPage
{
	protected $member;
	public function __construct()
	{

		global $_W;
		global $_GPC;
		parent::__construct();
		$this->member = m('member')->getInfo($_W['openid']);
	}


	public function appeal()
	{
		$id = $_GET['id'];
		include $this->template();
	}

	public function upimgarray()
	{
		global $_W;
		global $_GPC;
		global $uploadImg;
		if ($_W['ispost']) {
			unset($GOLBALS['uploadImg']);
			foreach ($_GPC['images'] as $key => $image)
				$uploadImg[] = $this->uploadImg($image);
		}
		show_json('uploadImg', $uploadImg);
		// dump($uploadImg);
	}

	public function uploadImg($base64)
	{
		global $_W;
		global $_GPC;
		header("content-type:text/html;charset=utf-8");
		$base64_image = str_replace(' ', '+', $base64);
		//post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)) {
			//匹配成功
			if ($result[2] == 'jpeg') {
				$image_name = uniqid() . '.jpg';
				//纯粹是看jpeg不爽才替换的
			} else {
				$image_name = uniqid() . '.' . $result[2];
			}
			load()->func('file');
			$path = 'images/uploads/' . date('Ymd', time());
			if (!(is_dir(ATTACHMENT_ROOT . $path))) {
				mkdirs(ATTACHMENT_ROOT . $path);
			}

			$image_url = ATTACHMENT_ROOT . "images/uploads/" . date('Ymd', time()) . '/' . "{$image_name}";
			$res_url = ATTACHMENT_ROOT . "images/uploads/" . date('Ymd', time()) . '/' . "{$image_name}";
			//服务器文件存储路径
			if (file_put_contents($image_url, base64_decode(str_replace($result[1], '', $base64_image)))) {
				$res_url = "images/uploads/" . date('Ymd', time()) . '/' . "{$image_name}";
				// dump($res_url);
				// show_json('res_url',$res_url);
				return $res_url;
			} else {
				show_json(1, '上传失败');
			}
		} else {
			show_json(1, '上传失败');
		}
	}

	//我的订单
	public function number_order()
	{
		date_default_timezone_set('PRC');
		global $_W;
		global $_GPC;
		$type = 0;
		$openid = $_W['openid'];
		//价格基础TRX价格  以及手续费
		$sys = pdo_fetch("select trxprice,trxsxf from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		$sys['trxsxf'] = round($sys['trxsxf'], 2);
		$start  = $sys['trxprice'] * (1 - 0.1);
		$end    = $sys['trxprice'] * (1 + 0.1);
		$member = m('member')->getMember($_W['openid'], true);
		//用户买入,卖出订单
		$guamai = pdo_fetchall("select * from" . tablename("guamai") . "where openid='" . $openid . "' or openid2='" . $openid . "' order by createtime desc");
		$time = time();
		foreach ($guamai as $key => $val) {
			// var_dump($val);nickname2
			$guamai[$key]['datatime'] = date("Y-m-d H:i:s", $val['createtime']);
			$guamai[$key]['time_news'] = ($val['createtime'] + 1800) - $time;
			$guamai[$key]['nickname'] = substr($val['openid'], -11);
			$guamai[$key]['nickname2'] = substr($val['openid2'], -11);
		}

		//申诉
		$guamai_appeal = pdo_fetchall("select * from" . tablename("guamai_appeal") . "where openid='" . $openid . "' or openid2='" . $openid . "'");
		foreach ($guamai_appeal as $k => $v) {
			$guamai_appeal[$k]['createtime'] = date("Y-m-d", $v['createtime']);
		}
		include $this->template();
	}

	//我的申诉
	public function tab_con()
	{
		global $_W;
		global $_GPC;
		if ($_W['ispost']) {
			if ($_GPC['text'] == '') {
				show_json(-1, '标题不能为空!!!');
			}
			if ($_GPC['textarea'] == '') {
				show_json(-1, '内容不能为空!!!');
			}
			$id = $_GPC['id'];
			$hello = json_encode(explode(',', $_GPC['files']));
			// $aa =  json_decode($hello);
			$guamai = pdo_fetch("select * from" . tablename("guamai") . "where id='" . $id . "'");
			$appeal = pdo_fetch("select * from" . tablename("guamai_appeal") . "where stuas=0 and order_id='" . $id . "' and appeal_name='" . $_W['mid'] . "'");
			if ($appeal) {
				show_json(1, '您还有一条为审核的申诉,请稍后再试!!!');
			} else {
				$data_appeal = array(
					"openid" => $guamai['openid'],
					"openid2" => $guamai['openid2'],
					"order_id" => $id,
					"file" => $guamai['file'],
					"files" => $hello,
					"type" => $guamai['type'],
					"appeal_name" => $_W['mid'],
					"stuas" => 0,
					"text" => $_GPC['text'],
					"textarea" => $_GPC['textarea'],
					"createtime" => time()
				);
				$guamai_appeal = pdo_insert("guamai_appeal", $data_appeal);
				if ($guamai_appeal) {
					show_json(1, '申诉成功');
				}
			}
		}
	}
	//申诉详情
	public function guamai_appeal_list()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$guamai_appeal = pdo_fetch("select g.*,m.* from" . tablename("guamai_appeal") . ' g left join ' . tablename('guamai') . '  m ON m.id=g.order_id' . " where g.id='$id'");
		// $user_id = $_GPC['mid'];
		$user_id = $guamai_appeal['appeal_name'];
		$users = pdo_fetch("select * from" . tablename("ewei_shop_member") . " where id='$user_id'");
		// dump($guamai_appeal);
		if ($users['openid'] == $guamai_appeal['openid']) {
			$guamai_appeal['openid2'] = substr($guamai_appeal['openid2'], -11);
			$guamai_appeal['openid']  = substr($guamai_appeal['openid'], -11);
			$guamai_appeal['type1']   = 0;
		} else {
			$guamai_appeal['openid2'] = substr($guamai_appeal['openid'], -11);
			$guamai_appeal['openid']  = substr($guamai_appeal['openid2'], -11);
			$guamai_appeal['type1']   = 0;
		}
		// dump($guamai_appeal['openid2']);
		include $this->template();
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$type = 0;
		//价格基础TRX价格  以及手续费
		$sys = pdo_fetch("select trxprice,trxsxf from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		$start = $sys['trxprice'] * (1 - 0.1);
		$end = $sys['trxprice'] * (1 + 0.1);
		$member = m('member')->getMember($_W['openid'], true);
		include $this->template();
	}


	//挂卖订单中心记录
	public function guamaijilu()
	{
		global $_W;
		global $_GPC;
		$type = 0;

		//价格基础TRX价格  以及手续费
		$sys = pdo_fetch("select trxprice,trxsxf from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		$start = $sys['trxprice'] * (1 - 0.1);
		$end = $sys['trxprice'] * (1 + 0.1);
		$member = m('member')->getMember($_W['openid'], true);
		include $this->template();
	}

	//点击加号触发发布订单判断
	public function judgeguamai()
	{
		global $_W;
		global $_GPC;

		$type = $_GPC['type'];

		$sys = pdo_fetch("select guamaiis from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);

		$guamai = pdo_fetchcolumn("select count(id) from" . tablename("guamai") . "where uniacid=" . $_W['uniacid'] . " and type='$type' and openid=:openid and status='0' ", array(':openid' => $_W['openid']));

		if ($guamai >= $sys['guamaiis']) {

			show_json(0, "您的未交易订单已达上限，请交易完再进行挂卖");
		} else {
			show_json(1, "状态正常");
		}
	}

	//挂卖中心
	public function recordjilu()
	{
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$openid = $_W['openid'];

		$select = 'SELECT g.id,g.openid,g.openid2,g.money,g.createtime,g.type,g.price,g.trx,g.status,m.nickname,m2.zfbfile,m2.wxfile,m2.bankid,m2.bankname,m2.bank,m2.nickname as nickname2 FROM ';
		$tablename = tablename('guamai') . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid left join' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2';
		$where = " WHERE g.uniacid=:uniacid AND g.type=:type AND (g.status=1 or g.status=2) AND (g.openid = '$openid' or g.openid2 = '$openid') ";
		$where .= " ORDER BY g.status = '1' DESC,g.openid = '$openid' DESC,g.openid2 = '$openid' DESC,g.createtime DESC ";
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

		$params[':uniacid'] = $_W['uniacid'];
		$params[':type'] = $type;

		$list = pdo_fetchall($select . $tablename . $where . $limit, $params);
		$total = pdo_fetchcolumn('SELECT count(g.id) FROM ' . $tablename . $where, $params);
		// show_json(111);

		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
			if ($val['zfbfile']) $list[$key]['zfbfile'] = 1;
			if ($val['wxfile']) $list[$key]['wxfile'] = 1;
			if ($val['bankid'] && $val['bankname'] && $val['bank']) $list[$key]['bank'] = 1;
			//判断该信息是否是自己发布的（未交易时）
			if ($val['openid'] == $_W['openid'] && $val['status'] == 0) $list[$key]['self'] = 1;
			else  $list[$key]['self'] = 0;
			//交易中
			if (($val['openid2'] != $_W['openid'] && $val['openid'] != $_W['openid']) && $val['status'] == 1) $list[$key]['self3'] = 1;
			else  $list[$key]['self3'] = 0;
		}
		// show_json($item);
		$data = array('list' => $list);

		// var_dump($data);
		// exit;

		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}


	//挂卖
	public function hangonsale()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {

			$type = $_GPC['type'];
			$openid = $_W['openid'];
			$member = m('member')->getMember($_W['openid'], true);
			//价格基础TRX价格  以及手续费
			$sys = pdo_fetch("select trxprice,trxsxf from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
			$start = $sys['trxprice'] * (1 - 0.1);
			$end = $sys['trxprice'] * (1 + 0.1);
			if ($_GPC['price'] < $start || $_GPC['price'] > $end) {
				show_json(-1, "请参考价格建议区间");
			}
			//判断该会员是否上传收款信息
			if (!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])) {
				show_json(-2, "请上传您的收款信息");
			}

			if ($type == 1) {
				if ($member['credit2'] < $_GPC['trx2']) {
					returnJson([], '您的ETH不足，请尽快投资！', -2);
				}
			}

			$data = array('openid' => $openid, 'uniacid' => $_W['uniacid'], 'price' => $_GPC['price'], 'trx' => $_GPC['trx'], 'trx2' => $_GPC['trx2'], 'money' => $_GPC['money'], 'type' => $type, 'status' => '0', 'sxf0' => $_GPC['sxf0'], 'createtime' => time());
			$data['apple_time'] = time() + 1800;
			$result = pdo_insert("guamai", $data);
			// show_json($result);
			if ($type == 1) {		//卖出

				if ($result) {    //如果挂卖成功，冻结挂卖的TRX币
					m('member')->setCredit($openid, 'credit2', -$_GPC['trx2']);
					$money2 = $member['credit2'] - $_GPC['trx2'];
					$data_member_array_log = array('uniacid' => 12, 'openid' => $openid, 'type' => 5, 'title' => "自由账户C2C交易减少" . $_GPC['trx2'], 'money' => $_GPC['trx'], 'money1' => $_GPC['trx2'], 'money2' => $money2, 'RMB' => $_GPC['money'], 'typec2c' => $type, 'createtime' => time());
					$data_member_array_log['front_money'] = $member['credit2'];
					$data_member_array_log['after_money'] = $member['credit2'] - $_GPC['trx2'];
					pdo_insert("ewei_shop_member_log", $data_member_array_log);
				}
				show_json(1, '挂卖成功');
			} else {
				show_json(1, '挂买成功');
			}
		}
	}

	// public function main()
	// {
	// 	global $_W;
	// 	global $_GPC;
	// 	$type = 0;
	// 	include $this->template();
	// }

	public function record()
	{
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$openid = $_W['openid'];

		$select = 'SELECT g.id,g.openid,g.openid2,g.money,g.createtime,g.type,g.price,g.trx,g.status,m.nickname,m.zfbfile,m.wxfile,m.bankid,m.bankname,m.bank,m2.nickname as nickname2 FROM ';
		$tablename = tablename('guamai') . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid left join' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2';
		$where = ' WHERE g.uniacid=:uniacid AND g.type=:type AND (g.status=0) ';
		$where .= " ORDER BY g.status = '1' DESC,g.openid = '$openid' DESC,g.openid2 = '$openid' DESC,g.createtime DESC ";
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

		$params[':uniacid'] = $_W['uniacid'];
		$params[':type'] = $type;

		$list  = pdo_fetchall($select . $tablename . $where . $limit, $params);
		$total = pdo_fetchcolumn('SELECT count(g.id) FROM ' . $tablename . $where, $params);
		// show_json(111);

		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
			if ($val['zfbfile']) $list[$key]['zfbfile'] = 1;
			if ($val['wxfile']) $list[$key]['wxfile'] = 1;
			if ($val['bankid'] && $val['bankname'] && $val['bank']) $list[$key]['bank'] = 1;
			//判断该信息是否是自己发布的（未交易时）
			if ($val['openid'] == $_W['openid'] && $val['status'] == 0) $list[$key]['self'] = 1;
			else  $list[$key]['self'] = 0;
			//交易中
			if (($val['openid2'] != $_W['openid'] && $val['openid'] != $_W['openid']) && $val['status'] == 1) $list[$key]['self3'] = 1;
			else  $list[$key]['self3'] = 0;

			//判断该数据是否是自己的
			if (($val['openid2'] == $_W['openid'] || $val['openid'] == $_W['openid']) && $val['status'] == 1 && $val['type'] == 1) {
				if ($key != 0) {
					// array_unshift($list,$list[$key]);
					// unset($list[$key+1]);
				}
			}

			//判断该数据是否是自己的
			if (($val['openid2'] == $_W['openid'] || $val['openid'] == $_W['openid']) && $val['status'] == 1 && $val['type'] == 0) {
				if ($key != 0) {
					// $key = 0;
					// $item[] = $key+1;
				}
			}
		}
		// show_json($item);
		$data = array('list' => $list);

		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}

	//点击买入或者卖出的时候给个判断，是否点击的是自己的订单
	public function judge()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$openid = $_GPC['openid'];
			if ($openid == $_W['openid'])
				show_json(1, "不能买入或卖出自己的订单");
		}
	}

	public function sellout_list()
	{
		global $_W;
		global $_GPC;
		//该订单的信息
		$id     = $_GPC['id'];
		$status = $_GPC['status'];
		$op     = $_GPC['op'];
		$openid = $_W['openid'];
		// dump($openid);
		$sell = pdo_fetch("select g.*,m.nickname,m.mobile,m.zfbfile,m.wxfile,m.bankid,m.bankname,m.bank,m2.mobile as mobile2,m2.nickname as nickname2,m2.zfbfile as zfbfile2,m2.wxfile as wxfile2,m2.bankid as bankid2,m2.bankname as bankname2,m2.bank as bank2 from" . tablename('guamai') . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2 ' . " where g.uniacid=" . $_W['uniacid'] . " and g.id='$id'");
		// dump($sell);
		include $this->template();
	}

	//撤销订单
	public function sellout_tab_con()
	{
		global $_W;
		global $_GPC;
		//该订单的信息
		$id = $_GPC['id'];
		$users = pdo_fetch("select id,openid,credit2 from" . tablename("ewei_shop_member") . " where openid='" . $openid . "'");
		$sell = pdo_fetch("select g.*,m.openid,m.credit2 from" . tablename('guamai') . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid ' . " where g.id='$id'");
		if (empty($sell)) return false;
		// dump($sell);die;
		if ($sell['status'] == 1) {
			show_json(1, "该订单已经在进行中,不能进行撤销!!!");
		}
		if ($sell['type'] == 0) {
			// $data = array("credit2"=>$sell['trx']+$sell['credit2']);
			$updeta_order = pdo_update("guamai", array("status" => 3, "createtime" => time()), array("openid" => $sell['openid'], "id" => $sell['id']));
			if ($updeta_order) {
				show_json(1, "撤销成功");
			}
		} else {
			$data = array("credit2" => $sell['trx2'] + $sell['credit2']);
			$updeta_order = pdo_update("guamai", array("status" => 3, "createtime" => time()), array("openid" => $sell['openid'], "id" => $sell['id']));
			if ($updeta_order) {
				$result = pdo_update("ewei_shop_member", $data, array("openid" => $sell['openid']));
				show_json(1, "撤销成功");
			} else {
				show_json(1, "撤销失败!");
			}
		}
	}

	public function sellout()
	{

		global $_W;
		global $_GPC;
		//该订单的信息
		$id = $_GPC['id'];
		$op = $_GPC['op']; //付款操作 1挂单人操作  type 买入卖出
		$openid = $_W['openid'];
		$sell = pdo_fetch("select g.*,m.nickname,m.mobile,m.zfbfile,m.wxfile,m.bankid,m.bankname,m.bank,m2.nickname as nickname2,m2.mobile as mobile2,m2.zfbfile as zfbfile2,m2.wxfile as wxfile2,m2.bankid as bankid2,m2.bankname as bankname2,m2.bank as bank2 from" . tablename('guamai') . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2 ' . " where g.uniacid=" . $_W['uniacid'] . " and g.id='$id'");
		// dump($sell);
		if ($op == 1) {
			if ($sell['zfbfile']) $payment[] = array('name' => "支付宝", 'type' => 'zfb');
			if ($sell['wxfile']) $payment[] = array('name' => "微信", 'type' => 'wx');
			if ($sell['bank'] && $sell['bankid'] && $sell['bankname']) $payment[] = array('name' => "银行", 'type' => 'bank');
		} else {
			if ($sell['zfbfile2']) $payment[] = array('name' => "支付宝", 'type' => 'zfb');
			if ($sell['wxfile2']) $payment[] = array('name' => "微信", 'type' => 'wx');
			if ($sell['bank2'] && $sell['bankid2'] && $sell['bankname2']) $payment[] = array('name' => "银行", 'type' => 'bank');
		}

		if ($sell['openid'] == $_W['openid']) {
			$type = 1;
		} else if ($sell['openid2'] == $_W['openid']) {
			$type = 2;
		}


		if ($_W['ispost']) {
			// show_json(123454);
			$type = $_GPC['type'];
			// $mobile = substr($_GPC['openid'],-11);
			// dump($openid);
			$guamai = pdo_fetchall("select * from" . tablename("guamai") . " where status = 1 and openid2='" . $openid . "'");
			// dump($type);die;
			if ($guamai) {
				$guamai_nums = count($guamai);
			}
			// dump($type);die;
			if ($type == 0) {   //买入
				if ($guamai_nums >= 1) {
					show_json(-1, "您还有订单尚未处理或还在交易中,请先进行交易！");
				}
				if ($op == 1) {
					$result = pdo_update("guamai", array('file' => $_GPC['file']), array('uniacid' => $_W['uniacid'], 'id' => $id));

					com('sms')->send_zhangjun2($sell['mobile2'], $id, "对方已付款成功,请及时确认.");

					if ($result) show_json(1, "挂单人付款成功");
				} else {
					//判断该用户是否有足够的币进行抢单
					$member = m('member')->getMember($_W['openid'], true);
					//判断该会员是否上传收款信息
					if (!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])) {
						show_json(-2, "请上传您的收款信息");
					}
					$apple_time = time() + 1800;
					$result = pdo_update("guamai", array('file' => $_GPC['file'], 'status' => 1, 'apple_time' => $apple_time, 'openid2' => $_W['openid']), array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
					$mobile = pdo_fetch("select * from" . tablename("guamai") . " where id='" . $_GPC['id'] . "'");
					$mobile = substr($mobile['openid'], -11);

					com('sms')->send_zhangjun2($mobile, $_GPC['id'], "订单已被抢单成功！请在有效时间内及时查看");
					if ($result) show_json(1, "抢单成功");
				}
			} else if ($type == 1) {  //卖出

				if ($op == 1) {	//买入订单  挂单人付钱
					// dump($op);die;
					$result = pdo_update("guamai", array('file' => $_GPC['file']), array('uniacid' => $_W['uniacid'], 'id' => $id));

					com('sms')->send_zhangjun2($sell['mobile'], $id, "对方已付款成功,请及时确认.");

					if ($result) show_json(1, "挂单人付款成功");
				} else {

					$id = $_GPC['id'];
					$op = $_GPC['op'];
					//判断该用户是否有足够的币进行抢单
					$member = m('member')->getMember($_W['openid'], true);
					$sell = pdo_fetch("select g.trx,g.openid,m.mobile,m2.mobile as mobile2 from" . tablename("guamai") . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid ' . ' left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2 ' . " where g.uniacid=" . $_W['uniacid'] . " and g.id='$id' and g.type=0");
					//    var_dump($sell['openid']);
					//    var_dump($_W['openid']);
					//    exit;
					if ($guamai_nums >= 1) {
						show_json(-1, "您还有订单尚未处理或还在交易中,请先进行交易！");
					}
					//判断该会员是否上传收款信息
					if (!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])) {
						show_json(-1, "请上传您的收款信息");
					}
					if ($member['credit2'] < $sell['trx']) {
						show_json(-1, "您的ETH不足，请尽快投资！");
					}
					//币足够的时候进行抢单  （扣币）
					$apple_time = time() + 1800;
					m('member')->setCredit($_W['openid'], 'credit2', -$sell['trx']);
					$result = pdo_update("guamai", array('status' => 1, 'openid2' => $_W['openid'], 'createtime' => time(), 'apple_time' => $apple_time), array('uniacid' => $_W['uniacid'], 'id' => $id));
					// dump($sell['mobile']);die;
					com('sms')->send_zhangjun2($sell['mobile'], $_GPC['id'], "订单已被抢单成功！请在有效时间内及时查看");

					show_json(1, "抢单成功");
				}
			}
			// else if($type==2){//卖出
			// 	$id = $_GPC['id'];

			// 	$op = $_GPC['op'];
			// 	//判断该用户是否有足够的币进行抢单
			// 	$member = m('member')->getMember($_W['openid'], true);
			// 	$sell = pdo_fetch("select g.trx2,m.mobile,m2.mobile as mobile2 from".tablename("guamai").' g left join '.tablename('ewei_shop_member').' m ON m.openid=g.openid '.' left join '.tablename('ewei_shop_member').' m2 ON m2.openid=g.openid2 '." where g.uniacid=".$_W['uniacid']." and g.id='$id' and g.type=1");
			// 	// dump($sell);
			// 	// dump($op);
			// 	if($op == 1){	//买入订单  挂单人付钱
			// 		$result = pdo_update("guamai",array('file'=>$_GPC['file']),array('uniacid'=>$_W['uniacid'],'id'=>$id));

			// 		com('sms')->send_zhangjun2($sell['mobile'], $id,"对方已付款成功,请及时确认.");

			// 		if($result) show_json(1,"挂单人付款成功");

			// 	}else{
			// 		if($guamai_nums >= 1)
			// 		{
			// 			show_json(-1,"您还有订单尚未处理或还在交易中,请先进行交易！");
			// 		}
			// 		//判断该会员是否上传收款信息
			// 		if(!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])){
			// 			if($result) show_json(-1,"请上传您的收款信息");
			// 		}
			// 		if($member['credit2']<$sell['trx']){
			// 			if($result) show_json(-1,"您的ETH不足，请尽快投资！");
			// 		}
			// 		//币足够的时候进行抢单  （扣币）
			// 		$apple_time = time()+1800;
			// 		m('member')->setCredit($_W['openid'],'credit2',-$sell['trx']);
			// 		$result = pdo_update("guamai",array('status'=>1,'openid2'=>$_W['openid'],'createtime'=>time(),'apple_time'=>$apple_time),array('uniacid'=>$_W['uniacid'],'id'=>$id));

			// 		com('sms')->send_zhangjun2($sell['mobile'], $id,"买入订单被抢单！");

			// 		if($result) show_json(1,"抢单成功");
			// 	}
			// }


		}

		// var_dump($sell);
		include $this->template();
	}

	//卖出的确认收款
	public function selloutyes()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {

			$id = $_GPC['selloutyes'];
			$type = $_GPC['type'];

			if ($type == 1) {		     	//卖出订单挂单人点击确认收款
				$sell = pdo_fetch("select g.*,m.mobile,m2.mobile as mobile2,m2.openid as openid2,m.credit2,m2.credit2 as credit22 from" . tablename('guamai') . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2 ' . " where g.uniacid=" . $_W['uniacid'] . " and g.id='$id'");
				// show_json($sell);
				$credit2 = $sell['credit2'] - $sell['trx2'];
				//判断该用户是否有足够的币进行抢单
				$member = m('member')->getMember($sell['openid'], true);
				//判断该会员是否上传收款信息
				if (!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])) {
					show_json(-1, "请上传您的收款信息");
				}
				// if($member['credit2']<$sell['trx']){
				// 	show_json(-1,"您的ETH不足，请尽快投资！");
				// }
				$ETH = $sell['credit22'] + $sell['trx'];
				//给抢单人充币
				pdo_update("guamai", array('status' => 2, 'endtime' => time()), array('uniacid' => $_W['uniacid'], 'id' => $id));
				pdo_update("ewei_shop_member", array("credit2" => $ETH), array("openid" => $sell['openid2']));
				com('sms')->send_zhangjun2($sell['mobile2'], $id, "对方已确认收款并放币,请注意查看.");
				$data_member_array_log = array('uniacid' => 12, 'openid' => $sell['openid2'], 'type' => 5, 'title' => "自由账户C2C交易增加" . $sell['trx'], 'money' => $sell['trx'], 'money1' => $sell['trx'], 'money2' => $sell['credit22'], 'RMB' => $sell['money'], 'typec2c' => $sell['type'], 'createtime' => time());
				$data_member_array_log['front_money'] = $sell['credit22'];
				$data_member_array_log['after_money'] = $ETH;
				pdo_insert("ewei_shop_member_log", $data_member_array_log);
				show_json(1, "订单完成");
			} else if ($type == 2) {			//买入订单抢单人点击确认收款
				$sell = pdo_fetch("select g.*,m.mobile,m2.mobile as mobile2,m.credit2,m2.credit2 as credit22 from" . tablename('guamai') . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2 ' . " where g.uniacid=" . $_W['uniacid'] . " and g.id='$id'");
				// show_json($sell);
				$ETH = $sell['credit2'] + $sell['trx'] - $sell['sxf0'];
				$credit2 = $sell['credit22'] - $sell['trx'];
				//判断该用户是否有足够的币进行抢单
				$member = m('member')->getMember($sell['openid2'], true);
				// dump($member['credit2']);die;
				//判断该会员是否上传收款信息
				if (!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])) {
					show_json(-1, "请上传您的收款信息");
				}
				// if($member['credit2']<$sell['trx']){
				// 	show_json(-1,"您的ETH不足，请尽快投资！");
				// }
				//给挂单人充币
				pdo_update("guamai", array('status' => 2, 'endtime' => time()), array('uniacid' => $_W['uniacid'], 'id' => $id));
				pdo_update("ewei_shop_member", array("credit2" => $ETH), array("openid" => $sell['openid']));
				// pdo_update("ewei_shop_member",array("credit2"=>$credit2),array("openid"=>$sell['openid2']));
				com('sms')->send_zhangjun2($sell['mobile'], $id, "对方已确认收款并放币,请注意查看.");

				//加币记录
				$money1 = $sell['trx'] - $sell['sxf0'];
				$data_member_log = array('uniacid' => 12, 'openid' => $sell['openid'], 'type' => 5, 'title' => "自由账户C2C交易添加" . $money1, 'money' => $sell['trx'], 'money1' => $money1, 'money2' => $sell['credit2'], 'RMB' => $sell['money'], 'typec2c' => $sell['type'], 'createtime' => time());
				$data_member_log['front_money'] = $sell['credit2'];
				$data_member_log['after_money'] = $ETH;
				pdo_insert("ewei_shop_member_log", $data_member_log);
				//减币记录
				$data_member_array_log = array('uniacid' => 12, 'openid' => $sell['openid2'], 'type' => 5, 'title' => "自由账户C2C交易减少" . $sell['trx'], 'money' => $sell['trx'], 'money1' => $sell['trx'], 'money2' => $sell['credit22'], 'RMB' => $sell['money'], 'typec2c' => $sell['type'], 'createtime' => time());
				$data_member_array_log['front_money'] = $sell['credit22'];
				$data_member_array_log['after_money'] = $credit2;
				pdo_insert("ewei_shop_member_log", $data_member_array_log);
				show_json(1, "订单完成");
			}
		}
	}
}
