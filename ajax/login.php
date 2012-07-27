<?php
/*
 * Created on 2009.05.15
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once(CLASSDIR_."easytpl.class.php");
$users_tpl = & new easytpl(TPLDIR_."blocks/partners_block.tpl", "templateVariables");

if(isset($_POST['action']) && $_POST['action']=='login'){
	
	$user_data = $main_object->call("users", "loginUser", array($_POST));
	
	//$user_data = $user_obj->loginUser($_POST);
	
	if(!empty($user_data)){
		$_SESSION['simple_user'] = $user_data;
		$main_object->call("users", "registerLogin", array($user_data['id']));
	}else{
		$users_tpl->setVar('bad_login', 1);
	}
}
if(isset($_GET['logout']) && $_GET['logout']==1){
	unset($_SESSION['simple_user']);
	redirect($lng."/");
}
$users_tpl->setVar('loged_user', $_SESSION['simple_user']);


if(isset($_POST['action']) && $_POST['action']=='forget'){
	
	$users_obj = $main_object->create("users");

	$email = trim(addcslashes($_POST['email'], "'"));
	$users_obj->sqlQueryWhere = " T.email='$email' AND ";
	$list = $users_obj->listSearchItems();

	$user_info = $list[0];
	if(is_numeric($user_info['id'])){

		include_once(CLASSDIR_."phpmailer.class.php");
		$mailer = new PHPMailer();
	
		$mailer->CharSet = "UTF-8";
		$mailer->Subject = $phrases['remind_password_subject'];
		$message = date('Y-m-d')."\r\n";
		$mailer->ContentType = "text/plain";
		
		$message = ereg_replace("<br />", "\r\n", $phrases['remind_password_body']);
		$message = ereg_replace("{password}", $user_info['userpass'], $message);
		
		$mailer->Body = $message;
		$mailer->AddAddress($user_info['email']);
		$mailer->From = $this->module_info['xml_settings']['confirm_mail_from_email']['value'];
		$mailer->FromName = $this->module_info['xml_settings']['confirm_mail_from_name']['value'];
		if($mailer->Send()){
			$users_tpl->setVar('remind_ok', 1);
		}

		
	}else{
		$users_tpl->setVar('bad_email', 1);
	}
	
}

if(!isset($_GET['target'])) $_GET['target'] = 'login_form';

$users_tpl->setVar('target_'.$_GET['target'], 1);

$users_tpl->setVar('reserved_url_words', $reserved_url_words);
$users_tpl->setVar('phrases', $phrases);
$users_tpl->setVar('lng', $lng);
$users_tpl->setVar('get', $_GET);
$users_tpl->setVar('config', $configFile->variable);

include $users_tpl->parse();

?>