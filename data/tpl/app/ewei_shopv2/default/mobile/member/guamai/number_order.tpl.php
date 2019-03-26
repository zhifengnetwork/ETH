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
		background: #0e222d;
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
		display:-webkit-box;
		display: -moz-box;
		display: -ms-flexbox;	
		display: -webkit-flex;
		display: flex;
    flex-wrap: nowrap;

	}
	
	.pay-tt {
		display: inline-block;
		width: 100%;
		height: 2rem;
		text-align: center;
		line-height: 2rem;
		color: #fff;
		font-size: 0.7rem;
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
	.tab_content .tab_con{
		display: none;
		padding: .5rem .2rem 0 .2rem;
		}
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
		height: 2.2rem;
		border: 1px solid green;
		color: black;
		background: white;
		border-radius: .3rem;
		line-height: 2.2rem;
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
		line-height: 1rem;
	}
	
	.form span {
		width: 20%;
	}
	
	.buy b {
		font-size: 18px;
		color: #F0E68C;
		margin-left: .5rem;
		font-weight: normal;
	}
	
	.buy img {
		width: .5rem;
		height: .8rem;
		margin-left: .5rem;
		vertical-align: text-top;
	}
	
	.fn_cl {
		color: #F0E68C;
	}
	
	.ccc {
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
							<p class="form ccc">
								<span>16:10&nbsp;11/13</span>
								<span>10000.0</span>
								<span>0.25</span>
								<span>2500.00</span>
							</p>
							<div class="ccc">
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
							<p class="form ccc">
								<span>16:10&nbsp;11/13</span>
								<span>10000.0</span>
								<span>0.25</span>
								<span>2500.00</span>
							</p>
							<div class="ccc">
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
							<p class="form ccc">
								<span>16:10&nbsp;11/13</span>
								<span>10000.0</span>
								<span>0.25</span>
								<span>2500.00</span>
							</p>
							<div class="ccc">
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
					<div class="mask_lis">
						<div class="tishi">手续费：<span class="sxf0"><?php  echo $sys['trxsxf'];?></span></div>
					</div>
					<p>交易总额</p>
					<input type="number" disabled value="0" style="padding: 5px 10px;width: 100%;" class="mairu_Money">
					<!-- <div class="tishi">预扣手续费<span style="color:#9f2332;">0</span>UES</div> -->
					<div class="mask1_btn">确定买入</div>
				</div>
			</div>
	
			

		</div>

	</div>

	<!--nav-->

</div>
<script type="text/javascript">
 // 确定卖出
 $('.mask0_btn').click(function () {
      let maiChu_price = $('.maiChu_price').val();  // 卖出价格
      let price_min = $('.price_Min').html();       // 最小单价
      let price_max = $('.price_Max').html();        // 最大单价
      let maiChu_num = $('.maiChu_Num').val();       // 卖出数量
      let getMoney0 = $('.getMoney0').val();        // 获得金额
      let sxf0 = $('.sxf0').html();                 // 手续费
      let setTrx0 = $('.setTrx0').val();            // 支付TRX

      // 1. 卖出价格需在最小单价与最大单价区间中
      if(maiChu_price < price_min || maiChu_price > price_max){
        alert('请根据参考价格来输入价格！')
        return
      } else if(maiChu_num <= 0){
        alert('请输入卖出的数量！')
        return
      }

      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/hangonsale')?>",
        data:{
          price: maiChu_price,
          trx: maiChu_num,
          money: getMoney0,
          servicecharge: sxf0,
          trx2: setTrx0,
          type: "1"
        },
        dataType: 'json',
        success:function(data){
          console.log(data);
          if(data.status == '-2'){
            alert(data.result.message);
            location.href="<?php  echo mobileurl('member/guamai')?>";
          }else if(data.status == 1){
            alert(data.result.message);
            location.reload();
          }
          
        },error:function(err){
          console.log(err);
          
        }
      })

    })
		// 监听卖出价格的input变化
    $('.maiChu_price').bind('input onpropertychange',function () {
      if($('.maiChu_price').val() < 0){
        alert('卖出价格必须大于0');
        $('.maiChu_price').val('');
        return false;
      }

      if($('.maiChu_Num').val() != '' && $('.maiChu_price').val() != ''){
        let getMoney = $('.maiChu_Num').val() * $('.maiChu_price').val();
        let num = $('.maiChu_Num').val();
        $('.getMoney0').val(getMoney);
        setTrx = Number(num) + Number($('.sxf0').html());
        $('.setTrx0').val(setTrx);
      } else {
        $('.getMoney0').val('0');
        $('.setTrx0').val("0");
      }

    })
    // 监听卖出数量的input变化
    $('.maiChu_Num').bind('input onpropertychange',function () {
      let r = /^[1-9]+[0-9]*]*$/;
      if(!r.test($('.maiChu_Num').val())){
        alert('卖出数量必须为大于0的整数');
        $('.maiChu_Num').val('');
        return false;
      }

      if($('.maiChu_price').val() != '' && $('.maiChu_Num').val() != ''){
        let getMoney = $('.maiChu_Num').val() * $('.maiChu_price').val();
        let num = $('.maiChu_Num').val();
        $('.getMoney0').val(getMoney);
        setTrx = Number(num) + Number($('.sxf0').html());
        $('.setTrx0').val(setTrx);
      } else {
        $('.getMoney0').val('0');
        $('.setTrx0').val("0");
      }
    })

    // 监听买入价格的input变化
    $('.maiRu_price').bind('input onpropertychange',function () {
      if($('.maiRu_price').val() < 0){
        alert('卖出价格必须大于0');
        $('.maiRu_price').val('');
        return false;
      }

      if($('.buyNum').val() != '' && $('.maiRu_price').val() != ''){
        let getMoney = ($('.buyNum').val()-$('.sxf0').html()) * $('.maiRu_price').val();
				console.log($('.buyNum').val());
				console.log($('.maiRu_price').val());
				console.log($('.sxf0').html());
        $('.mairu_Money').val(getMoney);
      } else {
        $('.mairu_Money').val('0');
      }

    })
    // 监听买入数量的input变化
    $('.buyNum').bind('input onpropertychange',function () {
      let r = /^[1-9]+[0-9]*]*$/;
      if(!r.test($('.buyNum').val())){
        alert('卖出数量必须为大于0的整数');
        $('.buyNum').val('');
        return false;
      }

      if($('.maiRu_price').val() != '' && $('.buyNum').val() != ''){
        let getMoney = ($('.buyNum').val()-$('.sxf0').html()) * $('.maiRu_price').val();
        $('.mairu_Money').val(getMoney);
				console.log($('.buyNum').val());
				console.log($('.maiRu_price').val());
				console.log($('.sxf0').html());

      } else {
        $('.getMoney0').val('0');
      }
    })

	// 确定买入
	$('.mask1_btn').click(function () {
      let maiRu_price = $('.maiRu_price').val();
      let price_min = $('.price_Min').html();
      let price_max = $('.price_Max').html();
      let buy_nam = $('.buyNum').val();
      // 1. 买入价格需在最小单价与最大单价区间中
      if(maiRu_price < price_min || maiRu_price > price_max){
        alert('请根据参考价格来输入价格！')
        return
      } else if(buy_nam <= 0 || buy_nam == ''){
        alert('请输入买入的数量！')
        return
      }

      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/hangonsale')?>",
        data:{
          price: $('.maiRu_price').val(),
          trx: $('.buyNum').val(),
          money: $('.mairu_Money').val(),
          type: "0"
        },
        dataType: 'json',
        success:function(data){
          console.log(data);
          if(data.status == '-2'){
            alert(data.result.message);
            location.href="<?php  echo mobileurl('member/guamai')?>";
          }else if(data.status == 1){
            alert(data.result.message);
            location.reload();
          }
          
        },error:function(err){
          console.log(err);
          
        }
      })

    
    
    })

	
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