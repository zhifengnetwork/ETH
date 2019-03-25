<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Lottery_EweiShopV2Page extends MobileLoginPage 
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
		$type = $_GPC['type'];
		$sale = pdo_fetch("select price,numberis,time from".tablename("ewei_shop_lottery2")."where uniacid=".$_W['uniacid']);

		include $this->template();
	}


	public function numberis(){
		//测试
		global $_W;
		global $_GPC;

		$minNum = $_GPC['minNum'];$maxNum = $_GPC['maxNum'];
		
		$op = array();
		for ($minNum; $minNum <=$maxNum ; $minNum++) { 
			$op[] = $minNum;
		}
		
		$yes = array();

		foreach ($op as $key => $val) {

				$kn = "";
				$kn .= $val;

			foreach ($op as $key => $val2) {

				$kn .=$val2;

				foreach ($op as $key => $val3) {

					$kn .=$val3;
					$yes[] = $kn;
					$kn = substr($kn, 0, -1);

				}

				$kn = substr($kn, 0, -1);		

			}

		}


		show_json(1,array('list'=>$yes));

	}

	//下注 
	public function bets(){
		global $_W;
		global $_GPC;

		if($_W['ispost']){

			$type = $_GPC['type'];

			if($type == 1){    //确认信息

				$member = m('member')->getMember($_W['openid'], true);

				$data = array('credit2'=>$member['credit2'],'credit4'=>$member['credit4']);
				
				show_json(1,array('list'=>$data));

			}else if($type == 2){  //下注

				$member = m('member')->getMember($_W['openid'], true);

				$sale = pdo_fetch("select * from".tablename("ewei_shop_lottery2")."where uniacid=".$_W['uniacid']);

				$payment = $_GPC['payment'];

				$money = $_GPC['money'];

				$list = $_GPC['list'];
				// show_json($list);

				if($payment == 1){  //TRX支付

					if($member['credit2']<$money)  show_json(-1,"您的自由账户余额不足");
					//扣除该会员的下注金额
					m('member')->setCredit($_W['openid'],'credit2',-$money);

				}else if($payment == 2){  //复投账户支付

					if($member['credit4']<$money)  show_json(-1,"您的复投账户余额");
					//扣除该会员的下注金额
					m('member')->setCredit($_W['openid'],'credit4',-$money);

				}

				foreach ($list as $key => $val) {
					$number = $val['0'];
					$data = array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid'],'number'=>"$number",'multiple'=>$val['1'],'money'=>$val['1']*$sale['price'],'createtime'=>time());
					// show_json($data);
					pdo_insert("stakejilu",$data);
				}

				pdo_update("ewei_shop_lottery2",array('sum'=>$sale['sum']+$money),array('uniacid'=>$_W['uniacid']));
				show_json(1,"下注成功");
			}

			

		}
	}

	//押注记录
	public function stakejilu(){
		global $_W;
		global $_GPC;

		include $this->template();
	}

	public function stakejiluis(){
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$openid = $_W['openid'];

		$select = 'SELECT og.id,og.money,og.createtime,og.number,og.thigh,og.multiple,og.endtime,og.lottery
				,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				 FROM ';
        $tablename = 	tablename('stakejilu').' og left join '.tablename('ewei_shop_member').' m ON m.openid=og.openid ';
        $where = ' WHERE og.uniacid=:uniacid and og.openid=:openid ';
		$where .= ' ORDER BY og.id DESC ';
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

		$params[':uniacid'] = $_W['uniacid'];
		$params[':openid'] = $_W['openid'];

		$list = pdo_fetchall($select.$tablename.$where.$limit,$params);
		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s",$val['createtime']);
		}
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM '.$tablename.$where, $params);

		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));

	}

		//押注记录
	public function winningrecord(){
		global $_W;
		global $_GPC;

		include $this->template();
	}

	public function winningrecordis(){
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$openid = $_W['openid'];

		$select = 'SELECT og.id,og.money,og.createtime,og.numberid,og.stakesum,og.type,og.ranking,og.number
				,m.id as m1id,m.realname as m1realname,m.mobile as m1mobile,m.nickname as m1nickname,m.avatar as m1avatar
				 FROM ';
        $tablename = tablename('winningrecord').' og left join '.tablename('ewei_shop_member').' m ON m.openid=og.openid ';
        $where = ' WHERE og.uniacid=:uniacid and og.openid=:openid ';
		$where .= ' ORDER BY og.id DESC ';
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

		$params[':uniacid'] = $_W['uniacid'];
		$params[':openid'] = $_W['openid'];

		$list = pdo_fetchall($select.$tablename.$where.$limit,$params);
		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s",$val['createtime']);
		}
		$total = pdo_fetchcolumn('SELECT count(og.id) FROM '.$tablename.$where, $params);

		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));

	}

	public function record(){
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];

		$list =  pdo_fetchall("select g.*,m.nickname from".tablename("ewei_shop_member_log")."g left join".tablename("ewei_shop_member")."m on g.openid=m.openid"." where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid order by g.createtime desc",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));

		foreach ($list as $key=>$val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s",$val['createtime']);
		}

		$data = array('list'=>$list);

		show_json(1,$data);	
	}

	//投资排行
	public function ranking(){
		global $_W;
		global $_GPC;

		$sale = pdo_fetch("select * from".tablename("ewei_shop_lottery2")."where uniacid=".$_W['uniacid']);

		//今日开始时间和结束时间戳
        $start = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $end = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

		//查出今日投资的前10名
		$investment = pdo_fetchall("select m.id,l.openid,m.avatar,m.nickname,m.mobile,sum(l.money) as moneys from ".tablename("stakejilu")." l left join ".tablename("ewei_shop_member")." m on l.openid=m.openid "." where l.uniacid=".$_W['uniacid']." and l.thigh=0 and l.createtime>'$start' and l.createtime<'$end' group by l.openid order by moneys desc limit 0,10");

		$shop_lottery = pdo_fetchall("select number,numberis from ".tablename('ewei_shop_lottery2')." where id=1");
		$number = $shop_lottery[0]['numberis'];
		$winning = pdo_fetchall("select * from ".tablename("winningrecord")." where type = 1 and number = ".$number." and createtime>'$start' and createtime<'$end'");

		//投资排名的中奖额度
		$touzi = unserialize($sale['investment']);

		$i = 1;
		foreach ($investment as $key => $val) {
			if($touzi['investment'.$i]){
				$investment[$key]['type'] = $i;
				$investment[$key]['yuji'] = number_format($touzi['investment'.$i]*$sale['sum']*0.01,6);
				$investment[$key]['bfb'] = $touzi['investment'.$i];

			}
			$i++;
		}
		foreach ($winning as $k=>$v){
				$winning[$k]['createtime'] = date("Y-m-d H:i:s",$v['createtime']);
				$winning[$k]['openid'] = substr($v['openid'],-11);
		}
		include  $this->template();
	}

	//游戏规则介绍
	public function rule(){
		global $_W;
		global $_GPC;

		$data = pdo_fetch("select * from ".tablename("ewei_shop_lottery2")."where uniacid=".$_W['uniacid']);
		// var_dump($data['contract']);
		include  $this->template();
	}
	
}
?>