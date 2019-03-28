<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>
  .zanwu{
    text-align: center;
    padding-top: 3rem;
    color: #ccc;

    display: none;
  }

  #tit span{

  	display: inline-block;
  	width: 29%;
  	height: 1.5rem;
  	line-height: 1.5rem;
  	/*border: 1px solid green;*/
  	text-align: center;
  	margin-left: 14%;

  }
  .select{

  	border-bottom: .1rem solid #353A45;
  	/*border:1px solid red;*/
  	color:#353A45 ;
  	font-weight: bolder;

  }
  .show{
  	font-size: .6rem;
  	margin-top: .4rem;
  }
  .headertitle {
    list-style-type: none;
  }
  .headertitle p  {
    width: 100%;
    height: 2rem;
    line-height: 2rem;
  }
  .headertitle p span {
    float: left;
    display: block;
    height: 100%;
    text-align: center;

  }
  .headertitle li span:nth-child(4){

  	display: inline-block;
  	width: 19%;
  	text-align: center;
  }
  .headertitle p span:nth-child(2){
  	width: 13%;
  }
  .headertitle p span:nth-child(3){
  	width: 22%;

  }
  .headertitle p span:nth-child(4){
  	width: 22%;
  }
  .headertitle p span:nth-child(5){
    padding-top: .2rem;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 33%;
    line-height: .8rem;
    color: red;

  }
  .data_listWrap {
    width: 100%;
    height: 100%;
  }
  .data_listBox {
    width: 100%;
    height: auto;
  }
  .data_listBox_term {
    float: left;
    height: .8rem;
    text-align: center;
  }
  .data_listBox_term:nth-child(1){
  	width: 12%;
  }
  .data_listBox_term:nth-child(2){
  	width: 11%;
  }
  .data_listBox_term:nth-child(3){
  	width: 22%;

  }
  .data_listBox_term:nth-child(4){
  	width: 29%;
  }
  .data_listBox_term:nth-child(5){
  	width: 26%;
    line-height: 1rem;
  	color: red;
  }
  .good-item{

  	border-bottom: .05rem solid #CCCCCC;
  	padding-bottom: .5rem;
  	box-sizing: border-box;

  }
  .good-item .lis{

  	margin-top: .5rem;
  	font-size: .6rem;
  	display: inline-block;
  	width: 50%;
  	padding-left: .5rem;
  	box-sizing: border-box;

  }
  .good-item .lis:nth-child(2) p:nth-child(3){
  	color: green;

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
    <p style="color: #f7f7f7;text-align: center;font-size: 1rem;font-weight: 600;position: absolute;
    top: 111px;
    left: 18px;">投资总额: <?php  echo $sale['sum'];?></p>
    <?php  } else { ?>
    <p style="color: #f7f7f7;text-align: center;font-size: 1rem;font-weight: 600;position: absolute;
    top: 111px;
    left: 18px;">投资总额: <?php  echo $sale['sum'];?></p>
    <?php  } ?>


   <div class="zanwu">
      <i class="icon icon-cry" style="font-size: 4rem;"></i>
      <p style="font-size: 1rem;">今日暂无排行</p>
    </div>


    <div id="wrap">
        <div id="tit">
            <span class="select">投资排名</span><span>中奖名单</span>
        </div>
        <div id="con">
          <div class="show" >

                <!--data 头部-->
                <div class="headertitle lis">
                  <p style="margin-left: 17px;"><span>排名</span><span>ID</span><span>昵称</span><span>预计获奖</span><span style="font-size: .6rem;">今日投资金额<br/>(ETH)</span></p>

                </div>
                <!--data list -->
                <div class="data_listWrap">
                      <?php  if(is_array($investment)) { foreach($investment as $val) { ?>
                        <p class="data_listBox" style="font-size:.6rem">
                          <span class="data_listBox_term">第<?php  echo $val['type'];?>名</span>
                          <span class="data_listBox_term">
                            <?php  echo $val['id'];?>
                          </span>
                          <span class="data_listBox_term"><?php  echo $val['nickname'];?></span>
                          <span class="data_listBox_term"><?php  echo $val['yuji'];?> <span style="color:red">(<?php  echo $val['bfb'];?>%)</span> </span>
                          <span class="data_listBox_term"><?php  echo $val['moneys'];?></span>
                        </p>
                      <?php  } } ?>
                </div>

          </div>

          <div style="display: none;" class="getprice show">
              <?php  if($winning == '') { ?>
                <p style="color: red;text-align: center;font-size: 1rem;font-weight: 600;">投资总额: <?php  echo $sale['sum'];?></p>
              <?php  } ?>
              <div class="getprice good-item">
                  <?php  if(is_array($winning)) { foreach($winning as $winn) { ?>
                <div class="lis">

                    <p>时间：<?php  echo $winn['createtime'];?></p>
                    <p>中奖号：<?php  echo $winn['number'];?></p>
                    <p>中奖注数：<?php  echo $winn['stakesum'];?>股</p>

                </div><div class="lis">
                    <p>中奖人昵称：<?php  echo $winn['openid'];?></p>
                    <p>中奖金额：<?php  echo $winn['money'];?></p>
                    <p>投注中奖</p>
                </div>
                <?php  } } ?>
              </div>
          </div>
        </div>
</div>

<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
  $(function () {

      $('#tit span').click(function() {
            var i = $(this).index();//下标第一种写法
            //var i = $('tit').index(this);//下标第二种写法
            $(this).addClass('select').siblings().removeClass('select');
            $('#con .show').eq(i).show().siblings().hide();


        });


  })

</script>
