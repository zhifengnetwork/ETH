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
    .se_tank{width: 100%;height: 0rem;background: #0a181f;position: absolute;bottom: 2.45rem;transition: all 1s;}
    .se_title{margin-top: 2.5rem;margin-left: 0.3rem;}
    .se_title span{font-size: 0.7rem;color: #fff;}
    .se_title input{width: 70%;height: 1.5rem;border: none;outline: none;border-radius: 0.2rem;padding-left: 0.2rem;}
	.se_tank h2{font-size: 0.8rem;color: #fff;font-weight: inherit;line-height: 2.5rem;}
	.se_tank_span{position: absolute;top: 5%;right: 5%;color: #fff;font-size: 0.8rem;}
	.se_tank_con{margin-top: 0.7rem;margin-left: 0.3rem;}
	.se_tank_con textarea{border-radius: 0.2rem; width: 70%;height: 5rem;resize: none;border: none;padding: 0.3rem;font-size: 0.65rem;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}
	.se_tank_con p{font-size: 0.7rem;color: #fff;display: inline-block;vertical-align:top;}
	.se_tank_btn{width: 68.5%;height: 3.5rem;line-height: 2.5rem;margin-left: 22%;}
	.se_tank_btn button{width: 100%;height: 1.6rem;background: #0a0;border: none;color: #fff;border-radius: 0.2rem;}
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
        <div class="Btn_on">申诉</div>
      </div>
    </div>

    <div class="se_tank">
    	<span class="se_tank_span">收起</span>
    	<div class="se_title">
    		<span>申诉标题:</span>
    		<input class="text" name="text" type="text" />
    	</div>
    	<div class="se_tank_con">
    		<p>申诉内容:</p>
    		<textarea class="textarea"></textarea>
    	</div>
    	<div class="se_tank_btn">
    		<a><button class="button">确定</button></a>
    	</div>
    </div>
  </div>



  <script>
    $('.Btn_on').click(function () {
    	$(".se_tank").css('height','13rem');
    });
    $(".se_tank_span").click(function(){
    	$(".se_tank").css('height',0);
    })
    $(".button").click(function(){
      let id = "<?php  echo $sell['id'];?>";
      let text = $(".text").val();
      let textarea = $(".textarea").val();
      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/tab_con')?>",
        data:{id:id,text:text,textarea:textarea},
        dataType:'json',
        success:function(data){
          console.log(data);
          if(data.status == 1){
            alert(data.result.message);
            // history.back(-1);
            $(".se_tank").css('height',0);
          }
        },error:function(err){
          console.log(err);
        }
      })
    });
  </script>

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
        <!-- <div class="Btn_on">申诉</div> -->
      </div>
    </div>
  </div>
<?php  } ?>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
