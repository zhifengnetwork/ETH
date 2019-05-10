<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>

    .tab-content>.tab-pane {margin-top: 10px;}

    .tab-content>.tab-pane>.fui-list-group {border-bottom: 0;}
    .wb-nav ul li a{
        color:white;
    }
    .btn-success{
        margin-top: 45px;
        min-width: 160px;
    }
    .pic-li:after{
        display: block;
        content: '';
        clear:both;
    }
    .pic-li .first{
        margin-top: 0
    }
    .pic-li li{
        float: left;
        position: relative;
        width: 17%;
        margin-left: 12%;
        margin-top:10px;
        /*opacity: .5;*/
        text-align: center;

    }
    .pic-li li img{
        width: 90%;
    }
    /*.pic-li li p{
        margin-top: 5px;
    }*/
    .pic-li li:hover img{
        transform: scale(1.2);
        /*position: ab*/
    }
    .ibox-content-xx .tab-content{
        min-height: 296px;
    }
    /*.panel-list */
</style>

<div class="page-header"><img src="../addons/ewei_shopv2/static/images/font_31.png">当前位置：<span class="text-primary">首页</span></div>







<div class="page-content transparent">
    <div class="wb-nav" >
        <div class="big-box">
            <div class="white-box">
                <!-- 折叠侧边栏 -->
               <!--  <p class="wb-nav-fold"><i class="icow icow-zhedie"></i></p> -->
                    <!-- <div class="wb-topbar-search expand-search">
                        <form action="" id="topbar-search">

                            <input type="hidden" name="c" value="site" />

                            <input type="hidden" name="a" value="entry" />

                            <input type="hidden" name="m" value="ewei_shopv2" />

                            <input type="hidden" name="do" value="web" />

                            <input type="hidden" name="r" value="search" />

                            <div class="input-group">

                                <input type="text" placeholder="请输入关键词进行功能搜索..." class="form-control wb-search-box" maxlength="15" name="keyword" <?php  if($system['merch']) { ?> data-merch="1"<?php  } ?> />

                                <span class="input-group-btn" style="left: -38px;top: -10px;">

                                    <a class="btn wb-header-btn"><i class="icow icow-sousuo-sousuo"></i></a>

                                </span>

                            </div>

                        </form>

                        <div class="wb-search-result">

                            <ul></ul>

                        </div>

                    </div> -->
                <ul class="four">
                    <!-- 管理首页 -->
                    <li>

                        <a href="<?php  echo webUrl()?>" data-toggle="tooltip" data-placement="bottom" title="管理首页"><i class="icow icow-homeL"></i></a>

                    </li>
                    <!-- 隐藏菜单 -->
                    <!-- <li class="wb-shortcut"><a id="showmenu"  ><i class="icow icow-list"></i></a></li> -->
                    <!-- 系统管理 -->
                    <?php  if($system['right_menu']['system']) { ?>

                        <li data-toggle="tooltip" data-placement="bottom" title="系统管理">

                            <a href="<?php  echo webUrl('system')?>"><i class="icow icow-syssetL"></i></a>

                        </li>

                    <?php  } ?>


                            <!-- tuichu  -->

                </ul>

                <div class="wb-header-flex"></div>
                <ul>
                    <li class="dropdown btn btn-success <?php  if($system['merch']) { ?>auto<?php  } ?>">

                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="导航"><?php  echo $system['right_menu']['menu_title'];?>
                            <!-- <span></span> 小箭头图标-->
                            <img src="../addons/ewei_shopv2/static/images/jiantou.png">
                        </a>

                        <ul class="dropdown-menu">

                            <?php  if(is_array($system['right_menu']['menu_items'])) { foreach($system['right_menu']['menu_items'] as $right_menu_item) { ?>

                                <?php  if(!is_array($right_menu_item)) { ?>

                                    <li class="divider"></li>

                                <?php  } else { ?>

                                    <li><a href="<?php  echo $right_menu_item['href'];?>" <?php  if($right_menu_item['blank']) { ?>target="_blank"<?php  } ?>> <?php  echo $right_menu_item['text'];?></a></li>

                                <?php  } ?>

                            <?php  } } ?>

                        </ul>
                    </li>
                </ul>
                <div class="fast-nav <?php  if(!empty($system['foldnav'])) { ?>indent<?php  } ?>">

                    <?php  if(!empty($system['history'])) { ?>

                        <div class="fast-list history">

                            <span class="title">最近访问</span>

                            <?php  if(is_array($system['history'])) { foreach($system['history'] as $history_item) { ?>

                                <a href="<?php  echo $history_item['url'];?>"><?php  echo $history_item['title'];?></a>

                            <?php  } } ?>

                            <a href="javascript:;" id="btn-clear-history" <?php  if($system['merch']) { ?> data-merch="1"<?php  } ?>>清除最近访问</a>

                        </div>

                    <?php  } ?>

                    <div class="fast-list menu">

                        <span class="title">全部导航</span>

                        <?php  if(is_array($sysmenus['shopmenu'])) { foreach($sysmenus['shopmenu'] as $index => $shopmenu) { ?>

                            <a href="javascript:;" <?php  if($index==0) { ?>class="active"<?php  } ?> data-tab="tab-<?php  echo $index;?>"><?php  echo $shopmenu['title'];?></a>

                        <?php  } } ?>

                        <?php  if(!empty($system['funbar']['open']) && empty($system['merch'])) { ?>

                            <a href="javascript:;" class="bold" data-tab="funbar">自定义快捷导航</a>

                        <?php  } ?>

                    </div>

                    <div class="fast-list list">

                        <?php  if(is_array($sysmenus['shopmenu'])) { foreach($sysmenus['shopmenu'] as $index => $shopmenu) { ?>

                            <div class="list-inner <?php  if($index==0) { ?>in<?php  } ?>" data-tab="tab-<?php  echo $index;?>">

                                <?php  if(is_array($shopmenu['items'])) { foreach($shopmenu['items'] as $shopmenu_item) { ?>

                                    <a href="<?php  echo $shopmenu_item['url'];?>"><?php  echo $shopmenu_item['title'];?></a>

                                <?php  } } ?>

                            </div>

                        <?php  } } ?>

                        <?php  if(!empty($system['funbar']['open']) && empty($system['merch'])) { ?>

                            <div class="list-inner" data-tab="funbar" id="funbar-list">

                                <?php  if(is_array($system['funbar']['data'])) { foreach($system['funbar']['data'] as $funbar_item) { ?>

                                    <a href="<?php  echo $funbar_item['href'];?>" style="<?php  if($funbar_item['bold']) { ?>font-weight: bold;<?php  } ?> color: <?php  echo $funbar_item['color'];?>;"><?php  echo $funbar_item['text'];?></a>

                                <?php  } } ?>

                                <a href="javascript:;" class="text-center funbar-add-btn"><i class="fa fa-plus"></i> 添加快捷导航</a>

                                <?php  if(!empty($system['funbar']['data'])) { ?>

                                    <a href="<?php  echo webUrl('sysset/funbar')?>" class="text-center funbar-add-btn"><i class="fa fa-edit"></i> 编辑快捷导航</a>

                                <?php  } ?>

                                <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('funbar', TEMPLATE_INCLUDEPATH)) : (include template('funbar', TEMPLATE_INCLUDEPATH));?>

                            </div>

                        <?php  } ?>

                    </div>

                </div>
            </div>
        </div>
        <div>
            <img src="../addons/ewei_shopv2/static/images/font_47.png" style="width:40px;height: 40px;margin: 2% 10px 0 -23%;">
            <H5>消息提醒</H5>
        </div>
        <?php  if(!$no_right) { ?>

            <div class="wb-panel in">

                <div class="panel-group" id="panel-accordion">

                    <?php if(cv('order.list.status1|order.list.status4')) { ?>

                    <div class="panel panel-default">

                        <div class="panel-heading" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                            <h4 class="panel-title">

                                <i><img src="../addons/ewei_shopv2/static/images/dingdan.png"  style="width: 23px"></i> <a class="news">订单消息</a> <span></span>

                            </h4>

                        </div>

                        <div id="collapseOne" class="panel-collapse collapse <?php  if($_W['action']!='shop.comment' && $_W['routes']!='shop.index.notice' && ($_W['action']!='apply' && $_W['plugin']!='commission')) { ?>in<?php  } ?>" aria-labelledby="headingOne">

                            <ul class="panel-body">

                                <?php  if(!empty($system['order1'])) { ?>

                                <li class="panel-list">

                                    <a class="panel-list-text" href="<?php  echo webUrl('order/list/status1')?>">待发货订单 <span class="pull-right text-warning">(<?php  echo $system['order1'];?>)</span> </a>

                                </li>

                                <?php  } ?>

                                <?php  if(!empty($system['order4'])) { ?>

                                <li class="panel-list">

                                    <a class="panel-list-text" href="<?php  echo webUrl('order/list/status4')?>">维权订单<span class="pull-right text-danger">(<?php  echo $system['order4'];?>)</span></a>

                                </li>

                                <?php  } ?>

                                <?php  if(empty($system['order1'])&&empty($system['order4'])) { ?>

                                <li class="panel-list">

                                    <div class="panel-list-text text-center">暂无消息提醒</div>

                                </li>

                                <?php  } ?>

                            </ul>

                        </div>

                    </div>

                    <?php  } ?>

                    <?php  if($system['notice']!='none' && !$system['merch']) { ?>

                        <div class="panel panel-default">

                            <div class="panel-heading" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                                <h4 class="panel-title">

                                    <i><img src="../addons/ewei_shopv2/static/images/gonggao.png"  style="width: 23px"></i>
                                     <a>内部公告</a> <span></span>

                                </h4>

                            </div>

                            <div id="collapseTwo" class="panel-collapse collapse <?php  if($_W['routes']=='shop.index.notice') { ?>in<?php  } ?>" role="tabpanel" aria-labelledby="headingTwo">

                                <ul class="panel-body">

                                    <?php  if(empty($system['notice'])) { ?>

                                    <li class="panel-list small">

                                        <div class="panel-list-text text-center">暂无消息提醒</div>

                                    </li>

                                    <?php  } else { ?>

                                    <?php  if(is_array($system['notice'])) { foreach($system['notice'] as $notice_item) { ?>

                                    <li class="panel-list small">

                                        <a class="panel-list-text" href="javascript:;" data-toggle="ajaxModal" data-href="<?php  echo webUrl('shop/index/view', array('id'=>$notice_item['id']))?>" title="<?php  echo $notice_item['title'];?>"><?php  echo $notice_item['title'];?></a>

                                    </li>

                                    <?php  } } ?>

                                    <li class="panel-list small" style="padding: 10px;">

                                        <a class="panel-list-text text-center" href="<?php  echo webUrl('shop/index/notice')?>"><span class="text-primary">查看更多</span></a>

                                    </li>

                                    <?php  } ?>

                                </ul>

                            </div>

                        </div>

                    <?php  } ?>

                    <?php  if(!$system['merch']) { ?>

                        <?php if(cv('commission.apply.view1|commission.apply.view2')) { ?>

                        <div class="panel panel-default">

                            <div class="panel-heading" role="tab" id="headingThree" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                                <h4 class="panel-title">

                                    <i><img src="../addons/ewei_shopv2/static/images/yongjin.png"  style="width: 23px"></i> 
                                    <a>佣金提现</a> <span></span>

                                </h4>

                            </div>

                            <div id="collapseThree" class="panel-collapse collapse <?php  if($_W['action']=='apply' && $_W['plugin']=='commission') { ?>in<?php  } ?>" role="tabpanel" aria-labelledby="headingFour">

                                <ul class="panel-body">

                                    <?php  if(!empty($system['commission1'])) { ?>

                                    <li class="panel-list">

                                        <a class="panel-list-text" href="<?php  echo webUrl('commission/apply', array('status'=>1))?>">待审核申请<span class="pull-right text-warning">(<?php  echo $system['commission1'];?>)</span></a>

                                    </li>

                                    <?php  } ?>

                                    <?php  if(!empty($system['commission2'])) { ?>

                                    <li class="panel-list">

                                        <a class="panel-list-text" href="<?php  echo webUrl('commission/apply', array('status'=>2))?>">待打款申请<span class="pull-right text-danger">(<?php  echo $system['commission2'];?>)</span></a>

                                    </li>

                                    <?php  } ?>

                                    <?php  if(empty($system['commission1'])&&empty($system['commission2'])) { ?>

                                    <li class="panel-list">

                                        <div class="panel-list-text text-center">暂无消息提醒</div>

                                    </li>

                                    <?php  } ?>

                                </ul>

                            </div>

                        </div>

                        <?php  } ?>

                    <?php  } ?>

                    <?php if(cv('shop.comment.edit')) { ?>

                    <div class="panel panel-default">

                        <div class="panel-heading" role="tab" id="headingFour" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">

                            <h4 class="panel-title">

                                <i><img src="../addons/ewei_shopv2/static/images/pingjia.png"  style="width: 23px"></i>
                                 <a>评价</a> <span></span>

                            </h4>

                        </div>

                        <div id="collapseFour" class="panel-collapse collapse <?php  if($_W['action']=='shop.comment') { ?>in<?php  } ?>" role="tabpanel" aria-labelledby="headingFour">

                            <ul class="panel-body">

                                <?php  if(empty($system['comment'])) { ?>

                                <li class="panel-list">

                                    <div class="panel-list-text text-center">暂无消息提醒</div>

                                </li>

                                <?php  } else { ?>

                                <li class="panel-list">

                                    <a class="panel-list-text" href="<?php  echo webUrl('shop/comment')?>">待审核评价<span class="pull-right text-warning">(<?php  echo $system['comment'];?>)</span></a>

                                </li>

                                <?php  } ?>

                            </ul>

                        </div>

                    </div>

                    <?php  } ?>


                    <?php  if($_W['isfounder'] && $_W['routes']!='system.auth.upgrade') { ?>

                    <div class="panel panel-default">

                        <div class="panel-heading" role="tab" id="headingFive" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseThree">

                            <h4 class="panel-title">

                                <i><img src="../addons/ewei_shopv2/static/images/tishi.png"  style="width: 23px"></i>
                                 <a style="position:relative;">系统提示 <i class="systips"></i></a> <span></span>

                            </h4>

                        </div>

                        <div id="collapseFive" class="panel-collapse collapse <?php  if($_W['action']=='shop.comment') { ?>in<?php  } ?>" role="tabpanel" aria-labelledby="headingFour">

                            <ul class="panel-body">

                                <li class="panel-list">

                                    <div class="panel-list-text nomsg">暂无消息提醒</div>

                                    <div class="panel-list-text upmsg" style="display: none; max-height: none;">

                                        <div>检测到更新</div>

                                        <div>新版本 <span id="sysversion">------</span></div>

                                        <div>新版本 <span id="sysrelease">------</span></div>

                                        <div>

                                            <a class="text-primary" href="<?php  echo webUrl('system/auth/upgrade')?>">立即更新</a>

                                            <a class="text-warning" href="javascript:check_ewei_shopv2_upgrade_hide();" style="margin-left: 15px;">暂不提醒</a>

                                        </div>

                                    </div>

                                </li>

                            </ul>

                        </div>

                    </div>

                    <?php  } ?>

                </div>

            </div>

        <?php  } ?>
    </div>


    <div class="row">

        <div class="col-md-4">

            <div class="ibox h300">

                <div class="ibox-title">

                    <h5><i class="icow icow-shop"></i>商城信息</h5>

                    <?php if(cv('sysset.shop.edit')) { ?>

                        <ul >

                            <a href="<?php  echo webUrl('sysset/shop')?>" class="text-primary">修改</a>

                        </ul>

                    <?php  } ?>

                </div>

                <div class="ibox-content">

                    <ul class="fui-cell-group">

                        <li class="fui-cell">商城名称：<span class="text"><?php  echo $shop_data['name'];?></span></li>

                        <li class="fui-cell">商城介绍：<span class="text"><?php  echo $shop_data['description'];?></span></li>

                        <li class="fui-cell">使用应用：<span class='text-no'><?php  echo $pluginnum;?></span>个 <a href="<?php  echo webUrl('plugins')?>" class="text-primary">查看</a></li>

                    </ul>

                </div>

            </div>

        </div>

        <div class="col-md-8">

            <div class="ibox h300">

                <div class="ibox-content  no-border">

                    <ul class="fui-list-group">

                        <!-- <?php if(cv('goods')) { ?>

                            <li class="fui-list">

                                <a href="<?php  echo webUrl('goods',array('goodsfrom'=>'out'))?>">

                                    <div class="fui-list-media">

                                        <span class="icow text-info icow-goodsL"></span>

                                    </div>

                                    <div class="fui-list-inner">

                                        <h5 class="goods_totals">-</h5>

                                        <p>已售罄商品</p>

                                    </div>

                                </a>

                            </li>

                        <?php  } ?> -->

                        <!-- <?php if(cv('order.list.status1')) { ?>

                            <li class="fui-list">

                                <a href="<?php  echo webUrl('order/list/status1')?>">

                                    <div class="fui-list-media">

                                        <span class="icow text-green icow-fahuo"></span>

                                    </div>

                                    <div class="fui-list-inner">

                                        <h5 class="order_status1">-</h5>

                                        <p><?php  if($is_openmerch==1) { ?>自营<?php  } ?>待发货订单</p>

                                    </div>

                                </a>

                            </li>

                        <?php  } ?> -->

                        <!-- <?php if(cv('order.list.status4')) { ?>

                            <li class="fui-list">

                                <a href="<?php  echo webUrl('order/list/status4')?>">

                                    <div class="fui-list-media">

                                        <span class="icow text-primary icow-tuihuo"></span>

                                    </div>

                                    <div class="fui-list-inner">

                                        <h5 class="order_status4">-</h5>

                                        <p><?php  if($is_openmerch==1) { ?>自营<?php  } ?>维权中订单</p>

                                    </div>

                                </a>

                            </li>

                        <?php  } ?> -->

                        <?php if(cv('finance.log.recharge')) { ?>
                            <li class="fui-list">
                                <a href="<?php  echo webUrl('finance/log/recharge',array('status'=>0))?>">
                                    <div class="fui-list-media">
                                        <span class="icow text-warning icow-shenhe"></span>
                                    </div>
                                    <div class="fui-list-inner">
                                        <h5 class="finance_total">-</h5>
                                        <p>点击进入审核提现列表</p>
                                    </div>
                                </a>
                            </li>
                        <?php  } ?>
                        <?php if(cv('finance.log.turnout')) { ?>
                            <li class="fui-list">
                                <a href="<?php  echo webUrl('finance/log/turnout',array('status'=>0))?>">
                                    <div class="fui-list-media">
                                        <span class="icow text-warning icow-shenhe"></span>
                                    </div>
                                    <div class="fui-list-inner">
                                        <h5 class="finance_total">-</h5>
                                        <p>点击进入一键复投记录列表</p>
                                    </div>
                                </a>
                            </li>
                        <?php  } ?>
                        <?php if(cv('finance.log.withdraw')) { ?>
                            <li class="fui-list">
                                <a href="<?php  echo webUrl('finance/log/withdraw',array('status'=>0))?>">
                                    <div class="fui-list-media">
                                        <span class="icow text-warning icow-shenhe"></span>
                                    </div>
                                    <div class="fui-list-inner">
                                        <h5 class="finance_total">-</h5>
                                        <p>点击进入投资申请列表</p>
                                    </div>
                                </a>
                            </li>
                        <?php  } ?>
                        <?php if(cv('finance.log.zhuanzhang')) { ?>
                            <li class="fui-list">
                                <a href="<?php  echo webUrl('finance/log/recharge',array('status'=>0))?>">
                                    <div class="fui-list-media">
                                        <span class="icow text-warning icow-shenhe"></span>
                                    </div>
                                    <div class="fui-list-inner">
                                        <h5 class="finance_total">-</h5>
                                        <p>点击进入转账记录列表</p>
                                    </div>
                                </a>
                            </li>
                        <?php  } ?>
                        <?php if(cv('finance.log.commission')) { ?>
                            <li class="fui-list">
                                <a href="<?php  echo webUrl('finance/log/commission',array('status'=>0))?>">
                                    <div class="fui-list-media">
                                        <span class="icow text-warning icow-shenhe"></span>
                                    </div>
                                    <div class="fui-list-inner">
                                        <h5 class="finance_total">-</h5>
                                        <p>点击进入奖励明细列表</p>
                                    </div>
                                </a>
                            </li>
                        <?php  } ?>
                        <?php if(cv('finance.log.hongbao')) { ?>
                            <li class="fui-list">
                                <a href="<?php  echo webUrl('finance/log/hongbao',array('status'=>0))?>">
                                    <div class="fui-list-media">
                                        <span class="icow text-warning icow-shenhe"></span>
                                    </div>
                                    <div class="fui-list-inner">
                                        <h5 class="finance_total">-</h5>
                                        <p>点击进入积分释放记录列表</p>
                                    </div>
                                </a>
                            </li>
                        <?php  } ?>

                    </ul>

                    <?php  if($hascommission) { ?>

                        <ul class="fui-list-group noborder">

                            <?php if(cv('commission.agent')) { ?>

                                <li class="fui-list">

                                    <a href="<?php  echo webUrl('commission/agent')?>">

                                        <div class="fui-list-media">

                                            <span class="icow text-primary icow-vip"></span>

                                        </div>

                                        <div class="fui-list-inner">

                                            <h5 class="commission_agent_total">-</h5>

                                            <p>分销总数</p>

                                        </div>

                                    </a>

                                </li>

                                <!-- <li class="fui-list">

                                    <a href="<?php  echo webUrl('commission/apply',array('status'=>1))?>">

                                        <div class="fui-list-media">

                                            <span class="icow text-warning icow-huiyuan2"></span>

                                        </div>

                                        <div class="fui-list-inner">

                                            <h5 class="commission_agent_status0_total">-</h5>

                                            <p>待审核分销商</p>

                                        </div>

                                    </a>

                                </li> -->

                            <?php  } ?>

                            <!-- <?php if(cv('commission.apply.view1')) { ?>

                                <li class="fui-list">

                                    <a href="<?php  echo webUrl('commission/apply',array('status'=>1))?>">

                                        <div class="fui-list-media">

                                            <span class="icow text-green icow-yongjinmingxi"></span>

                                        </div>

                                        <div class="fui-list-inner">

                                            <h5 class="commission_apply_status1_total">-</h5>

                                            <p>待审核佣金申请</p>

                                        </div>

                                    </a>

                                </li>

                            <?php  } ?> -->

                            <!-- <?php if(cv('commission.apply.view2')) { ?>

                                <li class="fui-list">

                                    <a href="<?php  echo webUrl('commission/apply',array('status'=>2))?>">

                                        <div class="fui-list-media">

                                            <span class="icow text-info icow-tixian1"></span>

                                        </div>

                                        <div class="fui-list-inner">

                                            <h5 class="commission_apply_status2_total">-</h5>

                                            <p>待打款佣金申请</p>

                                        </div>

                                    </a>

                                </li>

                            <?php  } ?> -->

                        </ul>

                    <?php  } ?>

                </div>

            </div>

        </div>

    </div>



    <?php  if($ordercol) { ?>

        <div class="row">
            <!-- <div class="col-md-<?php  echo $ordercol;?>">

                <div class="ibox h300" style="min-height: 404px;">

                    <div class="ibox-title">

                        <h5><i><img src="../addons/ewei_shopv2/static/images/rukou.png"  style="width: 23px"></i>入口</h5>



                    </div>

                    <div class="ibox-content ibox-content-xx">

                        <div class="tab-content relative">

                            <div class="ibox-loading" id="goods-rank-loading"></div>

                            <div class="tab-pane active" id="goods_rank_0">

                             <ul class="pic-li">
                                <a href="<?php  echo webUrl('sysset/cover/shop')?>">
                                    <li class="first">
                                        <img src="../addons/ewei_shopv2/static/images/index5.png">
                                        <p>商城入口</p>
                                    </li>
                                </a>
                                <a href="<?php  echo webUrl('sysset/cover/member')?>">
                                    <li class="first">
                                        <img src="../addons/ewei_shopv2/static/images/index6.png">
                                        <p>会员中心入口</p>
                                    </li>
                                </a>
                                <a href="<?php  echo webUrl('sysset/cover/order')?>">
                                    <li class="first">
                                        <img src="../addons/ewei_shopv2/static/images/index4.png">
                                        <p>订单入口</p>
                                    </li>
                                </a>
                                <a href="<?php  echo webUrl('sysset/cover/favorite')?>">
                                    <li>
                                        <img src="../addons/ewei_shopv2/static/images/index3.png">
                                        <p>收藏入口</p>
                                    </li>
                                </a>
                                <a href="<?php  echo webUrl('sysset/cover/cart')?>">
                                    <li>
                                        <img src="../addons/ewei_shopv2/static/images/index2.png">
                                        <p>购物车入口</p>
                                    </li>
                                </a>
                                <a href="<?php  echo webUrl('sysset/cover/coupon')?>">
                                    <li>
                                        <img src="../addons/ewei_shopv2/static/images/index1.png">
                                        <p>优惠券入口</p>
                                    </li>
                                </a>

                             </ul>

                            </div>




                        </div>



                    </div>

                </div>

            </div> -->
            <div class="col-md-<?php  echo $ordercol;?>">

                <div class="ibox" style="position: relative;">

                    <!-- <div class="ibox-title">

                        <h5><i class="icow">&#xe622;</i>订单概述</h5>

                        <ul class="nav nav-tabs" id="orderinfo">

                            <li class="active"><a data-toggle="tab"  href="#order_count_0">今日</a></li>

                            <li><a data-toggle="tab" href="#order_count_1">昨日</a></li>

                            <li><a data-toggle="tab" href="#order_count_7">最近七日</a></li>

                            <li><a data-toggle="tab" href="#order_count_30">本月</a></li>

                        </ul>

                    </div> -->

                    <!-- <div class="ibox-content">

                        <div class="tab-content" style="height: auto;">

                            <div class="tab-pane active" id="order_count_0">

                                <div class="fui-list-group">

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_count_0">-</h4>

                                            成交量(元)

                                        </div>

                                    </div>

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_price_0">-</h4>

                                            成交额(元)

                                        </div>

                                    </div>

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_avg_0">-</h4>

                                            人均消费(元)

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane" id="order_count_1">

                                <div class="fui-list-group">

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_count_1">-</h4>

                                            成交量(元)

                                        </div>

                                    </div>

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_price_1">-</h4>

                                            成交额(元)

                                        </div>

                                    </div>

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_avg_1">-</h4>

                                            人均消费(元)

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane" id="order_count_7">

                                <div class="fui-list-group">

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_count_7">-</h4>

                                            成交量(元)

                                        </div>

                                    </div>

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_price_7">-</h4>

                                            成交额(元)

                                        </div>

                                    </div>

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_avg_7">-</h4>

                                            人均消费(元)

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane" id="order_count_30">

                                <div class="fui-list-group">

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_count_30">-</h4>

                                            成交量(元)

                                        </div>

                                    </div>

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_price_30">-</h4>

                                            成交额(元)

                                        </div>

                                    </div>

                                    <div class="fui-list no-padding">

                                        <div class="fui-list-inner">

                                            <h4 class="text-warning order_avg_30">-</h4>

                                            人均消费(元)

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> -->

                </div>



                <div class="ibox">

                    <div class="ibox-content" style="border: 0;">

                        <div class="row relative">

                            <div class="ibox-loading" id="echarts-line-chart-loading"></div>

                            <div class="col-md-12">

                                <div class="" id="echarts-line-chart" style="height:156px; margin-top: 8px"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- <div class="col-md-<?php  echo $ordercol;?>">

                <div class="ibox h300">

                    <div class="ibox-title">

                        <h5><i class="icow">&#xe615;</i>商品销量排行</h5>

                        <ul class="nav nav-tabs" id="sale">

                            <li class="active"><a data-toggle="tab" href="#goods_rank_0">今日</a></li>

                            <li><a data-toggle="tab" href="#goods_rank_1">昨日</a></li>

                            <li><a data-toggle="tab" href="#goods_rank_7">最近七日</a></li>

                            <?php if(cv('statistics.goods')) { ?>

                                <li><a href="<?php  echo webUrl('statistics/goods')?>">更多</a></li>

                            <?php  } ?>

                        </ul>

                    </div>

                    <div class="ibox-content">

                        <div class="tab-content relative">

                            <div class="ibox-loading" id="goods-rank-loading"></div>

                            <div class="tab-pane active" id="goods_rank_0">

                                <table class="table table-hover">

                                    <thead>

                                    <tr>

                                        <th width="40px">排名</th>

                                        <th width="">商品名称</th>

                                        <th width="20%">成交数量</th>

                                        <th width="20%">成交金额</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                            </div>

                            <div class="tab-pane" id="goods_rank_1">

                                <table class="table table-hover">

                                    <thead>

                                    <tr>

                                        <th width="40px">排名</th>

                                        <th width="">商品名称</th>

                                        <th width="20%">成交数量</th>

                                        <th width="20%">成交金额</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                            </div>

                            <div class="tab-pane" id="goods_rank_7">

                                <table class="table table-hover">

                                    <thead>

                                    <tr>

                                        <th width="40px">排名</th>

                                        <th width="">商品名称</th>

                                        <th width="20%">成交数量</th>

                                        <th width="20%">成交金额</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                            </div>

                        </div>



                    </div>

                </div>

            </div> -->

        </div>

    <?php  } ?>



</div>





<script type="text/javascript">

    myrequire(['echarts'], function () {

        var hasLineChart = $("#echarts-line-chart").length>0;

        if(hasLineChart){

            var lineChart = echarts.init(document.getElementById("echarts-line-chart"));

        }

        window.onresize = function () {

            if(hasLineChart) {

                lineChart.resize();

            }

        };

        $.ajax({

            type: "GET",

            url: "<?php  echo webUrl('order/list/ajaxgettotals', array('merch' => -1))?>",

            dataType: "json",

            success: function (data) {

                var res = data.result;

                $(".order_status1").text(res.status1);

                $(".order_status4").text(res.status4);

                $.ajax({

                    type: "GET",

                    url: "<?php  echo webUrl('shop/ajax')?>",

                    dataType: "json",

                    success: function (data) {

                        var res = data.result;

                        $(".goods_totals").text(res.goods_totals);

                        $(".finance_total").text(res.finance_total);

                        $(".commission_agent_total").text(res.commission_agent_total);

                        $(".commission_agent_status0_total").text(res.commission_agent_status0_total);

                        $(".commission_apply_status1_total").text(res.commission_apply_status1_total);

                        $(".commission_apply_status2_total").text(res.commission_apply_status2_total);

                    }

                });

            }

        });



        $.ajax({

            type: "GET",

            url: "<?php  echo webUrl('order/ajaxorder')?>",

            dataType: "json",

            success: function (data) {

                var json = data.result;

                $(".order_count_0").text(json.order0.count);

                $(".order_price_0").text(json.order0.price);

                $(".order_avg_0").text(json.order0.avg);



                $(".order_count_1").text(json.order1.count);

                $(".order_price_1").text(json.order1.price);

                $(".order_avg_1").text(json.order1.avg);



                $(".order_count_7").text(json.order7.count);

                $(".order_price_7").text(json.order7.price);

                $(".order_avg_7").text(json.order7.avg);



                $(".order_count_30").text(json.order30.count);

                $(".order_price_30").text(json.order30.price);

                $(".order_avg_30").text(json.order30.avg);



                $.ajax({

                    type: "GET",

                    async: false,

                    url: "<?php  echo webUrl('order/ajaxtransaction')?>",

                    dataType: "json",

                    success: function (json) {

                        var lineoption = {

                            title: {

                                text: '近七日交易走势',

                                top: '100',

                                textStyle: {

                                    fontWeight: 'normal',

                                    fontSize: 12,

                                    color: '#404040',

                                    fontFamily: 'Microsoft YaHei UI',

                                }

                            },

                            tooltip: {

                                trigger: 'axis'

                            },

                            legend: {

                                data: ['成交额', '成交量']

                            },

                            grid: {

                                x: 50,

                                x2: 50,

                                y2: 30

                            },

                            calculable: true,

                            xAxis: [

                                {

                                    type: 'category',

                                    boundaryGap: false,

                                    data: json.price_key,

                                    axisLine: {

                                        lineStyle: {

                                            width: '0'

                                        }

                                    },

                                },

                            ],

                            yAxis: [

                                {

                                    type: 'value',

                                    axisLine: {

                                        lineStyle: {

                                            width: '0'

                                        }

                                    },

                                    axisLabel: {

                                        formatter: '{value}'

                                    }

                                }

                            ],

                            series: [

                                {

                                    name: '成交额',

                                    type: 'line',

                                    data: json.price_value,

                                    markPoint: {

                                        data: [

                                            {

                                                type: 'max',

                                                name: '最大值'

                                            },

                                            {

                                                type: 'min', name: '最小值'

                                            }

                                        ]

                                    },

                                    markLine: {

                                        data: [

                                            {type: 'average', name: '平均值'}

                                        ]

                                    },

                                    itemStyle: {

                                        normal: {

                                            color: '#30af84'

                                        }

                                    }

                                },

                                {

                                    name: '成交量',

                                    type: 'line',

                                    data: json.count_value,

                                    markLine: {

                                        data: [

                                            {type: 'average', name: '平均值'}

                                        ]

                                    },

                                    itemStyle: {

                                        normal: {

                                            color: '#44abf7'

                                        }

                                    }

                                }

                            ]

                        };

                        if(hasLineChart) {

                            lineChart.setOption(lineoption);

                            lineChart.resize();

                        }

                        $("#echarts-line-chart-loading").hide();

                        $("#echarts-line-chart").show();

                    }

                });

            }

        });



        var goodsUrl = "<?php  echo webUrl('goods/edit')?>&id=";

        $.ajax({

            type: "GET",

            url: "<?php  echo webUrl('shop/ajaxgoods')?>",

            dataType: "json",

            success: function (data) {

                if(data.status==1 && !$.isEmptyObject(data.result.obj)){

                    $.each(data.result.obj, function (id, obj) {

                        $("#"+id+" tbody").empty();

                        if($.isEmptyObject(obj)){

                            var html = '<tfoot><tr><td colspan="4" style="line-height: 250px; text-align: center;">暂无数据</td></tr></tfoot>';

                            $("#"+id+" table").append(html).find("thead").hide();

                        }else{

                            $.each(obj, function (index, goods) {

                                var index = index+1, title = goods.title||'空', url = goodsUrl+goods.id;

                                var html = '<tr><td>'+index+'</td><td><a href="'+url+'">'+title+'</a></td><td>'+goods.count+'</td><td class="text-warning">'+goods.money+'</td></tr>';

                                $("#"+id+" tbody").append(html);

                            });

                        }

                    })

                }

                $("#goods-rank-loading").hide();

            }

        });

    });

</script>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
