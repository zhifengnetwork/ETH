<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/statistics/tabs', TEMPLATE_INCLUDEPATH)) : (include template('web/statistics/tabs', TEMPLATE_INCLUDEPATH));?>
<style>
    .myform{margin: 10px 0;}
</style>
<div class="panel panel-info">
    <div class="panel-heading">按时间查询订单数和订单金额</div>
    <div class="panel-body">
        <form action="./index.php" method="get" class="form-horizontal"  id="form1">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="sz_yi" />
            <input type="hidden" name="do" value="statistics" />
            <input type="hidden" name="p"  value="order" />
            <div class="form-group">
	        	<div class="col-md-6 col-lg-4 myform">
	        		<div class='input-group'>
	            		<div class='input-group-addon'>会员名</div>
                        <input name="realname" type="text"  class="form-control" value="<?php  echo $_GPC['realname'];?>">
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 myform">
                    <div class='input-group'>
	                	<div class='input-group-addon'>收货人</div>
	                    <input name="addressname" type="text"  class="form-control" value="<?php  echo $_GPC['addressname'];?>">
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 myform">
                    <div class='input-group'>
                		<div class='input-group-addon'>订单号</div>
                    	<input name="ordersn" type="text"  class="form-control" value="<?php  echo $_GPC['ordersn'];?>">
                    </div>
                </div>
                <div class="form-group col-md-12 col-lg-8">
                    <div class='input-group'>
                        <div class='input-group-addon' style=" height: 34px; border-radius: 4px; border-left: 1px #ccc solid; border-right: 1px #ccc solid;">订单时间
                            <label class="radio-inline" style='margin-top:-7px;'><input type="radio" name="searchtime" value="0" <?php  if(empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>不搜索</label>
                            <label class="radio-inline" style='margin-top:-7px;'><input type="radio" name="searchtime" value="1" <?php  if(!empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>搜索</label>						</div>
                        <?php  echo tpl_form_field_daterange('datetime', array('starttime'=>date('Y-m-d H:i',$starttime),'endtime'=>date('Y-m-d H:i',$endtime)), true)?>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class='input-group'>
                        <button class="btn btn-default" ><i class="fa fa-search"></i>搜索</button>
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <?php  if('statistics.export.order') { ?>
                        <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
                        <?php  } ?>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">共计 <span style="color:red; "><?php  echo $totalcount;?></span> 个订单 , 金额共计 <span style="color:red; "><?php  echo $totalmoney;?></span>元</div>
    <div class="table-responsive">
	<table class="table table-hover table-bordered">
            <thead class="navbar-inner">
                <tr>
                    <th style="width:220px">订单号</th>
                    <th>总金额</th>
                    <th>商品小计</th>
					<th>运费</th>
					<th>会员折扣</th>					
					<th>积分抵扣</th>
					<th>余额抵扣</th>
					<th>满额立减</th>
					<th>优惠券优惠</th>
					<th>卖家改价</th>
					<th>卖家改运费</th>
                    <th style="width: 90px;">付款方式</th>
                    <th>会员名称</th>
                    <th>收货人</th>
                    <th>下单时间</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr  style="background: #eee">
                    <td><?php  echo $row['ordersn'];?></td>
                    <td><b><?php  echo $row['price'];?></b></td>
                    <td><?php  echo $row['goodsprice'];?></td>
					<td><?php  echo $row['dispatchprice'];?></td>
					<td><?php  if($row['discountprice']>0) { ?>-<?php  echo $row['discountprice'];?><?php  } ?></td>						
					<td><?php  if($row['deductprice']>0) { ?>-<?php  echo $row['deductprice'];?><?php  } ?></td>			
					<td><?php  if($row['deductcredit2']>0) { ?>-<?php  echo $row['deductcredit2'];?><?php  } ?></td>			
					<td><?php  if($row['deductenough']>0) { ?>-<?php  echo $row['deductenough'];?><?php  } ?></td>			
					<td><?php  if($row['couponprice']>0) { ?>-<?php  echo $row['couponprice'];?><?php  } ?></td>			
					<td><?php  if(0<$item['changeprice']) { ?>+<?php  } else { ?>-<?php  } ?><?php  echo number_format(abs($item['changeprice']),2)?></td>
                    <td><?php  if($row['paytype'] == 1) { ?>
                               <span class="label label-primary">余额支付</span>
                                 <?php  } else if($row['paytype'] == 11) { ?>
                               <span class="label label-default">后台付款</span>
                           <?php  } else if($row['paytype'] == 2) { ?>
                               <span class="label label-danger">在线支付</span>
                                 <?php  } else if($row['paytype'] == 21) { ?>
                               <span class="label label-success">微信支付</span>
                                 <?php  } else if($row['paytype'] == 22) { ?>
                               <span class="label label-warning">支付宝支付</span>
                                 <?php  } else if($row['paytype'] == 23) { ?>
                               <span class="label label-primary">银联支付</span>
                           <?php  } else if($row['paytype'] == 3) { ?>
                           <span class="label label-success">货到付款</span>
                         <?php  } ?>
                    </td>
                    <td><?php  echo $row['realname'];?></td>
                    <td><?php  echo $row['addressname'];?></td>
                    <td><?php  echo date('Y-m-d H:i',$row['createtime'])?></td>   
                </tr>	
                <tr >

                    <td colspan="15">
		   <?php  if(is_array($row['goods'])) { foreach($row['goods'] as $g) { ?>
		    <table style="width:200px;float:left;margin:10px 10px 0 10px;" title="<?php  echo $g['title'];?>">
				<tr>
					<td style="width:60px;border: none;"><img src="<?php  echo tomedia($g['thumb'])?>" style="width: 50px; height: 50px;border:1px solid #ccc;padding:1px;"></td>
					<td style="border: none;">
						单价: <?php  echo $g['realprice']/$g['total']?><br/>
						数量: <?php  echo $g['total'];?><br/>
						总价: <strong><?php  echo $g['realprice'];?></strong>
					</td>
				</tr>
			</table>
		   <?php  } } ?>
                    </td></tr>	
            <?php  } } ?>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
