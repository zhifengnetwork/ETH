<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style type='text/css'>

	.feed-activity-list {

		width: 96%;

		overflow: hidden;

		display: flex;

		flex-flow:row wrap;

		justify-content:flex-start; 

	    margin: 0 0 0 8%;
		/*border-right: 1px dashed #666; */

	}



	.feed-element {

		float: left;

		width: 320px;

		/*height:100px;*/

		margin-left: 15px;

		margin-bottom: 20px;

		/*border:1px solid #efefef;*/

		padding: 20px;

	}

	

	.feed-element::after {

		display: none

	}

	

	.feed-element .title {

		font-size: 14px;

		height: 24px;

		line-height: 24px;

		vertical-align: bottom;

		color: #333;

		font-weight: bold;

		margin-left: 10px;

	}

	.feed-element img.img-circle,

	.dropdown-messages-box img.img-circle {

		float: left;

		width: 60px;

		height: 60px;

		border-radius: 4px;

	}

	

	.media-body {

		margin-top: 3px;

	}

	.text-muted{

		margin-left:10px;

		width:200px;

		display: block;

		overflow : hidden;

		text-overflow: ellipsis;

		display: -webkit-box;

		-webkit-line-clamp: 2;

		-webkit-box-orient: vertical;

	}
	/*波浪线*/
	/*.kinds-list{
		width:27%;
		max-height: 1800px;
		min-height: 1200px;
		float:left;  
		margin-right: 10px;
		position: relative;
	    background: url(../addons/ewei_shopv2/static/images/listbg.png) right no-repeat;
    	background-size: 4%;
	}*/
	.kinds-list{
		/*width: 310px;*/
		width:100%;
		/*max-height: 1800px;*/
		/*min-height: 1200px;*/
		float:left;  
		/*margin-right: 30px;*/
		margin-right: 10px;
		position: relative;
	    /*background: url(../addons/ewei_shopv2/static/images/listbg.png) right no-repeat;*/
    	background-size: 4%;
	}
	.kinds-list>img{
	    width: 76px;
	    position: absolute;
	    top: -10px;
	    left: -10px;
	}
	/*波浪*/
	/*.kinds-list:last-child{
		background: white;    width: 15%;
	}*/
	/*.kinds-list:last-child .list-box{
		margin: 0 10% 35px 36%;
	    width: 48%;
	}*/
	/*.kinds-list:last-child .panel-heading{
	    padding:10px 26px 30px 71px;
	}*/
	.media-body, .media-left, .media-right{
		display: block;width: 100%;
	}
	.page-content{
		width:95%;
	    margin: 0 0 0 4%;
    	box-shadow: 1px 1px 10px #ccc;
	}
	/*波浪*/
	/*.list-box{	    
		width: 27%;
	    max-width: 120px;
	    max-height:200px;
	    float: left;
	    text-align: center;
	    margin: 0 5% 35px 11%;
		background-size: 100%;
	}*/
	.list-box{	    
	    width: 9%;
	    max-width:80px;
	    max-height: 200px;
	    float: left;
	    text-align: center;
	    margin: 0 1% 35px 3%;
	    background-size: 100%;
	}
	.list-box:hover img{
		transform: scale(1.1);
	}
	.feed-element{
		width:85%;
		/*height:100px;*/
		text-align: center;
		padding:  0;
		/*border-radius: 50%;border:1px solid #555;*/
	    margin: 0 0% 10px 0%;
	    /*margin:0;*/
	    background: rgb(85,93,104);
    	border-radius: 26px;
	}
	.feed-element img.img-circle, .dropdown-messages-box img.img-circle{
		float:none;
		width: 80%;
    	height: 80%;
	    border-radius: 4px;
	}
	/*.kinds-list:nth-child(3) .list-box:nth-child(2) .title,.kinds-list:nth-of-type(3) .list-box:nth-of-type(6) .title{
	    font-size: 14px;
	    margin: 19% 0 0 5%;
	    padding: 0 10px 0 10px;
        display: -webkit-box;
	    -webkit-line-clamp: 2;
	    overflow: hidden;
	    -webkit-box-orient: vertical;
	}*/
	/*蓝*/
	.kinds-list:nth-of-type(1) .list-box:nth-of-type(1) .feed-element,.kinds-list:nth-of-type(2) .list-box:nth-of-type(3) .feed-element{
		background: rgb(102,145,200);  
	}
	/*绿*/
	.kinds-list:nth-of-type(1) .list-box:nth-of-type(2) .feed-element,.kinds-list:nth-of-type(3) .list-box:nth-of-type(6) .feed-element{
		background: rgb(78,181,125);
	}
	/*紫*/
	.kinds-list:nth-of-type(1) .list-box:nth-of-type(3) .feed-element,.kinds-list:nth-of-type(3) .list-box:nth-of-type(2) .feed-element{
		background: rgb(123,91,166);
	}
	/*橙*/
	.kinds-list:nth-of-type(1) .list-box:nth-of-type(5) .feed-element,.kinds-list:nth-of-type(3) .list-box:nth-of-type(3) .feed-element,.kinds-list:nth-of-type(4) .list-box:nth-of-type(1) .feed-element{
		background: rgb(195,108,55);
	}
	/*红*/
	.kinds-list:nth-of-type(1) .list-box:nth-of-type(6) .feed-element,.kinds-list:nth-of-type(2) .list-box:nth-of-type(8) .feed-element,.kinds-list:nth-of-type(4) .list-box:nth-of-type(4) .feed-element{
		background: rgb(205,81,81);
	}
	/*不同行数box 背景*/
	/*.kinds-list .list-box:nth-of-type(1),.kinds-list .list-box:nth-of-type(2){
		background:url(../addons/ewei_shopv2/static/images/listbg1.png) no-repeat;
		background-size: 100%;
	}
	.kinds-list .list-box:nth-of-type(3),.kinds-list .list-box:nth-of-type(4){
		background:url(../addons/ewei_shopv2/static/images/listbg2.png) no-repeat;
		background-size: 100%;
	}
	.kinds-list .list-box:nth-of-type(5),.kinds-list .list-box:nth-of-type(6){
		background:url(../addons/ewei_shopv2/static/images/listbg3.png) no-repeat;
		background-size: 100%;
	}
	.kinds-list .list-box:nth-of-type(7),.kinds-list .list-box:nth-of-type(8){
		background:url(../addons/ewei_shopv2/static/images/listbg4.png) no-repeat;
		background-size: 100%;
	}
	.kinds-list .list-box:nth-of-type(9),.kinds-list .list-box:nth-of-type(10){
		background:url(../addons/ewei_shopv2/static/images/listbg5.png) no-repeat;
		background-size: 100%;
	}*/
	.title{
	    color: rgb(81,81,81);
	    font-weight: bold;
	    font-size: 16px;
	    width: 100%;
	    /*margin: 27% 0 0 5%;*/
	    display: block;
	    float: left;
	}
	/*波浪线*/
	/*.panel-heading{
	    padding: 10px 100px 30px 92px;
	    font-size: 16px;
	    color: #555;
	    text-align: center;
	}*/
	.panel-heading{
		width:95%;
	    padding: 10px 100px 10px 15px;
	    font-size: 16px;
	    color: #555;
	    margin-left:69px;
	    margin-bottom:70px;
	    border-bottom: 2px solid #ccc;
	}
	.panel-heading p{
	    font-size: 20px;
    	color:transparent;
    	
	}
	.panel-heading p img{
		width: 100%;
	}
	.panel-heading span{
		/*position: absolute;*/
        /*top: 15px;*/
	    /*padding: 3px 5px;*/
	    /*left: 111px;*/
	    font-size: 17px;
	    font-weight: bold;
	}
</style>

<div class="page-header">

	<img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置：<span class="text-primary">我的应用</span>

</div>



<div class="page-content">

	<div class='panel panel-default' style='border:none;'>

		<?php  if(is_array($category)) { foreach($category as $ck => $cv) { ?>
		
		<?php  if(count($cv['plugins'])<=0) { ?><?php  continue;?><?php  } ?>
		<!-- 分类 -->
		<div class="kinds-list">

			<img class="kind-img" src="../addons/ewei_shopv2/static/images/fuzhu.png">

			<div class="panel-heading" style='background:none;'>
				<p><!-- //////// -->
					<!-- <img src="../addons/ewei_shopv2/static/images/panel1.png"> -->
				</p>
					<span><?php  echo $cv['name'];?></span>
				
			</div>

			<div class="feed-activity-list">

				<?php  if(is_array($cv['plugins'])) { foreach($cv['plugins'] as $plugin) { ?>
				
				

				<?php if(cv($plugin['identity'])) { ?>
				<div class="list-box">
					
					<a class="feed-element" href="<?php  echo webUrl($plugin['identity'])?>">

								<span class="">

									<img src="<?php  echo tomedia($plugin['thumb'])?>" class="img-circle" alt="image" onerror="this.src='../addons/ewei_shopv2/static/images/yingyong.png'">

								</span>


						<div class="media-body ">

							

							<!-- <small class="text-muted"><?php  echo $plugin['desc'];?></small> -->

						</div>

					</a>
					<span class="title"><?php  echo $plugin['name'];?></span>

					<br>
				</div>
				

				<?php  } ?>

				<?php  } } ?>

			</div>
		</div>
		<?php  } } ?>

	</div>

</div>

<script>

	$(document).ready(function () {
		$('.kind-img').eq(0).attr('src','../addons/ewei_shopv2/static/images/yewu.png');
		$('.kind-img').eq(1).attr('src','../addons/ewei_shopv2/static/images/yingxiao.png');
		$('.kind-img').eq(2).attr('src','../addons/ewei_shopv2/static/images/gongju.png');
		$('.erji').remove();

		$('.wb-container').css('margin-left','0');

		$('.kind-list').eq(3).children().eq(5).children().css('margin-top','14%');

		$('.feed-activity-list,.plugin_tabs').each(function(){

			if($(this).children().length<=0){

				$(this).prev().remove();

				$(this).remove();

			}

		});
		

		// 删除title中的人
		$('.title').each(function(){
			var html = $(this).html();
			var reg = new RegExp("人","g");
			var a = html.replace(reg,'');
			// console.log(html,a);
			$(this).html(a);
		});
		
		function Boxresize(){
			// var heightBox = $('.list-box').css('height');
			// var height = parseInt($('.feed-element').css('width'))*1+50+'px';
			var width = $('.list-box').css('width');
			$('.feed-element').css({'height':width,'line-height':width,'width':width});
			// $('.list-box').css('width',width);
			// console.log($('.list-box').css('width'));
		}
		Boxresize();
		$(window).resize(function(){

			Boxresize()
		})
		
		// 添加背景虚线
		// var p = $('.panel-heading p');
		// var srcAtt = ['panel1.png','panel2.png','panel3.png','panel4.png'];

		// p.each(function(i){
		// 	var img = '<img src="../addons/ewei_shopv2/static/images/'+srcAtt[i]+'">'
		// 	$(this).html(img);
		// })
	})

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
