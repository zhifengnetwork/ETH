<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo $this->createWebUrl('admin', array('op'=>display));?>">管理员列表</a></li>
    <li ><a href="<?php  echo $this->createWebUrl('admin', array('op'=>create));?>">添加管理员</a></li>
</ul>
<div class="main">
    <div class="panel panel-primary">
        <div class="panel-heading">公众号数据监控 - 管理员列表</div>
        <div class="panel-body">
            <div class="table-responsive panel-body">
                <table class="table table-hover table-responsive" style="min-width: 300px;">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:150px;">编号</th>
                        <th style="width:200px;">姓名</th>
                        <th style="width:200px;">openID</th>
                        <th style="width:200px;">备注</th>
                        <th style="width:200px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  if(is_array($admin_all)) { foreach($admin_all as $key => $item) { ?>
                    <tr>
                        <td><?php  echo $item['admin_id'];?></td>
                        <td><?php  echo $item['admin_name'];?></td>
                        <td><?php  echo $item['admin_openid'];?></td>
                        <td><?php  echo $item['admin_remark'];?></td>
                        <td><a onclick="if(!confirm('删除后将不可恢复,确定删除吗?')) return false;" href="<?php  echo $this->createWebUrl('delete', array('admin_id'=>$item['admin_id']));?>" class="btn btn-default btn-danger">删除</a></td>
                    </tr>
                    <?php  } } ?>
                    <?php  if(!empty($admin_all)) { ?>
                    <tr>

                    </tr>
                    <?php  } else { ?>
                    <tr>
                        <td colspan="8">
                            尚未添加管理员
                        </td>
                    </tr>
                    <?php  } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>