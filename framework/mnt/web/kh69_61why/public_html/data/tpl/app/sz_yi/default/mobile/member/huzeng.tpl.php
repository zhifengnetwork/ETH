<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>互赠记录</title>
<style type="text/css">
body {
	margin: 0px;
	background: #eee;
	font-family: '微软雅黑';
	-moz-appearance: none;
}

.credit_list {
	height: 40px;
	width: 94%;
	background: #fff;
	padding: 10px 3%;
	margin-top: 5px;
}

.credit_list .info {
	height: 40px;
	width: 70%;
	float: left;
	font-size: 16px;
	color: #666;
	line-height: 20px;
	text-align: left;
}

.credit_list .info span {
	font-size: 14px;
	color: #999;
}

.credit_list .num {
	height: 40px;
	border-left: 1px solid #eaeaea;
	width: 20%;
	line-height: 40px;
	float: right;
	text-align: right;
	font-size: 16px;
	color: #666;
}

.credit_list .num span {
	font-size: 14px;
	color: #999;
}

.credit_tab {
	height: 30px;
	margin: 5px;
	border: 1px solid #ff6801;
	border-radius: 5px;
	overflow: hidden;
	font-size: 13px;
	background: #fff;
	padding-right: -2px;
}

.credit_nav {
	height: 30px;
	width: 25%;
	background: #fff;
	color: #666;
	text-align: center;
	line-height: 30px;
	float: left;
	border-right:1px solid #ddd; 
	box-sizing:border-box;
}

.credit_navon {
	color: #fff;
	background: #ff6801;
}

.credit_no {
	height: 100px;
	width: 100%;
	margin: 50px 0px 60px;
	color: #ccc;
	font-size: 12px;
	text-align: center;
}

#credit_loading {
	padding: 10px;
	color: #666;
	text-align: center;
}
</style>
<div class="page_topbar">
	<a href="javascript:;" class="back" onclick="history.back()"><i
		class="fa fa-angle-left"></i></a>
	<div class="title">互赠记录</div>
</div>

<div class="credit_tab">
	<div class="credit_nav <?php  if($_GPC['type']==0) { ?>credit_navon<?php  } ?> "
		data-type='0' border-right:1px solid #ddd >赠金果记录</div>
	<div class="credit_nav <?php  if($_GPC['type']==1) { ?>credit_navon<?php  } ?>  "
		data-type='1'>赠耕种果记录</div>
	<div class="credit_nav <?php  if($_GPC['type']==2) { ?>credit_navon<?php  } ?>  "
		data-type='2'>收金果记录</div>
	<div class="credit_nav <?php  if($_GPC['type']==3) { ?>credit_navon<?php  } ?>"
		data-type='3'>收耕种果记录</div>
</div>


<div id='container'></div>

<script id='tpl_log' type='text/html'>
    <%each list as log%>
    <div class="credit_list">
        <div class="info">
            <span>
			<%if zyw==0%> 
                我赠<%log.shouopenid%>
                <%log.jine%> 个金果</span>
            <br/><span><%log.time%></span></div>
       <%/if %> 
            <%if zyw==1%> 
               我赠<%log.shouopenid%>
                <%log.jine%> 个耕种果</span>
            <br/><span><%log.time%></span></div>
       <%/if %>
 		<%if zyw==2%> 
                <%log.zhuanopenid%>赠我
                <%log.jine%> 个金果</span>
            <br/><span><%log.time%></span></div>
       <%/if %> 
<%if zyw==3%> 
                <%log.zhuanopenid%>赠我
                <%log.jine%> 个耕种果</span>
            <br/><span><%log.time%></span></div>
       <%/if %> 
        </div>
    </div>
    <%/each%>
</script>
<script id='tpl_empty' type='text/html'>
    <div class="credit_no"><i class="fa fa-file-text-o" style="font-size:100px;"></i><br><span style="line-height:18px; font-size:16px;">暂时没有任何记录~</span></div>
</script>

<script language="javascript">
	var page = 1;
	var scrolled = false;
	var current_type = "<?php  echo intval($_GPC['type'])?>";
	require(
			[ 'tpl', 'core' ],
			function(tpl, core) {

				function bindScroller() {
					var loaded = false;
					var stop = true;

					$(window)
							.scroll(
									function() {
										if (loaded) {
											return;
										}
										totalheight = parseFloat($(window)
												.height())
												+ parseFloat($(window)
														.scrollTop());
										if ($(document).height() <= totalheight) {

											if (stop == true) {
												stop = false;
												scrolled = true;
												$('#container')
														.append(
																'<div id="credit_loading"><i class="fa fa-spinner fa-spin"></i> 正在加载...</div>');
												page++;
												core
														.json(
																'member/huzeng',
																{
																	type : current_type,
																	page : page
																},
																function(json) {
																	console
																			.log(json);
																	stop = true;
																	$(
																			'#credit_loading')
																			.remove();
																	$(
																			"#container")
																			.append(
																					tpl(
																							'tpl_log',
																							morejson.result));
																	if (morejson.result.list.length < morejson.result.pagesize) {
																		$(
																				"#container")
																				.append(
																						'<div id="credit_loading">已经加载完全部记录</div>');
																		loaded = true;
																		$(window).scroll = null;
																		return;
																	}
																}, true);
											}
										}
									});
				}
				function getLog(type) {
					$('.credit_nav').removeClass('credit_navon');
					$('.credit_nav[data-type=' + type + ']').addClass(
							'credit_navon');
					core.json('member/huzeng', {
						type : type,
						page : page
					}, function(json) {
						console.log(json);
						if (json.result.list.length <= 0) {
							$('#container').html(tpl('tpl_empty'));
							return;
						}
						$('#container').html(tpl('tpl_log', json.result));
						bindScroller();
					}, true);
				}
				$('.credit_nav').unbind('click').click(function() {
					page = 1;
					current_type = $(this).data('type')
					getLog(current_type);

				});
				getLog(current_type);
			})
</script>
<?php  $show_footer=true?> <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
