require(['jquery', 'util', colResizablejs], function ($, u) {
	editdata = function (btn) {
		var row = $(btn).parent().parent();
		var data = $(row).find(".field").val();
		var id = $(row).find("td:first").html();
		$("#rowid").val(id);
		data = eval("(" + data + ")");
		tb.clear();
		tb.init(data);
		var s = tb.webedit();
		$("#data-modal").find(".modal-body").html(s);
		tb.initwebedits();
		$("#data-modal").modal('show');
	}
	show_image_modal = function (btn) {
		var img = $(btn).find("img").attr("src");
		util.message('<img width=538px src="' + img + '">');
		util.dialog('', '<img style="max-width:568px;max-height:568px;" src="' + img + '">');
	};
	postmodify = function(){
		tb.getwebvalue("#data-modal");
		$("#modifyform").submit();
	};
	var showimages = function (row, k, files) {
		var i = 8 + parseInt(k);
		var s = "";
		for (var j in files) {
			if (files[j].length > 0) {
				s = s + '<a href="javascript:void(0);" onclick="show_image_modal(this);"><img height=25px src="' + u.tomedia(files[j]) + '"></a>&nbsp;';
			}
		}
		$(row).find("td:eq(" + i + ")").html(s);
	};
	var getimages = function (row, k, sn, value) {
		var id = $(row).find("td:eq(0)").html();
		$.ajax({
			type : "POST",
			url : getiamgeurl,
			data : {
				orderid : id,
				field : sn,
				mediaids : value.serverIds
			},
			dataType : "json",
			success : function (data) {
				var files = data.data;
				if (files) {
					files = files.split(";");
					showimages(row, k, files);
				}
			}
		});
	};
	$(document).ready(function () {
		u.loading();
		$(".field").each(function () {
			var field = $(this).val();
			field = JSON.parse(field);
			var row = $(this).parent().parent();
			for (var k in field) {
				var content = field[k].value;
				var i = 8 + parseInt(k);
				$(row).find("td:eq(" + i + ")").html(content);
			}
		});
		u.loaded();
		$(".field").each(function () {
			var field = $(this).val();
			field = JSON.parse(field);
			var row = $(this).parent().parent();
			for (var k in field) {
				if (field[k].inputtype == 9) {
					var content = field[k].value;
					if (content.length == 0) continue;
					var v = JSON.parse(content);
					if (v.images) {
						showimages(row, k, v.images.split(";"));
					} else {
						getimages(row, k, field[k].sn, v);
					}
				}
			}
		});
		$("#maintable").colResizable({liveDrag:true,resizeMode:'overflow'});
		$("#resizecolumn").removeClass("hide");
	});
});