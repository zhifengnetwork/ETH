<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title><?php  if(!empty($orderid)) { ?>支付宝支付<?php  } else { ?>支付宝充值<?php  } ?></title>
<style type="text/css">
 body {margin:0px; background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;}
</style>
<script language="javascript">
function showIframe(url,w,h){
    //添加iframe
    var if_w = w; 
    var if_h = h; 
    //allowTransparency='true' 设置背景透明 virutal
    $("<iframe width='" + if_w + "' height='" + if_h + "' id='alipayFrame' name='alipayFrame' style='position:absolute;z-index:4;'  frameborder='no' marginheight='0' marginwidth='0' ></iframe>").prependTo('body');    
    var st=document.documentElement.scrollTop|| document.body.scrollTop;//滚动条距顶部的距离
    var sl=document.documentElement.scrollLeft|| document.body.scrollLeft;//滚动条距左边的距离
    var ch=document.documentElement.clientHeight;//屏幕的高度
    var cw=document.documentElement.clientWidth;//屏幕的宽度
    var objH=$("#alipayFrame").height();//浮动对象的高度
    var objW=$("#alipayFrame").width();//浮动对象的宽度
    var objT=Number(st)+(Number(ch)-Number(objH))/2;
    var objL=Number(sl)+(Number(cw)-Number(objW))/2;
    $("#alipayFrame").css('left',objL);
    $("#alipayFrame").css('top',objT);
    $("#alipayFrame").attr("src", url)
    //添加背景遮罩
    $("<div id='alipayFrameBg' style='background-color: #fff;display:block;z-index:3;position:absolute;left:0px;top:0px;'/>").prependTo('body'); 
    var bgWidth = Math.max($("body").width(),cw);
    var bgHeight = Math.max($("body").height(),ch);
    $("#alipayFrameBg").css({width:bgWidth,height:bgHeight});
 
    //点击背景遮罩移除iframe和背景
    $("#alipayFrameBg").click(function() {
        $("#alipayFrame").remove();
        $("#alipayFrameBg").remove();
    });
}
var orderid = "<?php  echo $orderid;?>";
var logid = "<?php  echo $logid;?>";
    require(['tpl', 'core'], function(tpl, core) {
        core.json('order/pay_alipay',{orderid:orderid, logid:logid, openid:"<?php  echo $openid;?>"},function(json){
            var result = json.result;
            if(json.status!=1){
                if(orderid!='0'){
                    core.message(json.result,"<?php  echo $this->createMobileUrl('order/pay',array('orderid'=>$orderid))?>",'error');
                }else if(logid!='0'){
                    core.message(json.result,"<?php  echo $this->createMobileUrl('member')?>",'error');
                }
                 return;
            }
            if(!result.alipay.success){
                if(orderid!='0'){
                    core.message('支付宝支付参数错误!',"<?php  echo $this->createMobileUrl('order/pay',array('orderid'=>$orderid))?>",'error');
               }else if(logid!='0'){
                    core.message('支付宝支付参数错误!',"<?php  echo $this->createMobileUrl('member/recharge')?>",'error');   
                }
                 return;
            }
            var height =$(document.body).height();
             showIframe(result.alipay.url,"100%",height);
             },true,true);
     });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>