<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<?php  if($op == 'display') { ?>
<title>宝贝管理</title>
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
    #list ul li{float: left; width: 50%; text-align: center; padding-top: 10px; padding-bottom: 10px; color: #787878 ;}
    #list  ul li#action{  color:#FF3737; border-bottom: 1px solid #FF3E3E ;  }

    #list-body{width:100%; float: left; margin-top: 10px; text-align: center;background: #fff}
    #list-body>ul{width: 95%; padding-top: 10px; padding-bottom: 10px; margin: auto; background: #fff; font-size:11px; }
     #list-body>ul>li{width:100%;float: left; border-bottom:1px solid #CFCFCF; padding-bottom:8px;padding-top:8px; line-height: 100%; word-break:break-all;   }
    #list-body #center{}
    #list-body #center>li{float:left;}

    #big_body #box{width:100%;margin:0px; float: left;}
    #big_body #box>table{width:100%;margin:0px; float: left; text-align: center; }
    #big_body #box>table td{padding-top:10px;padding-bottom:10px;}


    #big_body #box>ul{width: 100%; float: left; text-align: center;}
    #big_body #box>ul>li{float: left;width: 50%;padding-top:10px;padding-bottom:10px; font-size: 12px;}

 }
</style>
<script type="text/javascript" src="<?php echo MODULE_URL.'plugin/suppliermenu/res/dropload.min.js?'.time();?>"></script>

<div id="big_body">
     <div id="header">
           <table>
               <tr>
                   <th style="width:10%;  " align="center"  valign="center" onclick="window.history.go(-1)" ><</th>
                   <th style="width:80%; " align="center" valign="center" >宝贝管理</th>
                   <th style="width:10%; background: url(<?php  echo MODULE_URL.'plugin/suppliermenu/res/2.png'?>) no-repeat left; background-size:20px 20px; " align="center" valign="center" > </th>
               </tr>
           </table>
     </div>
     <div id="list">
        <ul>
            <li <?php  if($type==1) { ?>id="action"<?php  } ?>    onclick="window.location.href = '<?php  echo $this->createPluginMobileUrl('suppliermenu/goods',array('type'=>1)); ?>' "    >出售中</li>
            <li <?php  if($type==0) { ?>id="action"<?php  } ?>      onclick="window.location.href = '<?php  echo $this->createPluginMobileUrl('suppliermenu/goods',array('type'=>0)); ?>' "   >仓库中</li>
        </ul>
     </div>
     <div id="box"><ul></ul></div>
</div>

<script id="tpl_li" type="text/html">
   <%each goods as g%>
    <li onclick=" window.location.href='<?php  echo $this->createPluginMobileUrl('suppliermenu/goods',array('op'=>'post'));?>&id=<%g.id%>'">
      <img style="width:100px; height:100px;" src="<%g.thumb%>"/>
      <div><%g.title%></div>
      <div>￥<%g.marketprice%></div>
    </li>
   <%/each%>
</script>

<script type="text/javascript">
        require(['tpl', 'core'], function(tpl, core) {

            var page = 0;
            $('#big_body').dropload({
                scrollArea : window,
                loadDownFn : function(me){
                    if(page<0) { alert();me.noData();return ;}
                    core.pjson('suppliermenu/goods', {op:'get',page:page,type:<?php  echo $type;?>}, function(json) {
                         $("#box>ul").append(  tpl('tpl_li',json.result) );

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


<?php  } ?>







<?php  $show_footer=true?>
<?php  $footer_current='member'?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
