<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>支付订单</title>
<style type="text/css">
    body {margin:0px; background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;}
.order_main {height:auto; border-bottom:1px solid #f0f0f0; border-top:1px solid #f0f0f0; background:#fff;margin-top:10px;}
.order_main .line {height:44px; margin:0 5px; border-bottom:1px solid #f0f0f0; line-height:44px;}
.order_main .line .label { float:left;width:80px;}
.order_main .line .info { float:right; width:100%; margin-left:-85px;text-align: right;overflow:hidden;height:44px;}
.order_main .line .info .inner { color:#666;margin-left:85px;}
.order_main .tip { color:#666; line-height:20px;padding:5px;font-size:13px; }
 
  .order_main .line .nav {height:22px; width:40px; background:#ccc; margin:10px 0px; float:right; border-radius:40px;}
.order_main .line .on {background:#4ad966;}
.order_main .line .nav nav {height:20px; width:20px; background:#fff; margin:1px; border-radius:20px;}
.order_main .line .nav .on {margin-left:19px;}

.order_sub1 {height:44px; margin:14px 5px; background:#31cd00; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
.order_sub10 {height:44px; margin:14px 5px; background:#31cd00; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
.order_sub2 {height:44px; margin:14px 5px; background:#f49c06; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
.order_sub3 {height:44px; margin:14px 5px;background:#e2cb04; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
.order_sub4 {height:44px; margin:14px 5px; background:#18c0f7; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}

.order_main1 {height:30px;padding:10px;border-bottom:1px solid #f0f0f0; border-top:1px solid #f0f0f0; background:#fff;text-align:center;margin-top:10px; }
.order_sub5 {height:30px; width:35%;padding:5px 10px 5px 10px; border:1px solid #ccc; border-radius:4px; text-align:center; font-size:16px; line-height:30px; color:#333; }
.order_sub6 {height:44px; margin:14px 5px; background:#07c4d0; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}

.order_subc {height:44px; margin:14px 5px; background:#31cd00; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}

.order_sub7 {height:44px; margin:14px 5px; background:#07c4d0; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}

</style>

<div id='container'></div>
<script id='tpl_order_info' type='text/html'>
    <input type='hidden' id='orderid' value="<%order.id%>"/>
       <div class="page_topbar">
        <a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
        <div class="title">支付订单</div>
    </div>
    <div class="order_main" >  
        <div class="line"><div class="label">订单编号</div><div class="info"><div class="inner"><%order.ordersn%></div></div></div>
        <div class="line"><div class="label">支付金额</div><div class="info"><div class="inner"><div style='color:#ff6600'>￥<span id="orderprice" price="<%order.price%>"><%order.price%></span>元</div></div></div></div>
    </div>
    <%if order.price>0%>    
	<%if yunpay.success%><div class="button order_sub10" >云支付</div><%/if%>    
    <%if wechat.success%><div class="button order_sub1">微信支付</div><%/if%>
    <%if alipay.success%><div class="button order_sub2" >支付宝支付</div><%/if%>

    <%if pay.success%><div class="button order_sub7" >微信支付</div><%/if%>
    
    <%if credit.success %>
        <div class="button order_sub3">金果支付(当前金果:<%credit.current%>)</div>
        <input type="hidden" id="credit" value="<%credit.current%>" />
        <%if credit.current<=0%>
        <div class="button order_sub4" onclick="location.href='<?php  echo $this->createMobileUrl('member/recharge')?>&returnurl=<%returnurl%>'">账户充值</div>
        <%/if%>  
    <%/if%>
    
    <%/if%>
    
    <div class="button order_subc"  <%if order.price>0%>style="display:none"<%/if%>>确认支付</div>
    <%if cash.success%><div class="button order_sub6" >货到付款</div><%/if%>
</script>

<script id='tpl_order_pay' type='text/html'>
       <div class="page_topbar">
            <div class="title">支付成功</div>
        </div>
    <%if address%>
        <img src="../addons/sz_yi/template/mobile/default/static/images/pay_ok.png" style="width:100%;" />
     <%/if%>
     <%if order.dispatchtype=='1' && order.isverify!='1'%>
        <img src="../addons/sz_yi/template/mobile/default/static/images/pay_carrier.png" style="width:100%;" />
     <%/if%>
     <%if order.isverify=='1'%>
        <img src="../addons/sz_yi/template/mobile/default/static/images/pay_verify.png" style="width:100%;" />
     <%/if%>
     <%if order.virtual!='0'%>
        <img src="../addons/sz_yi/template/mobile/default/static/images/pay_virtual.png" style="width:100%;" />
     <%/if%>
	 <%if order.isvirtual=='1'%>
        <img src="../addons/sz_yi/template/mobile/default/static/images/pay_success.png?v=1" style="width:100%;" />
     <%/if%>
    <div class="order_main" >
        <%if address%>
        <div class="line"><div class="label">收货人</div><div class="info"><div class='inner'><%address.realname%> <%address.mobile%></div></div></div>
        <div class="line"><div class="label">收货地址</div><div class="info"><div class='inner'><%address.address%></div></div></div>
        <%/if%>
        <%if carrier%>
         <%if order.isverify=='1' || order.isvirtual=='1'%> 
         <div class="line"><div class="label">联系人</div><div class="info"><div class='inner'><%carrier.carrier_realname%></div></div></div>
        <div class="line"><div class="label">联系电话</div><div class="info"><div class='inner'><%carrier.carrier_mobile%></div></div></div>
         <%else%>
        <div class="line"><div class="label">自提地点</div><div class="info"><div class='inner'><%carrier.address%></div></div></div>
        <div class="line"><div class="label">自提联系人</div><div class="info"><div class='inner'><%carrier.realname%> <%carrier.mobile%></div></div></div>
        <%/if%>
        <%/if%>
        <div class="line"><div class="label">实付款</div><div class="info"><div class='inner'><span style='color:#ff6600'>￥<%order.price%>元</span></div></div></div>
         <%if order.virtual!='0'%>
         <div class="line" style='text-align:center;'>请到订单中查看物品信息</div>
         <%/if%>
    </div>
     <div class="order_main1" >
         <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('order/list')?>'">订单详情</span>
         <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('shop')?>'">返回首页</span>
 		 <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('shop/shouye')?>'">返回果园</span>
     </div>
</script>

<script id='tpl_order_cash' type='text/html'>
      <div class="page_topbar">
           <div class="title">订单提交成功</div>
        </div>
    <img src="../addons/sz_yi/template/mobile/default/static/images/pay_cash.png" style="width:100%;" />
    <div class="order_main" >
        <%if address%>
        <div class="line"><div class="label">收货人</div><div class="info"><div class='inner'><%address.realname%> <%address.mobile%></div></div></div>
        <div class="line"><div class="label">收货地址</div><div class="info"><div class='inner'><%address.address%></div></div></div>
        <%/if%>
        <%if carrier%>
         <%if order.isverify=='1' || order.isvirtual=='1'%> 
         <div class="line"><div class="label">联系人</div><div class="info"><div class='inner'><%carrier.carrier_realname%></div></div></div>
        <div class="line"><div class="label">联系电话</div><div class="info"><div class='inner'><%carrier.carrier_mobile%></div></div></div>
         <%else%>
        <div class="line"><div class="label">自提地点</div><div class="info"><div class='inner'><%carrier.address%></div></div></div>
        <div class="line"><div class="label">自提联系人</div><div class="info"><div class='inner'><%carrier.realname%> <%carrier.mobile%></div></div></div>
        <%/if%>
        <%/if%>
        <div class="line"><div class="label">需到付</div><div class="info"><div class='inner'><span style='color:#ff6600'>￥<%order.price%>元</span></div></div></div>
    </div>
     <div class="order_main1" >
         <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('order/detail')?>&id=<%order.id%>'">订单详情</span>
         <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('shop')?>'">返回首页</span>
     </div>
</script>
 

<script language="javascript">
    require(['tpl', 'core'], function(tpl, core) {
        core.json('order/pay',{orderid:'<?php  echo $_GPC['orderid'];?>',openid:"<?php  echo $openid;?>"},function(json){
            var result = json.result;
            if(json.status==-1){
                 location.href = core.getUrl('order/detail',{id:"<?php  echo $_GPC['orderid'];?>"});
                 return;
            }
            if(json.status!=1){
                 core.message(result,"<?php  echo $this->createMobileUrl('order/detail',array('id'=>$_GPC['orderid']))?>",'error');
                 return;
            }
            $('#container').html(tpl('tpl_order_info',result));
            
           if(result.yunpay.success){
 
                 $('.order_sub10').click(function(){
                     
                     var deduct = ($('#deductmoney').length>0 &&$('#deductmoney').attr('on')=='1' )?1:0 ;
                    core.json('order/pay', {op: 'pay',type: 'yunpay', orderid:'<?php  echo $_GPC['orderid'];?>',openid:"<?php  echo $openid;?>",deduct:deduct}, function (rjson) {
                        if(rjson.status!=1){
                            $('.button').removeAttr('submitting');
                            core.tip.show(rjson.result);
                            return;
                        }
                       //virtual
                       location.href = core.getUrl('order/pay_yunpay',{orderid:'<?php  echo $_GPC['orderid'];?>'});
                       return;
                    },true,true);
                 })
           }
           if(result.alipay.success){
 
                 $('.order_sub2').click(function(){
                     
                     var deduct = ($('#deductmoney').length>0 &&$('#deductmoney').attr('on')=='1' )?1:0 ;
                    core.json('order/pay', {op: 'pay',type: 'alipay', orderid:'<?php  echo $_GPC['orderid'];?>',openid:"<?php  echo $openid;?>",deduct:deduct}, function (rjson) {
                        if(rjson.status!=1){
                            $('.button').removeAttr('submitting');
                            core.tip.show(rjson.result);
                            return;
                        }
                       //virtual
                       location.href = core.getUrl('order/pay_alipay',{orderid:'<?php  echo $_GPC['orderid'];?>'});
                       return;
                    },true,true);
                 })
           }
           if(result.credit.success){
               
               $(".order_sub3").click(function(){
                 if($(this).attr('submitting')=='1'){
                     return;
                 }
                 core.tip.confirm('确认要立即付款?',function(){
                    $('.button').attr('submitting',1);
                    core.json('order/pay',{
                        op:'complete',
                        orderid:'<?php  echo $_GPC['orderid'];?>',
                        type:'credit'
                    },function(pay_json){

                    	console.log(pay_json);//return false;
                        if(pay_json.status==1){
                           $('#container').html(tpl('tpl_order_pay',pay_json.result));
                           return;
                        }
                        core.tip.show(pay_json.result);
                        $('.button').removeAttr('submitting');
                    },true,true);
               });
                });
           }
           
            if(result.cash.success){
               $(".order_sub6").click(function(){
                   if($(this).attr('submitting')=='1'){
                       return;
                   }
                   core.tip.confirm('确认要货到付款?',function(){
                       $('.button').attr('submitting',1);
                    core.json('order/pay',{
                        op:'complete',
                        orderid:'<?php  echo $_GPC['orderid'];?>',
                        type:'cash'
                    },function(pay_json){
                        if(pay_json.status==2){
                           $('#container').html(tpl('tpl_order_cash',pay_json.result));
                           return;
                        }
                        core.tip.show(pay_json.result);
                        $('.button').removeAttr('submitting');
                    },true,true);
               });})
           }


           $('.order_sub7').click(function(){
                 if($(this).attr('submitting')=='1') return;
                 
                 $('.button').attr('submitting',1);

                 core.json('order/pay', {op: 'pay',type: 'pay', orderid:'<?php  echo $_GPC['orderid'];?>'}, function (rjson) {
                 //   alert(JSON.stringify(rjson));
                    if(rjson.status == 500){
                        $('.button').removeAttr('submitting');
                        core.tip.show(rjson.result);
                        return;
                    }

                  
                    
                    window.location.href = rjson.status.url;
                    
              
                  },true,true); 




           });


           
           if(result.wechat.success){
                $('.order_sub1').click(function(){   
                        if($(this).attr('submitting')=='1'){
                           return;
                        }
                         $('.button').attr('submitting',1);
                         var deduct = ($('#deductmoney').length>0 &&$('#deductmoney').attr('on')=='1' )?1:0 ;
                         core.json('order/pay', {op: 'pay',type: 'weixin', orderid:'<?php  echo $_GPC['orderid'];?>',deduct:deduct}, function (rjson) {
                            if(rjson.status!=1){
                                $('.button').removeAttr('submitting');
                                core.tip.show(rjson.result);
                                return;
                            }
                            
                            var wechat = rjson.result.wechat;
                          WeixinJSBridge.invoke('getBrandWCPayRequest', {
                                    'appId': wechat.appid ? wechat.appid : wechat.appId,
                                    'timeStamp': wechat.timeStamp,
                                    'nonceStr': wechat.nonceStr,
                                    'package': wechat.package,
                                    'signType': wechat.signType,
                                    'paySign': wechat.paySign,
                                }, function (res) {
                                    if (res.err_msg == 'get_brand_wcpay_request:ok') {
                                          core.json('order/pay',{
                                                                     op:'complete',
                                                                     orderid:'<?php  echo $_GPC['orderid'];?>',
                                                                     type:'weixin',deduct:deduct
                                                                 },function(pay_json){ 
                                                                     if(pay_json.status==1){
																		
                                                                        $('#container').html(tpl('tpl_order_pay',pay_json.result));
                                                                        return;
                                                                     }
                                                                     core.tip.show(pay_json.result);
                                                                     $('.button').removeAttr('submitting');
                                        },true,true);
                                    } else if(res.err_msg=='get_brand_wcpay_request:cancel') {
                                        $('.button').removeAttr('submitting');
                                        core.tip.show('取消支付');
                                    } else {
                                      $('.button').removeAttr('submitting');
                                    	alert(res.err_msg);
                                    }
                                });
                          },true,true); 
                 });
             }
             $('.order_subc').click(function(){   
                       core.tip.confirm('确认要立即付款?',function(){
                           $('.button').attr('submitting',1);
                                core.json('order/pay',{
                                       op:'complete',
                                       orderid:'<?php  echo $_GPC['orderid'];?>',
                                       type:'credit'
                                },function(pay_json){ 
                                    if(pay_json.status==1){
                                       $('#container').html(tpl('tpl_order_pay',pay_json.result));
                                       return;
                                    }
                                    core.tip.show(pay_json.result);
                                    $('.button').removeAttr('submitting');
                                },true,true);
                           })
              });
             
        
    },true)
});
 
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
