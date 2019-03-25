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
.clearfix:before{
	display:block;
	clear:both;
	content:"";
	visibility:hidden;
	height:0;
}
.clearfix:after{
	display:block;
	clear:both;
	content:"";
	visibility:hidden;
	height:0;
} 
.clearfix{zoom:1}  /*是在处理兼容性问题*/

  .fui-list-group {
    margin-top: 0;
  }
	ul li{list-style: none;}
	.tab_header{width: 100%}
	.tab_header ul li{width:33%;float: left;text-align: center;color: #fff;line-height: 2rem;height: 2rem;}
	.on{color:#F0E68C !important;border-bottom: 2px solid #F0E68C;}
	.box{padding-top:2.2rem;background: #071a21;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}

  .lj_plane{width: 20px;height: 20px;padding-top: 3px;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}
  .fui-header-right a{display: inline-block;}
  .tab_content{color: #fff;}
  .fui-page{background: #071a21;}
  .tab_con1_one{line-height: 2rem;height: 2rem;padding: 0 0.7rem;}
  .tab_con1_one p{display: inline-block;}
  .tab_con1_one_l{float: left;}
  .tab_con1_one_r{float: right;}
  .tab_con1_one_r_img{width: 26px;height: 25px;vertical-align: middle;}
</style>

<div class='fui-page  fui-page-current member-log-page'>

  <div class="fui-header">

    <div class="fui-header-left">

      <a class="back"></a>

    </div>

    <div class="title">ETH/CNY</div>
    <div class="fui-header-right" data-type="0">
    	 <i class="fui-header-right icon icon-add4"></i>
    </div>
  </div>
	
   <!--nav-->
	<div class="box">
			<!--这个是tab切换标题-->
			<div class="tab_header">
				<ul class="clearfix">
					<li class="current on con_on"> 我的订单</li>

					<li class="con_on">发布广告</li>

					<li class="con_on">我的申诉</li>

				</ul>
				<div class="clear"></div>
				<!--这个是要显示的内容部分-->
				<div class="tab_content">
					<div class="tab_con1">
						<div class="tab_con1_one clearfix">
							<div class="tab_con1_one_l">
								<p>买入</p>
								<p>UES</p>
							</div>
							<div class="tab_con1_one_r">
								<p>已取消</p>
								<p><img class="tab_con1_one_r_img" src="../addons/ewei_shopv2/static/images/zhifeng/jiantou.png" /></p>
							</div>
						</div>
						<div class="tab_con1_two">
							<ul>
								<li>
									<p>创建</p>
									<p>20:42 02-23</p>
								</li>
								<li>
									<p>数量(UES)</p>
									<p>10000.0</p>
								</li>
								<li>
									<p>价格(CNY)</p>
									<p>0.25</p>
								</li>
								<li>
									<p>总额(CNY)</p>
									<p>2500.00</p>
								</li>
							</ul>
						</div>
						<div class="tab_con1_there">
							<p>订单号</p>
							<p>1009288424325062657</p>
						</div>
						
						
					</div>

					<div>tab2的内容</div>

					<div>tab3的内容</div>

				</div>

			</div>

		</div>

  <!--nav-->

  </div>
		<script type="text/javascript">
			$(function(){
				
					/*var $asd = $(".tab_header ul li");
	
					$asd.click(function() {
	
					$(this).addClass("current").siblings().removeClass("current");
	
					var $index = $asd.index(this);
	
					var $content = $(".tab_content div");
	
					$content.eq($index).show().siblings().hide();*/
					$(".clearfix .con_on").on("click",function(){
						$(".clearfix li").eq($(this).index()).addClass("on").siblings().removeClass("on")
						$(".tab_content div").hide().eq($(this).index()).show()
					})
	
			})
			
		</script>



  <?php  $this->footerMenus()?>


</div>



<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>