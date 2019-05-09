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
                    modal.changeTab(1)
                },
                tab2: function () {
                    modal.changeTab(4)
                },
                tab3: function () {
                    modal.changeTab(2)
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
        core.json('member/investmentjilu/record', {
            page: modal.page,
            type: modal.type
        }, function (ret) {
            var result = ret.result.result;
            console.log(result);

            if (result.list.length <= 0) {
                $('.container').hide();
                $('.content-empty').show();
                $('.fui-content').infinite('stop');
            } else {
                $('.container').show();
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                $('.fui-content').infinite('stop')
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
                if (modal.type == 1) {
                    modal.page++;
                    $('.title').html('投资记录')
                    core.tpl('.container', 'tpl_getList1', result, modal.page > 1);
                } else if (modal.type == 4) {
                    modal.page++;
                    $('.title').html('提币记录')
                    core.tpl('.container', 'tpl_getList2', result, modal.page > 1);
                }else if(modal.type ==3 ){
                    modal.page++;
                    $('.title').html('转币记录')
                    core.tpl('.container', 'tpl_getList3', result, modal.page > 1);
                }
            }

        })
    };
    return modal;
});