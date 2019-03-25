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
  	width: 26%;
  	height: 1.5rem;
  	line-height: 1.5rem;
  	/*border: 1px solid green;*/
  	text-align: center;
  	margin-left: 16%;
  	
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
  .headertitle li span:nth-child(1){
  	
  	display: inline-block;
  	width: 13%;
  	text-align: center;
  	
  	
  }
  .headertitle li span:nth-child(2){
  	
  	display: inline-block;
  	width: 13%;
  	text-align: center;
  	
  }
  .headertitle li span:nth-child(3){
  	
  	display: inline-block;
  	width: 20%;
  	text-align: center;
  	
  }
  .headertitle li span:nth-child(4){
  	
  	display: inline-block;
  	width: 19%;
  	text-align: center;
  	
  }
  .headertitle li span:nth-child(5){
  	
  	display: inline-block;
  	width: 35%;
  	text-align: center;
  	color: red;
  	
  }
  
  .getprice{
  	font-size: .6rem;
  	margin-top: .4rem;
  	
  	
  }
  .getprice li span:nth-child(1){
  	
  	display: inline-block;
  	width: 20%;
  	text-align: center;
  	
  	
  }
  .getprice li span:nth-child(2){
  	
  	display: inline-block;
  	width: 20%;
  	text-align: center;
  	
  }
  .getprice li span:nth-child(3){
  	
  	display: inline-block;
  	width: 20%;
  	text-align: center;
  	
  }
  .getprice li span:nth-child(4){
  	
  	display: inline-block;
  	width: 40%;
  	text-align: center;
  	
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

   
    <!--<div class="zanwu">
      <i class="icon icon-cry" style="font-size: 4rem;"></i>
      <p style="font-size: 1rem;">今日暂无排行</p>
    </div>-->
    
    
    <div id="wrap">
         <div id="tit">
            <span class="select">投资排名</span><span>上期中奖名单</span>
        </div>
        <div id="con">
          <div class="show" >
                
                <ul class="headertitle lis">
                    <?php  if($investment == '') { ?>
                    <p style="color: red;text-align: center;font-size: 1rem;font-weight: 600;">投资总额: <?php  echo $sale['sum'];?></p>
                    <?php  } ?>
                  <li><span>排名</span><span>ID</span><span>昵称</span><span>预计获奖</span><span style="font-size: .6rem;">今日投资金额(TRX)</span></li>
                  <?php  if(is_array($investment)) { foreach($investment as $val) { ?>
                  <li class="lis" style="font-size:.6rem">
                    <span>第<?php  echo $val['type'];?>名</span>
                    <span>
                      <?php  echo $val['id'];?>
                    </span>
                    <span><?php  echo $val['nickname'];?></span>
                    <span><?php  echo $val['yuji'];?> <span style="color:red">(<?php  echo $val['bfb'];?>%)</span> </span>
                    <span><?php  echo $val['moneys'];?></span>
                  </li>
                  <?php  } } ?>
                </ul>
          </div>    

          <div style="display: none;" class="getprice">
              <ul class="getprice">
                <?php  if($winning == '') { ?>
                <p style="color: red;text-align: center;font-size: 1rem;font-weight: 600;">投资总额: <?php  echo $sale['sum'];?></p>
                <?php  } ?>
                <li><span>昵称</span><span>获奖金额</span><span>中奖号</span></li>
                <?php  if(is_array($winning)) { foreach($winning as $winn) { ?>
                  <li class="lis" style="font-size:.6rem">
                    <span><?php  echo $winn['openid'];?></span>
                    <span><?php  echo $winn['money'];?></span>
                    <span><?php  echo $winn['number'];?></span>
                  </li>
                <?php  } } ?>
              </ul>  
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
            $('#con div').eq(i).show().siblings().hide();
           
           
        });
    
    
  })
 
</script>