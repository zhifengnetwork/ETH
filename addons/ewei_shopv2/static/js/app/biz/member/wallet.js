define(['core', 'tpl'], function(core, tpl) {
    var modal = {};
    modal.init = function(params) {
        params = $.extend({
            returnurl: '',
            template_flag: 0,
            new_area: 0
        }, params || {});

        var reqParams = ['foxui.picker'];
        if (params.new_area) {
            reqParams = ['foxui.picker', 'foxui.citydatanew']
        }
        require(reqParams, function() {
            $('#city').cityPicker({
                new_area: params.new_area,
                showArea: false
            });
            $('#birthday').datePicker()
        });



    };

    return modal
});