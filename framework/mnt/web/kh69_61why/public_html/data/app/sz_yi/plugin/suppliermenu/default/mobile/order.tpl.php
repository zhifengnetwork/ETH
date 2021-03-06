<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>订单管理</title>
<style type="text/css">
    th{font-weight: 200;}
    body {margin:0px; background:#eee; padding:0px; -moz-appearance:none; font-family:微软雅黑;}
    #big_body{width:100%;margin:0px; float: left;}


    #header{ width:100%; padding-top:10px; padding-bottom: 10px; background:#FF3737 ;  text-align: center; color:#fff;  }
    #header table{margin: auto; width:95%; font-size: 16px;  }

    #list{width:100%;   background: #fff;}
    #list table{width:100%;}
    #list table th{color: #787878 ;width:25%;text-decoration:none; padding-top:10px; padding-bottom:10px;}

    #list table th#action{color:#FF3737; border-bottom: 1px solid #FF3E3E ; }
    #list  ul{float: left; width: 100%; background: #fff; }
    #list ul li{float: left; width: 25%; text-align: center; padding-top: 10px; padding-bottom: 10px; color: #787878 ;}
    #list  ul li#action{  color:#FF3737; border-bottom: 1px solid #FF3E3E ;  }

    #list-body{width:100%; float: left; margin-top: 10px; text-align: center;background: #fff}
    #list-body>ul{width: 95%; padding-top: 10px; padding-bottom: 10px; margin: auto; background: #fff; font-size:11px; }
     #list-body>ul>li{width:100%;float: left; border-bottom:1px solid #CFCFCF; padding-bottom:8px;padding-top:8px; line-height: 100%; word-break:break-all;   }
    #list-body #center{}
    #list-body #center>li{float:left;}



    #big_body #box{width:100%;margin:0px; float: left;}


 }
</style>
<script type="text/javascript" src="<?php echo MODULE_URL.'plugin/suppliermenu/res/dropload.min.js?'.time();?>"></script>

<div id="big_body">
      <div id="header">
           <table>
               <tr>
                   <th style="width:10%;  " align="center"  valign="center" onclick="window.history.go(-1)" ><</th>
                   <th style="width:80%; " align="center" valign="center" >订单管理</th>
                   <th style="width:10%; background: url(<?php  echo MODULE_URL.'plugin/suppliermenu/res/2.png'?>) no-repeat left; background-size:20px 20px; " align="center" valign="center" > </th>
               </tr>
           </table>
      </div>

     <div id="list">
        <ul>

            <li <?php  if($type==0) { ?>id="action"<?php  } ?>    onclick="window.location.href = '<?php  echo $this->createPluginMobileUrl('suppliermenu/order',array('type'=>0)); ?>' "    >全部</li>
            <li <?php  if($type==1) { ?>id="action"<?php  } ?>      onclick="window.location.href = '<?php  echo $this->createPluginMobileUrl('suppliermenu/order',array('type'=>1)); ?>' "    >待付款</li>
            <li <?php  if($type==2) { ?>id="action"<?php  } ?>      onclick="window.location.href = '<?php  echo $this->createPluginMobileUrl('suppliermenu/order',array('type'=>2)); ?>' "    >待发货</li>
            <li <?php  if($type==3) { ?>id="action"<?php  } ?>      onclick="window.location.href = '<?php  echo $this->createPluginMobileUrl('suppliermenu/order',array('type'=>3)); ?>' "    >待收货</li>

        </ul>
     </div>


     <div id="box"></div>

</div>

<script id="tpl_list" type="text/html">
      <div id="list">
        <ul>
            <%each data as  d%>
            <li><%d.name%></li>
            <%/each%>
        </ul>
     </div>
</script>



<script id="tpl-list-body" type="text/html">


<%each order as d%>
      <div id="list-body">
              <ul>
                  <li>
                      <div style="float:left;">
                          <span style="color:#7B7B7B">订单号：</span>
                          <span style="color:#616161"><%d.ordersn%></span>
                      </div>
                      <div style="float:right;color:#FF8A15;" id="status-<%d.id%>">
                             <%if d.status==0%>
                                 待付款
                             <%/if%>

                             <%if d.status==1%>
                                 待发货
                             <%/if%>

                             <%if d.status==2%>
                                 待收货
                             <%/if%>

                             <%if d.status==-1%>
                                 已取消
                             <%/if%>
                             <%if d.status==3%>
                                 已完成
                             <%/if%>
                      </div>
                  </li>


                  <%each d.goods as g%>
                  <li>
                     <ul id="center">
                         <li style="width:15%; text-align:left;">
                            <img style="width:40px; height:40px;" src="<%g.thumb%>"/>

                         </li>
                         <li style="width:70%; text-align:left;  ">
                               <%g.title%>
                         </li>
                         <li style="width:15%; text-align:right;">
                              <div>￥<%g.realprice%></div>
                              <div>x <%g.total%></div>
                         </li>
                     </ul>
                  </li>
                  <%/each%>

                  <li style=" text-align:right;">
                       <span style="color:#818181;">共&nbsp;<%d.total%>&nbsp;件商品</span>
                       <span style="color:#818181;">&nbsp;实付&nbsp;</span>
                       <span> ￥<%d.price%></span>
                  </li>
                  <li style="padding-bottom:13px;padding-top:13px; text-align:right;">
                      <%if d.status==0 %>
                       <%/if%>

                  </li>
              </ul>
      </div>
<%/each%>


</script>


<script type="text/javascript">

//window.location.href ='<?php  echo $this->createPluginMobileUrl('suppliermenu/order',array('op'=>'delete'));?>&orderid=<%d.id%>'
        function delete_sure(id){
           if(window.confirm('你确定要取消订单吗？')) {

              require(['core'], function( core) {

                    core.pjson('suppliermenu/order', {op:'delete',id:id}, function(json) {
                             if(json.result.status){
                                $("#status-"+id).text('已取消');
                                $("#delete-"+id).hide();

                                alert('取消成功');
                             }else{
                                alert('取消失败');
                             }

                    }, true);

              });


           }

        }

        require(['tpl', 'core'], function(tpl, core) {

            var page = 0;
            $('#big_body').dropload({
                scrollArea : window,
                loadDownFn : function(me){
                    if(page<0) { alert();me.noData();return ;}
                    core.pjson('suppliermenu/order', {op:'order',page:page,type:<?php  echo $type;?>}, function(json) {
                         $("#box").append(  tpl('tpl-list-body',json.result) );
                         if(json.result.status==true){
                              page++;
                              me.resetload();
                         }else{
                             page=-1;
                             me.lock();
                             me.noData();
                             me.resetload();
                         }

                    }, true);
                }
            });


        });


</script>



<?php  $show_footer=true?>
<?php  $footer_current='member'?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
