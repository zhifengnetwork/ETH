<?php
/*=============================================================================
#     FileName: shop.php
#         Desc: �̳���
#       Author: Yunzhong - http://www.yunzshop.com
#        Email: 1084070868@qq.com
#     HomePage: http://www.yunzshop.com
#      Version: 0.0.1
#   LastChange: 2016-02-05 02:35:01
#      History:
=============================================================================*/
if (!defined('IN_IA')) {
    exit('Access Denied');
}
class Sz_DYi_Shop
{
    public function getCategory()
    {
        global $_W;
        $shopset     = m('common')->getSysset('shop');
        $allcategory = array();
        $category    = pdo_fetchall("SELECT * FROM " . tablename('sz_yi_category') . " WHERE uniacid=:uniacid and enabled=1 ORDER BY parentid ASC, displayorder DESC", array(
            ':uniacid' => $_W['uniacid']
        ));
        $category    = set_medias($category, array(
            'thumb',
            'advimg'
        ));
        foreach ($category as $c) {
            if (empty($c['parentid'])) {
                $children = array();
                foreach ($category as $c1) {
                    if ($c1['parentid'] == $c['id']) {
                        if (intval($shopset['catlevel']) == 3) {
                            $children2 = array();
                            foreach ($category as $c2) {
                                if ($c2['parentid'] == $c1['id']) {
                                    $children2[] = $c2;
                                }
                            }
                            $c1['children'] = $children2;
                        }
                        $children[] = $c1;
                    }
                }
                $c['children'] = $children;
                $allcategory[] = $c;
            }
        }
        return $allcategory;
    }
    //add zyw
    public function getlevel($openid){
        global $_W;
        $sql="select level from ".tablename('sz_yi_member')." where openid='".$openid."'";
        $level=pdo_fetchcolumn($sql);
        return $level;
    }
    
    public function getid($openid) {
        //查id
        global $_W;
        $sql="select id from ".tablename('sz_yi_member')." where openid='".$openid."'";
        $id=pdo_fetchcolumn($sql);
        return $id;
    }
    public function xiaji($openid) {
        //查所有下级openID
        global $_W;
        $id=$this->getid($openid);
        $sql="select openid from ".tablename('sz_yi_member')." where agentid='".$id."'";
        $xiaji=pdo_fetchall($sql);
        return $xiaji;
    }
    public function xiaji_fx($openid) {
        //查所有下级openID
        global $_W;
        $id=$this->getid($openid);
        $sql="select openid from ".tablename('sz_yi_member')." where agentid='".$id."' and status=1 and isagent=1";
        $xiaji=pdo_fetchall($sql);
        return $xiaji;
    }
    
    public function fxs($openid,$sum=0) {
        //查所有下级分销商openID
        global $_W;
        $fx=$this->xiaji_fx($openid);
        $sum+= count($fx);//有多少个
       if(!empty($fx)){
           foreach ($fx as $v){
               $a=$this->fxs($v['openid']);
               $sum+= $a;//有多少个
           }
            
       }
       return $sum;
      
    }
     
    public function sumopenid($openid,$sum=0) {
        //计算团队总金额
        global $_W;
        //    'obf5cv-d7KzElTsRk-KFjwR2MdbA'
         
        $sql="select sum(price) from ".tablename('sz_yi_order')." where openid='".$openid."' and status=3";
        $price=pdo_fetchcolumn($sql);
        $sum+=$price;
        $zyw=$this->xiaji($openid,$sum);
         
        if(!empty($zyw)){
            foreach ($zyw as $v){
                $a=$this->sumopenid($v['openid']);
                $sum+=$a;
            }
             
        }
        return $sum;
         
    }
    public function sumopenid_1($openid,$sum=0) {
        //计算团队微信总金额
        global $_W;
        //    'obf5cv-d7KzElTsRk-KFjwR2MdbA'
         
        $sql="select sum(price) from ".tablename('sz_yi_order')." where openid='".$openid."' and status=3 and paytype=100";
        $price=pdo_fetchcolumn($sql);
        $sum+=$price;
        $zyw=$this->xiaji($openid,$sum);
         
        if(!empty($zyw)){
            foreach ($zyw as $v){
                $a=$this->sumopenid_1($v['openid']);
                $sum+=$a;
            }
             
        }
        return $sum;
         
    }
    public function sumopenid_3($openid,$sum=0){
        $a=$this->sumopenid_1($openid);
        $b=$this->sumopenid_2($openid);
        return $a+$b;
    }
    public function sumopenid_2($openid,$sum=0) {
        //计算团队总金额
        global $_W;
        //    'obf5cv-d7KzElTsRk-KFjwR2MdbA'
         
        $sql="select sum(price) from ".tablename('sz_yi_order')." where openid='".$openid."' and status=3 and paytype=0";
        $price=pdo_fetchcolumn($sql);
        $sum+=$price;
        $zyw=$this->xiaji($openid,$sum);
         
        if(!empty($zyw)){
            foreach ($zyw as $v){
                $a=$this->sumopenid_2($v['openid']);
                $sum+=$a;
            }
             
        }
        return $sum;
         
    }
}
