<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class test_EweiShopV2Page extends MobilePage 
{
	public function main() 
	{
		global $_W ;
		global $_GPC;
		
		
		
		
	}
	 
	public function kefu(){

		global $_W;
        global $_GPC;

        $sys = pdo_fetch("select kefufile,wxfufile from".tablename("ewei_shop_sysset")."where uniacid=".$_W['uniacid']);

        show_json(1,$sys);

	}
}
?>