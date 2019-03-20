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

			$arg = $mc['mobile'];
			$log = vsprintf('%s', print_r($arg, true));
		    $log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
		    $path = dirname(__FILE__) . '/log.log';
		    $fp = file_put_contents($path,$log,FILE_APPEND);

		//微信端
		if(is_weixin()){

			//是否用微信注册有账号
			$member = m('member')->getMember($openid);

			$arg = $openid;
			$log = vsprintf('%s', print_r($arg, true));
		    $log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
		    $path = dirname(__FILE__) . '/log.log';
		    $fp = file_put_contents($path,$log,FILE_APPEND);

			$arg = $member;
			$log = vsprintf('%s', print_r($arg, true));
		    $log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
		    $path = dirname(__FILE__) . '/log.log';
		    $fp = file_put_contents($path,$log,FILE_APPEND);


			//手机已存在
			if($info){


						$arg = '1';
						$log = vsprintf('%s', print_r($arg, true));
					    $log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					    $path = dirname(__FILE__) . '/log.log';
					    $fp = file_put_contents($path,$log,FILE_APPEND);


				//该手机号没有绑定过微信号（app注册的）,微信号没有注册过账号   =>   微信端绑定老账号，不生成新账号
				if(empty($info['avatar']) && empty($member)){

					$arg = '2';
					$log = vsprintf('%s', print_r($arg, true));
					$log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					$path = dirname(__FILE__) . '/log.log';
					$fp = file_put_contents($path,$log,FILE_APPEND);




					pdo_update('sz_yi_member', array('mobile' => $mc['mobile'], 'pwd' => md5($mc['password']), 'isbindmobile' => 1,'openid' => $openid), array('id' => $info['id']));
		        	show_json(1, array('preurl' => $preUrl));
				}else if(!empty($info['avatar']) && !empty($member)){


					$arg = '2.1';
						$log = vsprintf('%s', print_r($arg, true));
					    $log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					    $path = dirname(__FILE__) . '/log.log';
					    $fp = file_put_contents($path,$log,FILE_APPEND);


					//已绑定有微信号，该微信号是用户自己
					if($info['id'] == $member['id']){

						$arg = '2.5';
						$log = vsprintf('%s', print_r($arg, true));
					    $log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					    $path = dirname(__FILE__) . '/log.log';
					    $fp = file_put_contents($path,$log,FILE_APPEND);


						pdo_update('sz_yi_member', array('mobile' => $mc['mobile'], 'pwd' => md5($mc['password']), 'isbindmobile' => 1,'openid' => $openid), array('openid' => $member['openid']));
			        	show_json(1, array('preurl' => $preUrl));
					}else{

						$arg = '3';
						$log = vsprintf('%s', print_r($arg, true));
					    $log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					    $path = dirname(__FILE__) . '/log.log';
					    $fp = file_put_contents($path,$log,FILE_APPEND);

						//已绑定有微信号，该微信号不是用户自己   => 此手机号已经被绑定！
						show_json(2, array('preurl' => $preUrl));
					}

				}else if(empty($info['avatar']) && !empty($member)){

						$arg = '4';
						$log = vsprintf('%s', print_r($arg, true));
					    $log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					    $path = dirname(__FILE__) . '/log.log';
					    $fp = file_put_contents($path,$log,FILE_APPEND);

					show_json(2, array('preurl' => $preUrl));
				}else if(!empty($info['avatar']) && empty($member)) {

					$arg = '5';
					$log = vsprintf('%s', print_r($arg, true));
					$log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					$path = dirname(__FILE__) . '/log.log';
					$fp = file_put_contents($path,$log,FILE_APPEND);
					show_json(2, array('preurl' => $preUrl));
				}

			//手机号不存在
			}else{

				$arg = '6';
				$log = vsprintf('%s', print_r($arg, true));
				$log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
				$path = dirname(__FILE__) . '/log.log';
				$fp = file_put_contents($path,$log,FILE_APPEND);

				//根据获取到的openid，查询不到用户的 => 微信自动注册，同时绑定此手机号
				if(empty($member)){

					$arg = '7';
					$log = vsprintf('%s', print_r($arg, true));
					$log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					$path = dirname(__FILE__) . '/log.log';
					$fp = file_put_contents($path,$log,FILE_APPEND);

					$member = m('member')->checkMember('',$mc);
					show_json(1, array('preurl' => $preUrl));
				}else{

					$arg = '8';
					$log = vsprintf('%s', print_r($arg, true));
					$log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
					$path = dirname(__FILE__) . '/log.log';
					$fp = file_put_contents($path,$log,FILE_APPEND);

					//根据获取到的openid，已有用户的
					pdo_update('sz_yi_member', array('mobile' => $mc['mobile'], 'pwd' => md5($mc['password']), 'isbindmobile' => 1,'openid' => $openid), array('openid' => $member['openid']));
			        show_json(1, array('preurl' => $preUrl));
				}
			}



		    /*//手机号已经被注册 && 绑定新微信用户 
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
		    }else if ($info && !empty($member) && $info['id'] !== $member['id']) {
		    	//手机账号  /  微信账号   不是同一个
		    	show_json(2, array('preurl' => $preUrl));
		    }*/


		}else{

			$arg = '9';
			$log = vsprintf('%s', print_r($arg, true));
			$log = date('[Y/m/d H:i:s]') .'---'. $log . PHP_EOL;
			$path = dirname(__FILE__) . '/log.log';
			$fp = file_put_contents($path,$log,FILE_APPEND);

			//手机端 => 请在微信端操作！
			show_json(3, array('preurl' => $preUrl));

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
