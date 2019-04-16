<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}
class Androidapi_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W ;
		global $_GPC;

	}

	//投资
	public function wechat_complete()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data1 = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data1);exit();
		}
		// show_json($memberis);
		$money = $_GPC['money'];
		$url = $_GPC['url'];
		//exit();
		//投资区间
		$min = pdo_fetch("select min(start) as start from ".tablename("ewei_shop_commission_level4")." where uniacid=".$_W['uniacid']);
		$max = pdo_fetch("select max(end) as end from ".tablename("ewei_shop_commission_level4")." where uniacid=".$_W['uniacid']);

		if($money<$min['start'] || $money>$max['end']){  //投资范围不在区间内

			$data = array('type'=>-1,'start'=>$min['start'],'end'=>$max['end']);

			$data1 = array('status'=>0,"fail"=>"投资范围不在区间内");
			echo json_encode($data1);exit();

		}else{

			//查询投资的区间
			$ass = pdo_fetch("select * from".tablename("ewei_shop_commission_level4")."where uniacid=".$_W['uniacid']." and start<=".$money." and end>=".$money);

			//动态奖金
			//m('common')->comm($_W['openid'],$money);

			//领导奖奖金
			//m('common')->leader($_W['openid'],$money);

			// var_dump($list);exit();
			// show_json($list);

			$moneys = $money*$ass['multiple'];

			//m('member')->setCredit($_W['openid'],'credit1',$moneys);

			$data = array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid'],'type'=>1,'title'=>'资产投资','status'=>0,'money'=>$money,'credit'=>$moneys,'section'=>$ass['id'],'createtime'=>time(),'url'=>$url);

			$result = pdo_insert("ewei_shop_member_log",$data);

			$member = m('member')->getMember($_W['openid'], true);

			if($member['type']==0){
				pdo_update("ewei_shop_member"," type='1' ",array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid']));
			}

			if($result){

				$data = array('status'=>1,"success"=>"投资申请成功");
				echo json_encode($data);exit();
			}

		}
	}

	//出金    转出至TRX
	public function zhuanchutrx()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data1 = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data1);exit();
		}
		$set = $_W['shopset']['trade'];
		if (empty($set['withdraw']))
		{
			$data1 = array('status'=>0,"fail"=>"系统未开启提现");
			echo json_encode($data1);exit();
		}
		$set_array = array();

		//判断该会员是否绑定钱包地址和二维码
		$member = m('member')->getMember($_W['openid'], true);
		if(!$member['walletcode'] || !$member['walletaddress']){
			$data1 = array('status'=>0,"fail"=>"请完善您的资料");
			echo json_encode($data1);exit();
		}

		$money = floatval($_GPC['money']);
		$credit = m('member')->getCredit($_W['openid'], 'credit2');

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

		m('member')->setCredit($_W['openid'], 'credit2', -$money, array(0, $_W['shopset']['set'][''] . '余额提现预扣除: ' . $money . ',实际到账金额:' . $realmoney . ',手续费金额:' . $deductionmoney));
		$logno = m('common')->createNO('member_log', 'logno', 'RW');
		$apply['uniacid'] = $_W['uniacid'];
		$apply['logno'] = $logno;
		$apply['openid'] = $_W['openid'];
		$apply['title'] = 'TRX提现';
		$apply['type'] = 4;
		$apply['createtime'] = time();
		$apply['status'] = 0;
		$apply['money'] = $money;
		$apply['add'] = $member['walletaddress'];
		$apply['url'] = $member['walletcode'];
		$apply['realmoney'] = $_GPC['realmoney'];
		$apply['charge'] = $_GPC['charge'];
		// show_json($apply);
		pdo_insert('ewei_shop_member_log', $apply);
		$logid = pdo_insertid();
		m('notice')->sendMemberLogMessage($logid);
		$data = array('status'=>1,"success"=>"提现申请成功");
		echo json_encode($data);exit();
	}

	//静态账户转出
	public function zhuanchujingtai()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data1 = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data1);exit();
		}
		$set = $_W['shopset']['trade'];
		if (empty($set['withdraw']))
		{
			$data1 = array('status'=>0,"fail"=>"系统未开启提现");
			echo json_encode($data1);exit();
		}
		$set_array = array();
		$set_array['charge'] = $set['withdrawcharge1'];
		$set_array['begin'] = floatval($set['withdrawbegin']);
		$set_array['end'] = floatval($set['withdrawend']);
		$money = floatval($_GPC['money']);
		$credit = m('member')->getCredit($_W['openid'], 'credit3');
		if ($money <= 0)
		{
			$data1 = array('status'=>0,"fail"=>"提现金额错误");
			echo json_encode($data1);exit();
		}
		if ($credit < $money)
		{
			$data1 = array('status'=>0,"fail"=>"提现金额过大");
			echo json_encode($data1);exit();
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
		$data = array('status'=>1,"success"=>"静态账户转出成功");
		echo json_encode($data);exit();
	}

	//复投账户
	public function futouzhanghu() {
		global $_W;
		global $_GPC;

		$id = $_GPC['id'];
		if($id){
			$set = $_W['shopset']['trade'];
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$data = array('status'=>1,"list"=>array('credit2'=>$memberis['credit2'],'credit3'=>$memberis['credit3'],'credit4'=>$memberis['credit4'],'withdrawcharge'=>$set['withdrawcharge'],'withdrawmoney'=>$set['withdrawmoney']));
			echo json_encode($data);exit();
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}
	}
	//出金


	//团队    佣金奖金
	public function tunaduirecord(){
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}
		$type = $_GPC['type'];

		if($type==4){		//积分记录

			$list =  pdo_fetchall("select g.*,m.nickname from".tablename("ewei_shop_receive_hongbao")."g left join".tablename("ewei_shop_member")."m on g.openid=m.openid"." where g.uniacid=:uniacid  and g.openid=:openid order by g.time desc",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));

				foreach ($list as $key=>$val) {
					$list[$key]['createtime'] = date("Y-m-d H:i:s",$val['time']);
				}

				$count =  pdo_fetch("select sum(g.money) as money,sum(g.money2) as money2 from".tablename("ewei_shop_receive_hongbao")."g left join".tablename("ewei_shop_member")."m on g.openid=m.openid"." where g.uniacid=:uniacid  and g.openid=:openid",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));

				if(!$count['money'] && !$count['money2']){
					$summoeny=0;
				}else{
					$summoeny=$count['money']+$count['money2'];
				}

				$data = array('status'=>0,"list"=>array('list'=>$list,'money'=>$summoeny));
				echo json_encode($data);exit();
		}

		$list =  pdo_fetchall("select g.*,m.nickname from".tablename("ewei_shop_order_goods1")."g left join".tablename("ewei_shop_member")."m on g.openid2=m.openid"." where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid order by g.createtime desc",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));

		foreach ($list as $key=>$val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s",$val['createtime']);
		}

		$count =  pdo_fetch("select sum(g.money) as money from".tablename("ewei_shop_order_goods1")."g left join".tablename("ewei_shop_member")."m on g.openid2=m.openid"." where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));

		$data = array('status'=>0,"list"=>array('list'=>$list,'money'=>$count['money']));
		echo json_encode($data);exit();

	}

	public function digui($members,$mid){

		global $_W;

		global $_GPC;

		$Teams = array();//最终结果

		$op=1;

		$mids = array($mid);//第一次执行时候的用户id

		do {

			$othermids = array();

			$state = false;

			foreach ($mids as $valueone) {

				foreach ($members as $key => $valuetwo) {

					if($valuetwo['agentid'] == $valueone){

						$Teams[]=array('id' => $valuetwo['id'],'type'=>$op);//找到我的下级立即添加到最终结果中

						$othermids[] = $valuetwo['id'];//将我的下级id保存起来用来下轮循环他的下级



						$state=true;

					}

				}

			}

			$op = $op+1;

			$mids=$othermids;//foreach中找到的我的下级集合,用来下次循环

		} while ($state==true);

		return $Teams;
	}

	//团队下级
	public function tuanduixiaji()

	{

		global $_W;

		global $_GPC;

		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}

		$member = p('commission')->getInfo($_W['openid']);

		$total_level = 0;

		$level = intval($_GPC['level']);

		((3 < $level) || ($level <= 0)) && ($level = 1);

		$condition = '';



		$pindex = max(1, intval($_GPC['page']));

		$psize = 10;

		$ass = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = ' . $_W['uniacid']);

		$arr = $this->digui($ass,$member['id']);


		foreach($arr as $key=>$val){

			$ids .= $val['id'].",";

		}

		$ids_1 = substr($ids,0,-1);

		$condition = "and id in ($ids_1)";



		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = ' . $_W['uniacid'] . ' ' . $condition . '  ORDER BY isagent desc,id desc limit ' . (($pindex - 1) * $psize) . ',' . $psize);



		foreach ($list as &$row) {

			foreach ($arr as $key=>$val){    //给每个会员附加代数

				if($row['id']==$val['id']){

					$row['type'] = $val['type'];

				}

			}



			//给每个会员加入等级

			$level = pdo_fetch("select levelname from".tablename("ewei_shop_member_level")."where uniacid=:uniacid and id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$row['level']));

//			var_dump($level);

			$row['level'] = $level['levelname'];


			if ($member['isagent'] && $member['status']) {

				$info = p('commission')->getInfo($row['openid'], array('total'));

				$row['commission_total'] = $info['commission_total'];

				$row['agentcount'] = $info['agentcount'];

				$row['agenttime'] = date('Y-m-d H:i', $row['agenttime']);

			}

			$total_level = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $member['id'], ':uniacid' => $_W['uniacid']));

			$ordercount = pdo_fetchcolumn('select count(id) from ' . tablename('ewei_shop_order') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));

			$row['ordercount'] = number_format(intval($ordercount), 0);

			$moneycount = pdo_fetchcolumn('select sum(og.realprice) from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id where o.openid=:openid  and o.status>=1 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));

			$row['moneycount'] = number_format(floatval($moneycount), 2);

			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);

		}



		unset($row);

		//根据代数升序

		$type = array_column($list,'type');

		array_multisort($type,SORT_ASC,$list);


		$data = array('status'=>0,"result"=>array('list' => $list, 'total' => $total_level,'sum'=>count($arr), 'pagesize' => $psize));
		echo json_encode($data);exit();

	}
	//团队

	//投资明细
	public function touzirecord(){
		global $_W;
		global $_GPC;

		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}

		$type = $_GPC['type'];

		$list =  pdo_fetchall("select g.*,m.nickname from".tablename("ewei_shop_member_log")."g left join".tablename("ewei_shop_member")."m on g.openid=m.openid"." where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid order by g.createtime desc",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));

		foreach ($list as $key=>$val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s",$val['createtime']);
		}
		$data = array('status'=>1,'list'=>$list);
		echo json_encode($data);
	}
	//投资明细


	//投资排行
	public function fucairanking(){
		global $_W;
		global $_GPC;

		$sale = pdo_fetch("select * from" . tablename("ewei_shop_lottery2") . "where id=1");

		//昨天开始时间
		$t_start = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
		//昨天结束时间
		$t_end = mktime(23, 59, 59, date('m'), date('d') - 1, date('Y'));
		//今日开始时间和结束时间戳
		$start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
		//查出昨日投资前10名
		$t_investment = pdo_fetchall("select m.id,l.openid,m.avatar,m.nickname,m.mobile,sum(l.money) as moneys from " . tablename("stakejilu") . " l left join " . tablename("ewei_shop_member") . " m on l.openid=m.openid " . " where l.uniacid=" . $_W['uniacid'] . " and l.createtime>='$t_start' and l.createtime<='$t_end' group by l.openid order by moneys desc limit 0,10");
		// dump($t_investment);
		//查出今日投资的前10名
		$investment = pdo_fetchall("select m.id,l.openid,m.avatar,m.nickname,m.mobile,sum(l.money) as moneys from " . tablename("stakejilu") . " l left join " . tablename("ewei_shop_member") . " m on l.openid=m.openid " . " where l.uniacid=" . $_W['uniacid'] . " and l.createtime>'$start' and l.createtime<'$end' group by l.openid order by moneys desc limit 0,10");
		// dump($investment);
		$shop_lottery = pdo_fetchall("select number,numberis from " . tablename('ewei_shop_lottery2') . " where id=1");
		$number = $shop_lottery[0]['numberis'];
		$winning = pdo_fetchall("select * from " . tablename("winningrecord") . " where type = 1 ");
        
		//投资排名的中奖额度
		$touzi = unserialize($sale['investment']);


		$a = 1;
		foreach ($t_investment as $key => $val) {
			if ($touzi['investment' . $a]) {
				$t_investment[$key]['type'] = $a;
				$t_investment[$key]['yujis'] = number_format($touzi['investment' . $a] * $sale['sums'] * 0.01, 6);
				$t_investment[$key]['bfb'] = $touzi['investment' . $a];
			}
			$a++;
		}

		$i = 1;
		foreach ($investment as $key => $val) {
			if ($touzi['investment' . $i]) {
				$investment[$key]['type'] = $i;
				$investment[$key]['yuji'] = number_format($touzi['investment' . $i] * $sale['sum'] * 0.01, 6);
				$investment[$key]['bfb'] = $touzi['investment' . $i];
			}
			$i++;
		}
		foreach ($winning as $k => $v) {
			$winning[$k]['createtime'] = date("Y-m-d H:i:s", $v['createtime']);
			$winning[$k]['openid'] = substr_replace(substr($v['openid'], -11), '****', 3, 4);
		}
		
		 if($sale['sum'] == 0){
             $total =  $sale['sums'];    
		 }else{
			 $total =  $sale['sum']; 
		 }
		$data = [
			'winning'  => $winning,
			'total'    => $total,
			'today'    => $investment,
			'yestoday' => $t_investment,
		];
		returnJson($data, "获取数据成功",1);

	}

	//一键包号 3D彩票
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
		returnJson(array('list' => $yes), "获取成功",1);
	}


    //下注 3D彩票
	public function bets()
	{
		global $_W;
		global $_GPC;

			$type = $_GPC['type'];

			if ($type == 1) {    //确认信息

				$member = m('member')->getMember($_W['openid'], true);

				$data = array('credit2' => $member['credit2'], 'credit4' => $member['credit4']);
				returnJson(['list' => $data],'ok',1);
			} else if ($type == 2) {  //下注
				$t = time();
				$start = mktime(19, 59, 59, date("m", $t), date("d", $t), date("Y", $t));

				if ($t >= $start) {
					returnJson(array(), "下注失败!每日下注时间为下午20点前.",0);
				}
				// $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
				$member = m('member')->getMember($_W['openid'], true);

				$sale = pdo_fetch("select * from" . tablename("ewei_shop_lottery2") . "where uniacid=" . $_W['uniacid']);

				$payment = $_GPC['payment'];

				$money   = $_GPC['money'];

				$list    = $_GPC['list'];

				if(empty($list) && !is_array($list)){
					  returnJson([], "下注失败!下注号码不能为空.",0);
				}
				if($money < 0){
					returnJson(array(), "下注失败!金额必须大于0.",0);
				}
				if($payment < 1){
					returnJson(array(), "下注失败!请选择支付方式.",0);
			    }
				// show_json($list);

				if ($payment == 1) {  //ETH支付

					if ($member['credit2'] < $money)  returnJson(array(), "您的自由账户余额不足",0);
					//扣除该会员的下注金额
					m('member')->setCredit($_W['openid'], 'credit2', -$money);
					$title = "自由账户进行下注减少" . $money;
					$front_money = $member['credit2'];
				} else if ($payment == 2) {  //复投账户支付

					if ($member['credit4'] < $money)  returnJson(array(), "您的复投账户余额不足",0);
					//扣除该会员的下注金额
					m('member')->setCredit($_W['openid'], 'credit4', -$money);
					$title = "复投账户进行下注减少" . $money;
					$front_money = $member['credit4'];
				}
				$arr_log = array(
					'uniacid' => 12,
					'openid' => $_W['openid'],
					'money' => $money,
					'type' => 7,
					'title' => $title,
					'payment' => $payment,
					'front_money' => $front_money,
					'after_money' => $front_money - $money,
					'createtime' => time()
				);
				pdo_insert("ewei_shop_member_log", $arr_log);

				foreach ($list as $key => $val) {
					$number = $val['0'];
					$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'number' => "$number", 'multiple' => $val['1'], 'money' => $val['1'] * $sale['price'], 'createtime' => time());
					pdo_insert("stakejilu", $data);
				}

				pdo_update("ewei_shop_lottery2", array('sum' => $sale['sum'] + $money), array('uniacid' => $_W['uniacid']));
				returnJson(array(), "下注成功",1);
			}
	}

	//游戏规则介绍
	public function fucairule(){
		global $_W;
		global $_GPC;

		$data = pdo_fetch("select * from ".tablename("ewei_shop_lottery2")."where uniacid=".$_W['uniacid']);
		returnJson($data['contract'], "获取记录成功",1);
	}

	//3D首页开奖号 首页信息
	public function indexedit(){
		global $_W;
		global $_GPC;

		$sale = pdo_fetch("select price,numberis,time from" . tablename("ewei_shop_lottery2") . "where uniacid=" . $_W['uniacid']);
		// select * from table_name limit 0,10
		$sale1 = pdo_fetchall("select * from" . tablename('ewei_shop_lottery2_log') . "  order by id DESC limit 10");

		$data = [
			'price' => $sale['price'],
			'sale1' => $sale1,
		];
		returnJson($data, "首页信息成功",1);

	}

	//3D押注记录
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

		$data = array('list' => $list, 'total' => $total, 'pagesize' => $psize);
		
		
		returnJson($data, "获取记录成功",1);

	}

	//中奖记录
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
		
		$data = array('list' => $list, 'total' => $total, 'pagesize' => $psize);
		returnJson($data, "获取中奖记录成功",1);

	}



	/***
	 * 3d彩票 投资排行
	 */

	

	//c2c
	//挂卖中心
	public function guamairecordjilu(){
		global $_W;
		global $_GPC;
		$type   = $_GPC['type'];
		$pindex = max(1, intval($_GPC['page']));
		$psize  = 10;
		$openid = $_W['openid'];
		$select = 'SELECT g.id,g.openid,g.openid2,g.money,g.createtime,g.type,g.price,g.trx,g.status,m.nickname,m.zfbfile,m.wxfile,m.bankid,m.bankname,m.bank,m2.nickname as nickname2 FROM ';
		$tablename = tablename('guamai') . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid left join' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2';
		$where = ' WHERE g.uniacid=:uniacid AND g.type=:type  AND (g.status=0) ';
		$where .= " ORDER BY g.status = '1' DESC,g.openid = '$openid' DESC,g.openid2 = '$openid' DESC,g.createtime DESC ";
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

		$params[':uniacid'] = $_W['uniacid'];
		
		$params[':type']    = $type; //我卖出的订单 应该挂在买入的下面

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
		
		$data = array('list' => $list,'total' => $total,'pagesize' => $psize);
		returnJson($data,'ok',1);
	}

    //订单中心
	public function number_order(){
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$status = $_GPC['status'];
		if(!isset($status)){
			returnJson([],'请传入订单状态',0);
		}
		//价格基础TRX价格  以及手续费
		$sys = pdo_fetch("select trxprice,trxsxf from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		$sys['trxsxf'] = round($sys['trxsxf'], 2);
		$start  = $sys['trxprice'] * (1 - 0.1);
		$end    = $sys['trxprice'] * (1 + 0.1);
		$member = m('member')->getMember($_W['openid'], true);
		//用户买入,卖出订单
		$guamai = pdo_fetchall("select * from" . tablename("guamai") . "where  status='".$status."' AND (openid='" . $openid . "' or openid2='" . $openid . "') order by createtime desc");
		$time   = time();
		foreach ($guamai as $key => $val) {
			// var_dump($val);nickname2
			$guamai[$key]['datatime']  = date("Y-m-d H:i:s", $val['createtime']);
			$guamai[$key]['time_news'] = ($val['createtime'] + 1800) - $time;
			$guamai[$key]['nickname']  = substr($val['openid'], -11);
			$guamai[$key]['nickname2'] = substr($val['openid2'], -11);
		}
		returnJson($guamai,'获取订单成功',1);
	}

		/**
		 * 申诉中心
		 */
		public function guamai_appeal(){
			global $_W;
			global $_GPC;
			$pindex = max(1, intval($_GPC['page']));
			$psize  = 10;
			$limit  = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
			$guamai_appeal = pdo_fetchall("select * from" . tablename("guamai_appeal") . "where appeal_name='" . $_GPC['userid'] . "'".$limit);
			foreach ($guamai_appeal as $k => $v) {
				$guamai_appeal[$k]['createtime'] = date("m-d", $val['createtime']);
			}
			returnJson(['list'=>$guamai_appeal],'获取申诉列表成功',1);
		}


		//订单中心确认买入或者卖出接口
		public function hangonsale()
		{
			global $_W;
			global $_GPC;
	
			$type   = $_GPC['type'];
			$openid = $_W['openid'];
			$member = m('member')->getMember($_W['openid'], true);
			//价格基础TRX价格  以及手续费
			$sys = pdo_fetch("select trxprice,trxsxf from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
			$start = $sys['trxprice'] * (1 - 0.1);
			$end   = $sys['trxprice'] * (1 + 0.1);
			if ($_GPC['price'] < $start || $_GPC['price'] > $end) {
				returnJson([], "请参考价格建议区间",0);
			}
			//判断该会员是否上传收款信息
			if (!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])) {
				returnJson([], "请上传您的收款信息",0);
			}
			if ($member['credit2'] < $_GPC['trx2']) {
				returnJson([],'您的ETH不足，请尽快投资！',0);
			}
			$data   = array('openid' => $openid, 'uniacid' => $_W['uniacid'], 'price' => $_GPC['price'], 'trx' => $_GPC['trx'], 'trx2' => $_GPC['trx2'], 'money' => $_GPC['money'], 'type' => $type, 'status' => '0', 'sxf0' => $_GPC['sxf0'], 'createtime' => time());
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
				returnJson([],'挂卖成功',1);
			} else {
				returnJson([],'挂买成功',1);
			}
			
		}
        /***
		 * c2c首页点击卖出或者买入按钮
		 */

		public function sellout()
		{
			global $_W;
			global $_GPC;
			//参数  id  type 
			//该订单的信息
			$id     = $_GPC['id']; //订单ID
			$op     = $_GPC['op']; //特殊参数
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

			$type = $_GPC['type'];
			$guamai = pdo_fetchall("select * from" . tablename("guamai") . " where status = 1 and openid2='" . $openid . "'");
			// dump($type);die;
			if ($guamai) {
				$guamai_nums = count($guamai);
			}
			
			// dump($type);die;
			if ($type == 0) {   //买入
				if ($guamai_nums >= 1) {
					returnJson([],"您还有订单尚未处理或还在交易中,请先进行交易！", 0);
				}
				if ($op == 1) {
					$result = pdo_update("guamai", array('file' => $_GPC['file']), array('uniacid' => $_W['uniacid'], 'id' => $id));

					com('sms')->send_zhangjun2($sell['mobile2'], $id, "对方已付款成功,请及时确认.");

					if ($result) returnJson([],"挂单人付款成功", 1);
				} else {
					//判断是否是自己买入自己
					if($sell['openid'] == $_W['openid']){
						 returnJson([],"不能买入自己发放的账单", 0);
					}
					//判断该用户是否有足够的币进行抢单
					$member = m('member')->getMember($_W['openid'], true);
					//判断该会员是否上传收款信息
					if (!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])) {
						returnJson([], "请上传您的收款信息",-1);
					}
					$apple_time = time() + 1800;
					$result = pdo_update("guamai", array('file' => $_GPC['file'], 'status' => 1, 'apple_time' => $apple_time, 'openid2' => $_W['openid']), array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
					$mobile = pdo_fetch("select * from" . tablename("guamai") . " where id='" . $_GPC['id'] . "'");
					$mobile = substr($mobile['openid'], -11);

					com('sms')->send_zhangjun2($mobile, $_GPC['id'], "订单已被抢单成功！请在有效时间内及时查看");
					if ($result) returnJson([],"抢单成功",1);
				}
			} else if ($type == 1) {  //卖出
				
				if ($op == 1) {
					// dump($op);die;
					$result = pdo_update("guamai", array('file' => $_GPC['file']), array('uniacid' => $_W['uniacid'], 'id' => $id));

					com('sms')->send_zhangjun2($sell['mobile'], $id, "对方已付款成功,请及时确认.");

					if ($result) returnJson([],"挂单人付款成功",1);
				} else {
					$id = $_GPC['id'];
					$op = $_GPC['op'];
					//判断该用户是否有足够的币进行抢单
					$member = m('member')->getMember($_W['openid'], true);
					$sell   = pdo_fetch("select g.trx,m.mobile,m2.mobile as mobile2 from" . tablename("guamai") . ' g left join ' . tablename('ewei_shop_member') . ' m ON m.openid=g.openid ' . ' left join ' . tablename('ewei_shop_member') . ' m2 ON m2.openid=g.openid2 ' . " where g.uniacid=" . $_W['uniacid'] . " and g.id='$id' and g.type=0");
					if ($guamai_nums >= 1) {
						returnJson([],"您还有订单尚未处理或还在交易中,请先进行交易！",0);
					}
					if($sell['openid'] == $_W['openid']){
						returnJson([],"不能卖出自己发放的账单", 0);
					}
					// returnJson(['openid' => $sell['openid'] , 'openid2' => $_W['openid']]);

					//判断该会员是否上传收款信息
					if (!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])) {
						returnJson([], "请上传您的收款信息",0);
					}
					if ($member['credit2'] < $sell['trx']) {
						returnJson([], "您的ETH不足，请尽快投资！",0);
					}
					//币足够的时候进行抢单  （扣币）
					$apple_time = time() + 1800;
					m('member')->setCredit($_W['openid'], 'credit2', -$sell['trx']);
					$result = pdo_update("guamai", array('status' => 1, 'openid2' => $_W['openid'], 'createtime' => time(), 'apple_time' => $apple_time), array('uniacid' => $_W['uniacid'], 'id' => $id));
					// dump($sell['mobile']);die;
					com('sms')->send_zhangjun2($sell['mobile'], $_GPC['id'], "订单已被抢单成功！请在有效时间内及时查看");

					returnJson([], "抢单成功",1);
				}
			}
			
		}

		/***
		 * 
		 * 订单详情
		 */

		public function guamaiedit(){
			
			global $_W;
			global $_GPC;
			//参数  id  type 
			//该订单的信息
			$id = $_GPC['id']; //订单ID
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
			if ($sell['openid'] == $_W['openid']){
				$type = 1;
			} else if ($sell['openid2'] == $_W['openid']) {
				$type = 2;
			}
			returnJson(['list' => $sell,'type_own' => $type], "获取订单详情成功",1);

		}

		//申诉详情
		public function guamai_appeal_list()
		{
			global $_W;
			global $_GPC;
			$id      = $_GPC['id'];
			$user_id = $_GPC['userid'];
			$users = pdo_fetch("select * from" . tablename("ewei_shop_member") . " where id='$user_id'");
			$guamai_appeal = pdo_fetch("select g.*,m.* from" . tablename("guamai_appeal") . ' g left join ' . tablename('guamai') . '  m ON m.id=g.order_id' . " where g.id='$id'");
			// dump($guamai_appeal);
			if ($users['openid'] == $guamai_appeal['openid']) {
				$guamai_appeal['openid2'] = substr($guamai_appeal['openid2'], -11);
				$guamai_appeal['type1']   = "0";
			} else {
				$guamai_appeal['openid2'] = substr($guamai_appeal['openid'], -11);
				$guamai_appeal['type1']   = "1";
			}
			$guamai_appeal['mobile'] = $users['mobile']; 
			returnJson(['list' => $guamai_appeal], "获取申诉详情成功",1);
		}

		
		//我的申诉
		public function guamai_appeal_add()
		{
				global $_W;
				global $_GPC;
				$id    = $_GPC['id'];//订单号
				$hello = json_encode(explode(',', $_GPC['files']));
				$guamai = pdo_fetch("select * from" . tablename("guamai") . "where id='" . $id . "'");
				$appeal = pdo_fetch("select * from" . tablename("guamai_appeal") . "where stuas=0 and order_id='" . $id . "' and appeal_name='" . $_W['mid'] . "'");
				if ($appeal) {
					returnJson(array(),'您还有一条为审核的申诉,请稍后再试!!!',0);
				} else {
					$data_appeal = array(
						"openid"      => $guamai['openid'],
						"openid2"     => $guamai['openid2'],
						"order_id"    => $id,
						"file"        => $guamai['file'],
						"files"       => $hello,
						"type"        => $guamai['type'],
						"appeal_name" => $_W['mid'],
						"stuas"       => 0,
						"text"        => $_GPC['text'],
						"textarea"    => $_GPC['textarea'],
						"createtime"  => time()
					);
					$guamai_appeal = pdo_insert("guamai_appeal", $data_appeal);
					$guamai_appeal?returnJson(array(), "申诉成功",1):returnJson(array(), "申诉失败",0);
			  }
		}

          





	//价格建议区间
	public function guamaijianyi()
	{
		global $_W;
		global $_GPC;
		$type = 0;

		//价格基础TRX价格  以及手续费
		$sys = pdo_fetch("select trxprice,trxsxf from".tablename("ewei_shop_sysset")."where uniacid=".$_W['uniacid']);
		$start = $sys['trxprice']*(1-0.1);
		$end = $sys['trxprice']*(1+0.1);
		$data = array('start'=>$start,'end'=>$end);
		$member = m('member')->getMember($_W['openid'], true);
		echo json_encode(array('status'=>1,'list'=>$data));
	}


	//买入卖出的确认收款
	public function guamaiselloutyes(){
			global $_W;
			global $_GPC;
			$id   =  $_GPC['id'];
			$type =  $_GPC['type'];

			if($type){			//卖出订单挂单人点击确认收款

				$sell = pdo_fetch("select g.*,m.mobile,m2.mobile as mobile2,m2.openid as openid2 from".tablename('guamai').' g left join '.tablename('ewei_shop_member').' m ON m.openid=g.openid left join '.tablename('ewei_shop_member').' m2 ON m2.openid=g.openid2 '." where g.uniacid=".$_W['uniacid']." and g.id='$id'");
				// show_json($sell);

				com('sms')->send_zhangjun2($sell['mobile2'], $id,"卖出订单抢单完成！");

				//给抢单人充币
				pdo_update("guamai",array('status'=>2,'endtime'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$id));

				m('member')->setCredit($sell['openid2'],'credit1',$sell['trx']);
				returnJson([], "订单完成",1);

			}else{	//买入订单抢单人点击确认收款

				$sell = pdo_fetch("select g.*,m.mobile,m2.mobile as mobile2 from".tablename('guamai').' g left join '.tablename('ewei_shop_member').' m ON m.openid=g.openid left join '.tablename('ewei_shop_member').' m2 ON m2.openid=g.openid2 '." where g.uniacid=".$_W['uniacid']." and g.id='$id'");
				// show_json($sell);

				//给挂单人充币
				pdo_update("guamai",array('status'=>2,'endtime'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$id));

				m('member')->setCredit($sell['openid'],'credit1',$sell['trx']);

				com('sms')->send_zhangjun2($sell['mobile'], $id,"买入订单挂单完成！");
				returnJson([], "订单完成",1);
			}

	}


	//c2c撤销订单
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
			returnJson(array(),"该订单已经在进行中,不能进行撤销!!!",0);
		}
		if ($sell['type'] == 0) {
			// $data = array("credit2"=>$sell['trx']+$sell['credit2']);
			$updeta_order = pdo_update("guamai", array("status" => 3, "createtime" => time()), array("openid" => $sell['openid'], "id" => $sell['id']));
			if ($updeta_order) {
				returnJson(array(),"撤销成功",1);
			}
		} else {
			$data = array("credit2" => $sell['trx2'] + $sell['credit2']);
			$updeta_order = pdo_update("guamai", array("status" => 3, "createtime" => time()), array("openid" => $sell['openid'], "id" => $sell['id']));
			if ($updeta_order) {
				$result = pdo_update("ewei_shop_member", $data, array("openid" => $sell['openid']));
				returnJson(array(),"撤销成功!",1);
			} else {
				returnJson(array(),"撤销失败!",1);
			}
		}
	}
	//c2c


	//个人
	//会员名称  会员等级 市场等级
	public function homemember(){
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}

		$member = m('member')->getMember($_W['openid'], true);

		//会员等级和市场等级
		$huiyuanlevel = pdo_fetch("select l1.levelname as levelname1,l3.levelname as levelname3 from".tablename("ewei_shop_member")." m left join ".tablename("ewei_shop_commission_level")." l1 on m.agentlevel = l1.id left join ".tablename("ewei_shop_commission_level3")." l3 on m.agentlevel3 = l3.id "." where m.uniacid=".$_W['uniacid']." and m.openid=:openid ",array(':openid'=>$_W['openid']));

		$data = array('status'=>1,'nickname'=>$member['nickname'],'levelname1'=>$huiyuanlevel['levelname1'],'levelname3'=>$huiyuanlevel['levelname3']);
		echo json_encode($data);
	}

	//退出操作
	public function homeexit(){

		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}

		//查看该会员的总投资金额
        $arr2 = pdo_fetch("select sum(money) as money from".tablename("ewei_shop_member_log")."where uniacid=".$_W['uniacid']." and openid=:openid and type=1",array(':openid'=>$_W['openid']));

        $money4 = $arr2['money']*0.5;

        $data = array('status'=>1,'money'=>$arr2['money'],'money4'=>$money4);
        echo json_encode($data);
	}

	//退出操作确认退出
	public function homeexitis(){
		global $_W;
        global $_GPC;
        $id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}

        $money = $_GPC['money'];

        m('member')->setCredit($_W['openid'],'credit2',$money);

        pdo_update("ewei_shop_member", array('type' => 2,'credit5'=>$money,'agentlevel'=>0,'agentlevel2'=>0,'agentlevel3'=>0),array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid']));

        echo json_encode(array('status'=>1,"success"=>"退出操作成功"));
	}

	//上传头像和修改会员姓名
	public function homeface()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>1,"nickname"=>$members['nickname'],'avatar'=>$members['avatar']);
			echo json_encode($data);exit();
		}

		if ($_W['ispost'])
		{
			if($_GPC['into']){
				$data = array('status'=>1,"nickname"=>$memberis['nickname'],'avatar'=>$memberis['avatar']);
				echo json_encode($data);exit();
			}
			$nickname = trim($_GPC['nickname']);
			$avatar = trim($_GPC['avatar']);
			if (empty($nickname))
			{
				$data = array('status'=>0,"fail"=>"请填写昵称");
				echo json_encode($data);exit();
			}
			if (empty($avatar))
			{
				$data = array('status'=>0,"fail"=>"请上传头像");
				echo json_encode($data);exit();
			}
			pdo_update('ewei_shop_member', array('avatar' => $avatar, 'nickname' => $nickname), array('id' => $id, 'uniacid' => $_W['uniacid']));
			$data = array('status'=>1,"success"=>"更新完成");
			echo json_encode($data);exit();
		}
		include $this->template();
	}

	//钱包上传信息
	public function homewallet(){
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}
		if($_GPC['into']){
				$data = array('status'=>1,"walletaddress"=>$memberis['walletaddress'],'walletcode'=>$memberis['walletcode'],'zfbfile'=>$memberis['zfbfile'],'wxfile'=>$memberis['wxfile'],'bankid'=>$memberis['bankid'],'bankname'=>$memberis['bankname'],'bank'=>$memberis['bank']);
				echo json_encode($data);exit();
			}
		if (empty($_GPC['adress']))
		{
			$data = array('status'=>0,"fail"=>"请填写钱包地址");
			echo json_encode($data);exit();
		}
		if (empty($_GPC['url']))
		{
			$data = array('status'=>0,"fail"=>"请上传钱包二维码");
			echo json_encode($data);exit();
		}
		$datas = array('walletaddress'=>$_GPC['adress'],'walletcode'=>$_GPC['url']);
		if($_GPC['zfbfile']){
			$datas['zfbfile'] = $_GPC['zfbfile'];
		}
		if($_GPC['wxfile']){
			$datas['wxfile'] = $_GPC['wxfile'];
		}
		if($_GPC['bankid']){
			$datas['bankid'] = $_GPC['bankid'];
		}
		if($_GPC['bankname']){
			$datas['bankname'] = $_GPC['bankname'];
		}
		if($_GPC['bank']){
			$datas['bank'] = $_GPC['bank'];
		}
		 // show_json($datas);
		$result = pdo_update("ewei_shop_member",$datas,array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid']));

		if($result){
			$data = array('status'=>1,"success"=>"操作成功");
			echo json_encode($data);exit();
		}else{
			$data = array('status'=>-1,"success"=>"操作失败");
			echo json_encode($data);exit();
		}
	}

	public function verifycode()
	{
		global $_W;
		global $_GPC;
		$set = m('common')->getSysset(array('shop', 'wap'));
		$set['wap']['color'] = ((empty($set['wap']['color']) ? '#fff' : $set['wap']['color']));
		
		$mobile = trim($_GPC['mobile']);
		$temp = trim($_GPC['temp']);
		$imgcode = trim($_GPC['imgcode']);
		if( !$mobile || !$temp ){
			returnJson(array(),'参数错误！','-1');
		}
		
		$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and mobileverify=1 and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
		if (($temp == 'sms_forget') && empty($member)) {
			returnJson(array(),'此手机号未注册','-1');
		}
		if (($temp == 'sms_reg') && !(empty($member))) {
			returnJson(array(),'此手机号已注册，请直接登录','-1');
		}

		$res = pdo_fetch('select exprie_time from ' . tablename('phone_auth') . ' where phone=:phone order by id DESC limit 1', array(':phone' => $mobile));
		if( $res['exprie_time'] > time() ){
			returnJson(array(),'请求频繁请稍后重试','-1');
		}

		$sms_id = $set['wap'][$temp];
		if (empty($sms_id)) {
			returnJson(array(),'短信发送失败(NOSMSID)','-1');
		}
		
		$code = random(5, true);

		$data['phone'] = $mobile;
		$data['auth_code'] = $code;
		$data['start_time'] = time();
		$data['exprie_time'] = time() +60;

		pdo_insert("phone_auth", $data);

		$ret = com('sms')->send_zhangjun($mobile, $code);
		
		returnJson(array());
	}

	public function phoneAuth($phone, $auth_code)
    {	
		$res = pdo_fetch('select exprie_time from ' . tablename('phone_auth') . ' where phone='. $phone .' and auth_code= ' . $auth_code .' order by id DESC limit 1');
        if ($res) {
			if ($res['exprie_time'] >= time()) { // 还在有效期就可以验证
                return true;
            } else {
                return '-1';
            }
        }
        return false;
	}

	public function get_mobile(){
		global $_W;
		$member = m('member')->getMember($_W['openid'], true);
		returnJson($member['mobile']);
	}

	//修改密码
	public function cahngepwd()
	{
		global $_W;
		global $_GPC;
		
		$mobile = $_GPC['mobile'];
		$code = $_GPC['code'];
		$pwd = trim($_GPC['pwd']);
		if(!$mobile || !$code || !$pwd){
			returnJson(array(),'参数错误！','-1');
		}
		
		if( $this->phoneAuth($mobile,$code) === '-1' ){
			returnJson(array(),'验证码已过期！','-1');
		}else if( !$this->phoneAuth($mobile,$code) ){
			returnJson(array(),'验证码错误！','-1');
		}
		
		$member = pdo_fetch('select id,openid,mobile,pwd,salt,credit1,credit2, createtime from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid and mobileverify=1 limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
		$salt = ((empty($member) ? '' : $member['salt']));
		if (empty($salt)){
			$salt = random(16);
			while (1)
			{
				$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where salt=:salt limit 1', array(':salt' => $salt));
				if ($count <= 0)
				{
					break;
				}
				$salt = random(16);
			}
		}
		pdo_update('ewei_shop_member', array('mobile' => $mobile, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'mobileverify' => 1), array('id' => $id, 'uniacid' => $_W['uniacid']));
		returnJson(array());
	}

	public function kefu(){
		global $_W;
		$sys = pdo_fetch("select kefufile,wxkffile from".tablename("ewei_shop_sysset")."where uniacid=".$_W['uniacid']);
		$data = array('status'=>1,'qqfile'=>$sys['kefufile'],'wxkffile'=>$sys['wxkffile']);
		echo json_encode($data);
	}
	//个人

	public function img(){
		$file = $_POST['file'];
		show_json($file);
	}

	//图片上传
	public function imgfile(){

		$file = $_FILES['file'];//得到传输的数据


		//得到文件名称
		$name = $file['name'];
		$type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
		$allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型

		//判断文件类型是否被允许上传
		if(!in_array($type, $allow_type)){
		    //如果不被允许，则直接停止程序运行
			$book=array('status'=>1,'message'=>'您上传的类型有误');
			echo json_encode($book);
			exit;

		}
		//判断是否是通过HTTP POST上传的
		if(!is_uploaded_file($file['tmp_name'])){
		    //如果不是通过HTTP POST上传的
			$book=array('status'=>0,'message'=>'上传来源有误');
			echo json_encode($book);
			exit;
		}
		$upload_path = "./img/"; //上传文件的存放路径

		if($type == 'jpg'){
			$file['name']=time().'.jpg';
		}elseif($type == 'jpeg'){
		$file['name']=time().'.jpeg';
		}elseif($type == 'gif'){
		$file['name']=time().'.gif';
		}elseif($type == 'png'){
		$file['name']=time().'.png';
		}

		//开始移动文件到相应的文件夹
		if(move_uploaded_file($file['tmp_name'],$upload_path.$file['name'])){
		$url='http://'.$_SERVER['SERVER_NAME'].'/app/img/'.$file['name'];
		   $book=array('status'=>1,'message'=>'上传成功','url'=>$url);
			echo json_encode($book);
			exit;
		}else{
		  $book=array('status'=>0,'message'=>'上传失败');
			echo json_encode($book);
			exit;
		}

	}


	function new_file_upload($data='', $type = 'image') {
		global $_W;
		global $_GPC;
		$data = $_GPC['file'] ? $_GPC['file'] : $data;
		
		if (empty($data)) {
			returnJson(array(),'没有上传内容',-1);
		}
		

		switch($type){
	        case 'image/png':
	            $ext='png';
	            break;
	        case 'image/jpeg';
	            $ext='jpeg';
	            break;
	        case 'image/jpeg':
	            $ext='jpg';
	            break;
	        case 'image/bmp':
	            $ext='bmp';
	            break;
	        default:
	            $ext='jpg';
	    }
		$setting = setting_load('upload');
		$allowExt = array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'ico');
		$limit = $setting['upload']['image']['limit'];

		$setting = $_W['setting']['upload'][$ext];
		if (!empty($setting)) {
			$allowExt = array_merge($setting['extentions'], $allowExt);
		}
		if (!in_array($ext, $allowExt)) {
			returnJson(array(),'不允许上传此类文件',-1);
		}
		$img_content = str_replace('data:'.$type.';base64,','',$data);
	    $img_content = base64_decode($img_content);
		$result = array();
		$uniacid = intval($_W['uniacid']);
		$path = "images/{$uniacid}/" . date('Y/m/');
		mkdirs(ATTACHMENT_ROOT . '/' . $path,0777);

		$filename = file_random_name(ATTACHMENT_ROOT . '/' . $path, $ext);

		$res = file_put_contents(ATTACHMENT_ROOT.'/'.$path.$filename,$img_content);

		if(!$res){
			returnJson(array(),'保存上传文件失败',-1);
		}
		$result['path'] = $path.$filename;
		$result['success'] = true;
		returnJson($result);
		return $result;
	}


	public function newUpload(){
		global $_W,$_GPC;
		$result['status'] = 'error';

		$str = $_POST['file'];

		show_json($str);

        $type = $_POST['type'];

        load()->func('file');
		$path = '/images/ewei_shop/' . $_W['uniacid'];
		if (!(is_dir(ATTACHMENT_ROOT . $path)))
		{
			mkdirs(ATTACHMENT_ROOT . $path);
		}
		$_W['uploadsetting'] = array();
		$_W['uploadsetting']['image']['folder'] = $path;
		$_W['uploadsetting']['image']['extentions'] = $_W['config']['upload']['image']['extentions'];
		$_W['uploadsetting']['image']['limit'] = $_W['config']['upload']['image']['limit'];
		$file = $this->new_file_upload($str,$type);
		if (is_error($file))
		{
			$result['message'] = $file['message'];
			exit(json_encode($result));
		}

        if (function_exists('file_remote_upload'))
		{
			$remote = file_remote_upload($file['path']);
			if (is_error($remote))
			{
				$result['message'] = $remote['message'];
				exit(json_encode($result));
			}
		}
		$result['status'] = '1';
		$result['url'] = $file['url'];
		$result['error'] = 0;
		$result['filename'] = $file['path'];
		$result['url'] = trim($_W['attachurl'] . $result['filename']);
		// pdo_insert('core_attachment', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'filename' => $uploadfile['name'], 'attachment' => $result['filename'], 'type' => 1, 'createtime' => TIMESTAMP));
		exit(json_encode($result));
	}

	public function get_file(){
		echo json_encode( $_FILES['uploadedfile']);
		// $path = ATTACHMENT_ROOT ."images/{$uniacid}/" . date('Y/m/');
        $local_path  = ATTACHMENT_ROOT ."images/{$uniacid}/" . date('Y/05/');//服务器文件的存放路径

        $img_name = basename( $_FILES['uploadedfile']['name']);//服务器中的图片名（uploadedfile是键值名，可自行设定）

        $target_path = $local_path.$img_name;

        $urlfile = $_SERVER['HTTP_HOST']."/attachment/"."images/{$uniacid}/" . date("Y/05/").$img_name;  //文件地址

        $result = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);

        if($result) {

            echo json_encode(array("status"=>1,"success"=>"图片上上传成功","url"=>$urlfile));

        } else{

            echo json_encode(array('status'=>0,"success"=>"图片上传失败"));

        }
    }

	public function investment_record()
	{
		global $_W;
		global $_GPC;

		$type = $_GPC['type'];
		if ($type == 1) $type2 = 2;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$openid = $_W['openid'];
		$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid order by g.createtime desc" . ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		// dump($openid);
		// dump($list);die;
		if ($type == 3) { //查询转币记录

			$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_zhuanzhang") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.openid=:openid order by g.createtime desc" . ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			foreach ($list as $key => $val) {
				$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
			}

			$total = pdo_fetchcolumn("select count(g.id) from" . tablename("ewei_zhuanzhang") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.openid=:openid order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			$data = array('status' => 1, "result" => array('list' => $list, 'total' => $total, 'pagesize' => $psize));
			$data = array('list' => $list, 'total' => $total, 'pagesize' => $psize);

			returnJson($data);
		}
		if ($type == 5) {
			$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.openid=:openid and g.type=5 order by g.createtime desc" . ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			foreach ($list as $key => $val) {
				$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
			}
			$total = pdo_fetchcolumn("select count(g.id) from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.openid=:openid and g.type=5 order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			$data = array('status' => 1, "result" => array('list' => $list, 'total' => $total, 'pagesize' => $psize));
			$data = array('list' => $list, 'total' => $total, 'pagesize' => $psize);

			// dump($list);die;
			returnJson($data);
		}

		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
		}

		$total = pdo_fetchcolumn("select count(g.id) from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		$data = array('status' => 1, "result" => array('list' => $list, 'total' => $total, 'pagesize' => $psize));
		$data = array('list' => $list, 'total' => $total, 'pagesize' => $psize);
		returnJson($data);
	}

	public function income_record()
	{
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];
		
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

			$data = array('list' => $list, 'money' => $summoeny);

			returnJson($data);
		}

		$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_order_goods1") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
		}

		$count =  pdo_fetch("select sum(g.money) as money,sum(g.money2) as money2 from" . tablename("ewei_shop_order_goods1") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		$data = array('list' => $list, 'money' => $count['money'] + $count['money2']);

		returnJson($data);
	}

	public function today_record(){
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

			returnJson($data);
		}

		$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_order_goods1") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.createtime>=$start and g.createtime<=$end and g.type='$type' and g.openid=:openid order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
		}

		$count =  pdo_fetch("select sum(g.money) as money,sum(g.money2) as money2  from" . tablename("ewei_shop_order_goods1") . "g left join" . tablename("ewei_shop_member") . "m on g.openid2=m.openid" . " where g.uniacid=:uniacid and g.createtime>=$start and g.createtime<=$end and g.type='$type' and g.openid=:openid", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		$data = array('list' => $list, 'money' => $count['money'] + $count['money2']);

		returnJson($data);
	}

	public function payment()
	{
		global $_W;
		global $_GPC;

		$sys = pdo_fetch("select bibi from " . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		$member = m('member')->getMember($_W['openid'], true);
		$list = pdo_fetch("select * from " . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		$data = array('zfb' => $list['zfb'], 'zfbfile' => $list['zfbfile'], 'wx' => $list['wx'], 'weixinfile' => $list['weixinfile'], 'yhk' => $list['yhk'], 'yhkfile' => $list['yhkfile'], 'add' => $list['add'],'bibi'=>$sys['bibi'],'credit1'=>$member['credit1']);
		returnJson(array('list' => $data));
	}


	public function wechat_complete1()
	{
		global $_W;
		global $_GPC;


		$money = $_GPC['money'];
		$url = $_GPC['url'];
		$member = m('member')->getMember($_W['openid'], true);
		$sys = pdo_fetch("select *from " . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);

		if (empty($url)) returnJson(-1, "请输入您要投资的数量");
		if (empty($url)) returnJson(-1, "请上传到您的支付凭证");

		if (($member['credit1'] + $money) > $sys['bibi']) returnJson(-1, "您的投资已超过上限");


		$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'type' => 1, 'title' => '资产投资', 'status' => 0, 'money' => $money, 'credit' => $money, 'createtime' => time(), 'url' => $url);


		$result = pdo_insert("ewei_shop_member_log", $data);

		// if($member['type']==0){
		// 	pdo_update("ewei_shop_member"," type='1' ",array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid']));
		// }

		if ($result) {
			returnJson(array());
		}
	}

	public function xiaji_get_list()
	{
		
		global $_W;
		global $_GPC;

		require EWEI_SHOPV2_PLUGIN . 'commission/core/model.php';
		$commission = new CommissionModel;
		
		$openid = $_W['openid'];
		$member = $commission->getInfo($openid);
		$total_level = 0;
		$level = intval($_GPC['level']);
		((3 < $level) || ($level <= 0)) && ($level = 1);
		$condition = '';
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$ass = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = ' . $_W['uniacid']);
		$arr = $this->digui($ass, $member['id']);

		// show_json($arr);
		
		foreach ($arr as $key => $val) {
			$ids .= $val['id'] . ",";
		}

		$ids_1 = substr($ids, 0, -1);
		if ($ids_1) {
			$condition = "and id in ($ids_1)";
		}
		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = ' . $_W['uniacid'] . ' ' . $condition . '  ORDER BY isagent desc,id desc limit ' . (($pindex - 1) * $psize) . ',' . $psize);

		foreach ($list as &$row) {
			foreach ($arr as $key => $val) {    //给每个会员附加代数
				if ($row['id'] == $val['id']) {
					$row['type'] = $val['type'];
				}
			}
			//给每个会员加入等级
			$level = pdo_fetch("select levelname from" . tablename("ewei_shop_member_level") . "where uniacid=:uniacid and id=:id", array(':uniacid' => $_W['uniacid'], ':id' => $row['level']));
			//			var_dump($level);

			$row['level'] = $level['levelname'];
			if ($member['isagent'] && $member['status']) {
				$info = $commission->getInfo($row['openid'], array('total'));
				$row['commission_total'] = $info['commission_total'];
				$row['agentcount'] = $info['agentcount'];
				$row['agenttime'] = date('Y-m-d H:i', $row['agenttime']);
			}

			$total_level = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $member['id'], ':uniacid' => $_W['uniacid']));
			$ordercount = pdo_fetchcolumn('select count(id) from ' . tablename('ewei_shop_order') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
			$row['ordercount'] = number_format(intval($ordercount), 0);
			$moneycount = pdo_fetchcolumn('select sum(og.realprice) from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id where o.openid=:openid  and o.status>=1 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
			$row['moneycount'] = number_format(floatval($moneycount), 2);
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
		}

		unset($row);

		//根据代数升序

		$type = array_column($list, 'type');
		array_multisort($type, SORT_ASC, $list);

		returnJson(array('list' => $list, 'total' => $total_level, 'sum' => count($arr), 'pagesize' => $psize));
	}


	public function my_info(){
		global $_W;
		global $_GPC;
		//控制查询整个系统进入人时是否升级
		// $a = p("commission")->lingdaolevel();
		// var_dump($a);exit();
		$this->diypage('member');
		$member = m('member')->getMember($_W['openid'], true);
		$level = m('member')->getLevel($_W['openid']);

		//客服
		$sys = pdo_fetch("select kefufile,wxkffile from" . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);

		//会员等级和市场等级
		$huiyuanlevel = pdo_fetch("select l1.levelname as levelname1,l3.levelname as levelname3 from" . tablename("ewei_shop_member") . " m left join " . tablename("ewei_shop_commission_level") . " l1 on m.agentlevel = l1.id left join " . tablename("ewei_shop_commission_level3") . " l3 on m.agentlevel3 = l3.id " . " where m.uniacid=" . $_W['uniacid'] . " and m.openid=:openid ", array(':openid' => $_W['openid']));

		// var_dump($huiyuanlevel);

		//--------------释放积分---------------
		$beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endToday = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;

		//查看今日是否已释放
		$arr = pdo_fetch("select * from " . tablename("ewei_shop_receive_hongbao") . "where openid=:openid and time>=$beginToday and time<=$endToday  and uniacid=:uniacid", array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));


		$openid = $member['openid'];

		//获取该会员最高的投资倍率
		$arr1 = pdo_fetch("select max(section) as section from " . tablename("ewei_shop_member_log") . "where uniacid=" . $_W['uniacid'] . " and openid='$openid'");

		//最高倍率相应的释放比例
		$result  = pdo_fetch("select * from " . tablename("ewei_shop_commission_level4") . "where uniacid=:uniacid and id=:id", array(':uniacid' => $_W['uniacid'], ':id' => $arr1['section']));

		//释放的比例
		$proportion = $result['commission1'] + $result['commission2'];

		//静态账户获得金额
		$money = round($proportion * $member['credit1'] * 0.8 * 0.01, 2);

		//复投账户获得金额
		$money2 = round($proportion * $member['credit1'] * 0.2 * 0.01, 2);

		$money3 = $money + $money2;

		if (!$arr) {  //当今日未领取红包时才能领取
			if ($money) {

				if ($_POST['type'] == '1') {
					//充值
					m('member')->setCredit($_W['openid'], 'credit3', $money);
					m('member')->setCredit($_W['openid'], 'credit4', $money2);
					// 扣积分
					m('member')->setCredit($_W['openid'], 'credit1', -$money3);
					//管理奖

					m('common')->shangji1($member['agentid'], $member['openid'], $money3, 2);

					//领取红包记录
					pdo_insert("ewei_shop_receive_hongbao", array('openid' => $_W['openid'], 'money' => $money, 'money2' => $money2, 'type' => '1', 'time' => time(), 'uniacid' => $_W['uniacid']));
					show_json('1');
				}
			}
		} else {
			$type = 1;   //已释放
		}
		//-------------积分释放---------------

		//退出机制---------------------
		//查看该会员的总投资金额
		$arr2 = pdo_fetch("select sum(money) as money from" . tablename("ewei_shop_member_log") . "where uniacid=" . $_W['uniacid'] . " and openid=:openid and type=1", array(':openid' => $_W['openid']));

		$money4 = $arr2['money'] * 0.5;



		$open_creditshop = p('creditshop') && $_W['shopset']['creditshop']['centeropen'];
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$statics = array('order_0' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and status=0 and (isparent=1 or (isparent=0 and parentid=0)) and paytype<>3 and uniacid=:uniacid and istrade=0 and userdeleted=0', $params), 'order_1' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and (status=1 or (status=0 and paytype=3)) and isparent=0 and refundid=0 and uniacid=:uniacid and istrade=0 and userdeleted=0', $params), 'order_2' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and (status=2 or (status=1 and sendtype>0)) and isparent=0 and refundid=0 and uniacid=:uniacid and istrade=0 and userdeleted=0', $params), 'order_4' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and refundstate=1 and isparent=0 and uniacid=:uniacid and istrade=0 and userdeleted=0', $params), 'cart' => pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('ewei_shop_member_cart') . ' where uniacid=:uniacid and openid=:openid and deleted=0', $params), 'favorite' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_favorite') . ' where uniacid=:uniacid and openid=:openid and deleted=0', $params));
		} else {
			$statics = array('order_0' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and ismr=0 and status=0 and isparent=0 and paytype<>3 and uniacid=:uniacid and istrade=0 and userdeleted=0', $params), 'order_1' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and ismr=0 and (status=1 or (status=0 and paytype=3)) and isparent=0 and refundid=0 and uniacid=:uniacid and istrade=0 and userdeleted=0', $params), 'order_2' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and ismr=0 and (status=2 or (status=1 and sendtype>0)) and isparent=0 and refundid=0 and uniacid=:uniacid and istrade=0 and userdeleted=0', $params), 'order_4' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and ismr=0 and refundstate=1 and isparent=0 and uniacid=:uniacid and istrade=0 and userdeleted=0', $params), 'cart' => pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('ewei_shop_member_cart') . ' where uniacid=:uniacid and openid=:openid and deleted=0 and selected = 1', $params), 'favorite' => ($merch_plugin && $merch_data['is_openmerch'] ? pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_favorite') . ' where uniacid=:uniacid and openid=:openid and deleted=0 and `type`=0', $params) : pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_favorite') . ' where uniacid=:uniacid and openid=:openid and deleted=0', $params)));
		}
		$newstore_plugin = p('newstore');
		if ($newstore_plugin) {
			$statics['norder_0'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and ismr=0 and status=0 and isparent=0 and istrade=1 and uniacid=:uniacid', $params);
			$statics['norder_1'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and ismr=0 and status=1 and isparent=0 and istrade=1 and refundid=0 and uniacid=:uniacid', $params);
			$statics['norder_3'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and ismr=0 and status=3 and isparent=0 and istrade=1 and uniacid=:uniacid', $params);
			$statics['norder_4'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and ismr=0 and refundstate=1 and isparent=0 and istrade=1 and uniacid=:uniacid', $params);
		}
		$hascoupon = false;
		$hascouponcenter = false;
		$plugin_coupon = com('coupon');
		if ($plugin_coupon) {
			$time = time();
			$sql = 'select count(*) from ' . tablename('ewei_shop_coupon_data') . ' d';
			$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
			$sql .= ' where d.openid=:openid and d.uniacid=:uniacid and  d.used=0 ';
			$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . ')) order by d.gettime desc';
			$statics['coupon'] = pdo_fetchcolumn($sql, array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
			$pcset = $_W['shopset']['coupon'];
			if (empty($pcset['closemember'])) {
				$hascoupon = true;
			}
			if (empty($pcset['closecenter'])) {
				$hascouponcenter = true;
			}
			if ($hascoupon) {
				$couponnum = com('coupon')->getCanGetCouponNum($_W['merchid']);
			}
		}
		$hasglobonus = false;
		$plugin_globonus = p('globonus');
		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !(empty($plugin_globonus_set['open'])) && !(empty($plugin_globonus_set['openmembercenter']));
		}
		$haslive = false;
		$haslive = p('live');
		if ($haslive) {
			$live_set = $haslive->getSet();
			$haslive = $live_set['ismember'];
		}
		$hasThreen = false;
		$hasThreen = p('threen');
		if ($hasThreen) {
			$plugin_threen_set = $hasThreen->getSet();
			$hasThreen = !(empty($plugin_threen_set['open'])) && !(empty($plugin_threen_set['threencenter']));
		}
		$hasauthor = false;
		$plugin_author = p('author');
		if ($plugin_author) {
			$plugin_author_set = $plugin_author->getSet();
			$hasauthor = !(empty($plugin_author_set['open'])) && !(empty($plugin_author_set['openmembercenter']));
		}
		$hasabonus = false;
		$plugin_abonus = p('abonus');
		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !(empty($plugin_abonus_set['open'])) && !(empty($plugin_abonus_set['openmembercenter']));
		}
		$card = m('common')->getSysset('membercard');
		$actionset = m('common')->getSysset('memberCardActivation');
		$haveverifygoods = m('verifygoods')->checkhaveverifygoods($_W['openid']);
		if (!(empty($haveverifygoods))) {
			$verifygoods = m('verifygoods')->getCanUseVerifygoods($_W['openid']);
		}
		$showcard = 0;
		if (!(empty($card))) {
			$membercardid = $member['membercardid'];
			if (!(empty($membercardid)) && ($card['card_id'] == $membercardid)) {
				$cardtag = '查看微信会员卡信息';
				$showcard = 1;
			} else if (!(empty($actionset['centerget']))) {
				$showcard = 1;
				$cardtag = '领取微信会员卡';
			}
		}
		$hasqa = false;
		$plugin_qa = p('qa');
		if ($plugin_qa) {
			$plugin_qa_set = $plugin_qa->getSet();
			if (!(empty($plugin_qa_set['showmember']))) {
				$hasqa = true;
			}
		}
		$hassign = false;
		$com_sign = p('sign');
		if ($com_sign) {
			$com_sign_set = $com_sign->getSet();
			if (!(empty($com_sign_set['iscenter'])) && !(empty($com_sign_set['isopen']))) {
				$hassign = ((empty($_W['shopset']['trade']['credittext']) ? '积分' : $_W['shopset']['trade']['credittext']));
				$hassign .= ((empty($com_sign_set['textsign']) ? '签到' : $com_sign_set['textsign']));
			}
		}
		$hasLineUp = false;
		$lineUp = p('lineup');
		if ($lineUp) {
			$lineUpSet = $lineUp->getSet();
			if (!(empty($lineUpSet['isopen'])) && !(empty($lineUpSet['mobile_show']))) {
				$hasLineUp = true;
			}
		}
		$wapset = m('common')->getSysset('wap');
		$appset = m('common')->getSysset('app');
		$needbind = false;
		if (empty($member['mobileverify']) || empty($member['mobile'])) {
			if ((empty($_W['shopset']['app']['isclose']) && !(empty($_W['shopset']['app']['openbind']))) || !(empty($_W['shopset']['wap']['open'])) || $hasThreen) {
				$needbind = true;
			}
		}
		if (p('mmanage')) {
			$roleuser = pdo_fetch('SELECT id, uid, username, status FROM' . tablename('ewei_shop_perm_user') . 'WHERE openid=:openid AND uniacid=:uniacid AND status=1 LIMIT 1', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
		}


		returnJson(['member'=>$member,'huiyuanlevel'=>$huiyuanlevel,'money'=>$money,'money2'=>$money2,'money4'=>money4,'arr'=>$arr,'arr2'=>$arr2]);
	}

	public function my_wallet(){
		global $_W;
		global $_GPC;

		$this->diypage('member');

		$member = m('member')->getMember($_W['openid'], true);
		returnJson(['member'=>$member]);
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['trade'];

		if (empty($set['withdraw'])) {
			returnJson(array(), '系统未开启提现!',-1);
		}
		$set_array = array();

		//判断该会员是否绑定钱包地址和二维码
		$member = m('member')->getMember($_W['openid'], true);
		if (!$member['walletcode'] || !$member['walletaddress']) {
			returnJson(array(), '请完善您的资料!',-1);
		}

		$money = floatval($_GPC['money']);
		if (!floor($money / $set['withdrawmoney']))  returnJson(array(), "提现的金额必须是" . $set['withdrawmoney'] . "的倍数",-1);
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
		$apply['payment'] = 1;
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
		returnJson(array());
	}

	public function zhuangzhangis()
	{
		global $_W;
		global $_GPC;

		$money = $_GPC['money'];
		// $moneysxf = $_GPC['moneysxf'];
		$ass = pdo_fetch("select zhuanzhangsxf from " . tablename("ewei_shop_sysset") . " where uniacid=:uniacid ", array(':uniacid' => $_W['uniacid']));
		$moneysxf = $ass['zhuanzhangsxf'];
		$mid = $_GPC['id'];

		$member = m('member')->getMember($_W['openid'], true);
		$member2 = pdo_fetch("select * from " . tablename("ewei_shop_member") . "where uniacid=" . $_W['uniacid'] . " and id='$mid'");

		if (!$money) returnJson(array(), "请输入转账金额",-1);
		if (!$mid) returnJson(array(), "请输入转账人id",-1);
		if ($member['credit2'] < $money) returnJson(array(), "您输入的转账金额过大，账户余额不足",-1);
		// returnJson(array()mid);
		if ($member2['openid'] == $_W['openid']) returnJson(array(), "不能对自己进行转账",-1);

		$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'openid2' => $member2['openid'], 'money' => $money, 'money2' => $moneysxf, 'createtime' => time());

		//添加转账记录
		pdo_insert("ewei_zhuanzhang", $data);

		//向对方账户打钱
		m('member')->setCredit($member2['openid'], 'credit2', $money - $moneysxf);
		//自己扣钱
		m('member')->setCredit($member['openid'], 'credit2', -$money);
		returnJson(array(), "转账成功");
	}

	public function money_log()
	{
		global $_W;
		global $_GPC;

		$type = $_GPC['type'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$openid = $_W['openid'];
		$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.openid='$openid' order by g.createtime desc");
		$zhuanzhang = pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_zhuanzhang") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.openid=$openid order by g.createtime desc");
		foreach ($zhuanzhang as $k => $v) {
			$zhuanzhang[$k]['openid'] = substr($v['openid'], -11);
			$zhuanzhang[$k]['openid2'] = substr($v['openid2'], -11);
			$zhuanzhang[$k]['createtime'] = date("Y-m-d", $v['createtime']);
		}
		foreach ($list as $key => $val) {
			$list[$key]['shouxufei'] = $val['money1'] - $val['money'];
			$list[$key]['createtime'] = date("Y-m-d", $val['createtime']);
		}
		returnJson(['list'=>$list,'zhuanzhang'=>$zhuanzhang]);
	}

	public function pay_management() 
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid'], true);
		$data['bankid'] = $member['bankid'];
		$data['bankname'] = $member['bankname'];
		$data['bank'] = $member['bank'];
		$data['zfbfile'] = $member['zfbfile'];
		$data['wxfile'] = $member['wxfile'];
		returnJson($data);
	}

	public function pay_submit(){
		global $_W;
		global $_GPC;
		if($_GPC['adress'])  $data['walletaddress'] = $_GPC['adress'];
		if($_GPC['url'])  $data['walletcode'] = $_GPC['url'];
		if($_GPC['zfbfile'])  $data['zfbfile'] = $_GPC['zfbfile'];
		if($_GPC['wxfile'])  $data['wxfile'] = $_GPC['wxfile'];
		if($_GPC['bankid'])  $data['bankid'] = $_GPC['bankid'];
		if($_GPC['bankname'])  $data['bankname'] = $_GPC['bankname'];
		if($_GPC['bank'])  $data['bank'] = $_GPC['bank'];
	
		// show_json($data);
		$result = pdo_update("ewei_shop_member",$data,array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid']));

		if($result){
			returnJson(array());
		}else{
			returnJson(array(),'失败',-1);
		}
	}

	public function article_getlist()
	{
		global $_W;
		global $_GPC;
		$page = intval($_GPC['page']);
		$article_sys = pdo_fetch('select * from' . tablename('ewei_shop_article_sys') . 'where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		$article_sys['article_image'] = tomedia($article_sys['article_image']);
		$pindex = max(1, $page);
		$psize = (empty($article_sys['article_shownum']) ? '20' : $article_sys['article_shownum']);

		if ($article_sys['article_temp'] == 0) {
			$articles = pdo_fetchall('SELECT a.id, a.article_title, a.resp_img, a.article_rule_credit, a.article_rule_money, a.resp_desc, a.article_category FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category  WHERE a.article_state=1 and article_visit=0 and c.isshow=1 and a.uniacid= :uniacid order by a.displayorder desc, a.article_date desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid']));
		}
		else if ($article_sys['article_temp'] == 1) {
			$articles = pdo_fetchall('SELECT distinct article_date_v FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and article_visit=0 and c.isshow=1 and a.uniacid=:uniacid order by a.article_date_v desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid']), 'article_date_v');

			foreach ($articles as &$a) {
				$a['articles'] = pdo_fetchall('SELECT id,article_title,article_date_v,resp_img,resp_desc,article_date_v,resp_desc,article_category FROM ' . tablename('ewei_shop_article') . ' WHERE article_state=1 and article_visit=0 and uniacid=:uniacid and article_date_v=:article_date_v order by article_date desc ', array(':uniacid' => $_W['uniacid'], ':article_date_v' => $a['article_date_v']));
			}

			unset($a);
		}
		else {
			if ($article_sys['article_temp'] == 2) {

				$categorys = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_article_category') . ' WHERE uniacid=:uniacid and isshow=1 order by displayorder desc ', array(':uniacid' => $_W['uniacid']));

				$cate = intval($_GPC['cateid']);
				$where = ' and article_visit=0';

				if (0 < $cate) {
					$where = ' and article_category=' . $cate . ' ';
				}

				$articles = pdo_fetchall('SELECT a.id, a.article_title, a.resp_img, a.article_rule_credit, a.article_rule_money, a.article_author, a.article_date_v, a.resp_desc, a.article_category FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and c.isshow=1 and a.uniacid=:uniacid ' . $where . ' order by a.displayorder desc, a.article_date_v desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid']));
			}
		}
		
		if (!empty($articles)) {
			returnJson(['article_sys'=>$article_sys,'categorys'=>$categorys,'articles'=>$articles]);
		}
	}

	public function out()
	{
		global $_W;
		global $_GPC;

		$money = $_GPC['money'];
		if (empty($_W['openid'])) {
			returnJson(array(), "openid不能为空", 0);
		}
		
		$time = time();
		$user = pdo_fetch("select openid,createtime from" . tablename("ewei_shop_member") . "where openid='" . $_W['openid'] . "'");
		$time_one = $user['createtime'] + '2592000';
		if ($time > $time_one) {
			returnJson(array(), "账户已注册满一个月不能进行退出机制！", -1);
		}
		// $money_receive = 0;
		// $receive = pdo_fetchall("select * from" . tablename("ewei_shop_receive_hongbao") . "where openid='" . $_W['openid'] . "'");
		// foreach ($receive as $key => $val) {
		// 	$money_receive += $val['money'] + $val['money2'];
		// }
		// if ($money_receive > $money) {
		// 	returnJson(array(), "当前收益超出投资币数不能进行退出机制！", -1);
		// }
		m('member')->setCredit($_W['openid'], 'credit2', $money);

		pdo_update("ewei_shop_member", array('type' => 2, 'credit5' => $money, 'agentlevel' => 0, 'agentlevel2' => 0, 'agentlevel3' => 0), array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));

		returnJson(array());
	}

	public function download_app()
	{
		$data['androidurl'] = '';
		$data['iosurl'] = '';

		returnJson($data);
	}

	public function login()
	{
		global $_W;
		global $_GPC;
		

		$mobile = trim($_GPC['mobile']);
		$pwd = trim($_GPC['pwd']);
		$member = pdo_fetch('select openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and mobileverify=1 and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
		if (empty($member)) {
			returnJson(array(),'用户不存在',-1);
		}
		
		if (md5($pwd . $member['salt']) !== $member['pwd']) {
			returnJson(array(),'用户或密码错误',-1);
		}
		
		$data['userid'] = $member['openid'];
		// $data['salt'] = 'eth';
		$cany = json_encode($data);
		$cany = base64_encode($cany);
		unset($member['openid']);
		unset($member['pwd']);
		unset($member['salt']);
		$member['userid'] = $cany;
		returnJson($member);
	}

	public function reg_updpwd(){
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];
		$mobile = $_GPC['mobile'];
		$code = $_GPC['code'];
		$pwd = $_GPC['pwd'];

		if(!$mobile || !$code || !$pwd || !$type){
			returnJson(array(),'参数错误！','-1');
		}
		
		if( $this->phoneAuth($mobile,$code) === '-1' ){
			returnJson(array(),'验证码已过期！','-1');
		}else if( !$this->phoneAuth($mobile,$code) ){
			returnJson(array(),'验证码错误！','-1');
		}

		$member = pdo_fetch('select id,openid,mobile,pwd,salt,credit1,credit2, createtime from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid and mobileverify=1 limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
		
		if($type=='sms_changepwd'){
			$salt = ((empty($member) ? '' : $member['salt']));
			if (empty($salt)){
				$salt = random(16);
				while (1)
				{
					$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where salt=:salt limit 1', array(':salt' => $salt));
					if ($count <= 0)
					{
						break;
					}
					$salt = random(16);
				}
			}
			pdo_update('ewei_shop_member', array('mobile' => $mobile, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'mobileverify' => 1), array('id' => $id, 'uniacid' => $_W['uniacid']));
			returnJson(array());
		}else if($type=='sms_reg'){
			if (!(empty($member))) {
				returnJson(array() ,'此手机号已注册, 请直接登录' ,-1);
			}
			$salt = ((empty($member) ? '' : $member['salt']));
			if (empty($salt)) {
				$salt = m('account')->getSalt();
			}
			$openid = ((empty($member) ? '' : $member['openid']));
			$nickname = ((empty($member) ? '' : $member['nickname']));
			if (empty($openid)) {
				$openid = 'wap_user_' . $_W['uniacid'] . '_' . $mobile;
				$nickname = substr($mobile, 0, 3) . 'xxxx' . substr($mobile, 7, 4);
			}
			$data = array('uniacid' => $_W['uniacid'], 'mobile' => $mobile, 'nickname' => $nickname, 'openid' => $openid, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'createtime' => time(), 'mobileverify' => 1, 'comefrom' => 'mobile');
			$res = pdo_insert('ewei_shop_member', $data);
			if($res){
				$d['userid'] = $data['openid'];
				// $data['salt'] = 'eth';
				$cany = json_encode($d);
				$cany = base64_encode($cany);
				$d['userid'] = $cany;
				$d['mobile'] = $data['mobile'];
				returnJson($d);
			}
			returnJson(array(),'注册失败！',-1);

		}else{
			returnJson(array(),'参数错误！','-1');
		}
	}

	public function yijianfutou()
	{
		global $_W;
		global $_GPC;
		$money = $_GPC['money'];

		$type = $_GPC['type'];

		if (empty($money)) returnJson(array(),"复投金额不能为0",-1);

		$member = m('member')->getMember($_W['openid'], true);

		$sys = pdo_fetch("select *from " . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);

		if (($member['credit1'] + $money) > $sys['bibi']) returnJson(array(),"您的投资已超过上限",-1);

		$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'type' => 1, 'money' => $money, 'credit' => $money, 'createtime' => time(), 'section' => $ass['id']);

		$credit = 0;
		$receive_hongbao = pdo_fetchall("select * from" . tablename("ewei_shop_receive_hongbao") . "where openid='" . $_W['openid'] . "'");
		foreach ($receive_hongbao as $k => $val) {
			$credit += $val['money'] + $val['money2'];
		}
		//最高倍率相应的释放比例
		$result  = pdo_fetch("select * from" . tablename("ewei_shop_commission_level4") . "where uniacid=" . $_W['uniacid'] . " and start<=" . $member['credit1'] . " and end>=" . $member['credit1']);

		//释放的比例
		$money_propor = $result['multiple'] * $member['credit1'];
		if ($credit > $money_propor) {

			if ($money != $member['credit1']) {
				returnJson(array(),"激活复投账户必须等于'" . $member['credit1'] . "'/ETH",-1);
			}
		}
		// show_json($data);
		if ($type == 2) {  //自由账户一键复投

			if ($money > $member['credit2']) returnJson(array(),"您自由账户余额不足",-1);

			$data['status'] = 1;
			$data['payment'] = 1;
			$data['title'] = "自由账户一键复投";
			$data['front_money'] = $member['credit2'];
			$data['after_money'] = $member['credit2'] - $money;
			m('member')->setCredit($_W['openid'], 'credit2', -$money);
		} else if ($type == 4) {

			if ($money > $member['credit4']) returnJson(array(),"您复投账户余额不足",-1);

			$data['status'] = 2;
			$data['payment'] = 2;
			$data['title'] = "复投账户一键复投";
			$data['front_money'] = $member['credit4'];
			$data['after_money'] = $member['credit4'] - $money;


			m('member')->setCredit($_W['openid'], 'credit4', -$money);
		}
		// show_json($data);
		if ($credit >= $money_propor) {
			pdo_update("ewei_shop_member", "credit1='$money',suoding=0 ", array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));
			pdo_delete("ewei_shop_receive_hongbao", array('openid' => $_W['openid']));
			pdo_delete("ewei_shop_member_log", array('openid' => $_W['openid']));
			pdo_delete("ewei_zhuanzhang", array('openid' => $_W['openid']));
			pdo_delete("ewei_shop_order_goods1", array('openid' => $_W['openid']));
		} else {
			//向投资余额打款
			m('member')->setCredit($_W['openid'], 'credit1', $money);

			if ($member['type'] == 0) {
				pdo_update("ewei_shop_member", " type='1' ", array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));
			}
		}
		$result = pdo_insert("ewei_shop_member_log", $data);
		if ($result) returnJson(array(),"一键复投成功",1);
	}

	public function fotou_info(){
		$member = m('member')->getMember($_W['openid'], true);
		returnJson(['credit1'=>$member['credit1'],'credit4'=>$member['credit4'],'credit2'=>$member['credit2']]);
	}

}
?>
