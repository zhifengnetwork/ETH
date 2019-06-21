<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="region-goods-details row">
    <h1 class="region-goods-left col-sm-12">游戏规则</h1>
	<form  action="<?php  echo weburl('sale/contract')?>" method="post" class="form-horizontal form-validate">
    <div class=" region-goods-right col-sm-10">
        <div class="">
            <?php  echo tpl_ueditor('content',$data['contract'])?>
        </div>
        <div class="form-group" style="background:#fff">
            <label class="col-lg control-label"></label>
            <div class="col-xs-12">
                <input type="submit" value="提交" class="btn btn-primary">
            </div>
        </div>
    </div>
</form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
