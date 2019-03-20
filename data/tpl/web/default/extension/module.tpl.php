<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">
	应用管理
</div>
<ul class="we7-page-tab">
	<li <?php  if($do == 'installed') { ?>class="active"<?php  } ?>><a href="<?php  echo url('module/manage-system/installed')?>">已安装公众号应用  </a></li>
	<?php  if($_W['isfounder']) { ?>
	<li <?php  if($do == 'not_installed' && $_GPC['status'] != 'recycle') { ?>class="active"<?php  } ?>><a href="<?php  echo url('module/manage-system/not_installed')?>">未安装公众号应用</a></li>
	<li <?php  if($do == 'not_installed' && $_GPC['status'] != 'recycle') { ?>class="active"<?php  } ?>><a href="<?php  echo url('extension&a=module&do=prepared&')?>">一键安装公众号应用</a></li>
	<li <?php  if($do == 'not_installed' && $_GPC['status'] == 'recycle') { ?>class="active"<?php  } ?>><a href="<?php  echo url('module/manage-system/not_installed', array('status' => 'recycle'))?>">已停用公众号应用</a></li>
	<li <?php  if($do == 'subscribe') { ?>class="active"<?php  } ?>><a href="<?php  echo url('module/manage-system/subscribe')?>">订阅管理</a></li>
	<?php  } ?>
    </ul>
<div>
    <div>
        <div>
            <div>
                </div>
                    </div>
                    <table class="table we7-table table-hover vertical-middle table-manage">
		            <tr>
			        <th colspan="2" class="text-left">公众号应用名</th>
			        <th class="text-right">操作</th>
		            </tr>
		            <tr ng-repeat="module in module_list">
			        <td class="text-left module-img">
				    </div>
			        </td>		
		         </tr>
	        </table>
	    </form>
	</div>
</div>
<script type="text/javascript">
	require(['domReady'], function(dom){
		dom(function(){
			$('.module').delegate('.media-description-button', 'click', function(){ //控制模块详细信息
				$(this).parents('.item').find('.media-description').toggle();
				return false;
			});
		});
	});
</script>
<style type="text/css">
	small a{color:#999;}
	.form h4{margin-bottom:0;}
	#upgradelog {line-height: 25px;max-height:150px;overflow: auto;padding: 15px;}
	/*模块列表样式*/
	.module .item{border-bottom:1px #DDD dotted;margin-bottom:10px; padding-bottom:5px;}
	.module .media .pull-right{margin-bottom:0;width:140px;overflow:hidden;}
	.module .media .pull-right .input-prepend{float:right;}
	.module .media .pull-right .input-prepend .add-on{padding:0 5px; height:23px; line-height:23px;}
	.module .media .pull-right .input-prepend select{padding:1px; height:25px; line-height:25px;}
	.module .module-set{text-align:right; margin-top:6px;float:right;height:25px}
	.module .module-set a{margin-left:5px;}
	.module .media-body{position:relative;}
	.module .media-body .edit-info{margin-left:10px; color:rgb(255, 143, 0); display:none;}
	.module .media-body span{margin-top:6px; display:inline-block;}
	.module .media-object{display:inline-block; float:left; margin-right:10px; width:48px; height:48px; overflow:hidden;}
	.module .media-heading{font-weight:normal; font-size:16px;}
	.module .media-description{display:none; margin-top:5px; overflow:hidden; background:#EEE; padding:5px; color:#666;}
	.module div.alert{font-size:14px; font-weight:600; margin-bottom:10px;}
	.module-upgrade-info {display: none;}
	.module-upgrade-info img {width: 100%;}
</style>
<div class="clearfix">
<?php  if($do == 'installed') { ?><?php  } ?>
<?php  if($do == 'prepared') { ?>
<div ng-controller="listInstallModules">
<div class="module form-horizontal ng-cloak">
<div class="item" ng-repeat="m in modules">
	<div class="media">
	<div class="pull-right" style="width:230px;">
	<div class="module-set">
</div>
</div>
	</div>
		</div>
			<div class="media-description">
			</span>
			</div>
		</div>
	</div>
</div>
<?php  if($localUninstallModules) { ?>
<div class="form">
</div>
<div class="alert alert-info form-horizontal" style="display:none" id="install-info">
<dl class="dl-horizontal">
	<dt>整体进度</dt>
	<dd id="pragress"></dd>
	<dt>正在安装的模块</dt>
	<dd id="m_name"></dd>
</dl>
<dl class="dl-horizontal" style="display:none">
	<dt>安装失败的模块</dt>
<dd>
	<p class="text-danger" id="fail" style="margin:0;"></p>
</dd>
</dl>
</div>
<div class="module form-horizontal">
<?php  if(is_array($localUninstallModules)) { foreach($localUninstallModules as $row) { ?>
<div class="item" module-name="<?php  echo $row['name'];?>" id="module-<?php  echo $row['name'];?>">
<div class="media">
<div class="pull-right" style="width:230px;">
<div class="module-set">
<?php  if(empty($status)) { ?><?php  if($row['version_error']) { ?><?php  } else { ?><?php  } ?><?php  } else { ?><?php  } ?>
</div>
</div>
<img class="media-object img-rounded gray" src="../addons/<?php  echo strtolower($row['name']);?>/icon.jpg" onerror="this.src='../web/resource/images/nopic-small.jpg'">
<div class="media-body">
<h4 class="media-heading"><?php  echo $row['title'];?><small>（标识：<?php  echo $row['name'];?>&nbsp;&nbsp;&nbsp;版本：<?php  echo $row['version'];?>&nbsp;&nbsp;&nbsp;作者：<?php  echo $row['author'];?>）</small></h4>
<span><?php  echo $row['ability'];?>&nbsp;</span >
</div>
</div>
<div class="media-description">
<span>
<?php  echo $row['description'];?>
</span>
</div>
</div>
<?php  } } ?>
<?php  if(empty($status)) { ?>
<div>
<span class="btn btn-primary" id="batch-install">一键安装所有本地模块</span>
</div>
<?php  } ?>
</div>
<?php  } else { ?>
<div class="form">
<?php  if(empty($status)) { ?><?php  } else { ?><?php  } ?>
</div>
<?php  } ?>
<script type="text/javascript">
		require(['angular'], function(angular){
			angular.module('app', []).controller('listInstallModules', function($scope, $http) {
				$.post('<?php  echo url('extension/module/check');?>', {foo: 'install'},function(dat){
					try {
						var ret = $.parseJSON(dat);
						var recycle_modules = new Array();
						var i = 0
						<?php  if(is_array($recycle_modules)) { foreach($recycle_modules as $m) { ?>
						recycle_modules.push('<?php  echo $m;?>');
						i++;
						<?php  } } ?>
						if(!$.isArray(ret)) {
							return;
						}

						$.each(ret, function(){
							$('div.item[module-name=' + this.name + ']').remove();
							<?php  if(!$status) { ?>
							if (recycle_modules.indexOf(this.name) > -1) {
							<?php  } else { ?>
								if (recycle_modules.indexOf(this.name) < 0) {
							<?php  } ?>
								var index =ret.indexOf(this);
								delete (ret[index]);
							}
						});
						var res = new Array();
						var i = 0;
						for (var re = new Array() in ret) {
							res[i] = ret[re];
							i++;
						}
						ret = res;
						if (ret.length > 0) {
							$('#no_module').hide();
						}
						$scope.$apply(function(){
							$scope.modules = ret;
						});
					} catch(err) {}
				});
			});
			angular.bootstrap(document, ['app']);
			//处理批量安装模块
			var module = <?php  echo $prepare_module;?>;
			var module_title = <?php  echo $prepare_module_title;?>;
			var total = module.length;

			var i = 1;
			var fail = [];
			var success = [];

			var insta = function(){
				var m_name = module.pop();
				if(!m_name) {
					util.message('本次成功安装' + success.length + '个模块.<br>安装失败' + fail.length + '个模块', "<?php  echo url('module&a=manage-system&account_type=1')?>", 'info');
					return;
				}
				var pragress = i + '/' + total;
				$('#m_name').html(module_title[m_name]);
				$('#pragress').html(pragress);

				$.post("<?php  echo url('extension/module/batch-install')?>", {'m_name' : m_name}, function(data){
					if(data == 'success') {
						i++;
						$('#module-' + m_name).slideUp();
						success.push(module_title[m_name]);
						setTimeout(function(){insta()}, 2000);
					} else {
						i++;
						fail.push(module_title[m_name]);
						$('#fail').html(fail.join('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')).parent().parent().show();
						setTimeout(function(){insta()}, 2000);
					}
				});
			}

			$('#batch-install').click(function(){
				if(!confirm('批量安装仅安装本地模块,不能安装行业模块,确定安装？')) {
					return false;
				}
				$('#install-info').show();
				insta();
			});
		});
</script>
<?php  } ?>
<?php  if($do == 'recycle') { ?>
</span>
</div>
</div>
</div>
<?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
