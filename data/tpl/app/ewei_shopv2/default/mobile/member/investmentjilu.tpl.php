<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .goods-item {
        margin: 10px;
        border-bottom: 1px solid #ccc;
        padding: .5rem 1rem;
        background-color: #363a45;
        color: #fff;
    }
    .fui-list-group{
        margin-top: 0;
    }
    .fui-tab{
        margin-bottom: 1px;;
    }
</style>

<div class='fui-page  fui-page-current member-log-page'>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">投资记录</div>

    </div>



    <div class='fui-content navbar'>



        <!-- <?php  if($_W['shopset']['trade']['withdraw']) { ?>

        <div id="tab" class="fui-tab fui-tab-danger">

            <a data-tab="tab1" class="external <?php  if($type == 1 ) { ?>active<?php  } ?>" data-type='1'>充币</a>

            <a data-tab="tab2" class='external <?php  if($type == 4) { ?>active<?php  } ?>' data-type='4'>提币</a>

            <a data-tab="tab3" class='external <?php  if($type == 2 ) { ?>active<?php  } ?>' data-type='2'>转币</a>

        </div>

        <?php  } ?> -->


        <div class='content-empty' style='display:none;'>

            <i class='icon icon-searchlist'></i><br />暂时没有任何记录!

        </div>


        <div class='fui-list-group container' style="display:none;"></div>

        <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>

    </div>



    <script id="tpl_getList1" type="text/html">

        <%each list as item%>
        <div class=" goods-item">
          <div class="time">充币时间：<span><% item.createtime %></span></div>
          <div class="lis">
            <p>充币类型：<% item.title %></p>
            <p>投资状态：<%if item.type==2 %>成功<%else%><%if item.status==1 %>成功<%else%>审核中<%/if%><%/if%></p>
          </div>
          <div>充币金额：<span><% item.money %> XXX</span></div>
        </div>
        <%/each%>

    </script>

    <script id="tpl_getList2" type="text/html">

        <%each list as item%>
        <div class=" goods-item">
          <div class="time">提币时间：<span><% item.createtime %></span></div>
          <div>提币类型：<% item.title %></div>
          <div>提币金额：<% item.money %> 元</div>
          <div>实到金额：<% item.realmoney %> 元</div>
          <div>手续费：<% item.charge %> 元</div>
        </div>
        <%/each%>

    </script>

    <script id="tpl_getList3" type="text/html">

        <%each list as item%>
        <div class=" goods-item">
          <div class="time">转账时间：<span><% item.createtime %></span></div>
          <div>收款人：<% item.nickname %></div>
          <div>收款金额：<% item.money %> 元</div>
          <div>收款手续费：<% item.money2 %> 元</div>
        </div>
        <%/each%>

    </script>



    <script language='javascript'>

        require(['biz/member/investmentjilu'], function (modal) {

            modal.init({ type: "<?php  echo $type;?>" });

        });
    </script>

    <?php  $this->footerMenus()?>

</div>



<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
