<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Wallet_EweiShopV2Page extends MobileLoginPage 
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
		$member = m('member')->getMember($_W['openid'], true);
		
		include $this->template();
	}

	public function submit(){
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
			show_json(1);
		}else{
			show_json(-1);
		}
	}
	
}
?>