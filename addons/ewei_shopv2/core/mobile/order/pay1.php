<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Pay1_EweiShopV2Page extends MobileLoginPage
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$type = $_GPC['zf'];
		$zf = pdo_fetch("select * from".tablename("ewei_shop_sysset")."where uniacid=:uniacid",array(':uniacid'=>$uniacid));
		$member = m('member')->getMember($openid, true);
		$orderid = intval($_GPC['id']);
		$peerPaySwi = m('common')->getPluginset('sale');
		$peerPaySwi = $peerPaySwi['peerpay']['open'];
		$ispeerpay = m('order')->checkpeerpay($orderid);
		if (!(empty($order['istrade']))) 
		{
			$ispeerpay = 0;
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		include $this->template();
	}

	public function submit(){
        global $_W;
        global $_GPC;
        if($_POST){
           //上传订单的支付凭证
           $result = pdo_update("ewei_shop_order",array('file'=>$_POST['file'],'type'=>'1','zf'=>$_POST['zf']),array('uniacid'=>$_W['uniacid'],'id'=>$_POST['orderid']));
           if($result){
               show_json(1);
           }
        }
    }

}
?>