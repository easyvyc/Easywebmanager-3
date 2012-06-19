<?php

include_once(CLASSDIR."basic.class.php");
class actions extends basic {

	var $mod_actions = array('edit'=>array(), 'translate'=>array(), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array());
	var $catalog_dir = "catalog";
	
    function actions($module) {
    	
    	basic::basic();
    	// sicia reik perdaryt
    	if($module=="pages") $this->catalog_dir = $module;
    	
    	/*$main_object->create($module);
    	
    	if($main_object->obj[$module]->module_info['tree']){
    		$this->catalog_dir = $module;
    	}*/
    }
    
    
    
    // action methods
    function _edit(){
    	global $easy_tpl, $main_object, $cms_phrases, $module;
    	include_once(MODULESDIR.$this->catalog_dir."/actions/edit.php");
    }

    function _translate(){
    	global $easy_tpl, $main_object, $cms_phrases, $module;
    	include_once(MODULESDIR.$this->catalog_dir."/actions/translate.php");
    }

    function _module(){
    	global $easy_tpl, $main_object, $cms_phrases, $module;
    	include_once(MODULESDIR."pages/actions/module.php");
    }

    function _new(){
    	global $easy_tpl, $main_object, $cms_phrases, $module;
    	include_once(MODULESDIR.$this->catalog_dir."/actions/new.php");
    }

    function _import(){
    	global $easy_tpl, $main_object, $cms_phrases;
    	include_once(MODULESDIR.$this->catalog_dir."/actions/import.php");
    }

    function _export(){
    	global $easy_tpl, $main_object, $cms_phrases;
    	include_once(MODULESDIR.$this->catalog_dir."/actions/export.php");
    }

    function _pdf(){
    	global $easy_tpl, $main_object, $cms_phrases;
    	include_once(MODULESDIR.$this->catalog_dir."/actions/pdf.php");
    }

    function _delete(){
    	global $easy_tpl, $main_object, $cms_phrases;
    	include_once(MODULESDIR.$this->catalog_dir."/actions/delete.php");
    }
    
    function _settings(){
    	global $easy_tpl, $main_object, $cms_phrases;
    	include_once(MODULESDIR.$this->catalog_dir."/actions/settings.php");
    }
    
}
?>