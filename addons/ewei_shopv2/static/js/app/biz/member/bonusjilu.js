define(['core', 'tpl'], function (core, tpl) {
    var modal = {
        page: 1,
        type: 1
    };
    modal.init = function (params) {
        modal.type = params.type;
        FoxUI.tab({
            container: $('#tab'),
            handlers: {
                tab1: function () {
                    modal.changeTab(4)
                },
                tab2: function () {
                    modal.changeTab(1)
                },
                tab3: function () {
                    modal.changeTab(2)
                },
                tab4: function () {
                    modal.changeTab(3)
                }
            }
        });
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        });
        if (modal.page == 1) {
            modal.getList()
        }
    };
    modal.changeTab = function (type) {
        $('.container').html(''), $('.infinite-loading').show(), $('.content-empty').hide(), modal.page = 1, modal.type = type, modal.getList()
    };
    modal.getList = function () {
        core.json('member/bonusjilu/record', {
            page: modal.page,
            type: modal.type
        }, function (ret) {
            var result = ret.result;
            console.log(ret);

            if (result.list.length <= 0) {
                $('.container').hide();
                $('.content-empty').show();
                $('.fui-content').infinite('stop');
                $('.cont_tit').hide();
            } else {
                $('.cont_tit').show();
                $('.container').show();
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                $('.fui-content').infinite('stop')
                // if (result.list.length <= 0 || result.list.length < result.pagesize) {

                // }
                if (modal.type == 4) {
                    $('.cont_tit').html('收益总额：' + result.money);
                    modal.page++;
                    core.tpl('.container', 'tpl_member_bonus_list4', result, modal.page > 1);
                }else if (modal.type == 1) {
                    $('.cont_tit').html('直推奖总额：' + result.money);
                    modal.page++;
                    core.tpl('.container', 'tpl_member_bonus_list', result, modal.page > 1);
                } else if (modal.type == 2) {
                    $('.cont_tit').html('管理奖总额：' + result.money);
                    modal.page++;
                    core.tpl('.container', 'tpl_member_bonus_list', result, modal.page > 1);
                } else if (modal.type == 3) {
                    $('.cont_tit').html('领导奖总额：' + result.money);
                    modal.page++;
                    core.tpl('.container', 'tpl_member_bonus_list', result, modal.page > 1);
                }
            }

        })
    };
    return modal;
}); 