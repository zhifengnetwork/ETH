<?php
if (!(defined('IN_IA'))) 
{
    exit('Access Denied');
}
class Qipai_EweiShopV2Page extends MobileLoginPage 
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

   
    
}
?>