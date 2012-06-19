<?php

include_once(CLASSDIR."actions.class.php");
class actions_pages extends actions {

    function actions_pages() {
    	
    	actions::actions();
    	
    	$this->mod_actions = array('edit'=>array(), 'translate'=>array(), 'new'=>array(), /*'import'=>array(), 'export'=>array(), 'pdf'=>array(),*/ 'delete'=>array(), 'fields'=>array('title'=>array('lt'=>'Kategorijos papildymai', 'en'=>'Category extra')));
    	    	
    }

    function _block(){
    	global $easy_tpl, $main_object, $cms_phrases, $module;
    	include_once(MODULESDIR."pages/actions/block.php");
    }
    
    function _fields(){
    	global $easy_tpl, $main_object, $cms_phrases, $module;
    	include_once(MODULESDIR."pages/actions/fields.php");
    }
     
}

?>