<?php







 if (!defined('IN_IA')){

    exit('Access Denied');

}

global $_W, $_GPC;

$openid = m('user') -> getOpenid();
if(empty($openid)){
   $openid="oY2AEv8tgKppRT5ILpTgQSyUjVdg";
}

$member = pdo_fetch("SELECT * FROM ".tablename("sz_yi_member")." WHERE uniacid=:uniacid AND openid=:openid",array(":uniacid"=>$_W['uniacid'],":openid"=>$openid));
 
$level = 1;
$res = pdo_fetchall("SELECT t.*,m.nickname,g.title,g.thumb FROM ".tablename("sz_yi_tudi_1"). " AS t LEFT JOIN ".tablename("sz_yi_member")." AS m ON t.openid=m.openid LEFT JOIN ".tablename("sz_yi_goods")." AS g ON t.goodsid = g.id WHERE t.uniacid=:uniacid AND t.openid <> :openid AND t.status = 1 AND t.tnum=0 and t.csshijian>".time()." ORDER BY t.csshijian  LIMIT 10 ",array(":uniacid"=>$_W['uniacid'],":openid"=>$openid));
$time=time();
 foreach ($res as $k=>$v){
    if($v['csshijian']<=$time){
        $res[$k]['zyw_time']=0;
    }else{
         $res[$k]['zyw_time']=$v['csshijian']-$time;
    }
} 
$op = !empty($_GPC['op']) ? $_GPC['op'] : "display";
/* print_r($res);die; */
if( $op == 'ht' ){ 
	$id = $_GPC['id'];
	$res = pdo_fetch("SELECT * FROM ".tablename("sz_yi_tudi_1")." WHERE id=:id AND uniacid=:uniacid",array(":uniacid"=>$_W['uniacid'],":id"=>$id));
	$zyw_tou=$res['csnum']*0.2;
	/* $myshu = pdo_fetch("SELECT * FROM ".tablename("sz_yi_tudi_1")." WHERE openid=:openid AND uniacid=:uniacid AND status=1 AND goodsid > 0",array(":uniacid"=>$_W['uniacid'],":openid"=>$openid)); */
	$myyuanguo = pdo_fetchcolumn("SELECT yuanguo FROM ".tablename("sz_yi_member")." WHERE openid=:openid AND uniacid=:uniacid",array(":uniacid"=>$_W['uniacid'],":openid"=>$openid));
	if($res['csshijian']<=$time){
	    $res['zyw_time']=0;
	}else{
	    $res['zyw_time']=$res['csshijian']-$time;
	}
	if($res['zyw_time']>0){
	    show_json(-1,'果实还未成熟，等会再来！');
	}
	
	
	//判断被偷的数量
	if(!empty($res['tnum'])){ 
		show_json(-1,'请收下留情！这颗树已被偷!');
	}
	//判断被偷的数量
	if($res['csnum']<0.5){
	    show_json(-1,'果实不多了，给主人留点吧!');
	}

	//查找地主是否存在狗
	$doy = pdo_fetch("SELECT * FROM ".tablename("sz_dog")." WHERE openid=:openid AND uniacid=:uniacid",array(":uniacid"=>$_W['uniacid'],':openid'=>$res['openid']));
	$sj = rand(0,9);
	if($doy['level'] == 1){ 
		if($sj < 5){ 
			$beikou = true;
			$yg = $zyw_tou;
		}else{ 
			$beikou = false;
		}
	}
	if($doy['level'] == 2){ 
		if($sj < 6){ 
			$beikou = true;
			$yg = $zyw_tou*1.5;
		}else{ 
			$beikou = false;
		}
	}
	if($doy['level'] == 3){ 
		if($sj < 7){ 
			$beikou = true;
			$yg = $zyw_tou*2;
		}else{ 
			$beikou = false;
		}
	}

	if($myyuanguo<$yg){
	    show_json(-1,'您的原果不足！无法偷取！');
	}
	if(!$beikou){ 	
		$tdata['tnum'] = -$zyw_tou; 
		pdo_update("sz_yi_tudi_1",$tdata,array("id"=>$id));
		$yuanguo = $member['yuanguo'] + $zyw_tou;
		pdo_update("sz_yi_member",array("yuanguo"=>$yuanguo),array("openid"=>$openid));
		$dodata['openid'] = $openid;
		$dodata['stime']  = time();
		$dodata['knum']   = $zyw_tou;
		$dodata['kopenid']= $res['openid'];
		$dodata['uniacid']= $_W['uniacid'];
		$dodata['status'] = 1;
		pdo_insert('sz_dog_log',$dodata);
		$res = "偷取成功，成功偷取".$zyw_tou."原果！";

	}else{ 
		$tdata['tnum'] = $yg; 
		pdo_update("sz_yi_tudi_1",$tdata,array("id"=>$id));
		$yuanguo = $member['yuanguo'] - $yg;
		pdo_update("sz_yi_member",array("yuanguo"=>$yuanguo),array("openid"=>$openid));
		$dodata['openid'] = $openid;
		$dodata['stime']  = time();
		$dodata['knum']   = $yg;
		$dodata['kopenid']= $res['openid'];
		$dodata['uniacid']= $_W['uniacid'];
		$dodata['status'] = 2;
		pdo_insert('sz_dog_log',$dodata);
		$res = '被小狗捉了,您被扣'.$yg."原果！";

	}
	

	show_json(-1,$res);
}


include $this -> template('shop/steal');

