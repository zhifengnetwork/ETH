<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('commission/common', TEMPLATE_INCLUDEPATH)) : (include template('commission/common', TEMPLATE_INCLUDEPATH));?>

<style>
    .page-commission-shares .img{
        height: 100%;
    }
    .page-commission-shares .img img{
        height: 100%;
    }
</style>


<div class="fui-page fui-page-current page-commission-shares">

    <?php  if(is_h5app()) { ?>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">推广二维码</div>

        <div class="fui-header-right"></div>

    </div>

    <?php  } ?>

    <div class="fui-content">

        <?php  if(!empty($goods)) { ?>

        <div class="fui-list-group">

            <div class="fui-list">

                <div class="fui-list-media">

                    <i class="icon icon-money"></i>

                </div>

                <div class="fui-list-inner">

                    <div class="row">

                        <div class="row-text">预计最高<?php  echo $this->set['texts']['commission1']?> <span class='text-danger'><?php  echo $commission;?></span> <?php  echo $this->set['texts']['yuan']?>

                        </div>

                    </div>

                    <div class="subtitle">已销售 <span><?php  echo $goods['sales'];?></span> 件</div>

                </div>

            </div>

        </div>

        <?php  } ?>

        <!-- 系统生成图片 开始 -->

        <div class="img" id='posterimg'>

	    <div class='fui-cell-group'>

		<div class='fui-cell'>

		    <div class='fui-cell-info text-center'><div class="fui-preloader"></div><br/>正在生成海报，请稍后...</div>

		</div>

	    </div>

	    <img src="" style="display:none;" />

        </div>

    </div>

</div>

<script language='javascript'>

		require(['../addons/ewei_shopv2/plugin/commission/static/js/qrcode.js'], function (modal) {

			modal.init({goodsid: <?php  echo intval($_GPC['goodsid'])?>});

		});

	</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>



<!--青岛易联互动网络科技有限公司-->
