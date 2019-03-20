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

        //检查该手机号是否被注册
		//$info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where  mobile ="' . $mc['mobile'] . '" and pwd <> ""');
        $info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where  mobile ="' . $mc['mobile'] . '"');


		//微信端
		if(is_weixin()){

			//是否用微信注册有账号
			$member = m('member')->getMember($openid);

		    //手机号已经被注册 && 绑定新微信用户
		    if($info && empty($member)){
		    	pdo_update('sz_yi_member', array('mobile' => $mc['mobile'], 'pwd' => md5($mc['password']), 'isbindmobile' => 1,'openid' => $openid), array('id' => $info['id']));
		        show_json(1, array('preurl' => $preUrl));

		    //手机号没被注册 && 已经注册有微信号				
		    }else if(empty($info) && !empty($member)){
		        pdo_update('sz_yi_member', array('mobile' => $mc['mobile'], 'pwd' => md5($mc['password']), 'isbindmobile' => 1,), array('openid' => $openid));
		        show_json(1, array('preurl' => $preUrl));

		    //手机号没被注册 && 新用户
		    }else if (empty($info) && empty($member)){
		    	$member = m('member')->checkMember('',$mc);
				show_json(1, array('preurl' => $preUrl));

		    //微信用户修改已绑定的手机号				
		    }else if($info && !empty($member) && $info['id'] == $member['id']){
		    	pdo_update('sz_yi_member', array('mobile' => $mc['mobile'], 'pwd' => md5($mc['password']), 'isbindmobile' => 1,), array('openid' => $openid));
		        show_json(1, array('preurl' => $preUrl));
		    }


		}else{

			//手机端	
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
