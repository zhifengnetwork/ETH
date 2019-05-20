define(['core', 'tpl'], function (core, tpl) {
	var modal = {
		minimumcharge: 0,
		wechat: 0,
		alipay: 0,
		couponid: 0,
		coupons: []
	};
	modal.init = function (params) {
		modal.minimumcharge = params.minimumcharge;
		modal.wechat = params.wechat;
		modal.alipay = params.alipay;
		window.couponid = modal.couponid;
		$('#money').bind('input propertychange', function () {
			modal.hideCoupon();
			$('#btn-next').addClass('disabled').show(), $('.btn-pay').hide();
			if ($(this).isNumber() && !$(this).isEmpty() && parseFloat($(this).val()) > 0) {
				$('#btn-next').removeClass('disabled')
			}
		});
		$('#btn-next').click(function () {
			// FoxUI.toast.show('最低投资金额为' + modal.minimumcharge + '元!');
			var money = $.trim($('#money').val());

			core.json('member/recharge/payment', {
				type: 1
			}, function (pay_json) {
				console.log(pay_json);
				// if(pay_json.result.wx == 1){
				$('.erweima').css('display', 'flex')
				// }
				// if(pay_json.result.zfb == 1){
				// 	$('#zfb').css('display','block')
				// }
				// if(pay_json.result.yhk == 1){
				// 	$('#bank').css('display','block')
				// }

				// $('.bank img').attr('src','../attachment/'+pay_json.result.yhkfile+'');
				// $('.zfb img').attr('src','../attachment/'+pay_json.result.zfbfile+'');
				$('.erweima img').attr('src', '../attachment/' + pay_json.result.weixinfile + '');
				$('#skaddress').attr('value', pay_json.result.add);
				// exit();
				$('#btn-next').remove();
			}, true, true)
		});
		$('.btn-sub').click(function () {
			if ($('#avatar').isEmpty()) {
				core.tip.show('请上传支付凭证！');
				return false;
			}
			var money = $.trim($('#money').val());
			var url = $('#avatar').val();
			core.json('member/recharge/wechat_complete', {
				money: money,
				url: url
			}, function (pay_json) {
				// console.log(pay_json);exit();
				if (pay_json.status.type == -1) {
					FoxUI.toast.show('投资区间在' + pay_json.status.start + '到' + pay_json.status.end + '之间');
					return false;
				}
				if (pay_json.status == 1) {

					FoxUI.toast.show('投资成功!');
					location.href = core.getUrl('member/investmentjilu&type=1');
					// return
				}
				if (pay_json.status == 0) {

					FoxUI.toast.show('您的投资之和已超过上限投资金额!');
				}
			}, true, true)

			var showpay = false;
			if ($(this).attr('submit')) {
				return
			}
			if (!$.isEmpty(money)) {
				if ($.isNumber(money) && parseFloat(money) > 0) {
					if (modal.minimumcharge > 0) {
						if (parseFloat(money) < modal.minimumcharge) {
							FoxUI.toast.show('最低充值金额为' + modal.minimumcharge + '元!');
							return
						} else {
							showpay = true
						}
					} else {
						showpay = true
					}
				}
			}
			if (!showpay) {
				return
			}
			$(this).attr('submit', '1');
			core.json('sale/coupon/util/query', {
				money: money,
				type: 1
			}, function (rjson) {
				if (rjson.status != 1) {
					$('#btn-sub').removeAttr('submit');
					core.tip.show(rjson.result);
					return
				}
				if (rjson.result.coupons.length > 0) {
					$('#coupondiv').show().find('.badge').html(rjson.result.coupons.length).show();
					$('#coupondiv').find('.text').hide();
					$('#coupondiv').click(function () {
						require(['biz/sale/coupon/picker'], function (picker) {
							picker.show({
								couponid: modal.couponid,
								coupons: rjson.result.coupons,
								onCancel: function () {
									window.couponid = modal.couponid = 0;
									$('#coupondiv').find('.fui-cell-label').html('优惠券');
									$('#coupondiv').find('.fui-cell-info').html('')
								},
								onSelected: function (data) {
									$('#coupondiv').find('.fui-cell-label').html('已选择');
									$('#coupondiv').find('.fui-cell-info').html(data.couponame);
									window.couponid = modal.couponid = data.couponid
								}
							})
						})
					})
				} else {
					modal.hideCoupon()
				}
				$('#btn-sub').removeAttr('submit').hide();
				if (core.ish5app()) {
					$('#btn-wechat').show();
					$('#btn-alipay').show();
					return
				}
				if (modal.wechat) {
					$('#btn-wechat').show()
				}
				if (modal.alipay) {
					$('#btn-alipay').show()
				}
			}, true, true)
		});
		$(document).on('click', '#btn-wechat', function () {
			if ($('.btn-pay').attr('submit')) {
				return
			}
			var money = $('#money').val();
			if (money <= 0) {
				FoxUI.toast.show('充值金额必须大于0!');
				return
			}
			if (!$('#money').isNumber()) {
				FoxUI.toast.show('请输入数字金额!');
				return
			}
			$('.btn-pay').attr('submit', 1);
			core.json('member/recharge/submit', {
				type: 'wechat',
				money: money,
				couponid: modal.couponid
			}, function (rjson) {
				if (rjson.status != 1) {
					$('.btn-pay').removeAttr('submit');
					FoxUI.toast.show(rjson.result.message);
					return
				}
				if (core.ish5app()) {
					appPay('wechat', rjson.result.logno, rjson.result.money, true);
					return
				}
				var wechat = rjson.result.wechat;
				if (wechat.weixin) {
					function onBridgeReady() {
						WeixinJSBridge.invoke('getBrandWCPayRequest', {
							'appId': wechat.appid ? wechat.appid : wechat.appId,
							'timeStamp': wechat.timeStamp,
							'nonceStr': wechat.nonceStr,
							'package': wechat.package,
							'signType': wechat.signType,
							'paySign': wechat.paySign
						}, function (res) {
							if (res.err_msg == 'get_brand_wcpay_request:ok') {
								var sub = setInterval(function () {
									core.json('member/recharge/wechat_complete', {
										logid: rjson.result.logid
									}, function (pay_json) {
										if (pay_json.status == 1) {
											clearInterval(sub);
											FoxUI.toast.show('充值成功!');
											location.href = core.getUrl('member');
											return
										}
									}, true, true)
								}, 2000)
							} else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
								$('.btn-pay').removeAttr('submit');
								FoxUI.toast.show('取消支付')
							} else {
								core.json('member/recharge/submit', {
									type: 'wechat',
									money: money,
									couponid: modal.couponid,
									jie: 1
								}, function (wechat_jie) {
									modal.payWechatJie(wechat_jie.result, money)
								}, false, true)
							}
						})
					}
					if (typeof WeixinJSBridge == "undefined") {
						if (document.addEventListener) {
							document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false)
						} else if (document.attachEvent) {
							document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
							document.attachEvent('onWeixinJSBridgeReady', onBridgeReady)
						}
					} else {
						onBridgeReady()
					}
				}
				if (wechat.weixin_jie || wechat.jie == 1) {
					modal.payWechatJie(rjson.result, money)
				}
			}, true, true)
		});
		$(document).on('click', '#btn-alipay', function () {
			if ($('.btn-pay').attr('submit') && !core.ish5app()) {
				return
			}
			if (money <= 0) {
				FoxUI.toast.show('充值金额必须大于0!');
				return
			}
			var money = $('#money').val();
			if (!$('#money').isNumber()) {
				FoxUI.toast.show('请输入数字金额!');
				return
			}
			$('.btn-pay').attr('submit', 1);
			core.json('member/recharge/submit', {
				type: 'alipay',
				money: money,
				couponid: modal.couponid
			}, function (rjson) {
				if (rjson.status != 1) {
					$('.btn-pay').removeAttr('submit');
					FoxUI.toast.show(rjson.result.message);
					return
				}
				if (core.ish5app()) {
					appPay('alipay', rjson.result.logno, money, '1', null, true)
				} else {
					location.href = core.getUrl('order/pay_alipay', {
						orderid: rjson.result.logno,
						type: 1,
						url: rjson.result.alipay.url
					})
				}
			}, true, true)
		})
	};
	modal.payWechatJie = function (res, money) {
		var img = core.getUrl('index/qr', {
			url: res.wechat.code_url
		});
		$('#qrmoney').text(money);
		$('#btnWeixinJieCancel').unbind('click').click(function () {
			$('.btn-pay').removeAttr('submit');
			clearInterval(settime);
			$('.order-weixinpay-hidden').hide()
		});
		$('.order-weixinpay-hidden').show();
		var settime = setInterval(function () {
			core.json('member/recharge/wechat_complete', {
				logid: res.logid
			}, function (pay_json) {
				if (pay_json.status == 1) {
					location.href = core.getUrl('member');
					return
				}
			}, false, true)
		}, 1000);
		$('.verify-pop').find('.close').unbind('click').click(function () {
			$('.order-weixinpay-hidden').hide();
			$('.btn-pay').removeAttr('submit');
			clearInterval(settime)
		});
		$('.verify-pop').find('.qrimg').attr('src', img).show()
	};
	modal.hideCoupon = function () {
		$('#coupondiv').hide();
		$('#coupondiv').find('.badge').html('0').hide();
		$('#coupondiv').find('.text').show()
	};
	return modal
});
