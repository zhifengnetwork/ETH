require(['jquery', 'util'], function ($, u) {
	function object(o) {
		function F() {}
		F.prototype = o;
		return new F();
	}
	var Element = function (d) {
		var title = d.title;
		var desc = d.desc;
		var inputtype = d.inputtype;
		var checktype = d.checktype;
		var isneed = d.isneed;
		var ishide = d.ishide;
		var sortnumber = d.sortnumber;
		var errormsg = d.errormsg;
		var options = d.options;
		var value = d.value;
		var sn = d.sn;
		var webstart = '<div class="form-group">';
		var weblabel = function () {
			var s = '<label class="col-xs-12 col-sm-3 col-md-2 control-label">';
			if (this.isneed == 1) {
				s = s + '<span style="color:red">*</span>';
			}
			s = s + title;
			s = s + '</label>';
			return s;
		};
		var inputhead = '<div class="col-sm-9 col-xs-10">';
		var inputend = '</div>';
		var webinput = function () {
			var s = '';
			//to be overload
			s = '<input name="fields' + sn + '" ' + 'class="form-control" type="text" ';
			if (isneed == 1) {
				s = s + ' required ';
			}
			if (value) {
				s = s + ' value="' + value + '"';
			}
			s = s + '>';
			return s;
		};
		var webend = '</div>';
		var webedit = function () {
			return webstart + weblabel() + inputhead + webinput() + inputend + webend;
		};
		var mobileedit = function () {
			return "";
		};
		var getwebvalue = function (div) {
			var n = 'fields' + sn;
			var v = $(div).find("[name='" + n + "']").val();
			return v;
		};
		return {
			title : title,
			desc : desc,
			inputtype : inputtype,
			checktype : checktype,
			isneed : isneed,
			ishide : ishide,
			sortnumber : sortnumber,
			errormsg : errormsg,
			options : options,
			value : value,
			sn : sn,
			webstart : webstart,
			weblabel : weblabel,
			inputhead : inputhead,
			inputend : inputend,
			webinput : webinput,
			webend : webend,
			webedit : webedit,
			toeditinweb : webedit,
			getwebvalue : getwebvalue,
			toeditinwechat : mobileedit
		};
	};

	var SingleEdit = function (d) {
		var e = Element(d);
		var F = object(e);
		F.webinput = function () {
			var s = '';
			s = '<input name="fields' + F.sn + '" ' + 'class="form-control" type="text" ';
			if (F.isneed == 1) {
				s = s + ' required ';
			}
			if (F.value) {
				s = s + ' value="' + F.value + '"';
			}
			s = s + '>';
			return s;
		};
		F.toeditinweb = F.webedit = function () {
			return F.webstart + F.weblabel() + F.inputhead + F.webinput() + F.inputend + F.webend;
		};
		return F;
	};

	var MultiEdit = function (d) {
		var e = Element(d);
		var F = object(e);
		F.webinput = function () {
			var s = '';
			s = '<textarea name="fields' + F.sn + '" ' + 'class="form-control" type="text" ';
			if (this.isneed == 1) {
				s = s + ' required ';
			}
			s = s + '>';
			if (this.value) {
				s = s + F.value;
			}
			s = s + '</textarea>';
			return s;
		};
		F.toeditinweb = F.webedit = function () {
			return F.webstart + F.weblabel() + F.inputhead + F.webinput() + F.inputend + F.webend;
		};
		return F;
	};

	var SelectEdit = function (d) {
		var e = Element(d);
		var F = object(e);
		F.webinput = function () {
			var s = '';
			s = "<select name='fields" + F.sn + "' class='form-control'>";
			for (var k in F.options) {
				s = s + "<option value =" + F.options[k];
				if (F.options[k] == F.value) {
					s = s + " selected "
				}
				s = s + ">" + F.options[k] + "</option>"
			}
			s = s + "</select>";
			return s;
		};
		F.toeditinweb = F.webedit = function () {
			return F.webstart + F.weblabel() + F.inputhead + F.webinput() + F.inputend + F.webend;
		};
		return F;
	};

	var CheckboxEdit = function (d) {
		var e = Element(d);
		var F = object(e);
		F.webinput = function () {
			var s = '';
			for (var k in F.options) {
				var t = "";
				if (F.value.indexOf(F.options[k]) > -1) {
					t = " checked ";
				}
				s = s + "<label class='checkbox-inline'><input value='" + F.options[k] + "' type='checkbox' name='fields" + F.sn + "'" + t + ">" + F.options[k] + "</label>";
			}
			return s;
		};
		F.toeditinweb = F.webedit = function () {
			return F.webstart + F.weblabel() + F.inputhead + F.webinput() + F.inputend + F.webend;
		};
		F.getwebvalue = function (div) {
			var n = 'fields' + F.sn;
			var chk_value = [];
			$(div).find('input[name="' + n + '"]:checked').each(function () {
				chk_value.push($(this).val());
			});
			var v = chk_value.join(",");
			return v;
		};
		return F;
	};

	var DateEdit = function (d) {
		var e = Element(d);
		var F = object(e);
		F.webinput = function () {
			var s = '';
			s = '<input name="fields' + F.sn + '" ' + ' type="text" readonly class="datetimepicker form-control bcxdate"';
			if (F.isneed == 1) {
				s = s + ' required ';
			}
			if (F.value) {
				s = s + ' value="' + F.value + '"';
			}
			s = s + '>';
			return s;
		};
		F.toeditinweb = F.webedit = function () {
			return F.webstart + F.weblabel() + F.inputhead + F.webinput() + F.inputend + F.webend;
		};
		return F;
	};

	var TimeEdit = function (d) {
		var e = Element(d);
		var F = object(e);
		F.webinput = function () {
			var s = '';
			s = '<input name="fields' + F.sn + '" ' + ' type="text" readonly class="datetimepicker form-control bcxtime"';
			if (F.isneed == 1) {
				s = s + ' required ';
			}
			if (F.value) {
				s = s + ' value="' + F.value + '"';
			}
			s = s + '>';
			return s;
		};
		F.toeditinweb = F.webedit = function () {
			return F.webstart + F.weblabel() + F.inputhead + F.webinput() + F.inputend + F.webend;
		};
		return F;
	};

	var RichTextEdit = function (d) {
		var e = Element(d);
		var F = object(e);

		return F;
	};

	var CarNumberEdit = function (d) {
		var e = Element(d);
		var F = object(e);

		return F;
	};

	var ImageuploadEdit = function (d) {
		var e = Element(d);
		var F = object(e);
		F.webinput = function () {
			var field = 'fields' + F.sn;
			var s = '';
			s = '	<div class="input-group">\
								<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传图片" autocomplete="off">\
								<span class="input-group-btn">\
									<button class="btn btn-default" type="button" onclick="uploadMultiImage(this);">选择图片</button>\
									<input type="hidden" value="' + field + '" /></span>\
							</div>';
			s = s + ' <div class="input-group multi-img-details"> ';
			var imgs;
			var data = F.value;
			if (data)
				data = $.parseJSON(data);
			if (data.images)
				imgs = data.images.split(";");
			for (var i in imgs) {
				s = s + '\
					    <div class="multi-item">\
					        <img src="' + util.tomedia(imgs[i]) + '" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">\
					        <input type="hidden" name="' + field + '[]" value="' + imgs[i] + '">\
					        <em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>'
			}
			s = s + '</div>';
			return s;
		};
		F.toeditinweb = F.webedit = function () {
			return F.webstart + F.weblabel() + F.inputhead + F.webinput() + F.inputend + F.webend;
		};
		F.getwebvalue = function (div) {
			var field = 'fields' + F.sn;
			var imgs = "";
			$(div).find("[name='" + field + "[]']").each(function () {
				imgs = imgs + $(this).val() + ";";
			});
			var t = F.value;
			if (t) {
				t = JSON.parse(t);
				t.images = imgs;
			} else {
				if (imgs.length > 0)
					t = {
						images : imgs
					};
			}
			return JSON.stringify(t);
		};
		return F;
	};

	var DistrictEdit = function (d) {
		var e = Element(d);
		var F = object(e);
		F.webinput = function () {
			var arr = F.value.split(' ');
			var province = '';
			var city = '';
			var district = '';
			if (arr[0])
				province = arr[0];
			if (arr[1])
				city = arr[1];
			if (arr[2])
				district = arr[2];
			var s = '';
			var field = 'fields' + F.sn;
			s = '\
						<div class="row row-fix tpl-district-container">\
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">\
								<select name="' + field + '[province]" data-value="' + province + '" class="form-control tpl-province"></select>\
							</div>\
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">\
								<select name="' + field + '[city]" data-value="' + city + '" class="form-control tpl-city"></select>\
							</div>\
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">\
								<select name="' + field + '[district]" data-value="' + district + '" class="form-control tpl-district"></select>\
							</div>\
						</div>';
			return s;
		};
		F.toeditinweb = F.webedit = function () {
			return F.webstart + F.weblabel() + F.inputhead + F.webinput() + F.inputend + F.webend;
		};
		F.getwebvalue = function (div) {
			var n = 'fields' + F.sn;
			var p = $(div).find("[name='" + n + "[province]']").val();
			var c = $(div).find("[name='" + n + "[city]']").val();
			var d = $(div).find("[name='" + n + "[district]']").val();
			var v = p + " " + c + " " + d;
			return v;
		};
		return F;
	};

	var EditFactory = function (data) {
		var edits = new Array("", SingleEdit, MultiEdit, SelectEdit, CheckboxEdit, DateEdit, TimeEdit, RichTextEdit, CarNumberEdit, ImageuploadEdit, DistrictEdit);
		var el = new edits[data.inputtype](data);
		return el;
	};

	tb = (function () {
		var inputtype = new Array("", "单行文本", "多行文本", "单项选择", "多项选择", "日期", "时间", "富文本", "车牌", "图片", "省市区(县)");
		var checktype = new Array("", "电话", "身份证号码");
		var yesno = new Array("否", "是");
		var datas = new Array();
		var els = new Array();
		var getdatas = function () {
			return datas;
		};
		var setsn = function () {
			for (var d in datas) {
				if (!datas[d].sn) {
					var t = new Date().getTime();
					t = t.toString();
					var r = Math.floor(Math.random() * 900) + 100;
					r = r.toString();
					datas[d].sn = t + r;
				}
			}
		};
		var getnextsortnumber = function () {
			var i = 1;
			for (var d in datas) {
				if (datas[d].sortnumber >= i) {
					i = datas[d].sortnumber + 1;
				}
			}
			return i;
		};
		var checkdata = function (d) {
			if (d.title.length == 0) {
				return "名称必须填写";
			}
			if (d.inputtype == 3) {
				if (d.options.length == 0) {
					return "选择项必须填写";
				}
			}
			return "";
		};
		var input = function (i) {
			var s = "";
			return s;
		};
		var refresh = function (el) {
			var el = arguments[0] ? arguments[0] : "#bctbody";
			var s = "";
			datas.sort(function (a, b) {
				return a.sortnumber - b.sortnumber
			});
			var d;
			for (d in datas) {
				s = s + "<tr>";
				s = s + "<td>" + datas[d].title + "</td>";
				s = s + "<td>" + datas[d].desc + "</td>";
				s = s + "<td>" + inputtype[datas[d].inputtype] + "</td>";
				s = s + "<td>" + checktype[datas[d].checktype] + "</td>";
				s = s + "<td>" + input(d) + "</td>";
				s = s + "<td>" + yesno[datas[d].isneed] + "</td>";
				s = s + "<td>" + yesno[datas[d].ishide] + "</td>";
				s = s + "<td>" + datas[d].sortnumber + "</td>";
				s = s + "<td>" + datas[d].errormsg + "</td>";
				s = s + "<td>" + "<a href='javascript:;' class='editinput' data='" + d + "'>"
					 + "<span class='glyphicon glyphicon-pencil'></span></a>"
					 + "&nbsp;"
					 + "<a href='javascript:;' class='removeedit' data='" + d + "'><span class='glyphicon glyphicon-trash'></span></a>"
					 + "</td>";
				s = s + "</tr>";
			}
			$(el).html(s);
		};
		var append = function (d) {
			datas.push(d);
			setsn();
			var el = EditFactory(d);
			els.push(el);
		};
		var update = function (i, d) {
			datas[i] = d;
			setsn();
			var el = EditFactory(d);
			els[i] = el;
		};
		var remove = function (i) {
			datas.splice(i, 1);
			els.splice(i, 1);
		};
		var clear = function () {
			datas.splice(0, datas.length);
			els.splice(0, els.length);
		};
		var getinput = function (i) {
			return datas[i];
		};
		var initdata = function (oridata) {
			datas = datas.concat(oridata);
			setsn();
			els.splice(0, els.length);
			for (var i in datas) {
				var el = EditFactory(datas[i]);
				els.push(el);
			}
		};
		var initforwebedit = function () {
			var s = "";
			for (var i in els) {
				s = s + els[i].toeditinweb();
			}
			var t = JSON.stringify(datas);
			t = '<input type="hidden" id="inputs" name="inputs" value=\'' + t + '\'>';
			return t + s;
		};
		var initwebedits = function () {
			require(["datetimepicker"], function () {
				$(function () {
					var option = {
						lang : "zh",
						step : 1,
						timepicker : false,
						closeOnDateSelect : true,
						format : "Y-m-d"
					};
					$(".datetimepicker.bcxdate").datetimepicker(option);
				});
			});
			require(["datetimepicker"], function () {
				$(function () {
					var option = {
						lang : "zh",
						step : 1,
						timepicker : true,
						closeOnDateSelect : true,
						format : "Y-m-d H:i"
					};
					$(".datetimepicker.bcxtime").datetimepicker(option);
				});
			});
			require(["jquery", "district"], function ($, dis) {
				$(".tpl-district-container").each(function () {
					var elms = {};
					elms.province = $(this).find(".tpl-province")[0];
					elms.city = $(this).find(".tpl-city")[0];
					elms.district = $(this).find(".tpl-district")[0];
					var vals = {};
					vals.province = $(elms.province).attr("data-value");
					vals.city = $(elms.city).attr("data-value");
					vals.district = $(elms.district).attr("data-value");
					dis.render(elms, vals, {
						withTitle : true
					});
				});
			});
		};
		var getwebvalue = function (div) {
			var v;
			for (var i in els) {
				v = els[i].getwebvalue(div);
				datas[i].value = v;
			}
			$(div).find("#inputs").val(JSON.stringify(datas));
		};
		var initformobileedit = function () {
			var s = "";
			return s;
		};
		return {
			get : getinput,
			update : update,
			append : append,
			remove : remove,
			clear : clear,
			refresh : refresh,
			init : initdata,
			getnextsortnumber : getnextsortnumber,
			checkdata : checkdata,
			webedit : initforwebedit,
			initwebedits : initwebedits,
			getwebvalue : getwebvalue,
			getdatas : getdatas
		}
	})();
});

//image uploader
function uploadMultiImage(elm) {
	var name = $(elm).next().val();
	util.image("", function (urls) {
		$.each(urls, function (idx, url) {
			$(elm).parent().parent().next().append('<div class="multi-item"><img onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" src="' + url.url + '" class="img-responsive img-thumbnail"><input type="hidden" name="' + name + '[]" value="' + url.attachment + '"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>');
		});
	}, {
		"multiple" : true,
		"direct" : false
	});
}
function deleteMultiImage(elm) {
	require(["jquery"], function ($) {
		$(elm).parent().remove();
	});
}
