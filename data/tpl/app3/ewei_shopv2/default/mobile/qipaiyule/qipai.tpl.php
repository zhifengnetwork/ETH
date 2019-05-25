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
    <div class="title">棋牌娱乐</div>
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
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/doudizhu.png" alt="" width="50">
        <span>斗地主</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/douniu.jpg" alt="" width="50">
        <span>斗牛</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/junqi.png" alt="" width="50">
        <span>军旗</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/majiang.png" alt="" width="50">
        <span>麻将</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/wuziqi.png" alt="" width="50">
        <span>五子棋</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/weiqi.png" alt="" width="50">
        <span>围棋</span>
      </a>
      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/xiangqi.png" alt="" width="50">
        <span>象棋</span>
      </a>

      <a class="lis0 zanweikaifang" href="javascript:;">
        <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/zhajinhua.png" alt="" width="50">
        <span>炸金花</span>
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