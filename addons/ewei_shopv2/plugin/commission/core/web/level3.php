<?php

if (!defined('IN_IA')) {

	exit('Access Denied');

}



class Level3_EweiShopV2Page extends PluginWebPage

{

	public function main()

	{

		global $_W;

		global $_GPC;

		global $_S;

		$set = $_S['commission'];

		$leveltype = $set['leveltype'];

		// $default = array('id' => 'default', 'levelname' => empty($set['levelname']) ? '默认等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);

		$others = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_level3') . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY commission1 asc');

		$list = $others;

		include $this->template();

	}



	public function add()

	{

		$this->post();

	}



	public function edit()

	{

		$this->post();

	}



	protected function post()

	{

		global $_W;

		global $_GPC;

		global $_S;

		$set = $_S['commission'];

		$leveltype = $set['leveltype'];

		$id = trim($_GPC['id']);



		if ($id == 'default') {

			$level = array('id' => 'default', 'levelname' => empty($set['levelname']) ? '默认等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);

		}

		else {

			$level = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_commission_level3') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => intval($id), ':uniacid' => $_W['uniacid']));

		}



		if ($_W['ispost']) {

			$data = array('uniacid' => $_W['uniacid'], 'levelname' => trim($_GPC['levelname']),'type' => trim($_GPC['type']), 'commission1' => trim(trim($_GPC['commission1']), '%'), 'commission2' => trim(trim($_GPC['commission2']), '%'), 'commission3' => trim(trim($_GPC['commission3']), '%'), 'commissionmoney' => trim($_GPC['commissionmoney'], '%'), 'ordermoney' => $_GPC['ordermoney'], 'ordercount' => intval($_GPC['ordercount']), 'downcount' => intval($_GPC['downcount'])

				, 'commission4' => trim(trim($_GPC['commission4']), '%'), 'commission5' => trim(trim($_GPC['commission5']), '%'), 'commission6' => trim(trim($_GPC['commission6']), '%'), 'commission7' => trim(trim($_GPC['commission7']), '%'), 'commission8' => trim(trim($_GPC['commission8']), '%'), 'commission9' => trim(trim($_GPC['commission9']), '%'), 'jifen1' => trim(trim($_GPC['jifen1']), '%'), 'jifen2' => trim(trim($_GPC['jifen2']), '%'), 'jifen3' => trim(trim($_GPC['jifen3']), '%'), 'jifen4' => trim(trim($_GPC['jifen4']), '%'), 'jifen5' => trim(trim($_GPC['jifen5']), '%'), 'jifen6' => trim(trim($_GPC['jifen6']), '%'), 'jifen7' => trim(trim($_GPC['jifen7']), '%'), 'jifen8' => trim(trim($_GPC['jifen8']), '%'), 'jifen9' => trim(trim($_GPC['jifen9']), '%'));



			if (!empty($id)) {

				if ($id == 'default') {

					$updatecontent = '<br/>等级名称: ' . $set['levelname'] . '->' . $data['levelname'] . '<br/>一级佣金比例: ' . $set['commission1'] . '->' . $data['commission1'] . '<br/>二级佣金比例: ' . $set['commission2'] . '->' . $data['commission2'] . '<br/>三级佣金比例: ' . $set['commission3'] . '->' . $data['commission3'];

					$set['levelname'] = $data['levelname'];

					$set['commission1'] = $data['commission1'];

					$set['commission2'] = $data['commission2'];

					$set['commission3'] = $data['commission3'];

					$set['commission4'] = $data['commission4'];

					$set['commission5'] = $data['commission5'];

					$set['commission6'] = $data['commission6'];

					$set['commission7'] = $data['commission7'];

					$set['commission8'] = $data['commission8'];

					$set['commission9'] = $data['commission9'];

					$set['jifen1'] = $data['jifen1'];

					$set['jifen2'] = $data['jifen2'];

					$set['jifen3'] = $data['jifen3'];

					$set['jifen4'] = $data['jifen4'];

					$set['jifen5'] = $data['jifen5'];

					$set['jifen6'] = $data['jifen6'];

					$set['jifen7'] = $data['jifen7'];

					$set['jifen8'] = $data['jifen8'];

					$set['jifen9'] = $data['jifen9'];

					$this->updateSet($set);

					plog('commission.level.edit', '修改分销商默认等级' . $updatecontent);

				}

				else {

					$updatecontent = '<br/>等级名称: ' . $level['levelname'] . '->' . $data['levelname'] . '<br/>一级佣金比例: ' . $level['commission1'] . '->' . $data['commission1'] . '<br/>二级佣金比例: ' . $level['commission2'] . '->' . $data['commission2'] . '<br/>三级佣金比例: ' . $level['commission3'] . '->' . $data['commission3'];

					pdo_update('ewei_shop_commission_level3', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));

					plog('commission.level.edit', '修改分销商等级 ID: ' . $id . $updatecontent);

				}

			}

			else {

				pdo_insert('ewei_shop_commission_level3', $data);

				$id = pdo_insertid();

				plog('commission.level3.add', '添加分销商等级 ID: ' . $id);

			}



			show_json(1, array('url' => webUrl('commission/level3')));

		}



		include $this->template();

	}



	public function delete()

	{

		global $_W;

		global $_GPC;

		$id = intval($_GPC['id']);



		if (empty($id)) {

			$id = (is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0);

		}



		$items = pdo_fetchall('SELECT id,levelname FROM ' . tablename('ewei_shop_commission_level') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);



		foreach ($items as $item) {

			pdo_delete('ewei_shop_commission_level', array('id' => $item['id']));

			plog('commission.level.delete', '删除分销商等级 ID: ' . $id . ' 等级名称: ' . $level['levelname']);

		}



		show_json(1);

	}

}



?>
