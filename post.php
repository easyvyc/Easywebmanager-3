<?php
/*
 * Created on 2009.01.24
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



error_reporting(0);
ob_start();
session_start();
header("Content-Type: text/html; charset=utf-8");

// Set variable to user side
$user_side = true;

// Config
include("inc/config.inc.php");
$TIME_START = getmicrotime();

// Cache object
$cache_obj = & new cache(CACHEDIR."data/");

// Debug mode
if(isset($_GET['debug']) && $_GET['debug']==1){
	$_SESSION['debug']['enabled'] = 1;
}

$lng = $_SESSION['site_lng'];

include_once(CLASSDIR_."object.class.php");
$main_object = new object();


$phrases = $main_object->call("phrases", "loadPhrases");

$forms_obj = $main_object->create("forms");
$form_data = $forms_obj->loadItem($_GET['formid']);

if(!empty($_POST)){
	
	$req_arr = explode("::", $form_data['required_fields']);
	
	echo "<script type=\"text/javascript\">top.enableForm('{$form_data['title']}');</script>";
	
	$error = false;
	foreach($req_arr as $val){
		if($val=='') continue;
		if(!$_POST[$val] || $_POST[$val]==''){
			$error = true;
			echo "<script type=\"text/javascript\">top.document.forms['{$form_data['title']}'].elements['$val'].className=top.document.forms['{$form_data['title']}'].elements['$val'].className+' err';</script>";
		}
	}
	if(in_array('captcha', $req_arr)){
		if(strtolower($_SESSION['securimage_code_value']) != strtolower($_POST['captcha'])){
			$error = true;
			echo "<script type=\"text/javascript\">if(top.document.getElementById('_FORM_captcha')) { top.document.getElementById('_FORM_captcha').className+=' err'; }else{ top.document.forms['{$form_data['title']}'].elements['captcha'].className=top.document.forms['{$form_data['title']}'].elements['captcha'].className+' err'; } </script>";
		}		
	}	
	if($error) exit;
	
	if($form_data['selType']=='mail'){

		include_once(CLASSDIR_."phpmailer.class.php");
		
		$emails = preg_split("/[;,\s]/", $form_data['targetEmailEmails']);
		foreach($emails as $email){		
			if(!valid_email($email)){
				$mailer = new PHPMailer();
		
				$mailer->CharSet = "UTF-8";
		
				$message = date('Y-m-d H:i')."\r\n";
				$mailer->ContentType = "text/plain";
				foreach($data['post'] as $key=>$val){
					if($key!='action' && $key!='submit') $message .= "$key: $val\r\n";
				}
				foreach($_FILES as $key=>$val){
					$mailer->AddAttachment($val['tmp_name'], $val['name']);
				}
		
				$body = ereg_replace("<br />", "", $form_data['targetEmailTemplate']);
		
				$message = "";
				$targetEmailSubject = $form_data['targetEmailSubject'];
				$targetEmailFromemail = $form_data['targetEmailFromemail'];
				$targetEmailFromname = $form_data['targetEmailFromname'];
				foreach($_POST as $key=>$val){
					$body = str_replace("{".$key."}", $val, $body);
					$targetEmailFromemail = str_replace("{".$key."}", $val, $targetEmailFromemail);
					$targetEmailFromname = str_replace("{".$key."}", $val, $targetEmailFromname);
					$targetEmailSubject = str_replace("{".$key."}", $val, $targetEmailSubject);
					$message .= "$key: $val\r\n";
				}
		
				$mailer->Subject = $targetEmailSubject;
				$body = str_replace("{content}", $message, $body);
		
				$mailer->Body = $body;

				$mailer->AddAddress($email);

				$mailer->From = $targetEmailFromemail;
				$mailer->FromName = $targetEmailFromname;
				$mailer->Send();			
			       
			}
		}
		
		$response_text = $phrases['form_send_success'];

		
	}
	
	if($form_data['selType']=='database'){
		$data = $_POST;
		$data['isNew'] = 1;
		$data['parent_id'] = 0;
		$data['id'] = 0;
		$data['language'] = $lng;
		foreach($data as $key=>$val){
			if(!is_array($val)){
				$data[$key] = $database->escape($val);
			}
		}
		$main_object->call($form_data['targetDatabaseModule'], "saveItem", array($data));
		$response_text = $phrases['form_saved_success'];
	}

	if($form_data['selType']=='custom'){
		$response_text = $main_object->call($form_data['targetCustomModule'], $form_data['targetCustomMethod'], array($_POST));
	}
	
	$register_conversion = true;
	
	echo "<script type=\"text/javascript\"> top.document.getElementById('{$form_data['title']}').innerHTML='$response_text'; </script>";

}

if(!isset($_SESSION['admin']['id'])) include("inc/visitor.inc.php");

exit;
ob_flush();

?>
