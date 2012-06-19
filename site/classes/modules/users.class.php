<?php


require_once(CLASSDIR_.'catalog.class.php');
class users extends catalog {
	
	var $denied_fields = array('group_id', 'payment', 'active', 'confirm_code');

    function users() {
	
    	catalog::catalog("users");	    

		$this->userData = $_SESSION['user'];
	    
    }
    
	function loginUser($data){
		
		$data['email'] = addcslashes($data['email'], "'");
		$data['password'] = addcslashes($data['password'], "'");
		
		//$param['where'] = " T.userlogin='{$data['loginname']}' AND T.userpass='{$data['password']}' AND T.active=1 AND ";
		$this->sqlQueryWhere = " T.email='{$data['email']}' AND T.userpass='{$data['password']}' AND T.active=1 AND ";
		$arr = $this->listSearchItems();

		return $arr[0];
		
	}

	function loadRegisterForm(){
	
		global $lng, $reserved_url_words, $record, $phrases;

		$record = $this->main_object->create("users");
		
		include_once(CLASSDIR_."formaction.class.php");
		$formaction_obj = & new formaction();
		
		$action_data['title'] = "Registracija";
		$action_data['emails'] = "";
		$action_data['target'] = "database";
		$action_data['module'] = $this->module_info['table_name'];
		$action_data['name'] = "register";
		$action_data['action'] = "javascript: void(post('{$configFile->variable['site_url']}ajax.php?content=register&lng={$_GET['lng']}&target={$_GET['target']}', '{$_GET['target']}', document.forms['register']));";
		$action_data['redirect'] = "ajax.php?content=register&lng={$_GET['lng']}&target={$_GET['target']}&thanks=1";
		$action_data['isNew'] = 1;
		$action_data['is_category'] = 0;
		$action_data['id'] = 0;
		$action_data['parent_id'] = 0;
		$action_data['language'] = $lng;
		$action_data['author_id'] = 0;
		
		$formaction_obj->setAction($action_data);
		$formaction_obj->setFields($this->table_fields);
		$formaction_obj->form->editField('active', array('elm_type'=>FRM_HIDDEN, 'value'=>1));
		$formaction_obj->form->editField('confirm_code', array('elm_type'=>FRM_HIDDEN, 'value'=>generatePassword(20)));
		$formaction_obj->form->editField('userpass', array('elm_type'=>FRM_PASSWORD, 'required'=>1));
		
		//$formaction_obj->form->editField($this->_table_fields['comments']['list_values']['get_category'], array('value'=>$id));
		//$formaction_obj->form->editField($this->_table_fields['comments']['list_values']['get_column_name'], array('value'=>'comments'));
		
		$formaction_obj->form->editField('submit', array('captcha'=>0));
		
		$formaction_obj->form->editField('is_company', array('elm_type'=>FRM_CHECKBOX));
		
		$formaction_obj->form->editField('is_company', array('field_extra_params'=>"onclick=\"javascript: if(this.checked) $('#id_company_name,#id_company_code,#id_company_address,#id_company_pvm').show(500); else $('#id_company_name,#id_company_code,#id_company_address,#id_company_pvm').hide(500); \""));
		if($_POST['is_company']!=1){
			$formaction_obj->form->editField('company_name', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_code', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_address', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_pvm', array('extra_block_style'=>"display:none;"));
			if(isset($_POST['action'])){
				$_POST['company_name'] = strlen($_POST['company_name'])&&$_POST['company_name']!=$formaction_obj->form->elements['company_name']['title']?$_POST['company_name']:"&nbsp;";
				$_POST['company_code'] = strlen($_POST['company_code'])&&$_POST['company_code']!=$formaction_obj->form->elements['company_code']['title']?$_POST['company_code']:"&nbsp;";
				$_POST['company_address'] = strlen($_POST['company_address'])&&$_POST['company_address']!=$formaction_obj->form->elements['company_address']['title']?$_POST['company_address']:"&nbsp;";
				$_POST['company_pvm'] = strlen($_POST['company_pvm'])&&$_POST['company_pvm']!=$formaction_obj->form->elements['company_pvm']['title']?$_POST['company_pvm']:"&nbsp;";
			}
		}		
		
		unset($formaction_obj->form->elements['group_id']);
		unset($formaction_obj->form->elements['payment']);
		
		$_POST['active'] = 1;
		$_POST['id'] = 0;
		$_POST['confirm_code'] = generatePassword(20);
		//pae($_POST);
		$formaction_obj->setData($_POST);
		
		return $formaction_obj->process();		
		
	}

	function loadEditUser(){
	
		global $lng, $reserved_url_words, $record, $data, $phrases;

		$record = $this->main_object->create("users");
		
		include_once(CLASSDIR_."formaction.class.php");
		$formaction_obj = & new formaction();
		
		$action_data['title'] = "Registracija";
		$action_data['emails'] = "";
		$action_data['target'] = "database";
		$action_data['module'] = $this->module_info['table_name'];
		$action_data['name'] = "register";
		$action_data['action'] = "javascript: void(post('{$configFile->variable['site_url']}ajax.php?content=register&lng={$_GET['lng']}&target={$_GET['target']}', '{$_GET['target']}', document.forms['register']));";
		$action_data['redirect'] = "ajax.php?content=register&lng={$_GET['lng']}&target={$_GET['target']}&thanks=1";
		$action_data['isNew'] = 0;
		$action_data['is_category'] = 0;
		$action_data['id'] = $_SESSION['simple_user']['id'];
		$action_data['parent_id'] = 0;
		$action_data['language'] = $lng;
		
		foreach($this->table_fields as $i=>$val){
			$this->table_fields[$i]['value'] = ($val['elm_type']!=FRM_SELECT?$_SESSION['simple_user'][$val['column_name']]:$_SESSION['simple_user'][$val['column_name']."_ids"]);
			if(!in_array($val['column_name'], $this->denied_fields)) $tbl_fields[] = $this->table_fields[$i];
		}
		
		$formaction_obj->setAction($action_data);
		$formaction_obj->setFields($tbl_fields);
		$formaction_obj->form->editField('userpass', array('elm_type'=>FRM_PASSWORD, 'required_field'=>0));
		
		$formaction_obj->form->editField('submit', array('captcha'=>0, 'title'=>$phrases['save_user_info_submit']));
		$formaction_obj->form->editField('active', array('elm_type'=>FRM_HIDDEN));
		
		$formaction_obj->form->editField('is_company', array('elm_type'=>FRM_CHECKBOX));
		$formaction_obj->form->editField('is_company', array('field_extra_params'=>"onclick=\"javascript: if(this.checked) $('#id_company_name,#id_company_code,#id_company_address,#id_company_pvm').show(500); else $('#id_company_name,#id_company_code,#id_company_address,#id_company_pvm').hide(500); \""));
		if($_POST['is_company']!=1){
			$formaction_obj->form->editField('company_name', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_code', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_address', array('extra_block_style'=>"display:none;"));
			$formaction_obj->form->editField('company_pvm', array('extra_block_style'=>"display:none;"));
			if(isset($_POST['action'])){
				$_POST['company_name'] = strlen($_POST['company_name'])&&$_POST['company_name']!=$formaction_obj->form->elements['company_name']['title']?$_POST['company_name']:"&nbsp;";
				$_POST['company_code'] = strlen($_POST['company_code'])&&$_POST['company_code']!=$formaction_obj->form->elements['company_code']['title']?$_POST['company_code']:"&nbsp;";
				$_POST['company_address'] = strlen($_POST['company_address'])&&$_POST['company_address']!=$formaction_obj->form->elements['company_address']['title']?$_POST['company_address']:"&nbsp;";
				$_POST['company_pvm'] = strlen($_POST['company_pvm'])&&$_POST['company_pvm']!=$formaction_obj->form->elements['company_pvm']['title']?$_POST['company_pvm']:"&nbsp;";
			}
		}			
		
		$formaction_obj->form->addField('id', array('elm_type'=>FRM_HIDDEN, 'value'=>$action_data['id']));
		
		$formaction_obj->setData($_POST);
		
		return $formaction_obj->process();		
		
	}

	function saveItem($data){

		global $phrases, $reserved_url_words;
		
		if($data['isNew']==1){
			$data['payment'] = $this->_table_fields['payment']['default_value'];
		}else{
			$old_data = $this->loadItem($data['id']);
			foreach($this->denied_fields as $val){
				$data[$val] = $old_data[$val];
			}
			if($data['userpass']==''){
				$data['userpass'] = $old_data['userpass'];
			}
		}
		
		$data['active'] = 1;
		//$data['title'] = $data['firstname']." ".$data['lastname'];
		
		$id = catalog::saveItem($data);
		
		$data['id'] = $id;
		
		$_SESSION['simple_user'] = $data;
		
		/*if($data['isNew']==1){
			
			// send mail with confirm code
			include_once(CLASSDIR_."phpmailer.class.php");
			$mailer = new PHPMailer();
		
			$mailer->CharSet = "windows-1257";
			$mailer->Subject = iconv('UTF-8', 'windows-1257', "{$phrases['user_confirm_email_subject']}");
			$mailer->ContentType = "text/plain";
			$message = "{$phrases['user_confirm_email_body']} {$this->config->variable['site_url']}$this->language/{$reserved_url_words['register']}/{$reserved_url_words['thanks']}/{$reserved_url_words['code']}/{$data['confirm_code']}/";
			$mailer->Body = iconv('UTF-8', 'windows-1257', ereg_replace("<br />", "\r\n", $message));

			//pae($data);
			$mailer->AddAddress($data['email']);
			$mailer->From = "no-reply@ekoidejos.lt";
			$mailer->FromName = $this->config->variable['pr_url'];
			$mailer->Send();
			
		}*/
		
		return $id;
		
	}
	
	function checkByEmail($email){
		$email = $this->db->escape($email);
		$this->sqlQueryWhere = " T.email='$email' AND ";
		$list = $this->listSearchItems();
		return (empty($list)?false:true);
	}
	
	function checkAndInsertNewUser($data){
		if(!$this->checkByEmail($data['email'])){
			$data['isNew'] = 1;
			$data['id'] = 0;
			$data['parent_id'] = 0;
			$data['language'] = $this->language;
			$data['userpass'] = generatePassword(7);
			$id = $this->saveItem($data);
			$this->sendRegisterEmail($data);
		}
	}
	
	function sendRegisterEmail($user_data){

		include_once(CLASSDIR_."phpmailer.class.php");
		$mailer = new PHPMailer();
	
		$mailer->CharSet = "UTF-8";
		$mailer->Subject = $this->module_info['xml_settings']['confirm_mail_subject']['value'];
		$mailer->ContentType = "text/plain";
		$message = $this->module_info['xml_settings']['confirm_mail_body']['value'];
		$message = ereg_replace("{email}", $user_data['email'], $message);
		$message = ereg_replace("{password}", $user_data['userpass'], $message);
		$mailer->Body = ereg_replace("<br />", "\r\n", $message);

		//pae($data);
		$mailer->AddAddress($user_data['email']);
		$mailer->From = $this->module_info['xml_settings']['confirm_mail_from_email']['value'];
		$mailer->FromName = $this->module_info['xml_settings']['confirm_mail_from_name']['value'];
		$mailer->Send();		

	}

	function activateUser($code){
	
		global $phrases;
		
		$code = addcslashes($code, "'");
		$sql = "UPDATE $this->table SET active=1 WHERE confirm_code='$code'";
		$this->db->exec($sql, __FILE__, __LINE__);

		if($this->db->count>0){
			return $phrases['user_activate_success'];
		}else{
			return $phrases['user_activate_fail'];
		}
		
	}
	
	
}

?>
