<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<div class="page-header"><img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置：<span class="text-primary">申诉详情</span></div>

<div class="page-content">





<form <?php  if('member.list.edit') { ?>action="" method='post'<?php  } ?> class='form-horizontal form-validate'>

 <input type="hidden" name="referer" value="" />

	<div class="tabs-container">



		<div class="tabs">

			<ul class="nav nav-tabs">

				<li class="active"><a data-toggle="tab" href="#tab-basic" aria-expanded="true"> 基本信息</a></li>

				<li class=""><a data-toggle="tab" href="#tab-trade" aria-expanded="false"> 交易信息</a></li>

			</ul>

			<div class="tab-content ">

				<div id="tab-basic" class="tab-pane active">
          <p>申诉人id: <input type="text" name="" value="<?php  echo $guamai_appeal['appeal_name'];?>" disabled> </p><br>
          <p>申诉标题: <input type="text" value="<?php  echo $guamai_appeal['text'];?>" disabled> </p><br>
          <p>申诉内容: <input type="text" value="<?php  echo $guamai_appeal['textarea'];?>" disabled> </p><br>
          <p>凭   证:<br>
            <?php  if(is_array($guamai_appeal['files'])) { foreach($guamai_appeal['files'] as $row) { ?>
            <img src="../attachment/<?php  echo $row;?>" alt="">
            <?php  } } ?>
          </p><br>
          <p>申诉时间: <?php  echo date('Y-m-d H:i',$guamai_appeal['createtime'])?></p><br>
        </div>

				<div id="tab-trade" class="tab-pane">
          <p>挂单人: <input type="text" name="" value="<?php  echo $guamai['openid'];?>" style="width:20%"; disabled> </p><br>
          <p>抢单人: <input type="text" value="<?php  echo $guamai['openid2'];?>" style="width:20%"; disabled> </p><br>
          <p>币单价: <input type="text" value="<?php  echo $guamai['price'];?>" disabled> </p><br>
          <p>币数量: <input type="text" value="<?php  echo $guamai['trx'];?>" disabled> </p><br>
          <p>获得CNY: <input type="text" value="<?php  echo $guamai['money'];?>" disabled> </p><br>
          <p>手续费: <input type="text" value="<?php  echo $guamai['sxf0'];?>" disabled> </p><br>
          <?php  if($guamai['type']==0) { ?>
          <p>买卖类型: 买入 </p><br>
          <?php  } else { ?>
          <p>买卖类型: 卖出 </p><br>
          <?php  } ?>
          <?php  if($guamai['status']==0) { ?>
          <p>交易类型: 未交易 </p><br>
          <?php  } else if($guamai['status']==1) { ?>
          <p>交易类型: 交易中 </p><br>
          <?php  } else if($guamai['status']==2) { ?>
          <p>交易类型: 交易完成 </p><br>
          <?php  } else if($guamai['status']==3) { ?>
          <p>交易类型: 交易失败 </p><br>
          <?php  } ?>
          <p>凭   证:<br>
            <img src="<?php  echo $guamai['file'];?>" alt="">
          </p><br>
          <p>申诉时间: <?php  echo date('Y-m-d H:i',$guamai_appeal['createtime'])?></p><br>
        </div>




			</div>

		</div>

	</div>

	<div class="form-group"></div>

          <div class="form-group">

		<label class="col-lg control-label"></label>

		<div class="col-sm-9 col-xs-12">
        <?php  if($guamai_appeal['stuas']==0) { ?>
        <a  class='btn btn-op btn-primary' data-toggle='ajaxPost' data-confirm="确认同意申诉申请?" href="<?php  echo webUrl('sale/appeal_list',array('id' => $guamai_appeal['id'],'type'=>1));?>">
          <input type="submit"  value="同意" class="btn btn-primary" />
          </a>
           <a  class='btn btn-op btn-primary' data-toggle='ajaxPost' data-confirm="确认拒绝申诉申请?" href="<?php  echo webUrl('sale/appeal_list',array('id' => $guamai_appeal['id'],'type'=>-1));?>">
            <input type="submit"  value="拒绝" class="btn btn-primary" />


          </a>
      <?php  } ?>

			<input type="button" class="btn btn-default" name="submit" onclick="history.go(-1)" value="返回列表" <?php if(cv('member.list.edit')) { ?>style='margin-left:10px;'<?php  } ?> />

		</div>

	</div>



</form>

</div>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--NDAwMDA5NzgyNw==-->
