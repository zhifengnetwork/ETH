<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>仓库</title>
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
    .hs-entrepot-top{background: #fff;height: 42px;line-height: 42px;overflow: hidden;}
    .hs-entrepot-top a{color: #6c6cef;text-align: center;width: 25%;display: inline-block;font-size: 14px;float: left;border-left: 1px solid #eee;margin-left: -1px}
    .hs-entrepot-top a.on{color: #fff;background: #6c6cef}
    /*entrepot*/
    .hs-entrepot{background: #fff;padding: 10px 0;margin-top: 10px}
    .hs-entrepot .hs-entrepot-ul0{width: 65%; margin: 20px auto;line-height: 30px;font-size: 14px}
    .hs-entrepot .hs-entrepot-ul0 li{overflow:hidden;line-height: 35px}
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
</style>
<div class="hs-entrepot-top">
    <a data-id="1" class="on" href="javascipt:;">原果仓库</a>
    <a data-id="2" href="javascipt:;">功劳薄</a>
    <a data-id="3" href="javascipt:;">宠物养护</a>
    <a data-id="4" href="javascipt:;">互偷记录</a>
</div>
<div class="hs-entrepot">
    <div class="on1" style="display: block;">
        <ul class="hs-entrepot-ul0">
            <li>
                <div class="hs-entrepot-fl"><span class="text-red">*</span>剩余原果： </div>
                <div class="hs-entrepot-fr" id="yuanguo"><?php  echo $yuanguo;?></div>
            </li>
            <li>
                <div class="hs-entrepot-fl"><span class="text-red">*</span>出售数量：</div>
                <div class="hs-entrepot-fr"><input class="hs-entrepot-input" type="text" id="num" placeholder="请输入出售数量"></div>
            </li>
        </ul>
        <div class="hs-entrepot-btn" id="pay">立即出售</div>
    </div>
    <div class="on2">
        <ul class="hs-entrepot-ul2">
            <?php  if(is_array($glao)) { foreach($glao as $v) { ?>
            <li>
                <div class="hs-entrepot-con-fl">
                    <img src="<?php  echo $v['avatar'];?>" alt="">
                </div>
                <div class="hs-entrepot-con-fr">
                    <div style="font-size: 14px;white-space:nowrap;overflow:hidden;">用户名：<span style="color: red;"><?php  echo $v['nickname'];?></span></div>
                    <div>扣留数目：<span style="color: red;"><?php  echo $v['knum'];?></span> 颗</div>
                    <div><?php  echo date("Y-m-d H:i:s",$v['stime']);?></div>
                </div>
            </li>
            <?php  } } ?>
        </ul>
    </div>
    <div class="on3">
        <img src="../addons/sz_yi/template/mobile/default/static/images/entrepot_on2.jpg" alt="" width="100%">
        <div style="margin-top: -30px;margin-left: 10px;font-size: 14px;">
       <?php  if(!empty($dog)) { ?>
       
       		 <?php  if($dog['level']==1) { ?>
				       <?php  if(!empty($ltime)) { ?>
				        	<div>距成为成年狗还有<span class="count" data-time="<?php  echo $ltime;?>"></span></div>
				        <?php  } else { ?>
				        	你当前没有喂狗粮>><a style="color: red" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=6">点击购买成年狗粮</a>
				        <?php  } ?>
			  <?php  } else if($dog['level']==2) { ?>
			  		<?php  if(!empty($ltime)) { ?>
			        	<div>距成为狗王还有<span class="count" data-time="<?php  echo $ltime;?>"></span></div>
			        <?php  } else { ?>
			        	你当前没有喂狗粮>><a style="color: red" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=7">点击购买狗王粮</a>
			        <?php  } ?>
			   
			    
			  <?php  } ?>
	<?php  } else { ?>
		你当前没有狗>><a style="color: red" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=5">点击购买幼狗</a>     
     <?php  } ?>
        
        </div>
    </div>
    <div class="on4">
        <div class="hs-entrepot-tt">当前列表是您在偷取他人果实时，被狗抓到时所丢失的记录</div>
        <ul class="hs-entrepot-ul2">
        <?php  if(is_array($htou)) { foreach($htou as $v) { ?>
            <li>
                <div class="hs-entrepot-con-fl">
                    <img src="<?php  echo $v['avatar'];?>" alt="">
                </div>
                <div class="hs-entrepot-con-fr">
                    <div style="font-size: 14px;white-space:nowrap;overflow:hidden;">用户名称：<span style="color: red;"><?php  echo $v['nickname'];?></span></div>
                    <?php  if($v['status'] == 1) { ?>
                    <div>偷了：<span style="color: red;"><?php  echo $v['knum'];?></span> 颗</div>
                    <?php  } else { ?>
                    <div>被小狗发,扣留：<span style="color: red;"><?php  echo $v['knum'];?></span> 颗</div>
                    <?php  } ?>
                    <div><?php  echo date("Y-m-d H:i:s",$v['stime']);?></div>
                </div>
            </li>
        <?php  } } ?>
        </ul>
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
    //倒计时
    function count(obj, closeTime){
        var displayTime;
        function showTime(){
            var day = Math.floor(closeTime / (60 * 60 * 24));
            var hour = Math.floor(closeTime / (3600)) - (day * 24);
            var minute = Math.floor(closeTime / (60)) - (day * 24 * 60) - (hour * 60);
            var second = Math.floor(closeTime) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            (day<10) ? ("0"+day):day;
            (hour<10) ? ("0"+hour):hour;
            (minute<10) ? ("0"+minute):minute;
            (second<10) ? ("0"+second):second;
            closeTime -= 1;
            var html = day+'天'+hour+'小时'+minute+'分'+second+'秒';
            obj.html(html);
            if(closeTime == -1){
                clearInterval(displayTime);
                //document.location.href = document.location.href;
                return;
            }
        }
        showTime();
        displayTime = setInterval(function(){
            showTime();
        }, 1000)
    }
    $(".htou").click(function(){ 
        var obj = $(this);
        var id  = obj.attr("data-id");
        core.json('shop/steal', {op: 'ht',id:id}, function(json) { 
            console.log(json);
            if(json.status == -1){ 
                alert(json.result);
                location.reload();
            }
                
        },true,true);
    });
    $(".count").each(function(){
        var obj = $(this);
        var closeTime = parseInt($(this).attr("data-time"));
        count(obj, closeTime);
    });


});
</script>
<!-- 版权消息 -->

<?php  $show_footer=true;$footer_current ='shouye'?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
