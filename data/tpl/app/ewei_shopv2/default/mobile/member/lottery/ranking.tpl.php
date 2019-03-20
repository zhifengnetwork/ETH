<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>
  .lis {
    display: flex;
    align-items: center;
    margin: .5rem 0;
  }

  .lis>span {
    text-align: center;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .lis>span:nth-child(1) {
    width: 15%;
  }

  .lis>span:nth-child(2) {
    width: 10%;
  }

  .lis>span:nth-child(3) {
    width: 20%;
  }

  .lis>span:nth-child(4) {
    width: 30%;
  }

  .lis>span:nth-child(5) {
    width: 25%;
    color: #be2120;
  }
  .lis .lis_img{
    width: 50px;
    height: 50px;
    border-radius: 50%;
  }
  .zanwu{
    text-align: center;
    padding-top: 3rem;
    color: #ccc;
    display: none;
  }
</style>

<div class='fui-page  fui-page-current'>

  <div class="fui-header">
    <div class="fui-header-left">
      <a class="back" onclick='location.back()'></a>
    </div>
    <div class="title">投资排行</div>
    <div class="fui-header-right">&nbsp;</div>
  </div>

  <div class='fui-content navbar'>

    <div class="bg">
      <img src="../addons/ewei_shopv2/static/images/touzhiBg.png" alt="" width="100%">
    </div>

    <?php  if($investment == '') { ?>
    <p style="color: red;text-align: center;font-size: 1rem;font-weight: 600;">投资总额: <?php  echo $sale['sum'];?></p>
    <?php  } ?>

    <ul>
      <li class="lis">
        <span>排名</span>
        <span>ID</span>
        <span>昵称</span>
        <span>预计获奖</span>
        <span style="font-size: .6rem;">今日投资金额<br>(TRX)</span>
      </li>

      <?php  if(is_array($investment)) { foreach($investment as $val) { ?>
      <li class="lis" style="font-size:.6rem">
        <span>第<?php  echo $val['type'];?>名</span>
        <span>
          <?php  echo $val['id'];?>
          <!-- <img src="<?php  echo tomedia($val['avatar'])?>" alt="" class="lis_img" onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"> -->
        </span>
        <span><?php  echo $val['nickname'];?></span>
        <span><?php  echo $val['yuji'];?> <span style="color:red">(<?php  echo $val['bfb'];?>%)</span> </span>
        <span><?php  echo $val['moneys'];?></span>
      </li>
      <?php  } } ?>
    </ul>

    <div class="zanwu">
      <i class="icon icon-cry" style="font-size: 4rem;"></i>
      <p style="font-size: 1rem;">今日暂无排行</p>
    </div>



  </div>


</div>

<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
  $(function () {
    if($('.lis').length <= 1){
      $('ul').css('display','none');
      $('.zanwu').css('display','block');
    }
  })
</script>