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
		touch-action: pan-x;
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

		padding:2.2rem 0 2.7rem 0;
		background: #071a21;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		overflow-y: scroll;
	    height: 100%;


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
	.box_nav{position: fixed;width: 100%;height: 2rem;background: #0a181f;max-width: 750px;z-index:100;}
	.box_nav ul li {
		width: 33%;
		float: left;
		text-align: center;
		color: #fff;
		line-height: 2rem;
		height: 2rem;
	}
	/*------tab切换里面的内容------*/
	.tab_header {
		width: 100%
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
		padding: 2rem 0 0.5rem 0;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		overflow: hidden;
	}
	.tab_content .tab_con{
		display: none;
		padding: .5rem .2rem 0 .2rem;
		}

	.tab_content .tab_con.active{
		display: block;
	}

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
		/*display: flex;*/
		background-color: #fff;
		color: #000;
		/*padding: 5px 10px;*/
		/*align-items: center;*/
	}

	.mask1>.mask1_lis>.buyNum {
		padding: 5px 10px;
		width: 100%;
		/*border: 0;*/
		outline-style: none;
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
	.mask_lis_p{    padding: 5px 0;}
	.mask1>.mask_tit {
		margin-top: 10px;
		font-size: 16px;
		text-align: center;
		color: #c2a378;
	}

	.mask1>.mask1_pice {
		/*display: flex;*/
	}

	.mask1>.mask1_pice>p {
		/*width: 20%;
		text-align: center;*/
	}

	.maiRu_price {
		padding: 5px 10px;
		width: 100%;
		/*border: 0;*/
		outline-style: none;
	}

	.mask1 {
		background-color: #0e222d;
		color: #fff;
		padding: 20px;
	}

	.mask0 {
		background-color: #0e222d;
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
	.mask_lis_input{width: 100%;
		padding: 5px 10px;}
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
		margin: 10px 0;
	}
	/*-------我的申诉-------*/
	.main {
		width: 100%;
		margin-top: 0.5rem;
	}
	.wtf_item {display: inline-block;width: 100%;}
	.wtf_item1 {border-bottom: 1px solid #fff;line-height: 1.9rem;height: 1.9rem;width: 100%;}
	.wtf_item1 p:nth-child(1){font-size: 0.65rem;color: #FFFFFF;float: left;margin-left: 0.6rem;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}
	.wtf_item1 p:nth-child(2) {font-size: 0.65rem;color: #FFFFFF;float: right;padding-right: 0.6rem;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}
	/* 订单内容 */

	.order_list {
		width: 100%;
		height: auto;
		border-bottom: 1px solid #c5c5c5;
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
		height: 1.5rem;
	}

	.order .form{
		display: flex;
	  justify-content: flex-start;
	}

	.order .form>span {
		width: 50%;
		display: flex;
	  flex-wrap: nowrap;
		overflow: hidden;
		white-space : nowrap ;
	}
	.order .form>span:nth-child(1),.order .form>span:nth-child(2){
		width: 30%;
	}
	.order .form>span:nth-child(2){
		padding:0 .3rem;
	}
	.order	.form_spww>span:nth-child(1){
		width: 50%;
	}
	.buy b {
		font-size: 18px;
		color: #F0E68C;
		margin-left: .5rem;
		font-weight: nowrap ;
	}
	.order .form_spww{
		display: flex;
	  justify-content: space-between;
	}
	.form_spww>span{
		width: 100%;
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
	/*-----倒计时------*/
	.order_time{/*font-weight: bold;*/
		letter-spacing: 0.03rem;
		padding-left: 0.85rem;
		box-sizing: border-box; width: 100%;
		color: #fff;
		font-size: 0.7rem;
		text-align: right;}

	/* 我的订单 tab */
	.tab_cut{
		width: 100%;
		padding: 0.3rem;
		touch-action: pan-x;
	}
  .tab_cut>ul{
		display: flex;
		flex-wrap: nowrap;
	}
	/* 默认样式 */
	.tab_cut ul .tab_item{
		width: 25%;
		text-align: center;
		height: 2rem;
		line-height: 2rem;
	}
	/* 选中样式 */
	.tab_cut ul .tab_item.active{
		background: #F0E68C;
	}
	.tab_cut ul .tab_item.active>a{
		color:#0a181f;
	}
  .tab_cut ul .tab_item a{
		color: #FFFFFF;
	}
	/* 交易状态切换 */
	.my_order{
		position: relative;
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    width: 100%;
    height: 100%;
    will-change: left;
	}
	.my_order .tab_cont{
	 /* padding: .5rem .2rem 0 .2rem; */
	 width: 100%;
    -webkit-flex-shrink: 0;
    flex-shrink: 0;
    box-sizing: border-box;
		width: 100%;
	}
	/* .my_order .tab_cont.active{
		display: block;
	} */
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
		<div class="box_nav">
			<ul class="clearfix">
				<li class="current on con_on" > 我的订单</li>

				<li class="con_on">发布广告</li>

				<li class="con_on">我的申诉</li>

			</ul>
			<div class="clear"></div>
		</div>

		<!--这个是tab切换标题-->
		<div class="tab_header">

			<!--这个是要显示的内容部分-->
			<div class="tab_content">
					<!-- tab切换内容   未交易 交易中  交易完成  交易失败-->
				  <div class="tab_cut">
						<ul>
							<li class="tab_item active">
								<a href=""  data-id="0">未交易</a>
							</li>
							<li class="tab_item">
								<a href=""  data-id="1">交易中</a>
							</li>
							<li class="tab_item">
								<a href=""  data-id="2">交易完成</a>
							</li>
							<li class="tab_item">
								<a href=""  data-id="3">交易失败</a>
							</li>
						</ul>
					</div>
				<!--------我的订单---------->
				<div class="tab_con  active " style="padding:0" >
					<div class="my_order" id="load"style="left: 0%;transition-duration: 0.3s;">
				<!-- 未交易 -->
					<div class="tab_cont undone">
						<?php  if(is_array($guamai)) { foreach($guamai as $winn) { ?>
						<?php  if($winn['status'] == '0') { ?>
						<div class="order_list">
							<div class="order">
								<p class="buy">
										<?php  if($openid == $winn['openid2']) { ?>
										<?php  if($winn['type'] == '0') { ?>
											<span style="color:brown">卖出<b>ETH</b></span>
										<?php  } ?>
										<?php  if($winn['type'] == '1') { ?>
											<span style="color:#0a0">买入<b>ETH</b></span>
										<?php  } ?>
									<?php  } else { ?>
										<?php  if($winn['type'] == '0') { ?>
										<span style="color:#0a0">买入<b>ETH</b></span>
										<?php  } ?>
										<?php  if($winn['type'] == '1') { ?>
										<span style="color:brown">卖出<b>ETH</b></span>
										<?php  } ?>
									<?php  } ?>
									<?php  if($winn['status'] == '0') { ?>
									<span class="fn_cl" data-val="0" onclick="location.href='<?php  echo mobileurl('member/guamai/sellout_list')?>&id=<?php  echo $winn['id'];?>&type=<?php  echo $winn['status'];?>'" >未交易<img src="../addons/ewei_shopv2/static/images/zhifeng/right.png"></span>
									<?php  } ?>
								</p>
								<p class="form">
									<span><span class="font_color_999"> <?php  echo $winn['trx'];?></span>/个</span>
									<span>$<span class="font_color_999"><?php  echo $winn['price'];?></span></span>
									<span>总额(CNY)： <span class="font_color_999"><?php  echo $winn['money'];?></span></span>
								</p>
								<p class="form form_spww">
										<span><span class="font_color_999"><?php  echo $winn['datatime'];?></span></span>
									</p>
							</div>
						</div>
						<?php  } ?>
						<?php  } } ?>

					</div>
				<!-- 交易中 -->
					<div class="tab_cont trading">
							<?php  if(is_array($guamai)) { foreach($guamai as $winn) { ?>
							<?php  if($winn['status'] == '1') { ?>
							<div class="order_list">
								<div class="order">

									<p class="buy">
										<?php  if($openid == $winn['openid2']) { ?>
											<?php  if($winn['type'] == '0') { ?>
												<span style="color:brown">卖出<b>ETH</b></span>
											<?php  } ?>
											<?php  if($winn['type'] == '1') { ?>
												<span style="color:#0a0">买入<b>ETH</b></span>
											<?php  } ?>
										<?php  } else { ?>
											<?php  if($winn['type'] == '0') { ?>
											<span style="color:#0a0">买入<b>ETH</b></span>
											<?php  } ?>
											<?php  if($winn['type'] == '1') { ?>
											<span style="color:brown">卖出<b>ETH</b></span>
											<?php  } ?>
										<?php  } ?>


										<?php  if($winn['status'] == '1') { ?>
										<span class="fn_cl" data-val="1" onclick="location.href='<?php  echo mobileurl('member/guamai/sellout')?>&id=<?php  echo $winn['id'];?>&op=<?php  echo $winn['type'];?>&status=<?php  echo $winn['status'];?>'">交易中<img src="../addons/ewei_shopv2/static/images/zhifeng/right.png"></span>
										<?php  } ?>
									</p>
									<p class="form">
										<span><span class="font_color_999"> <?php  echo $winn['trx'];?></span>/个</span>
										<span>$<span class="font_color_999"><?php  echo $winn['price'];?></span></span>
										<span>总额(CNY)： <span class="font_color_999"><?php  echo $winn['money'];?></span></span>
									</p>
									<p class="form form_spww">
	<!--倒计时-时间戳-->
											<span><span class="font_color_999"><?php  echo $winn['datatime'];?></span></span>
											<input type="hidden" value="<?php  echo $winn['apple_time'];?>" class="time"/>
											<span id="order_time" class="order_time" ></span>
										</p>
								</div>
							</div>
							<?php  } ?>

							<?php  } } ?>
						</div>
				<!-- 交易完成 -->
					<div class="tab_cont achieve">
							<?php  if(is_array($guamai)) { foreach($guamai as $winn) { ?>
							<?php  if($winn['status'] == '2') { ?>
							<div class="order_list">
								<div class="order">

									<p class="buy">
											<?php  if($openid == $winn['openid2']) { ?>
											<?php  if($winn['type'] == '0') { ?>
												<span style="color:brown">卖出<b>ETH</b></span>
											<?php  } ?>
											<?php  if($winn['type'] == '1') { ?>
												<span style="color:#0a0">买入<b>ETH</b></span>
											<?php  } ?>
										<?php  } else { ?>
											<?php  if($winn['type'] == '0') { ?>
											<span style="color:#0a0">买入<b>ETH</b></span>
											<?php  } ?>
											<?php  if($winn['type'] == '1') { ?>
											<span style="color:brown">卖出<b>ETH</b></span>
											<?php  } ?>
										<?php  } ?>
										<?php  if($winn['status'] == '2') { ?>
										<span class="fn_cl" data-val="2" onclick="location.href='<?php  echo mobileurl('member/guamai/sellout_list')?>&id=<?php  echo $winn['id'];?>&op=<?php  echo $winn['type'];?>&status=<?php  echo $winn['status'];?>'">交易完成<img src="../addons/ewei_shopv2/static/images/zhifeng/right.png"></span>
										<?php  } ?>

									</p>


									<p class="form">
										<span><span class="font_color_999"> <?php  echo $winn['trx'];?></span>/个</span>
										<span>$<span class="font_color_999"><?php  echo $winn['price'];?></span></span>
										<span>总额(CNY)： <span class="font_color_999"><?php  echo $winn['money'];?></span></span>
									</p>
									<p class="form form_spww">
											<!--倒计时-时间戳-->
											<span><span class="font_color_999"><?php  echo $winn['datatime'];?></span></span>
										</p>
								</div>
							</div>
							<?php  } ?>
							<?php  } } ?>

					</div>
				<!-- 交易失败 -->
					<div class="tab_cont defeated">
							<?php  if(is_array($guamai)) { foreach($guamai as $winn) { ?>
							<?php  if($winn['status'] == '3') { ?>
							<div class="order_list">
								<div class="order">

									<p class="buy">
										<?php  if($openid == $winn['openid2']) { ?>
											<?php  if($winn['type'] == '0') { ?>
												<span style="color:brown">卖出<b>ETH</b></span>
											<?php  } ?>
											<?php  if($winn['type'] == '1') { ?>
												<span style="color:#0a0">买入<b>ETH</b></span>
											<?php  } ?>
										<?php  } else { ?>
											<?php  if($winn['type'] == '0') { ?>
											<span style="color:#0a0">买入<b>ETH</b></span>
											<?php  } ?>
											<?php  if($winn['type'] == '1') { ?>
											<span style="color:brown">卖出<b>ETH</b></span>
											<?php  } ?>
										<?php  } ?>


										<?php  if($winn['status'] == '3') { ?>
										<span class="fn_cl" data-val="3" onclick="location.href='<?php  echo mobileurl('member/guamai/sellout_list')?>&id=<?php  echo $winn['id'];?>&op=<?php  echo $winn['type'];?>&status=<?php  echo $winn['status'];?>'" >交易失败<img src="../addons/ewei_shopv2/static/images/zhifeng/right.png"></span>
										<?php  } ?>
									</p>

									<p class="form">
											<span><span class="font_color_999"> <?php  echo $winn['trx'];?></span>/个</span>
											<span>$<span class="font_color_999"><?php  echo $winn['price'];?></span></span>
											<span>总额(CNY)： <span class="font_color_999"><?php  echo $winn['money'];?></span></span>
										</p>

									<p class="form form_spww">
											<!--倒计时-时间戳-->
										<span><span class="font_color_999"><?php  echo $winn['datatime'];?></span></span>
									</p>

								</div>
							</div>
							<?php  } ?>
							<?php  } } ?>
						</div>
				</div>
			</div>
				<!--------发布广告----------->
				<div class="tab_con ">
					<div class="buying">
						<a class="pay-tt active">买入ETH</a>
						<a class="pay-tt">卖出ETH</a>
					</div>
				</div>
				<!--------我的申诉----------->
				<div class="tab_con">
					<div class="wtf_top">
						<div class="wtf_item">
								<?php  if(is_array($guamai_appeal)) { foreach($guamai_appeal as $appeal) { ?>
							<div class="wtf_item1" onclick="window.location.href = ''">
								<?php  if($appeal['stuas'] == 0) { ?>
								<p>该订单“<?php  echo $appeal['order_id'];?>”,在进行审核。</p>
								<?php  } else if($appeal['stuas'] == 1) { ?>
								<p>该订单“<?php  echo $appeal['order_id'];?>”,审核通过，并对该账号进行处罚。</p>
								<?php  } else if($appeal['stuas'] == 2) { ?>
								<p>该订单“<?php  echo $appeal['order_id'];?>”,该申诉失效。</p>
								<?php  } ?>
								<p><?php  echo $appeal['createtime'];?></p>
							</div>
							<?php  } } ?>
						</div>
					</div>
				</div>

				<!-- <?php  if($appeal['stuas'] == 0) { ?>正在进行审核。<?php  } else if($appeal['stuas'] == 1) { ?>审核通过，并对该账号进行处罚。{else $appeal['stuas'] == 2}该申诉失效.<?php  } ?> -->
			</div>
			<div class="mask0_box hide">
				<!-- 卖出 -->
				<div class="mask0 hide">
					<p>价格(CNY)</p>
					<div class="mask_lis">
						<input type="number" placeholder="请输入卖出的价格" class="maiChu_price">
						<div class="tishi">参考价格：￥<span class="price_Min"><?php  echo $start;?></span>-￥<span class="price_Max"><?php  echo $end;?></span></div>
					</div>
					<div class="mask_lis">
						<p class="mask_lis_p">数量(ETH)</p>
						<input type="number" placeholder="请输入卖出的数量" class="maiChu_Num">
					</div>
					<div class="mask_lis">
						<p>预获金额(CNY)</p>
						<input class="mask_lis_input" type="number" disabled value="0" class="getMoney0">
						<div class="tishi">手续费：<span class="sxf0"><?php  echo $sys['trxsxf'];?></span>%</div>
					</div>
					<div class="mask_lis">
						<p>待付(ETH)</p>
						<input type="number" disabled value="0" class="setTrx0">
					</div>
					<div class="mask0_btn">确定卖出</div>
				</div>

				<!-- 买入 -->
				<div class="mask1">
					<div class="mask1_pice">
						<p>价格(CNY)</p>
						<input type="number" placeholder="请输入买入的价格" class="maiRu_price">
					</div>
					<div class="tishi">参考价格：￥<span class="price_Min"><?php  echo $start;?></span>-￥<span class="price_Max"><?php  echo $end;?></span></div>

					<p>买入数量(ETH)</p>
					<div class="mask1_lis">
						<input type="number" placeholder="请输入购买的数量" class="buyNum">
					</div>
					<div class="mask_lis">
							<p>预获币数(ETH)</p>
						<input class="mask_lis_input" type="number" disabled value="0" class="getMoney0">
						<div class="tishi">手续费：<span class="sxf0"><?php  echo $sys['trxsxf'];?></span>%</div>
					</div>
					<div class="mask_lis">
						<p>预获金额(CNY)</p>
						<input type="number" disabled value="0" style="padding: 5px 10px;width: 100%;" class="mairu_Money">
						<!-- <div class="tishi">预扣手续费<span style="color:#9f2332;">0</span>UES</div> -->
					</div>
					<div class="mask1_btn">确定买入</div>
				</div>
			</div>
			<script type="text/javascript" src="../../../../../../../app/themes/chengzi_bphweizhan/js/jquery-1.8.2.min.js" ></script>
			<!---交易倒计时----->
			<script>

			 $(function(){

			 	var addTimer = function(){
		        var list = [],
		          interval;
		        return function(id,timeStamp){
		          if(!interval){
		             interval = setInterval(go,1);
							}
		          // list.push({ele:document.getElementById(id),time:timeStamp});
							list.push({ele:id,time:timeStamp});
							console.log(list)
		        }
		        function go(){
		          for (var i = 0; i < list.length; i++) {
								for (var t = 0;t<list[i].ele.length; t++){
									list[i].ele[t].innerHTML = (changeTimeStamp(list[i].time[t]))
									var $li = $(list[i].ele[t])
									var hide = $li.parent().parent().children(".buy").children('.fn_cl').attr("data-val")
									 if(hide==2 || hide==3 || hide==0 || hide==4){
									  $li.hide()
									 }
								}
		          }
							}
		         function changeTimeStamp(timeStamp){
					 var	$timeStamp = $(timeStamp).val()
           var distancetime = new Date($timeStamp*1000).getTime() - new Date().getTime();
          if(distancetime > 0){
　　　　　　　　//如果大于0.说明尚未到达截止时间
			/*毫秒*/
            var ms =  Math.floor(distancetime%1000);
            /*秒*/
            var sec = Math.floor(distancetime/1000%60);
            /*分*/
            var min = Math.floor(distancetime/1000/60%60);
            /*小时*/
//          var hour =Math.floor(distancetime/1000/60/60/24);
            if(ms<100){
              ms = "0"+ ms;
            }
            if(sec<10){
              sec = "0"+ sec;
            }
            if(min<10){
              min = "0"+ min;
            }
//          if(hour<10){
//            hour = "0"+ hour;
//          }
            return "倒计时："+min + ":" +sec;
						}
						else{
	　　　　　　　　//若否，就是已经到截止时间了
							return "已截止！"
						}
        }
      }();
      //倒计时位置，时间戳
			var formtime= $(".form .time")
			var order = $(".form .order_time")
			addTimer(order,formtime);
			})


			</script>
		</div>

	</div>

	<!--nav-->

</div>
<script type="text/javascript">
// 申诉原因
$('.button').click(function () {
	let textarea = $('.textarea').val();
	if(textarea == ''){
		alert('请输入申诉原因！')
		return
	}

	console.log(textarea);

	$.ajax({
		type:'post',
		url:"<?php  echo mobileurl('member/guamai/tab_con')?>",
		data:{
			textarea: textarea
		},
		dataType: 'json',
		success:function(data){
			console.log(data);
			if(data.status == '-2'){
				alert(data.result.message);
				location.href="<?php  echo mobileurl('member/wallet')?>";
			}else if(data.status == 1){
				alert(data.result.message);
				location.reload();
			}
		},error:function(err){
			console.log(err);
		}
	})


})
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
            location.href="<?php  echo mobileurl('member/wallet')?>";
          }else if(data.status == 1){
            alert(data.result.message);
            location.reload();
          }else if(data.status == -1){
						alert(data.result.message);
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
        setTrx = Number(num) + Number($('.sxf0').html()*num/100);
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
				let getMoney = muns * $('.maiRu_price').val();
				let getMoney0 = Number($('.buyNum').val())-Number(sxf0);
				// console.log();
        $('.mairu_Money').val(getMoney);
				$('.getMoney0').val(getMoney0);
      } else {
        $('.mairu_Money').val('0');
				$('.getMoney0').val('0');
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
			var sxf0 = $('.sxf0').html()*$('.buyNum').val()/100;
			// Number(sxf0) +
			var muns =  Number($('.buyNum').val());
			let getMoney = muns * $('.maiRu_price').val();
			let getMoney0 = Number($('.buyNum').val())-Number(sxf0);
			console.log($('.buyNum').val());
			console.log($('.maiRu_price').val());
			console.log(Number($('.buyNum').val())-Number(sxf0));
			$('.mairu_Money').val(getMoney);
			$('.getMoney0').val(getMoney0);
		} else {
			$('.mairu_Money').val('0');
			$('.getMoney0').val('0');
		}
	})

    // 确定买入
    $('.mask1_btn').click(function () {
      let maiRu_price = $('.maiRu_price').val();
      let price_min = $('.price_Min').html();
      let price_max = $('.price_Max').html();
			let buy_nam = $('.buyNum').val();
			let sxf0 = $('.sxf0').html()*$('.buyNum').val()/100;                // 手续费
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
					type: "0",
					sxf0:sxf0
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
          }else if(data.status == -1){
						alert(data.result.message);
					}

        },error:function(err){
          console.log(err);
        }
      })



    })
	$(function() {
		//tab切换
		$(".box_nav .con_on").on("click", function() {
			var index=$(this).index();
			$('.tab_cut').hide()
			$(this).addClass("on").siblings().removeClass("on");
			//内容切换
			 $(".tab_content .tab_con").eq(index).addClass("active").siblings().removeClass("active");
			// $(".tab_content .tab_con").eq(index).show().siblings().hide();
		//买入卖出切换
		if(index == 0){
			$('.tab_cut').show()
		}else {
			$('.tab_cut').hide()
		}
		if($(this).index() == 1) {
				$(".mask0_box").show()
			} else {
				$(".mask0_box").hide()
			}
		})

		//我的订单 状态切换
		$(".tab_item>a").click(function(e){
		   e.preventDefault();
			 let data = $(this).attr('data-id')
			 let li = $(this).parent();
			 let index = li.index();
			 $('.my_order').css('left',-index+'00%');//状态切换
			 li.addClass("active").siblings().removeClass('active');
			 //$('.my_order .tab_cont').eq(index).addClass('active').siblings().removeClass('active')
		})
	})

	// 买入卖出
	$(".buying .pay-tt").click(function() {
		var $a = $(this)
		$('.tab_cut').hide()
		$a.addClass("active").siblings().removeClass("active")
		// $a.show().siblings().hide()
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
