<?php
/**
 * 微信端/手机端首页
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.cocogd.com.cn)
 * @license    http://www.cocogd.com.cn
 * @link       http://www.cocogd.com.cn
 * @since      File available since Release v1.1
 */
 
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$openid    = m('user')->getOpenid();
$uniacid   = $_W['uniacid'];
$designer  = p('designer');

if ($designer) {
	$pagedata = $designer->getPage();
	/*自定义首页*/
	if ($pagedata) {
		extract($pagedata);
		$guide = $designer->getGuide($system, $pageinfo);
		$_W['shopshare'] = array('title' => $share['title'], 'imgUrl' => $share['imgUrl'], 'desc' => $share['desc'], 'link' => $this->createMobileUrl('shop'));
		if (p('commission')) {
			$set = p('commission')->getSet();
			if (!empty($set['level'])) {
				$member = m('member')->getMember($openid);
				if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
					$_W['shopshare']['link'] = $this->createMobileUrl('shop', array('mid' => $member['id']));
					if (empty($set['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
						$trigger = true;
					}
				} else if (!empty($_GPC['mid'])) {
					$_W['shopshare']['link'] = $this->createMobileUrl('shop', array('mid' => $_GPC['mid']));
				}
			}
		}
		include $this->template('shop/index_diy');
		exit; 
	}
}

/*店标、店名、店主*/
$set = set_medias(m('common')->getSysset('shop'), array('logo', 'img'));

$common = m("common")->getSysset(array("shop", "share")); //商城设置
$setting = $common['shop'];

$uid = $_GPC['__uid'];
if( $uid || $openid )
{
	//我的小店
	if($uid)
	{
		$mystore = pdo_fetch('SELECT id,uid,isagent,nickname,avatar FROM ' . tablename('sz_yi_member') . ' WHERE uniacid=:uniacid and uid=:uid LIMIT 1 ', array(':uniacid' => $uniacid, ':uid' => $uid));
	}
	else
	{
		$mystore = pdo_fetch('SELECT id,uid,isagent,nickname,avatar FROM ' . tablename('sz_yi_member') . ' WHERE uniacid=:uniacid and openid=:openid LIMIT 1 ', array(':uniacid' => $uniacid, ':openid' => $openid));
	}
	if( $mystore['isagent'] )
	{
		//已经申请代理商
		$set['name'] = $mystore['nickname'] . '的小店';
		$set['logo'] = $mystore['avatar'];
	}
	$uid = $mystore['uid'] ? $mystore['uid'] : $mystore['id'];
}

//模板
$template_shop = m("cache")->getString("template_shop");
if($template_shop == 'haioo' && $mystore['isagent'] )
{
	//跳转
	$mid = $_GPC["mid"] ? $_GPC["mid"] : $uid;
	//$url = "http://wx.aicnmm.com/app/index.php?i=1&c=entry&method=myshop&p=commission&mid=1&m=sz_yi&do=plugin";
	$url = "index.php?i={$_W['uniacid']}&c=entry&method=myshop&p=commission&m=sz_yi&mid=".$mid."&do=plugin";
	//header('Location: '.$url);
}


//广告轮换图
$advs = pdo_fetchall('SELECT id,advname,link,thumb FROM ' . tablename('sz_yi_adv') . ' WHERE uniacid=:uniacid AND enabled=1 ORDER BY displayorder DESC', array(':uniacid' => $uniacid));
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
	if ($operation == 'index') {
		//广告图
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('sz_yi_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$advs = set_medias($advs, 'thumb');
		//产品分类
		$category = pdo_fetchall('select id,name,thumb,parentid,level from ' . tablename('sz_yi_category') . ' where uniacid=:uniacid and ishome=1 and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$category = set_medias($category, 'thumb');
		foreach ($category as &$c) {
			$c['thumb'] = tomedia($c['thumb']);
			if ($c['level'] == 3) {
				$c['url'] = $this->createMobileUrl('shop/list', array('tcate' => $c['id']));
			} else if ($c['level'] == 2) {
				$c['url'] = $this->createMobileUrl('shop/list', array('ccate' => $c['id']));
			}
		}
		unset($c);
		show_json(1, array('set' => $set, 'advs' => $advs, 'category' => $category));
	} else if ($operation == 'goods') {
		//
		$type = $_GPC['type'];
		$args = array('page' => $_GPC['page'], 'pagesize' => 6, 'isrecommand' => 1, 'order' => 'displayorder desc,createtime desc', 'by' => '');
		$goods = m('goods')->getList($args);
		show_json(1, array('goods' => $goods, 'pagesize' => $args['pagesize']));
	}
}
$this->setHeader();

if($template_shop == 'vellgo')
{
	$goods = pdo_fetchall('select id,title,thumb,marketprice,status from ' . tablename('sz_yi_goods') . ' where uniacid=:uniacid  and status=1 order by displayorder desc', array(':uniacid' => $uniacid));
	$goodscount = count($goods);
	if( $goodscount <= 1)
	{
		include $this->template('shop/detail');
		exit;
	}
}

include $this->template('shop/index');
