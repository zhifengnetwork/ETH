<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid = m('user') -> getOpenid();
$uniacid = $_W['uniacid'];
$set = m('common') -> getSysset(array('trade'));

$set1 = p('commission') ->getSet();



if ($operation == 'display' && $_W['isajax']){
    $credit = m('member') -> getCredit($openid, 'credit2');
    $member = m('member') -> getMember($openid);
    $returnurl = urlencode($this -> createMobileUrl('member/withdraw'));
    $infourl = $this -> createMobileUrl('member/info', array('returnurl' => $returnurl));
    show_json(1, array('credit' => $credit, 'infourl' => $infourl, 'noinfo' => empty($member['realname'])));
}else if ($operation == 'submit' && $_W['ispost']){
    $money = floatval($_GPC['money']);
    $credit = m('member') -> getCredit($openid, 'credit2');
    if ($money < 0){
        show_json(0, '非法提现金额!');
    }
    if (empty($money)){
        show_json(0, '申请金额为空!');
    }
    if ($money > $credit){
        show_json(0, '提现金额过大!');
    }
    m('member') -> setCredit($openid, 'credit2', - $money);
    $logno = m('common') -> createNO('member_log', 'logno', 'RW');
	$procedures =$money *( 1 -$set1['procedures'] /100);
    $log = array('uniacid' => $uniacid, 'logno' => $logno, 'openid' => $openid, 'title' => '余额提现', 'type' => 1, 'createtime' => time(), 'status' => 0, 'money' => $procedures,'procedures'=>$set1['procedures']);
    pdo_insert('sz_yi_member_log', $log);
    $logid = pdo_insertid();
    m('notice') -> sendMemberLogMessage($logid);
    show_json(1);
}
include $this -> template('member/withdraw');
