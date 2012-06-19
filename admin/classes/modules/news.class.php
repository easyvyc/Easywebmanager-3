<?php

include_once(CLASSDIR."record.class.php");
class news extends record {
	
	function news($module) {
    	
    	record::record($module);
    	
    	//$this->mod_actions = array('edit'=>array(), 'send'=>array('title'=>array('lt'=>'Siųsti', 'en'=>'Send'), 'img'=>'mail'), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array(), 'settings'=>array());
    	
    }
    
    function saveItem($data){
    	if(isset($data['title']) && strlen($data['title'])){
	    	include_once(CLASSDIR."modules/pages.class.php");
	    	$data['item_url'] = pages::replaceLetters($data['title']);
    	}
    	$id = record::saveItem($data);
    	return $id;
    }
    
}

?>