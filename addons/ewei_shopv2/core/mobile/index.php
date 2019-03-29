<?php
if (!(defined('IN_IA')))
{
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

		$member = m('member')->getMember($_W['openid'], true);

		$sys = pdo_fetch("select give from ".tablename("ewei_shop_sysset")."where uniacid=".$_W['uniacid']);
		$openid = $_W['openid'];
		//获取该会员最高的投资倍率
        $arr1 = pdo_fetch("select max(section) as section from ".tablename("ewei_shop_member_log")."where uniacid=".$_W['uniacid']." and openid='$openid'");

        //最高倍率相应的释放比例
        $result  = pdo_fetch("select * from ".tablename("ewei_shop_commission_level4")."where uniacid=:uniacid and id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$arr1['section']));

        //释放的比例
        $proportion = $result['commission1']+$result['commission2'];

        //上一次的开奖号
        $sale = pdo_fetch("select price,numberis from".tablename("ewei_shop_lottery2")."where uniacid=".$_W['uniacid']);

        if(!$proportion) $proportion = '0.3';

      	//幻灯片数据
      	$slide = pdo_fetchall("select * from ".tablename("ewei_shop_adv")."where uniacid=".$_W['uniacid']." and enabled='1' ");
      	// var_dump($slide);

      	//公告数据
      	$notice = pdo_fetchall("select * from ".tablename("ewei_shop_notice")."where uniacid=".$_W['uniacid']." and status='1' ");
      	// var_dump($notice);

		if (!(empty($mid)))
		{
			$index_cache = preg_replace_callback('/href=[\\\'"]?([^\\\'" ]+).*?[\\\'"]/', function($matches) use($mid)
			{
				$preg = $matches[1];
				if (strexists($preg, 'mid='))
				{
					return 'href=\'' . $preg . '\'';
				}
				if (!(strexists($preg, 'javascript')))
				{
					$preg = preg_replace('/(&|\\?)mid=[\\d+]/', '', $preg);
					if (strexists($preg, '?'))
					{
						$newpreg = $preg . '&mid=' . $mid;
					}
					else
					{
						$newpreg = $preg . '?mid=' . $mid;
					}
					return 'href=\'' . $newpreg . '\'';
				}
			}
			, $index_cache);
		}
		$shop_data = m('common')->getSysset('shop');
		$cpinfos = com('coupon')->getInfo();
		include $this->template();
	}

	//首页信息
	public function homeinfo(){
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($_W['openid']){
			$member = m('member')->getMember($_W['openid'], true);
			$id = $member['id'];
		}
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}

		$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $endToday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

		//投资总额
		$arr1 = pdo_fetch("select sum(money) as money from".tablename("ewei_shop_member_log")."where uniacid=".$_W['uniacid']." and openid=:openid and type in(1,2) and status=1 ",array(':openid'=>$_W['openid']));

		//总收益
		$arr2 = pdo_fetch("select sum(money) as money,sum(money2) as money2 from".tablename("ewei_shop_order_goods1")."where uniacid=".$_W['uniacid']." and openid=:openid",array(':openid'=>$_W['openid']));

		//释放总积分
		$jifensum = pdo_fetch("select sum(money) as money,sum(money2) as money2 from".tablename("ewei_shop_receive_hongbao")."where uniacid=".$_W['uniacid']." and openid=:openid",array(':openid'=>$_W['openid']));

		//今日总收益
		$arr3 = pdo_fetch("select sum(money) as money,sum(money2) as money2 from".tablename("ewei_shop_order_goods1")."where uniacid=".$_W['uniacid']." and openid=:openid and createtime>'$beginToday' and createtime<'$endToday' ",array(':openid'=>$_W['openid']));

		//今日总积分
		$jifen = pdo_fetch("select sum(money) as money,sum(money2) as money2 from".tablename("ewei_shop_receive_hongbao")."where uniacid=".$_W['uniacid']." and openid=:openid and time>'$beginToday' and time<'$endToday'",array(':openid'=>$_W['openid']));

		//团队下级
		$ass = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = ' . $_W['uniacid']);

		$arr4 = m('common')->memberxiaji($ass,$id);

		$data = array('status'=>1,'touzimoney'=>number_format($arr1['money'],6),'shouyimoneysum'=>number_format($arr2['money']+$arr2['money2']+$jifensum['money']+$jifensum['money2'],6),'shouyimoney'=>number_format($arr3['money']+$arr3['money2']+$jifen['money']+$jifen['money2'],6),'money'=>number_format($memberis['credit2']+$memberis['credit4'],6),'xiaji'=>count($arr4));

		echo json_encode($data);

	}

	public function lunbo(){
		global $_W;
		global $_GPC;
		// $id = $_GPC['id'];
		// if($id){
		// 	$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
		// 	$_W['openid'] = $memberis['openid'];
		// }else{
		// 	$data = array('status'=>0,"fail"=>"请上传会员的id");
		// 	echo json_encode($data);exit();
		// }

		if ($_W['ispost']) {

			$slide = pdo_fetchall("select * from ".tablename("ewei_shop_adv")."where uniacid=".$_W['uniacid']." and enabled='1' ");
			$data = array('status'=>1,'list'=>$slide);
			echo json_encode($data);
		}
	}

	public function notice(){
		global $_W;
		global $_GPC;
		if ($_W['ispost']) {

			$notice = pdo_fetchall("select * from ".tablename("ewei_shop_notice")."where uniacid=".$_W['uniacid']." and status='1' ");
			$data = array('status'=>1,'list'=>$notice);
	        echo json_encode($data);
		}
	}

	public function trx(){
		global $_W;
		global $_GPC;
		// com('sms')->send_zhangjun2("17671252557", "105","卖出订单抢单完成！");
		if ($_W['ispost']) {
			$id = $_GPC['id'];

			$member = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			if(!$member){
				$data = array('status'=>0,"fail"=>"该会员不存在！");
				echo json_encode($data);exit();
			}
		   $data = array('status'=>1,'list'=>array('trx'=>$member['credit1']));
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
		$defaults = array( 'adv' => array('text' => '幻灯片', 'visible' => 1), 'search' => array('text' => '搜索栏', 'visible' => 1), 'nav' => array('text' => '导航栏', 'visible' => 1), 'notice' => array('text' => '公告栏', 'visible' => 1), 'cube' => array('text' => '魔方栏', 'visible' => 1), 'banner' => array('text' => '广告栏', 'visible' => 1), 'goods' => array('text' => '推荐栏', 'visible' => 1) );
		$sorts = ((isset($_W['shopset']['shop']['indexsort']) ? $_W['shopset']['shop']['indexsort'] : $defaults));
		$sorts['recommand'] = array('text' => '系统推荐', 'visible' => 1);
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_adv') . ' where uniacid=:uniacid and iswxapp=0 and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$navs = pdo_fetchall('select id,navname,url,icon from ' . tablename('ewei_shop_nav') . ' where uniacid=:uniacid and iswxapp=0 and status=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$cubes = ((is_array($_W['shopset']['shop']['cubes']) ? $_W['shopset']['shop']['cubes'] : array()));
		$banners = pdo_fetchall('select id,bannername,link,thumb from ' . tablename('ewei_shop_banner') . ' where uniacid=:uniacid and iswxapp=0 and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$bannerswipe = $_W['shopset']['shop']['bannerswipe'];
		if (!(empty($_W['shopset']['shop']['indexrecommands'])))
		{
			$goodids = implode(',', $_W['shopset']['shop']['indexrecommands']);
			if (!(empty($goodids)))
			{
				$indexrecommands = pdo_fetchall('select id, title, thumb, marketprice,ispresell,presellprice, productprice, minprice, total from ' . tablename('ewei_shop_goods') . ' where id in( ' . $goodids . ' ) and uniacid=:uniacid and status=1 order by instr(\'' . $goodids . '\',id),displayorder desc', array(':uniacid' => $uniacid));
				foreach ($indexrecommands as $key => $value )
				{
					if (0 < $value['ispresell'])
					{
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
}
?>
