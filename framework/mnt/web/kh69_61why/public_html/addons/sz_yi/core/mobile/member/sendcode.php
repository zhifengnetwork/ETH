<?php
/**
 * 发送信息
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.cocogd.com.cn)
 * @license    http://www.cocogd.com.cn
 * @link       http://www.cocogd.com.cn
 * @since      File available since Release v1.1
 */
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$mc    = $_GPC['memberdata'];  //'18646588292';
$op    = empty($_GPC['op']) ? 'sendcode' : trim($_GPC['op']);

$ip    = $this->GetIP();
$t     = time();
$start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
$end   = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
$max_num = 4;//一天最多可发送短信条数

session_start();
if($op == 'sendcode'){
    $mobile = $_GPC['mobile'];
    if(empty($mobile)){
        show_json(0, '请填入手机号');
    }
    $info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where mobile=:mobile and pwd!="" and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':mobile' => $mobile
            ));
    if(!empty($info))
    {
        show_json(0, '该手机号已被注册！不能获取验证码。');
    }

    $num1 = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('sz_yi_mobile_code').' where mobile=:mobile and type=:add_user and time > :start and time < :end',array(':mobile'=> $mobile,':add_user' =>'add_user',':start' => $start,':end'=> $end));
    $num2 = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('sz_yi_mobile_code').' where ip=:ip and time > :start and time < :end',array(':ip'=> $ip,':start' => $start,':end'=> $end));
    if ($num1 > $max_num || $num2 > $max_num) {
        show_json(0, '今天获取验证码次数过多，请明天再试');exit;
    }

    $code = rand(1000, 9999);
    $_SESSION['codetime'] = time();
    $_SESSION['code'] = $code;
    $_SESSION['code_mobile'] = $mobile;
  //  $content = "您的安全码是：". $code ."。请不要把安全码泄露给其他人。如非本人操作，可不用理会！";

    $data_code           = array();
    $data_code['mobile'] = $mobile;
    $data_code['ip']     = $ip;
    $data_code['time']   = time();
    $data_code['code']   = $code;
    $data_code['type']   = 'add_user';

    pdo_insert('sz_yi_mobile_code', $data_code);
    $issendsms = $this->sendSms($mobile, $code);
    show_json(1);
}else if ($op == 'forgetcode'){
    $mobile = $_GPC['mobile'];
    if(empty($mobile)){
        show_json(0, '请填入手机号');
    }
    $info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where mobile=:mobile and pwd!="" and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':mobile' => $mobile
            ));
    //print_r($info);
    if(empty($info))
    {
        show_json(0, '该手机号未注册！不能找回密码。');
    }


    $num1 = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('sz_yi_mobile_code').' where mobile=:mobile and type=:forgetcode and time > :start and time < :end',array(':mobile'=> $mobile,':forgetcode' =>'forgetcode',':start' => $start,':end'=> $end));
    $num2 = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('sz_yi_mobile_code').' where ip=:ip and type=:forgetcode and time > :start and time < :end',array(':ip'=> $ip,':forgetcode' =>'forgetcode',':start' => $start,':end'=> $end));
    if ($num1 > $max_num || $num2 > $max_num) {
        show_json(0, '今天获取验证码次数过多，请明天再试');exit;
    }


    $code                    = rand(1000, 9999);
    $_SESSION['codetime']    = time();
    $_SESSION['code']        = $code;
    $_SESSION['code_mobile'] = $mobile;
  //  $content = "您的安全码是：". $code ."。请不要把安全码泄露给其他人。如非本人操作，可不用理会！";

    $data_code['mobile'] = $mobile;
    $data_code['ip']     = $ip;
    $data_code['time']   = time();
    $data_code['code']   = $code;
    $data_code['type']   = 'forgetcode';

    pdo_insert('sz_yi_mobile_code', $data_code);
    $issendsms = $this->sendSms($mobile, $code);
    show_json(1);
}else if ($op == 'bindmobilecode'){
    $mobile = $_GPC['mobile'];
    if(empty($mobile)){
        show_json(0, '请填入手机号');
    }
    $info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where mobile=:mobile and pwd!="" and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':mobile' => $mobile
            ));
    //print_r($info);
    
    $code = rand(1000, 9999);
    $_SESSION['codetime'] = time();
    $_SESSION['code'] = $code;
    $_SESSION['code_mobile'] = $mobile;
  //  $content = "您的安全码是：". $code ."。请不要把安全码泄露给其他人。如非本人操作，可不用理会！";

    $num1 = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('sz_yi_mobile_code').' where mobile=:mobile and type=:bindmobilecode and time > :start and time < :end',array(':mobile'=> $mobile,':bindmobilecode' =>'bindmobilecode',':start' => $start,':end'=> $end));
    $num2 = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('sz_yi_mobile_code').' where ip=:ip and type=:bindmobilecode and time > :start and time < :end',array(':ip'=> $ip,':bindmobilecode' =>'bindmobilecode',':start' => $start,':end'=> $end));
    if ($num1 > $max_num || $num2 > $max_num) {
        show_json(0, '今天获取验证码次数过多，请明天再试');exit;
    }


    $data_code['mobile'] = $mobile;
    $data_code['ip']     = $ip;
    $data_code['time']   = time();
    $data_code['code']   = $code;
    $data_code['type']   = 'bindmobilecode';

    pdo_insert('sz_yi_mobile_code', $data_code);    
    $issendsms = $this->sendSms($mobile, $code);
    show_json(1);
}else if ($op == 'checkcode'){
    $code = $_GPC['code']; 

    if(($_SESSION['codetime']+60*5) < time()){
        show_json(0, '验证码已过期,请重新获取');
    }
    if($_SESSION['code'] != $code){
        show_json(0, '验证码错误,请重新获取');
    }
    show_json(1);  
}
else if ($op == 'ismobile'){
    $mobile = $_GPC['mobile'];
    if(empty($mobile)){
        show_json(0, '请填入手机号');
    }
    $info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where mobile=:mobile and pwd!="" and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':mobile' => $mobile
            ));
    if(!empty($info))
    {
        show_json(0, '该手机号已被注册！');
    }else{

 


     show_json(1); 
    }    
}
