<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<?php  if($op ==1 && $type==1) { ?>   <!-- 卖出订单   挂卖人进入 -->
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

      <div class="buyBtn">确定收款</div>
      <div class="Btn_on">申诉</div>


    </div>



  </div>
</div>

<script type="text/javascript">
  $('.buyBtn').click(function () {
    let id = "<?php  echo $sell['id'];?>";
    $.ajax({
      type:'post',
      url:"<?php  echo mobileurl('member/guamai/selloutyes')?>",
      data:{selloutyes:id,type:1},
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
  })
</script>

<?php  } else if($op ==1 && ($type==2 || !$type)) { ?>     <!-- 卖出订单   抢单人进入 -->
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

  #zfselect {
    border: 0;
    outline-style: none;
    padding: 5px;
    width: 70%;
    box-sizing: border-box;
  }

  .ewmBox {
    padding: 1rem;
    display: none;
  }

  .ewmBox>.ewmImg {
    width: 80%;
    margin: 0 10%;
  }

  .ewmBox>.ewmTie {
    text-align: center;
  }

  .bankBox {
    padding: .5rem;
    margin-top: .5rem;
    border: 1px solid #666;
    /* display: none; */
  }

  .bankBox>.bankBoxTie {
    text-align: center;
    color: red;
  }

  .bankBox>p {
    font-size: .8rem;
  }

  .setImg {
    padding: .5rem 0;
  }

  .setImgBox {
    width: 100%;
    height: 6rem;
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
    width: 54%;
    height: 100%;
    position: absolute;
    left: 3.4rem;
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
  #imgFile0{
    opacity: 0;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
  }
  .disable{
    pointer-events: none;
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
      <p>需付款：<?php  echo $sell['money'];?> </p>
      <p>付款人：<?php  echo $sell['nickname2'];?> </p>
      <div class="zfBox">
        <span>支付方式：</span>
        <select name="zfselect" id="zfselect">
          <?php  if(is_array($payment)) { foreach($payment as $itme) { ?>
          <option value="<?php  echo $itme['type'];?>" <?php  if($itme['type']=='bank') { ?> selected <?php  } ?> ><?php  echo $itme['name'];?></option>
          <?php  } } ?>
        </select>
      </div>
      <div class="ewmBox">
        <div class="ewmTie">请扫描二维码完成支付</div>
        <img src="<?php  echo $sell['wxfile'];?>" alt="" class="ewmImg wxewm">
        <img src="<?php  echo $sell['zfbfile'];?>" alt="" class="ewmImg zfbewm">
      </div>
      <div class="bankBox">
        <div class="bankBoxTie">*请前往当地银行打款</div>
        <p>银行：<?php  echo $sell['bank'];?></p>
        <p>户主：<?php  echo $sell['bankname'];?></p>
        <p>卡号：<?php  echo $sell['bankid'];?></p>

      </div>

      <div class="setImg">
        <p>上传凭证：</p>
        <div class="setImgBox">
          <span>点击上传凭证</span>
          <img src="<?php  echo $sell['file'];?>" alt="" class="pic">
          <input type="file" name='imgFile0' id='imgFile0'/>
          <input  type="hidden" id="avatar"/>
        </div>
      </div>

      <?php  if($sell['file'] == '') { ?>
      <div class="buyBtn">确定</div>
      <?php  } else { ?>
      <div class="buyBtn">确定更改</div>
      <?php  } ?>

    </div>
    <div class="Btn_on">申诉</div>


  </div>
</div>

<script src="../addons/ewei_shopv2/static/js/dist/ajaxfileupload.js" type="text/javascript"></script>
<script type="text/javascript">

  // 提交js
  $('.buyBtn').click(function () {
    $(this).addClass('disable');

    if($('#zfselect').val() == 0 || $('#zfselect').val() == ''){
      alert('请选择支付方式！');
      $('.buyBtn').removeClass('disable');
      return
    }else if($('#avatar').val() == ''){
      alert('请上传支付凭证！');
      $('.buyBtn').removeClass('disable');
      return
    }else{
      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/sellout')?>",
        data:{id:"<?php  echo $sell['id'];?>",mobile:"<?php  echo $sell['mobile'];?>",file:$('#avatar').val(),type:1},
        dataType:'json',
        success:function(data){
          console.log(data);
          alert(data.result.message);
          history.back(-1);
          $('.buyBtn').removeClass('disable');

        },error:function(err){
          console.log(err);
          $('.buyBtn').removeClass('disable');

        }
      })
    }
  })

  $('#zfselect').change(function () {
    let val = $(this).val();
    console.log(val);
    if (val == 'bank') {
      $('.bankBox').css('display', 'block');
      $('.ewmBox').css('display', 'none');
    } else if (val == 'wx') {
      $('.bankBox').css('display', 'none');
      $('.ewmBox').css('display', 'block');
      $('.wxewm').css('display', 'block');
      $('.zfbewm').css('display', 'none');
    } else if (val == 'zfb') {
      $('.bankBox').css('display', 'none');
      $('.ewmBox').css('display', 'block');
      $('.wxewm').css('display', 'none');
      $('.zfbewm').css('display', 'block');
    } else if (val == 0) {
      $('.bankBox').css('display', 'none');
      $('.ewmBox').css('display', 'none');
    }

  })

</script>

<script language="javascript">
  require(['tpl', 'core'], function (tpl, core) {

        /*图片上传*/
        $('#imgFile0').change(function () {
          var comment = $(this).closest('.comment_main');
          var ogid = comment.data('ogid');

          $.ajaxFileUpload({
            url: core.getUrl('util/uploader'),
            data: { file: "imgFile0" },
            secureuri: false,
            fileElementId: 'imgFile0',
            dataType: 'json',
            success: function (res, status) {
              $('.pic').attr('src', res.url);
              $('#avatar').val(res.url);

            }, error: function (data, status, e) {

            }
          });
        });
        /*图片上传*/



  })
</script>
<?php  } else if($op ==0 && $type==1) { ?>     <!-- 买入订单   挂卖人进入 -->
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

  #zfselect {
    border: 0;
    outline-style: none;
    padding: 5px;
    width: 70%;
    box-sizing: border-box;
  }

  .ewmBox {
    padding: 1rem;
    display: none;
  }

  .ewmBox>.ewmImg {
    width: 80%;
    margin: 0 10%;
  }

  .ewmBox>.ewmTie {
    text-align: center;
  }

  .bankBox {
    padding: .5rem;
    margin-top: .5rem;
    border: 1px solid #666;
    /* display: none; */
  }

  .bankBox>.bankBoxTie {
    text-align: center;
    color: red;
  }

  .bankBox>p {
    font-size: .8rem;
  }

  .setImg {
    padding: .5rem 0;
  }

  .setImgBox {
    width: 100%;
    height: 6rem;
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
    height: 100%;
    position: absolute;
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
  #imgFile0{
    opacity: 0;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
  }
  .disable{
    pointer-events: none;
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
      <p>需付款：<?php  echo $sell['money'];?> </p>
      <p>收款人:<?php  echo $sell['nickname2'];?> </p>
      <div class="zfBox">
        <span>支付方式：</span>
        <select name="zfselect" id="zfselect">
          <?php  if(is_array($payment)) { foreach($payment as $itme) { ?>
          <option value="<?php  echo $itme['type'];?>" <?php  if($itme['type']=='bank') { ?> selected <?php  } ?> ><?php  echo $itme['name'];?></option>
          <?php  } } ?>
        </select>
      </div>
      <div class="ewmBox">
        <div class="ewmTie">请扫描二维码完成支付</div>
        <img src="<?php  echo $sell['wxfile2'];?>" alt="" class="ewmImg wxewm">
        <img src="<?php  echo $sell['zfbfile2'];?>" alt="" class="ewmImg zfbewm">
      </div>
      <div class="bankBox">
        <div class="bankBoxTie">*请前往当地银行打款</div>
        <p>银行：<?php  echo $sell['bank2'];?></p>
        <p>户主：<?php  echo $sell['bankname2'];?></p>
        <p>卡号：<?php  echo $sell['bankid2'];?></p>

      </div>

      <div class="setImg">
        <p>上传凭证：</p>
        <div class="setImgBox">
          <span>点击上传凭证</span>
          <img src="<?php  echo $sell['file'];?>" alt="" class="pic">
          <input type="file" name='imgFile0' id='imgFile0'/>
          <input  type="hidden" id="avatar"/>
        </div>
      </div>

      <?php  if($sell['file'] == '') { ?>
      <div class="buyBtn">确定</div>
      <?php  } else { ?>
      <div class="buyBtn">确定更改</div>
      <?php  } ?>

    </div>
    <div class="Btn_on">申诉</div>


  </div>
</div>

<script src="../addons/ewei_shopv2/static/js/dist/ajaxfileupload.js" type="text/javascript"></script>
<script type="text/javascript">

  // 提交js
  $('.buyBtn').click(function () {
    $(this).addClass('disable');

    if($('#zfselect').val() == 0 || $('#zfselect').val() == ''){
      alert('请选择支付方式！');
      $('.buyBtn').removeClass('disable');
      return
    }else if($('#avatar').val() == ''){
      alert('请上传支付凭证！');
      $('.buyBtn').removeClass('disable');
      return
    }else{

       $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/sellout')?>",
        data:{id:"<?php  echo $sell['id'];?>",file:$('#avatar').val(),type:0,op:"1"},
        dataType:'json',
        success:function(data){
          console.log(data);
          alert(data.result.message);
          history.back(-1);
          $('.buyBtn').removeClass('disable');

        },error:function(err){
          console.log(err);
          $('.buyBtn').removeClass('disable');

        }
      })
    }
  })

  $('#zfselect').change(function () {
    let val = $(this).val();
    console.log(val);
    if (val == 'bank') {
      $('.bankBox').css('display', 'block');
      $('.ewmBox').css('display', 'none');
    } else if (val == 'wx') {
      $('.bankBox').css('display', 'none');
      $('.ewmBox').css('display', 'block');
      $('.wxewm').css('display', 'block');
      $('.zfbewm').css('display', 'none');
    } else if (val == 'zfb') {
      $('.bankBox').css('display', 'none');
      $('.ewmBox').css('display', 'block');
      $('.wxewm').css('display', 'none');
      $('.zfbewm').css('display', 'block');
    } else if (val == 0) {
      $('.bankBox').css('display', 'none');
      $('.ewmBox').css('display', 'none');
    }

  })

</script>

<script language="javascript">
  require(['tpl', 'core'], function (tpl, core) {

        /*图片上传*/
        $('#imgFile0').change(function () {
          var comment = $(this).closest('.comment_main');
          var ogid = comment.data('ogid');

          $.ajaxFileUpload({
            url: core.getUrl('util/uploader'),
            data: { file: "imgFile0" },
            secureuri: false,
            fileElementId: 'imgFile0',
            dataType: 'json',
            success: function (res, status) {
              $('.pic').attr('src', res.url);
              $('#avatar').val(res.url);

            }, error: function (data, status, e) {

            }
          });
        });
        /*图片上传*/



  })
</script>

<?php  } else if($op ==0 && $type==2) { ?>     <!-- 买入订单   抢单人人进入 -->
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
        <p style="margin-top:10px">收款人：<?php  echo $sell['nickname2'];?> </p>
        <div class="zfBox">
          <!-- <span>支付方式：</span>
          <p>微信</p> -->
        </div>


        <div class="setImg">
          <p>支付凭证：</p>
          <div class="setImgBox">
            <?php  if($sell['file'] == '') { ?>
            <span style="height:6rem">未上传支付凭证</span>
            <?php  } else { ?>
            <img src="<?php  echo $sell['file'];?>" alt="" class="pic">
            <?php  } ?>
          </div>
        </div>

        <div class="buyBtn">确定收款</div>



      </div>
      <div class="Btn_on">申诉</div>



    </div>
  </div>

  <script type="text/javascript">
    $('.buyBtn').click(function () {
      let id = "<?php  echo $sell['id'];?>";
      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/selloutyes')?>",
        data:{selloutyes:id,type:0},
        dataType:'json',
        success:function(data){
          console.log(data);
          if(data.status == 1){
            alert(data.result.message);
            history.back(-1);
          }
          if(data.status == 2){
            alert(data.result.message);
            history.back(1);
          }


        },error:function(err){
          console.log(err);

        }
      })
    });
  </script>
<?php  } ?>
<script>
$('.Btn_on').click(function () {
  let id = "<?php  echo $sell['id'];?>";
  $.ajax({
    type:'post',
    url:"<?php  echo mobileurl('member/guamai/tab_con')?>",
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
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
