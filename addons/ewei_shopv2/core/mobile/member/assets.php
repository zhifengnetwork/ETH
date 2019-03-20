<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Assets_EweiShopV2Page extends MobileLoginPage 
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
		
		//查询在投多少
		$member = m('member')->getMember($_W['openid'], true);
		$investment = number_format($member['credit1'],2);
		
		


		include $this->template();
	}
	
}
?>