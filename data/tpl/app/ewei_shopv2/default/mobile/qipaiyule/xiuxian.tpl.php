<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
  .fui-content {
    background-color: #0d1438;
  }

  .uls {
    display: flex;
    flex-wrap: wrap;
    margin: 1rem;
        margin-top: 3rem;
  }

  .lis0 {
    width: 33%;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #fff;
    margin-bottom: 3rem;
  }

  .lis0>span {
    margin-top: 10px;
  }

</style>

<div class='fui-page  fui-page-current member-log-page'>

  <div class="fui-header">
    <div class="fui-header-left">
      <a class="back"></a>
    </div>
    <div class="title">休闲游戏</div>
    <div class="fui-header-right">
      <i class="icon icon-add4"></i>
    </div>
  </div>

  <div class='fui-content navbar'>
    <ul class="uls">
      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/dezhou.png" alt="" width="50">
        <span>德州扑克</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/2048.png" alt="" width="50">
        <span>2048</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/caiheikuai.png" alt="" width="50">
        <span>别踩白块</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/eluosi.png" alt="" width="50">
        <span>俄罗斯方块</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/huocairen.png" alt="" width="50">
        <span>火柴人联盟</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/qieshuiguo.png" alt="" width="50">
        <span>切水果</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/saiche.png" alt="" width="50">
        <span>疯狂赛车</span>
      </a>
      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/tanchishe.png" alt="" width="50">
        <span>贪吃蛇</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/xiaoniao.png" alt="" width="50">
        <span>小鸟与猪</span>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/xiaoxiaole.png" alt="" width="50">
        <span>消消乐</span>
      </a>
    </ul>
  </div>



</div>

<script>
$(function () {
  $('.zanweikaifang').click(function () {
    alert('暂未开放')
  })
})

</script>

<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

