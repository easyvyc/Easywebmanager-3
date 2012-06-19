<?php
/*
 * Created on 2009.07.07
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once("install/lib/forms.class.php");
include_once("install/lib/config.class.php");
include_once($CONFIGFILE);

$config_obj = new config($CONFIGFILE);

$form_obj = new forms(array('name'=>'db', 'method'=>'POST', 'action'=>''));

$wrong_fields = array('action', 'submit');


$form_obj->add("action", array('title'=>'', 'type'=>"hidden", "value"=>'db'));
$form_obj->add("hostname", array('title'=>$lang['db']['hostname'], 'type'=>"text", "required"=>1, "value"=>$variable['hostname']));
$form_obj->add("username", array('title'=>$lang['db']['username'], 'type'=>"text", "required"=>1, "value"=>$variable['username']));
$form_obj->add("password", array('title'=>$lang['db']['password'], 'type'=>"text", "required"=>1, "value"=>$variable['password']));
$form_obj->add("database", array('title'=>$lang['db']['database'], 'type'=>"text", "required"=>1, "value"=>$variable['database']));
$form_obj->add("dump", array('title'=>$lang['db']['dump'], 'type'=>"file", "required"=>0));

$form_obj->add("submit", array('title'=>'', "type"=>"button", "value"=>$lang['common']['next_step'], 'onclick'=>"javascript: this.form.submit();"));

if(isset($_POST['action']) && $_POST['action']=='db'){
	$form_obj->validate($_POST);
	/*$license_response = valid_license($_POST);
	if($license_response['error']==1){
		$form_obj->error = 1;
		$form_obj->fields['pr_url']['error'] = $license_response['error_domain'];
		$form_obj->fields['license']['error'] = $license_response['error_license'];
		$form_obj->fields['key']['error'] = $license_response['error_key'];
	}*/
	if($form_obj->error!=1){
		foreach($_POST as $key=>$val){
			if(!in_array($key, $wrong_fields)){
				$variable[$key] = htmlspecialchars($val);
			}
		}
		$config_obj->create($variable);
		redirect("install.php?step=ftp");
	}
}

echo $form_obj->create();

?>