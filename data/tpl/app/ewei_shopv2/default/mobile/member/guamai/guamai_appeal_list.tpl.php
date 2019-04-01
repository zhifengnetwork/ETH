<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
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
        <div class="title">申诉详情</div>
      <div class="fui-header-right">
      </div>
    </div>
    <div class='fui-content navbar'>
      <div class="txtInfo">
        <p>申诉问题：<?php  echo $guamai_appeal['order_id'];?></p>
        <p>申诉原因：<?php  echo $guamai_appeal['text'];?> </p>
        <p>申诉订单：<?php  echo $guamai_appeal['textarea'];?> </p>
        <p>申诉人：<?php  echo $users['mobile'];?> </p>
        <?php  if($guamai_appeal['openid'] == $users['openid']) { ?>
        <p>被申诉人：<?php  echo $guamai_appeal['openid2'];?> </p>
        <?php  } else { ?>
        <p>被申诉人：<?php  echo $guamai_appeal['openid2'];?> </p>
        <?php  } ?>
        <p>ETH数量：<?php  echo $guamai_appeal['trx'];?> </p>
        <p>CNY数量：<?php  echo $guamai_appeal['money'];?> </p>
        <?php  if($guamai_appeal['stuas'] == 0) { ?>
        <p>是否审核：申诉中 </p>
        <?php  } else if($guamai_appeal['stuas'] == 1) { ?>
        <p>是否审核：申诉成功 </p>
        <?php  } else if($guamai_appeal['stuas'] == 2) { ?>
        <p>是否审核：申诉失败 </p>
        <?php  } else if($guamai_appeal['stuas'] == 3) { ?>
        <p>是否审核：申诉无效 </p>
        <?php  } ?>
        <div class="zfBox">
        </div>
        <div class="setImg">
          <p>支付凭证：</p>
          <div class="setImgBox">
            <?php  if($guamai_appeal['file'] == '') { ?>
            <span style="height:6rem">未上传支付方式</span>
            <?php  } else { ?>
            <img src="<?php  echo $guamai_appeal['file'];?>" alt="" class="pic">
            <?php  } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
