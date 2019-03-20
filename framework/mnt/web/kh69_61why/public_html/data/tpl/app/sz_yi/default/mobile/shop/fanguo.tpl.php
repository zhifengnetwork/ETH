<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>返果明细</title>
<style>
    body { font-family: "Microsoft Yahei", "宋体", "Helvetica Neue", Helvetica, sans-serif; max-width: 768px; margin: 0 auto !important; background: #ebebeb;}
    html { font-size: 62.5%; }
    body, ul, li, img, a, h3{ margin: 0; padding: 0; }
    ul{list-style: none}
    img { width: 100%; display: block; border: 0; }
    a:link, a:visited { color: #333333; text-decoration: none; }
    a:hover { color: #FF850E; text-decoration: none; }
    .clearfix:after { content: '\0020'; display: block; height: 0; clear: both; visibility: hidden }
    .clearfix { *zoom: 1 }
    /*头部*/
    .hs-entrepot-top{height: 42px;line-height: 42px;overflow: hidden;background: #fff;}
    .hs-entrepot-top a{color: #6c6cef;text-align: center;width: 33%;display: inline-block;font-size: 14px;float: left;border-left: 1px solid #eee;margin-left: -1px}
    .hs-entrepot-top a.on{color: #fff;background: #6c6cef}
    /*entrepot*/
    .hs-entrepot{}
    .hs-entrepot .hs-entrepot-ul0{width: 100%; line-height: 24px; font-size: 14px;}
    .hs-entrepot .hs-entrepot-ul0 li{ display: block; width: 100%; margin:0px auto;text-indent: 20px; line-height: 35px;margin-top: 5px; background: #fff;}
    .hs-entrepot .hs-entrepot-ul0 li p{display: block; padding: 0px; margin: 0px;  }
    .hs-entrepot .hs-entrepot-ul0 li .hs-entrepot-fl{float: left;width: 35%}
    .hs-entrepot .hs-entrepot-ul0 li .hs-entrepot-fr{float: left;width: 65%}
    .hs-entrepot .hs-entrepot-ul0 li .hs-entrepot-input { width: 94%; border: 1px solid #ddd; background: #fff; height: 28px; line-height: 28px;padding: 0 2%;}
    .text-red{color: red;vertical-align: -3px;margin-right: 3px}
    .hs-entrepot-btn { background: #6c6cef; color: #fff; height: 35px; white-space: nowrap; text-overflow: ellipsis; font-size: 14px; cursor: pointer; line-height: 35px;width: 30%;margin: 0 auto;text-align: center;border-radius: 5px}
    .hs-entrepot-tt{color: red;padding: 0 10px;margin-bottom: 10px}
    .hs-entrepot-ul2 li{background: #fff;overflow: hidden;border-top: 1px solid #eee;padding: 10px}
    .hs-entrepot-con-fl{float: left;}
    .hs-entrepot-con-fl img{width: 80px;height: 80px;background: #eee}
    .hs-entrepot-con-fr{float: left;margin-left: 10px;line-height: 25px}
    .hs-entrepot > div {display: none;}
    /*版权信息*/
    .copyright{margin-top: 20px}
    .copyright_ul{overflow: hidden;width: 90%;margin: 0 auto;}
    .copyright_ul li{float: left;text-align: center;width: 25%;position: relative;}
    .copyright_ul li a{text-decoration: none;color: #999}
    .copyright_ul li span{position: absolute;right: -2px;color: #666}
    .copyright_bottom{text-align: center;color: #999;line-height: 30px}
    
    .order_top {height:44px; width:100%;  background:#f8f8f8;  border-bottom:1px solid #e3e3e3;}
	.order_top .title {height:44px; width:100%;text-align: center; font-size:16px; line-height:44px; color:#666;}
    .order_top .title i{ float: left;height: 44px; line-height: 44px; }
</style>
<div class="order_top">
    <div class="title" onclick="history.back()"><i class="fa fa-chevron-left"></i> 返果明细</div>
</div>
<div class="hs-entrepot-top">
    <a data-id="1" class="on" href="javascipt:;">下一级</a>
    <a data-id="2" href="javascipt:;">下二级</a>
    <a data-id="3" href="javascipt:;">下三级</a>
</div>
<div class="hs-entrepot">
    <div class="on1" style="display: block;">
        <ul class="hs-entrepot-ul0">
        	总数:+<?php  echo $count_yiji;?>
           <?php  if(is_array($yiji)) { foreach($yiji as $v) { ?>
			<li><p>收获人姓名：<?php  echo $v['nickname'];?></p><p>返果数量：    <?php  echo $v['yiji'];?> 时间:<?php  echo date("Y-m-d H:i:s",$v['time'])?></p></li>
       		<?php  } } ?>
        </ul>
    </div>
    <div class="on2">
   	
        <ul class="hs-entrepot-ul0">
        	 总数:+<?php  echo $count_erji;?>
        	<?php  if(is_array($erji)) { foreach($erji as $v) { ?>
           	<li><p>收获人姓名：<?php  echo $v['nickname'];?></p><p>返果数量：    <?php  echo $v['erji'];?> 时间:<?php  echo date("Y-m-d H:i:s",$v['time'])?></p></li>
       		<?php  } } ?>
        </ul>
    </div>
    <div class="on3">
    <ul class="hs-entrepot-ul0">
     		总数:+<?php  echo $count_sanji;?>
        <?php  if(is_array($sanji)) { foreach($sanji as $v) { ?>
           	<li><p>收获人姓名：<?php  echo $v['nickname'];?></p><p>返果数量：    <?php  echo $v['sanji'];?> 时间:<?php  echo date("Y-m-d H:i:s",$v['time'])?></p></li>
       <?php  } } ?>
    </div>
</div>
<script type="text/javascript">
	require(['core','tpl'],function(core,tpl){
	    $(".hs-entrepot-top a").unbind("click").click(function(){
	        if($(this).attr('class')=='on'){
	            return;
	        }else{
	            var id = $(this).attr("data-id");
	            $(".hs-entrepot-top a").removeClass('on');
	            $(this).addClass('on');
	            $(".hs-entrepot > div").hide();
	            $(".hs-entrepot > div.on"+id).show();
	        }
	    });
	    $("#pay").unbind("click").click(function(){
	        var num = $("#num").val();
	        var yuanguo = parseInt($("#yuanguo").text());
	        if(num=="" || num==0){
	            core.tip.show('请输入正确的出售数量!');
	            return;
	        }
	        if(num<0 || num>yuanguo){
	            core.tip.show('请输入正确的出售数量!');
	            return;
	        }           
	        core.json('shop/entrepot',{
	            'op':'duihuan',
	            'num':num
	        }, function(json) { 
	            // console.log(json);
	            if(json.status==1){
	                core.tip.show(json.result);  
	                location.reload();
	            }else{
	                core.tip.show("网络错误！");            
	            }
	        },true,true);
	    });
	});
</script>
<!-- 版权消息 -->
<?php  $show_footer=true;$footer_current ='shouye'?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>