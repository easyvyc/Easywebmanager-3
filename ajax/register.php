<?php
/*
 * Created on 2009.05.15
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$tpl_inner = & new easytpl(TPLDIR_."blocks/register.tpl", "templateVariables");

//$record = $user_obj = $main_object->create("users");
//
//include_once(CLASSDIR_."formaction.class.php");
//$formaction_obj = & new formaction();
//
//foreach($user_obj->table_fields as $key=>$val){
//	//$user_obj->table_fields[$key]['title'] = $phrases['register_form_'.$user_obj->table_fields[$key]['column_name']];
//	if(($user_obj->table_fields[$key]['CE']==0 || $user_obj->table_fields[$key]['CE']==2)) $table_fields[] = $user_obj->table_fields[$key];
//}
//	//$table_fields[] = array('elm_type'=>FRM_TEXTAREA, 'column_name'=>'comment', 'title'=>$phrases['order_form_comment']);
//$table_fields[] = array('elm_type'=>FRM_HIDDEN, 'column_name'=>'active', 'value'=>1);
//$table_fields[] = array('elm_type'=>FRM_HIDDEN, 'column_name'=>'isNew', 'value'=>1);
//$table_fields[] = array('elm_type'=>FRM_HIDDEN, 'column_name'=>'is_category', 'value'=>"0");
//$table_fields[] = array('elm_type'=>FRM_HIDDEN, 'column_name'=>'parent_id', 'value'=>"0");
//$table_fields[] = array('elm_type'=>FRM_HIDDEN, 'column_name'=>'id', 'value'=>"0");
//
//$action_data_register['target'] = "database";
//$action_data_register['module'] = "users";
//$action_data_register['name'] = "register";
//$action_data_register['isNew'] = 1;
//$action_data_register['is_category'] = "0";
//$action_data_register['id'] = "0";
//$action_data_register['parent_id'] = "0";
//
//$action_data_register['redirect'] = "ajax.php?content=register&lng={$_GET['lng']}&target={get.target}&thanks=1";//$configFile->variable['site_url'].$lng."/".$reserved_url_words['order']."/".$reserved_url_words['step']."/3";
//
//$formaction_obj->setAction($action_data_register);
//$formaction_obj->setFields($table_fields);
//
//$formaction_obj->form->editField("userpass", array('elm_type'=>FRM_PASSWORD));
//
//$formaction_obj->form->formParams['form_action'] = "javascript: void(post('{$configFile->variable['site_url']}ajax.php?content=register&lng={$_GET['lng']}&target={get.target}', '{get.target}', document.forms['register']));";
//
//$_POST['active'] = 1;
//$formaction_obj->setData($_POST);
//
//$formaction_obj->form->addField('submit', array('title'=>$phrases['user_new_submit'], 'elm_type'=>FRM_SUBMIT));
//unset($formaction_obj->form->elements['loginname']);
//
//$formaction_obj->form->editField('subscribe_newsletters_ok', array('checked'=>1));
//
//unset($formaction_obj->form->elements['rating']);
//
//$forma_content = $formaction_obj->process();
//
//$tpl_inner->setVar('register_form', $forma_content);
//
//$tpl_inner->setVar('get', $_GET);

$tpl_inner->setVar('phrases', $phrases);

include $tpl_inner->parse();
exit;


?>