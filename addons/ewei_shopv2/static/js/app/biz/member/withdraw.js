define(['core', 'tpl'], function(core, tpl) {
    var modal = {};
    modal.allow = function() {
        if (!$('#money').isNumber() || $('#money').isEmpty()) {
            return false
        } else {
            var money = parseFloat($('#money').val());
            if (money <= 0) {
                return false
            }
            if (modal.min > 0) {
                if (money < modal.min) {
                    return false
                }
            }
            if (money > modal.max) {
                return false
            }
        }
        if (modal.withdrawcharge > 0 && money != 0) {
            var deductionmoney = money / 100 * modal.withdrawcharge;
            deductionmoney = Math.round(deductionmoney * 100) / 100;
            if (deductionmoney >= modal.withdrawbegin && deductionmoney <= modal.withdrawend) {
                deductionmoney = 0
            }
            var realmoney = money - deductionmoney;
            realmoney = Math.round(realmoney * 100) / 100;
            $("#deductionmoney").html(deductionmoney);
            $("#realmoney").html(realmoney);
            $(".charge-group").show()
        }
        return true
    };
    modal.init = function(params) {
        modal.withdrawcharge = params.withdrawcharge;
        modal.withdrawbegin = params.withdrawbegin;
        modal.withdrawend = params.withdrawend;
        modal.min = params.min;
        modal.max = params.max;
        var checked_applytype = $('#applytype').find("option:selected").val();
        if (checked_applytype == 2) {
            $('.ab-group').show();
            $('.alipay-group').show();
            $('.bank-group').hide()
        } else if (checked_applytype == 3) {
            $('.ab-group').show();
            $('.alipay-group').hide();
            $('.bank-group').show()
        } else {
            $('.ab-group').hide();
            $('.alipay-group').hide();
            $('.bank-group').hide()
        }
        $('#applytype').change(function() {
            var applytype = $(this).find("option:selected").val();
            if (applytype == 2) {
                $('.ab-group').show();
                $('.alipay-group').show();
                $('.bank-group').hide()
            } else if (applytype == 3) {
                $('.ab-group').show();
                $('.alipay-group').hide();
                $('.bank-group').show()
            } else {
                $('.ab-group').hide();
                $('.alipay-group').hide();
                $('.bank-group').hide()
            }
        });
        $('#btn-all').click(function() {
            if (modal.max <= 0) {
                return
            }
            $('#money').val(modal.max);
            if (!modal.allow()) {
                $('#btn-next').addClass('disabled')
            } else {
                $('#btn-next').removeClass('disabled')
            }
        });
        $('#money').bind('input propertychange', function() {
            if (!modal.allow()) {
                $('#btn-next').addClass('disabled')
            } else {
                $('#btn-next').removeClass('disabled')
            }
        });
        $('#btn-next').click(function() {
            // var money = $.trim($('#money').val());
            // var current = $.trim($("#current").html());
            var money = Number($('#money').val());
            var current = Number(modal.max);
            
            if(current<money){
                FoxUI.toast.show('您账户余额不足');
                return
            }
            if (!$('#money').isNumber()) {
                FoxUI.toast.show('请输入提现金额!');
                return
            }
            
            $('.btn-withdraw').attr('submit', 1);
                   core.json('member/withdraw/submit', {
                       money: money,
                       realmoney: $('#realmoney').html(),
                       charge: $('#deductionmoney').html(),
                    }, function(rjson) {
                             
                            if (rjson.status == '-1') {
                                FoxUI.toast.show('请绑定您的钱包地址和二维码!');
                                location.href = core.getUrl('member/payManage', {
                                type: 1
                            })
                            // console.log(rjson);exit();   
                            }
                            if (rjson.status != 1) {
                                $('.btn-widthdraw').removeAttr('submit');
                                FoxUI.toast.show(rjson.result.message);
                                return
                            }
                           $('#btn-next').css('pointer-events', 'none');
                           FoxUI.toast.show('余额提现成功!');
                            location.href = core.getUrl('member/investmentjilu', {
                                type: 4
                            })
                    }, true, true)
            })
        
    };
    return modal
});