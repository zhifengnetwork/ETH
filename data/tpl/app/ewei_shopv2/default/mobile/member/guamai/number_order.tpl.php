<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>
	#tab>a {
		flex: 1;
	}
	
	.mydingdan {
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
	/*---背景颜色----*/
		.fui-page {
		background: #071a21;
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
	/*-------清除浮动-------*/
	.clearfix:before {
		display: block;
		clear: both;
		content: "";
		visibility: hidden;
		height: 0;
	}
	
	.clearfix:after {
		display: block;
		clear: both;
		content: "";
		visibility: hidden;
		height: 0;
	}
	
	.clearfix {
		zoom: 1
	}
	/*是在处理兼容性问题*/
	
	.tab_header .hide {
		display: none;
	}
	/* 买入 卖出按钮样式 */

	.buying {
		height: 2rem;
		text-align: center;
		padding-top: .5rem;
	}
	
	.pay-tt {
		display: inline-block;
		width: 48%;
		height: 2rem;
		/* background: #F0E68C; */
		text-align: center;
		/* line-height: 2rem; */
		padding: .5rem;
		color: #fff;
	}
	
	.pay-tt.active {
		background: #F0E68C;
		color: #000;
	}
	
	.fui-list-group {
		margin-top: 0;
	}
	
	ul li {
		list-style: none;
	}
	

	/*-----选中状态----*/
	.on {
		color: #F0E68C !important;
		border-bottom: 2px solid #F0E68C;
	}
	
	.box {
		padding-top: 2.2rem;
		background: #071a21;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
	}
	/*----飞机图标---*/
	.lj_plane {
		width: 20px;
		height: 20px;
		padding-top: 3px;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
	}
	
	.fui-header-right a {
		display: inline-block;
	}
	/*---tab切换---*/
	.tab_header {
		width: 100%
	}
	
	.tab_header ul li {
		width: 33%;
		float: left;
		text-align: center;
		color: #fff;
		line-height: 2rem;
		height: 2rem;
	}
	
	.tab_content {
		color: #fff;
	}
	.tab_con1_one {
		line-height: 2rem;
		height: 2rem;
		padding: 0 0.7rem;
	}
	
	.tab_con1_one p {
		display: inline-block;
	}
	
	.tab_con1_one_l {
		float: left;
	}
	
	.tab_con1_one_r {
		float: right;
	}
	
	.tab_con1_one_r_img {
		width: 26px;
		height: 25px;
		vertical-align: middle;
	}
	
	.tab_content {
		color: #fff;
		padding-top: .5rem;
		padding-bottom: .5rem;
	}
	.tab_content .tab_con{display: none;}
	.tab_content .tab_con.active{display: block;}
	
	/* 买入 卖出弹框 */
	
	.mask1_btn {
		width: 100%;
		text-align: center;
		height: 30px;
		line-height: 30px;
		background-color: #0a0;
		margin: 10px 0 20px;
	}
	
	.mask1>.mask1_lis {
		display: flex;
		background-color: #fff;
		color: #000;
		padding: 5px 10px;
		align-items: center;
	}
	
	.mask1>.mask1_lis>.buyNum {
		border: 0;
		outline-style: none;
		width: 70%;
	}
	
	.mask1>.mask1_lis>.allBuy {
		width: 30%;
	}
	
	.mask1>.mask1_lis>.allBuy>span {
		color: #c2a378;
	}
	
	.mask1>p {
		padding: 5px 0;
	}
	
	.mask1>.mask_tit {
		margin-top: 10px;
		font-size: 16px;
		text-align: center;
		color: #c2a378;
	}
	
	.mask1>.mask1_pice {
		display: flex;
	}
	
	.mask1>.mask1_pice>p {
		width: 20%;
		text-align: center;
	}
	
	.maiRu_price {
		padding: 5px 10px;
		width: 80%;
		border: 0;
		outline-style: none;
	}
	
	.mask1 {
		background-color: #0e222d;
		/* position: fixed;
      width: 100%;
      bottom: 0;
      left: 0;
      z-index: 9; */
		color: #fff;
		padding: 20px;
	}
	
	.mask0 {
		background-color: #0e222d;
		/* position: fixed;
      width: 100%;
      bottom: 0;
      left: 0; */
		z-index: 9;
		color: #fff;
		padding: 20px;
	}
	
	.mask0>.mask_tit {
		margin-top: 10px;
		font-size: 16px;
		text-align: center;
		color: #c2a378;
	}
	
	.mask0>.mask_lis>input {
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
	/*-------我的申诉-------*/
	.main {
		width: 100%;
		margin-top: 0.5rem;
	}
	
	.main p {
		font-size: 1rem;
		padding-top: 0.3rem;
		padding-bottom: 0.5rem;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		text-align: center;
	}
	
	textarea {
		outline: none;
		width: 78%;
		height: 12rem;
		margin-left: 11%;
		font-size: 0.7rem;
		border: 2px solid black;
		border-radius: 0.3rem;
		padding: 0.4rem;
		letter-spacing: 0.05rem;
	}
	
	.appeal_reason {
		color: white;
	}
	
	.button {
		width: 78%;
		height: 2.6rem;
		border: 1px solid green;
		color: black;
		background: white;
		border-radius: .3rem;
		line-height: 2.6rem;
		text-align: center;
		font-size: 1.1rem;
		margin: auto;
		margin-top: 0.8rem;
	}
	/* 订单内容 */
	
	.order_list {
		width: 100%;
		height: auto;
		border-bottom: 1px solid #eee;
	}
	
	.order {
		padding: .4rem;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
	}
	
	.order p {
		display: flex;
		justify-content: space-between;
		line-height: 1.5rem;
	}
	
	.order .form span {
		width: 22%;
	}
	
	.buy b {
		font-size: 18px;
		color: #F0E68C;
		margin-left: .5rem;
		font-weight: normal;
	}
	
	.buy img {
		width: .4rem;
    height: .55rem;
    margin: 0 .5rem;
    vertical-align: baseline;
	}
	
	.fn_cl {
		color: #F0E68C;
	}
	
	.font_color_999 {
		color: #999999;
	}
	
	.order div span {
		margin-right: 1rem;
	}
	
	
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
				<li class="current on con_on" > 我的订单</li>

				<li class="con_on">发布广告</li>

				<li class="con_on">我的申诉</li>

			</ul>
			<div class="clear"></div>
			<!--这个是要显示的内容部分-->
			<div class="tab_content">
				<!--------我的订单---------->
				<div class="tab_con active">
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
							<p class="form font_color_999">
								<span>16:10&nbsp;11/13</span>
								<span>10000.0</span>
								<span>0.25</span>
								<span>2500.00</span>
							</p>
							<div class="font_color_999">
								<span>订单号</span>
								<span>666666666666666</span>
							</div>
						</div>
					</div>
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
							<p class="form font_color_999">
								<span>16:10&nbsp;11/13</span>
								<span>10000.0</span>
								<span>0.25</span>
								<span>2500.00</span>
							</p>
							<div class="font_color_999">
								<span>订单号</span>
								<span>666666666666666</span>
							</div>
						</div>
					</div>
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
							<p class="form font_color_999">
								<span>16:10&nbsp;11/13</span>
								<span>10000.0</span>
								<span>0.25</span>
								<span>2500.00</span>
							</p>
							<div class="font_color_999">
								<span>订单号</span>
								<span>666666666666666</span>
							</div>
						</div>
					</div>
				
				</div>
				
				<!--------发布广告----------->
				<div class="tab_con">
					<div class="buying">
						<a class="pay-tt active">买入ETH</a>
						<a class="pay-tt">卖出ETH</a>
					</div>
				</div>
				<!--------我的申诉----------->
				<div class="tab_con">
					<div class="main">
						<p class="appeal_reason">申诉原因</p>
						<textarea placeholder="请输入申诉原因"></textarea>
						<div class="button">申诉</div>
					</div>
				</div>
			
			
			</div>
			<div class="mask0_box hide">
				<!-- 卖出 -->
				<div class="mask0 hide">
					<div class="mask_lis">
						<p>价格(CNY)</p>
						<input type="number" placeholder="请输入卖出的价格" class="maiChu_price">
						<div class="tishi">参考价格：￥<span class="price_Min"><?php  echo $start;?></span>-￥<span class="price_Max"><?php  echo $end;?></span></div>
					</div>
					<div class="mask_lis">
						<p>数量(ETH)</p>
						<input type="number" placeholder="请输入卖出的数量" class="maiChu_Num">
					</div>
					<div class="mask_lis">
						<p>预获金额(CNY)</p>
						<input type="number" disabled value="0" class="getMoney0">
						<div class="tishi">手续费：<span class="sxf0"><?php  echo $sys['trxsxf'];?></span></div>
					</div>
					<div class="mask_lis">
						<p>待付(ETH)</p>
						<input type="number" disabled value="0" class="setTrx0">
					</div>
					<div class="mask0_btn">确定卖出</div>
				</div>

				<!-- 买入 -->
				<div class="mask1 ">
					<div class="mask1_pice">
						<p>单价</p>
						<input type="number" placeholder="请输入买入的价格" class="maiRu_price">
					</div>
					<div class="tishi">参考价格：￥<span class="price_Min"><?php  echo $start;?></span>-￥<span class="price_Max"><?php  echo $end;?></span></div>

					<p>买入数量</p>
					<div class="mask1_lis">
						<input type="number" placeholder="请输入购买的数量" class="buyNum">
					</div>
					<p>交易总额</p>
					<input type="number" disabled value="0" style="padding: 5px 10px;width: 100%;" class="mairu_Money">
					<!-- <div class="tishi">预扣手续费<span style="color:#9f2332;">0</span>UES</div> -->
					<div class="mask1_btn">确定买入</div>
				</div>
			</div>
			<!-- 买入模板 -->
			<script id="tpl_maichu" type="text/html">
				<ul>
					<% each list as val %>
					<li class="lis">
						<p style="color: #fff;">挂卖编号：
							<% val.id %> </p>
						<div class="lis_lie lis_lie0">
							<p>挂单人:
								<% val.nickname %>
								<% if val.zfbfile==1 %> <i class="icon icon-alipay"></i>
								<% /if %>
								<% if val.wxfile==1 %> <i class="icon icon-wechat1"></i>
								<% /if %>
								<% if val.bank==1 %> <i class="icon icon-vipcard"></i>
								<% /if %>
							</p>
							<span>￥<% val.price %> </span>
						</div>
						<% if val.openid2 != '' %>
						<p style="color:#c2a378">抢单人：
							<% val.nickname2 %>
						</p>
						<% /if %>
						<div class="lis_lie lis_lie1">挂单数量
							<% val.trx %>
						</div>
						<!-- <div class="lis_lie lis_lie2">限额 2800.0-2800.0 UES</div> -->
						<% if val.status == 0 %>
						<div class="maiRu_btn" data-id='<% val.id %>' <% if val.self==1 %> onclick="alert('不能买入自己发放的账单')"
							<% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"
							<% else %> onclick="location.href='<?php  echo mobileurl('member/guamai/sellout')?>&id=
							<% val.id %>&op=1'"
							<% /if %>>买入
						</div>
						<% /if %>
						<% if val.status == 1 %>
						<div class="maiRu_btn" data-id='<% val.id %>' style="background-color: #a02332;" <% if val.self==1 %> onclick="alert('不能买入自己发放的账单')"
							<% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"
							<% else %> onclick="location.href='<?php  echo mobileurl('member/guamai/sellout')?>&id=
							<% val.id %>&op=1'"
							<% /if %>>交易中</div>
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
						<p style="color: #6b5b3a; justify-content: space-between;display: flex;">唐**
							<% val.id %> <span style="color:#891635;font-size:.8rem;padding-right: 1.5rem;">￥ <% val.price %> </span></p>
						<div class="lis_lie lis_lie1">挂单数量
							<% val.trx %> </div>

						<div class="lis_lie lis_lie0">
							<p style="color:#545d62">限额:
								<% val.nickname %>

							</p>

						</div>
						<% if val.openid2 != '' %>
						<p style="color:#c2a378">抢单人：
							<% val.nickname2 %>
						</p>
						<% /if %>

						<!-- <div class="lis_lie lis_lie2">限额 2800.0-2800.0 UES</div> -->

						<% if val.status == 0 %>
						<div class="maiChu_btn" data-id="<% val.id %>" <% if val.self==1 %> onclick="alert('不能卖出自己发放的账单')"
							<% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"
							<% else %> data-flag = '0'
							<% /if %> >卖出</div>
						<% /if %>

						<% if val.status == 1 %>
						<div class="maiChu_btn" data-id="<% val.id %>" style="background-color: #a02332" <% if val.self==1 %> onclick="alert('不能卖出自己发放的账单')"
							<% else if val.self3 == 1 %> onclick="alert('该账单正在交易中')"
							<% else if val.self3 == 0 %> onclick="location.href='<?php  echo mobileurl('member/guamai/sellout')?>&id=
							<% val.id %>&op=0'"
							<% else %> data-flag = '0'
							<% /if %> >交易中
						</div>
						<% /if %>

					</li>
					<% /each %>
				</ul>
			</script>
			

		</div>

	</div>

	<!--nav-->

</div>
<script type="text/javascript">
	$(function() {
		//tab切换
		$(".tab_header .con_on").on("click", function() {
			var index=$(this).index();
			$(this).addClass("on").siblings().removeClass("on");
			//内容切换
			$(".tab_content .tab_con").eq(index).addClass("active").siblings().removeClass("active");
		
		//买入卖出切换
		if($(this).index() == 1) {
				$(".mask0_box").show()
			} else {
				$(".mask0_box").hide()
			}
		})

	})

	// 买入卖出
	$(".buying .pay-tt").click(function() {
		var $a = $(this)
		$a.addClass("active").siblings().removeClass("active")
		$(this).index()
		if($(this).index() == 0) {
			$(".mask1").show().siblings(".mask0").hide();
		} else {
			$(".mask0").show().siblings(".mask1").hide();
		}
	})
</script>

<?php  $this->footerMenus()?>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>