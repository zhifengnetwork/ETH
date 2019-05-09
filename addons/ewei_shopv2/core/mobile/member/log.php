<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Log_EweiShopV2Page extends MobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$_GPC['type'] = intval($_GPC['type']);
		include $this->template();
	}
	public function get_list() 
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
        if ($type == 0 || $type == 1) {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');
            $condition = ' and openid=:openid and uniacid=:uniacid and type=:type';
            $params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':type' => intval($_GPC['type']));
            $list = pdo_fetchall('select * from ' . tablename('ewei_shop_member_log') . ' where 1 ' . $condition . ' order by createtime desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
            $total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_log') . ' where 1 ' . $condition, $params);
            foreach ($list as &$row) {
                $row['createtime'] = date('Y-m-d H:i', $row['createtime']);
                $row['typestr'] = $apply_type[$row['applytype']];
            }
            unset($row);
            show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
        }else if($type == 2){
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;

            $select = 'SELECT og.money,og.createtime,og.type,og.status,o.ordersn,m.mobile FROM ';
            $tablename = tablename('ewei_shop_order_goods1').' og left join '.tablename('ewei_shop_order')
                .' o ON o.id=og.orderid left join '.tablename('ewei_shop_member').' m ON m.openid=og.openid2 ';
            $where = ' WHERE og.uniacid=:uniacid AND og.openid=:openid ';
            $where .= ' ORDER BY og.id DESC ';
            $limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;

            $params[':uniacid'] = $_W['uniacid'];
            $params[':openid'] = $_W['openid'];

            $list = pdo_fetchall($select.$tablename.$where.$limit,$params);
            $total = pdo_fetchcolumn('SELECT count(og.id) FROM '.$tablename.$where, $params);

            foreach($list as &$row)
            {
                $row['createtime'] = date('Y-m-d H:i', $row['createtime']);
                $row['status2'] = $row['type'];
                $row['type'] = 2;

                if ($row['status2'] == 1)
                    $row['status2'] = '分销';
                elseif ($row['status2'] == 2)
                    $row['status2'] = '业绩';
                elseif ($row['status2'] == 3)
                    $row['status2'] = '总业绩分红';
            }
            unset($row);
            show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
        }
	}
}
?>