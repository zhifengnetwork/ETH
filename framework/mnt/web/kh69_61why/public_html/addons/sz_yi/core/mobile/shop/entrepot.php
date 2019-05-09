<?php







 if (!defined('IN_IA')){

    exit('Access Denied');

}

global $_W, $_GPC;

$openid = m('user') -> getOpenid();



if(empty($openid)){

//    $openid="oY2AEv6i3Dulf1pOYfR50P22pmtM";

}

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';

$sql="select yuanguo from ".tablename('sz_yi_member')." where openid='".$openid."'";

$yuanguo=pdo_fetchcolumn($sql);

$glao = pdo_fetchall("SELECT l.stime,l.knum,m.nickname,m.avatar FROM ".tablename("sz_dog_log")." AS  l LEFT JOIN ".tablename("sz_yi_member")." AS m ON l.openid=m.openid WHERE l.kopenid=:openid AND l.uniacid=:uniacid AND l.status=2 ORDER BY l.stime DESC ",array(":uniacid"=>$_W['uniacid'],":openid"=>$openid));

$htou = pdo_fetchall("SELECT l.stime,l.knum,m.nickname,m.avatar,l.status FROM ".tablename("sz_dog_log")." AS  l LEFT JOIN ".tablename("sz_yi_member")." AS m ON l.kopenid=m.openid WHERE l.openid=:openid AND l.uniacid=:uniacid  ORDER BY l.stime DESC ",array(":uniacid"=>$_W['uniacid'],":openid"=>$openid));

$dog  = pdo_fetch("SELECT * FROM ".tablename("sz_dog")." WHERE openid=:openid AND uniacid=:uniacid",array(":openid"=>$openid,":uniacid"=>$_W['uniacid']));
if($dog['level'] < 3){ 
	if(!empty($dog['etime']) && $dog['etime'] > time()){ 
		$ltime = $dog['etime'] - time();
	}else{ 
		if($dog['level'] == 1){ 
			$foot = pdo_fetch("SELECT id,title,thumb FROM ".tablename("sz_yi_goods")." WHERE uniacid=:uniacid AND id=6 ",array(":uniacid"=>$_W['uniacid']));
		}elseif($dog['level'] == 2){ 
			$foot = pdo_fetch("SELECT id,title,thumb FROM ".tablename("sz_yi_goods")." WHERE uniacid=:uniacid AND id=7 ",array(":uniacid"=>$_W['uniacid']));
		}
	}
}

if ($_W['isajax']){

    if($op=="duihuan"){

        $num=$_GPC['num'];

        $row=m('order')->duihuan($openid,$num);

        if($row==false){

            show_json(-1,'兑换失败！');

        }else{

            show_json(1,'兑换成功！');

        }

    }

  }

include $this -> template('shop/entrepot');

