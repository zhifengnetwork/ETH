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

  /* 订单内容 */
  .order_list{width: 100%;height: auto;border-bottom: 1px solid #eee;}
  .order{padding:.4rem;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}
  .order p{display: flex;justify-content: space-between;line-height: 1rem;}
  .form span{width: 20%;}
  .buy b{font-size: 18px;color:#F0E68C; margin-left: .5rem;font-weight: normal;}
  .buy img{width: .5rem;height: .8rem;margin-left: .5rem;vertical-align: text-top;}
  .fn_cl{color:#F0E68C;}
  .ccc{color:#999999;}
  .order div span{margin-right: 1rem;}
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

					<div>
            <div class="order_list">
              <div class="order">
                <p class="buy">
                  <span>买入<b>UES</b></span>
                  <span class="fn_cl">已取消<img src="../addons/ewei_shopv2/static/images/zhifeng/right.png"></span>
                </p>
                <p class="form">
                  <span>创建时间</span>
                  <span>数量(UES)</span>
                  <span>价格(CNY)</span>
                  <span>总额(CNY)</span>
                </p>
                <p class="form ccc">
                  <span>16:10&nbsp;11/13</span>
                  <span>10000.0</span>
                  <span>0.25</span>
                  <span>2500.00</span>
                </p>
                <div class="ccc" >
                  <span>订单号</span>
                  <span>666666666666666</span>
                </div>
              </div>
            </div>
          </div>

					<div>tab2的内容</div>

					<div >tab3的内容</div>

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