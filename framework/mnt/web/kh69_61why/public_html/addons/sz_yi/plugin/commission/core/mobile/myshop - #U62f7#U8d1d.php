<?php
/**
 * 我的小店首页
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.cocogd.com.cn)
 * @license    http://www.cocogd.com.cn
 * @link       http://www.cocogd.com.cn
 * @since      File available since Release v1.1
 */
 
global $_W, $_GPC;
$mid     = intval($_GPC['mid']);
$openid  = m('user')->getOpenid();
$member  = m('member')->getMember($openid);
$set     = $this->set;
$uniacid = $_W['uniacid'];
if (!empty($mid)) {
	if (!$this->model->isAgent($mid)) {
		header('location: ' . $this->createMobileUrl('shop'));
		exit;
	}
	if ($mid != $member['id']) {
		if ($member['isagent'] == 1 && $member['status'] == 1) {
			if (!empty($set['closemyshop'])) {
				$shopurl = $this->createMobileUrl('shop', array('mid' => $member['id']));
			} else {
				$shopurl = $this->createPluginMobileUrl('commission/myshop', array('mid' => $member['id']));
			}
			header('location: ' . $shopurl);
			exit;
		} else {
			if (!empty($set['closemyshop'])) {
				$shopurl = $this->createMobileUrl('shop', array('mid' => $mid));
				header('location: ' . $shopurl);
				exit;
			}
		}
	} else {
		if (!empty($set['closemyshop'])) {
			$shopurl = $this->createMobileUrl('shop', array('mid' => $member['id']));
			header('location: ' . $shopurl);
			exit;
		}
	}
} else {
	if ($member['isagent'] == 1 && $member['status'] == 1) {
		$mid = $member['id'];
		if (!empty($set['closemyshop'])) {
			$shopurl = $this->createMobileUrl('shop');
			header('location: ' . $shopurl);
			exit;
		}
	} else {
		header('location: ' . $this->createMobileUrl('shop'));
		exit;
	}
}

/*店标、店名、店主*/
$set = set_medias(m('common')->getSysset('shop'), array('logo', 'img'));

$common = m("common")->getSysset(array("shop", "share")); //商城设置
$setting = $common['shop'];

$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
if ($op == 'display') {
	//广告轮换图
	$advs = pdo_fetchall('SELECT id,advname,link,thumb FROM ' . tablename('sz_yi_adv') . 
						' WHERE uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
	$advs = set_medias($advs, 'thumb');
	
	//商品分类
	$category = pdo_fetchall('SELECT id,name,thumb,parentid,level,advimg,advurl FROM ' . tablename('sz_yi_category') . 
							' WHERE uniacid=:uniacid and parentid=0 and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
	$category = set_medias($category, 'thumb');
	foreach ($category as &$c) {
		$c['advimg'] = tomedia($c['advimg']);
		if( $c['advurl'] )
		{
			$c['url'] = $c['advurl'];
		}
		else
		{
			if ($c['level'] == 3) {
				$c['url'] = $this->createMobileUrl('shop/category', array('tcate' => $c['id']));
			} else if ($c['level'] == 2) {
				$c['url'] = $this->createMobileUrl('shop/category', array('ccate' => $c['id']));
			} else if ($c['level'] == 1) {
				$c['url'] = $this->createMobileUrl('shop/category', array('ccate' => $c['id']));
			}
		}
	}
	unset($c);

	//店主推荐
	//$recommend = pdo_fetchall('SELECT * FROM ' . tablename('sz_yi_goods') . 
			//' WHERE uniacid=:uniacid AND istime=1 AND status=1 AND deleted=0 '.
			//' ORDER BY displayorder DESC', array(':uniacid' => $uniacid));
			
	//注册会员总数
	$members = pdo_fetch('SELECT count(*) as count FROM ' . tablename('sz_yi_member') . 
						' WHERE uniacid=:uniacid LIMIT 1 ', array(':uniacid' => $uniacid));
	for($i=0; $i < strlen($members['count']); $i++)
	{	
		$j=$i+1;
		$number = substr($members['count'],$i,$j);
		$membercount .=  '<span class="var">'.$number.'</span>';
	}		
	
	//限时卖
	$timespike = pdo_fetchall('SELECT id,thumb,title,marketprice,productprice,timestart,timeend FROM ' . tablename('sz_yi_goods') . 
					          ' WHERE uniacid=:uniacid AND istime=1 AND status=1 AND deleted=0 AND timeend > '. time() .''.
					          ' ORDER BY displayorder DESC', array(':uniacid' => $uniacid));
	foreach($timespike as $key => $value)
	{
		$alltime = $value['timeend'] - $value['timestart'];//促销时间=结束时间-开始时间
		$surplus = $value['timeend'] - time();//剩余时间=结束时间-当前时间
		$elapsed = $value['timestart'] - time();//消逝时间=开始时间-当前时间
		
		$timespike[$key]['duration'] = $surplus*1000;//（时间的）持续，持久，连续
		$timespike[$key]['distance'] = $alltime*1000;//（时间的）间隔，长久;
		$timespike[$key]['elapsed']  = $elapsed*1000;//消逝时间
		$timespike[$key]['nowtime'] = time();//当前时间
	}
	
	//即将开始计算时间
	$latelyspike = pdo_fetch('SELECT timestart,timeend FROM ' . tablename('sz_yi_goods') . 
							' WHERE uniacid=:uniacid AND isrecommand=1 AND status=1 AND deleted=0 AND timestart > ' . time() . 
							' ORDER BY timestart DESC LIMIT 1 ', array(':uniacid' => $uniacid));
	$latelyspike['duration'] = ($latelyspike['timeend'] - time());//（时间的）持续，持久，连续
	$latelyspike['distance'] = ($latelyspike['timeend'] - $latelyspike['timestart']);//（时间的）间隔，长久;
	$latelyspike['elapsed']  = ($latelyspike['timestart'] - time());//消逝时间
	
	if ($_W['isajax']) {
		if (empty($shop['selectgoods'])) {
			$goodscount = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_goods') . ' where uniacid=:uniacid and status=1 and deleted=0', array(':uniacid' => $_W['uniacid']));
		} else {
			$goodscount = count(explode(",", $shop['goodsids']));
		}
		$advs = pdo_fetchall("select id,advname,link,thumb from " . tablename('sz_yi_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$advs = set_medias($advs, 'thumb');
		$ret = array('shop' => $shop, 'goodscount' => number_format($goodscount, 0), 'set' => m('common')->getSysset('shop'), 'advs' => $advs);
		$ret['isme'] = $mid == $member['id'];
		show_json(1, $ret);
	}
	$_W['shopshare'] = array('title' => $shop['name'], 'imgUrl' => $shop['logo'], 'desc' => $shop['desc'], 'link' => $this->createMobileUrl('shop'));
	if ($member['isagent'] == 1 && $member['status'] == 1) {
		$_W['shopshare']['link'] = $this->createPluginMobileUrl('commission/myshop', array('mid' => $member['id']));
		if (empty($this->set['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
			$trigger = true;
		}
	} else if (!empty($mid)) {
		$_W['shopshare']['link'] = $this->createPluginMobileUrl('commission/myshop', array('mid' => $_GPC['mid']));
	}
	$this->setHeader();
	include $this->template('myshop');
} 


else if ($op == 'goods') 
{
	if ($_W['isajax']) {
		$args = array('page' => $_GPC['page'], 'pagesize' => 6, 'order' => 'displayorder desc,createtime desc', 'by' => '');
		if (!empty($shop['selectgoods'])) {
			$goodsids = explode(',', $shop['goodsids']);
			if (!empty($goodsids)) {
				$args['ids'] = trim($shop['goodsids']);
			}
		}
		$goods = m('goods')->getList($args);
		show_json(1, array('goods' => $goods, 'pagesize' => $args['pagesize']));
	}
} 

//我的小店设置
else if ($op == 'set') {
	if ($_W['isajax']) {
		if ($_W['ispost']) {
			//提交数据
			$shopdata = is_array($_GPC['shopdata']) ? $_GPC['shopdata'] : array();
			$shopdata['uniacid'] = $_W['uniacid'];
			$shopdata['mid'] = $member['id'];
			if (empty($shop['id'])) {
				pdo_insert('sz_yi_commission_shop', $shopdata);
			} else {
				pdo_update('sz_yi_commission_shop', $shopdata, array('id' => $shop['id']));
			}
			show_json(1);
		}
		//小店显示
		$shop = pdo_fetch('select * from ' . tablename('sz_yi_commission_shop') . ' where uniacid=:uniacid and mid=:mid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));
		$shop = set_medias($shop, array('img', 'logo'));
		$openselect = false;
		if ($this->set['select_goods'] == '1') {
			if (empty($member['agentselectgoods']) || $member['agentselectgoods'] == 2) {
				$openselect = true;
			}
		} else {
			if ($member['agentselectgoods'] == 2) {
				$openselect = true;
			}
		}
		$shop['openselect'] = $openselect;
		show_json(1, array('shop' => $shop));
	}
	include $this->template('myshop_set');
	
} 
//
else if ($op == 'select') {
	if ($_W['isajax']) {
		if ($member['agentselectgoods'] == 1) {
			show_json(-1, '您无权自选商品，请和运营商联系!');
		}
		if (empty($this->set['select_goods'])) {
			if ($member['agentselectgoods'] != 2) {
				show_json(-1, '系统未开启自选商品!');
			}
		}
		$shop = pdo_fetch('select * from ' . tablename('sz_yi_commission_shop') . ' where uniacid=:uniacid and mid=:mid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));
		if ($_W['ispost']) {
			$shopdata['selectgoods'] = intval($_GPC['selectgoods']);
			$shopdata['selectcategory'] = intval($_GPC['selectcategory']);
			$shopdata['uniacid'] = $_W['uniacid'];
			$shopdata['mid'] = $member['id'];
			if (is_array($_GPC['goodsids'])) {
				$shopdata['goodsids'] = implode(",", $_GPC['goodsids']);
			}
			if (!empty($shopdata['selectgoods']) && !is_array($_GPC['goodsids'])) {
				show_json(0, '请选择商品!');
			}
			if (empty($shop['id'])) {
				pdo_insert('sz_yi_commission_shop', $shopdata);
			} else {
				pdo_update('sz_yi_commission_shop', $shopdata, array('id' => $shop['id']));
			}
			show_json(1);
		}
		$goods = array();
		if (!empty($shop['selectgoods'])) {
			$goodsids = explode(',', $shop['goodsids']);
			if (!empty($goodsids)) {
				$goods = pdo_fetchall('select id,title,marketprice,thumb from ' . tablename('sz_yi_goods') . ' where uniacid=:uniacid and id in ( ' . trim($shop['goodsids']) . ')', array(':uniacid' => $_W['uniacid']));
				$goods = set_medias($goods, 'thumb');
			}
		}
		show_json(1, array('shop' => $shop, 'goods' => $goods));
	}
	$set = m('common')->getSysset('shop');
	include $this->template('myshop_select');
}
