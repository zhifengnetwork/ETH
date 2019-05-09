<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>申请<?php  echo $this->set['texts']['withdraw']?></title>
<style type="text/css">
body {margin:0px; background:#efefef; -moz-appearance:none;}
input {-webkit-appearance:none; outline:none;}
.balance_img {height:80px; width:80px; margin:70px auto 0px; background:#ffb400; border-radius:40px; color:#fff; font-size:70px; text-align:center; line-height:90px;}
.balance_text {height:20px; width:100%; margin-top:16px; text-align:center; line-height:20px; font-size:16px; color:#666;}
.balance_num {height:24px; width:100%; margin-top:10px; text-align:center; line-height:24px; font-size:22px; color:#444;}

.balance_sub1 {height:44px; width:94%; margin:14px 3% 0px; background:#ff6600; border-radius:4px; text-align:center; font-size:18px; line-height:44px; color:#fff; box-shadow:#eee 1px 1px 3px;}
.balance_sub2 {height:44px; width:94%; margin:14px 3% 0px; background:#31cd00; border-radius:4px; text-align:center; font-size:18px; line-height:44px; color:#fff;}
.balance_sub3 {height:44px; width:94%; margin:14px 3% 0px; background:#ffffff; border-radius:4px; text-align:center; font-size:18px; line-height:44px; color:#666; box-shadow:#eee 1px 1px 3px;}
.disabled { background:#ccc;}
</style>
<div id='container'></div>

<script id='tpl_main' type='text/html'>
 <div class="balance_img"><i class="fa fa-cny"></i></div>
    <div class="balance_text">我的<?php  echo $this->set['texts']['commission_ok']?></div>
    <div class="balance_num">￥<%member.commission_ok%></div>
    
   
    <div class="balance_sub balance_sub1 <%if !cansettle%>disabled<%/if%>" data-type="0"><?php  echo $this->set['texts']['widthdraw']?>到原果</div>
   
    
  
    <div class="balance_sub3" onclick="location.href='<?php  echo $this->createPluginMobileUrl('commission/log')?>'"><?php  echo $this->set['texts']['withdraw']?>记录</div>
</script>
<script language="javascript">
    require(['tpl', 'core'], function(tpl, core) {
        
        core.pjson('commission/apply',{},function(json){
           var result = json.result;
           $('#container').html(  tpl('tpl_main',json.result) );
           if(result.noinfo){
                core.message('请补充您的资料后才能申请提现!',result.infourl,'warning');
                return;
            }
            
           if(json.result.cansettle){
               $('.balance_sub').click(function(){
                   if($('.balance_sub').attr('saving')=='1'){
                       return;
                   }
                   var type= $(this).data('type');
                       
                   core.tip.confirm('确认兑换<?php  echo $this->set['texts']['widthdraw']?>? <?php  echo $this->set['texts']['withdraw']?>点击兑换之后，将在原果上显示.',function(){
                       
                       $('.balance_sub').attr('saving',1).html('正在处理中...');
                        core.pjson('commission/apply',{type:type},function(pjson){
                              if(pjson.status=='1'){
                                   core.tip.show( pjson.result );
                                   location.href = core.getUrl('plugin/commission/withdraw');
                              }
                               
                       },true,true);
                   });
               })
           }
        },true);
        
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
