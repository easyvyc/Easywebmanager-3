<?php
/*
 * Created on 2009.07.07
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
//error_reporting(E_ALL);



include_once("install/lib/forms.class.php");
include_once("install/lib/config.class.php");
include_once($CONFIGFILE);

$config_obj = new config($CONFIGFILE);

$form_obj = new forms(array('name'=>'config', 'method'=>'POST', 'action'=>''));

$wrong_fields = array('action', 'submit');


if(strlen($variable['pr_url'])==0){
	$variable['pr_url'] = $_SERVER['HTTP_HOST'];
}
$variable['project_dir'] = "";
if(strlen($variable['project_dir'])==0){
	$variable['project_dir'] = ereg_replace("install.php", "", $_SERVER['SCRIPT_NAME']);
}

$form_obj->add("action", array('title'=>'', 'type'=>"hidden", "value"=>'config'));
//$form_obj->add("pr_name", array('title'=>$lang['config']['pr_name'], 'type'=>"text", "required"=>1, "value"=>$variable['pr_name']));
$form_obj->add("pr_url", array('title'=>$lang['config']['pr_url'], 'type'=>"text", "required"=>1, "value"=>$variable['pr_url'], "valid_function"=>"valid_domain"));
$form_obj->add("project_dir", array('title'=>$lang['config']['pr_dir'], 'type'=>"text", "required"=>1, "value"=>$variable['project_dir'], "valid_function"=>"valid_dir"));
$form_obj->add("pr_email", array('title'=>$lang['config']['pr_email'], 'type'=>"text", "required"=>1, "value"=>$variable['pr_email'], "valid_function"=>"valid_email"));
$form_obj->add("license", array('title'=>$lang['config']['license'], 'type'=>"text", "required"=>1, "value"=>$variable['license']));
$form_obj->add("key", array('title'=>$lang['config']['key'], 'type'=>"text", "required"=>1, "value"=>$variable['key']));
//$form_obj->add("google_map_code", array('title'=>$lang['config']['google_map_code'], 'type'=>"text", "required"=>1, "value"=>""));

$form_obj->add("submit", array('title'=>'', "type"=>"button", "value"=>$lang['common']['next_step'], 'onclick'=>"javascript: this.form.submit();"));

if(isset($_POST['action']) && $_POST['action']=='config'){
	$form_obj->validate($_POST);
	$license_response = valid_license($_POST);
	if($license_response['error']==1){
		$form_obj->error = 1;
		$form_obj->fields['pr_url']['error'] = $license_response['error_domain'];
		$form_obj->fields['license']['error'] = $license_response['error_license'];
		$form_obj->fields['key']['error'] = $license_response['error_key'];
	}
	if($form_obj->error!=1){
		foreach($_POST as $key=>$val){
			if(!in_array($key, $wrong_fields)){
				$variable[$key] = htmlspecialchars($val);
			}
		}
		$config_obj->create($variable);
		redirect("install.php?step=db");
	}
}

echo $form_obj->create();


/*
echo '
<form method="post" name="config">
<table >
<tr><td>'.$lang['config']['pr_name'].'</td><td><input class="txt" type="text" value="" name="pr_name" /></td></tr>
<tr><td>'.$lang['config']['pr_url'].'</td><td><input class="txt" type="text" value="" name="pr_url" /></td></tr>
<tr><td>'.$lang['config']['pr_dir'].'</td><td><input class="txt" type="text" value="" name="pr_dir" /></td></tr>
<tr><td>'.$lang['config']['pr_email'].'</td><td><input class="txt" type="text" value="" name="pr_email" /></td></tr>
<tr><td>'.$lang['config']['license'].'</td><td><input class="txt" type="text" value="" name="license" /></td></tr>
<tr><td>'.$lang['config']['key'].'</td><td><input class="txt" type="text" value="" name="key" /></td></tr>
<tr><td>'.$lang['config']['google_map_code'].'</td><td><input class="txt" type="text" value="" name="google_map_code" /></td></tr>
</table>
<input class="btn" type="button" onclick="javascript: location=\'install.php?step=cred\';" value="'.$lang['common']['next_step'].'" />
</form>
';
*/
?>