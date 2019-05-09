var tb = (function () {
	var inputtype = new Array("", "单行文本", "多行文本", "单项选择","多项选择","日期","时间","富文本","车牌","图片","省市区(县)");
	var checktype = new Array("", "电话", "身份证号码");
	var yesno = new Array("否", "是");
	var datas = new Array();
	var els = new Array();
	var getdatas = function () {
		return datas;
	};
	var setsn = function(){
		for (var d in datas){
			if (!datas[d].sn){
				var t = new Date().getTime();
				t = t.toString();
				var r = Math.floor(Math.random () * 900) + 100;
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
	var input = function (t, l) {
		var s = "";
		var t = parseInt(t);
		switch (t) {
		case 1:
			s = "<input type='text'>";
			break;
		case 2:
			s = "<textarea></textarea>";
			break;
		case 3:
			s = "<select>";
			for (var k in l) {
				s = s + "<option value =" + l[k] + ">" + l[k] + "</option>"
			}
			s = s + "</select>";
			break;
		case 4:
			for (var k in l){
				s = s + "<label><input type='checkbox' name='checkbox'>" + l[k] + "</label>";
			}
			break;
		case 5:
			s = "<input type='text'>";
			break;	
		case 6:
			s = "<input type='text'>";
			break;
		case 7:
			s = "<textarea></textarea>";
			break;	
		case 8:
			s = "<select><option value ='1'>京</option><option value ='2'>津</option><option value ='3'>沪</option></select><input type='text'>";
			break;	
		case 9:
			s = "<input type='file'>";
			break;	
		case 10:
			s = "<input class='weui_input mui-district-picker-address' placeholder='请选择地区' type='text' readonly value=''/>";
			break;
		default:
			s = "";
		}
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
			s = s + "<td>" + input(datas[d].inputtype, datas[d].options) + "</td>";
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
	};
	var update = function (i, d) {
		datas[i] = d;
		setsn();
	};
	var remove = function (i) {
		datas.splice(i, 1);
	};
	var getinput = function (i) {
		return datas[i];
	};
	var initdata = function (oridata) {
		datas = datas.concat(oridata);
		setsn();
	};
	var initforwebedit = function(){
		var s = "";
		return s;
	};
	var webinput = function (t, l){
		var s = "";
		return s;
	};
	var initformobileedit = function(){
		var s = "";
		return s;
	};
	var mobileedit = function(){
		var s = "";
		return s;		
	};
	return {
		get : getinput,
		update : update,
		append : append,
		remove : remove,
		refresh : refresh,
		init : initdata,
		getnextsortnumber : getnextsortnumber,
		checkdata : checkdata,
		webedit : initforwebedit,
		getdatas : getdatas
	}
})();


