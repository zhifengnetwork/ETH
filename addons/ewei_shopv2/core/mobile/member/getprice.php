<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}
class Getprice_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        global $_W;
        // header('content-type:text/html;charset=utf-8');
		// 根据url循环获取
		$url_arr = array(
			// 'BTC' => 'https://api.huobi.pro/market/trade?symbol=btcusdt',
			// 'BCH' => 'https://api.huobi.pro/market/trade?symbol=bchusdt',
			'ETH' => 'https://api.huobi.pro/market/trade?symbol=ethusdt'
			// 'XRP' => 'https://api.huobi.pro/market/trade?symbol=xrpusdt',
			// 'EOS' => 'https://api.huobi.pro/market/trade?symbol=eosusdt',
			// 'LTC' => 'https://api.huobi.pro/market/trade?symbol=ltcusdt',
			// 'TRX' => 'https://api.huobi.pro/market/trade?symbol=trxusdt',
			// 'ETC' => 'https://api.huobi.pro/market/trade?symbol=etcusdt',
			// 'HT'  => 'https://api.huobi.pro/market/trade?symbol=htusdt'
		);
		$currency_arr = [];
		// 获取配置表
		// $configs = Db::name('income_config')->field('name,value')->select();
		// // 把配置项name转换成$configs['price_min1']['value']
		// $configs = arr2name($configs);
		foreach($url_arr as $k=>$v){
			// dump($v);
			$res = '';
			$res = $this->getUrl($v);
			$currency['status'] = $res['status'];
			$currency['ch'] =  $res['ch'];
			$currency['cu_name'] =  $k;
            $currency['price'] =  $res['tick']['data'][0]['price']*6.9182;
           
			// update币种表对应币种价格
			if($currency['status']=='ok' && $currency['price']>0){
				$updates['trxprice'] = $currency['price'];
                // $updates['update_price_time'] = time();
                $list = pdo_update("ewei_shop_sysset", $updates, array('uniacid' => $_W['uniacid']));
                dump($updates);
                if($list)
                {
                    echo 'ok';
                }
                
				// Db::name('currency')->where(['alias_name'=>$currency['cu_name']])->update($updates);trxprice
			}
		}

		
    }
    
    // getApiUrl
    public function getUrl($url){

        date_default_timezone_set('PRC');
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json",]);
        $output = '';
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $arrCurlResult['output'] = $output;//返回结果
        $arrCurlResult['response_code'] = $info;//返回http状态
        curl_close($ch);
        unset($ch);
        return json_decode($output,true);
    }
}
