<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}
class Integralrelease_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        //积分释放
        $this->diypage('member');

        //释放时间
        $beginToday = mktime(0, 1, 0, date('m'), date('d'), date('Y'));


        //今日开始时间和结束时间戳
        $start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;


        if ($beginToday) {

            //可以进行积分释放的会员
            $ass = pdo_fetchall("select openid,credit1,type from " . tablename("ewei_shop_member") . " where uniacid=:uniacid and type='1' ", array(':uniacid' => $_W['uniacid']));


            // var_dump($ass);exit();
            foreach ($ass as $key => $value) {
                //向积分释放表中查询该会员今天是否已经释放
                $arr = pdo_fetch("select * from " . tablename("ewei_shop_receive_hongbao") . "where openid=:openid and time>=$start and time<=$end  and uniacid=:uniacid", array(':openid' => $value['openid'], ':uniacid' => $_W['uniacid']));
                // var_dump($arr);

                if (!$arr && $value['credit1']) {  //无日志的情况下给会员释放积分
                    $openid = $value['openid'];
                    //获取该会员最高的投资倍率
                    $arr1 = m('member')->getMember($openid, true);

                    //最高倍率相应的释放比例
                    $result  = pdo_fetch("select * from" . tablename("ewei_shop_commission_level4") . "where uniacid=" . $_W['uniacid'] . " and start<=" . $arr1['credit1'] . " and end>=" . $arr1['credit1']);

                    //释放的比例
                    $proportion = $result['commission1'] + $result['commission2'];
                    if (!$proportion) $proportion = 0.3;
                    //静态账户获得金额
                    $money = round($proportion * $value['credit1'] * 0.8 * 0.01, 6);

                    //复投账户获得金额
                    $money2 = round($proportion * $value['credit1'] * 0.2 * 0.01, 6);

                    $money3 = $money + $money2;

                    $member = m('member')->getMember($openid, true);

                    //充值
                    m('member')->setCredit($openid, 'credit2', $money);
                    m('member')->setCredit($openid, 'credit4', $money2);
                    // 扣积分
                    // m('member')->setCredit($openid,'credit1',-$money3);
                    //管理奖
                    m('common')->shangji1($member['agentid'], $member['openid'], $money3, 2);

                    //积分释放记录
                    pdo_insert("ewei_shop_receive_hongbao", array('openid' => $openid, 'money' => $money, 'money2' => $money2, 'type' => '1', 'time' => time(), 'uniacid' => $_W['uniacid']));
                }
            }
        } else {

            echo "积分释放为每日00:01:00" . "<br/>";
        }
    }
}
