<?php

include_once(CLASSDIR_."catalog.class.php");

class shippings extends catalog{
	
	function shippings(){

		catalog::catalog("shippings");
		
		$this->currency = $this->main_object->call("currencies", "getCurrent");
    	
	}
	
    function loadItem($id){
    	$data = record::loadItem($id);
    	$data['price'] = number_format($data['price']/$this->currency['course'], 2, ".", "");
    	return $data;
    }
    		
}

?>