<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>互偷</title>
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
    .hs-steal-top{background: #fff;height: 42px;line-height: 42px;text-align: center;position: fixed;width: 100%;top:0;left: 0}
    .hs-steal-top a{height: 42px;width: 42px;color:#999;display: block;position: absolute;top: 0;font-size: 14px}
    .hs-steal-top a.goBack{left:12px;}
    .hs-steal-top a.goHome{right:12px;}
    .hs-steal-top h3{font-size: 14px } 
    /*steal*/
    .hs-steal{margin-top: 62px;}
    .hs-steal-ul li{margin-bottom: 20px;background: #fff;}
    .hs-steal-tit{color: red;font-size: 16px;padding: 10px;border-bottom: 1px solid #eee;}
    .hs-steal-con{overflow:hidden;position: relative;padding: 10px}
    .hs-steal-con-fl{float: left;}
    .hs-steal-con-fl img{width: 80px;height: 80px;background: #eee}
    .hs-steal-con-fr{float: left;margin-left: 10px;line-height: 25px}
    .hs-steal-con .hs-steal-a{display: block;position: absolute;top: 30px;right: 5px;background: #a6c90a; color: #fff;padding: 5px 10px;border-radius: 5px;font-size: 16px}
    /*版权信息*/
    .copyright{margin-top: 20px}
    .copyright_ul{overflow: hidden;width: 90%;margin: 0 auto;}
    .copyright_ul li{float: left;text-align: center;width: 25%;position: relative;}
    .copyright_ul li a{text-decoration: none;color: #999}
    .copyright_ul li span{position: absolute;right: -2px;color: #666}
    .copyright_bottom{text-align: center;color: #999;line-height: 30px}
</style>
<div class="hs-steal-top">
    <a href="javascript:history.back();" title="返回" class="goBack"><i class="fa fa-angle-left" style="margin-right: 5px;font-size: 22px;vertical-align: -2px"></i>返回</a>
    <h3>互偷</h3>
    <!-- <a href="javascript:;" title="home" class="goHome">home</a> -->
</div>
<div style="height: 52px;width: 100%"></div>
<?php  if(!empty($res)) { ?>
<div class="hs-steal">
    <ul class="hs-steal-ul">
    <?php  if(is_array($res)) { foreach($res as $k => $v) { ?>
        <li>
            <div class="hs-steal-tit">所属庄主：<?php  echo $v['nickname'];?></div>
            <div class="hs-steal-con clearfix">
                <div class="hs-steal-con-fl">
                    <img src="/attachment/<?php  echo $v['thumb'];?>" alt="">
                </div>
                <div class="hs-steal-con-fr">
                    <div style="font-size: 14px;white-space:nowrap;overflow:hidden;">果树名称：<span style="color: red;"><?php  echo $v['title'];?></span></div>
                    <div>总种植数：<span style="color: red;"><?php  echo $v['total'];?></span> 颗</div>
                    <div>距成熟还有<span class="count" data-time="<?php  echo $v['zyw_time'];?>"></span></div>
                </div>
                <div class="hs-steal-a htou" data-id="<?php  echo $v['id'];?>" data-time="<?php  echo $v['zyw_time'];?>" data-openid="<?php  echo $v['openid'];?>" data-num="<?php  echo $v['num'];?>"  href="">偷取</div>
            </div>
        </li>
    <?php  } } ?>
    </ul>
</div>
<?php  } else { ?>
<div style="margin: 25px auto;font-size: 20px;text-align: center;">今天没有可偷取的果树了，明天再来吧！</div>
<?php  } ?>
<!-- 版权消息 -->
<script type="text/javascript">
require(['core','tpl'],function(core,tpl){
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
