<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <?php if(cv('commission.cover')) { ?><li <?php  if($_GPC['method']=='cover') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('commission/cover')?>">分销中心入口设置</a></li><?php  } ?>
</ul>

<form id="setform"  action="" method="post" class="form-horizontal form" onclick='return formcheck()'>
    <div class='panel panel-default'>
        <div class='panel-heading'>
            分销中心入口设置
        </div>
        <div class='panel-body'>
            <div class="row">
                <div class="form-group col-lg-7">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">直接链接</label>
                    <div class="col-xs-7 col-sm-8 col-md-9 col-lg-8">
                        <p class='form-control-static'><a href='javascript:;' title='点击复制连接' id='cp'><?php  echo $this->createPluginMobileUrl('commission')?></a></p>
                    </div>
                </div>
                <div class="form-group col-lg-7">
                    <label class="col-xs-5 col-sm-4 col-md-3 col-lg-2 control-label"><span style="color:red">*</span> 关键词</label>
                    <div class="col-xs-7 col-sm-8 col-md-9 col-lg-8">
                        <input type='text' class='form-control' name='cover[keyword]' value="<?php  echo $keyword['content'];?>" />
                    </div>
                    </div>
                <div class="form-group col-lg-7">
                    <label class="col-xs-5 col-sm-4 col-md-3 col-lg-2 control-label">封面标题</label>
                    <div class="col-xs-7 col-sm-8 col-md-9 col-lg-8">
                        <input type='text' class='form-control' name='cover[title]' value="<?php  echo $cover['title'];?>" />
                    </div>
                </div>
                <div class="form-group col-lg-7">
                    <label class="col-xs-5 col-sm-4 col-md-3 col-lg-2 control-label">封面图片</label>
                    <div class="col-xs-7 col-sm-8 col-md-9 col-lg-8">
                        <?php  echo tpl_form_field_image('cover[thumb]',$cover['thumb'])?>
                    </div>
                </div>
                <div class="form-group col-lg-7">
                    <label class="col-xs-5 col-sm-4 col-md-3 col-lg-2 control-label">封面描述</label>
                    <div class="col-xs-7 col-sm-8 col-md-9 col-lg-8">
                        <textarea name='cover[desc]' class='form-control'><?php  echo $cover['description'];?></textarea>
                    </div>
                </div>
                <div class="form-group col-lg-7">
                <label class="col-xs-5 col-sm-4 col-md-3 col-lg-2 control-label">状态</label>
                <div class="col-xs-7 col-sm-8 col-md-9 col-lg-8">
                    <label class="radio-inline">
                        <input type="radio" name="cover[status]" value="0" <?php  if(empty($rule['status'])) { ?> checked="checked"<?php  } ?>/>
                        禁用
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="cover[status]" value="1" <?php  if($rule['status']==1) { ?> checked="checked"<?php  } ?>/>
                        启用
                    </label>
                </div>
            </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-1 col-sm-2 col-md-3 col-lg-2 control-label"></label>
                <div class="col-xs-11 col-sm-10 col-md-9 col-lg-10">
                    <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                </div>
            </div>
        </div>
        </div>
    </div>
</form>
<script language='javascript'>
    function formcheck(){}
    $(function(){
        $('form').submit(function(){
            if($(':input[name="cover[keyword]"]').isEmpty()){
                Tip.focus($(':input[name="cover[keyword]"]'),'请输入关键词!');
                return false;
            }
            return true;
        })

    })
    require(['util'],function(u){
        $('#cp').each(function(){
            u.clip(this, $(this).text());
        });
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>