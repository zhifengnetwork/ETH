<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="./resource/css/bootstrap-switch.min.css" type="text/css" />
<script type="text/javascript" src="./resource/js/lib/bootstrap-switch.js"></script>
<style>    
.panel-heading{background: #E8ECEF;padding:5px 0px 5px 40px;margin: 20px 0px 0 0;border: 1px solid #CFCFCF;border-bottom: none;font-size: 16px;font-weight: 200;}    .panel-body{padding:20px 0;margin-bottom: 20px;border: 1px solid #CFCFCF;border-top: none;background: #fff;}    .form-group>.row>.col-xs-12.col-sm-6.col-md-4{  padding-right: 50px;  margin-bottom: 20px;  }    .form-group>div>span>b, .clr>span>b,    .form-group>span>b,.myrow>span>b,.myrow>div>span>b,.myrow>span>b,.myrow>span>b{color:red;}    .form-group>span,.myrow>span{float: left;padding-left: 15px;padding-top: 7px;}    .clr:after{content: "";display: block;  clear: both;}.fl{float: left;}.fr{float: right;}    div.btn-radio-group label.btn-default.active {  background-color: #1e95c9;  border-color: #357ebd;  color: #fff;  }    .form-group div.boostrap-switch,.myrow div.boostrap-switch{float: left;padding-left: 15px;}    .font-set{margin: 10px 0px;}    .power-set{margin: 10px 0;padding-left: 0px;padding-right: 0px;height:35px;}    .hidden-item{display: none;}    .subcol{width:6%;}    @media(max-width:1580px) {        .myrow {            margin-right: 0px;        }    }    @media(min-width:1580px) {        .myrow {            margin-right: 150px;        }    }
</style>
<ul class="nav nav-tabs">
  <?php if(cv('commission.set')) { ?>
  <li <?php  if($_GPC['method']=='set') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('commission/set')?>">基础设置</a></li>
  <?php  } ?>
</ul>
<form id="setform"  action="" method="post" class="form-horizontal form">
  <div class='panel-heading'> 分销层级 </div>
  <div class="panel-body">
    <div class="form-group">
      <label class="col-xs-3 col-md-2 control-label">分销层级</label>
      <div class="col-xs-9 col-md-4">
        <select  class="form-control" name="setdata[level]">
          <option value="0" <?php  if(empty($set['level'])) { ?>selected<?php  } ?>>不开启分销机制</option>
          <option value="1" <?php  if($set['level']==1) { ?>selected<?php  } ?>>一级分销</option>
          <option value="2" <?php  if($set['level']==2) { ?>selected<?php  } ?> >二级分销</option>
          <option value="3" <?php  if($set['level']==3) { ?>selected<?php  } ?> >三级分销</option>
          <option value="4" <?php  if($set['level']==4) { ?>selected<?php  } ?> >四级分销</option>
          <option value="5" <?php  if($set['level']==5) { ?>selected<?php  } ?> >五级分销</option>
         
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label class="col-xs-3  col-md-2 control-label"></label>
      <div class="col-xs-9 col-md-8 "> <span class='help-block'>新加入的分销商（默认等级），<b>采用此默认比例</b></span> <span class='help-block'>分销佣金计算优先级：<b> 商品固定佣金比例 > 分销商等级佣金比例 >默认佣金比例</b></span> </div>
    </div>
    <div class="form-group clr">
      <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销内购</label>
      <div class="boostrap-switch" id="myswdiv"> <!--<input type="checkbox" id="mysw" name="selfbuy"  value="<?php  echo $set['selfbuy'];?>" <?php  if($set['selfbuy'] ==1) { ?> checked="checked"<?php  } ?>/>-->
        <label class="radio-inline">
          <input type="radio"  name="setdata[selfbuy]" value="0" <?php  if($set['selfbuy'] ==0) { ?> checked="checked"<?php  } ?> />
          关闭</label>
        <label class="radio-inline">
          <input type="radio"  name="setdata[selfbuy]" value="1" <?php  if($set['selfbuy'] ==1) { ?> checked="checked"<?php  } ?> />
          开启</label>
      </div>
      <span class='help-block'  >开启分销内购，分销商自己购买商品，<b>享受一级佣金，上级享受二级佣金，上上级享受三级佣金</b></span> </div>
    <div class="form-group">
      <label class="col-xs-12 col-sm-3 col-md-2 control-label">佣金计算方式</label>
      <div class="col-xs-12 col-sm-4">
        <select  class="form-control" name="culate_method">
          <option value="0" <?php  if(empty($set['culate_method'])) { ?>selected<?php  } ?>>默认佣金计算方式</option>
          <option value="1" <?php  if($set['culate_method']==1) { ?>selected<?php  } ?>>实付款金额</option>
          <option value="2" <?php  if($set['culate_method']==2) { ?>selected<?php  } ?>>商品原价</option>
          <option value="3" <?php  if($set['culate_method']==3) { ?>selected<?php  } ?> >商品现价</option>
          <option value="4" <?php  if($set['culate_method']==4) { ?>selected<?php  } ?> >商品成本价</option>
          <option value="5" <?php  if($set['culate_method']==5) { ?>selected<?php  } ?> >商品利润（实付款金额-商品成本价）</option>
        </select>
      </div>
    </div>
  </div>
  </div>
  <div class='panel-heading'> 分销设置 </div>
  <div class='panel-body'>
    <div class="form-group row clr ">
      <label class="col-xs-4 col-sm-3 col-md-2 col-lg-2 control-label">成为下线条件</label>
      <div class="btn-group btn-radio-group" data-toggle="buttons" style="float: left;">
        <label class="btn btn-default">
          <input type="radio"  name="setdata[become_child]" value="0" <?php  if($set['become_child'] ==0) { ?> checked="checked"<?php  } ?> />
          首次点击分享连接</label>
        <label class="btn btn-default">
          <input type="radio"  name="setdata[become_child]" value="1" <?php  if($set['become_child'] ==1) { ?> checked="checked"<?php  } ?> />
          首次下单</label>
        <label class="btn btn-default">
          <input type="radio"  name="setdata[become_child]" value="2" <?php  if($set['become_child'] ==2) { ?> checked="checked"<?php  } ?> />
          首次付款</label>
      </div>
      <span class='help-block' >首次点击分享连接： <b>可以自由设置分销商条件</b></span> <span class='help-block' >首次下单/首次付款： <b>无条件不可用</b></span> </div>
   
   
    <div class="form-group">
      <label class="col-xs-12 col-sm-3 col-md-2 control-label">购买指定商品升级</label>
      <div class="boostrap-switch"> <!--<input type="checkbox" name="upgrade_by_good" value="<?php  echo $set['upgrade_by_good'];?>"  <?php  if($set['upgrade_by_good']==1) { ?>checked="checked"<?php  } ?> >-->
        <label class="radio-inline">
          <input type="radio"  name="setdata[upgrade_by_good]" value="0" <?php  if($set['upgrade_by_good'] ==0) { ?> checked="checked"<?php  } ?> />
          否</label>
        <label class="radio-inline">
          <input type="radio"  name="setdata[upgrade_by_good]" value="1" <?php  if($set['upgrade_by_good'] ==1) { ?> checked="checked"<?php  } ?> />
          是</label>
      </div>
    </div>
    <div class="form-group">
      <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商必须完善资料</label>
      <div class="boostrap-switch">
        <label class="radio-inline">
          <input type="radio"  name="setdata[become_reg]" value="0" <?php  if($set['become_reg'] ==0) { ?> checked="checked"<?php  } ?> />
          需要</label>
        <label class="radio-inline">
          <input type="radio"  name="setdata[become_reg]" value="1" <?php  if($set['become_reg'] ==1) { ?> checked="checked"<?php  } ?> />
          不需要</label>
        <!--<input type="checkbox"  name="become_reg" value="<?php  echo $set['become_reg'];?>"  <?php  if($set['become_reg'] ==1) { ?> checked="checked"<?php  } ?>>--> </div>
      <span class="help-block" >(分销商在分销或提现时是否必须完善资料)</span> </div>
    <div class="form-group">
      <label class="col-xs-12 col-sm-3 col-md-2 control-label">成为分销商是否需要审核</label>
      <div  class="boostrap-switch" style="float: left;">
        <label class="radio-inline">
          <input type="radio"  name="setdata[become_check]" value="0" <?php  if($set['become_check'] ==0) { ?> checked="checked"<?php  } ?> />
          需要</label>
        <label class="radio-inline">
          <input type="radio"  name="setdata[become_check]" value="1" <?php  if($set['become_check'] ==1) { ?> checked="checked"<?php  } ?> />
          不需要</label>
        <!--<input type="checkbox" name="become_check" value="<?php  echo $set['become_check'];?>"  <?php  if($set['become_check'] ==1) { ?> checked="checked"<?php  } ?> >--> </div>
      <span class="help-block" >(以上条件达到后，<b>是否需要审核才能成为真正的分销商</b>)</span> </div>
  </div>
  <div class='panel-heading'> 权限设置 </div>
  <div class='panel-body'>
    <div class="myrow">
      <div class="col-md-12 col-lg-6 power-set">
        <label class="col-xs-3 col-md-3 col-lg-3 control-label">提现额度</label>
        <div class="col-xs-3 col-md-3">
          <input type="text" name="setdata[withdraw]" class="form-control" value="<?php  echo $set['withdraw'];?>"  />
        </div>
        <span class="help-block" >(当前代理的佣金达到此额度时才能提现)</span> </div>
      <!-- Author:ym Date:2016-04-07 Content:钓鱼式营销 -->
      <div class="col-md-12 col-lg-6 power-set">
        <label class="col-xs-3 col-md-3 col-lg-3 control-label">提现消费</label>
        <div class="col-xs-3 col-md-3">
          <input type="text" name="setdata[consume_withdraw]" class="form-control" value="<?php  echo $set['consume_withdraw'];?>"  />
        </div>
        <span class="help-block" >(钓鱼式营销，提现需先消费的金额，需订单完成后。)</span> </div>
      <div class="col-md-12 col-lg-6 power-set">
        <label class="col-xs-3 col-md-3 col-lg-3 control-label">结算天数</label>
        <div class="col-xs-3 col-md-3" style="float: left;">
          <input type="text" name="setdata[settledays]" class="form-control" value="<?php  echo $set['settledays'];?>"  />
        </div>
        <span class="help-block" >当订单完成后的n天后，<b>佣金才能申请提现</b></span> </div>
      <div class="col-md-12 col-lg-6 power-set">
        <label class="col-xs-3 col-md-3 col-lg-3 control-label">分销等级说明连接</label>
        <div class="col-xs-3 col-md-3" style="float: left;">
          <input type="text" name="setdata[levelurl]" class="form-control" value="<?php  echo $set['levelurl'];?>"  />
        </div>
        <span class="help-block" >分销等级说明连接</span> </div>

		
      <div class="col-md-12 col-lg-6 power-set">
        <label class="col-xs-3 col-md-3 col-lg-3 control-label">余额手续费</label>
        <div class="col-xs-3 col-md-3">
          <input type="text" name="setdata[procedures]" class="form-control" value="<?php  echo $set['procedures'];?>"  />
		  
        </div>
        <span class="help-block" >%(当前设置余额提现手续费用，按百分之比来扣除)</span> </div>
      <div class="col-md-12 col-lg-6 power-set">
        <label class="col-xs-3 col-md-3 col-lg-3 control-label">开启提现到余额</label>
        <div class="boostrap-switch"  style="float: left;">
          <label class="radio-inline">
            <input type="radio"  name="setdata[closetocredit]" value="0" <?php  if($set['closetocredit'] ==0) { ?> checked="checked"<?php  } ?> />
            开启</label>
          <label class="radio-inline">
            <input type="radio"  name="setdata[closetocredit]" value="1" <?php  if($set['closetocredit'] ==1) { ?> checked="checked"<?php  } ?> />
            关闭</label>
          <!--<input type="checkbox" name="closetocredit" value="<?php  echo $set['closetocredit'];?>" <?php  if($set['closetocredit'] ==1) { ?> checked="checked"<?php  } ?> >--> </div>
        <span class="help-block" >(是否允许用户佣金提现到余额，<b>否则只允许微信提现</b>)</span> </div>
      </div>
  </div>
  
  
  
    <div class='panel-heading'>  </div>
  <div class='panel-body'>
    <div class="form-group">
      <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
      <div class="col-sm-9 col-xs-12">

      </div>
    </div>
    <div class="form-group">
      <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
      <div class="col-sm-9 col-xs-12">  </div>
    </div>
  </div>
 
 <div class='panel-heading'> 模板设置 </div>
  <div class='panel-body'>
    <?php  if(0) { ?>
    <div class="form-group row clr ">
      <label class="col-xs-4 col-sm-3 col-md-2 col-lg-2 control-label">模板选择</label>
      <div class="btn-group btn-radio-group col-sm-9 col-xs-12" data-toggle="buttons">
        <select class='form-control' name='setdata[style]'>
          <?php  if(is_array($styles)) { foreach($styles as $style) { ?>
          <option value='<?php  echo $style;?>' <?php  if($style==$set['style']) { ?>selected<?php  } ?>><?php  echo $style;?></option>
          <?php  } } ?>
        </select>
      </div>
      <span class='help-block' ></span> </div>
    <?php  } ?>  
   
   
    <div class="form-group">
      <label class="col-xs-12 col-sm-3 col-md-2 control-label">注册面头部图片</label>
      <div class="boostrap-switch col-sm-9 col-xs-12">
       <?php  echo tpl_form_field_image('setdata[regbg]',$set['regbg'],'../addons/sz_yi/plugin/commission/template/mobile/default/static/images/bg.png')?>
      </div>
    </div>
  </div>
   

  <!--<div class='panel-heading'>        等级设置    </div>    <div class='panel-body'>        <div class="form-group">            <label class="col-xs-12 col-sm-3 col-md-2 control-label">默认级别名称</label>            <div class="col-sm-9 col-xs-12">                <input type="text" name="setdata[levelname]" class="form-control" value="<?php echo empty($set['levelname'])?'普通等级':$set['levelname']?>"  />                <span class="help-block">分销商默认等级名称，不填写默认“普通等级”</span>            </div>        </div>        <?php  if(0) { ?>        <div class='panel-body'>            <div class="form-group">                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商等级升级依据</label>                <div class="col-sm-9 col-xs-12">                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="0" <?php  if(empty($set['leveltype'])) { ?>checked<?php  } ?>/> 分销订单总额(完成的订单)                    </label>                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="1" <?php  if($set['leveltype']==1) { ?>checked<?php  } ?>/> 一级分销订单金额(完成的订单)                    </label>        <br/>                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="2" <?php  if($set['leveltype']==2) { ?>checked<?php  } ?>/> 分销订单总数(完成的订单)                    </label>                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="3" <?php  if($set['leveltype']==3) { ?>checked<?php  } ?>/> 一级分销订单总数(完成的订单)                    </label>                    <br /><br />                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="4" <?php  if($set['leveltype']==4) { ?>checked<?php  } ?>/> 自购订单金额(完成的订单)                    </label>                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="5" <?php  if($set['leveltype']==5) { ?>checked<?php  } ?>/> 自购订单数量(完成的订单)                    </label>                    <br/>                    <br />                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="6" <?php  if($set['leveltype']==6) { ?>checked<?php  } ?>/> 下线总人数（分销商+非分销商）                    </label>                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="7" <?php  if($set['leveltype']==7) { ?>checked<?php  } ?>/> 一级下线人数（分销商+非分销商）                    </label>                    <br />                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="8" <?php  if($set['leveltype']==8) { ?>checked<?php  } ?>/> 下级分销商总人数                    </label>                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="9" <?php  if($set['leveltype']==9) { ?>checked<?php  } ?>/> 一级分销商人数                    </label>                    <br /><br />                    <label class="radio radio-inline" style="width:240px">                        <input type="radio" name="setdata[leveltype]" value="10" <?php  if($set['leveltype']==10) { ?>checked<?php  } ?>/> 已提现佣金总金额                    </label>                    <span class="help-block">默认为分销订单总金额</span>                </div>            </div>        </div> </div>    <?php  } ?>    <div class='panel-heading'>        样式设置    </div>    <div class='panel-body'>        <div class="form-group">            <label class="col-xs-12 col-sm-3 col-md-2 control-label">模板选择</label>            <div class="col-sm-9 col-xs-12">                <select class='form-control' name='setdata[style]'>                    <?php  if(is_array($styles)) { foreach($styles as $style) { ?>                    <option value='<?php  echo $style;?>' <?php  if($style==$set['style']) { ?>selected<?php  } ?>><?php  echo $style;?></option>                    <?php  } } ?>                </select>            </div>        </div>        <div class="form-group">            <label class="col-xs-12 col-sm-3 col-md-2 control-label">注册面头部图片</label>            <div class="col-sm-9 col-xs-12">                <?php  echo tpl_form_field_image('setdata[regbg]',$set['regbg'],'../addons/sz_yi/plugin/commission/template/mobile/default/static/images/bg.png')?>            </div>        </div>    </div>-->
  <div class='panel-heading'> 文字设置 </div>
  <div class='panel-body' style="margin-bottom: 60px;">
    <div class="form-group"> </div>
    <div class="form-group row">
      <div class="col-sm-12 col-md-11">
        <div class="col-xs-12 col-md-12 col-lg-6" style="margin: 10px 15px 10px 0px;padding-right: 0px;">
          <div class="input-group">
            <div class="input-group-addon">默认级别名称</div>
            <input type="text" name="setdata[levelname]" class="form-control" value="<?php echo empty($set['levelname'])?'普通等级':$set['levelname']?>"  />
            <div class="input-group-addon">分销商默认等级名称，不填写默认“普通等级”</div>
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">按&nbsp;钮&nbsp;文&nbsp;字&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="setdata[buttontext]" class="form-control" value="<?php echo empty($set['buttontext'])?'我要分销':$set['buttontext']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">分销商名称&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[agent]" class="form-control" value="<?php echo empty($set['texts']['agent'])?'分销商':$set['texts']['agent']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">小<span style="display: inline-block;width: 50px;"></span>店&nbsp;&nbsp;</div>
            <input type="text" name="texts[shop]" class="form-control" value="<?php echo empty($set['texts']['shop'])?'小店':$set['texts']['shop']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">我&nbsp;的&nbsp;小&nbsp;店&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[myshop]" class="form-control" value="<?php echo empty($set['texts']['myshop'])?'我的小店':$set['texts']['myshop']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">分&nbsp;销&nbsp;中&nbsp;心&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[center]" class="form-control" value="<?php echo empty($set['texts']['center'])?'分销中心':$set['texts']['center']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">成为分销商&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[become]" class="form-control" value="<?php echo empty($set['texts']['become'])?'成为分销商':$set['texts']['become']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">提<span style="display: inline-block;width: 50px;"></span>现&nbsp;&nbsp;</div>
            <input type="text" name="texts[withdraw]" class="form-control" value="<?php echo empty($set['texts']['withdraw'])?'提现':$set['texts']['withdraw']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">佣<span style="display: inline-block;width: 50px;"></span>金&nbsp;&nbsp;</div>
            <input type="text" name="texts[commission]" class="form-control" value="<?php echo empty($set['texts']['commission'])?'佣金':$set['texts']['commission']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">分&nbsp;销&nbsp;佣&nbsp;金&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[commission1]" class="form-control" value="<?php echo empty($set['texts']['commission1'])?'分销佣金':$set['texts']['commission1']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">累&nbsp;计&nbsp;佣&nbsp;金&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[commission_total]" class="form-control" value="<?php echo empty($set['texts']['commission_total'])?'累计佣金':$set['texts']['commission_total']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">可提现佣金&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[commission_ok]" class="form-control" value="<?php echo empty($set['texts']['commission_ok'])?'可提现佣金':$set['texts']['commission_ok']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">已申请佣金&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[commission_apply]" class="form-control" value="<?php echo empty($set['texts']['commission_apply'])?'已申请佣金':$set['texts']['commission_apply']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">待打款佣金&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[commission_check]" class="form-control" value="<?php echo empty($set['texts']['commission_check'])?'待打款佣金':$set['texts']['commission_check']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">未结算佣金&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[commission_lock]" class="form-control" value="<?php echo empty($set['texts']['commission_lock'])?'未结算佣金':$set['texts']['commission_lock']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">成功提现佣金</div>
            <input type="text" name="texts[commission_pay]" class="form-control" value="<?php echo empty($set['texts']['commission_pay'])?'成功提现佣金':$set['texts']['commission_pay']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">佣&nbsp;金&nbsp;明&nbsp;细&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[commission_detail]" class="form-control" value="<?php echo empty($set['texts']['commission_detail'])?'佣金明细':$set['texts']['commission_detail']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">分&nbsp;销&nbsp;订&nbsp;单&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[order]" class="form-control" value="<?php echo empty($set['texts']['order'])?'佣金明细':$set['texts']['order']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">我&nbsp;的&nbsp;团&nbsp;队&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[myteam]" class="form-control" value="<?php echo empty($set['texts']['myteam'])?'我的团队':$set['texts']['myteam']?>"  />
          </div>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-3 font-set">
          <div class="input-group">
            <div class="input-group-addon">我&nbsp;的&nbsp;客&nbsp;户&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <input type="text" name="texts[mycustomer]" class="form-control" value="<?php echo empty($set['texts']['mycustomer'])?'我的下线':$set['texts']['mycustomer']?>"  />
          </div>
        </div>
      </div>
      <div class="" style="background: #fff;position:fixed;bottom: 0px;z-index: 10;padding: 5px 0;width: 100%;text-align: center;">
        <div class="col-xs-12 col-sm-11">
          <input type="submit" name="submit" value="提交" class="btn btn-primary subcol" onclick='return formcheck()' />
          <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-12 col-sm-12 col-lg-9" style="margin-left: 15px;padding-right:60px;">
        <div class="input-group">
          <div class="input-group-addon" style="width: 12%">团队级别名称</div>
          <input type="text" name="texts[c1]" class="form-control" value="<?php echo empty($set['texts']['c1'])?'一级':$set['texts']['c1']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c2]" class="form-control" value="<?php echo empty($set['texts']['c2'])?'二级':$set['texts']['c2']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c3]" class="form-control" value="<?php echo empty($set['texts']['c3'])?'三级':$set['texts']['c3']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c4]" class="form-control" value="<?php echo empty($set['texts']['c4'])?'四级':$set['texts']['c4']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c5]" class="form-control" value="<?php echo empty($set['texts']['c5'])?'五级':$set['texts']['c5']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c6]" class="form-control" value="<?php echo empty($set['texts']['c6'])?'六级':$set['texts']['c6']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c7]" class="form-control" value="<?php echo empty($set['texts']['c7'])?'七级':$set['texts']['c7']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c8]" class="form-control" value="<?php echo empty($set['texts']['c8'])?'八级':$set['texts']['c8']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c9]" class="form-control" value="<?php echo empty($set['texts']['c9'])?'九级':$set['texts']['c9']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c10]" class="form-control" value="<?php echo empty($set['texts']['c10'])?'十级':$set['texts']['c10']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c11]" class="form-control" value="<?php echo empty($set['texts']['c11'])?'十一级':$set['texts']['c11']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c12]" class="form-control" value="<?php echo empty($set['texts']['c12'])?'十二级':$set['texts']['c12']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c13]" class="form-control" value="<?php echo empty($set['texts']['c13'])?'十三级':$set['texts']['c13']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c14]" class="form-control" value="<?php echo empty($set['texts']['c14'])?'十四级':$set['texts']['c14']?>" style="width:12%;text-align:center;" />
          <input type="text" name="texts[c15]" class="form-control" value="<?php echo empty($set['texts']['c15'])?'十五级':$set['texts']['c15']?>" style="width:12%;text-align:center;" />
        </div>
      </div>
    </div>
  </div>
  </div>
</form>
<!-- Author:Y.yang Date:2016-04-08 Content:购买指定商品成为分销商，（选择商品的输入框和JS） -->
<div id="modal-goods" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style='width: 920px;'>
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3>选择商品</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="input-group">
            <input type="text" class="form-control" name="keyword" value="" id="search-kwd-goods"                               placeholder="请输入商品名称"/>
            <span class='input-group-btn'>
            <button type="button" class="btn btn-default"                                                              onclick="search_goods();">搜索 </button>
            </span> </div>
        </div>
        <div id="module-menus-goods" style="padding-top:5px;"></div>
      </div>
      <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a> </div>
    </div>
  </div>
</div>
</div>
</div>
<script>   $(function () {        var befInx=$("[name='setdata[level]']").prop("selectedIndex");        for(i=befInx;i<=15;i++){            $("#sIx").children().eq(i).addClass("hidden-item");        }        $("[name='setdata[level]']").change(function () {            var clkInx=$(this).prop("selectedIndex");            if ((parseInt(befInx)-parseInt(clkInx))<0){                for(i=befInx;i<clkInx;i++){                    $("#sIx").children().eq(i).removeClass("hidden-item");                }                befInx=clkInx;            }            else {                for (i=14;i>=clkInx;i--){                    $("#sIx").children().eq(i).addClass("hidden-item");                }                befInx=clkInx;            }        });    });   $(function () {        var bcs=$("[name='setdata[become_child]']");        for (i=0;i<bcs.length;i++){            if(bcs[i].checked){                $(bcs[i]).parent().addClass("active");            }else {                $(bcs[i]).parent().removeClass("active");            }        }    });   /*$(function() {        $(":checkbox").on("switchChange.bootstrapSwitch", function () {                if($(this).prop('checked')){                    $(this).val('1');                    $(this).attr('checked','checked');                }                else{                    $(this).val('0');                    $(this).removeAttr('checked');                }            });       $('[name="selfbuy"]').bootstrapSwitch({onText:"开启",offText:"关闭"});       $('[name="upgrade_by_good"]').bootstrapSwitch({onText:"是",offText:"否"});       $('[name="become_order"]').bootstrapSwitch({onText:"付款后",offText:"完成后"});       $('[name="become_reg"]').bootstrapSwitch({onText:"需要",offText:"不需要"});       $('[name="become_check"]').bootstrapSwitch({onText:"需要",offText:"不需要"});       $('[name="closetocredit"]').bootstrapSwitch({onText:"开启",offText:"关闭"});       $('[name="select_goods"]').bootstrapSwitch({onText:"开启",offText:"关闭"});       $('[name="closemyshop"]').bootstrapSwitch({onText:"开启",offText:"关闭"});       $('[name="openorderdetail"]').bootstrapSwitch({onText:"开启",offText:"关闭"});       $('[name="openorderbuyer"]').bootstrapSwitch({onText:"开启",offText:"关闭"});       $('[name="remind_message"]').bootstrapSwitch({onText:"开启",offText:"关闭"});       $('[name="liuyan"]').bootstrapSwitch({onText:"开启",offText:"关闭"});    });*/</script><script language='javascript'>    function search_goods() {        if ($.trim($('#search-kwd-goods').val()) == '') {            Tip.focus('#search-kwd-goods', '请输入关键词');            return;        }        $("#module-goods").html("正在搜索....");        $.get("<?php  echo $this->createWebUrl('shop / query')?>", {            keyword: $.trim($('#search-kwd-goods').val())        }, function (dat) {            $('#module-menus-goods').html(dat);        });    }    function select_good(o) {        $("#goodsid").val(o.id);        $("#goods").val("[" + o.id + "]" + o.title);        $("#modal-goods .close").click();    }    function formcheck() {        var become_child = $(":radio[name='setdata[become_child]']:checked").val();        if (become_child == '1' || become_child == '2') {            if ($(":radio[name='setdata[become]']:checked").val() == '0') {                alert('成为下线条件选择了首次下单/首次付款，成为分销商条件不能选择无条件!');                return false;            }        }        return true;    }</script><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>