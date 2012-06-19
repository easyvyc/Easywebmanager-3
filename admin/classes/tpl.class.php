<?php

class template
{
	var $file = '';
	var $vars = array();
	var $fvars = array();
	var $loops = array();
	var $floops = array();

	// clases konstruktorius, uzsetinamas failas
	function template($file=''){
		$this->file = $file;
	}
	
	function setFile($file){
	    $this->file = $file;
	}
	
	// loopso registravimas
	function setLoop($name, $value){
	    if(!empty($value)) $this->loops[$name] = $value;  
	}

	// loopso registravimas
	function setFastLoop($name, $value){
	    if(!empty($value)) $this->floops[$name] = $value;
	}
	
	// blocko registravimas
	function setVar($name, $value){
	    if(is_array($value)){
	        foreach($value as $k=>$v)// jei registruojamas variablas masyvas, registruojamas kiekvienas masyvas elementas
	        	$this->setVar($name.".".$k, $v);
	    }
	    else
	        $this->vars[$name] = $value;
	}

	// blocko registravimas
	function setFastVar($name, $value){
	    if(is_array($value)){
	        foreach($value as $k=>$v)// jei registruojamas variablas masyvas, registruojamas kiekvienas masyvas elementas
	        	$this->setFastVar($name.".".$k, $v);
	    }
	    else
	        $this->fvars[$name] = $value;
	}
		
	// parsiname loopsus
	function loops(){
		while(list($key, $value) = each($this->floops)){
		    if(empty($value))
		        $this->clearLoop($key);
		    else    
		        $this->parseFastLoop($key, $value);
		}
		while(list($key, $value) = @each($this->loops)){
		    if(empty($value))
		        $this->clearLoop($key);
		    else    
		        $this->parseLoop($key, $value);
		}
	}
	
	// tuscio loopso ishvalymas
	function clearLoop($name){
	    $pos=0;
	    while(($pos=strpos($this->source, "{loop ".$name."}", $pos))!==false){
            $endPos = strpos($this->source, "{-loop ".$name."}", $pos);
	        $length = strlen("{-loop ".$name."}");
	        $this->source = substr_replace($this->source, '', $pos, $endPos + $length);
	    }
	}

	// loopso parsinimas
	// fast loopai nepalaiko _INDEX'u
	function parseFastLoop($name, $value, $code=''){
	    $pos=0; $c=0; $p=0; $n=0;
	    $code = ($code==''?$this->source:$code);
	    while(($pos=strpos($this->source, "{loop ".$name."}", $pos))!==false){
            $endPos = strpos($this->source, "{-loop ".$name."}", $pos);
	        $length = strlen("{loop ".$name."}");
	        $tempCode = substr($this->source, $pos+$length, $endPos-$pos-$length);// be <loop>
		    $parsed = ''; 
		    for($i=0, $index = 1; !empty($value[$i]); $i++, $index++){
		        $n=1;
		        $tmp = $tempCode;
		        foreach($value[$i] as $k=>$v){
		            if(is_array($v)){
		                $this->setFastLoop($name.'.'.$i.'.'.$k, $v);// jei loopso elementas masyvas, setinamas naujas loopsas
		                //$this->setFastLoop($name.'.'.$i.'._INDEX', $index);
		            }else{
		                $this->setVar($name.".".$i.".".$k, $v);// kiekvienas loopso elementas registruojamas kaip blockas
		                //$this->setVar($name.".".$i."._INDEX", $index);
		            }
		            $tmp = $this->extractFastLoop($tmp, $name, $i, $k);
		            //$tmp = $this->extractFastLoop($tmp, $name, $i, "_INDEX");
		        }
		        
		        $parsed .= $tmp;
		    }
		    $this->source = substr_replace($this->source, $parsed, $pos, $endPos+$length+1-$pos);
	        
	        if($n!=1){// loop tagu naikinimas
		        $endPos = strpos($this->source, "{-loop ".$name."}", $pos);
		        $length = strlen("{loop ".$name."}");
		        $this->source = substr_replace($this->source, '', $pos, $endPos+$length+1);	            
	        }
	    }
	}
	
	// loopso parsinimas
	function parseLoop($name, $value, $code=''){
	    $pos=0; $c=0; $p=0; $n=0;
	    $code = ($code==''?$this->source:$code);
	    while(($pos=strpos($this->source, "{loop ".$name."}", $pos))!==false){
            $endPos = strpos($this->source, "{-loop ".$name."}", $pos);
	        $length = strlen("{loop ".$name."}");
	        $tempCode = substr($this->source, $pos+$length, $endPos-$pos-$length);// be <loop>
		    $parsed = ''; 
		    for($i=0, $index = 1; !empty($value[$i]); $i++, $index++){
		        $n=1;
		        $tmp = $tempCode;
		        foreach($value[$i] as $k=>$v){
		            if(is_array($v)){
		                $this->setLoop($name.'.'.$i.'.'.$k, $v);// jei loopso elementas masyvas, setinamas naujas loopsas
		            }else{
		                $this->setVar($name.".".$i.".".$k, $v);// kiekvienas loopso elementas registruojamas kaip blockas
		                $this->setVar($name.".".$i."._INDEX", $index);
		            }
		            $tmp = $this->extractLoop($tmp, $name, $i, $k);
		            $tmp = $this->extractLoop($tmp, $name, $i, "_INDEX");
		        }
		        
		        $parsed .= $tmp;
		    }
		    $this->source = substr_replace($this->source, $parsed, $pos, $endPos+$length+1-$pos);
	        
	        if($n!=1){// loop tagu naikinimas
		        $endPos = strpos($this->source, "{-loop ".$name."}", $pos);
		        $length = strlen("{loop ".$name."}");
		        $this->source = substr_replace($this->source, '', $pos, $endPos+$length+1);	            
	        }
	    }
	}

	// loopso extractinimas
	function extractFastLoop($temp, $name, $index, $key){

	    $temp = str_replace("{block ".$name.".".$key, "{block ".$name.".".$index.".".$key, $temp);
        $temp = str_replace("{-block ".$name.".".$key, "{-block ".$name.".".$index.".".$key, $temp);

		//$temp = $this->blocks($temp);    
        $temp = str_replace("{".$name.".".$key."}", $this->floops[$name][$index][$key], $temp);
        
        return $temp;
	}
	
	
	// loopso extractinimas
	function extractLoop($temp, $name, $index, $key){

		    $temp = str_replace("{block ".$name.".".$key, "{block ".$name.".".$index.".".$key, $temp);
	        $temp = str_replace("{-block ".$name.".".$key, "{-block ".$name.".".$index.".".$key, $temp);

	        //$temp = str_replace("{".$name.".".$key."}", $this->vars[$name.".".$index.".".$key], $temp);
	        $temp = str_replace("{".$name.".".$key, "{".$name.".".$index.".".$key, $temp);
	        
	        $temp = str_replace("{loop ".$name.".".$key, "{loop ".$name.".".$index.".".$key, $temp);
	        $temp = str_replace("{-loop ".$name.".".$key, "{-loop ".$name.".".$index.".".$key, $temp);
	    //}
        
        return $temp;
	}
	
	// blocku parsinimas einant per source'a
	function blocks($source){
	    $pos=0; $endPos=0; $n = 0;
	    while(($pos=strpos($source, "{block ", $pos))!==false){
	        $endPos1=strpos($source, "}", $pos);
	        $endPos2=strpos($source, " no}", $pos);
	        if($endPos1!==false){
	            $endPos = $endPos1;
	            $negative = 0;
	        }
	        if($endPos2!==false){
	            $endPos = $endPos2;
	            $negative = 1;
	        }
	        if($endPos1!==false && $endPos2!==false){
	            if($endPos1 < $endPos2){
	                $endPos = $endPos1;
	                $negative = 0;
	            }else{
	                $endPos = $endPos2;
	                $negative = 1;
	            }
	        }
	        
	        if($endPos > $pos){// jei blogai suzymetas blockas, nieko nedarom
		        reset($this->vars); 
		        $k=0;
		        $str = substr($source, $pos+7, $endPos-$pos-7);
		        
		        //echo $endPos." ".$endPos1." ".$endPos2." ".$negative." ".$str." ".$this->vars[$str]."<br>";
		        $value = (isset($this->vars[$str])?$this->vars[$str]:0);
		        //$value = $this->vars[$str];
		        $key = $str;

		        
		        if($negative==1){// jei neigimo blockas
			        if($str==$key){
			            $k=1;
		                $endPos = strpos($source, "{-block ".$key." no}", $pos);
		                if($endPos===false){
		                	echo "Neuzdarytas blokas '$key' no";
		                	exit;
		                }
		                $endPos += strlen("{-block ".$key." no}");
		                if($value===0 || $value==='' || $value==='0'){
		                    $temp = substr($source, $pos, $endPos-$pos);
		                    $temp = str_replace("{block ".$key." no}", '', $temp);
			                $temp = str_replace("{-block ".$key." no}", '', $temp);
			                $source = substr_replace($source, $temp, $pos, $endPos-$pos);
		                }elseif(isset($value)){
		                    $source = substr_replace($source, '', $pos, $endPos-$pos);
		                }else{
		                    $pos += strlen("{block ".$key." no}");
		                }   
			        }
			        if($k==0){
		                $pos+= strlen("{block ".$str." no}");
			        }
		        }else{
			        if($str==$key){
		                $k=1;
		                $endPos = strpos($source, "{-block ".$key."}", $pos);
		                if($endPos===false){
		                	echo "Neuzdarytas blokas '$key' $this->file";
		                	exit;
		                }
		                $endPos += strlen("{-block ".$key."}");
		                if($value===0 || $value==='' || $value==='0'){
		                    $source = substr_replace($source, '', $pos, $endPos-$pos);
		                }elseif(isset($value)){
		                    $temp = substr($source, $pos, $endPos-$pos);
		                    $temp = str_replace("{block ".$key."}", '', $temp);
			                $temp = str_replace("{-block ".$key."}", '', $temp);
			                $source = substr_replace($source, $temp, $pos, $endPos-$pos);
		                }else{
		                    $pos += strlen("{block ".$key."}");
		                }   
			        }
			        if($k==0){
		                $pos+= strlen("{block ".$str."}");
			        }
		        }
	        }
	    }
	    return $source;
	}

	// {variablu} parsinimas
	function vars(){
	    foreach($this->vars as $key=>$value){
		    $p=0; 
	        while(($p=strpos($this->source, "{".$key."}", $p))!==false){
	            $e=$p + strlen("{".$key."}");
	            $this->source = substr_replace($this->source, $value, $p, $e-$p);
	            $p += strlen($value);
	        }
	    }
	}

	function fastVars(){
	    foreach($this->fvars as $key=>$value){
		    $p=0; 
	        while(($p=strpos($this->source, "{".$key."}", $p))!==false){
	            $e=$p + strlen("{".$key."}");
	            $this->source = substr_replace($this->source, $value, $p, $e-$p);
	            $p += strlen($value);
	        }
	    }
	}
		
	// blocku parsinimas einant per visus uzregistruotus variablus
	function blocks1(){
	    foreach($this->vars as $key=>$value){
	        $pos=0;
	        while(($pos=strpos($this->source, "{block ".$key."}", $pos))!==false&&($endPos=strpos($this->source, "{-block ".$key."}", $pos))!==false){
	            $endPos+= strlen("{-block ".$key."}");
	            if(isset($value)&&$value==0)
	                $this->source = substr_replace($this->source, '', $pos, $endPos-$pos);
	            elseif(isset($value)){
	                $temp = substr($this->source, $pos, $endPos-$pos);
	                $temp = str_replace("{block ".$key."}", '', $temp);
	                $temp = str_replace("{-block ".$key."}", '', $temp);
	                $this->source = substr_replace($this->source, $temp, $pos, $endPos-$pos);
	            }
	        }
	        
	        $pos=0; 
	        while(($pos=strpos($this->source, "{".$key."}", $pos))!==false){
	            $endPos=$pos + strlen("{".$key."}");
	            $this->source = substr_replace($this->source, $value, $pos, $endPos-$pos);
	        }
	    }
	}	
	
	function clearTpl(){
	    $pos=0; $endPos=0;
	    while(($pos=strpos($this->source, "{loop ", $pos))!==false){
	        $end = strpos($this->source, "}", $pos);
	        $length = strlen("{loop ");
	        $name = substr($this->source, $pos + $length, $end - ($pos + $length));
	        $endPos = strpos($this->source, "{-loop ".$name."}", $pos) + strlen("{-loop ".$name."}");
	        $this->source = substr_replace($this->source, '', $pos, $endPos-$pos);
	    }	    
	}
	
	// failo parsininmas
	function parse($f=''){
		
		if($this->source != ''){
			
		}elseif(file_exists($this->file)){
		    $file = fopen($this->file, "r");
		    $this->source = fread($file, filesize($this->file));
		    fclose($file);
		}else{
		    echo "nera failo: ".$this->file;
		    exit;
		}
		$this->fastVars();
		$this->loops();
		$this->source = $this->blocks($this->source);
		$this->vars();
		$this->clearTpl();
		//$this->display_blocks();
		return $this->source;
	}
	
	function display_loops(){
	    echo "<pre>";
	    print_r($this->loops);
	    echo "</pre>";
	}

	function display_blocks(){
	    echo "<pre>";
	    print_r($this->vars);
	    echo "</pre>";
	}

	
}

?>