<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}
class Index_EweiShopV2Page extends MobilePage
{
	public function main()
	{

		global $_W;
		global $_GPC;
		$_SESSION['newstoreid'] = 0;
		$this->diypage('home');
		$uniacid = $_W['uniacid'];
		$mid = intval($_GPC['mid']);
		$index_cache = $this->getpage();
		$q = $_GPC['q'];
		
		$member = m('member')->getMember($_W['openid'], true);

		$sys = pdo_fetch("select give from " . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		$openid = $_W['openid'];
		//获取该会员最高的投资倍率
		$arr1 = pdo_fetch("select max(section) as section from " . tablename("ewei_shop_member_log") . "where uniacid=" . $_W['uniacid'] . " and openid='$openid'");

		//最高倍率相应的释放比例
		$result  = pdo_fetch("select * from " . tablename("ewei_shop_commission_level4") . "where uniacid=:uniacid and id=:id", array(':uniacid' => $_W['uniacid'], ':id' => $arr1['section']));

		//释放的比例
		$proportion = $result['commission1'] + $result['commission2'];

		//上一次的开奖号
		$sale = pdo_fetch("select price,numberis from" . tablename("ewei_shop_lottery2") . "where uniacid=" . $_W['uniacid']);

		if (!$proportion) $proportion = '0.3';

		//幻灯片数据
		$slide = pdo_fetchall("select * from " . tablename("ewei_shop_adv") . "where uniacid=" . $_W['uniacid'] . " and enabled='1' ");
		// var_dump($slide);

		//公告数据
		$notice = pdo_fetchall("select * from " . tablename("ewei_shop_notice") . "where uniacid=" . $_W['uniacid'] . " and status='1' ");
		// var_dump($notice);

		if (!(empty($mid))) {
			$index_cache = preg_replace_callback(
				'/href=[\\\'"]?([^\\\'" ]+).*?[\\\'"]/',
				function ($matches) use ($mid) {
					$preg = $matches[1];
					if (strexists($preg, 'mid=')) {
						return 'href=\'' . $preg . '\'';
					}
					if (!(strexists($preg, 'javascript'))) {
						$preg = preg_replace('/(&|\\?)mid=[\\d+]/', '', $preg);
						if (strexists($preg, '?')) {
							$newpreg = $preg . '&mid=' . $mid;
						} else {
							$newpreg = $preg . '?mid=' . $mid;
						}
						return 'href=\'' . $newpreg . '\'';
					}
				},
				$index_cache
			);
		}
		$shop_data = m('common')->getSysset('shop');
		$cpinfos = com('coupon')->getInfo();

		if($q){

			

			if($_W['openid']){
				$data = $this->homeinfo($q);
				$data = $data['data'];
			}

			$data['touziimg'] = MODULE_URL . 'static/icon/touzhi.png';
			$data['touzititle'] = '投资总额';

			$data['shouyisumimg'] = MODULE_URL . 'static/icon/zhongshouyi.png';
			$data['shouyisumtitle'] = '总收益';

			$data['shouyiimg'] = MODULE_URL . 'static/icon/jinri.png';
			$data['shouyititle'] = '今日收益';

			$data['moneyimg'] = MODULE_URL . 'static/icon/qianbao.png';
			$data['moneytitle'] = '钱包余额';

			$data['jihuoimg'] = MODULE_URL . 'static/icon/jihuo.png';
			$data['jihuotitle'] = '激活账户';

			$data['xiajiimg'] = MODULE_URL . 'static/icon/tuandui.png';
			$data['xiajititle'] = '团队';
			
			// $menu['index']['url'] = empty($_GPC['merchid']) ? mobileUrl() : mobileUrl('merch');
			$menu['index']['title'] = '首页';
			$menu['index']['img'] =  ( $_W['routes']=='' ||  $_W['routes']=='shop' ||  $_W['routes']=='commission.myshop' ) ? MODULE_URL . 'static/icon/shouye1.png' : MODULE_URL . 'static/icon/shouye0.png';
			
			// $menu['qipai']['url'] = mobileUrl('member/qipai');
			$menu['qipai']['title'] = '棋牌娱乐';
			$menu['qipai']['img'] = $_W['routes'] =='member.qipai' ? MODULE_URL . 'static/icon/qipaiyule1.png' : MODULE_URL . 'static/icon/qipaiyule0.png';

			// $menu['guamai']['url'] = mobileUrl('member/guamai');
			$menu['guamai']['title'] = 'C2C';
			$menu['guamai']['img'] = $_W['routes'] =='member.guamai' ? MODULE_URL . 'static/icon/C2C1.png' : MODULE_URL . 'static/icon/C2C0.png';

			// $menu['member']['url'] = mobileUrl('member/member');
			$menu['member']['title'] = '我的';
			$menu['member']['img'] = $_W['routes'] =='member' ? MODULE_URL . 'static/icon/wode1.png' : MODULE_URL . 'static/icon/wode0.png';
			
			
			returnJson(['slide'=>$slide,'data'=>$data,'notice'=>$notice,'menu'=>$menu]);
		}

		include $this->template();
	}

	//首页信息
	public function homeinfo($q='')
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if ($_W['openid'] == "") {
			$_GPC['openid'] = $_GPC['openid'];
		} else {
			$_GPC['openid'] = $_W['openid'];
		}

		if ($_GPC['openid']) {
			$member = m('member')->getMember($_GPC['openid'], true);
			$id = $member['id'];
		}
		if ($id) {
			$memberis = pdo_fetch("select * from " . tablename("ewei_shop_member") . "where uniacid=" . $_W['uniacid'] . " and id='$id'");
			$_GPC['openid'] = $memberis['openid'];
		} else {
			$data = array('status' => 0, "msg" => "请上传会员的id");
			echo json_encode($data);
			exit();
		}

		$beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endToday = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;

		//投资总额
		$arr1 = pdo_fetch("select sum(money) as money from" . tablename("ewei_shop_member_log") . "where uniacid=" . $_W['uniacid'] . " and openid=:openid and type in(1,2) and status=1 ", array(':openid' => $_GPC['openid']));

		//总收益
		$arr2 = pdo_fetch("select sum(money) as money,sum(money2) as money2 from" . tablename("ewei_shop_order_goods1") . "where uniacid=" . $_W['uniacid'] . " and openid=:openid", array(':openid' => $_GPC['openid']));

		//释放总积分
		$jifensum = pdo_fetch("select sum(money) as money,sum(money2) as money2 from" . tablename("ewei_shop_receive_hongbao") . "where uniacid=" . $_W['uniacid'] . " and openid=:openid", array(':openid' => $_GPC['openid']));

		//今日总收益
		$arr3 = pdo_fetch("select sum(money) as money,sum(money2) as money2 from" . tablename("ewei_shop_order_goods1") . "where uniacid=" . $_W['uniacid'] . " and openid=:openid and createtime>'$beginToday' and createtime<'$endToday' ", array(':openid' => $_GPC['openid']));

		//今日总积分
		$jifen = pdo_fetch("select sum(money) as money,sum(money2) as money2 from" . tablename("ewei_shop_receive_hongbao") . "where uniacid=" . $_W['uniacid'] . " and openid=:openid and time>'$beginToday' and time<'$endToday'", array(':openid' => $_GPC['openid']));

		//团队下级
		$ass = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = ' . $_W['uniacid']);

		$arr4 = m('common')->memberxiaji($ass, $id);

		$data = array('status' => 1, 'msg' => '获取成功', 'data' => array('touzimoney' => number_format($arr1['money'], 6), 'shouyimoneysum' => number_format($arr2['money'] + $arr2['money2'] + $jifensum['money'] + $jifensum['money2'], 6), 'shouyimoney' => number_format($arr3['money'] + $arr3['money2'] + $jifen['money'] + $jifen['money2'], 6), 'money' => number_format($memberis['credit2'] + $memberis['credit4'], 6), 'xiaji' => count($arr4)));
		if($q){
			return $data;
		}
		echo json_encode($data);
	}

	public function xiaji()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['user_id'];
		if (empty($id)) {
			$data = array('status' => 0, "msg" => "请上传会员的id");
			echo json_encode($data);
			exit();
		}
		//团队下级
		$ass = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = 12');
		// dump($ass);
		// die;
		$arr4 = m('common')->memberxiaji($ass, $id);
		$users = [];
		foreach ($arr4 as $key => $val) {
			$users[] = pdo_fetch("select openid,id,mobile,nickname from" . tablename("ewei_shop_member") . "where id ='" . $val['id'] . "'");
		}
		if ($users) {
			$msg = "获取成功";
		} else {
			$msg = "获取失败";
		}
		$data = array('status' => 1, 'msg' => $msg, 'data' => $users);
		echo json_encode($data);
	}


	public function lunbo()
	{
		global $_W;
		global $_GPC;
		// $id = $_GPC['id'];
		// if($id){
		// 	$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
		// 	$_W['openid'] = $memberis['openid'];
		// }else{
		// $data = array('status'=>0,"fail"=>"请上传会员的id");
		// echo json_encode($data);exit();
		// }

		if ($_W['ispost']) {

			$slide = pdo_fetchall("select * from " . tablename("ewei_shop_adv") . "where uniacid=" . $_W['uniacid'] . " and enabled='1' ");
			if ($slide) {
				$msg = "获取成功";
			} else {
				$msg = "获取失败";
			}
			$data = array('status' => 1, 'msg' => $msg, 'data' => $slide);
			echo json_encode($data);
		}
	}
	/**
	 *资产记录api
	 */
	public function total_investment()
	{
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];
		// $openid = $_W['openid'];
		$openid = $_GPC['openid'];
		if ($openid == "") {
			$data = array('status' => 0, "msg" => "openid不存在！");
			echo json_encode($data);
			exit();
		}
		if ($_W['ispost']) {
			if ($type == 1) {
				$list =  pdo_fetchall("select g.openid,g.type,g.title,g.createtime,g.money,g.front_money,g.after_money,g.money1,g.money2,g.RMB,g.typec2c,m.nickname from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.openid='$openid' and g.type='$type' order by g.createtime desc");
			} else if ($type == 3) {
				$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_zhuanzhang") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.openid='$openid' order by g.createtime desc");
			} else {
				$list =  pdo_fetchall("select g.openid,g.type,g.title,g.createtime,g.money,g.front_money,g.after_money,g.money1,g.money2,g.RMB,g.typec2c,m.nickname from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.openid='$openid' order by g.createtime desc");
			}
			foreach ($list as $key => $val) {
				$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
			}
			if ($list) {
				$msg = "获取成功";
			} else {
				$msg = "获取失败";
			}

			$data = array('status' => 1, 'msg' => $msg, 'data' => $list);
			echo json_encode($data);
		}
	}

	public function notice()
	{
		global $_W;
		global $_GPC;
		if ($_W['ispost']) {

			$notice = pdo_fetchall("select * from " . tablename("ewei_shop_notice") . "where uniacid=" . $_W['uniacid'] . " and status='1' ");
			$data = array('status' => 1, 'list' => $notice);
			echo json_encode($data);
		}
	}

	public function trx()
	{
		global $_W;
		global $_GPC;
		// com('sms')->send_zhangjun2("17671252557", "105","卖出订单抢单完成！");
		if ($_W['ispost']) {
			$id = $_GPC['id'];

			$member = pdo_fetch("select * from " . tablename("ewei_shop_member") . "where uniacid=" . $_W['uniacid'] . " and id='$id'");
			if (!$member) {
				$data = array('status' => 0, "msg" => "该会员不存在！");
				echo json_encode($data);
				exit();
			}
			$data = array('status' => 1, 'list' => array('trx' => $member['credit1']));
			echo json_encode($data);
		}
	}



	public function get_recommand()
	{
		global $_W;
		global $_GPC;
		$args = array('page' => $_GPC['page'], 'pagesize' => 6, 'isrecommand' => 1, 'order' => 'displayorder desc,createtime desc', 'by' => '');
		$recommand = m('goods')->getList($args);
		show_json(1, array('list' => $recommand['list'], 'pagesize' => $args['pagesize'], 'total' => $recommand['total'], 'page' => intval($_GPC['page'])));
	}
	private function getcache()
	{
		global $_W;
		global $_GPC;
		return m('common')->createStaticFile(mobileUrl('getpage', NULL, true));
	}
	public function getpage()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$defaults = array('adv' => array('text' => '幻灯片', 'visible' => 1), 'search' => array('text' => '搜索栏', 'visible' => 1), 'nav' => array('text' => '导航栏', 'visible' => 1), 'notice' => array('text' => '公告栏', 'visible' => 1), 'cube' => array('text' => '魔方栏', 'visible' => 1), 'banner' => array('text' => '广告栏', 'visible' => 1), 'goods' => array('text' => '推荐栏', 'visible' => 1));
		$sorts = ((isset($_W['shopset']['shop']['indexsort']) ? $_W['shopset']['shop']['indexsort'] : $defaults));
		$sorts['recommand'] = array('text' => '系统推荐', 'visible' => 1);
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_adv') . ' where uniacid=:uniacid and iswxapp=0 and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$navs = pdo_fetchall('select id,navname,url,icon from ' . tablename('ewei_shop_nav') . ' where uniacid=:uniacid and iswxapp=0 and status=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$cubes = ((is_array($_W['shopset']['shop']['cubes']) ? $_W['shopset']['shop']['cubes'] : array()));
		$banners = pdo_fetchall('select id,bannername,link,thumb from ' . tablename('ewei_shop_banner') . ' where uniacid=:uniacid and iswxapp=0 and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$bannerswipe = $_W['shopset']['shop']['bannerswipe'];
		if (!(empty($_W['shopset']['shop']['indexrecommands']))) {
			$goodids = implode(',', $_W['shopset']['shop']['indexrecommands']);
			if (!(empty($goodids))) {
				$indexrecommands = pdo_fetchall('select id, title, thumb, marketprice,ispresell,presellprice, productprice, minprice, total from ' . tablename('ewei_shop_goods') . ' where id in( ' . $goodids . ' ) and uniacid=:uniacid and status=1 order by instr(\'' . $goodids . '\',id),displayorder desc', array(':uniacid' => $uniacid));
				foreach ($indexrecommands as $key => $value) {
					if (0 < $value['ispresell']) {
						$indexrecommands[$key]['minprice'] = $value['presellprice'];
					}
				}
			}
		}
		$goodsstyle = $_W['shopset']['shop']['goodsstyle'];
		$notices = pdo_fetchall('select id, title, link, thumb from ' . tablename('ewei_shop_notice') . ' where uniacid=:uniacid and iswxapp=0 and status=1 order by displayorder desc limit 5', array(':uniacid' => $uniacid));
		$seckillinfo = plugin_run('seckill::getTaskSeckillInfo');
		ob_start();
		ob_implicit_flush(false);
		require $this->template('index_tpl');
		return ob_get_clean();
	}
	public function seckillinfo()
	{
		$seckillinfo = plugin_run('seckill::getTaskSeckillInfo');
		include $this->template('shop/index/seckill_tpl');
		exit();
	}
	public function qr()
	{
		global $_W;
		global $_GPC;
		$url = trim($_GPC['url']);
		require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
		QRcode::png($url, false, QR_ECLEVEL_L, 16, 1);
	}

	public function record()
	{
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];
		if (empty($type)) {
			$data = array('status' => 0, "msg" => "请传入类型！！！");
			echo json_encode($data);
			exit();
		}
		if ($type == 4) {		//积分记录

			$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_receive_hongbao") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid  and g.openid=:openid order by g.time desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			foreach ($list as $key => $val) {
				$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['time']);
			}

			$count =  pdo_fetch("select sum(g.money) as money,sum(g.money2) as money2 from" . tablename("ewei_shop_receive_hongbao") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid  and g.openid=:openid", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			if (!$count['money'] && !$count['money2']) {
				$summoeny = 0;
			} else {
				$summoeny = $count['money'] + $count['money2'];
			}

			$data = array('status' => 1, 'msg' => '获取成功', 'data' => array('list' => $list, 'money' => $summoeny));
		} else {
			$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_order_goods1") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			foreach ($list as $key => $val) {
				$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
			}

			$count =  pdo_fetch("select sum(g.money) as money,sum(g.money2) as money2 from" . tablename("ewei_shop_order_goods1") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			$data = array('status' => 1, 'msg' => '获取成功', 'data' => array('list' => $list, 'money' => $count['money'] + $count['money2']));
		}
		echo json_encode($data);
	}
}
