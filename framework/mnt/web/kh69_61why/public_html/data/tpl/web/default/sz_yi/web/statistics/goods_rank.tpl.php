<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/statistics/tabs', TEMPLATE_INCLUDEPATH)) : (include template('web/statistics/tabs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-info">
    <div class="panel-heading">查询商品销售量和销售额，默认排序为销售额从高到低</div>
    <div class="panel-body" style="padding: 6px 0px;">
        <form action="./index.php" method="get" class="form-horizontal">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="sz_yi" />
            <input type="hidden" name="do" value="statistics" />
            <input type="hidden" name="p"  value="goods_rank" />
            <div class="form-group">
                <div class="col-sm-6 col-lg-2" style="margin: 15px 0 0 0;">
	        		<div class='input-group'>
			            <div class='input-group-addon'>商品名称</div>
                    	<input name="title" type="text"  class="form-control" value="<?php  echo $_GPC['title'];?>">
					</div>
            	</div>
            	<div class="col-sm-6 col-lg-3" style="margin: 15px 0 0 0;">
        			<div class='input-group'>
		                <div class='input-group-addon' style=" height: 34px; border-radius: 4px; border-left: 1px #ccc solid; border-right: 1px #ccc solid;">排序方式
		                    <label class='radio-inline' style='margin-top:-7px;'><input type='radio' name='orderby' value='0' <?php  if(empty($_GPC['orderby'])) { ?>checked<?php  } ?>/>按销售额</label>
		                    <label class='radio-inline' style='margin-top:-7px;'><input type='radio' name='orderby' value='1'  <?php  if($_GPC['orderby']==1) { ?>checked<?php  } ?>/>按销售量</label>
		                </div>
					</div>
            	</div>
                <div class="col-sm-8 col-lg-7" style="margin: 15px 0 0 0;">
                    <div class='input-group'>
                        <div class='input-group-addon'>下单时间
                            <label class="radio-inline" style='margin-top:-7px;'><input type="radio" name="searchtime" value="0" <?php  if(empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>不搜索</label>
                            <label class="radio-inline" style='margin-top:-7px;'><input type="radio" name="searchtime" value="1" <?php  if(!empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>搜索</label>
                        </div>
                        <?php  echo tpl_form_field_daterange('datetime', array('starttime'=>date('Y-m-d H:i',$starttime),'endtime'=>date('Y-m-d H:i',$endtime)), true)?>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-3" style="margin: 15px 0 0 0;">
        			<div class='input-group'>
		                <button class="btn btn-default" ><i class="fa fa-search"></i>搜索</button>
		                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		                <?php if(cv('statistics.export.goods_rank')) { ?>
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
            <thead>
                <tr>
                    <th style='width:80px;'>排行</th>
                    <th>商品名称</th>
                    <th>销售量</th>
                    <th>销售额</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $key => $row) { ?>
                <tr>
                    <td><?php  if(($pindex -1)* $psize + $key + 1<=3) { ?>
                             <labe class='label label-danger' style='padding:8px;'>&nbsp;<?php  echo ($pindex -1)* $psize + $key + 1?>&nbsp;</labe>
                            <?php  } else { ?>
                             <labe class='label label-default'  style='padding:8px;'>&nbsp;<?php  echo ($pindex -1)* $psize + $key + 1?>&nbsp;</labe>
                           <?php  } ?>
                       </td>
                    <td>
                        <img src="<?php  echo tomedia($row['thumb'])?>" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;">
                        <?php  echo $row['title'];?></td>
                    <td><?php  echo $row['count'];?></td>
                    <td><?php  echo $row['money'];?></td>
                </tr>
                <?php  } } ?>
        </table>
    </div>
    <?php  echo $pager;?>
</div>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
