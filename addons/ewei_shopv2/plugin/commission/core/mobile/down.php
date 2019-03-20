<?php

if (!defined('IN_IA')) {

	exit('Access Denied');

}



require EWEI_SHOPV2_PLUGIN . 'commission/core/page_login_mobile.php';

class Down_EweiShopV2Page extends CommissionMobileLoginPage

{

	public function main()

	{

		global $_W;

		global $_GPC;

		$member = $this->model->getInfo($_W['openid']);

		$levelcount1 = $member['level1'];

		$levelcount2 = $member['level2'];

		$levelcount3 = $member['level3'];

		$level1 = $level2 = $level3 = 0;

		$level1 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $member['id'], ':uniacid' => $_W['uniacid']));

		if ((2 <= $this->set['level']) && (0 < $levelcount1)) {

			$level2 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		}



		if ((3 <= $this->set['level']) && (0 < $levelcount2)) {

			$level3 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		}



		$total = $level1 + $level2 + $level3;

		include $this->template();

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



	public function xiaji($agentid,$op,$data=''){

		global $_W;

		global $_GPC;

		//该会员的下级人id

		//获取下级的是否为分销商

		$data = array();  //结果集

		$id = array($agentid);//第一次循环的id

		do{

			$mids = array();   //下次循环的id

			$state = false;    //判断循环是否终止

			foreach ($id as $val){

				$result = pdo_fetchall("select * from".tablename("ewei_shop_member") ."where uniacid=:uniacid and agentid=:agentid and agentlevel>0",array(':uniacid'=>$_W['uniacid'],':agentid'=>$val));

				if($result){

					foreach ($result as $key=>$item){

						$data[] = array('id'=>$item['id'],'type'=>$op);

						$mids[] = $item['id'];

						$state = true;

					}

				}

			}

			$id = $mids;   //下级循环的id组

			$op = $op+1;



		}while($state==true);

		return $data;

	}



	public function get_list()

	{

		global $_W;

		global $_GPC;

		$openid = $_W['openid'];

		$member = $this->model->getInfo($openid);

		$total_level = 0;

		$level = intval($_GPC['level']);

		((3 < $level) || ($level <= 0)) && ($level = 1);

		$condition = '';



		$pindex = max(1, intval($_GPC['page']));

		$psize = 10;

		$ass = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = ' . $_W['uniacid']);

		$arr = $this->digui($ass,$member['id']);



		// show_json($arr);

		foreach($arr as $key=>$val){

			$ids .= $val['id'].",";

		}

		$ids_1 = substr($ids,0,-1);

		if($ids_1){

			$condition = "and id in ($ids_1)";
			
		}


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

				$info = $this->model->getInfo($row['openid'], array('total'));

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



		show_json(1, array('list' => $list, 'total' => $total_level,'sum'=>count($arr), 'pagesize' => $psize));

	}

}



?>

