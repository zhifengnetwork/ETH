<?php


global $_W, $_GPC;


$operation   = empty($_GPC['op']) ? 'display' : $_GPC['op'];
if ($operation == 'display') {
    $params    = array();
    $condition = '';
    if (!empty($_GPC['mid'])) {
        $condition .= ' and id=:mid';
        $condition1 .= ' and r.mid=:mid';
        $params[':mid'] = intval($_GPC['mid']);
    }
    if (!empty($_GPC['realname'])) {
        $_GPC['realname'] = trim($_GPC['realname']);
        $condition .= ' and ( realname like :realname or nickname like :realname or mobile like :realname)';
        $condition1 .= ' and ( m.realname like :realname or m.nickname like :realname or m.mobile like :realname)';
        $params[':realname'] = "%{$_GPC['realname']}%";  
    }

    $total = pdo_fetchall("select * from" . tablename('sz_yi_returnmatter') . " r 
        left join " . tablename('sz_yi_member') . " m on (r.mid = m.id ) where r.uniacid =" . $_W['uniacid'] . " {$condition1} group by mid" ,$params);
    $total = count($total);  
	
	
	
    $list_group=pdo_fetchall(" select * from " .tablename('sz_yi_returnmatter'). " r 
        left join " . tablename('sz_yi_member') . " m on (r.mid = m.id ) where r.uniacid= " .$_W['uniacid']. "  {$condition1}  group by mid",$params);
	 
    foreach( $list_group as $row1){
        $infomation=pdo_fetch("select * from " .tablename('sz_yi_member'). "  where uniacid=" .$_W['uniacid']. " and id=" .$row1['mid'] );
       $list_group1[$row1['mid']]= pdo_fetchall(" select * from " .tablename('sz_yi_returnmatter'). " where uniacid=" .$_W['uniacid']. "     and  mid = ".$row1['mid']);
	   /*  print_r("<pre>");
		print_r($list_group1); */
       foreach($list_group1[$row1['mid']] as  $row2){
			
			 
            $asd[$row1['mid']]['money1']+=$row2['money'];
			
            $asd[$row1['mid']]['return_money1']+=$row2['return_money'];
            $asd[$row1['mid']]['status']=$row2['status'];
       }
       $asd[$row1['mid']]['realname']=$infomation['realname'];
       $asd[$row1['mid']]['avatar']=$infomation['avatar'];
       $asd[$row1['mid']]['mid']=$infomation['id'];
      /*  $asd[$row1['mid']]['unreturnmoney']=$asd[$row1['mid']]['money1'] - $asd[$row1['mid']]['return_money1'];  */
	 $asd[$row1['mid']]['unreturnmoney']=$asd[$row1['mid']]['return_money1'];  
       
    }

    unset($row);

}elseif ($operation == 'detail') {

	
    $total = pdo_fetchall("select * from" . tablename('sz_yi_returnmatter') . " r 
        left join " . tablename('sz_yi_member') . " m on (r.mid = m.id ) where r.uniacid =" . $_W['uniacid'] ." and r.mid = ".$_GPC['mid'],$params);
    $total = count($total);

    $list_group=pdo_fetchall(" select r.id, r.uniacid, r.mid, r.money, r.return_money, r.createtime, r.status, m.realname, m.nickname, m.avatar from " .tablename('sz_yi_returnmatter'). " r 
        left join " . tablename('sz_yi_member') . " m on (r.mid = m.id ) where r.uniacid= " .$_W['uniacid'] ." and r.mid = ".$_GPC['mid'],$params);
    foreach ($list_group as $key => $value) {
      /*   $list_group[$key]['unreturnmoney'] = $value['money'] - $value['return_money']; */
	    $list_group[$key]['unreturnmoney'] = $value['return_money'];
        $list_group[$key]['createtime'] = date('Y-m-d H:i',$value['createtime']);
    }
 
    // }

    unset($row);

}

include $this->template('return_tj');

