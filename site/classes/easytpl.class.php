<?php

include_once(CLASSDIR_."basic.class.php");
class easytpl extends basic {
	
	var $file = '';
	var $vars = array();
	var $blocks = array();
	var $loops = array();
	var $floops = array();
	var $parseAllTime = false;

	// clases konstruktorius, uzsetinamas failas
	function easytpl($file='', $object_name='', $cacheDir=CACHETPLDIR){
		
		global $templateVariables;
		
		basic::basic();
		
		$this->tplVars = & $templateVariables;
		
		$this->cacheDir = $cacheDir;
		
		$this->file = $file;
		if(strlen($object_name)) $this->objectName = $object_name;
		
	}
	
	function setFile($file){
	    $this->file = $file;
	}
	
	// loopso registravimas
	function setLoop($name, $value){
	    
	    $this->tplVars->set_loop($name, $value);
	    
	    /*if(!empty($value)){
	    	$n = count($value);
	    	for($i=0; $i<$n; $i++){
	    		if(is_array($value)){
		    		if(!empty($value[$i]))
		    			$value[$i]['_INDEX'] = $i+1;
	    		}
	    	}
	     	$this->tplVars->loops[$name] = $value;
	    }*/  
	}
                                              
	/*// aukstesnio prioriteto loopso registravimas (pirmiau ivykdomas nei paparastas loopas)
	function setFastLoop($name, $value){
	    $this->setLoop($name, $value);
	}*/
	
	// blocko registravimas
	function setVar($name, $value){
	    
	    $this->tplVars->set_var($name, $value);
	    
	    /*if(is_array($value)){
	        // jei registruojamas variablas masyvas, registruojamas kiekvienas masyvas elementas
	        foreach($value as $k=>$v)
	        	$this->setVar($name.".".$k, $v);
	    }
	    else
	        $this->tplVars->vars[$name] = $value;*/
	}

	// aukstesnio prioriteto blocko registravimas (pirmiau ivykdomas nei paparastas blockas)
	/*function setFastVar($name, $value){
		$this->setVar($name, $value);
	}*/
	
	function loops($source){
	    $pos=0; $endPos=0; $n = 0;
	    while(($pos=strpos($source, "<loop name=\"", $pos))!==false){
	        $endPos=strpos($source, "\">", $pos);
	        $loopname = substr($source, $pos+12, $endPos-$pos-12);
	        $loopPath = explode(".", $loopname);
	        $endPosLoop = strpos($source, "</loop name=\"".$loopname."\">", $endPos) + strlen("</loop name=\"".$loopname."\">");
	        if($endPosLoop===false) {
	        	echo "Neuzdarytas loop blockas: $loopname"; 
	        	exit;
	        }
	        $tempCode = substr($source, $pos, $endPosLoop-$pos);
	        $tempCode = $this->parseLoop($tempCode, $loopPath);
	        $tempCode = $this->loops($tempCode);
	        $source = substr_replace($source, $tempCode, $pos, $endPosLoop-$pos);
	    }
	    return $source;
	}
	
	// loopso parsinimas
	function parseLoop($code, $loopPath){
		$loopname = implode(".", $loopPath);
		$name = implode("_", $loopPath);
		$n = count($loopPath);
		for($i=0; $i<$n; $i++){
			$arr[] = $loopPath[$i];
			$var .= '["'.$loopPath[$i].'"]';
			if(($i+1)<$n) $var .= '[$'.implode("_", $arr).'_key]';
		}
		
	    while(($pos=strpos($code, "<loop name=\"".$loopname."\">", $pos))!==false){
            $endPos = strpos($code, "</loop name=\"".$loopname."\">", $pos);
            if(!$endPos){
            	echo "Neranda loop'o ".$loopname." pabaigos";
            	exit;
            }
	        $length = strlen("<loop name=\"".$loopname."\">");
	        $tempCode = substr($code, $pos, $endPos-$pos+$length+1);// be <loop>

			$tempCode = str_replace('<loop name="'.$loopname.'">', '<?php foreach($'.$this->objectName.'->loops'.$var.' as $'.$name.'_key => $'.$name.'_val){ ?>', $tempCode);
			$tempCode = str_replace('</loop name="'.$loopname.'">', '<?php } ?>', $tempCode);
		    

		    $tempCode = ereg_replace("\{".$loopname."\.(\{[a-zA-Z0-9\._]{1,}\})\}", "<?php echo \$".$name."_val[{\\1}]; ?>", $tempCode);
		    // Jei templeite bus {loop.{other}.title} Neveiks
		    /*$tempCode = ereg_replace("\{([a-zA-Z0-9\._]{1,}\.)\{([a-zA-Z0-9\._]{1,})\}(\.[a-zA-Z0-9\._]{1,})\}", "<?php echo \${$this->objectName}->vars[\"\\1\".\${$this->objectName}->vars[\"\\2\"].\"\\3\"]; ?>", $tempCode);*/
		    
		    $tempCode = ereg_replace("\{\{".$loopname."\.([a-zA-Z0-9_]{1,})\}\}", "\$".$name."_val[\"\\1\"]", $tempCode);
		    $tempCode = ereg_replace("\{".$loopname."\.([a-zA-Z0-9_]{1,})\}", "<?php echo \$".$name."_val[\"\\1\"]; ?>", $tempCode);
		    
		    $tempCode = ereg_replace("<block name=\"".$loopname."\.([a-zA-Z0-9_]{1,})\">", "<?php if(\$".$name."_val[\"\\1\"]){ ?>", $tempCode);
		    $tempCode = ereg_replace("</block name=\"".$loopname."\.([a-zA-Z0-9_]{1,})\">", "<?php } ?>", $tempCode);
		    
		    $tempCode = ereg_replace("<block name=\"".$loopname."\.([a-zA-Z0-9_]{1,})\" no>", "<?php if(!\$".$name."_val[\"\\1\"]){ ?>", $tempCode);
		    $tempCode = ereg_replace("</block name=\"".$loopname."\.([a-zA-Z0-9_]{1,})\" no>", "<?php } ?>", $tempCode);
		    

		    $code = substr_replace($code, $tempCode, $pos, $endPos+$length+1-$pos);
		        
	    }
	    
	    return $code;
	    
	}
	
	function setCodeBlock($name, $value){
		$this->tplVars->blocks[$name] = $value;
	}
	
	function parseCodeBlocks(){
		foreach($this->tplVars->blocks as $key => $val){
			$this->source = str_replace("{".$key."}", "<?php $val ?>", $this->source);
		}
	}
		
	function vars(){
	    
	    $this->source = ereg_replace("\{\{([a-zA-Z0-9\._]{1,})\}\}", "\${$this->objectName}->vars[\"\\1\"]", $this->source);
	    $this->source = ereg_replace("\{([a-zA-Z0-9\._]{1,}\.)\{([a-zA-Z0-9\._]{1,})\}\}", "<?php echo \${$this->objectName}->vars[\"\\1\".\${$this->objectName}->vars[\"\\2\"]]; ?>", $this->source);
	    $this->source = ereg_replace("\{([a-zA-Z0-9\._]{1,}\.)\{([a-zA-Z0-9\._]{1,})\}(\.[a-zA-Z0-9\._]{1,})\}", "<?php echo \${$this->objectName}->vars[\"\\1\".\${$this->objectName}->vars[\"\\2\"].\"\\3\"]; ?>", $this->source);
	    $this->source = ereg_replace("\{\{([a-zA-Z0-9\._]{1,})\}(\.[a-zA-Z0-9\._]{1,})\}", "<?php echo \${$this->objectName}->vars[\${$this->objectName}->vars[\"\\1\"].\"\\2\"]; ?>", $this->source);
	    $this->source = ereg_replace("\{([a-zA-Z0-9\._]{1,})\}", "<?php echo \${$this->objectName}->vars[\"\\1\"]; ?>", $this->source);
	    
		$this->source = ereg_replace("<block name=\"([a-zA-Z0-9\._]{1,}\.)\{([a-zA-Z0-9\._]{1,})\}\">", "<?php if(\${$this->objectName}->vars[\"\\1\".\${$this->objectName}->vars[\"\\2\"]]){ ?>", $this->source);
		$this->source = ereg_replace("<block name=\"([a-zA-Z0-9\._]{1,}\.)\{([a-zA-Z0-9\._]{1,})\}(\.[a-zA-Z0-9\._]{1,})\">", "<?php if(\${$this->objectName}->vars[\"\\1\".\${$this->objectName}->vars[\"\\2\"].\"\\3\"]){ ?>", $this->source);
		$this->source = ereg_replace("<block name=\"\{([a-zA-Z0-9\._]{1,})\}(\.[a-zA-Z0-9\._]{1,})\">", "<?php if(\${$this->objectName}->vars[\${$this->objectName}->vars[\"\\1\"].\"\\2\"]){ ?>", $this->source);
		$this->source = ereg_replace("<block name=\"([a-zA-Z0-9\._]{1,})\">", "<?php if(\${$this->objectName}->vars[\"\\1\"]){ ?>", $this->source);
		$this->source = ereg_replace("</block name=\"([a-zA-Z0-9\._]{1,})\">", "<?php } ?>", $this->source);

		$this->source = ereg_replace("<block name=\"([a-zA-Z0-9\._]{1,}\.)\{([a-zA-Z0-9\._]{1,})\}\">", "<?php if(!\${$this->objectName}->vars[\"\\1\".\${$this->objectName}->vars[\"\\2\"]]){ ?>", $this->source);
		$this->source = ereg_replace("<block name=\"([a-zA-Z0-9\._]{1,}\.)\{([a-zA-Z0-9\._]{1,})\}(\.[a-zA-Z0-9\._]{1,})\">", "<?php if(!\${$this->objectName}->vars[\"\\1\".\${$this->objectName}->vars[\"\\2\"].\"\\3\"]){ ?>", $this->source);
		$this->source = ereg_replace("<block name=\"\{([a-zA-Z0-9\._]{1,})\}(\.[a-zA-Z0-9\._]{1,})\">", "<?php if(!\${$this->objectName}->vars[\${$this->objectName}->vars[\"\\1\"].\"\\2\"]){ ?>", $this->source);
		$this->source = ereg_replace("<block name=\"([a-zA-Z0-9\._]{1,})\" no>", "<?php if(!\${$this->objectName}->vars[\"\\1\"]){ ?>", $this->source);
		$this->source = ereg_replace("</block name=\"([a-zA-Z0-9\._]{1,})\" no>", "<?php } ?>", $this->source);
		
	}
	
	function parseCalls($source){
		
	    $pos=0; $endPos=0; $n = 0;
	    while(($pos=strpos($source, "<call code=\"", $pos))!==false){
	        $endPos=strpos($source, "\">", $pos);
	        $code = substr($source, $pos+12, $endPos-$pos-12);
	        $arr = explode("::", $code);
	        foreach($arr as $val){
	        	$arr1 = explode("=", $val);
	        	$params[$arr1[0]] = $arr1[1];
	        }
	        
			$tempCode = "<?php \${$this->objectName}->set_{$params['set']}('{$params['name']}', \$main_object->call('{$params['module']}', '{$params['method']}', array({$params['params']}))); ?>";

	        $source = substr_replace($source, $tempCode, $pos, $endPos-$pos+2);
	        
	    }
	    return $source;
		
		
	}
	
	function parseIncludes($source){
		
	    $pos=0; $endPos=0; $n = 0;
	    while(($pos=strpos($source, "<include file=\"", $pos))!==false){
	        $endPos=strpos($source, "\">", $pos);
	        $file = substr($source, $pos+15, $endPos-$pos-15);
	        
			$tempCode = file_get_contents(DOCROOT_.$file);

	        $source = substr_replace($source, $tempCode, $pos, $endPos-$pos+2);
	        
	    }
	    return $source;
		
	}	
	
	// failo parsininmas
	function parse(){
		
		$this->cacheFile = $this->cacheDir.md5($this->file).".php";
		
		if(!file_exists($this->file) && !file_exists($this->cacheFile)){
		    echo "nera failo: ".$this->file;
		    exit;
		}
		
		clearstatcache();
		if(filemtime($this->file) > filemtime($this->cacheFile) || $this->parseAllTime){
		    $file = fopen($this->file, "r");
		    $this->source = fread($file, filesize($this->file));
		    fclose($file);
		    $this->cache = true;

		    $this->source = $this->parseIncludes($this->source);
			$this->parseCodeBlocks();
			$this->source = $this->loops($this->source);
			$this->vars();
			
			$this->source = $this->parseCalls($this->source);
			
			$file = fopen($this->cacheFile, "w");
			fwrite($file, $this->source);
			chmod($this->cacheFile, 0777);
			fclose($file);

		}

		return $this->cacheFile;
	}
	
}

?>
