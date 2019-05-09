<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Zhuanzhang_EweiShopV2Page extends MobileLoginPage 
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
	
		include $this->template();
	}

	public function judge(){

		global $_W;
		global $_GPC;

		if($_POST){

			$member = m('member')->getMember($_W['openid']);

			if($member['mobile']==$_POST['mobile']){
				show_json('-1');
			}

			$list = pdo_fetch("select id from ".tablename("ewei_shop_member")."where uniacid=:uniacid and (id=:id or mobile=:mobile)",array(':uniacid'=>$_W['uniacid'],':id'=>$_POST['mobile'],':mobile'=>$_POST['mobile']));

			if($list){
				show_json('1',array('mid'=>$list['id']));
			}else{
				show_json('0');
			}


		}
	}

	public function zhuanzhanginfo(){

		global $_W;
		global $_GPC;

		include $this->template();

	}
	
}
?>