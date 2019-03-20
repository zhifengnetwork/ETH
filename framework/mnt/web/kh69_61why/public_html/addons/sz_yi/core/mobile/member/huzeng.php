<?php
if (! defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation = ! empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid = m('user')->getOpenid();
$uniacid = $_W['uniacid'];
$zyw = ! empty($_GPC['type']) ? $_GPC['type'] : 0;
if ($_W['isajax']) {
    if ($operation == 'display') {
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        
        if ($zyw == 0) {
            $condition = " and zhuanopenid=:openid and uniacid=:uniacid and leibie=1";
        } elseif ($zyw == 1) {
            $condition = " and zhuanopenid=:openid and uniacid=:uniacid and leibie=2";
        } elseif ($zyw == 2) {
            $condition = " and shouopenid=:openid and uniacid=:uniacid and leibie=1";
        } elseif ($zyw == 3) {
            $condition = " and shouopenid=:openid and uniacid=:uniacid and leibie=2";
        }
        
        $params = array(
            ':uniacid' => $uniacid,
            ':openid' => $openid
        );
        $list = pdo_fetchall("select * from " . tablename('sz_yi_zengsong') . " where 1 {$condition} order by time desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_zengsong') . " where 1 {$condition}", $params);
        
        if ($zyw == 0) {
            foreach ($list as &$row) {
                $row['time'] = date('Y-m-d H:i', $row['time']);
                $member = m('member')->getMember($row['shouopenid']);
                $row['shouopenid'] = empty($member['nickname']) ? $member['mobile'] : $member['nickname'];
            }
        } elseif ($zyw == 1) {
            foreach ($list as &$row) {
                $row['time'] = date('Y-m-d H:i', $row['time']);
                $member = m('member')->getMember($row['shouopenid']);
                $row['shouopenid']= empty($member['nickname']) ? $member['mobile'] : $member['nickname'];
            }
        } elseif ($zyw == 2) {
            foreach ($list as &$row) {
                $row['time'] = date('Y-m-d H:i', $row['time']);
                $member = m('member')->getMember($row['zhuanopenid']);
                $row['zhuanopenid'] = empty($member['nickname']) ? $member['mobile'] : $member['nickname'];
            }
        } elseif ($zyw == 3) {
            foreach ($list as &$row) {
                $row['time'] = date('Y-m-d H:i', $row['time']);
                $member = m('member')->getMember($row['zhuanopenid']);
                $row['zhuanopenid'] = empty($member['nickname']) ? $member['mobile'] : $member['nickname'];
            }
        }
        unset($row);
        show_json(1, array(
            'total' => $total,
            'list' => $list,
            'pagesize' => $psize,
            'zyw'=>$zyw
        ));
    }
}
include $this->template('member/huzeng');