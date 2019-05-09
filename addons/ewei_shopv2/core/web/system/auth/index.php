<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends SystemPage {

	function main() {

		global $_W,$_GPC;
		$domain = trim( preg_replace( "/http(s)?:\/\//", "", rtrim($_W['siteroot'],"/") )  );
		$ip = gethostbyname($_SERVER['HTTP_HOST']);
		$set = pdo_fetch('select id, sets from ' . tablename('ewei_shop_sysset') . ' order by id asc limit 1');
        $sets = iunserializer($set['sets']);

		$id = isset($sets['auth']['id']) ? $sets['auth']['id'] : 0;
        $resp = auth_user($id, $domain);
        $ip = $resp['ip'];
		$auth = get_auth();
		load()->func('communication');
		
		if ($_W['ispost']) {
			 
			if (empty($_GPC['domain'])) {
				show_json(0,'域名不能为空!');
			}
			if (empty($_GPC['code'])) {
				show_json(0,'请填写授权码!');
			}
			
			$data = array( 'ip' => $ip, 'siteid' => $id, 'code' => $_GPC['code'], 'domain' => $domain);
			$result = auth_grant($data);
			
			if ($result['errno'] == '1') {
                show_json(0,$result['message']);
			} else {
                $set = pdo_fetch('select id, sets from ' . tablename('ewei_shop_sysset') . ' order by id asc limit 1');
                $sets = iunserializer($set['sets']);
                if (!is_array($sets)) {
                    $sets = array();
                }
				if(!empty($result['auid'])){
					$id=$result['auid'];
				}
                $sets['auth'] = array(
                    'ip' => $ip,
                    'id' => $id,
                    'code' => $_GPC['code'],
                    'domain' =>$domain
                );
                if (empty($set)) {
                    pdo_insert('ewei_shop_sysset', array('sets' => iserializer($sets), 'uniacid' => $_W['uniacid']));
                } else {
					
                    pdo_update('ewei_shop_sysset', array('sets' => iserializer($sets)), array('id' => $set['id']));
                }
                $result['status'] = 1;
                $result['result']['url'] = webUrl('system/auth');
                die(json_encode($result));
            }
		}
		$result = array('status'=>0);
		if (!empty($ip) && !empty($id) && !empty($auth['code'])) {
			load()->func('communication');
			$data = array('ip' => $ip, 'id' => $id, 'code' => $auth['code'], 'domain' => $domain);
            $result = auth_checkauth($data);
		}
		include $this->template();
	}

}
