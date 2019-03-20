<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
  .navInfo{
    display: flex;
    background-color: #adbac2;
  }
  .navInfo > a{
    flex: 1;
    padding: 10px 0;
    text-align: center;
    color: #fff;
  }
  .navInfo_active{
    color: #d2691e !important;
    border-bottom: 2px solid #d2691e;
  }
  .goods-item{
    padding: .5rem;
    border-bottom: 1px solid #ccc;
  }
  .lis{
    display: flex;
    /* justify-content: space-between; */
  }
  .lis > p:nth-child(1){
    width: 70%;
  }
  .lis > p:nth-child(2){
    width: 30%;
  }
</style>

<div class='fui-page  fui-page-current member-log-page'>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">3D游戏</div>

    </div>



    <div class='fui-content navbar' >



        <!-- <?php  if($_W['shopset']['trade']['withdraw']) { ?>

        <div id="tab" class="fui-tab fui-tab-danger">

            <a data-tab="tab1"  class="external <?php  if($_GPC['type']==0) { ?>active<?php  } ?>" data-type='0'>充值记录</a>

            <a data-tab="tab2" class='external <?php  if($_GPC['type']==1) { ?>active<?php  } ?>'  data-type='1'>提现记录</a>

            <a data-tab="tab3" class='external <?php  if($_GPC['type']==2) { ?>active<?php  } ?>'  data-type='2'>奖励记录</a>

        </div>

        <?php  } ?> -->
        <div class="navInfo">
          <!-- <a href="<?php  echo mobileurl('member/lottery')?>" >3D下注</a>
          <a href="javascript:;" class="navInfo_active">押注记录</a>
          <a href="<?php  echo mobileurl('member/lottery/winningrecord')?>">开奖记录</a> -->
          <a href="" onclick="location.href='<?php  echo mobileurl('member/lottery')?>'" >3D下注</a>
          <a href="javascript:;" class="navInfo_active">押注记录</a>
          <a href="" onclick="location.href='<?php  echo mobileurl('member/lottery/winningrecord')?>'">开奖记录</a>
        </div>


        <div class='content-empty' style='display:none;'>

            <i class='icon icon-searchlist'></i><br/>暂时没有任何记录!

        </div>


        <div class='fui-list-group container' style="display:none;"></div>

        <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>

    </div>



    <script id="tpl_stakejilu" type="text/html">


        <%each list as val%>

        <div class="goods-item">
          <div class="lis">
            <p>时间: <% val.createtime %></p>
            <p>期数: <% val.id %></p>
          </div>
          <div class="lis">
            <p>投注金额: <% val.money %></p>
            <p>倍数: <% val.multiple %></p>
          </div>
          <div class="lis">
            <p>投注号码: <% val.number %></p>
            <p>
              <% if val.thigh == 0 %> <span style='color:#0a0;'>未开奖</span> 
              <% else if val.thigh == 1 %> <span style='color:#ea2000'>已开奖</span>
              <% /if %>
            </p>
          </div>


        </div>

        <%/each%>

    </script>



    <script language='javascript'>
        require(['biz/member/stakejilu'], function (modal) {

            modal.init();

        });
    </script>

    <?php  $this->footerMenus()?>

</div>



<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
