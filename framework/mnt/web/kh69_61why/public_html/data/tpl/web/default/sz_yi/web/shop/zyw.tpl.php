<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/tabs2', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/tabs2', TEMPLATE_INCLUDEPATH));?>



<?php  if($op=="display" || $op=='zyw') { ?>
<div class="main rightlist">
<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
				<input type="hidden" name="m" value="sz_yi" />
				<input type="hidden" name="do" value="shop" />
				<input type="hidden" name="p"  value="zyw" />
				<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>" />
				<div class="form-group">
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
						<div class='input-group'>
							<div class='input-group-addon'>用户id</div>
							<input class="form-control" name="id" id="" type="text" value="<?php  echo $_GPC['id'];?>">
						</div>
					</div>



					<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
						<div class='input-group'>
							<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button></div>
					</div>
				</div>
			</form>
		</div>
	</div> 
	<style>
		.label{cursor:pointer; line-height: 2.5;}
		.panel .table td, .panel .table th{ text-align: center; }
	</style>
	<!-- <div class="panel panel-default">
		<div class="panel-body">
			<a class='btn btn-primary' href="<?php  echo $this->createWebUrl('shop/qiche')?>">汽车管理</a>>汽车类型
		</div>
	</div> -->
	<form action="" method="post">
		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th width="20%">ID</th>
						<th width="20%">赠</th>
						<th width="20%">收</th>
						<th width="20%">时间</th>
						<th width="20%">金额</th>
				
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($list)) { foreach($list as $item) { ?>
					<tr>

						<td><?php  echo $item['id'];?></td>
						<td ><?php  echo $item['zhuanopenid'];?></td>
						<td ><?php  echo $item['shouopenid'];?></td>
						<td ><?php  echo date('Y-m-d H:i:s',$item['time']);?></td>
						
						<td ><?php  echo $item['jine'];?></td>
						
					</tr>
					<?php  } } ?>
					

					
					</tbody>
					
				</table>
				<?php  echo $pager;?>
			</div>
		</div>
	</form>
</div>
</div>

<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
