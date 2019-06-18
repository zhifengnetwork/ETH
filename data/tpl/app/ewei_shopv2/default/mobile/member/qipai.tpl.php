<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
  .fui-content{
    background-color: #0d1438;
  }
  .uls{
    display: flex;
    flex-wrap: wrap;
    margin: 1rem;
  }
  .lis{
    width: 100%;
    color: #fff;
    display: flex;
    align-items: center;
    color: #fff;
    justify-content: space-between;
    margin: 10px auto;
        height: 7.5rem;
  }
  .lis > span{
        margin-top: 5px;
  }

</style>

<div class='fui-page  fui-page-current member-log-page'>

  <div class="fui-header">
    <div class="fui-header-left">
      <a class="back"></a>
    </div>
    <div class="title">游戏大全</div>
    <div class="fui-header-right">
      <i class="icon icon-add4"></i>
    </div>
  </div>

  <div class='fui-content navbar'>
    <ul class="uls">
      <!-- <?php  echo mobileUrl('member/lottery')?> -->
      <a class="lis zanweikaifang" href="">
          <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/3D0.png" alt="" width="65%" height="100%">
          <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/3D1.png" alt="" width="30%" height="100%">
      </a>

      <a class="lis" href="<?php  echo mobileUrl('qipaiyule/xiuxian')?>">
          <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/xiuxian0.png" alt="" width="65%" height="100%">
          <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/xiuxian1.png" alt="" width="30%" height="100%">
      </a>

      <a class="lis" href="<?php  echo mobileUrl('qipaiyule/qipai')?>">
          <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/qipai0.png" alt="" width="65%" height="100%">
          <img src="<?php  echo EWEI_SHOPV2_LOCAL?>static/icon/qipai1.png" alt="" width="30%" height="100%">
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