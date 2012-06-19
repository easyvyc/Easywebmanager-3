<?php

class config {

    function config($file) {
    	$this->file = $file;
    }
    
    function create($variable){

		$begin = "<?php\r\n";
		$str = $this->parseVariable($variable);
		$end = "?>";
		
		$content = $begin.$str.$end;
		
		$file = fopen($this->file, "w");
		fwrite($file, $content);
		fclose($file);
		
    }
    
	function parseVariable($var, $path=array(), $level=0){
		
		if(is_array($var)){
			foreach($var as $key => $val){
				$path[$level] = $key;
				if(is_array($val)){
					$str .= $this->parseVariable($val, $path, $level+1);
				}else{
					$str .= $this->putVariable($val, $path);
				}
			}
		}else{
			$str .= $this->putVariable($var, $path);
		}
		
		return $str;
		
	}
	
	function putVariable($val, $path){
		
		$arr_path = implode("']['", $path);
		unset($value_str);
		if(is_bool($val) || is_float($val) || is_int($val))
			$value_str = $val;
		else
			$value_str = "'".addcslashes($val, "'")."'";
		$str .= "\$variable['".$arr_path."']=".$value_str.";\r\n";
		
		return $str;
	
	}
	    
}
?>