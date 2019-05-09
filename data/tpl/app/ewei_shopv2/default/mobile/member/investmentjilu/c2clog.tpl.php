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
      margin-top: 53px;
    }
</style>

<div class='fui-page  fui-page-current member-log-page'>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">c2c交易记录</div>

    </div>
    <div class="sty1">
    <?php  if(is_array($list)) { foreach($list as $log) { ?>
    <div class=" goods-item">
      <div class="time">c2c交易时间：<span><?php  echo $log['createtime'];?></span></div>
      <div class="lis">
        <p>ETH数量：<?php  echo $log['title'];?></p>
        <p>交易金额：<?php  echo $log['RMB'];?></p>
      </div>
    </div>
    <?php  } } ?>
  </div>

  </div>


  <?php  $this->footerMenus()?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
