<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<div class='fui-page  fui-page-current'>

    <div class="fui-header">

        <div class="fui-header-left" onclick="window.location.href='<?php  echo mobileUrl('member/index')?>'">

            <a  class="back" ></a>

        </div>

        <div class="title">复投账户</div>

        <div class="fui-header-right">&nbsp;</div>

    </div>

    <div class='fui-content navbar' >

        <div class='fui-cell-group fui-cell-group-o'>

       <div id="tab" class="fui-tab fui-tab-danger">

        <a data-tab="tab1"  class="external <?php  if($_GPC['type']==0) { ?>active<?php  } ?>" href="<?php  echo mobileUrl('member/withdraw', array('type' => 0))?>" data-type='0'>ETH提现</a>

        <!-- <a data-tab="tab2" class='external <?php  if($_GPC['type']==1) { ?>active<?php  } ?>' href="<?php  echo mobileUrl('member/withdraw1', array('type' => 1))?>"  data-type='1'>静态账户</a> -->

        <a data-tab="tab3" class='external <?php  if($_GPC['type']==2) { ?>active<?php  } ?>' href="<?php  echo mobileUrl('member/withdraw2', array('type' => 2))?>"  data-type='1'>复投账户</a>

        </div>

            <div class='fui-cell-title'>

                <div class='fui-cell-info' style='color:#999'>当前可用复投账户余额: ￥<span id='current'><?php  echo number_format($member['credit4'],2)?></span> 
                <!-- <a id='btn-all' class='text-primary external' href='#'>全部转出</a></div> -->

            </div>

            <div class="fui-cell-title" style="    color: red;">
                注：复投账户不可以转账 ，不可以提现 ，不可以提到余额。 
            </div>






    </div>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->