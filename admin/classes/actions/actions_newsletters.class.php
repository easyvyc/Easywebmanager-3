<?php

include_once(CLASSDIR."actions.class.php");
class actions_newsletters extends actions {

    function actions_newsletters() {
    	
    	actions::actions();
    	
    	$this->mod_actions = array('module'=>array(), 'edit'=>array(), 'translate'=>array(), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array());
    	    	
    }

    function _send(){
    	
    	global $main_object;
    	
    	//$tpl = & new easytpl(MODULESDIR."extras/newsletters_emails.tpl", "templateVariables");
    	
		include_once(CLASSDIR."forms.class.php");
		$form = new forms();
		
		$record = $main_object->create($_GET['module']);
		
		$record->loadItem($_GET['id']);
		
		$form->addField("emails", $record->_table_fields['emails']);
		$form->addField("submit", $record->_table_fields['submit']);
		
		$send['lt'] = "Siųsti";
		$send['en'] = "Send";
		
		$form->editField("submit", array("title"=>$send[$_SESSION['site_lng']]));
		
		$form->formName = 'mail';
		$form->formAction = "javascript: void(top.content.PageClass.submitForm_('{$configFile->variable['site_admin_url']}ajax.php?get=extras/send_newsletter&module={$_GET['module']}&id={$_GET['id']}&offset=0', 'newsletters_loading', top.content.document.forms['mail'], 1));";
		
		$form_data = $form->construct_form();
		
		
						
		echo $form_data;
		exit;  	
    	
    }
    
}

?>