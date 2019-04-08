<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('user/user-header', TEMPLATE_INCLUDEPATH)) : (include template('user/user-header', TEMPLATE_INCLUDEPATH));?>
<div class="keyword-list-head clearfix we7-margin-bottom">
	<form action="" method="get">
		<input type="hidden" name="c" value="user">
		<input type="hidden" name="a" value="display">
		<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
		<div class="input-group pull-left col-sm-4">
			<input type="text" name="username" id="" value="<?php  echo $_GPC['username'];?>" class="form-control" <?php  if($_GPC['do'] == ACCOUNT_MANAGE_NAME_VICE_FOUNDER) { ?> placeholder="搜索副创始人" <?php  } else { ?> placeholder="搜索用户名" <?php  } ?> />
			<span class="input-group-btn"><button class="btn btn-default"><i class="fa fa-search"></i></button></span>
		</div>
	</form>
	<div class="pull-right">
		<?php  if($_GPC['do'] == 'display' || $_GPC['do'] == '') { ?><a href="<?php  echo url('user/create');?>" class="btn btn-primary">+添加用户</a><?php  } ?>
		<?php  if($_GPC['do'] == ACCOUNT_MANAGE_NAME_VICE_FOUNDER) { ?><a href="<?php  echo url('user/create/vice_founder');?>" class="btn btn-primary">+添加副创始人</a><?php  } ?>
	</div>
</div>
<table class="table we7-table table-hover table-manage vertical-middle" id="js-users-display" ng-controller="UsersDisplay" ng-cloak>
	<col width="120px"/>
	<col width="150px">
	<?php  if($do != 'vice_founder') { ?>
	<col width="200px"/>
	<?php  } ?>
	<col width="120px"/>
	<col width="120px"/>
	<col width="100px"/>
	<col width="120px"/>
	<col width="150px"/>
	<tr>
		<th></th>
		<th class="text-left">用户名</th>
		<?php  if($do != 'vice_founder') { ?>
		<th>用户权限组</th>
		<?php  } ?>
		<th>创建公众号</th>
		<th>使用公众号</th>
		<th>应用</th>
		<th>到期时间</th>
		<th class="text-right">操作</th>
	</tr>
	<tr ng-repeat="user in users" ng-if="users">
		<td><img src="{{user.avatar}}" alt="" class="img-responsive icon"/></td>
		<td class="text-left" ng-bind="user.username"><?php  echo $user['username'];?></td>
		<?php  if($do != 'vice_founder') { ?>
		<td>
			<span class="color-default" ng-if="user.founder">管理员</span>
			<span class="color-default" ng-if="user.groupname && !user.founder" ng-bind="user.groupname"></span>
			<span class="color-default" ng-if="!user.groupname && !user.founder">未分配</span>
		</td>
		<?php  } ?>
		<td class="color-default" ng-bind="user.maxaccount"></td>
		<td class="color-default" ng-bind="user.uniacid_num"></td>
		<td class="color-default">
			<span ng-if="!user.founder" ng-bind="user.module_nums"></span>
			<span ng-if="user.founder">全部</span>
		</td>
		<td>
			<span ng-bind="user.endtime"></span>
		</td>
		<td>
			<?php  if($do != 'vice_founder') { ?>
			<div class="link-group" ng-if="!user.founder">
				<a ng-href="{{links.edit}}uid={{user.uid}}" ng-if="do == 'display'">编辑</a>
				<a ng-href="{{links.deny}}uid={{user.uid}}" ng-if="do == 'display'" data-toggle="tooltip" data-placement="left" title="禁用后可在用户回收站查找到并重新启用。">禁用</a>
				<a ng-href="{{links.checkPass}}uid={{user.uid}}" ng-if="do == 'check_display'">通过</a>
				<a ng-href="{{links.deny}}uid={{user.uid}}" ng-if="do == 'check_display'" data-toggle="tooltip" data-placement="left" title="拒绝后可在用户回收站查找到并启用。">拒绝</a>
				<a ng-href="{{links.recycleRestore}}uid={{user.uid}}" ng-if="do == 'recycle_display'">启用</a>
				<a ng-href="{{links.recycleDel}}uid={{user.uid}}" class="del" ng-if="do == 'recycle_display'">删除</a>
			</div>
			<?php  } else { ?>
			<div class="link-group" ng-if="user.founder">
				<a ng-href="{{links.edit}}uid={{user.uid}}" ng-if="do == 'vice_founder'">编辑</a>
				<a ng-href="{{links.recycleDel}}uid={{user.uid}}" class="del" ng-if="do == 'vice_founder'">删除</a>
			</div>
			<?php  } ?>
		</td>
	</tr>
	<tr ng-if="!users">
		<td colspan="7" class="text-center">暂无数据</td>
	</tr>
</table>
<div class="text-right">
	<?php  echo $pager;?>
</div>
<script type="text/javascript">
	$(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
	angular.module('userManageApp').value('config', {
		do: "<?php echo !empty($_GPC['do']) ? $_GPC['do'] : 'display'?>",
		users: <?php echo !empty($users) ? json_encode($users) : 'null'?>,
		usergroups: <?php echo !empty($usergroups) ? json_encode($usergroups) : 'null'?>,
		links: {
			recycleDel: "<?php  echo url('user/display/recycle_delete')?>",
			recycleRestore: "<?php  echo url('user/display/recycle_restore')?>",
			checkPass: "<?php  echo url('user/display/check_pass')?>",
			deny: "<?php  echo url('user/display/recycle')?>",
			edit: "<?php  echo url('user/edit')?>",
		},
	});
	angular.bootstrap($('#js-users-display'), ['userManageApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
