<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
	<?php if( ce('shop.goods' ,$item) ) { ?>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <label class="col-xs-12 col-sm-3 col-md-3 control-label">快速选择</label>
	    <div class="col-sm-9 col-xs-12">
	          <select id='selectdetail' class='form-control' onchange="selectDetail()">
	          	<option datas-datas=''>--快速选择--</option>
	          	<?php  if(is_array($details)) { foreach($details as $detail) { ?>
	          	<option data-datas='<?php  echo json_encode($detail)?>'>
	          		<?php  echo $detail['detail_shopname'];?>
	          	</option>
	          	<?php  } } ?>
	          		
	          </select>
	    </div>
	</div>
	<script type="text/javascript">
		function selectDetail(){
			
			var json = $('#selectdetail').find("option:selected").data('datas');
			 
			
			$(':input[name=detail_shopname]').val(json.detail_shopname);
			$(':input[name=detail_totaltitle]').val(json.detail_totaltitle);
			$(':input[name=detail_btntext1]').val(json.detail_btntext1);
			$(':input[name=detail_btnurl1]').val(json.detail_btnurl1);
			$(':input[name=detail_btntext2]').val(json.detail_btntext2);
			$(':input[name=detail_btnurl2]').val(json.detail_btnurl2);
			
			$(':input[name=detail_logo]').val(json.detail_logo);
			$('.detail-logo img').attr('src', json.detail_logo_url);
			
		}
	</script>
	<?php  } ?>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <label class="col-xs-12 col-sm-3 col-md-3 control-label">店铺LOGO</label>
	    <div class="col-sm-9 col-xs-12 detail-logo">
	             <?php if( ce('shop.goods' ,$item) ) { ?>
	        <?php  echo tpl_form_field_image('detail_logo', $item['detail_logo'])?>
	        <span class="help-block">建议尺寸: 100 * 100 ，或正方型图片 </span>
	          <?php  } else { ?>
	            <?php  if(!empty($item['detail_logo'])) { ?>
	            <a href='<?php  echo tomedia($item['detail_logo'])?>' target='_blank'>
	            <img src="<?php  echo tomedia($item['detail_logo'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
	             </a>
	            <?php  } ?>
	        <?php  } ?>
	    </div>
	</div>
</div>
<div class="form-group">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <label class="col-xs-12 col-sm-3 col-md-3 control-label">店铺名称</label>
	    <div class="col-sm-9 col-xs-12">
	           <?php if( ce('shop.goods' ,$item) ) { ?>
	        <input type="text" name="detail_shopname"  class="form-control" value="<?php  echo $item['detail_shopname'];?>" />
	        <span class='help-block'>如果不填写，系统默认选择小店或商城名称</span>
	        <?php  } else { ?>
	        <div class='form-control-static'><?php  echo $item['detail_shopname'];?></div> 
	        <?php  } ?>
	    </div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <label class="col-xs-12 col-sm-3 col-md-3 control-label">全部宝贝x个</label>
	    <div class="col-sm-9 col-xs-12">
	           <?php if( ce('shop.goods' ,$item) ) { ?>
	        <input type="text" name="detail_totaltitle" class="form-control" value="<?php  echo $item['detail_totaltitle'];?>" />
	        <span class='help-block'>如果不填写，系统默认显示全部宝贝数</span>
	        <?php  } else { ?>
	        <div class='form-control-static'><?php  echo $item['detail_totaltitle'];?></div>
	        <?php  } ?>
	    </div>
	</div>
</div>

<div class="form-group">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <label class="col-xs-12 col-sm-3 col-md-3 control-label">查看所有商品</label>
	    <div class="col-sm-9 col-xs-12">
	        <?php if( ce('shop.goods' ,$item) ) { ?>
	        	<input type="text" class="form-control" name="detail_btntext1" value="<?php  echo $item['detail_btntext1'];?>" placeholder="按钮名称" style="width:25%;float:left"  />
	        	<input type="text" class="form-control" name="detail_btnurl1" value="<?php  echo $item['detail_btnurl1'];?>" placeholder="按钮完整连接" style="width:75%;" />
	        	<span class='help-block'>如果不填写，系统默认"查看所有商品"及"默认的全部商品连接"</span>
	        <?php  } else { ?>
	        	<div class='form-control-static'><?php  echo $item['btn_text1'];?> / <?php echo empty($item['btn_url1'])?'默认':$item['btn_url1']?></div>
	        <?php  } ?>
	    </div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <label class="col-xs-12 col-sm-3 col-md-3 control-label">进店逛逛</label>
	    <div class="col-sm-9 col-xs-12">
	        <?php if( ce('shop.goods' ,$item) ) { ?>
	        	<input type="text" class="form-control" name="detail_btntext2" value="<?php  echo $item['detail_btntext2'];?>" placeholder="按钮名称" style="width:25%;float:left"  />
	        	<input type="text" class="form-control" name="detail_btnurl2" value="<?php  echo $item['detail_btnurl2'];?>" placeholder="按钮完整连接" style="width:75%;" />
	        	<span class='help-block'>如果不填写，系统默认"进店逛逛"及"默认的小店或商城连接"</span>
	        <?php  } else { ?>
	        	<div class='form-control-static'><?php  echo $item['detail_btntext2'];?> / <?php echo empty($item['detail_url2'])?'默认':$item['detail_url2']?></div>
	        <?php  } ?>
	    </div>
	</div>
</div>