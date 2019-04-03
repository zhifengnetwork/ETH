<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	.all{background: #071a21;padding: 2.2rem 0 2.7rem 0;background: #071a21;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;overflow-y: scroll;height: 100%;}

	.se_tank{width: 100%;background: #0a181f;}
    .se_title{margin-top: 1rem;margin-left: 0.3rem;}
    .se_title span{font-size: 0.7rem;color: #fff;}
    .se_title input{width: 70%;height: 1.5rem;border: none;outline: none;border-radius: 0.2rem;padding-left: 0.2rem;}
	.se_tank h2{font-size: 0.8rem;color: #fff;font-weight: inherit;line-height: 2.5rem;}
	.se_tank_span{position: absolute;top: 3%;right: 5%;color: #fff;font-size: 0.8rem;}
	.se_tank_con{margin-top: 0.7rem;margin-left: 0.3rem;}
	.se_tank_con textarea{border-radius: 0.2rem; width: 70%;height: 4rem;resize: none;border: none;padding: 0.3rem;font-size: 0.65rem;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}
	.se_tank_con p{font-size: 0.7rem;color: #fff;display: inline-block;vertical-align:top;}
	.se_tank_btn{width: 80%;height: 6.5rem;line-height: 6.5rem;margin: 0 auto;}
	.se_tank_btn button{width: 100%;height: 1.6rem;background: #0a0;border: none;color: #fff;border-radius: 0.2rem;}

	.tipsText{line-height: 0.3rem;}
	.renderingRrpa{padding-top: 0.88rem;box-sizing: border-box;}

	.uploadWrap p{font-size: 0.3rem;color: #fff;text-align: center;line-height: 0.8rem;}
	.imageEchoBox{width: 100%;height: 5rem;margin: 0 auto;background: #f5f5f5;border-radius: 0.2rem;position: relative;}
	ul li{list-style: none;}
	.imageEchoBox span{width: 100%;font-size: 0.24rem;color: #000;position: absolute;top: 45%;left: 22%;border-radius: 0.09rem;line-height: 0.6rem;}
	.imageEchoBox ul li{float: left;width: 25%;line-height: 5rem;height: 5rem;}
	.imageEchoBox img{/* position: absolute; top: 50%;left: 50%;transform: translate(-50%,-50%);*/ max-width: 100%;max-height: 100%;}

	.uploadFile{border-radius: 0.2rem;width: 100% !important;height: 1.4rem;line-height: 1.4rem;position: absolute;top: 110%;left: 0%;opacity: 0;z-index: 10;}
	.uploadFile2{border-radius: 0.2rem; width: 100%;height:1.4rem;font-size: 0.23rem; position: absolute;top: 110%;left: 0%;color: #000;background: #f5f5f5;text-align: center;line-height: 1.4rem;}

	.decideToSell{width: 100%;margin: 0 auto;margin-bottom: 1rem;}
	.decideToSell p{letter-spacing: 0.02rem; font-size: 0.3rem; background: #f5f5f5;color: #000;padding: 0.2rem 0;text-align: center;border-radius: 0.1rem;display: block;}

	.popover_box span{font-size: 0.3rem;}
	.popover_box{width: 80%;margin: 0 auto;border-radius: 0.2rem;padding-top: 0.5rem;}
</style>
<div class="all">


<div class="fui-header">

		<div class="fui-header-left">
			<a class="back"></a>
		</div>

		<div class="title">申诉</div>
		<div class="fui-header-right" data-type="0">
			<!-- <i class="fui-header-right icon icon-add4"></i> -->
		</div>
	</div>

	<div class="se_tank">
    	<!--<span class="se_tank_span">X</span>-->
    	<div class="se_title">
    		<span>申诉标题:</span>
    		<input class="text" name="text" type="text" />
    	</div>
    	<div class="se_tank_con">
    		<p>申诉内容:</p>
    		<textarea class="textarea"></textarea>
    	</div>
    	<div class="popover_box clearfix">
			<!-- '创建一个image对象'，给canvas绘制使用 -->
			<canvas id="canvas" style="display: none;"></canvas>
			<div class="imageEchoBox">
				<span class="tipsText" style="font-size: 0.2rem !important;">请点击“选择图片”上传二维码。</span>
				<!--渲染图片-->
				<ul class="upImgUl">
       
				</ul>
				<!--上传图片 tyle='file'-->
				<a class="uploadFile2" href=" ">选择图片</a>
				<input type="hidden" class="files" value="">
				<input class="uploadFile" type="file" onchange="UpLoad(this)" name="file" id="" value="" accept="image/*" multiple />
			</div>
		</div>
    	<div class="se_tank_btn">
    		<a><button class="button">确定</button></a>
    	</div>

    </div>
</div>
<script>
  	/*存储base64路径=>后台*/
  	var upImgArr = [];
  	/*记录上传图片的张数=>ajax（puah路径完成）*/
  	var countN = null;
	/*上传图片*/
	function UpLoad(e) {
		/*保存 点击对应的this*/
		var that = $(e);
		console.log('多张图片！',e.files);
		/*初始化*/
		//upImgArr = [];
		if(e.files) {
			/* 提示文字，隐藏 */
			that.siblings(".tipsText").hide();
			var f = e.files;
			console.log(8989,f);
			if(f.length > 4){
				alert('上传图片不能超过4张!');
				return;
			}
			/*判断什么时候ajax（puah路径完成）*/
			countN = f.length;
			/*循环得出图片路径*/
			for(var i=0;i<f.length;i++){
				fileType = f[i]['type'];
				if(/image\/\w+/.test(fileType)) {
					var fileReader = new FileReader();
					fileReader.readAsDataURL(f[i]);
					fileReader.onload = function(event) {
						var result = event.target.result; //返回的dataURL
						var image = new Image();
						image.src = result;
						//若图片大小大于1M，压缩后再上传，否则直接上传
						if(f.size > 1024 * 1024) {
							image.onload = function() {
								//创建一个image对象，给canvas绘制使用
								var canvas = document.getElementById("canvas");
								canvas.width = image.width;
								canvas.height = image.height; //计算等比缩小后图片宽高
								var ctx = canvas.getContext('2d');
								ctx.drawImage(this, 0, 0, canvas.width, canvas.height);
								var newImageData = canvas.toDataURL(fileType, 0.8); //重新生成图片
								$("#canvas").hide();
								/*把路径丢进公共的数组里=>后台*/
								upImgArr.push(newImageData);

								/*调用ajax请求函数*/
								upImgAjax();

							}
						} else {
							//创建一个image对象，给canvas绘制使用
							image.onload = function() {
//								console.log(456,result);
								upImgArr.push(result);
								/*调用ajax请求函数*/
								upImgAjax();

							}
						}

					}
				} else {
					alert("请选择图片");
				}


			}
		} else {
			console.log('取消选择图片！');
		}
	}
	/*上传图片ajax*/
	function upImgAjax(){
		console.log(upImgArr);
		/*判断数组push完成*/
		if(countN == upImgArr.length){
			console.log('数组push完成，可以ajax！');
			$.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/upimgarray')?>",
        data:{images:upImgArr},
        dataType:'json',
        success:function(data){
					/*创建标签*/
					var strImg = '';
					$('.files').val(data.result);
					console.log(data.result)
					for(var j=0;j<data.result.length;j++){
						strImg += '<li><img src="../attachment/'+ data.result[j] +'" /> </li>';
					}
					/*渲染图片*/
					$('.upImgUl').html(strImg);
        },error:function(err){
          console.log(err);
        }
      })
		}
	}
</script>
<script>
    $(".button").click(function(){
      let id = "<?php  echo $id;?>";
      let text = $(".text").val();
      let files = $(".files").val();
      let textarea = $(".textarea").val();
			// console.log(files);
      $.ajax({
        type:'post',
        url:"<?php  echo mobileurl('member/guamai/tab_con')?>",
        data:{id:id,text:text,textarea:textarea,files:files},
        dataType:'json',
        success:function(data){
          // console.log(data);
          if(data.status == 1){
						if(confirm(data.result.message)){
							location.href="<?php  echo mobileurl('member/guamai/number_order')?>";
						}else {
							console.log('取消!')
						}
            // alert(data.result.message);
            // // history.back(-1);
						// location.href="<?php  echo mobileurl('member/guamai/number_order')?>";
            // $(".se_tank").css('height',0);
          }
        },error:function(err){
          console.log(err);
        }
      })
    });
  </script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
