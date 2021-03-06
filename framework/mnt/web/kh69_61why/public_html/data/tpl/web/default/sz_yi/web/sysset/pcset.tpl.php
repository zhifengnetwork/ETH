<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="ulleft-nav">
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo $this->createWebUrl('sysset',array('op'=>'shop'))?>">PC商城设置</a></li>
</ul> 
</div>

<link href="../addons/sz_yi/plugin/article/template/imgsrc/article.css" rel="stylesheet">
<style type="text/css">
    .setmenu .form-group{margin-bottom: 0;}
    .border_bg{ border: 1px #ccc solid;border-radius: 4px; margin-bottom: 10px; background-color: #fff; }
    .border_bg .panel-heading{ background-color: #e8ecef; color: #000; }
</style>
<div class="main rightlist">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
        <input type='hidden' name='setid' value="<?php  echo $set['id'];?>" />
        <input type='hidden' name='op' value="pcset" />
        <div class="panel panel-default" style="background-color: transparent; border: none;">
        	<div class="border_bg">
        		<div class='panel-heading'>基本设置</div>
        		<div class='panel-body'>
	                <div class="form-group">
	                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">PC版开关</label>
		                    <div class="col-sm-9 col-xs-12">
		                        <label class='radio-inline'><input type='radio' name='pcset[ispc]' value='1' <?php  if($set['shop']['ispc']==1) { ?>checked<?php  } ?>/> 开启</label>
		                        <label class='radio-inline'><input type='radio' name='pcset[ispc]' value='0' <?php  if($set['shop']['ispc']==0) { ?>checked<?php  } ?> /> 关闭</label>
		                    </div>
	                	</div>
	                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片</label>
		                    <div class="col-sm-9 col-xs-12">
		                        <div class="">
		                        	<a href="<?php  echo $this->createWebUrl('shop/adv')?>" style=" display: inline-block; padding: 5px 14px; background-color: #1d95c9; color: #fff;margin-bottom: 20px;">设置</a>
		                        	PC幻灯片是与手机端同步的，<span style="color: red;">但需单独上传PC幻灯图。</span>
		                        	
		                        </div>
		                    </div>
		                </div>
	                </div>
	                <div class="form-group">
	                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商城LOGO</label>
		                    <div class="col-sm-9 col-xs-12">
		                        <?php if(cv('sysset.save.shop')) { ?>
		                        <?php  echo tpl_form_field_image('pcset[pclogo]', $set['shop']['pclogo'])?>
		                        <span class='help-block'>长方型图片,建议270*60</span>
		                        <?php  } else { ?>
		                        <input type="hidden" name="pcset[pclogo]" value="<?php  echo $set['shop']['pclogo'];?>"/>
		                        <?php  if(!empty($set['shop']['pclogo'])) { ?>
		                        <a href='<?php  echo tomedia($set['shop']['pclogo'])?>' target='_blank'>
		                           <img src="<?php  echo tomedia($set['shop']['pclogo'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
		                        </a>
		                        <?php  } ?>
		                        <?php  } ?>
		                    </div>
		                </div>
	                </div>
	            </div>
        	</div>
            
            <div class="border_bg">
	            <div class='panel-heading'>SEO优化</div>
	            <div class='panel-body'>
	                <div class="form-group">
	                	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		                    <label class="col-xs-12 col-sm-3 col-md-3 control-label">商城标题</label>
		                    <div class="col-sm-9 col-xs-12">
		                        <input class="form-control" type="text" value="<?php  echo $set['shop']['pctitle'];?>" name="pcset[pctitle]">
		                        <span class="help-block">搜索引擎优化商城标题</span>
		                    </div>
	                	</div>
	                	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		                    <label class="col-xs-12 col-sm-3 col-md-3 control-label">SEO关键字</label>
		                    <div class="col-sm-9 col-xs-12">
		                        <input class="form-control" type="text" value="<?php  echo $set['shop']['pckeywords'];?>" name="pcset[pckeywords]">
		                        <span class="help-block">搜索引擎优化商城关键字</span>
		                    </div>
		                </div>
	                	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		                    <label class="col-xs-12 col-sm-3 col-md-3 control-label">SEO描述</label>
		                    <div class="col-sm-9 col-xs-12">
		                        <textarea class="form-control" cols="60" name="pcset[pcdesc]" style="height:100px;"><?php  echo $set['shop']['pcdesc'];?></textarea>
		                        <span class="help-block">搜索引擎优化商城描述</span>
		                    </div>
		                </div>
		            </div>
	            </div>
	        </div>

	        <div class="border_bg">
            	<div class='panel-heading'>推荐码</div>
	            <div class='panel-body'>
	            	<div class='panel-heading' style="background-color: #e8f6fa;">是否启用</div>
	            	<div class='panel-body'>
		                <div class="form-group">
		                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否启用</label>
			                    <div class="col-sm-9 col-xs-12">
			                        <label class="radio-inline"><input type="radio" name="pcset[isreferral]" value="0" <?php  if($set['shop']['isreferral']==0) { ?>checked<?php  } ?> /> 禁用</label>
			                        <label class="radio-inline"><input type="radio" name="pcset[isreferral]" value="1" <?php  if($set['shop']['isreferral']==1) { ?>checked<?php  } ?> /> 启用</label>
			                    </div>
			                </div>
		                </div>
		            </div> 
	   
	                <div class='panel-heading' style="background-color: #e8f6fa;">奖励设置</div>
	                <div class='panel-body'>
		                <div class="form-group">
		                 	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐人获得</label>
			                     <div class="col-sm-9 col-xs-12">
			                        <div class="input-group">
			                            <input type="text" name="pcset[reccredit]" class="form-control" value="<?php  echo $set['shop']['reccredit'];?>" />
			                            <div class="input-group-addon">积分</div>
			                            <input type="text" name="pcset[recmoney]" class="form-control" value="<?php  echo $set['shop']['recmoney'];?>" />
			                            <div class="input-group-addon">元现金</div>
			                        </div>
			                    </div>
			                </div>
		                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">使用者获得</label>
			                     <div class="col-sm-9 col-xs-12">
			                        <div class="input-group">
			                            <input type="text" name="pcset[subcredit]" class="form-control" value="<?php  echo $set['shop']['subcredit'];?>" />
			                            <div class="input-group-addon">积分</div>
			                            <input type="text" name="pcset[submoney]" class="form-control" value="<?php  echo $set['shop']['submoney'];?>" />
			                            <div class="input-group-addon">元现金</div>
			                        </div>
			                    </div>
			                </div>
		                </div>
		                <div class="form-group">
		                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">奖励现金方式</label>
			                    <div class="col-sm-9 col-xs-12">
			                        <label class="radio-inline"><input type="radio" name="pcset[paytype]" value="0" <?php  if(empty($set['shop']['paytype'])) { ?>checked<?php  } ?> /> 余额</label>
			                        <label class="radio-inline"><input type="radio" name="pcset[paytype]" value="1" <?php  if($set['shop']['paytype']==1) { ?>checked<?php  } ?> /> 微信钱包</label>
			                        <span class='help-block'>如果奖励现金，是打到零钱包还是余额<i style="color: red;font-style: normal;">( 打到零钱包需要微信支付，并在后台上传证书 )</i></span>
			                    </div>
			                </div>
		                </div>
		            </div>

	            	<div class="panel-heading" style="background-color: #e8f6fa;">通知设置</div>
	            	<div class='panel-body'>
		            	<div class="form-group">
		                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">通知模板消息ID（任务处理通知）</label>
			                    <div class="col-sm-9 col-xs-12">
			                       <input type="text" name="pcset[templateid]" class="form-control" value="<?php  echo $set['shop']['templateid'];?>" />
			                       <span class="help-block">公众平台模板消息ID:  OPENTM200605630，如果不填写，则使用客服消息发送通知</span>
			                    </div>
			            	</div> 
		            		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐者通知</label>
			                    <div class="col-sm-9 col-xs-12"> 
			                       <input type="text" name="pcset[subtext]" class="form-control" value="<?php  echo $set['shop']['subtext'];?>" />
			                       <span class="help-block">例如：[nickname] 通过您的推荐码注册账号! 获得了 [credit] 个积分,[money]元奖励!</span>
			                       <span class="help-block">[nickname] 为使用者昵称 [credit] 奖励的积分 [money] 奖励的钱 </span>
			                    </div>
			                </div>
		            		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		                    	<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用者通知</label>
			                    <div class="col-sm-9 col-xs-12">
			                       <input type="text" name="pcset[entrytext]" class="form-control" value="<?php  echo $set['shop']['entrytext'];?>" />
			                       <span class="help-block">例如：您使用了 [nickname] 的推荐码注册账号! 获得了 [credit] 个积分,[money]元奖励!</span>
			                       <span class="help-block">[nickname] 为推荐者昵称 [credit] 奖励的积分 [money] 奖励的钱 </span>
			                    </div>
			            	</div>
		                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">使用者现金奖励入账描述</label>
			                    <div class="col-sm-9 col-xs-12">
			                       <input type="text" name="pcset[subpaycontent]" class="form-control" value="<?php  echo $set['shop']['subpaycontent'];?>" />
			                       <span class="help-block">默认为：您通过 [nickname]的推荐码注册账号的奖励</span>
			                       <span class="help-block">[nickname]为推荐者昵称</span>
			                    </div>
			                </div>
		                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐者现金奖励入账描述</label>
			                    <div class="col-sm-9 col-xs-12">
			                       <input type="text" name="pcset[recpaycontent]" class="form-control" value="<?php  echo $set['shop']['recpaycontent'];?>" />
			                       <span class="help-block">默认为：推荐 [nickname] 使用推荐码注册账号的奖励</span>
			                       <span class="help-block">[nickname]为使用者昵称</span>
			                    </div>
			                </div>
		                </div>
		            </div>

		        	<div class='panel-heading' style="background-color: #e8f6fa;">LOGO添加</div>
		            <div class='panel-body'>
		                <div class="form-group">
		                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐码LOGO</label>
			                    <div class="col-sm-9 col-xs-12">
				            		<?php if(cv('sysset.save.shop')) { ?>
				                        <?php  echo tpl_form_field_image('pcset[referrallogo]', $set['shop']['referrallogo'])?>
				                        <span class='help-block'>960*258</span>
				            		<?php  } else { ?>
				                        <input type="hidden" name="pcset[referrallogo]" value="<?php  echo $set['shop']['referrallogo'];?>"/>
				                        <?php  if(!empty($set['shop']['referrallogo'])) { ?>
				                        <a href='<?php  echo tomedia($set['shop']['referrallogo'])?>' target='_blank'>
				                           <img src="<?php  echo tomedia($set['shop']['referrallogo'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
				                        </a>
				                        <?php  } ?>
				            		<?php  } ?>
			                    </div>
			                </div>
		                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">登陆注册LOGO</label>
			                    <div class="col-sm-9 col-xs-12">
									<?php if(cv('sysset.save.shop')) { ?>
			                        	<?php  echo tpl_form_field_image('pcset[reglogo]', $set['shop']['reglogo'])?>
			                        	<span class='help-block'>335*230</span>
			                        <?php  } else { ?>
			                        	<input type="hidden" name="pcset[reglogo]" value="<?php  echo $set['shop']['reglogo'];?>"/>
				                        <?php  if(!empty($set['shop']['reglogo'])) { ?>
					                        <a href='<?php  echo tomedia($set['shop']['reglogo'])?>' target='_blank'>
					                           <img src="<?php  echo tomedia($set['shop']['reglogo'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
					                        </a>
				                        <?php  } ?>
			                        <?php  } ?>
			                    </div>
			                </div>
			            </div>
	                </div>
	                <!--<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">注册协议</label>
	                    <div class="col-sm-9 col-xs-12">
							<div class="input-group form-group">
                                <input class="form-control" type="text" data-id="<?php  echo $set['shop']['reg_agreement'];?>" placeholder="请填写阅读原文指向的链接 (请以http://开头, 不填则不显示)" value="<?php  echo $set['shop']['reg_agreement'];?>" name="pcset[reg_agreement]">
                                <input class="form-control" type="hidden" value="<?php  echo $set['shop']['reg_agreement'];?>" name="pcset[reg_agreement]">
                                <span class="input-group-addon btn btn-default nav-link" data-id="<?php  echo $set['shop']['reg_agreement'];?>" style="background: #fff;" data-original-title="" title="">选择链接</span>
                            </div>
	                    </div>
	            	</div>-->
	            </div>
	        </div>

	    	<div class="border_bg">
            	<div class='panel-heading'>内容设置</div>
	            <div class='panel-body'>
		            <div class="form-group">
		                <label class="col-xs-12 col-sm-3 col-md-1 control-label">头部菜单</label>
		                <div class="col-sm-9">
		                    <div class="panel-body table-responsive" style="padding:0px;">
		                        <table class="table setmenu">
		                            <thead>
		                                <tr>
		                                    <th style='width:70px;'></th>
		                                    <th>名称</th>
		                                    <th>链接</th>
		                                </tr>
		                            </thead>
		                            <tbody id="param-items" class="hmenu">
		                                <?php  if(is_array($set['shop']['hmenu_name'])) { foreach($set['shop']['hmenu_name'] as $k => $v) { ?>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;" class="fa fa-move" title="拖动调整此显示顺序"><i class="fa fa-arrows"></i></a>&nbsp;
		                                        <a href="javascript:;" onclick="deleteParam(this)" style="margin-top:10px;" title="删除"><i class='fa fa-remove'></i></a>
		                                    </td>
		                                    <td>
		                                        <div class="input-group form-group">
		                                            <span class="input-group-addon" style="border-right: 0px;">名称</span>
		                                            <input class="form-control" type="text" value="<?php  echo $v;?>" name="pcset[hmenu_name][]">
		                                        </div>
		                                    </td>
		                                    <td>
		                                        <div class="input-group form-group">
		                                            <input class="form-control" type="text" data-id="<?php  echo $set['shop']['hmenu_id'][$k];?>" placeholder="请填写阅读原文指向的链接 (请以http://开头, 不填则不显示)" value="<?php  echo $set['shop']['hmenu_url'][$k];?>" name="pcset[hmenu_url][]">
		                                            <input class="form-control" type="hidden" value="<?php  echo $set['shop']['hmenu_id'][$k];?>" name="pcset[hmenu_id][]">
		                                            <span class="input-group-addon btn btn-default nav-link" data-id="<?php  echo $set['shop']['hmenu_id'][$k];?>" style="background: #fff;" data-original-title="" title="">选择链接</span>
		                                        </div>
		                                    </td>
		                                </tr>
		                                <?php  } } ?>
		                            </tbody>
		                               <?php if( ce('shop.goods' ,$item) ) { ?>
		                            <tbody>
		                                <tr>
		                                    <td>&nbsp;</td>
		                                    <td colspan="2">
		                                        <a href="javascript:;" id='add-param' onclick="addParam('hmenu')" style="margin-top:10px;" class="btn btn-default"  title="添加菜单"><i class='fa fa-plus'></i> 添加菜单</a>
		                                    </td>
		                                </tr>
		                            </tbody>
		                            <?php  } ?>
		                        </table>
		                    </div>
		                </div>
		            </div>  
		
		            <div class="form-group">
		                <label class="col-xs-12 col-sm-3 col-md-1 control-label">楼层显示</label>
		                <div class="col-sm-9 col-xs-12" >
		                      
		                    <label for="isrecommand" class="checkbox-inline">
		                        <input type="checkbox" name="pcset[index][isrecommand]" value="isrecommand" id="isrecommand" <?php  if($set['shop']['index']['isrecommand'] == 'isrecommand') { ?>checked="true"<?php  } ?> /> 推荐
		                    </label>
		                    <label for="isnew" class="checkbox-inline">
		                        <input type="checkbox" name="pcset[index][isnew]" value="isnew" id="isnew" <?php  if($set['shop']['index']['isnew'] == 'isnew') { ?>checked="true"<?php  } ?> /> 新上
		                    </label>
		                    <label for="ishot" class="checkbox-inline">
		                        <input type="checkbox" name="pcset[index][ishot]" value="ishot" id="ishot" <?php  if($set['shop']['index']['ishot'] == 'ishot') { ?>checked="true"<?php  } ?> /> 热卖
		                    </label>
		                    <label for="isdiscount" class="checkbox-inline">
		                        <input type="checkbox" name="pcset[index][isdiscount]" value="isdiscount" id="isdiscount" <?php  if($set['shop']['index']['isdiscount'] == 'isdiscount') { ?>checked="true"<?php  } ?> /> 促销
		                    </label>
		                    <label for="issendfree" class="checkbox-inline">
		                        <input type="checkbox" name="pcset[index][issendfree]" value="issendfree" id="issendfree" <?php  if($set['shop']['index']['issendfree'] == 'issendfree') { ?>checked="true"<?php  } ?> /> 包邮
		                    </label>
		                    <label for="istime" class="checkbox-inline">
		                        <input type="checkbox" name="pcset[index][istime]" value="istime" id="istime" <?php  if($set['shop']['index']['istime'] == 'istime') { ?>checked="true"<?php  } ?> /> 限时卖
		                    </label>
		
		                </div>
		            </div>
	            	<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-1 control-label">广告管理</label>
	                    <div class="col-sm-9 col-xs-12">
	                        <div class="">
	                        	<a href="<?php  echo $this->createWebUrl('shop/adv')?>" style=" display: inline-block; padding: 5px 14px; background-color: #1d95c9; color: #fff;margin-bottom: 20px;">设置</a>
	                        	楼层栏目上方可添加横幅广告。
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

	    	<div class="border_bg">
            	<div class='panel-heading'>底部设置</div>
	            <div class='panel-body'>
		            <div class="form-group">
		                <label class="col-xs-12 col-sm-3 col-md-1 control-label">底部菜单</label>
		                <div class="col-sm-9">
		                    <div class="panel-body table-responsive" style="padding:0px;">
		                        <table class="table setmenu">
		                            <thead>
		                                <tr>
		                                    <th style='width:70px;'></th>
		                                    <th>名称</th>
		                                    <th>链接</th>
		                                </tr>
		                            </thead>
		                            <tbody id="param-items" class="fmenu">
		                                <?php  if(is_array($set['shop']['fmenu_name'])) { foreach($set['shop']['fmenu_name'] as $k => $v) { ?>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;" class="fa fa-move" title="拖动调整此显示顺序"><i class="fa fa-arrows"></i></a>&nbsp;
		                                        <a href="javascript:;" onclick="deleteParam(this)" style="margin-top:10px;" title="删除"><i class='fa fa-remove'></i></a>
		                                    </td>
		                                    <td>
		                                        <div class="input-group form-group">
		                                            <span class="input-group-addon" style="border-right: 0px;">名称</span>
		                                            <input class="form-control" type="text" value="<?php  echo $v;?>" name="pcset[fmenu_name][]">
		                                        </div>
		                                    </td>
		                                    <td>
		                                        <div class="input-group form-group">
		                                            <input class="form-control" type="text" data-id="<?php  echo $set['shop']['fmenu_id'][$k];?>" placeholder="请填写阅读原文指向的链接 (请以http://开头, 不填则不显示)" value="<?php  echo $set['shop']['fmenu_url'][$k];?>" name="pcset[fmenu_url][]">
		                                            <input class="form-control" type="hidden" value="<?php  echo $set['shop']['fmenu_id'][$k];?>" name="pcset[fmenu_id][]">
		                                            <span class="input-group-addon btn btn-default nav-link" data-id="<?php  echo $set['shop']['fmenu_id'][$k];?>" style="background: #fff;" data-original-title="" title="">选择链接</span>
		                                        </div>
		                                    </td>
		                                </tr>
		                                <?php  } } ?>
		                            </tbody>
		                               <?php if( ce('shop.goods' ,$item) ) { ?>
		                            <tbody>
		                                <tr>
		                                    <td>&nbsp;</td>
		                                    <td colspan="2">
		                                        <a href="javascript:;" id='add-param' onclick="addParam('fmenu')" style="margin-top:10px;" class="btn btn-default"  title="添加菜单"><i class='fa fa-plus'></i> 添加菜单</a>
		                                    </td>
		                                </tr>
		                            </tbody>
		                            <?php  } ?>
		                        </table>
		                    </div>
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="col-xs-12 col-sm-3 col-md-1 control-label">版权信息</label>
		                <div class="col-sm-9">
		                    <div class="input-group"  style="width: 99%;float:left;margin-right:1%">
		                        <?php  echo tpl_ueditor('pcset[pccopyright]',$set['shop']['pccopyright'])?>
		                    </div>
		                </div>
		            </div>
	
	            	<div class="form-group"></div>
	            	<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
	                    <div class="col-sm-9 col-xs-12">
                        	<?php if(cv('sysset.save.shop')) { ?>
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        	<?php  } ?>
	                     </div>
	            	</div> 
	            </div>
	        </div>
        </div>     
    </form>
</div>
<!-- mylink start -->
    <div id="modal-mylink" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="width: 720px;">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px;">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active" style="display: block;"><a aria-controls="link_system" role="tab" data-toggle="tab" href="#link_system" aria-expanded="true">系统页面</a></li>
                        <li role="presentation" style="display: block;"><a aria-controls="link_goods" role="tab" data-toggle="tab" href="#link_goods" aria-expanded="false">商品链接</a></li>
                        <li role="presentation" style="display: block;"><a aria-controls="link_cate" role="tab" data-toggle="tab" href="#link_cate" aria-expanded="false">商品分类</a></li>
                        <?php  if(!empty($designer)) { ?>
                            <li role="presentation" style="display: block;"><a aria-controls="link_diy" role="tab" data-toggle="tab" href="#link_diy" aria-expanded="false">DIY页面</a></li>
                        <?php  } ?>
                        <li role="presentation" style="display: block;"><a aria-controls="link_diy" role="tab" data-toggle="tab" href="#link_article" aria-expanded="false">营销文章</a></li>
                        <li role="presentation" style="display: block;"><a aria-controls="link_other" role="tab" data-toggle="tab" href="#link_other" aria-expanded="false">自定义链接</a></li>
                    </ul>   
                </div>
                 <div class="modal-body tab-content">
                     <div role="tabpanel" class="tab-pane link_system active" id="link_system">
                         <div class="mylink-con">
                            <div class="page-header">
                                <h4><i class="fa fa-folder-open-o"></i> 商城页面</h4>
                            </div>
                            <div class="btn btn-default mylink-nav" data-href="<?php  echo $this->createMobileUrl('shop/index')?>">商城首页</div>
                            <div class="btn btn-default mylink-nav" data-href="<?php  echo $this->createMobileUrl('member')?>">个人中心</div>
                            <div class="btn btn-default mylink-nav" data-href="<?php  echo $this->createMobileUrl('plugin/commission')?>">分销中心</div>
                            <div class="btn btn-default mylink-nav" data-href="<?php  echo $this->createMobileUrl('shop/category')?>">分类页面</div>
                            <div class="btn btn-default mylink-nav" data-href="<?php  echo $this->createMobileUrl('shop/list')?>">全部商品</div>
                            <div class="btn btn-default mylink-nav" data-href="<?php  echo $this->createMobileUrl('shop/cart')?>">购物车</div>
                            <div class="btn btn-default mylink-nav" data-href="<?php  echo $this->createMobileUrl('plugin/commission',array('method'=>'myshop'))?>">我的小店</div>
                            <div class="btn btn-default mylink-nav" data-href="<?php  echo $this->createMobileUrl('order')?>">我的订单</div>
                            <div class="page-header">
                                <h4><i class="fa fa-folder-open-o"></i> 其他页面</h4>
                            </div>
                            <p style="line-height: 20px;  padding-left: 20px;">更多功能正在开发...</p>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane link_goods" id="link_goods">
                         <div class="input-group">
                             <input type="text" class="form-control" name="keyword" value="" id="select-good-kw" placeholder="请输入商品名称进行搜索 (多规格商品不支持一键下单)">
                             <span class="input-group-btn"><button type="button" class="btn btn-default" id="select-good-btn">搜索</button></span>
                         </div>
                         <div class="mylink-con" id="select-goods" style="height:266px;"></div>
                     </div>
                     <div role="tabpanel" class="tab-pane link_cate" id="link_cate">
                         <div class="mylink-con">
                             <?php  if(is_array($goodcates)) { foreach($goodcates as $goodcate) { ?>
                                <?php  if(empty($goodcate['parentid'])) { ?>
                                    <div class="mylink-line">
                                        <?php  echo $goodcate['name'];?>
                                        <div class="mylink-sub">
                                            <a href="javascript:;" class="mylink-nav" data-href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$goodcate['id']))?>">选择</a>
                                        </div>
                                    </div>
                                    <?php  if(is_array($goodcates)) { foreach($goodcates as $goodcate2) { ?>
                                        <?php  if($goodcate2['parentid']==$goodcate['id']) { ?>
                                            <div class="mylink-line">
                                                <span style='height:10px; width: 10px; margin-left: 10px; margin-right: 10px; display:inline-block; border-bottom: 1px dashed #ddd; border-left: 1px dashed #ddd;'></span>
                                                <?php  echo $goodcate2['name'];?>
                                                <div class="mylink-sub">
                                                    <a href="javascript:;" class="mylink-nav" data-href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$goodcate['id'],'ccate'=>$goodcate2['id']))?>">选择</a>
                                                </div>
                                            </div>
                                            <?php  if(is_array($goodcates)) { foreach($goodcates as $goodcate3) { ?>
                                                <?php  if($goodcate3['parentid']==$goodcate2['id']) { ?>
                                                    <div class="mylink-line">
                                                        <span style='height:10px; width: 10px; margin-left: 30px; margin-right: 10px; display:inline-block; border-bottom: 1px dashed #ddd; border-left: 1px dashed #ddd;'></span>
                                                        <?php  echo $goodcate3['name'];?>
                                                        <div class="mylink-sub">
                                                            <a href="javascript:;" class="mylink-nav" data-href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$goodcate['id'],'ccate'=>$goodcate2['id'],'tcate'=>$goodcate3['id']))?>">选择</a>
                                                        </div>
                                                    </div>
                                                <?php  } ?>
                                            <?php  } } ?>
                                        <?php  } ?>
                                    <?php  } } ?>
                                <?php  } ?>
                             <?php  } } ?>
                         </div>
                     </div>
                     <?php  if(!empty($designer)) { ?>
                     <div role="tabpanel" class="tab-pane link_cate" id="link_diy">
                         <div class="mylink-con">
                             <?php  if(is_array($diypages)) { foreach($diypages as $diypage) { ?>
                                <div class="mylink-line">
                                    <?php  if($diypage['pagetype']=='4') { ?>
                                        <label class="label label-danger" style="margin-right:5px;">其他</label>
                                    <?php  } else if($diypage['pagetype']=='1') { ?>
                                        <?php  if($diypage['setdefault']==1) { ?>
                                            <label class="label label-success" style="margin-right:5px;">默认首页</label>
                                        <?php  } else { ?>
                                            <label class="label label-primary" style="margin-right:5px;">首页</label>
                                        <?php  } ?>
                                    <?php  } ?>
                                    <?php  echo $diypage['pagename'];?>
                                    <div class="mylink-sub">
                                        <a href="javascript:;" class="mylink-nav" data-href="<?php  echo $this->createPluginMobileUrl('designer',array('pageid'=>$diypage['id']))?>">选择</a>
                                    </div>
                                </div>
                             <?php  } } ?>
                         </div>
                     </div>
                     <?php  } ?>
                     <div role="tabpanel" class="tab-pane link_cate" id="link_article">
                         <div class="input-group">
                             <span class="input-group-addon" style='padding:0px; border: 0px;'>
                                 <select class="form-control tpl-category-parent" name="article_category" id="select-article-ca" style='width: 150px; border-radius: 4px 0px 0px 4px; border-right: 0px;'>
                                     <option value="" selected="selected">全部分类</option>
                                     <?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
                                        <option value="<?php  echo $category['id'];?>"><?php  echo $category['category_name'];?></option>
                                     <?php  } } ?>
                                 </select>
                             </span>
                             <input type="text" class="form-control" value="" id="select-article-kw" placeholder="请输入文章标题进行搜索">
                             <span class="input-group-btn"><button type="button" class="btn btn-default" id="select-article-btn">搜索</button></span>
                         </div>
                         <div class="mylink-con" style="height:266px;">
                             <div class="mylink-line">
                                 <label class="label label-primary" style="margin-right:5px;">文章列表</label>
                                 <?php  echo $article_sys['article_title'];?>
                                 <div class="mylink-sub">
                                     <a href="javascript:;" class="mylink-nav" data-href="<?php  echo $this->createPluginMobileUrl('article',array('method'=>'article'))?>">选择</a>
                                 </div>
                             </div>
                             <div id="select-articles"></div>
                         </div>
                     </div>
                     <div role="tabpanel" class="tab-pane link_cate" id="link_other">
                         <div class="mylink-con" style="height: 150px;">
                             <div class="form-group" style="overflow: hidden;">
                                 <label class="col-xs-12 col-sm-3 col-md-2 control-label" style="line-height: 34px;">链接地址</label>
                                 <div class="col-sm-9 col-xs-12">
                                     <textarea name="mylink_href" class="form-control" style="height: 90px; resize: none;" placeholder="请以http://开头"></textarea>   
                                 </div>
                             </div>
                             <div class="form-group" style="overflow: hidden; margin-bottom: 0px;i">
                                 <label class="col-xs-12 col-sm-3 col-md-2 control-label" style="line-height: 34px;"></label>
                                 <div class="col-sm-9 col-xs-12">
                                     <div class="btn btn-primary col-lg-1 mylink-nav2" style="margin-left: 20px; width: auto; overflow: hidden; margin-left: 0px;"> 插入 </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<!-- mylink end -->
<script type="text/javascript" src="resource/js/lib/jquery-ui-1.10.3.min.js"></script>
<script language="javascript">
    $(function() {
        $("#param-items").sortable({handle: '.fa-move'});
        $("#chkoption").click(function() {
            var obj = $(this);
            if (obj.get(0).checked) {
                $("#tboption").show();
                $(".trp").hide();
            }
            else {
                $("#tboption").hide();
                $(".trp").show();
            }
        });
    })
    function addParam(type) {
        var url = "<?php  echo $this->createWebUrl('sysset/settpl',array('tpl'=>'setmenu'))?>";
        $.ajax({
            "url": url,
            "data": {'type':type},
            success: function(data) {
                $('#param-items.'+type).append(data);
            }
        });
        return;
    }
    function deleteParam(o) {
        $(o).parent().parent().remove();
    }
    $(document).on("click",".nav-link",function(){
        var id = $(this).data("id");
        if(id){
            $("#modal-mylink").attr({"data-id":id});
            $("#modal-mylink").modal();
        }
    });
    $(document).on("click",".mylink-nav",function(){
        var href = $(this).data("href");
        var id = $("#modal-mylink").attr("data-id");
        if(id){
            $("input[data-id="+id+"]").val(href);
            $("#modal-mylink").attr("data-id","");
        }else{
            ue.execCommand('link', {href:href});
        }
        $("#modal-mylink .close").click();
    });
    $(".mylink-nav2").click(function(){
        var href = $("textarea[name=mylink_href").val();
        if(href){
            var id = $("#modal-mylink").attr("data-id");
            if(id){
                $("input[data-id="+id+"]").val(href);
                $("#modal-mylink").attr("data-id","");
            }else{
                ue.execCommand('link', {href:href});
            }
            $("#modal-mylink .close").click();
            $("textarea[name=mylink_href").val(""); 
        }else{
            $("textarea[name=mylink_href").focus();
            alert("链接不能为空!");
        }
    });
    // ajax 选择商品
    $("#select-good-btn").click(function(){
        var kw = $("#select-good-kw").val();
        $.ajax({
            type: 'POST',
            url: "<?php  echo $this->createPluginWebUrl('article',array('method'=>'api','apido'=>'selectgoods'))?>",
            data: {kw:kw},
            dataType:'json',
            success: function(data){
                //console.log(data);
                $("#select-goods").html("");
                if(data){
                    $.each(data,function(n,value){
                        var html = '<div class="good">';
                              html+='<div class="img"><img src="'+value.thumb+'"/></div>'
                              html+='<div class="choosebtn">';
                              html+='<a href="javascript:;" class="mylink-nav" data-href="'+"<?php  echo $this->createMobileUrl('shop/detail')?>&id="+value.id+'">详情链接</a><br>';
                              if(value.hasoption==0){
                                html+='<a href="javascript:;" class="mylink-nav" data-href="'+"<?php  echo $this->createMobileUrl('order/confirm')?>&id="+value.id+'">下单链接</a>';
                              }
                              html+='</div>';
                              html+='<div class="info">';
                              html+='<div class="info-title">'+value.title+'</div>';
                              html+='<div class="info-price">原价:￥'+value.productprice+' 现价￥'+value.marketprice+'</div>';
                              html+='</div>'
                              html+='</div>';
                        $("#select-goods").append(html);
                    }); 
                }
           }
        });
    });
    // ajax 选择文章
    $("#select-article-btn").click(function(){
        var category = $("#select-article-ca option:selected").val();
        var keyword = $("#select-article-kw").val();
        $.ajax({
            type: 'POST',
            url: "<?php  echo $this->createPluginWebUrl('article',array('method'=>'api','apido'=>'selectarticles'))?>",
            data: {category:category,keyword:keyword},
            dataType:'json',
            success: function(data){
                //console.log(data);
                $("#select-articles").html("");
                if(data){
                    $.each(data,function(n,value){
                        var html = '<div class="mylink-line">['+value.category_name+'] '+value.article_title;
                              html+='<div class="mylink-sub">';
                              html+='<a href="javascript:;" class="mylink-nav" data-href="'+"<?php  echo $this->createPluginMobileUrl('article')?>&aid="+value.id+'">选择</a>';
                              html+='</div></div>';
                        $("#select-articles").append(html);
                    });
                }
            }
        });
    }); 
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>