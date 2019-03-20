<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon-new.css?v=2017030302">
<style type="text/css">
	
   .box{
    padding:1px 0%;background: white;display: none;
   }
   .box li{
    position: relative;margin:20px 0;list-style: none;
   }
   .box li img{
    width: 40px;vertical-align: middle;
   }
   .box .bank img,.box .zfb img,.box .wx img{
   	width: 70%;
   }
   .box li input{
    position: absolute;
    right:0;top:10px;
   }
   .bank,.zfb,.wx{
   	display: none;text-align: center;
   }
   #bank,#zfb,#wx{
   	display: none;
   }
   .skadress{
   	display: none
   }
   .qbadress{
		display: flex;
		-webkit-display:flex;
	    margin: 0 0 0px 0;
	    padding: 10px 3%;
	    background: white;
	}
	.qbadress .fui-content-title{
		width: 3.85rem
	}
	.qbadress .fui-content-box{
		flex:3;
	}
	.fui-content-title:nth-of-type(1){
		line-height: 8rem
	}
	.fui-content-title:nth-of-type(2){
		line-height: 39px;
	}
	.fui-content-box input{
		height: 39px;
	    width: 100%;
	    display: block;
	    padding: 0px;
	    margin: 0px;
	    border: 0px;
	    float: left;
	    font-size: 0.7rem;
	    border-bottom: 1px solid #ccc;
	}
	.images{
		text-align: center;
	}
	.images img{
		width: 8rem;height:8rem;
	}
	#imgFile0{
		position:absolute;width:8rem;height:8rem;-webkit-tap-highlight-color: transparent;filter:alpha(Opacity=0); opacity: 0;    left: 15%;cursor: pointer;z-index: 999;
	}
	.btn-sub{
		width: 90%;position: relative;/*bottom:10%;*/left:5%;
	}
	.fui-content .fui-cell-group .erweima{
		display: none;
	}
	.erweima img{
		width: 8rem;
    	height: 8rem;
	}
</style>
<div class='fui-page fui-page-current'>

    <div class="fui-header">

		<div class="fui-header-left">

			<a class="back"></a>

		</div>

		<div class="title">投资购买</div> 

		<div class="fui-header-right">&nbsp;</div>

    </div>

    <div class='fui-content navbar' >

		<input type="hidden" id="logid" value="<?php  echo $logid;?>" />

		<input type="hidden" id="couponid" value="" />

		<div class='fui-cell-group'>

			<div class='fui-cell'>

				<div class='fui-cell-label'>当前投资额</div>

				<div class='fui-cell-info'><?php  echo number_format($member['credit1'],2)?></div>

			</div>

			<div class='fui-cell'>

				<div class='fui-cell-label'><?php  if($member['type']==0) { ?>激活投资<?php  } else if($member['type']==1) { ?>追加投资<?php  } ?></div>

				<div class='fui-cell-info'><input type='number' class='fui-input' id='money' value="<?php  echo $_GPC['money'];?>"></div>

			</div>

			<div class='fui-cell'>

				账户投资上限：<?php  echo $sys['bibi'];?><br>

				当前最多可投资：<?php  echo $sys['bibi']-$member['credit1']?>

			</div>

			<div class='fui-cell erweima'>

				<div class='fui-cell-label'>二维码</div>

				<div class='fui-cell-info' style="text-align: center;">
					<img id="erweima" src="../addons/ewei_shopv2/template/mobile/default/static/images/wx.png">  
				</div>
				<!-- <li id="wx">
		              
		           
		            <div class="wx">
		            	<img src="">
		            </div>  
		        </li> -->
			</div>
			
			<div class='fui-cell skadress' style="display: none">

				<div class='fui-cell-label'>收款地址</div>

				<div class='fui-cell-info'><input type='text' class='fui-input' id='skaddress' value="<?php  echo $_GPC['address'];?>"></div>

			</div>

		</div>

		<div class='fui-cell-group'>

			<?php  if(com('coupon')) { ?>

			<div class='fui-cell' id='coupondiv' style='display:none'>

				<div class='fui-cell-label' style='width:auto'>优惠券</div>

				<div class='fui-cell-info'></div>

				<div class='fui-cell-remark'>

					<div class='badge' style='display:none'>0</div>

					<span class='text'>无可用</span>

				</div>

			</div>

			<?php  } ?>

		</div>


<div class="box">
 <!-- 
    <ul>
        <li id="bank">
            <img src="../addons/ewei_shopv2/template/mobile/default/static/images/qianbao.png">  
            <span>银行卡</span>  
            <div class="bank" >
            	<img src="">
            </div>
        </li>

        <li id="zfb">
            <img src="../addons/ewei_shopv2/template/mobile/default/static/images/zfb.png">    
            <span>支付宝</span> 
            <div class="zfb">
            	<img src="">
            </div> 
        </li>

        
    </ul> -->
    <div class="qbadress">
	    <div class="fui-content-title" >

	    			支付凭证
		</div>
		<div class="fui-content-box">
		    <div class="pic">
				<div class="plus" style="position:relative">
					<i class="fa fa-plus" style="position:absolute;"></i>
					<input type="file" name='imgFile0' id='imgFile0' />
				</div>
				<div class="images">
					<!-- <img  src="<?php  echo $member['walletcode'];?>" /> -->
					<img  src="../addons/ewei_shopv2/static/images/upload.png"  />
					<!-- upload.png为默认图片 -->

				</div>
				<!-- input无图时为空 -->
				<input  type="hidden"  value=""  id="avatar"/>
			</div>
		</div>
	</div>

	<div class="qbadress">
		<button class="btn btn-default btn-sub" >确定购买</button>
	</div>
</div>

<?php  if(!empty($acts)) { ?>

		<div class='fui-cell-group'>

			<div class='fui-according expanded'>

				<div class='fui-according-header'>

					<div class="text">充值活动 

						充值满 <span class='text-danger'><?php  echo $acts[0]['enough'];?></span> 元立即送 <span class='text-danger'><?php  echo $acts[0]['give'];?></span> 元

					</div>

					<?php  if(count($acts)>1) { ?><span class="remark">更多</span><?php  } ?>

				</div>

				<?php  if(count($acts)>1) { ?>

				<div class='fui-according-content'>

					<div class='content-block' style="padding: 0 0.5rem;">

						<div class="fui-cell-group" style="margin-top: 0;">

							<?php  if(is_array($acts)) { foreach($acts as $key => $enough) { ?>

								<?php  if($key>0) { ?>

								<div class="fui-cell" style="">

									<div class="fui-cell-text">充值满 <span class='text-danger'><?php  echo $enough['enough'];?></span> 元立即送 <span class='text-danger'><?php  echo $enough['give'];?></span> 元</div>

								</div>

								<?php  } ?>

							<?php  } } ?>

						</div>

					</div>

				</div>

				<?php  } ?>

			</div>

		</div>

<?php  } ?>

		<a id='btn-next' class='btn btn-success block disabled'>付款</a>
<!-- 
		<?php  if($wechat['success'] || $payinfo['wechat']) { ?>

		<a id='btn-wechat' class='btn btn-success block btn-pay ' style='display:none'>微信支付</a>

		<?php  } ?>

		<?php  if(($alipay['success'] && !is_h5app()) || $payinfo['alipay']) { ?>

		<a id='btn-alipay' class='btn btn-warning  block btn-pay'  style='display:none'>支付宝支付</a>

		<?php  } ?> -->


<script type="text/javascript">
	require(['core'], function( core) {
		/*图片上传*/
			$('#imgFile0').change(function() {
				// core.loading('正在上传');

				var comment =$(this).closest('.comment_main');
				var ogid = comment.data('ogid');

				$.ajaxFileUpload({
					url: core.getUrl('util/uploader'),
					data: {file: "imgFile0"},
					secureuri: false,
					fileElementId: 'imgFile0',
					dataType: 'json',
					success: function(res, status) {
						var src2 = $('.images img').prop('src');
						console.log(res.url);
						if(res.url == undefined){
							return false;
						}
						// core.removeLoading();
						//var obj = $(tpl('tpl_img', res));
						var obj = document.createElement('img');
						obj.src=res.url;
						obj.style.width='8rem';
						obj.style.height='8rem';

						$('.images').html(' ');
						$('.images').append(obj);
						$('#avatar').val(res.url);

					}, error: function(data, status, e) {
						// core.removeLoading();
						core.tip.show('上传失败!');
					}
				});
			});
		/*图片上传*/

		// $('.btn-sub').click(function(){
		// 	// var adress = $('#ad').val();
		// 	var url = $('#avatar').val();
		// 	console.log($('.images img').prop('src'));
		// 	// if($('#ad').isEmpty()){
		// 	// 	core.tip.show('请填写钱包地址！');
		// 	// 	return false;
		// 	// }
		// 	if($('#avatar').isEmpty()){
		// 		core.tip.show('请上传钱包二维码！');
		// 		return false;
		// 	}
		// 	$.ajax({
		// 		url:"<?php  echo mobileUrl('member/recharge/submit')?>",
		// 		type:'post',
		// 		data:{url:url},
		// 		dataType:'json',
		// 		success:function(data){
		// 			if(data.status == 1){
		// 				core.tip.show('上传成功');
		// 				setTimeout(function(){
		// 					window.location.href="<?php  echo mobileUrl('member/assets')?>";
		// 				},1000)
		// 			}
		// 		},error:function(e){
		// 			console.log(e)
		// 		}
		// 	})
		// })
	})
	$('#btn-next').click(function(){
		$('.box').css('display','block');
		$('.skadress').css('display','flex')
	});
	$('.box').on('click','li',function(){
		$('.box div').css('display','none');
		var $this = $(this);
		let id = $this.prop('id');

		$('.'+id+'').show();
	})
</script>


		



    </div>

	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('order/pay/wechat_jie', TEMPLATE_INCLUDEPATH)) : (include template('order/pay/wechat_jie', TEMPLATE_INCLUDEPATH));?>

	<script language='javascript'>

		require(['biz/member/recharge'], function (modal) {

			modal.init({minimumcharge: <?php  echo $minimumcharge?>,wechat: <?php  echo intval($wechat['success'])?>,alipay:<?php  echo intval($alipay['success'])?>});

	});

</script>

</div> 



<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('sale/coupon/util/picker', TEMPLATE_INCLUDEPATH)) : (include template('sale/coupon/util/picker', TEMPLATE_INCLUDEPATH));?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
