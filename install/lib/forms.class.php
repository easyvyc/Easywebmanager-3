<?php

class forms {

    function forms($data) {
    	$this->form_data = $data;
    }
    
    function add($name, $column){
    	$column['name'] = $name;
    	$this->fields[$name] = $column;
    }
    
    function edit($name, $column){
    	foreach($column as $k=>$v){
    		$this->fields[$name][$k] = $v;
    	}
    }
    
    function valid_field($name, $value, $field){
    	if($field['required']==1){
    		if(!isset($value) || $value==''){
    			$this->fields[$name]['error'] = 1;
    			return false;
    		}
    	}
    	if(isset($field['valid_function']) && function_exists($field['valid_function'])){
    		if(!call_user_func($field['valid_function'], $value, $field, $this->data)){
    			$this->fields[$name]['error'] = 1;
    			return false;
    		}
    	}
    	return true;
    }
    
    function validate($data){
    	$this->data = $data;
    	foreach($this->fields as $key=>$val){
    		$this->fields[$key]['value'] = $data[$key];
    		if(!$this->valid_field($key, $data[$key], $val)){
    			$this->error = 1;
		    }
    	}
    }
    
    function create(){
    	
    	$content = "";
    	
    	$content .= "<form name=\"{$this->form_data['name']}\" action=\"{$this->form_data['action']}\" method=\"{$this->form_data['method']}\">";
    	foreach($this->fields as $key=>$val){
    		$content .= "<div class=\"row\">";
    		$content .= "<div class=\"title ".($val['error']==1?"error":"")."\">{$val['title']}</div>";
    		$content .= "<div class=\"field\">";
    		switch($val['type']){
				case "text":
					$content .= "<input class=\"txt\" type=\"text\" name=\"{$val['name']}\" value=\"{$val['value']}\">";
				break;
				case "textarea":
					$content .= "<textarea name=\"{$val['name']}\">{$val['value']}</textarea>";
				break;
				case "file":
					$content .= "<input type=\"file\" name=\"{$val['name']}\" value=\"{$val['value']}\">";
				break;
				case "hidden":
					$content .= "<input type=\"hidden\" name=\"{$val['name']}\" value=\"{$val['value']}\">";
				break;
				case "button":
					$content .= "<input class=\"btn\" type=\"submit\" name=\"{$val['name']}\" value=\"{$val['value']}\" >";
				break;
				default:
				
			}
			if($val['error']==1) $content .= " <span class=\"error\">Klaida</span>";
			$content .= "</div>";
    		$content .= "</div>";
    	}
    	$content .= "</form>";
    	
    	return $content;
    	
    }
    
}
?>