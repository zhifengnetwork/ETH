<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>
  #tab > a{
    flex: 1;
  }
  .mydingdan{
    flex: 1;
    color: #fff;
    text-align: center;
    line-height: 40px;
  }

  .fui-header {
    background: #0a181f;
    color: #fff;
  }

  .fui-header .title {
    color: #fff;
  }

  .fui-header a.back:before {
    border-color: #fff;
  }

  .fui-header-right>.icon-add4 {
    font-size: 22px;
  }

  .fui-tab {
    background: #0a181f;
  }

  .fui-tab.fui-tab-danger a.active {
    color: #F0E68C;
    border-color: #F0E68C;
  }

  .fui-tab a {
    color: #fff;
  }

  .fui-tab-o,
  .fui-tab {
    margin-bottom: 0;
  }

  .fui-list-group {
    margin-top: 0;
  }

  .lis {
    background-color: #061016;
    padding: 10px 20px;
    position: relative;
    border-bottom: 1px solid #666;
  }

  .lis_lie {
    display: flex;
    color: #fff;
  }

  .lis_lie0 {
    justify-content: space-between;
  }

  .lis_lie0>span {
    font-size: 16px;
    color: #9f2332;
    width: 22%;

  }

  .lis_lie0>p {
    color: #ffffff;
  }

  .lis_lie0>p>i {
    color: #fff;
    font-size: 18px;
  }

  .lis_lie1 {
    font-size: 16px;
  }

  .lis_lie2 {
    color: #666;
  }

  .maiRu_btn {
    background-color: #429547;
    color: #fff;
    border-radius: 2px;
    position: absolute;
    right: 20px;
    bottom: 5px;
    width: 25%;
    padding: 5px 0;
    text-align: center;
  }

  .maiChu_btn  {background-color: #a02332;}
  .maiChu_btn {
    background-color: #a02332;
    color: #fff;
    border-radius: 2px;
    position: absolute;
    right: 20px;
    bottom: 5px;
    width: 25%;
    padding: 5px 0;
    text-align: center;
  }
    .mask1_btn{
      width: 100%;
      text-align: center;
      height: 30px;
      line-height: 30px;
      background-color: #0a0;
      margin: 10px 0 20px;
    }
    .mask1 > .mask1_lis{
      display: flex;
      background-color: #fff;
      color: #000;
      padding: 5px 10px;
      align-items: center;
    }
    .mask1 > .mask1_lis > .buyNum{
      border: 0;
      outline-style: none;
      width: 70%;
    }
    .mask1 > .mask1_lis > .allBuy{
      width: 30%;
    }
    .mask1 > .mask1_lis > .allBuy > span{
      color: #c2a378;
    }
    .mask1 > p{
      padding: 5px 0;
    }
    .mask1 > .mask_tit{
      margin-top: 10px;
      font-size: 16px;
      text-align: center;
      color: #c2a378;
    }
    .mask1 >.mask1_pice{
      display: flex;
    }
    .mask1 >.mask1_pice > p{
        width: 20%;
        text-align: center;
    }
    .maiRu_price{
      padding: 5px 10px;
      width: 80%;
      border: 0;
      outline-style: none;
    }
    .mask1{
      background-color: #0e222d;
      position: fixed;
      width: 100%;
      bottom: 0;
      left: 0;
      z-index: 9;
      color: #fff;
      padding: 0 20px;
    }
    .mask0 {
      background-color: #0e222d;
      position: fixed;
      width: 100%;
      bottom: 0;
      left: 0;
      z-index: 9;
      color: #fff;
      padding: 0 20px;
    }
    .mask0 > .mask_tit {
      margin-top: 10px;
      font-size: 16px;
      text-align: center;
      color: #c2a378;
    }

    .mask0 > .mask_lis>input {
      width: 100%;
      padding: 5px 10px;
    }

    .tishi {
      text-align: right;
      color: #888;
      font-size: 12px;
      padding: 3px 0;
      border-bottom: 1px solid #666;
    }

    .mask0_btn {
      width: 100%;
      text-align: center;
      height: 30px;
      line-height: 30px;
      background-color: #0a0;
      margin: 20px 0;
    }
  .disable{
    pointer-events: none;
  }
  .lj_plane{width: 20px;height: 20px;padding-top: 3px;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}
	.fui-header-right i{display: inline-block;}
</style>

<div class='fui-page  fui-page-current member-log-page'>

  <div class="fui-header">

    <div class="fui-header-left">

      <a class="back"></a>

    </div>

    <div class="title">ETH/CNY</div>
    <div class=""></div>
    <div class="fui-header-right" data-type="0">
    	<!----飞机图标---->
    	<i><a href="<?php  echo mobileurl('member/guamai/number_order')?>"><img class="lj_plane" src="../addons/ewei_shopv2/static/images/zhifeng/plane.png" /></a></i>
      <!----加号图标----->
      <!-- <i class="fui-header-rig icon icon-add4"></i> -->
    </div>
  </div>

  <div class='fui-content navbar' style="background-color:#0a181f">



    <?php  if($_W['shopset']['trade']['withdraw']) { ?>

    <div id="tab" class="fui-tab fui-tab-danger">

      <a data-tab="tab1" class="tab1 external <?php  if($type == 0) { ?>active<?php  } ?>" data-type='0'>买入</a>

      <a data-tab="tab2" class='tab2 external <?php  if($type == 1) { ?>active<?php  } ?>' data-type='1'>卖出</a>

     <!-- <span onclick="location.href='<?php  echo mobileurl('member/guamai/guamaijilu')?>'" class="mydingdan">我的订单</span> -->

    </div>

    <?php  } ?>


    <div class='content-empty' style='display:none;'>

      <i class='icon icon-searchlist'></i><br />暂时没有任何记录!

    </div>



    <div class='fui-list-group container' style="display:none;">

    </div>

    <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>

  </div>
  <!-- 买入模板 -->
  <script id="tpl_maichu" type="text/html">
      <ul>
      <% each list as val %>
        <li class="lis">
          <p style="color: #fff;">挂卖编号：<% val.id %> </p>
          <div class="lis_lie lis_lie0">
            <p>挂单人:  <% val.nickname %>　
              <% if val.zfbfile==1 %> <i class="icon icon-alipay"></i> <% /if %>
              <% if val.wxfile==1 %> <i class="icon icon-wechat1"></i> <% /if %>
              <% if val.bank==1 %> <i class="icon icon-vipcard"></i> <% /if %>
            </p>
            <span>￥<% val.price %> </span>
          </div>
          <% if val.openid2 != '' %>
          <p style="color:#c2a378">抢单人：<% val.nickname2 %></p>
          <% /if %>
          <div class="lis_lie lis_lie1">挂单数量 <% val.trx %></div>
          <!-- <div class="lis_lie lis_lie2">限额 2800.0-2800.0 UES</div> -->
          <!-- <% if val.status == 0 %>
          <div class="maiRu_btn" data-id='<% val.id %>' <% if val.self == 1 %> onclick="alert('不能买入自己发放的账单')"<% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"<% else %> onclick="location.href='<?php  echo mobileurl('member/guamai/sellout')?>&id=<% val.id %>&op=1'"<% /if %>>买入
          </div>
          <% /if %> -->
          <% if val.status == 0 %>
          <div class="maiChu_btn" data-type="0" data-id="<% val.id %>"
            <% if val.self == 1 %> onclick="alert('不能买入自己发放的账单')"
            <% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"
            <% else %> data-flag = '0' <% /if %> >买入</div>
          <% /if %>
          <% if val.status == 1 %>
          <div class="maiRu_btn" data-id='<% val.id %>' style="background-color: #a02332;" <% if val.self == 1 %> onclick="alert('不能买入自己发放的账单')"<% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"<% else %> onclick="location.href='<?php  echo mobileurl('member/guamai/sellout')?>&id=<% val.id %>&op=1'"<% /if %>>交易中</div>
          <% /if %>
        </li>
      <% /each %>
      </ul>
  </script>

  <!-- 卖出模板 -->
  <script id="tpl_mairu" type="text/html">
    <ul>
    <% each list as val %>
        <li class="lis">
          <p style="color: #ffffff; justify-content: space-between;display: flex;">挂卖编号：<% val.id %>  <span style="color:#891635;font-size:.8rem;padding-right: 1.5rem;" >￥ <% val.price %> </span></p>

          <div class="lis_lie lis_lie0">
            <p >抢单人: <% val.nickname %>　
              <% if val.zfbfile==1 %> <i class="icon icon-alipay"></i> <% /if %>
              <% if val.wxfile==1 %> <i class="icon icon-wechat1"></i> <% /if %>
              <% if val.bank==1 %> <i class="icon icon-vipcard"></i> <% /if %>
            </p>

          </div>
          <div class="lis_lie lis_lie1">挂单数量 <% val.trx %> </div>
          <% if val.openid2 != '' %>
          <p style="color:#c2a378">抢单人：<% val.nickname2 %></p>
          <% /if %>
          <!-- <div class="lis_lie lis_lie2">限额 2800.0-2800.0 UES</div> -->
          <% if val.status == 0 %>
          <div class="maiChu_btn" data-type="1" data-id="<% val.id %>"
            <% if val.self == 1 %> onclick="alert('不能卖出自己发放的账单')"
            <% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"
            <% else %> data-flag = '0' <% /if %> >卖出</div>
          <% /if %>

          <% if val.status == 1 %>
          <div class="maiChu_btn" data-id="<% val.id %>" style="background-color: #a02332"
          <% if val.self == 1 %> onclick="alert('不能卖出自己发放的账单')"
          <% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"
          <% else if val.self3 == 0 %> onclick="location.href='<?php  echo mobileurl('member/guamai/sellout')?>&id=<% val.id %>&op=0'"
          <% else %> data-flag = '0'
          <% /if %> >交易中
          </div>
          <% /if %>
        </li>
    <% /each %>
    </ul>
  </script>


  <!-- js -->
  <script type="text/javascript">

  $('.container').on('click','.maiChu_btn',function (e) {

      if($(this).data('flag') == 0){
          e.stopPropagation();
          $(this).addClass('disable')
          let id = $(this).data('id');
          let type = $(this).attr('data-type');
          $.ajax({
            type:'post',
            url:"<?php  echo mobileurl('member/guamai/sellout')?>",
            data:{id:id, type:type},
            dataType:'json',
            success:function(data){
              console.log(data);
              // alert(data.result.message);

              $('.maiChu_btn').removeClass('disable');
              // if(data.status == 1){
              //     location.reload();
              //     window._type = 0;
              //     console.log(window._type);

              // }
              if(data.status == 1)
              {
                if(confirm(data.result.message)){
                  location.href="<?php  echo mobileurl('member/guamai/number_order')?>";
                }else {
                  console.log('取消!')
                }
                window._type = 0;
              }

              if(data.status == -1)
              {
                alert(data.result.message);
              }

            },error:function(err){
              console.log(err);
              $('.maiChu_btn').removeClass('disable');

            }
          })
      }
  })


    $(function () {
    // 页面加载时隐藏弹窗至屏幕外
      $('.mask0').css('bottom', $('.mask0').height() * -1);
      $('.mask1').css('bottom', $('.mask1').height() * -1);
    })

    // 设置全部变量0为卖出，1为买入
    var typeTab = 0;
    $('.tab1').click(function () {
      typeTab = 0;
    })
    $('.tab2').click(function () {
      typeTab = 1;
    })


    // 点击加号弹出弹框
    $('.fui-header-rig').click(function () {
      console.log(typeTab);
      if (typeTab == 1) {

        $.ajax({
          type:'post',
          url:"<?php  echo mobileurl('member/guamai/judgeguamai')?>",
          data:{type:1},
          dataType:'json',
          success:function(data){
            console.log(data);
            if(data.status == 1){
                $('.mask0').animate({
                  bottom: "0"
                }, 600)
            } else if (data.status == 0){
              FoxUI.toast.show(data.result.message);
            }

          },error:function(err){
            console.log(err);

          }
        })


      } else if (typeTab == 0) {

        $.ajax({
          type:'post',
          url:"<?php  echo mobileurl('member/guamai/judgeguamai')?>",
          data:{type:0},
          dataType:'json',
          success:function(data){
            console.log(data);
            if(data.status == 0){
              FoxUI.toast.show(data.result.message);
            }else if(data.status == 1){
              $('.mask1').animate({
                bottom: "0"
              }, 600)
            }

          },error:function(err){
            console.log(err);

          }
        })



      }

    })

    // 点击内容缩起弹窗
    $('.fui-content').click(function () {
      $('.mask0,.mask1').animate({
        bottom: $('.mask0').height() * -1
      }, 600)
    })

  </script>


  <script language='javascript'>
    window._type = 1;
    require(['biz/member/guamai'], function (modal) {

      modal.init({ type: window._type });

    });
  </script>

  <?php  $this->footerMenus()?>


</div>



<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
