<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
global $_W, $_GPC;
$openid = m('user') -> getOpenid();
$preUrl = $_COOKIE['preUrl'];
if ($_W['isajax']){
    if ($_W['ispost']){
        $mc = $_GPC['memberdata']; 
		
		$info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where  mobile ="' . $mc['mobile'] . '" and pwd <> ""');
		
		$member = m('member')->getMember($openid);
		
        if($info){

            $oldopenid = $info['openid'];
           
		    /*pdo_update('sz_yi_member_address', array('openid' => $openid), array('openid' => $oldopenid));
            
            pdo_update('sz_yi_member_favorite', array('openid' => $openid), array('openid' => $oldopenid));
            
           
            pdo_update('sz_yi_order_comment', array('openid' => $openid), array('openid' => $oldopenid));
            pdo_update('sz_yi_saler', array('openid' => $openid), array('openid' => $oldopenid));
            pdo_update('sz_yi_coupon_data', array('openid' => $openid), array('openid' => $oldopenid));
            pdo_update('sz_yi_coupon_guess', array('openid' => $openid), array('openid' => $oldopenid));
            pdo_update('sz_yi_coupon_log', array('openid' => $openid), array('openid' => $oldopenid));
            pdo_update('sz_yi_creditshop_log', array('openid' => $openid), array('openid' => $oldopenid));
			*/
			
			pdo_update('sz_yi_member_cart', array('openid' => $openid), array('openid' => $oldopenid));
			pdo_update('sz_yi_order', array('openid' => $openid), array('openid' => $oldopenid));
			pdo_update('sz_yi_member_log', array('openid' => $openid), array('openid' => $oldopenid));
			pdo_update('sz_yi_order',array('agentid'=>$member['id']),array('agentid'=>$info['id']));
			pdo_update('sz_yi_member',array('agentid'=>$member['id']),array('agentid'=>$info['id']));	
			pdo_delete('sz_yi_member', array('openid' => $oldopenid));
			
			$data = array('mobile' => $info['mobile'], 'pwd' => $info['pwd'], 'isbindmobile' => 1, 'credit1' => $info['credit1'], 'credit2' => $info['credit2'],);
            pdo_update('sz_yi_member', $data, array('openid' => $openid));
            show_json(1, array('preurl' => $preUrl));
        }else{
            pdo_update('sz_yi_member', array('mobile' => $mc['mobile'], 'pwd' => md5($mc['password']), 'isbindmobile' => 1,), array('openid' => $openid));
            show_json(1, array('preurl' => $preUrl));
        }
    }
}
if($_GPC[style] == 1){
	include $this->template('member/bindmobile1');
}else if($_GPC[style] == 2){
	include $this->template('member/bindmobile2');
}else{
	include $this->template('member/bindmobile');
}
