<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .border_bg{ border: 1px #ccc solid;border-radius: 4px; margin-bottom: 10px; background-color: #fff;}
    .border_bg .panel-heading{ background-color: #e8ecef; color: #000; }
</style>
<?php  if($do != 'module') { ?>
<ul class="nav nav-tabs">
	<?php  if($do == 'styles') { ?><li class="active"><a href="<?php  echo url('site/style/styles');?>">风格管理</a></li><?php  } ?>
	<?php  if($do == 'template') { ?><li class="active"><a href="<?php  echo url('site/style/template');?>">模板管理</a></li><?php  } ?>
	<?php  if($do == 'designer') { ?><li class="active"><a href="<?php  echo url('site/style/designer', array('styleid' => $_GPC['styleid']))?>">设计风格</a></li><?php  } ?>
</ul>
<?php  } ?>
<?php  if($do == 'module') { ?>
<div class="panel panel-default">
	<div class="panel-heading">覆盖模块模板HTML或是内容时，需要在当前风格目录即“app/themes/<?php  echo $currentTemplate;?>”下，新建同名模板，即可修改此模块模板内容。</div>
	<div class="table-responsive">
		<table class="table">
			<thead>
			<tr><th style="width:40%">源文件</th>
				<th style="width:40%">覆盖文件</th>
				<th style="width:20%"></th>
			</tr>
			</thead>
			<?php  if(is_array($templates)) { foreach($templates as $name => $item) { ?>
			<tr class="active"><td colspan='3'><?php  echo $modules[$name]['title'];?></td></tr>
			<?php  if(is_array($item)) { foreach($item as $file) { ?>
			<?php  $targetfile = 'app/themes/' . $currentTemplate . '/' .$name.'/'.$file;?>
			<tr>
				<td>/addons/<?php  echo $name;?>/template/mobile/<?php  echo $file;?></td>
				<td style="<?php  if(file_exists(IA_ROOT . '/' .$targetfile)) { ?>color:green<?php  } else { ?>color:red<?php  } ?>" ><?php  echo $targetfile;?></td>
				<td><a href="javascript:;" onclick="createtemplate('<?php  echo $name;?>', '<?php  echo $file;?>')">生成重定义模板</a></td>
			</tr>
			<?php  } } ?>
			<?php  } } ?>
		</table>
	</div>
</div>
<script type="text/javascript">
	function createtemplate(name, file) {
		if (file && confirm('此操作辅助生成您需要重定义的模板空文件，你也可以在文件目录中手动添加或是修改些文件，是否确定要生成吗？')) {
			$.post("<?php  echo url('site/style/createtemplate');?>" + 'name=' + name + '&file=' + file).success(function(){
				location.reload();
			});
		}
	}
</script>
<?php  } ?>
<?php  if($do == 'designer') { ?>
	<div class="clearfix">
		<form id="form" class="form-horizontal form" action="" method="post">
			<input type="hidden" name="styleid" value="<?php  echo $styleid;?>">
			<div class="panel panel-default" style="background-color: transparent; border: none;">
				<div class="border_bg">
					<div class="panel-heading">微站风格</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">风格名称</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="name" value="<?php  echo $style['name'];?>">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">模板路径</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control" disabled value="./app/themes/<?php  echo $template['name'];?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">基础图片目录[imgdir]</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="style[imgdir]" value="<?php  echo $styles['imgdir']['content'];?>" />
									<span class="help-block">风格基础图片存放的目录，如果为空则默认为./app/themes/<?php  echo $template['name'];?>/images目录</span>
								</div>
							</div>
						
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">正常字体[fontfamily]</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="style[fontfamily]" value="<?php  echo $styles['fontfamily']['content'];?>" />
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">正常字体大小[fontsize]</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="style[fontsize]" value="<?php  echo $styles['fontsize']['content'];?>" />
									<span class="help-block"></span>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">普通文本颜色[fontcolor]</label>
								<div class="col-sm-9 col-xs-12">
									<?php  echo tpl_form_field_color('style[fontcolor]', $styles['fontcolor']['content'])?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">菜单文本颜色[fontnavcolor]</label>
								<div class="col-sm-9 col-xs-12">
									<?php  echo tpl_form_field_color('style[fontnavcolor]', $styles['fontnavcolor']['content'])?>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">链接文字颜色[linkcolor]</label>
								<div class="col-sm-9 col-xs-12">
									<?php  echo tpl_form_field_color('style[linkcolor]', $styles['linkcolor']['content'])?>
								</div>							</div>
						</div>						<div class="form-group">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">首页背景 [indexbgcolor] [indexbgextra] [indexbgimg]</label>
								<div class="col-sm-9 col-xs-12">
									<?php  echo tpl_form_field_color('style[indexbgcolor]', $styles['indexbgcolor']['content'])?>
									<span class="help-block">背景颜色 [indexbgcolor]</span>
									<input class="form-control" type="text" name="style[indexbgextra]" value="<?php  echo $styles['indexbgextra']['content'];?>" placeholder="">
									<span class="help-block">附加属性 [indexbgextra]</span>
									<?php  echo tpl_form_field_image('style[indexbgimg]', $styles['indexbgimg']['content'])?>
									<span class="help-block">背景图 [indexbgimg]</span>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">		
								<label class="col-xs-12 col-sm-3 col-md-3 control-label">扩展CSS</label>		
								<div class="col-sm-9 col-xs-12">		
									<textarea name="style[css]" class="form-control" cols="120" rows="16"><?php  echo $styles['css']['content'];?></textarea>		
									<span class="help-block">附加一些CSS样式</span>		
								</div>		
							</div>						</div>
					</div>				</div>
			</div>
			<div class="panel panel-default" style="background-color: transparent; border: none;">				<div class="border_bg">
					<div class="panel-heading">自定义属性</div>
					<div class="panel-body">	
						<div class="alert alert-danger">	
							(说明：变量名用于设置不同的变量,只能是字母数字组成.变量描述可方便用户识别对应变量的作用,不能为空)<br>	
							(注意：这里定义的变量,变量值不能为空,否则将视为无效)	
						</div>	
						<div id="customForm">	
							<?php  if(is_array($styles)) { foreach($styles as $style) { ?>	
							<?php  if(!in_array($style['variable'], $systemtags)) { ?>	
								<div class="form-group">	
									<div class="col-sm-10">	
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">	
											<div class="input-group" style="margin-left:-15px;margin-bottom:10px">	
												<span class="input-group-addon">变量名</span>	
												<input class="form-control" name="custom[name][]" value="<?php  echo $style['variable'];?>" type="text" placeholder="请输入配置变量">	
											</div>	
										</div>	
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">	
											<div class="input-group" style="margin-left:-15px;margin-bottom:10px">	
												<span class="input-group-addon">变量描述</span>	
												<input class="form-control" name="custom[desc][]" value="<?php  echo $style['description'];?>" type="text" placeholder="请输入变量描述">	
											</div>	
										</div>	
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">	
											<div class="input-group" style="margin-left:-15px;margin-bottom:10px">	
												<span class="input-group-addon">值</span>	
												<input class="form-control" name="custom[value][]" value="<?php  echo $style['content'];?>" type="text" placeholder="请输入配置值">	
											</div>	
										</div>	
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-1">	
											<label class="checkbox-inline">	
												<a href="javascript:;" onclick="deleteOption(this)" class="fa fa-times-circle" title="删除此操作"></a>	
											</label>	
										</div>	
									</div>	
								</div>	
							<?php  } ?>	
							<?php  } } ?>	
						</div>	
						<a href="javascript:;" onclick="addFormItem()"><i class="fa fa-plus-square"></i> 添加新变量</a>	
					</div>				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
						<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
						<input type="submit" class="btn btn-primary col-lg-1" name="submit" id="submit" value="提交" />
				</div>
			</div>
		</form>
	</div>
	<script type="text/html" id="item-form-html">
		<div class="form-group">
			<div class="col-sm-10">
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
					<div class="input-group" style="margin-left:-15px;margin-bottom:10px">
						<span class="input-group-addon">变量名</span>
						<input class="form-control" name="custom[name][]" type="text" placeholder="请输入配置变量">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
					<div class="input-group" style="margin-left:-15px;margin-bottom:10px">
						<span class="input-group-addon">变量描述</span>
						<input class="form-control" name="custom[desc][]" type="text" placeholder="请输入变量描述">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<div class="input-group" style="margin-left:-15px;margin-bottom:10px">
						<span class="input-group-addon">值</span>
						<input class="form-control" name="custom[value][]" type="text" placeholder="请输入配置值">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-1">
					<label class="checkbox-inline">
						<a href="javascript:;" onclick="deleteOption(this)" class="fa fa-times-circle" title="删除此操作" style="font-size: 20px;"></a>
					</label>
				</div>
			</div>
		</div>
	</script>
	<script type="text/javascript">
		function addFormItem() {
			$('#customForm').append($('#item-form-html').html());
		}
		function deleteOption(o) {
			$(o).parent().parent().parent().parent().remove();
		}

	</script>
<?php  } ?>

<?php  if($do == 'template') { ?>
<style>
.template .item{position:relative;display:block;float:left;border:1px #ddd solid;border-radius:5px;background-color:#fff;padding:5px;width:190px;margin:0 20px 20px 0; overflow:hidden;}
.template .title{margin:5px auto;line-height:2em;}
.template .title a{text-decoration:none;}
.template .item img{width:178px;height:270px; cursor:pointer;}
.template .active.item-style img, .template .item-style:hover img{width:178px;height:270px;border:3px #009cd6 solid;padding:1px; }
.template .title .fa{display:none}
.template .active .fa.fa-check{display:inline-block;position:absolute;bottom:33px;right:6px;color:#FFF;background:#009CD6;padding:5px;font-size:14px;border-radius:0 0 6px 0;}
.template .fa.fa-times{cursor:pointer;display:inline-block;position:absolute;top:10px;right:6px;color:#D9534F;background:#ffffff;padding:5px;font-size:14px;text-decoration:none;}
.template .fa.fa-times:hover{color:red;}
.template .item-bg{width:100%; height:342px; background:#000; position:absolute; z-index:1; opacity:0.5; margin:-5px 0 0 -5px;}
.template .item-build-div1{position:absolute; z-index:2; margin:-5px 10px 0 5px; width:168px;}
.template .item-build-div2{text-align:center; line-height:30px; padding-top:150px;}
</style>
<div class="clearfix template">
	<div class="panel panel-default">
		<nav role="navigation" class="navbar navbar-default navbar-static-top" style="margin-bottom:0;">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="javascript:;" class="navbar-brand">微站风格类型</a>
				</div>
				<ul class="nav navbar-nav nav-btns">
					<li <?php  if(empty($_GPC['type']) || $_GPC['type'] == 'all') { ?> class="active" <?php  } ?>>
						<a href="<?php  echo url('site/style/template', array('type' => 'all'));?>">全部</a>
					</li>
					<?php  if(is_array($temtypes)) { foreach($temtypes as $type) { ?>
						<li <?php  if($_GPC['type'] == $type['name']) { ?> class="active" <?php  } ?>>
							<a href="<?php  echo url('site/style/template', array('type' => $type['name']));?>"><?php  echo $type['title'];?></a>
						</li>
					<?php  } } ?>
				</ul>
			</div>
		</nav>
		<div class="panel-body">
			<?php  if(is_array($stylesResult)) { foreach($stylesResult as $item) { ?>
				<?php  if(!empty($item['styleid'])) { ?>
					<div class="item item-style<?php  if($setting['styleid'] == $item['styleid']) { ?> active<?php  } ?>">
						<a class="fa fa-times"  onclick="if(!confirm('删除后将不可恢复,确定删除吗?')) return false;" title="删除风格" href="<?php  echo url('site/style/del', array('styleid' => $item['styleid']))?>"></a>
						<div class="title">
							<div style="overflow:hidden; height:28px;"><?php  echo $item['title'];?> (<?php  echo $item['name'];?>)</div>
							<a href="<?php  echo url('site/style/default', array('styleid' => $item['styleid']))?>">
								<img src="../app/themes/<?php  echo $item['name'];?>/preview.jpg" class="img-rounded" />
							</a>
							<span class="fa fa-check"></span>
						</div>
						<div class="btn-group  btn-group-justified">
							<a href="<?php  echo url('site/style/designer', array('styleid' => $item['styleid']))?>" class="btn btn-default btn-xs">设计风格</a>
							<a href="<?php  echo url('site/style/copy', array('styleid' => $item['styleid']))?>" class="btn btn-default btn-xs">复制风格</a>
							<a href="javascript:;" onclick="preview('<?php  echo $item['styleid'];?>');return false;" class="btn btn-default btn-xs">预览</a>
						</div>
					</div>
				<?php  } else { ?>
					<div class="item" style="border-color:#FFF;">
						<div class="item-bg"></div>
						<div class="item-build-div1">
							<div class="item-build-div2">
								<a href="<?php  echo url('site/style/build', array('templateid' => $item['templateid']))?>" class="btn btn-warning item-build-btn" role="button" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="该模板尚未激活，激活后可正常使用！">点击激活</a>
							</div>
						</div>
						<div class="title">
							<div style="overflow:hidden; height:28px;"><?php  echo $item['title'];?></div>
							<img src="../app/themes/<?php  echo $item['name'];?>/preview.jpg" class="img-rounded" />
						</div>
						<div class="btn-group  btn-group-justified">
							<a href="#" class="btn btn-default btn-xs">设计风格</a>
							<a href="#" class="btn btn-default btn-xs">复制风格</a>
							<a href="#" class="btn btn-default btn-xs">预览</a>
						</div>
					</div>
				<?php  } ?>
			<?php  } } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	require(['bootstrap'],function($){
		$('.item .item-build-btn').popover();
	});
	//预览风格时,预览的是默认微站的导航链接和快捷操作
	function preview(styleid) {
		var content = '<iframe width="320" scrolling="yes" height="480" frameborder="0" src="about:blank"></iframe>';
		var footer =
				'			<a href="<?php  echo url('site/style/default');?>styleid=' + styleid + '" class="btn btn-primary">设为默认模板</a>' +
				'			<a href="<?php  echo url('site/style/designer');?>styleid=' + styleid + '" class="btn btn-primary">设计风格</a>' +
				'			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>';
		var dialog = util.dialog('预览模板', content, footer);
		dialog.find('iframe').on('load', function(){
			$('a', this.contentWindow.document.body).each(function(){
				var href = $(this).attr('href');
				if(href && href[0] != '#') {
					var arr = href.split(/#/g);
					var url = arr[0];
					if(url.slice(-1) != '&') {
						url += '&';
					}
					if(url.indexOf('?') != -1) {
						url += ('s=' + styleid);
					}
					if(arr[1]) {
						url += ('#' + arr[1]);
					}
					if (url.substr(0, 10) == 'javascript' || url.indexOf('?') == -1) {
						url = url.substr(0, url.lastIndexOf('&'));
					}
					$(this).attr('href', url);
				}
			});
		});
		var url = '<?php  echo murl('home', array(), true, true)?>&s=' + styleid;
		dialog.find('iframe').attr('src', url);
		dialog.find('.modal-dialog').css({'width': '322px'});
		dialog.find('.modal-body').css({'padding': '0', 'height': '480px'});
		dialog.modal('show');
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
