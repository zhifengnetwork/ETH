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
            $ass = pdo_fetchall("select openid,credit1,credit2,credit4,type from " . tablename("ewei_shop_member") . " where uniacid=:uniacid and type='1' and suoding = 0 ", array(':uniacid' => $_W['uniacid']));
            foreach ($ass as $key => $value) {
                $credit = 0;
                $credit1 = 0;
                $receive_hongbao = pdo_fetchall("select * from" . tablename("ewei_shop_receive_hongbao") . "where openid='" . $value['openid'] . "'");
                $receive_logs    = pdo_fetchall("select * from" . tablename("ewei_shop_order_goods1") . "where openid='" . $value['openid'] . "'");
                foreach ($receive_logs as $key1 => $value1){
                        $credit1 += $value1['money']+$value1['money2'];
                }
                foreach ($receive_hongbao as $k => $val) {
                        $credit += $val['money'] + $val['money2'];
                }
                $credit = $credit1 + $credit;

                //向积分释放表中查询该会员今天是否已经释放
                $arr = pdo_fetch("select * from " . tablename("ewei_shop_receive_hongbao") . "where openid=:openid and time>=$start and time<=$end  and uniacid=:uniacid", array(':openid' => $value['openid'], ':uniacid' => $_W['uniacid']));
                // var_dump($arr);

                if (!$arr && $value['credit1']) {  //无日志的情况下给会员释放积分
                    $openid = $value['openid'];
                    //获取该会员最高的投资倍率
                    $arr1 = m('member')->getMember($openid, true);

                    //最高倍率相应的释放比例
                    $result  = pdo_fetch("select * from" . tablename("ewei_shop_commission_level4") . "where uniacid=" . $_W['uniacid'] . " and start<=" . $arr1['credit1'] . " and end>=" . $arr1['credit1']);
                    // dump($result['multiple']);
                    //释放的比例
                    $proportion = $result['commission1'] + $result['commission2'];
                    // dump($proportion.'-------------'.$arr1['openid']);
                    //收益总币数
                    $money_propor = $result['multiple'] * $value['credit1'];

                    if ($credit >= $money_propor) {
                        pdo_update("ewei_shop_member", " suoding='1' ", array('openid' => $openid));
                        continue;
                    }
                    if (!$proportion) $proportion = 0.3;
                    dump($proportion.'-------------'.$arr1['openid']);
                    $nums_money = round($proportion * $value['credit1'] * 0.01, 6);
                    dump($nums_money);
                    //静态账户获得金额
                    $money1 = round($nums_money*0.8,6);

                    //复投账户获得金额
                    $money2 = round($nums_money*0.2,6);


                    $member = m('member')->getMember($openid, true);
                    dump($money1);
                    dump($money2);
                    //充值
                    m('member')->setCredit($openid, 'credit2', $money1);
                    m('member')->setCredit($openid, 'credit4', $money2);
                    // 扣积分
                    // m('member')->setCredit($openid,'credit1',-$money3);
                    //管理奖
                    $money = m('common')->shangji1($member['agentid'], $member['openid'], $nums_money, 2,1);
                    if(!empty($money))
                    {
                        //动态奖金
                        // dump($money."-----".$member['agentid']."-------------------".$member['id']);
                        // $this->money($member,$money);
                        //获取所有上级
                        $user_list = m('common')->get_uper_user($member['agentid']);
                        $money = $money;
                        foreach($user_list['recUser'] as $key=>$value){
                            if($value['id'] == $member['agentid'])
                            {
                                continue;
                            }
                            $member1 = pdo_fetchall("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and agentid= '".$value['id']."' and type = 1");
                            //直推人数
                            $nums = count($member1);
                            if($nums>=5){
                                $agentid = $value['id'];
                                // dump('1111111-------------'.$agentid.'========'.$money);
                                $list111 = m('common')->shangji1($agentid,$member['openid'],$money,$key+1,2);
                                $money = $list111;
                            }else{
                                break;
                            }
                        }
                        
                    }
                    
                    // //积分释放记录
                    pdo_insert("ewei_shop_receive_hongbao", array('openid' => $openid, 'money' => $money1, 'money2' => $money2, 'money3' => $nums_money, 'type' => '1', 'time' => time(), 'uniacid' => $_W['uniacid']));
                }
            }
        } else {

            echo "积分释放为每日00:01:00\n";
        }
    }

    
    //动态奖金
    public function money($member,$money)
    {
        global $_W;
        dump($money);
        //今日开始时间和结束时间戳
        $start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        $user_order_goods = pdo_fetch("select * from".tablename("ewei_shop_order_goods1")."where openid2='".$member['openid']."' and createtime>='$start' and createtime<='$end' and jindongtai=1");
        dump($user_order_goods);
        $user_list = pdo_fetchall("select * from".tablename("ewei_shop_member")."where agentid='".$member['id']."'"); 
        $money = $money;
        if($user_list){
            dump($money.'++++++++++++++++++');
            //获取所有上级
            $user_list = m('common')->get_uper_user($member['agentid']);
            
            foreach($user_list['recUser'] as $key=>$value){
                // if($value['id'] == $member['id'])
                // {
                //     continue;
                // }         
                $member1 = pdo_fetchall("select * from".tablename("ewei_shop_member")."where uniacid=".$_W['uniacid']." and agentid= '".$value['id']."' and type = 1");
                //直推人数
                $nums = count($member1);
                if($nums>=5){
                    $agentid = $value['id'];
                    dump('1111111-------------'.$agentid.'========'.$money);
                    $list111 = m('common')->shangji1($agentid,$member['openid'],$money,$key+1);
                    $money = $list111;
                }else{
                    break;
                }
            } 
        }
    }
}
