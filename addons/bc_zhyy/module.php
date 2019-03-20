<?php
defined('IN_IA') or exit('Access Denied');

define ( 'BC_ZHYY_ROOT', IA_ROOT.'/addons/bc_zhyy');
define ( 'BC_ZHYY_STATIC', $_W['siteroot'].'addons/bc_zhyy/static/' );

class bc_zhyyModule extends WeModule {
	
	public $tablename = 'bc_zhyy_form';
	
	public function fieldsFormDisplay($rid = 0) {
		global $_W;
		load()->func('tpl');
		if (!empty($rid)) {
			$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
			$sets = unserialize($reply['settings']);
			if (!empty($sets)){
				foreach ($sets as $key => $value){
					$reply[$key]=$value;
				}
			}
		}
		if (!$reply) {
			$now = time();
			$reply = array(
				"valid_time_start" => $now,
				"valid_time_end" => strtotime(date("Y-m-d H:i", $now + 7 * 24 * 3600)),
				"submit_times" => 1,
			);
		}
		$settings = $this->module['config'];
		$manageurl = $this->createWebUrl('index');
		include $this->template('manage/form');
	}
	
	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		global $_GPC, $_W;
		$id = intval($_GPC['reply_id']);	
		$insert = array(
			'rid' => $rid,
			'uniacid' => $_W['uniacid'],
			'form_theme' => $_GPC['form_theme'],
			'keyword' => $_GPC['keywordinput'],
			'form_pic' => $_GPC['form_pic'],
			'marketprice' => $_GPC['marketprice'],
			'costprice' => $_GPC['costprice'],
			'feature' => $_GPC['feature'],
			'details' => htmlspecialchars_decode($_GPC['details']),
			'remark' => htmlspecialchars_decode($_GPC['remark']),
			'valid_time_start' => strtotime($_GPC['datelimit']['start']),
			'valid_time_end' => strtotime($_GPC['datelimit']['end']),
			'phone' => $_GPC['phone'],
			'error_prompt' => $_GPC['error_prompt'],
			'success_prompt' => $_GPC['success_prompt'],
			'submit_times' => intval($_GPC['submit_times']),
			'fields' => $_GPC['forms']
		);
		$settingfields = array("setting_consumer_phone","setting_consumer_message","setting_notice_phone","setting_notice_message","sharemsg0","sharemsg1",
		"mine_pic","showprice","showfeature","setting_consumer_wechat_tmplid","setting_consumer_wechat_tmplkey","setting_consumer_wechat_title","setting_consumer_wechat_remark","needwriteoff");//增加是否核销的配置项studyarmy 2017.02.16
		$settings = array();
		foreach($settingfields as $st){
			$settings[$st]=$_GPC[$st];
		}
		$insert['settings'] = serialize($settings);		
		if (empty($id)) {
			$id = pdo_insert($this->tablename, $insert);
		} else {
			pdo_update($this->tablename, $insert, array('id' => $id));
		}
		return true;		
	}

	public function ruleDeleted($rid) {
		global $_W;
		pdo_delete('bc_zhyy_form', array('rid' => $rid,'uniacid'=>$_W['uniacid']));
		pdo_delete('bc_zhyy_fans', array('rid' => $rid,'uniacid'=>$_W['uniacid']));
		pdo_delete('bc_zhyy_order', array('rid' => $rid,'uniacid'=>$_W['uniacid']));
	}	
	
	private function savesetting(){
		global $_GPC, $_W;
		$cfg = array(
			'showwords1' => intval($_GPC['showwords1']),
			'showwords2' => intval($_GPC['showwords2']),
			'showfeature' => intval($_GPC['showfeature']),
			'showprice' => intval($_GPC['showprice']),
			'showminepic' => intval($_GPC['showminepic']),
			'sendsmsnotice' => intval($_GPC['sendsmsnotice']),
			'userid' => $_GPC['userid'],
			'username' => $_GPC['username'],
			'password' => $_GPC['password'],
			'sign' => $_GPC['sign'],			
		);
		if ($this->saveSettings($cfg)) {
			load()->model('cache');
			cache_build_setting();
			message('参数设置成功！', 'refresh');
		}
		message('参数设置成功！', 'refresh');		
	}
	
	public function settingsDisplay($settings) {
		global $_GPC, $_W;
		if (checksubmit()) {
			$this->savesetting();
		}
		$title = '参数设置';
		include $this->template('system/setting');
	}	
}
	
?>