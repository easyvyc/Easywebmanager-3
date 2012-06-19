<?php
/*
 * Created on 2007.08.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


//include_once(CLASSDIR_."modules/users.class.php");
//$user_obj = & new users();

if(isset($_POST['action']) && $_POST['action']=='login'){
	
	$user_data = $main_object->call("users", "loginUser", array($_POST));
	
	//$user_data = $user_obj->loginUser($_POST);
	
	if(!empty($user_data)){
//		$user_data['discount'] = $user_data['group_discount'];
//		$user_data['card_type_value'] = $user_data['card_type'];
//		$user_data['card_type'] = $user_data['card_type_ids'];
		$_SESSION['user'] = $user_data;
//		$sql = "SELECT page_url FROM cms_pages WHERE disabled!=1 AND public_page=1 AND template=5 AND parent_id={$id_path[0]['id']} ";
//		$database->exec($sql, __FILE__, __LINE__);
//		$row = $database->row();
		redirect($configFile->variable['site_url'].$lng."/");
	}else{
		$tpl->setVar('bad_login', 1);
	}
}
if(isset($_POST['action']) && $_POST['action']=='logout'){
	unset($_SESSION['user']);
	redirect($configFile->variable['site_url'].$lng."/");
}
$tpl->setVar('loged_user', $_SESSION['user']);



?>