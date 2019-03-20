<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/statistics/tabs', TEMPLATE_INCLUDEPATH)) : (include template('web/statistics/tabs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-info">
    <div class="panel-heading">查询商品销售量和销售额明细</div>
    <div class="panel-body">
        <form action="./index.php" method="get" class="form-horizontal">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="sz_yi" />
            <input type="hidden" name="do" value="statistics" />
            <input type="hidden" name="p"  value="goods" />
            <div class="form-group">
                <div class="col-md-3 col-lg-2">
	        		<div class='input-group'>
			            <div class='input-group-addon'>商品名称</div>
                    	<input name="title" type="text"  class="form-control" value="<?php  echo $_GPC['title'];?>">
					</div>
            	</div>   
            	<div class="col-md-9 col-lg-6">
        			<div class='input-group'>
		                <div class='input-group-addon'>下单时间
		                    <label class="radio-inline" style='margin-top:-7px;'><input type="radio" name="searchtime" value="0" <?php  if(empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>不搜索</label> 
		                    <label class="radio-inline" style='margin-top:-7px;'><input type="radio" name="searchtime" value="1" <?php  if(!empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>搜索</label>
			            </div>
                        <?php  echo tpl_form_field_daterange('datetime', array('starttime'=>date('Y-m-d H:i',$starttime),'endtime'=>date('Y-m-d H:i',$endtime)), true)?>
		            </div>
            	</div>   
            	<div class="col-md-6 col-lg-3">
        			<div class='input-group'>
		                <div class='input-group-addon' style=" height: 34px; border-radius: 4px; border-left: 1px #ccc solid; border-right: 1px #ccc solid;">排序方式
		                    <label class='radio-inline' style='margin-top:-7px;'><input type='radio' name='orderby' value='0' <?php  if(empty($_GPC['orderby'])) { ?>checked<?php  } ?>/>按销售额</label>
		                    <label class='radio-inline' style='margin-top:-7px;'><input type='radio' name='orderby' value='1'  <?php  if($_GPC['orderby']==1) { ?>checked<?php  } ?>/>按销售量</label>
		                </div>
					</div>
            	</div>   
            	<div class="col-md-6 col-lg-3" style="margin: 10px 0 0 0;">
        			<div class='input-group'>
	                    <button class="btn btn-default" ><i class="fa fa-search"></i>搜索</button>
	                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	                    <?php if(cv('statistics.export.goods')) { ?>
	                    <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
	                    <?php  } ?>
	                </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">总数: <span style='color:red'><?php  echo $total;?></span></div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="navbar-inner">
                <tr>
                    <th>订单号</th>
                    <th>商品名称</th>
                    <th>商品编号</th>
                    <th>数量</th>
                    <th>价格</th>
                    <th>成交时间</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td><?php  echo $item['ordersn'];?></td>
                    <td><img src="<?php  echo tomedia($item['thumb'])?>" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;">
                        <?php  echo $item['title'];?></td>
					 <td><?php  echo $item['goodssn'];?></td>
                    <td><?php  echo $item['total'];?></td>
                    <td><?php  echo $item['price'];?></td>
                    <td><?php  echo date('Y-m-d  H:i:s',$item['createtime'])?></td>
                </tr>
                <?php  } } ?>
        </table>
    </div>
    <?php  echo $pager;?>
</div>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
