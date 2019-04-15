<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('commission/common', TEMPLATE_INCLUDEPATH)) : (include template('commission/common', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.fui-list-box{
		height: 70px;overflow: hidden;
		border-bottom: 1px solid #ccc;
	}
	.fui-list{
		height: 70px;    padding: 0 .5rem!important;
	}
	.down{
		padding:0 0 0 .5rem;color:#999;    display: -webkit-box;
	    display: -webkit-flex;
	    display: -ms-flexbox;
	    display: flex;
	}
	.down .left{
		width: 2.5rem;margin-right: .5rem
	}
</style>
<div class="fui-page fui-page-current page-commission-down">

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

		<div class="title"><?php  echo $this->set['texts']['mydown']?>(<span id="sum">0</span>)</div>

    </div>

    <div class="fui-content navbar">

        <?php  if($this->set['level']>=2) { ?>

        <div class="fui-tab fui-tab-warning" id="tab">

            <a class="active" href="javascript:void(0)" data-tab='level1'><?php  echo $this->set['texts']['c1']?>(<?php  echo $level1;?>)</a>

            <?php  if($this->set['level']>=2) { ?><a href="javascript:void(0)" data-tab='level2'><?php  echo $this->set['texts']['c2']?>(<?php  echo $level2;?>)</a><?php  } ?>

            <?php  if($this->set['level']>=3) { ?><a href="javascript:void(0)" data-tab='level3'><?php  echo $this->set['texts']['c3']?>(<?php  echo $level3;?>)</a><?php  } ?>

        </div>

        <?php  } ?>





        <div class="fui-title">成员信息 <i class="icon icon-favor text-danger"></i> 为已经成为该账户的下级
            

        </div>

        <div class="fui-list-group" id="container"></div>

        <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>



		<div class='content-empty' style='display:none;'>

			<i class='icon icon-group'></i><br/>暂时没有任何数据

		</div>



    </div>





	<script id='tpl_commission_down_list' type='text/html'>

		<%each list as user%>
		<div class="fui-list-box">
			<div class="fui-list show">

				<div class="fui-list-media">

					<%if user.avatar%>

					<img data-lazy="<?php  echo $_W['attachurl'];?><%user.avatar%>" class="round" onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'">

					<%else%>

					<i class="icon icon-my2"></i>

					<%/if%>

				</div>

				<div class="fui-list-inner">

					<div class="row">

					      <div class="row-text">

						  <%if user.isagent==1 && user.status==1%>

						  <i class="icon icon-favor text-danger"></i>

						  <%/if%>

						  <%if user.nickname%><%user.nickname%><%else%>未获取<%/if%>

					      

					      </div>

					</div>

					<div class="subtitle">

					      <%if user.isagent==1 && user.status==1%>

					    成为下级时间: <%user.agenttime%>

					    <%else%>

					    注册时间:  <%user.createtime%>

					    <%/if%>

					    

					</div>

				</div>

				<div class="row-remark">

					<%if user.isagent==1 && user.status==1%>

						<% if user.type == 1 %>
						<p>直推</p>
						<% else %>
						<p>团队</p>
						<% /if %>

					<!--<p><%user.agentcount%>个成员</p>-->

					<%else%>

					<!--<p>消费: <%user.moneycount%><?php  echo $this->set['texts']['yuan']?></p>-->

					<!--<p><%user.ordercount%>个订单</p>-->

					<%/if%>

				</div>

			</div>
			
			<div class="down">
				<div class="left"><!-- 详细信息： --></div>
				<div>
					<%if user.mobile == ''%>
					<p>暂无绑定手机号</p>
					<% else %>
					<p>电话：<%user.mobile%></p>
					<%/if%>
				</div>
			</div>
			
		</div>

		<%/each%>
		<script type="text/javascript">
			$(function(){
				$('.fui-list-box').click(function(){
					let $this = $(this);
					let boxHeight = $this.height() + 1;
					let showHeight = $this.find('.show').height();
					let hideHeight = $this.find('.down').height();
					let height = showHeight+hideHeight;
					
					console.log(showHeight,hideHeight,boxHeight,height);
					if(boxHeight == showHeight){
						$this.animate({'height':height});
						$this.siblings().animate({'height':showHeight},'fast');
						console.log('toshow');
					}else{
						$this.animate({'height':showHeight});
						console.log('tohide');
					}
				})
			})
		</script>
	</script>



	<script language='javascript'>

		require(['../addons/ewei_shopv2/plugin/commission/static/js/down.js'], function (modal) {

			modal.init();
			// modal.init({fromDetail: false});

		});
		
	</script>

</div>

<?php  $this->footerMenus()?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>


