<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('tabs', TEMPLATE_INCLUDEPATH)) : (include template('tabs', TEMPLATE_INCLUDEPATH));?>
<form id="setform"  action="" method="post" class="form-horizontal form">
    <div class='panel panel-default'>
        <div class='panel-heading'>供应商设置</div>
        <div class='panel-body'>
            <div class="form-group">
            	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="col-xs-12 col-sm-3 col-md-3 control-label">开启会员申请供应商</label>
	                <div class="col-sm-9 col-xs-12">
	                    <label class="radio-inline"><input type="radio"  name="setdata[switch]" value="0" <?php  if($set['switch'] ==0) { ?> checked="checked"<?php  } ?> /> 关闭</label>
	                    <label class="radio-inline"><input type="radio"  name="setdata[switch]" value="1" <?php  if($set['switch'] ==1) { ?> checked="checked"<?php  } ?> /> 开启</label>
	                </div>
	            </div>
            </div>
        </div>


        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">供应商权限设置</label>
            <div class="col-sm-9">


               <?php  foreach($power as $key => $value){?>


                    <label class="checkbox-inline">
                        <input type="checkbox" id="inlineCheckbox1" value="<?php  echo $key;?>" name="power[<?php  echo $key;?>]" <?php  if(!empty($_power[$key])) { ?>checked <?php  } ?>><?php  echo $value;?>
                    </label>


               <?php  }?>
 
            </div>
        </div>

        <div class="form-group"></div>



        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9">
                <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" onclick='return formcheck()' />
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            </div>
        </div>


 





    </div>
</form>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
