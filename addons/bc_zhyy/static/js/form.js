require(['jquery', 'util'], function ($, u) {
	$(document).ready(function () {
		$(document).on("click", ".editinput", function () {
			var key = $(this).attr("data");
			if (!key) {
				key = -1;
			}
			$("input[name='key']").val(key);
			key = parseInt(key);
			if (key >= 0) {
				var d = tb.get(key);
				$("input[name='inputtitle']").val(d.title);
				$("input[name='desc']").val(d.desc);
				$("input[name='inputtype']:checked").prop("checked", false);
				$("input[name='inputtype'][value='" + d.inputtype + "']").prop("checked", true);
				$("input[name='checktype']:checked").prop("checked", false);
				$("input[name='checktype'][value='" + d.checktype + "']").prop("checked", true);
				if (d.isneed == 1) {
					$("input[name='isneed']").prop("checked", true);
				} else {
					$("input[name='isneed']").prop("checked", false);
				}
				if (d.ishide == 1) {
					$("input[name='ishide']").prop("checked", true);
				} else {
					$("input[name='ishide']").prop("checked", false);
				}				
				$("input[name='sortnumber']").val(d.sortnumber);
				$("input[name='errormsg']").val(d.errormsg);
				$("textarea[name='options']").val(d.options.join(";\r"));
				if (d.inputtype == 3 || d.inputtype == 4) {
					$("#optiongroup").show();
				} else {
					$("#optiongroup").hide();
				}
			} else {
				$("input[name='inputtitle']").val("");
				$("input[name='desc']").val("");
				$("input[name='inputtype']:checked").prop("checked", false);
				$("input[name='inputtype'][value='1']").prop("checked", true);
				$("input[name='checktype']:checked").prop("checked", false);
				$("input[name='checktype'][value='0']").prop("checked", true);
				$("input[name='isneed']").prop("checked", false);
				$("input[name='ishide']").prop("checked", false);
				$("input[name='sortnumber']").val(tb.getnextsortnumber());
				$("input[name='errormsg']").val("");
				$("textarea[name='options']").val("");
				$("#optiongroup").hide();
			}
			$("#myModal").modal("show");
		});
		$(document).on("click", ".removeedit", function () {
			var key = $(this).attr("data");
			key = parseInt(key);
			if (key >= 0) {
				tb.remove(key);
				tb.refresh();
				var dts = tb.getdatas();
				var s = JSON.stringify(dts);
				$("#forms").val(s);
			}
		});
	});

	$(document).ready(function () {
		//初始化表单
		var inputs = $("#forms").val();
		if (inputs.length == 0) {
			return;
		}
		util.loading();
		inputs = eval("(" + inputs + ")");
		tb.init(inputs);
		tb.refresh();
		util.loaded();
	});

	$("#saveinput").click(function () {
		var key = $("input[name='key']").val();
		var title = $("input[name='inputtitle']").val();
		var desc = $("input[name='desc']").val();
		var inputtype = $("input[name='inputtype']:checked").val();
		var checktype = $("input[name='checktype']:checked").val();
		var isneed = $("input[name='isneed']").prop('checked') ? 1 : 0;
		var ishide = $("input[name='ishide']").prop('checked') ? 1 : 0;
		var sortnumber = $("input[name='sortnumber']").val();
		var errormsg = $("input[name='errormsg']").val();
		var t = $("textarea[name='options']").val();
		t = t.replace(/\r/g, "");
		t = t.replace(/\n/g, "");
		t = t.replace(/；/g, ";");
		var options = t.split(";");
		for (var k in options) {
			if (options[k].length == 0) {
				options.splice(k, 1);
			}
		}
		var d = {
			title : title,
			desc : desc,
			inputtype : parseInt(inputtype),
			checktype : parseInt(checktype),
			isneed : parseInt(isneed),
			ishide : parseInt(ishide),
			sortnumber : parseInt(sortnumber),
			errormsg : errormsg,
			options : options
		};
		var r = tb.checkdata(d);
		if (r.length > 0) {
			alert(r);
			return;
		}
		if (key < 0) {
			tb.append(d);
		} else {
			tb.update(key, d);
		}
		tb.refresh();
		var dts = tb.getdatas();
		var s = JSON.stringify(dts);
		$("#forms").val(s);
		$("#myModal").modal("hide");
	});

	$("input[name='inputtype']").click(function () {
		var inputtype = $("input[name='inputtype']:checked").val();
		if (inputtype == 3 || inputtype == 4) {
			$("#optiongroup").show();
		} else {
			$("#optiongroup").hide();
		}
	});
});