<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}
class Sms_EweiShopV2ComModel extends ComModel
{
	public function send($mobile, $tplid, $data, $replace = true)
	{
		global $_W;
		$smsset = $this->sms_set();
		$template = $this->sms_verify($tplid, $smsset);
		if (empty($template['status']))
		{
			return $template;
		}
		$params = $this->sms_data($template['type'], $data, $replace, $template);
		if ($template['type'] == 'juhe')
		{
			$data = array('mobile' => $mobile, 'tpl_id' => $template['smstplid'], 'tpl_value' => $params, 'key' => $smsset['juhe_key']);
			load()->func('communication');
			$result = ihttp_post('http://v.juhe.cn/sms/send', $data);
			$result = $result['content'];
			if (empty($result) || (0 < $result['error_code']))
			{
				return array('status' => 0, 'message' => '短信发送失败(' . $result['error_code'] . ')：' . json_encode($result['reason']));


			}
		}
		if ($template['type'] == 'dayu')
		{
					include_once EWEI_SHOPV2_VENDOR . 'dayu/TopSdk.php';
					$dayuClient = new TopClient();
					$dayuClient->appkey = $smsset['dayu_key'];
					$dayuClient->secretKey = $smsset['dayu_secret'];
					$dayuRequest = new AlibabaAliqinFcSmsNumSendRequest();
					$dayuRequest->setSmsType('normal');
					$dayuRequest->setSmsFreeSignName($template['smssign']);
					$dayuRequest->setSmsParam($params);
					$dayuRequest->setRecNum('' . $mobile);
					$dayuRequest->setSmsTemplateCode($template['smstplid']);
					$dayuResult = $dayuClient->execute($dayuRequest);
					$dayuResult = (array) $dayuResult;
					if (empty($dayuResult) || !(empty($dayuResult['code'])))
					{
						return array('status' => 0, 'message' => '短信发送失败(' . $dayuResult['sub_msg'] . '/code: ' . $dayuResult['code'] . '/sub_code: ' . $dayuResult['sub_code'] . ')');

					}
		}
		if ($template['type'] == 'aliyun')
		{
							load()->func('communication');
							$paramstr = http_build_query(array('ParamString' => $params, 'RecNum' => $mobile, 'SignName' => $template['smssign'], 'TemplateCode' => $template['smstplid']));
							$header = array('Authorization' => 'APPCODE ' . $smsset['aliyun_appcode']);
							$request = ihttp_request('http://sms.market.alicloudapi.com/singleSendSms?' . $paramstr, '', $header);
							$result = json_decode($request['content'], true);
							if (!($result['success']) || ($request['code'] != 200))
							{
								if ($request['code'] != 200)
								{
									$result['message'] = $request['headers']['X-Ca-Error-Message'];
								}
								return array('status' => 0, 'message' => '短信发送失败(错误信息: ' . $result['message'] . ')');


							}
		}

			if ($template['type'] == 'emay')
		{
									include_once EWEI_SHOPV2_VENDOR . 'emay/SMSUtil.php';
									$balance = $this->sms_num('emay', $smsset);
									if ($balance <= 0)
									{
										return array('status' => 0, 'message' => '短信发送失败(亿美软通余额不足, 当前余额' . $balance . ')');
									}
									$emayClient = new SMSUtil($smsset['emay_url'], $smsset['emay_sn'], $smsset['emay_pw'], $smsset['emay_sk'], array('proxyhost' => $smsset['emay_phost'], 'proxyport' => $smsset['pport'], 'proxyusername' => $smsset['puser'], 'proxypassword' => $smsset['ppw']), $smsset['emay_out'], $smsset['emay_outresp']);
									$emayResult = $emayClient->send($mobile, '【' . $template['smssign'] . '】' . $params);
									if (!(empty($emayResult)))
									{
										return array('status' => 0, 'message' => '短信发送失败(错误信息: ' . $emayResult . ')');

									}
		}

		return array('status' => 1);
	}

	function send_sms($account, $pwd, $mobile, $code)

	{

	    $content = "您的验证码是：". $code ."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！";



	    $smsrs = file_get_contents('http://106.ihuyi.cn/webservice/sms.php?method=Submit&account='.$account.'&password='.$pwd.'&mobile=' . $mobile . '&content='.urldecode($content));



	   return $this->xml_to_array($smsrs);

	}



	function send_sms_alidayu($mobile, $code, $templateType){

	    $set = m('common')->getSysset();

	    include IA_ROOT . "/addons/sz_yi/alifish/TopSdk.php";

	    //$appkey = '23355246';

	    //$secret = '0c34a4887d2f52a6365a266bb3b38d25';



	    switch ($templateType) {

	        case 'reg':

	            $templateCode = $set['sms']['templateCode'];

	            break;

	        case 'forget':

	            $templateCode = $set['sms']['templateCodeForget'];

	            break;

	        default:

	            $templateCode = $set['sms']['templateCode'];

	            break;

	    }



	    $c = new TopClient;

	    $c->appkey = $set['sms']['appkey'];

	    $c->secretKey = $set['sms']['secret'];

	    $req = new AlibabaAliqinFcSmsNumSendRequest;

	    $req->setExtend("123456");

	    $req->setSmsType("normal");

	    $req->setSmsFreeSignName($set['sms']['signname']);

	    $req->setSmsParam("{\"code\":\"{$code}\",\"product\":\"{$set['sms']['product']}\"}");

	    $req->setRecNum($mobile);

	    $req->setSmsTemplateCode($templateCode);

	    $resp = $c->execute($req);

	    return objectArray($resp);

	}
	function send_zhangjun3($mobile,$id,$name){//掌骏

		$set = m('common')->getSysset();
 
 
 
		 $content = "【ETH】消息通知：用户".$id.$name;
 
 
 
		 $time=date('ymdhis',time());
 
		 $arr=array(
 
			 'uname'=>"hsxx40",
 
			 'pwd'=>"hsxx40",
 
			 'time'=>$time
 
		 );
 
		 $signPars='';
 
		 foreach($arr as $v) {
 
			 $signPars .=$v;
 
		 }
 
 
 
		 $sign = strtolower(md5($signPars));
 
 
 
		 $arrs=array(
 
			 'userid'=>"9795",
 
			 'timestamp'=>$time,
 
			 'sign'=>$sign,
 
			 'mobile'=>$mobile,
 
			 'content'=>$content,
 
			 'action'=>'send'
 
 
 
		 );
 
		 $url='http://120.77.14.55:8888/v2sms.aspx';
 
		 $ret=$this->call($url, $arrs);
 
		 return $ret;
 
	 }

	function send_zhangjun2($mobile,$id,$name){//掌骏

	   $set = m('common')->getSysset();



	    $content = "【ETH】您订单编号为：".$id.$name;



	    $time=date('ymdhis',time());

	    $arr=array(

	        'uname'=>"hsxx40",

	        'pwd'=>"hsxx40",

	        'time'=>$time

	    );

	    $signPars='';

	    foreach($arr as $v) {

	        $signPars .=$v;

	    }



	    $sign = strtolower(md5($signPars));



	    $arrs=array(

	        'userid'=>"9795",

	        'timestamp'=>$time,

	        'sign'=>$sign,

	        'mobile'=>$mobile,

	        'content'=>$content,

	        'action'=>'send'



	    );

	    $url='http://120.77.14.55:8888/v2sms.aspx';

	    $ret=$this->call($url, $arrs);

	    return $ret;

	}

	function send_zhangjun($mobile,$code){//掌骏

	    $set = m('common')->getSysset();



	    $content = "【ETH】您的手机验证码为：".$code."，该短信1分钟内有效。如非本人操作，可不用理会！";



	    $time=date('ymdhis',time());

	    $arr=array(

	        'uname'=>"hsxx40",

	        'pwd'=>"hsxx40",

	        'time'=>$time

	    );

	    $signPars='';

	    foreach($arr as $v) {

	        $signPars .=$v;

	    }



	    $sign = strtolower(md5($signPars));



	    $arrs=array(

	        'userid'=>"9795",

	        'timestamp'=>$time,

	        'sign'=>$sign,

	        'mobile'=>$mobile,

	        'content'=>$content,

	        'action'=>'send'



	    );

	    $url='http://120.77.14.55:8888/v2sms.aspx';

	    $ret=$this->call($url, $arrs);

	    return $ret;

	}



	function call($url,$arr,$second = 30){





    $ch = curl_init();



    //设置超时



    curl_setopt($ch, CURLOPT_TIMEOUT, $second);



    curl_setopt($ch,CURLOPT_URL, $url);

    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);

    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);//严格校验

    //设置header

    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    //要求结果为字符串且输出到屏幕上

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    /*

     if($useCert == true){

     //设置证书

     //使用证书：cert 与 key 分别属于两个.pem文件

     curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');

     curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);

     curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');

     curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);

    } */

    //post提交方式

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);

    //运行curl

    $data = curl_exec($ch);



    return $this->xml_to_array($data);

}

	function xml_to_array($xml)

	{

	    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";

	    if(preg_match_all($reg, $xml, $matches)){

	            $count = count($matches[0]);

	            for($i = 0; $i < $count; $i++){

	            $subxml= $matches[2][$i];

	            $key = $matches[1][$i];

	                    if(preg_match( $reg, $subxml )){

	                            $arr[$key] = $this->xml_to_array( $subxml );

	                    }else{

	                            $arr[$key] = $subxml;

	                    }

	            }

	    }

	    return $arr;

	}

	public function sms_set()
	{
		global $_W;
		return pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sms_set') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
	}
	public function sms_temp()
	{
		global $_W;
		$list = pdo_fetchall('SELECT id, `type`, `name` FROM ' . tablename('ewei_shop_sms') . ' WHERE status=1 and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		foreach ($list as $i => &$item )
		{
			if ($item['type'] == 'juhe')
			{
				$item['name'] = '[聚合]' . $item['name'];
			}
			else if ($item['type'] == 'dayu')
			{
				$item['name'] = '[大于]' . $item['name'];
			}
			else if ($item['type'] == 'aliyun')
			{
				$item['name'] = '[阿里云]' . $item['name'];
			}
			else if ($item['type'] == 'emay')
			{
				$item['name'] = '[亿美]' . $item['name'];
			}
		}
		unset($item);
		return $list;
	}
	public function sms_num($type, $smsset = NULL)
	{
		if (empty($type))
		{
			return;
		}
		if (empty($smsset) || !(is_array($smsset)))
		{
			$smsset = $this->sms_set();
		}
		if ($type == 'emay')
		{
			include_once EWEI_SHOPV2_VENDOR . 'emay/SMSUtil.php';
			$emayClient = new SMSUtil($smsset['emay_url'], $smsset['emay_sn'], $smsset['emay_pw'], $smsset['emay_sk'], array('proxyhost' => $smsset['emay_phost'], 'proxyport' => $smsset['pport'], 'proxyusername' => $smsset['puser'], 'proxypassword' => $smsset['ppw']), $smsset['emay_out'], $smsset['emay_outresp']);
			$num = $emayClient->getBalance();
			if (!(empty($smsset['emay_warn'])) && !(empty($smsset['emay_mobile'])) && ($num < $smsset['emay_warn']) && (($smsset['emay_warn_time'] + (60 * 60 * 24)) < time()))
			{
				$emayClient = new SMSUtil($smsset['emay_url'], $smsset['emay_sn'], $smsset['emay_pw'], $smsset['emay_sk'], array('proxyhost' => $smsset['emay_phost'], 'proxyport' => $smsset['pport'], 'proxyusername' => $smsset['puser'], 'proxypassword' => $smsset['ppw']), $smsset['emay_out'], $smsset['emay_outresp']);
				$emayResult = $emayClient->send($smsset['emay_mobile'], '【系统预警】' . '您的亿美软通SMS余额为:' . $num . '，低于预警值:' . $smsset['emay_warn'] . ' (24小时内仅通知一次)');
				if (empty($emayResult))
				{
					pdo_update('ewei_shop_sms_set', array('emay_warn_time' => time()), array('id' => $smsset['id']));
				}
			}
			return $num;
		}
	}
	protected function sms_verify($tplid, $smsset)
	{
		global $_W;
		$template = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sms') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $tplid, ':uniacid' => $_W['uniacid']));
		$template['data'] = iunserializer($template['data']);
		if (empty($template))
		{
			return array('status' => 0, 'message' => '模板不存在!');
		}
		if (empty($template['status']))
		{
			return array('status' => 0, 'message' => '模板未启用!');
		}
		if (empty($template['type']))
		{
			return array('status' => 0, 'message' => '模板类型错误!');
		}
		if ($template['type'] == 'juhe')
		{
			if (empty($smsset['juhe']))
			{
				return array('status' => 0, 'message' => '未开启聚合数据!');
			}
			if (empty($smsset['juhe_key']))
			{
				return array('status' => 0, 'message' => '未填写聚合数据Key!');
			}
			if (empty($template['data']) || !(is_array($template['data'])))
			{
				return array('status' => 0, 'message' => '模板类型错误!');
			}
		}
		else if ($template['type'] == 'dayu')
		{
			if (empty($smsset['dayu']))
			{
				return array('status' => 0, 'message' => '未开启阿里大于!');
			}
			if (empty($smsset['dayu_key']))
			{
				return array('status' => 0, 'message' => '未填写阿里大于Key!');
			}
			if (empty($smsset['dayu_secret']))
			{
				return array('status' => 0, 'message' => '未填写阿里大于Secret!');
			}
			if (empty($template['data']) || !(is_array($template['data'])))
			{
				return array('status' => 0, 'message' => '模板类型错误!');
			}
			if (empty($template['smssign']))
			{
				return array('status' => 0, 'message' => '未填写阿里大于短信签名!');
			}
		}
		else if ($template['type'] == 'aliyun')
		{
			if (empty($smsset['aliyun']))
			{
				return array('status' => 0, 'message' => '未开启阿里云短信!');
			}
			if (empty($smsset['aliyun_appcode']))
			{
				return array('status' => 0, 'message' => '未填写阿里云短信AppCode!');
			}
			if (empty($template['data']) || !(is_array($template['data'])))
			{
				return array('status' => 0, 'message' => '模板类型错误!');
			}
			if (empty($template['smssign']))
			{
				return array('status' => 0, 'message' => '未填写阿里云短信签名!');
			}
		}
		else if ($template['type'] == 'emay')
		{
			if (empty($smsset['emay']))
			{
				return array('status' => 0, 'message' => '未开启亿美软通!');
			}
			if (empty($smsset['emay_url']))
			{
				return array('status' => 0, 'message' => '未填写亿美软通网关!');
			}
			if (empty($smsset['emay_sn']))
			{
				return array('status' => 0, 'message' => '未填写亿美软通序列号!');
			}
			if (empty($smsset['emay_pw']))
			{
				return array('status' => 0, 'message' => '未填写亿美软通密码!');
			}
			if (empty($smsset['emay_sk']))
			{
				return array('status' => 0, 'message' => '未填写亿美软通SessionKey!');
			}
			if (empty($template['smssign']))
			{
				return array('status' => 0, 'message' => '未填写亿美软通短信签名!');
			}
		}
		return $template;
	}
	protected function sms_data($type, $data, $replace, $template)
	{
		if ($replace)
		{
			if ($type == 'emay')
			{
				$tempdata = $template['content'];
				foreach ($data as $key => $value )
				{
					$tempdata = str_replace('[' . $key . ']', $value, $tempdata);
				}
				$data = $tempdata;
			}
			else
			{
				$tempdata = iunserializer($template['data']);
				foreach ($tempdata as &$td )
				{
					foreach ($data as $key => $value )
					{
						$td['data_shop'] = str_replace('[' . $key . ']', $value, $td['data_shop']);
					}
				}
				unset($td);
				$newdata = array();
				foreach ($tempdata as $td )
				{
					$newdata[$td['data_temp']] = $td['data_shop'];
				}
				$data = $newdata;
			}
		}
		if ($type == 'juhe')
		{
			$result = '';
			$count = count($data);
			$i = 0;
			foreach ($data as $key => $value )
			{
				if ((0 < $i) && ($i < $count))
				{
					$result .= '&';
				}
				$result .= '#' . $key . '#=' . $value;
				++$i;
			}
		}
		else
		{
			if (($type == 'dayu') || ($type == 'aliyun'))
			{
				$result = json_encode($data);
			}
			else if ($type == 'emay')
			{
				$result = $data;
			}
		}
		return $result;
	}
	protected function http_post($url, $postData)
	{
		$postData = http_build_query($postData);
		$options = array( 'http' => array('method' => 'POST', 'header' => 'Content-type:application/x-www-form-urlencoded', 'content' => $postData, 'timeout' => 15 * 60) );
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if (!(is_array($result)))
		{
			$result = json_decode($result, true);
		}
		return $result;
	}
	protected function http_get($url)
	{
		$result = file_get_contents($url, false);
		if (!(is_array($result)))
		{
			$result = json_decode($result, true);
		}
		return $result;
	}
	public function callsms(array $params)
	{
		global $_W;
		$tag = ((isset($params['tag']) ? $params['tag'] : ''));
		$datas = ((isset($params['datas']) ? $params['datas'] : array()));
		$tm = $_W['shopset']['notice'];
		if (empty($tm))
		{
			$tm = m('common')->getSysset('notice');
		}
		$smsid = $tm[$tag . '_sms'];
		$smsclose = $tm[$tag . '_close_sms'];
		if (!(empty($smsid)) && empty($smsclose) && !(empty($params['mobile'])))
		{
			$sms_data = array();
			foreach ($datas as $i => $value )
			{
				$sms_data[$value['name']] = $value['value'];
			}
			$this->send($params['mobile'], $smsid, $sms_data);
		}
	}
}
?>
