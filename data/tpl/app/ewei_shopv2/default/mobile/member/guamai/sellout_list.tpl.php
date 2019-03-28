<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<?php  if($type==1) { ?>   <!-- 卖出订单   挂卖人进入 -->
2342341111
<?php  } else if($type==0) { ?>     <!-- 买入订单   挂卖人进入 -->
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
      <?php  if($op == 1) { ?>
      <div class="title">卖出TRX</div>
      <?php  } else if($op == 0) { ?>
      <div class="title">买入TRX</div>
      <?php  } ?>
      <div class="fui-header-right">
      </div>
    </div>

    <div class='fui-content navbar'>
      <div class="txtInfo">
        <p>挂卖人：<?php  echo $sell['nickname'];?> </p>
        <p>挂卖单价：<?php  echo $sell['price'];?> </p>
        <p>挂卖数量：<?php  echo $sell['trx'];?> </p>
        <p>待收款：<?php  echo $sell['money'];?> </p>
        <p style="margin-top:10px">付款人：<?php  echo $sell['nickname2'];?> </p>
        <div class="zfBox">
          <!-- <span>支付方式：</span>
          <p>微信</p> -->
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
        <div class="buyBtn">未交易</div>
      </div>
    </div>
  </div>
<?php  } ?>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
