<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<?php  if($status==2) { ?>   <!-- 卖出订单   挂卖人进入 -->
<style>
    .fui-header {
      background: #0a181f;
    }

    .fui-header .title {
      color: #fff;
    }

    .fui-header a.back:before {
      border-color: #fff;
    }

    .txtInfo {
      padding: .5rem;
      font-size: .8rem;
    }
    .zfBox {
      display: flex;
      align-items: center;
    }
    .setImg {
      padding: .5rem 0;
    }

    .setImgBox {
      width: 100%;
      border: 1px solid #666;
      position: relative;
    }

    .setImgBox>span {
      width: 100%;
      display: block;
      ;
      line-height: 6rem;
      text-align: center;
    }

    .setImgBox>.pic {
      width: 100%;
      left: 0;
      top: 0;
    }
    .buyBtn {
      width: 80%;
      color: #fff;
      background-color: #0a0;
      text-align: center;
      padding: 10px 0;
      border-radius: .5rem;
      margin: 1rem auto 0;
    }
    .Btn_on {
      width: 80%;
      color: #fff;
      background-color: #0a0;
      text-align: center;
      padding: 10px 0;
      border-radius: .5rem;
      margin: 1rem auto 0;
    }
</style>

  <div class='fui-page  fui-page-current member-log-page'>
    <div class="fui-header">
      <div class="fui-header-left">
        <a class="back"></a>
      </div>
      <!-- <?php  if($op == 1) { ?>
      <div class="title">卖出ETH</div>
      <?php  } else if($op == 0) { ?>
      <div class="title">买入ETH</div>
      <?php  } ?> -->
      <?php  if($openid == $sell['openid2']) { ?>
        <?php  if($op == 1) { ?>
        <div class="title">买入ETH</div>
        <?php  } else if($op == 0) { ?>
        <div class="title">卖出ETH</div>
        <?php  } ?>
      <?php  } else { ?>
        <?php  if($op == 1) { ?>
        <div class="title">卖出ETH</div>
        <?php  } else if($op == 0) { ?>
        <div class="title">买入ETH</div>
        <?php  } ?>
      <?php  } ?>
      <div class="fui-header-right">
      </div>
    </div>
    <div class='fui-content navbar'>
      <div class="txtInfo">
          <p>订单号：<?php  echo $sell['id'];?> </p>
        <?php  if($op == 1) { ?>
        <p>挂卖人：<?php  echo $sell['mobile'];?> </p>
        <?php  } else if($op == 0) { ?>
        <p>挂买人：<?php  echo $sell['mobile2'];?> </p>
        <?php  } ?>
        <p>挂卖单价：<?php  echo $sell['price'];?> </p>
        <p>挂卖数量：<?php  echo $sell['trx'];?> </p>
        <p>待收款：<?php  echo $sell['money'];?> </p>
        <?php  if($op == 1) { ?>
        <p style="margin-top:10px">付款人：<?php  echo $sell['mobile2'];?> </p>
        <?php  } else if($op == 0) { ?>
        <p style="margin-top:10px">收款人：<?php  echo $sell['mobile'];?> </p>
        <?php  } ?>
        <div class="zfBox">
        </div>
        <div class="setImg">
          <p>支付凭证：</p>
          <div class="setImgBox">
            <?php  if($sell['file'] == '') { ?>
            <span style="height:6rem">未上传支付方式</span>
            <?php  } else { ?>
            <img src="<?php  echo $sell['file'];?>" alt="" class="pic">
            <?php  } ?>
          </div>
        </div>
        <a href="<?php  echo mobileurl('member/guamai/appeal')?>&id=<?php  echo $sell['id'];?>">
          <div class="Btn_on">申诉</div>
        </a>
      </div>
    </div>
  </div>

<?php  } else if($status==0) { ?>     <!-- 买入订单   挂卖人进入 -->
<style>
    .fui-header {
      background: #0a181f;
    }

    .fui-header .title {
      color: #fff;
    }

    .fui-header a.back:before {
      border-color: #fff;
    }

    .txtInfo {
      padding: .5rem;
      font-size: .8rem;
    }
    .zfBox {
      display: flex;
      align-items: center;
    }
    .setImg {
      padding: .5rem 0;
    }

    .setImgBox {
      width: 100%;
      border: 1px solid #666;
      position: relative;
    }

    .setImgBox>span {
      width: 100%;
      display: block;
      ;
      line-height: 6rem;
      text-align: center;
    }

    .setImgBox>.pic {
      width: 100%;
      left: 0;
      top: 0;
    }
    .buyBtn {
      width: 80%;
      color: #fff;
      background-color: #0a0;
      text-align: center;
      padding: 10px 0;
      border-radius: .5rem;
      margin: 1rem auto 0;
    }
    .Btn_on {
      width: 80%;
      color: #fff;
      background-color: #0a0;
      text-align: center;
      padding: 10px 0;
      border-radius: .5rem;
      margin: 1rem auto 0;
    }

  </style>

  <div class='fui-page  fui-page-current member-log-page'>

    <div class="fui-header">
      <div class="fui-header-left">
        <a class="back"></a>
      </div>
      <!-- <?php  if($op == 1) { ?>
      <div class="title">卖出ETH</div>
      <?php  } else if($op == 0) { ?>
      <div class="title">买入ETH</div>
      <?php  } ?> -->
      <?php  if($openid == $sell['openid']) { ?>
        <?php  if($op == 1) { ?>
        <div class="title">买入ETH</div>
        <?php  } else if($op == 0) { ?>
        <div class="title">卖出ETH</div>
        <?php  } ?>
      <?php  } else { ?>
        <?php  if($op == 1) { ?>
        <div class="title">卖出ETH</div>
        <?php  } else if($op == 0) { ?>
        <div class="title">买入ETH</div>
        <?php  } ?>
      <?php  } ?>
      <div class="fui-header-right">
      </div>
    </div>

    <div class='fui-content navbar'>
      <div class="txtInfo">
          <p>订单号：<?php  echo $sell['id'];?> </p>
        <p>挂卖人：<?php  echo $sell['mobile'];?> </p>
        <p>挂卖单价：<?php  echo $sell['price'];?> </p>
        <p>挂卖数量：<?php  echo $sell['trx'];?> </p>
         <p>待付款：<?php  echo $sell['money'];?> </p>
        <div class="buyBtn">未交易是否取消</div>
      </div>
    </div>
  </div>
  <script>
    $('.buyBtn').click(function () {
      let id = "<?php  echo $sell['id'];?>";
      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/sellout_tab_con')?>",
        data:{id:id},
        dataType:'json',
        success:function(data){
          console.log(data);
          if(data.status == 1){
            alert(data.result.message);
            history.back(-1);
          }

        },error:function(err){
          console.log(err);

        }
      })
  });
  </script>
  <?php  } else if($status==3) { ?>
  <style>
    .fui-header {
      background: #0a181f;
    }

    .fui-header .title {
      color: #fff;
    }

    .fui-header a.back:before {
      border-color: #fff;
    }

    .txtInfo {
      padding: .5rem;
      font-size: .8rem;
    }
    .zfBox {
      display: flex;
      align-items: center;
    }
    .setImg {
      padding: .5rem 0;
    }

    .setImgBox {
      width: 100%;
      border: 1px solid #666;
      position: relative;
    }

    .setImgBox>span {
      width: 100%;
      display: block;
      ;
      line-height: 6rem;
      text-align: center;
    }

    .setImgBox>.pic {
      width: 100%;
      left: 0;
      top: 0;
    }
    .buyBtn {
      width: 80%;
      color: #fff;
      background-color: #0a0;
      text-align: center;
      padding: 10px 0;
      border-radius: .5rem;
      margin: 1rem auto 0;
    }
    .Btn_on {
      width: 80%;
      color: #fff;
      background-color: #0a0;
      text-align: center;
      padding: 10px 0;
      border-radius: .5rem;
      margin: 1rem auto 0;
    }

  </style>

  <div class='fui-page  fui-page-current member-log-page'>
    <div class="fui-header">
      <div class="fui-header-left">
        <a class="back"></a>
      </div>
      <!-- <?php  if($op == 1) { ?>
      <div class="title">卖出ETH</div>
      <?php  } else if($op == 0) { ?>
      <div class="title">买入ETH</div>
      <?php  } ?> -->
      <?php  if($openid == $sell['openid2']) { ?>
        <?php  if($op == 1) { ?>
        <div class="title">买入ETH</div>
        <?php  } else if($op == 0) { ?>
        <div class="title">卖出ETH</div>
        <?php  } ?>
      <?php  } else { ?>
        <?php  if($op == 1) { ?>
        <div class="title">卖出ETH</div>
        <?php  } else if($op == 0) { ?>
        <div class="title">买入ETH</div>
        <?php  } ?>
      <?php  } ?>
      <div class="fui-header-right">
      </div>
    </div>
    <div class='fui-content navbar'>
      <div class="txtInfo">
          <p>订单号：<?php  echo $sell['id'];?> </p>
        <?php  if($op == 1) { ?>
        <p>挂卖人：<?php  echo $sell['mobile'];?> </p>
        <?php  } else if($op == 0) { ?>
        <p>挂买人：<?php  echo $sell['mobile2'];?> </p>
        <?php  } ?>
        <p>挂卖单价：<?php  echo $sell['price'];?> </p>
        <p>挂卖数量：<?php  echo $sell['trx'];?> </p>
        <p>待收款：<?php  echo $sell['money'];?> </p>
        <?php  if($op == 1) { ?>
        <p style="margin-top:10px">付款人：<?php  echo $sell['mobile2'];?> </p>
        <?php  } else if($op == 0) { ?>
        <p style="margin-top:10px">收款人：<?php  echo $sell['mobile'];?> </p>
        <?php  } ?>
        <div class="zfBox">
        </div>
        <div class="setImg">
          <p>支付凭证：</p>
          <div class="setImgBox">
            <?php  if($sell['file'] == '') { ?>
            <span style="height:6rem">未上传支付方式</span>
            <?php  } else { ?>
            <img src="<?php  echo $sell['file'];?>" alt="" class="pic">
            <?php  } ?>
          </div>
        </div>
        <?php  if($sell['file'] == '') { ?>

        <?php  } else { ?>
        <a href="<?php  echo mobileurl('member/guamai/appeal')?>&id=<?php  echo $sell['id'];?>">
          <div class="Btn_on">申诉</div>
        </a>
        <?php  } ?>
        <!-- <div class="Btn_on">申诉</div> -->
      </div>
    </div>
  </div>
<?php  } ?>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
