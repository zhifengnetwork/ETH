<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .goods-item {
        margin: 10px;
        border-bottom: 1px solid #ccc;
        padding: .2rem 1rem;
        background-color: #363a45;
        color: #fff;
    }
    .fui-list-group{
        margin-top: 0;
    }
    .fui-tab{
        margin-bottom: 1px;;
    }
    .sty1{
      margin-top: 39px;
      height: 100%;
      overflow: auto;
      padding-bottom: 97px;
    }
</style>

<div class='fui-page  fui-page-current member-log-page'>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">总记录</div>

    </div>
    <div class="sty1">
      <?php  if(is_array($list)) { foreach($list as $log) { ?>
      <div class=" goods-item">
        <div class="time">时间：<span><?php  echo $log['createtime'];?></span></div>
        <div class="lis">
          <?php  if($log['money']!=null) { ?>
          <p>交易金额：<?php  echo $log['money'];?></p>
          <?php  } ?>
          <?php  if($log['typec2c'] == 1) { ?>
          <?php  if($log['shouxufei'] == 0) { ?>
          <?php  } else { ?>
          <p>手续费：<?php  echo $log['shouxufei'];?></p>
          <?php  } ?>
          <?php  } ?>

          <p>描述：<?php  echo $log['title'];?></p>
          <?php  if($log['typec2c']=="") { ?>

            <?php  if($log['type']==4) { ?>
            <p>实到金额：<?php  echo $log['realmoney'];?></p>
            <p>手续费：<?php  echo $log['charge'];?></p>
            <?php  } ?>
          <?php  } else { ?>
            <?php  if($log['typec2c'] == 1) { ?>
            <p>类型：买入</p>
            <?php  } else { ?>
            <p>类型：卖出</p>
            <?php  } ?>
          <?php  } ?>
          <?php  if($log['after_money']!=null) { ?>
          <?php  if($log['payment'] == 1 ) { ?>
          <p>自由账户可用余额：<?php  echo $log['after_money'];?></p>
          <?php  } else if($log['payment'] == 2 ) { ?>
          <p>复投账户可用余额：<?php  echo $log['after_money'];?></p>
          <?php  } ?>
          <?php  } ?>
        </div>
      </div>
      <?php  } } ?>

      <?php  if(is_array($zhuanzhang)) { foreach($zhuanzhang as $logs) { ?>
      <div class=" goods-item">
        <!-- <div class="time">时间：<span><?php  echo $logs['createtime'];?></span></div> -->
        <div class="lis">
          <p>描述：转币</p>
          <p>转币人：<?php  echo $logs['openid'];?></p>
          <p>得币人：<?php  echo $logs['openid2'];?></p>
          <p>数量：<?php  echo $logs['money'];?></p>
          <p>手续费：<?php  echo $logs['money2'];?></p>
          <p>时间：<?php  echo $logs['createtime'];?></p>
        </div>
      </div>
      <?php  } } ?>
  </div>

  </div>


  <?php  $this->footerMenus()?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
