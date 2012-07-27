<?php
/*
 * Created on 2007.08.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if(isset($_POST['action']) && $_POST['action']=='newsletters'){
	$_POST['email'] = addcslashes($_POST['email'], "'");
	if(valid_email($_POST['email'])){
		$tpl->setVar('subscriber_error', 1);
	}else{
		//$subscribers_obj = & new catalog("subscribers");
		$_post_data['id'] = 0;
		$_post_data['isNew'] = 1;
		$_post_data['is_category'] = 0;
		$_post_data['parent_id'] = 0;
		$_post_data['language'] = $lng;
		$_post_data['title'] = $_POST['email'];
		$_post_data['active'] = 1;
		//if($subscribers_obj->checkDataExist(array('column_name'=>'title', 'value'=>$_POST['email']), $_post_data)!=1){
		if($main_object->call("subscribers", "checkDataExist", array(array('column_name'=>'title', 'value'=>$_POST['email']), $_post_data)) != 1){
			//$subscribers_obj->saveItem($_post_data);
			$main_object->call("subscribers", "saveItem", array($_post_data));
			$tpl->setVar('successful_subscriber', 1);
		}else{
			$tpl->setVar('subscriber_error', 1);
		}
	}
}

?>