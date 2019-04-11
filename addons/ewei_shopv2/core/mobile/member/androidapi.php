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
		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}
		$sale = pdo_fetch("select * from".tablename("ewei_shop_lottery2")."where uniacid=".$_W['uniacid']);

		//今日开始时间和结束时间戳
        $start = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $end = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

		//查出今日投资的前10名
		$investment = pdo_fetchall("select l.openid,m.avatar,m.nickname,m.mobile,sum(l.money) as moneys from ".tablename("stakejilu")." l left join ".tablename("ewei_shop_member")." m on l.openid=m.openid "." where l.uniacid=".$_W['uniacid']." and l.thigh=0 and l.createtime>'$start' and l.createtime<'$end' group by l.openid order by moneys desc limit 0,10");

		// var_dump($investment);

		//投资排名的中奖额度
		$touzi = unserialize($sale['investment']);

		$i = 1;
		foreach ($investment as $key => $val) {

			if($touzi['investment'.$i]){

				$investment[$key]['type'] = $i;
				$investment[$key]['yuji'] = round($touzi['investment'.$i]*$sale['sum']*0.01,2);

			}

			$i++;
		}
		$data = array('status'=>0,"list"=>$investment);
		echo json_encode($data);exit();
		// var_dump($investment);

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
					returnJson([], "下注失败!每日下注时间为下午20点前.",0);
				}
				// $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
				$member = m('member')->getMember($_W['openid'], true);

				$sale = pdo_fetch("select * from" . tablename("ewei_shop_lottery2") . "where uniacid=" . $_W['uniacid']);

				$payment = $_GPC['payment'];

				$money   = $_GPC['money'];

				$list    = $_GPC['list'];

				if(empty($list)){
					  returnJson([], "下注失败!下注号码不能为空.",0);
				}
				if($money < 0){
					returnJson([], "下注失败!金额必须大于0.",0);
				}
				if($payment < 1){
					returnJson([], "下注失败!请选择支付方式.",0);
			    }
				// show_json($list);

				if ($payment == 1) {  //ETH支付

					if ($member['credit2'] < $money)  returnJson([], "您的自由账户余额不足",0);
					//扣除该会员的下注金额
					m('member')->setCredit($_W['openid'], 'credit2', -$money);
					$title = "自由账户进行下注减少" . $money;
					$front_money = $member['credit2'];
				} else if ($payment == 2) {  //复投账户支付

					if ($member['credit4'] < $money)  returnJson([], "您的复投账户余额不足",0);
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
				returnJson([], "下注成功",1);
			}
	}



	//游戏规则介绍
	public function fucairule(){
		global $_W;
		global $_GPC;

		$data = pdo_fetch("select * from ".tablename("ewei_shop_lottery2")."where uniacid=".$_W['uniacid']);
		// var_dump($data['contract']);
		$data = array('status'=>1,'list'=>$data['contract']);
		echo json_encode($data);
	}

	//押注记录
	public function stakejiluis(){
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

		$data = array('status'=>1,"result"=>array('list' => $list, 'total' => $total, 'pagesize' => $psize));
		echo json_encode($data);exit();

	}

	//中奖记录
	public function winningrecordis(){
		global $_W;
		global $_GPC;

		$id = $_GPC['id'];
		if($id){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$id'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_decode($data);
		}

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

		$data = array('status'=>1,"result"=>array('list' => $list, 'total' => $total, 'pagesize' => $psize));
		echo json_encode($data);exit();


	}
	//3d彩票

	//c2c
	//挂卖中心
	public function guamairecordjilu(){
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
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$openid = $_W['openid'];
		$status = $_GPC['status'];
		if(empty($status)){
			$data = array('status'=>0,"fail"=>"请上传订单状态");
			echo json_encode($data);exit();
		}

		$select = 'SELECT g.id,g.openid,g.openid2,g.money,g.createtime,g.type,g.price,g.trx,g.status,m.nickname,m.zfbfile,m.wxfile,m.bankid,m.bankname,m.bank,m2.nickname as nickname2 FROM ';
		$tablename = tablename('guamai').' g left join '.tablename('ewei_shop_member').' m ON m.openid=g.openid left join'.tablename('ewei_shop_member').' m2 ON m2.openid=g.openid2';
		$where = " WHERE g.uniacid=:uniacid AND g.type=:type AND (g.status='$status') ";
		$where .= " ORDER BY g.status = '1' DESC,g.openid = '$openid' DESC,g.openid2 = '$openid' DESC,g.createtime DESC ";
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

		$params[':uniacid'] = $_W['uniacid'];
		$params[':type'] = $type;

		$list = pdo_fetchall($select.$tablename.$where.$limit,$params);
		$total = pdo_fetchcolumn('SELECT count(g.id) FROM '.$tablename.$where, $params);
		// show_json(111);

		foreach ($list as $key=>$val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s",$val['createtime']);
			if($val['zfbfile']) $list[$key]['zfbfile'] = 1;
			if($val['wxfile']) $list[$key]['wxfile'] = 1;
			if($val['bankid'] && $val['bankname'] && $val['bank']) $list[$key]['bank'] = 1;
			//判断该信息是否是自己发布的（未交易时）
			if($val['openid']==$_W['openid'] && $val['status']==0)$list[$key]['self'] = 1; else  $list[$key]['self'] = 0;
			//交易中
			if(($val['openid2']!=$_W['openid'] && $val['openid']!=$_W['openid']) && $val['status']==1)$list[$key]['self3'] = 1; else  $list[$key]['self3'] = 0;
		}

		// show_json($item);


		$data = array('status'=>1,"result"=>array('list' => $list, 'total' => $total, 'pagesize' => $psize));
		echo json_encode($data);exit();
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

	//挂卖订单
	public function hangonsale(){
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

		if($_W['ispost']){

			$type = $_GPC['type'];
			$openid = $_W['openid'];
			$member = m('member')->getMember($_W['openid'], true);
			//价格基础TRX价格  以及手续费
			$sys = pdo_fetch("select trxprice,trxsxf from".tablename("ewei_shop_sysset")."where uniacid=".$_W['uniacid']);
			$start = $sys['trxprice']*(1-0.1);
			$end = $sys['trxprice']*(1+0.1);
			if($_GPC['price']<$start || $_GPC['price']>$end){
				$data = array('status'=>0,"fail"=>"请参考价格建议区间！");
				echo json_encode($data);exit();
			}
			//判断该会员是否上传收款信息
			if(!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])){
				$data = array('status'=>0,"fail"=>"请上传您的收款信息！");
				echo json_encode($data);exit();
			}

			if($member['credit1']<$_GPC['trx2']){
				$data = array('status'=>0,"fail"=>"您的TRX币不足,请尽快充值！");
				echo json_encode($data);exit();
			}

			$data = array('openid'=>$openid,'uniacid'=>$_W['uniacid'],'price'=>$_GPC['price'],'trx'=>$_GPC['trx'],'trx2'=>$_GPC['trx2'],'money'=>$_GPC['money'],'type'=>$type,'status'=>'0','createtime'=>time());

			$result = pdo_insert("guamai",$data);
			// show_json($result);
			if($type == 1){		//卖出

				if($result){    //如果挂卖成功，冻结挂卖的TRX币
					m('member')->setCredit($openid,'credit1',-$_GPC['trx2']);
				}
				$data = array('status'=>1,"success"=>"挂卖成功！");
				echo json_encode($data);exit();
			}else{
				$data = array('status'=>1,"success"=>"挂卖成功！");
				echo json_encode($data);exit();
			}


		}
	}

	//点击买入或卖出按钮
	public function guamaisellout(){

		global $_W;
		global $_GPC;
		$mid = $_GPC['mid'];
		if($mid){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$mid'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}
		//该订单的信息
		$id = $_GPC['id'];
		$op = $_GPC['op'];
		$sell = pdo_fetch("select g.*,m.nickname,m.mobile,m.zfbfile,m.wxfile,m.bankid,m.bankname,m.bank,m2.nickname as nickname2,m2.zfbfile as zfbfile2,m2.wxfile as wxfile2,m2.bankid as bankid2,m2.bankname as bankname2,m2.bank as bank2 from".tablename('guamai').' g left join '.tablename('ewei_shop_member').' m ON m.openid=g.openid left join '.tablename('ewei_shop_member').' m2 ON m2.openid=g.openid2 '." where g.uniacid=".$_W['uniacid']." and g.id='$id'");
		if($op == 1){
			if($sell['zfbfile']) $payment[] = array('name'=>"支付宝",'type'=>'zfb');
			if($sell['wxfile']) $payment[] = array('name'=>"微信",'type'=>'wx');
			if($sell['bank'] &&$sell['bankid'] && $sell['bankname']) $payment[] = array('name'=>"银行",'type'=>'bank');
		}else{
			if($sell['zfbfile2']) $payment[] = array('name'=>"支付宝",'type'=>'zfb');
			if($sell['wxfile2']) $payment[] = array('name'=>"微信",'type'=>'wx');
			if($sell['bank2'] &&$sell['bankid2'] && $sell['bankname2']) $payment[] = array('name'=>"银行",'type'=>'bank');
		}

		if($sell['openid']==$_W['openid']){
			$type = 1;
		}else if($sell['openid2']==$_W['openid']){
			$type = 2;
		}
		if($id && $mid && !$_GPC['file'] && !$_GPC['mairu'] && !$_GPC['maichu']){
			$data = array('status'=>0,"list"=>array('op'=>$op,'type'=>$type,'sell'=>$sell,'zf'=>$payment));
			echo json_encode($data);exit();
		}

		if($_W['ispost']){
			// show_json(123454);
			$type = $_GPC['type'];
			$mobile = $_GPC['mobile'];
			if($type == 1){   //卖出

				com('sms')->send_zhangjun2($mobile, $_GPC['id'],"卖出订单被抢单！");
				// exit();
				// show_json($mobile);
				$result = pdo_update("guamai",array('file'=>$_GPC['file'],'status'=>1,'openid2'=>$_W['openid']),array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

				if($result) echo json_encode(array('status'=>1,'success'=>"抢单成功"));exit();

			}else if($type == 0){  //买入

				$id = $_GPC['id'];

				$op = $_GPC['op'];

				//判断该用户是否有足够的币进行抢单
				$member = m('member')->getMember($_W['openid'], true);
				$sell = pdo_fetch("select g.trx,m.mobile,m2.mobile as mobile2 from".tablename("guamai").' g left join '.tablename('ewei_shop_member').' m ON m.openid=g.openid '.' left join '.tablename('ewei_shop_member').' m2 ON m2.openid=g.openid2 '." where g.uniacid=".$_W['uniacid']." and g.id='$id' and g.type=0");

				if($op == 1){	//买入订单  挂单人付钱
					$result = pdo_update("guamai",array('file'=>$_GPC['file']),array('uniacid'=>$_W['uniacid'],'id'=>$id));

					com('sms')->send_zhangjun2($sell['mobile2'], $id,"买入订单挂单人已上传支付凭证！");

					if($result) echo json_encode(array('status'=>1,'success'=>"挂单人付款成功"));exit();

				}else{

					//判断该会员是否上传收款信息
					if(!$member['zfbfile'] && !$member['wxfile'] && (!$member['bankid'] || !$member['bankname'] || !$member['bank'])){
						echo json_encode(array('status'=>0,'success'=>"请上传支付凭证"));exit();
					}

					if($member['credit1']<$sell['trx']){
						echo json_encode(array('status'=>0,'success'=>"您的TRX不足，请尽快投资"));exit();

					}

					//币足够的时候进行抢单  （扣币）
					m('member')->setCredit($_W['openid'],'credit1',-$sell['trx']);
					$result = pdo_update("guamai",array('status'=>1,'openid2'=>$_W['openid']),array('uniacid'=>$_W['uniacid'],'id'=>$id));

					com('sms')->send_zhangjun2($sell['mobile'], $id,"买入订单被抢单！");

					if($result) echo json_encode(array('status'=>1,'success'=>"抢单成功"));exit();
				}

			}


		}

	}


	//买入卖出的确认收款
	public function guamaiselloutyes(){
		global $_W;
		global $_GPC;
		$mid = $_GPC['mid'];
		if($mid){
			$memberis = pdo_fetch("select * from ".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and id='$mid'");
			$_W['openid'] = $memberis['openid'];
		}else{
			$data = array('status'=>0,"fail"=>"请上传会员的id");
			echo json_encode($data);exit();
		}
		if($_W['ispost']){

			$id = $_GPC['selloutyes'];
			$type = $_GPC['type'];

			if($type){			//卖出订单挂单人点击确认收款

				$sell = pdo_fetch("select g.*,m.mobile,m2.mobile as mobile2,m2.openid as openid2 from".tablename('guamai').' g left join '.tablename('ewei_shop_member').' m ON m.openid=g.openid left join '.tablename('ewei_shop_member').' m2 ON m2.openid=g.openid2 '." where g.uniacid=".$_W['uniacid']." and g.id='$id'");
				// show_json($sell);

				com('sms')->send_zhangjun2($sell['mobile2'], $id,"卖出订单抢单完成！");

				//给抢单人充币
				pdo_update("guamai",array('status'=>2,'endtime'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$id));

				m('member')->setCredit($sell['openid2'],'credit1',$sell['trx']);

				echo json_encode(array('status'=>1,'success'=>"订单完成"));exit();

			}else{			//买入订单抢单人点击确认收款

				$sell = pdo_fetch("select g.*,m.mobile,m2.mobile as mobile2 from".tablename('guamai').' g left join '.tablename('ewei_shop_member').' m ON m.openid=g.openid left join '.tablename('ewei_shop_member').' m2 ON m2.openid=g.openid2 '." where g.uniacid=".$_W['uniacid']." and g.id='$id'");
				// show_json($sell);

				//给挂单人充币
				pdo_update("guamai",array('status'=>2,'endtime'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$id));

				m('member')->setCredit($sell['openid'],'credit1',$sell['trx']);

				com('sms')->send_zhangjun2($sell['mobile'], $id,"买入订单挂单完成！");

				show_json(1,"订单完成");

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

	//修改密码
	public function cahngepwd()
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
		$member = m('member')->getMember($_W['openid'], true);
		$wapset = m('common')->getSysset('wap');

		// show_json(111);
		if ($_W['ispost'])
		{
			$mobile = trim($_GPC['mobile']);
			$verifycode = trim($_GPC['verifycode']);
			$pwd = trim($_GPC['pwd']);

			@session_start();
			$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
			if($_GPC['code'] && ($_GPC['code'] != $verifycode) ){
				show_json(0, '验证码错误或已过期!');
			}else if(!$_GPC['code']){
				if (!(isset($_SESSION[$key])) || ($_SESSION[$key] !== $verifycode) || !(isset($_SESSION['verifycodesendtime'])) || (($_SESSION['verifycodesendtime'] + 600) < time()))
				{
					show_json(0, '验证码错误或已过期!');
				}
			}

			$member = pdo_fetch('select id,openid,mobile,pwd,salt,credit1,credit2, createtime from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid and mobileverify=1 limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
			$salt = ((empty($member) ? '' : $member['salt']));
			if (empty($salt))
			{
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
			unset($_SESSION[$key]);
			echo json_encode(array('status'=>1,'success'=>'修改密码成功'));
		}
		$sendtime = $_SESSION['verifycodesendtime'];
		if (empty($sendtime) || (($sendtime + 60) < time()))
		{
			$endtime = 0;
		}
		else
		{
			$endtime = 60 - time() - $sendtime;
		}

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


	function new_file_upload($data, $type = 'image') {
		$harmtype = array('asp', 'php', 'jsp', 'js', 'css', 'php3', 'php4', 'php5', 'ashx', 'aspx', 'exe', 'cgi');
		if (empty($data)) {
			return error(-1, '没有上传内容');
		}

		global $_W;

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
			return error(-3, '不允许上传此类文件');
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
			return error(-1, '保存上传文件失败');
		}
		$result['path'] = $path.$filename;
		$result['success'] = true;
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

			returnJson($data);
		}
		if ($type == 5) {
			$list =  pdo_fetchall("select g.*,m.nickname from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.openid=:openid and g.type=5 order by g.createtime desc" . ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			foreach ($list as $key => $val) {
				$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
			}
			$total = pdo_fetchcolumn("select count(g.id) from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.openid=:openid and g.type=5 order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			$data = array('status' => 1, "result" => array('list' => $list, 'total' => $total, 'pagesize' => $psize));

			// dump($list);die;
			returnJson($data);
		}

		foreach ($list as $key => $val) {
			$list[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
		}

		$total = pdo_fetchcolumn("select count(g.id) from" . tablename("ewei_shop_member_log") . "g left join" . tablename("ewei_shop_member") . "m on g.openid=m.openid" . " where g.uniacid=:uniacid and g.type='$type' and g.openid=:openid order by g.createtime desc", array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		$data = array('status' => 1, "result" => array('list' => $list, 'total' => $total, 'pagesize' => $psize));

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

		$list = pdo_fetch("select * from " . tablename("ewei_shop_sysset") . "where uniacid=" . $_W['uniacid']);
		$data = array('zfb' => $list['zfb'], 'zfbfile' => $list['zfbfile'], 'wx' => $list['wx'], 'weixinfile' => $list['weixinfile'], 'yhk' => $list['yhk'], 'yhkfile' => $list['yhkfile'], 'add' => $list['add']);
		returnJson(1, array('list' => $data));
	}


	public function wechat_complete()
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
			returnJson([]);
		}
	}

}
?>
