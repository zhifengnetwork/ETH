<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Yeji_EweiShopV2Page extends MobileLoginPage
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$_GPC['type'] = intval($_GPC['type']);
        if($_GPC['type'] == '0'){
            $result = pdo_fetchall("select p.*,o.ordersn from ".tablename("monthyeji_pen")."p left join ".tablename("ewei_shop_order")." o on p.orderid=o.id "." where p.uniacid=:uniacid and p.openid=:openid order by p.createtime desc",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));
            $sum = pdo_fetch("select sum(money) as summoney from ".tablename("monthyeji_pen")." where uniacid=:uniacid and openid=:openid ",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));
        }
		include $this->template();
	}

}
?>