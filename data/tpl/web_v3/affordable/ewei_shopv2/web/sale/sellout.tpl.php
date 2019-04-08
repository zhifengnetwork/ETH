<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>

    .style i{

        vertical-align: middle;

    }
    .input-group-select{
        left:0;top:0;
    }
    .btn-success{
        margin-top: 0;
    }
</style>

<div class="page-header"><img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置：<span class="text-primary">提现申请记录</span></div>

<div class="page-content">

    <form action="./index.php" method="get" class="form-horizontal table-search" role="form" id="form1">

        <input type="hidden" name="c" value="site" />

        <input type="hidden" name="a" value="entry" />

        <input type="hidden" name="m" value="ewei_shopv2" />

        <input type="hidden" name="do" value="web" />

        <input type="hidden" name="r" value="sale.sellout" />

        <div class="page-toolbar">

            <span class="pull-left">

                    <?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'卖出订单创建时间'),true);?>

                </span>

            <div class="input-group">

                <span class="input-group-select">

                    <select name="status" class="form-control"   style="width:100px;"  >

                        <option value="" <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>状态</option>

                            <option value="0" <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>未交易</option>

                            <option value="1" <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>交易中</option>

                            <option value="2" <?php  if($_GPC['status']=='2') { ?>selected<?php  } ?>>交易完成</option>

                            <option value="3" <?php  if($_GPC['status']=='3') { ?>selected<?php  } ?>>交易失败</option>

                    </select>

                </span>

                <!-- <span class="input-group-select">

                    <select name="groupid" class="form-control" style="width:100px;"  >

                        <option value="">会员分组</option>

                        <?php  if(is_array($groups)) { foreach($groups as $group) { ?>

                        <option value="<?php  echo $group['id'];?>" <?php  if($_GPC['groupid']==$group['id']) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>

                        <?php  } } ?>

                    </select>

                </span> -->

                <!-- <span class="input-group-select">

                    <select name="level" class="form-control" style="width:100px;"  >

                        <option value="">会员等级</option>

                        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>

                        <option value="<?php  echo $level['id'];?>" <?php  if($_GPC['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>

                        <?php  } } ?>

                    </select>

                </span> -->

                <!-- <span class="input-group-select">

                    <?php  if($_GPC['type']==0) { ?>

                    <select name="rechargetype" class="form-control" style="width:100px;"  >

                        <option value='' <?php  if($_GPC['rechargetype']=='') { ?>selected<?php  } ?>>充值方式</option>

                        <option value='wechat' <?php  if($_GPC['rechargetype']=='wechat') { ?>selected<?php  } ?>>微信</option>

                        <option value='alipay' <?php  if($_GPC['rechargetype']=='alipay') { ?>selected<?php  } ?>>支付宝</option>

                        <option value='system' <?php  if($_GPC['rechargetype']=='system') { ?>selected<?php  } ?>>后台</option>

                        <option value='system1' <?php  if($_GPC['rechargetype']=='system1') { ?>selected<?php  } ?>>后台扣款</option>

                        <?php  if(p('ccard')) { ?><option value='ccard' <?php  if($_GPC['rechargetype']=='ccard') { ?>selected<?php  } ?>>充值卡返佣</option><?php  } ?>

                    </select>

                    <?php  } ?>

                </span> -->

                <span class="input-group-select">

                    <select name="searchfield"  class="form-control"   style="width:120px;"  >

                        <!-- <option value="logno" <?php  if($_GPC['searchfield']=='logno') { ?>selected<?php  } ?>>提现单号</option> -->

                        <option value="member" <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>

                    </select>

                </span>

                <input type="text" class="form-control"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词" />

                <span class="input-group-btn">

                    <button class="btn  btn-primary" type="submit"> 搜索</button>

                    <?php if(cv('finance.log.recharge.export')) { ?>

                        <!-- <button type="submit" name="export" value="1" class="btn btn-success ">导出</button> -->

                    <?php  } ?>

                </span>

            </div>

        </div>

    </form>

    <?php  if(empty($list)) { ?>

    <div class="panel panel-default">

        <div class="panel-body empty-data">未查询到相关数据</div>

    </div>

    <?php  } else { ?>

    <div class="row">

        <div class="col-md-12">

            <table class="table">

                <thead>

                <tr>

                    <th style='width:50px;text-align: center;'>id</th>

                    <th style='width:200px'>卖出人</th>

                    <th style='width:200px;'>购买人</th>

                    <th style='width:100px;'>卖出币</th>

                    <th style='width:100px;'>卖出金额</th>

                    <th style='width:100px;'>卖出手续费</th>

                    <th style='width:200px;'>卖出时间</th>

                    <th style='width:200px;'>购买时间</th>

                    <th style='width:300px;'>打款凭证</th>

                    <th style='width:100px;'>状态</th>



                </tr>

                </thead>

                <tbody>

                <?php  if(is_array($list)) { foreach($list as $row) { ?>

                <tr>

                    <!-- id -->
                    <td>
                        <?php  echo $row['id'];?>

                    </td>

                    <!-- 卖出人 -->
                    <td data-toggle='tooltip' title='<?php  echo $row['nickname'];?>'>

                        <?php if(cv('member.list.detail')) { ?>

                        <a  href="<?php  echo webUrl('member/list/detail',array('id' => $row['mid']));?>" target='_blank'>

                            <img class="radius50" src='<?php  echo tomedia($row['m1avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' / onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"> <?php  echo $row['m1nickname'];?>

                        </a>

                        <?php  } else { ?>

                        <img src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?>

                        <?php  } ?>

                    </td>

                    <!-- 购买人 -->
                    <td data-toggle='tooltip' title='<?php  echo $row['nickname'];?>'>

                        <?php if(cv('member.list.detail')) { ?>

                        <a  href="<?php  echo webUrl('member/list/detail',array('id' => $row['mid']));?>" target='_blank'>

                            <img class="radius50" src='<?php  echo tomedia($row['m2avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' / onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'">
                            <?php  if(!$row['m2nickname']) { ?>暂无<?php  } else { ?><?php  echo $row['m2nickname'];?><?php  } ?>

                        </a>

                        <?php  } else { ?>

                        <img src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?>

                        <?php  } ?>

                    </td>

                    <!-- 卖出币 -->
                    <td><?php  echo $row['trx'];?></td>

                    <!-- 卖出金额 -->
                    <td><?php  echo $row['money'];?></td>

                    <!-- 卖出手续费 -->
                    <td><?php  echo $row['trx2']-$row['trx'];?></td>

                    <!-- 卖出时间 -->
                    <td  class="style">
                        <?php  echo date("Y-m-d H:i:s",$row['createtime']);?>
                    </td>

                    <!-- 购买时间  -->
                    <td  class="style">
                        <?php  if($row['endtime']) { ?>  <?php  echo date("Y-m-d H:i:s",$row['endtime']);?><?php  } ?>
                    </td>

                    <!-- 打款凭证 -->
                    <td style="">
                         <a href='<?php  echo $row['file'];?>'>
                            <img src="<?php  echo $row['file'];?>" style="width:100px;hight:100px;">
                        </a>
                    </td>

                    <!-- 状态 -->
                    <td>
                        <?php  if($row['status']==0) { ?>

                        <span class='text-default'>未交易</span>

                        <?php  } else if($row['status']==1) { ?>

                        <span class='text-success'>交易中</span>

                        <?php  } else if($row['status']==2) { ?>

                        <span class='text-default'>交易完成</span>

                        <?php  } else if($row['status']==3) { ?>

                        <span class='text-danger'>交易失败</span>

                        <?php  } ?>
                    </td>



                </tr>

                <?php  if(!empty($row['remark'])) { ?>

                <tr style=";border-bottom:none;background:#f9f9f9;">

                    <td colspan='8' style='text-align:left'>

                        备注:<span class="text-info"><?php  echo $row['remark'];?></span>

                    </td>

                </tr>

                <?php  } ?>

                <?php  } } ?>

                </tbody>

                <tfoot>

                <tr>

                    </td>

                    <td colspan="8" style="text-align: right">

                        <?php  echo $pager;?>

                    </td>

                </tr>

                </tfoot>

            </table>

        </div>

    </div>

    <?php  } ?>



</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>



<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->
