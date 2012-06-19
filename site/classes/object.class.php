<?php

include_once(CLASSDIR_."basic.class.php");
class object extends basic {
	
	var $classDir = "";
	
    function object() {
    
    	basic::basic();
    	$this->classDir = CLASSDIR_;
    	
    }
    
    function create($module){

    	if(is_numeric($module)){
    		$mod = $this->module->getModule($module);
    		$module = $mod['table_name'];
    	}    	
    	
		if(is_object($this->obj[$module])) return $this->obj[$module];
    	
    	if(file_exists($this->classDir."modules/$module.class.php")){
    		
    		include_once($this->classDir."modules/$module.class.php");
    		$this->obj[$module] = & new $module($module);
    		
    	}else{
    		
    		include_once($this->classDir."catalog.class.php");
    		$this->obj[$module] = & new catalog($module);
    		
    	}
    	
    	return $this->obj[$module];
    	
    }
    
    function get($module, $property){
    	
    	if(!is_object($this->obj[$module])){
    		$this->create($module);
    	}
    	return $this->obj[$module]->$property;
    	
    }
    
    function set($module, $property, $value){
    	
    	if(!is_object($this->obj[$module])){
    		$this->create($module);
    	}
		$this->obj[$module]->$property = $value;	
    	
    }
    
    function call($module, $method, $params=array()){
    	
    	if(!is_object($this->obj[$module])){
    		$this->create($module);
    	}
    	if(method_exists($this->obj[$module], $method)){
    		
    		$return = call_user_method_array($method, $this->obj[$module], $params);
    		
    	}else{
    		
    		$this->error = "This method not exist";
    		return false;
    		
    	}
    	return $return;
    	
    }
    
    function destroy($module){
    	
    	unset($this->obj[$module]);
    	
    }
    
}

?>