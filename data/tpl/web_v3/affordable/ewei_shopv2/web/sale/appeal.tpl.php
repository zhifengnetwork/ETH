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

        <input type="hidden" name="r" value="finance.log.recharge" />

        <div class="page-toolbar">

            <!-- <span class="pull-left">

                    <?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'申请时间'),true);?>

                </span> -->

            <!-- <div class="input-group">

                <span class="input-group-select">

                    <select name="status" class="form-control"   style="width:100px;"  >

                        <option value="" <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>状态</option>

                            <option value="1" <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>完成</option>

                            <option value="0" <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>申请中</option>

                            <option value="2" <?php  if($_GPC['status']=='2') { ?>selected<?php  } ?>>失败</option>

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

                </span>

                <span class="input-group-select">

                    <select name="searchfield"  class="form-control"   style="width:120px;"  >

                        <option value="logno" <?php  if($_GPC['searchfield']=='logno') { ?>selected<?php  } ?>>提现单号</option>

                        <option value="member" <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>

                    </select>

                </span>

                <input type="text" class="form-control"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词" />

                <span class="input-group-btn">

                    <button class="btn  btn-primary" type="submit"> 搜索</button>

                    <?php if(cv('finance.log.recharge.export')) { ?>

                        <!-- <button type="submit" name="export" value="1" class="btn btn-success ">导出</button>

                    <?php  } ?>

                </span>

            </div> -->

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

                    <th style='width:200px;'>申诉单号</th>

                    <th>申诉人</th>

                    <th>被申诉人</th>

                    <th>申诉订单号</th>

                    <th style='width:150px;'>申诉时间</th>

                    <!-- <th style='width:150px;text-align: center;'>申诉金额</th> -->

                    <!-- <th style='width:150px;text-align: center;'>支付凭证</th> -->

                    <th style='width:150px;text-align: center;'>状态</th>

                    <th style="text-align: center;">操作</th>
                    <th></th>

                </tr>

                </thead>

                <tbody>

                <?php  if(is_array($list)) { foreach($list as $row) { ?>

                <tr>
                    <td><?php  if(!empty($row['id'])) { ?>

                        <?php  echo $row['id'];?>

                        <?php  } else { ?>

                        <?php  echo $row['id'];?>

                        <?php  } ?>

                    </td>
                    <td><?php  echo $row['m2mobile'];?></td>
                    <td><?php  echo $row['m1mobile'];?></td>
                    <td><?php  echo $row['order_id'];?></td>
                    <td><?php  echo date('Y-m-d H:i',$row['createtime'])?></td>
                    <!-- <td><?php  echo $row['money'];?></td> -->

                    <!-- <td data-toggle='tooltip' title='<?php  echo $row['nickname'];?>'> -->

                    <!-- <td style="text-align: center;" class="style">

                        <a href="<?php  echo $row['file'];?>">
                            <img src="<?php  echo $row['file'];?>" style="width:100px;hight:100px;">
                        </a>
                    </td> -->

                    <td style="text-align: center;">



                        <?php  if($row['stuas']==0) { ?>

                        <span class='text-default'>申请中</span>

                        <?php  } else if($row['stuas']==1) { ?>

                        <span class='text-success'>申诉成功</span>

                        <?php  } else if($row['stuas']==2) { ?>

                        <span class='text-default'>申诉失败</span>

                        <?php  } else if($row['stuas']==3) { ?>

                        <span class='text-danger'>申诉无效</span>

                        <?php  } ?>

                    </td>

                    <td style="text-align: center;">
                            <a  class='btn btn-op btn-primary' href="<?php  echo webUrl('sale/appeal_list',array('id' => $row['id']));?>">
                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="查看详情">
                                        查看详情
                                </span>
                            </a>
                         <!-- <?php  if($row['stuas']==0) { ?>
                          <a  class='btn btn-op btn-primary' data-toggle='ajaxPost' data-confirm="确认同意申诉申请?" href="<?php  echo webUrl('sale/appeal_list',array('id' => $row['id'],'type'=>1));?>">
                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="同意">
                                        同意
                                </span>
                            </a>
                             <a  class='btn btn-op btn-primary' data-toggle='ajaxPost' data-confirm="确认拒绝申诉申请?" href="<?php  echo webUrl('sale/appeal_list',array('id' => $row['id'],'type'=>-1));?>">

                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="拒绝">

                                        拒绝

                                </span>

                            </a>
                        <?php  } else if($row['stuas']==1) { ?>
                            已同意
                        <?php  } else { ?>
                            已拒绝
                        <?php  } ?> -->

                    </td>
                    <td></td>

                </tr>
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

<!--NDAwMDA5NzgyNw==-->
