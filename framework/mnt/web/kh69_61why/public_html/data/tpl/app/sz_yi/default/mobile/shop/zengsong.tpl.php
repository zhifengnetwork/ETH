<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>转赠</title>
<style type="text/css">
body {
	margin: 0px;
	background: #efefef;
	font-family: '微软雅黑';
	-moz-appearance: none;
}

.info_main {
	height: auto;
	background: #fff;
	margin-top: 14px;
	border-bottom: 1px solid #e8e8e8;
	border-top: 1px solid #e8e8e8;
}

.info_main .line {
	margin: 0 10px;
	height: 40px;
	border-bottom: 1px solid #e8e8e8;
	line-height: 40px;
	color: #999;
}

.info_main .line .title {
	height: 40px;
	width: 90px;
	line-height: 40px;
	color: #444;
	float: left;
	font-size: 16px;
}

.info_main .line .info {
	width: 100%;
	float: right;
	margin-left: -90px;
}

.info_main .line .inner {
	margin-left: 80px;
}

.info_main .line .inner input {
	height: 40px;
	width: 100%;
	display: block;
	padding: 0px;
	margin: 0px;
	border: 0px;
	float: left;
	font-size: 16px;
}

.info_main .line .inner select {
	border: 1px solid #ccc;
	height: 30px;
	min-width: 120px;
	line-height: 30px;
	padding: 0 5px
}

.info_sub {
	height: 44px;
	margin: 14px 5px;
	background: #31cd00;
	border-radius: 4px;
	text-align: center;
	font-size: 16px;
	line-height: 44px;
	color: #fff;
}
</style>
<div class='container'>
	<div class="page_topbar" style="background: #fff">
		<a href="javascript:;" class="back" onclick="history.back()"><i
			class="fa fa-angle-left"></i></a>
		<div class="title">转赠</div>
	</div>
	<div class="info_main">
		<div class="line">
			<div class="title">转增类型：</div>
			<div class='info'>
				<div class='inner'>耕种果</div>
			</div>
		</div>
		<!--         <div class="line">
            <div class="title">受赠类型：</div>
            <div class='info'>
                <div class='inner'>
                    希望果
                </div>
            </div>
        </div>
        <div class="line">
            <div class="title">累计数量：</div>
            <div class='info'>
                <div class='inner'>
                    0
                </div>
            </div>
        </div> -->
		<div class="line">
			<div class="title">现有数量：</div>
			<div class='info'>
				<div class='inner'>
					<input type="text" id="xianyou" disabled="true"
						value="<?php  echo $gengzhongguo;?>" />
				</div>
			</div>
		</div>
		<!--     <div class="line">
            <div class="title">可用数量：</div>
            <div class='info'>
                <div class='inner'>
                    0
                </div>
            </div>
        </div> -->
		<div class="line">
			<div class="title">获赠人ID：</div>
			<div class='info'>
				<div class='inner'>
					<input type="text" id="userid" placeholder="请输入获赠人ID" value="" />
				</div>
			</div>
		</div>
		<div class="line">
			<div class="title">转赠数量：</div>
			<div class='info'>
				<div class='inner'>
					<input type="text" id="zeng" placeholder="请输入转赠数量" />
				</div>
			</div>
		</div>
	</div>
	<div class="info_sub">确认转赠</div>
</div>
<script type='text/javascript'>
	require([ 'tpl', 'core' ], function(tpl, core) {
		var aaa;
		$("#userid").blur(function() {
			var id = $(this).val();

			core.json('shop/jinguo', {
				'op' : 'zengsongren',
				'id' : id,

			}, function(json) {
				if (json.status == 1) {
					console.log(json);
					aaa = json.result;

					$("#userid").attr({
						aaa : json.realname
					});
				} else {
					core.tip.show('获赠人ID错误!');
				}
			});
		});
		$(".info_sub").click(function() {
			if (typeof (aaa) == 'undefined') {

				return 0;
			}
			var a = $("#userid").val();
			var b = parseFloat($("#zeng").val()).toFixed(2);
			var v = parseFloat($("#xianyou").val()).toFixed(2);
			var z = v-b;
			if (z < 0 || b <= 0) {
				alert("请输入正确的数字");
				return;
			}
			if (confirm('确定要给 ' + aaa + ' 转赠 ' + b + '耕种果？')) {
				core.json('shop/zengsong', {
					'op' : 'zengsong',
					'zeng' : b,
					'userid' : a
				}, function(json) {
					console.log(json);
					if (json.status == -1) {
						alert(json.result);
					} else if (json.status == 1) {
						alert("您给" + json.result + "成功赠送了" + b + "个耕种果");
						location.reload();
					}
				}, true, true);
			}
		});
	});
</script>
