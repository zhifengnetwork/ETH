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

<div class="page-header"><img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置：<span class="text-primary">佣金记录</span></div>

<div class="page-content">

    <form action="./index.php" method="get" class="form-horizontal table-search" role="form" id="form1">

        <input type="hidden" name="c" value="site" />

        <input type="hidden" name="a" value="entry" />

        <input type="hidden" name="m" value="ewei_shopv2" />

        <input type="hidden" name="do" value="web" />

        <input type="hidden" name="r" value="finance.log.commission" />

        <div class="page-toolbar">

            <!-- <span class="pull-left">

                    <?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'奖金时间'),true);?>

                </span> -->

            <div class="input-group">

                <span class="input-group-select">

                    <select name="type" class="form-control"   style="width:100px;"  >

                        <option value="" <?php  if(empty($_GPC['type'])) { ?>selected<?php  } ?>>奖金类型</option>

                            <option value="1" <?php  if($_GPC['type']=='1') { ?>selected<?php  } ?>>动态奖</option>

                            <option value="2" <?php  if($_GPC['type']=='2') { ?>selected<?php  } ?>>管理奖</option>

                            <option value="3" <?php  if($_GPC['type']=='3') { ?>selected<?php  } ?>>领导奖</option>

                    </select>

                </span>

                <span class="input-group-select">

                    <select name="searchfield"  class="form-control"   style="width:100px;"  >

                        <!-- <option value="logno" <?php  if($_GPC['searchfield']=='logno') { ?>selected<?php  } ?>>订单单号</option> -->

                        <option value="member" <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>

                    </select>

                </span>

                <input type="text" class="form-control"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词" />

                <span class="input-group-btn">

                    <button class="btn  btn-primary" type="submit"> 搜索</button>
                    
                    <?php if(cv('finance.log.commission.export')) { ?>

                   <!--  <button type="submit" name="export" value="1" class="btn btn-success">导出</button> -->

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

                    <th style='width:200px;'>奖金id</th>

                    <th>获利会员</th>

                    <th>来源会员</th>

                    <th>自由金额</th>

                    <th>复投金额</th>

                    <th style='width:100px;'>发放时间</th>

                    <th style='width:100px;text-align: center;'>发放类型</th>

                    <th style='width:200px;text-align: center;'>发放状态</th>

                </tr>

                </thead>

                <tbody>

                <?php  if(is_array($list)) { foreach($list as $row) { ?>

                <tr>

                    <td>
                        <?php  echo $row['id'];?>
                    </td>

                    <td data-toggle='tooltip' title='<?php  echo $row['m1nickname'];?>'>

                        <a  href="<?php  echo webUrl('member/list/detail',array('id' => $row['m1id']));?>" target='_blank'>
                            <img class="radius50" src='<?php  echo tomedia($row['m1avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' / onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"> <?php  echo $row['m1nickname'];?>
                            
                            <div>手机号码：<?php  if(!empty($row['m1mobile'])) { ?><?php  echo $row['m1mobile'];?><?php  } else { ?>暂无<?php  } ?></div>
                        </a>

                    </td>
                    
                    <td data-toggle='tooltip' title='<?php  echo $row['m2nickname'];?>'>

                        <a  href="<?php  echo webUrl('member/list/detail',array('id' => $row['m2id']));?>" target='_blank'>
                            <img class="radius50" src='<?php  echo tomedia($row['m2avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' / onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"> <?php  echo $row['m2nickname'];?>
                           
                            <div>手机号码：<?php  if(!empty($row['m2mobile'])) { ?><?php  echo $row['m2mobile'];?><?php  } else { ?>暂无<?php  } ?></div>
                        </a>

                    </td>
                    <?php  if($row['type']==1) { ?>
                    <td><?php  echo $row['money3'];?></td>
                    <td>0.00</td>
                    <?php  } else { ?>
                    <td><?php  echo $row['money'];?></td>

                    <td><?php  echo $row['money2'];?></td>
                    <?php  } ?>
                    

                    <td><?php  echo date('Y-m-d',$row['createtime'])?><br/><?php  echo date('H:i',$row['createtime'])?></td>

                    <td style="text-align: center;" class="style">

                        <?php  if($row['type']=='1') { ?>

                        <i class="icow icow-yue text-warning" ></i>动态奖

                        <?php  } else if($row['type']=='2') { ?>

                        <i class="icow icow-yue text-warning" ></i>管理奖

                        <?php  } else if($row['type']=='3') { ?>

                        <i class="icow icow-yue text-warning" ></i>领导奖

                        <?php  } ?>

                    </td>

                    <td style="text-align: center;">

                        <?php  if($row['type']==1) { ?>

                        <span class='text-success'><?php  echo $row['status'];?>级动态奖</span>

                        <?php  } else if($row['type']==2) { ?>

                        <span class='text-success'>管理奖</span>

                        <?php  } else if($row['type']==3) { ?>

                        <span class='text-success'>领导奖</span>

                        <?php  } ?>

                    </td>


                <?php  } } ?>

                </tbody>

                <tfoot>

                <tr>

                    </td>

                    <td colspan="7" style="text-align: right">

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