<?php 
    if (!defined('IN_IA')) {
        print ('Access Denied');
    }
    global $_W, $_GPC;
   
    $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    $uniacid   = $_W['uniacid'];
    if($op=='display'){
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $condition = "where  uniacid='".$uniacid."' AND leibie=1";
        if(!empty($_GPC['id'])){
            $member=m('member')->getMember($_GPC['id']);
            $condition.=" AND (zhuanopenid ='{$member['openid']}' OR shouopenid ='{$member['openid']}')";
       
         }
        $sqls = 'SELECT COUNT(*) FROM ' . tablename('sz_yi_zengsong') . $condition;
         
        $total = pdo_fetchcolumn($sqls);
        
        $pager = pagination($total, $pindex, $psize);
        $sql="select * from ".tablename('sz_yi_zengsong')." ".$condition ." order by time desc limit ". ($pindex - 1) * $psize . ',' . $psize;
      // print_r($sql);die;
        $list= pdo_fetchall($sql);
        
        

        
       /*  $sql="select * from ".tablename('sz_yi_fenhong')." where uniacid={$uniacid}";
        $list= pdo_fetchall($sql); */
      
       foreach ($list as $k=>$v){
            $member = m('member')->getMember($v['zhuanopenid']);
            $list[$k]['zhuanopenid']=!empty($member['nickname'])?$member['nickname']:$member['realname'];
            $member = m('member')->getMember($v['shouopenid']);
             $list[$k]['shouopenid']=!empty($member['nickname'])?$member['nickname']:$member['realname'];
        } 
    }else if($op=="zyw"){
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $condition = "where  uniacid='".$uniacid."' and leibie=2";
       if(!empty($_GPC['id'])){
            $member=m('member')->getMember($_GPC['id']);
            $condition.=" AND (zhuanopenid ='{$member['openid']}' OR shouopenid ='{$member['openid']}')";
       
         }
        $sqls = 'SELECT COUNT(*) FROM ' . tablename('sz_yi_zengsong') . $condition;
         
        $total = pdo_fetchcolumn($sqls);
        
        $pager = pagination($total, $pindex, $psize);
        $sql="select * from ".tablename('sz_yi_zengsong')." ".$condition ." order by time desc limit ". ($pindex - 1) * $psize . ',' . $psize;
        $list= pdo_fetchall($sql);
        
        
        
        
        /*  $sql="select * from ".tablename('sz_yi_fenhong')." where uniacid={$uniacid}";
         $list= pdo_fetchall($sql); */
        
        foreach ($list as $k=>$v){
            $member = m('member')->getMember($v['zhuanopenid']);
            $list[$k]['zhuanopenid']=!empty($member['nickname'])?$member['nickname']:$member['realname'];
            $member = m('member')->getMember($v['shouopenid']);
            $list[$k]['shouopenid']=!empty($member['nickname'])?$member['nickname']:$member['realname'];
        }
    }
    load()->func('tpl');
    include $this->template('web/shop/zyw');
    ?>