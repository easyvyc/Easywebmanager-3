<?php 

include_once(CLASSDIR_."basic.class.php");
include_once(dirname(__FILE__)."/images.class.php");
include_once(dirname(__FILE__)."/tpl.class.php");
class forms extends basic {

	var $error_msg_empty_field = 'Empty!';
	var $default_style = 'txt';
	var $error_style = 'error';
	var $field_style = 'fo';
	var $error = 0;
	var $imgobjects = array();
	var $formName = "save";
	var $create_in_iframe = 0;
	var $iframe_load_action = "";
	var $debug = 0;

	function forms() {
	    
	    basic::basic();
	    $this->imgDir = UPLOADDIR;
	    $this->imgUrl = UPLOADURL;
	    $this->tpl_path = MODULESDIR."forms/";
	    $this->tpl_main = & new template($this->tpl_path."main.tpl");
	    $this->tpl = array();
	    $this->default_error_message = $this->cmsPhrases['main']['common']['empty_field'];
	    
	}
	
	// uzkraunami visi fieldai
	function setData($fields){
		
		foreach($fields as $key=>$val){
			$this->addField($key, $val);
		}
		
	}
	
	// uzkrauna po viena fielda 
	function addField($key, $arr){
		
		$arr['style'] = $this->default_style;
        $arr['name'] = $key;
        if(isset($arr['elm_type'])) $arr['type'] = $arr['elm_type'];
        if(isset($arr['type'])) $arr['elm_type'] = $arr['type'];
        if($arr['type']==FRM_FLOAT) $arr['function'] = 'checkFloat';
        if($arr['type']==FRM_NUMBER) $arr['function'] = 'checkNumber';
        if(isset($arr['default_value'])) $arr['default_value'] = $this->getDefaultValue($arr);
        $this->elements[$key] = $arr;
        
	}

	// edit one field 
	function editField($name, $arr){
		
		if(isset($arr['default_value'])) $arr['default_value'] = $this->getDefaultValue($arr);
		foreach($this->elements as $key=>$val){
			if($name==$this->elements[$key]['column_name'] || $name==$this->elements[$key]['name'])
				$index = $key;
		}
		if(isset($index)){
			foreach($arr as $key=>$val){
				$this->elements[$index][$key] = $val;
			}
		}
		
	}
	
	function set_element_prms($k) {

		$this->elements[$k]['show_error'] = ($this->elements[$k]['value'] == '' ? 1 : '');
		$this->elements[$k]['ok'] = ($this->elements[$k]['value'] == '' ? 0 : 1);
		$this->elements[$k]['style'] = ($this->elements[$k]['value'] == '' ? $this->error_style : $this->default_style);
		$this->error = ($this->elements[$k]['value'] == '' ? 1 : ($this->error!=1?0:1));
		$this->elements[$k]['error_message'] = (strlen($this->elements[$k]['error_message'])>0?$this->elements[$k]['error_message']:$this->default_error_message);
		
		if(strlen($this->elements[$k]['class_method'])>0){
			$par = $this->parseString2Array($this->elements[$k]['class_method']);
			if(!empty($par)){
				if(is_object($GLOBALS[$par['object']]) && method_exists($GLOBALS[$par['object']], $par['method'])){
					$error = call_user_method($par['method'], $GLOBALS[$par['object']], $this->elements[$k], $this->form_data);
					$this->elements[$k]['show_error'] = ($error || $this->elements[$k]['show_error'] ? 1 : '');
					$this->elements[$k]['ok'] = ($error == 1 ? 0 : 1);
					$this->elements[$k]['style'] = ($error == 1 ? $this->error_style : $this->elements[$k]['style']);
					$this->error = $error == 1 ? 1 : ($this->error==1? 1 : 0);
					$this->elements[$k]['error_message'] = (strlen($this->elements[$k]['error_message'])?$this->elements[$k]['error_message']:$this->default_error_message);
					if($error && strlen($par['admin_error_msg'])>0)  $this->elements[$k]['error_message'] = $par['admin_error_msg'];
				}
			}
		}
		
		if (strlen($this->elements[$k]['function'])>0) {
			$par = $this->parseString2Array($this->elements[$k]['function']);
			if(function_exists($par['function'])){
				$error = call_user_func($par['function'], $this->elements[$k]['value']);
				$this->elements[$k]['show_error'] = ($error || $this->elements[$k]['show_error'] ? 1 : '');
				$this->elements[$k]['ok'] = ($error == 1 ? 0 : 1);
				$this->elements[$k]['style'] = ($error == 1 ? $this->error_style : $this->elements[$k]['style']);
				$this->error = $error == 1 ? 1 : ($this->error==1? 1 : 0);
				$this->elements[$k]['error_message'] = (strlen($this->elements[$k]['error_message'])?$this->elements[$k]['error_message']:$this->default_error_message);
				if($error && strlen($par['admin_error_msg'])>0)  $this->elements[$k]['error_message'] = $par['admin_error_msg'];
			}
		} 
		
	}

	function validate($data) {
		
		$this->create_in_iframe = 1;
	    $this->form_data = $data;
	    foreach ($this->elements as $k => $v) {
	    	
	    	if($data['edited_field_'.$k]==1) $this->elements[$k]['edited'] = 1;
	    	
	    	switch ($v['type']) {
				case FRM_TEXTAREA :
					$this->elements[$k]['value'] = $data[$k];
					$this->elements[$k]['value'] = trim($this->elements[$k]['value']);
					if($this->elements[$k]['html']!=1){
						$this->elements[$k]['value'] = addcslashes($this->elements[$k]['value'], "'\\");
						$this->elements[$k]['value'] = htmlspecialchars($this->elements[$k]['value']);
					}elseif($this->elements[$k]['escape']==1){
						$this->elements[$k]['value'] = addcslashes($this->elements[$k]['value'], "'\\");
					}
					$_POST[$k] = $this->elements[$k]['value'];
					if ($v['require'] == 1) $this->set_element_prms($k);
					$this->elements[$k]['value'] = stripslashes($this->elements[$k]['value']);
					break;
				case FRM_HTML :
					if($this->elements[$k]['htmlspecialchars']!=1){
						$this->elements[$k]['value'] = ereg_replace("\'", "&#39;", $data[$k]);
					}else{
						$this->elements[$k]['value'] = addcslashes($data[$k], "'\\");
					}
					$_POST[$k] = $this->elements[$k]['value'];
					break;
				case FRM_FILE :
					global $denied_upload_files;
					$column_name = 'file_'.$k;
					if((int)$this->php_ini_array['upload_max_filesize']['local_value']<(int)$this->php_ini_array['post_max_size']['local_value']){
						$max_post_file_size = (int)$this->php_ini_array['upload_max_filesize']['local_value'];
					}else{
						$max_post_file_size = (int)$this->php_ini_array['post_max_size']['local_value'];
					}

					//UPLOAD_ERR_OK
					//Value: 0; There is no error, the file uploaded with success. 
					//
					//UPLOAD_ERR_INI_SIZE
					//Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini. 
					//
					//UPLOAD_ERR_FORM_SIZE
					//Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form. 
					//
					//UPLOAD_ERR_PARTIAL
					//Value: 3; The uploaded file was only partially uploaded. 
					//
					//UPLOAD_ERR_NO_FILE
					//Value: 4; No file was uploaded. 
					//
					//UPLOAD_ERR_NO_TMP_DIR
					//Value: 6; Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3. 
					//
					//UPLOAD_ERR_CANT_WRITE
					//Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0.
					
	    			$this->createFileObj($k, "files");
	    			
					$file_info = pathinfo($_FILES[$column_name]['name']);
					
					if($_FILES[$column_name]['error']==1 || $_FILES[$column_name]['error']==2 || $_FILES[$column_name]['error']==3 || $_FILES[$column_name]['error']==6){
						$this->elements[$k]['show_error'] = 1;
						$this->elements[$k]['ok'] = 0;
						$this->elements[$k]['style'] = $this->error_style;
						$this->error = 1;
						$this->elements[$k]['error_message'] = $this->cmsPhrases['main']['common']['too_big_file'];
					}elseif($_FILES[$column_name]['error']==4 && $v['require'] == 1 && $this->form_data['old_'.$k]==''){
						$this->elements[$k]['show_error'] = 1;
						$this->elements[$k]['ok'] = 0;
						$this->elements[$k]['style'] = $this->error_style;
						$this->error = 1;
						//$this->elements[$k]['error_message'] = $this->cmsPhrases['main']['common']['too_big_file'];
					}elseif(is_uploaded_file($_FILES[$column_name]['tmp_name']) && in_array(strtolower($file_info['extension']), $denied_upload_files)){
						$this->elements[$k]['show_error'] = 1;
						$this->elements[$k]['ok'] = 0;
						$this->elements[$k]['style'] = $this->error_style;
						$this->error = 1;
						$this->elements[$k]['error_message'] = $this->cmsPhrases['main']['common']['wrong_extension_file'];
					}else{
						$arr['old'] = $this->elements[$k]['value'];
						
						if(is_uploaded_file($_FILES[$column_name]['tmp_name'])){
							$this->elements[$k]['value'] = $this->file[$k]->save($_FILES[$column_name]);
						}
						
						if(strlen($this->elements[$k]['value'])>0)
							$_POST[$k] = $_GET[$k] = $this->elements[$k]['value'];
						$arr['new'] = $this->elements[$k]['value'];
						$this->uploadedFiles['files'][$k] = $arr;
						$this->elements[$k]['value'] = $_POST[$k];
					}
					
					if ($v['require'] == 1) $this->set_element_prms($k);
					break;
				case FRM_IMAGE :
					global $valid_images;
					$column_name = 'file_'.$k;
					if((int)$this->php_ini_array['upload_max_filesize']['local_value']<(int)$this->php_ini_array['post_max_size']['local_value']){
						$max_post_file_size = (int)$this->php_ini_array['upload_max_filesize']['local_value'];
					}else{
						$max_post_file_size = (int)$this->php_ini_array['post_max_size']['local_value'];
					}
					
					$this->createFileObj($k, "images");
					
					$v['image_extra'] = getValueParamsImages($v['extra_params']);
					$this->file[$k]->resize_params = $v['image_extra'];
					
					$file_info = pathinfo($_FILES[$column_name]['name']);
					
					if($_FILES[$column_name]['error']==1 || $_FILES[$column_name]['error']==2 || $_FILES[$column_name]['error']==3 || $_FILES[$column_name]['error']==6){
						$this->elements[$k]['show_error'] = 1;
						$this->elements[$k]['ok'] = 0;
						$this->elements[$k]['style'] = $this->error_style;
						$this->error = 1;
						$this->elements[$k]['error_message'] = $this->cmsPhrases['main']['common']['too_big_file'];
					}elseif(is_uploaded_file($_FILES[$column_name]['tmp_name']) && !in_array(strtolower($file_info['extension']), $valid_images)){
						$this->elements[$k]['show_error'] = 1;
						$this->elements[$k]['ok'] = 0;
						$this->elements[$k]['style'] = $this->error_style;
						$this->error = 1;
						$this->elements[$k]['error_message'] = $this->cmsPhrases['main']['common']['wrong_extension_file'];
					}else{
						if(isset($this->form_data['noresize_'.$k])){
							
							foreach($v['image_extra'] as $image_extra_key => $image_extra_val){
								if(!is_numeric($this->form_data['resize_width_'.$k.'_'.$image_extra_val['prefix']]) || 
								   !is_numeric($this->form_data['resize_height_'.$k.'_'.$image_extra_val['prefix']])){
								   $this->error = 1;
								   $this->elements[$k]['style'] = $this->error_style;
								}else{
									$this->file[$k]->resize_params[$image_extra_key]['size_width'] = $this->form_data['resize_width_'.$k.'_'.$image_extra_val['prefix']];
									$this->file[$k]->resize_params[$image_extra_key]['size_height'] = $this->form_data['resize_height_'.$k.'_'.$image_extra_val['prefix']];
								}
							}
							
							if($this->error != 1){
								$this->file[$k]->resize_image = isset($this->form_data['noresize_'.$k])?1:0;
								if($_FILES[$column_name]['size']==0){
									if($this->form_data['resize_old_'.$k]==1){
										$this->file[$k]->resize_old_image = $this->form_data['old_'.$k];
									}
								}
								$arr['old'] = $this->form_data['old_'.$k];
								
								$this->elements[$k]['value'] = $this->file[$k]->save($_FILES[$column_name]);
								
								if(strlen($this->elements[$k]['value'])>0){
									// _GET reikia del flash upload
									$_POST[$k] = $_GET[$k] = $this->elements[$k]['value'];
								}
									
								$arr['new'] = $this->elements[$k]['value'];
								$this->uploadedFiles['files'][$k] = $arr;
							}
						}
					}
					$this->elements[$k]['value'] = $_POST[$k];
					if ($v['require'] == 1) $this->set_element_prms($k);
					break;
				case FRM_RADIO :
				case FRM_SELECT :
				case FRM_AUTOCOMPLETE :
					$this->elements[$k]['value'] = trim($data[$k]);
					if ($v['require'] == 1) $this->set_element_prms($k);
					break;
				case FRM_CHECKBOX_GROUP :
					foreach($data[$k] as $s_k=>$s_v){
						$this->elements[$k]['checked'][] = $data[$k][$s_k];
						//if(isset($data[$k][$s_k])) $this->elements[$k]['value'][$s_k]['checked'] = 'checked';
					}
					$this->elements[$k]['value'] = implode("::", $data[$k]);
					$_POST[$k] = $this->elements[$k]['value'];
					break;
				case FRM_CHECKBOX :
					$this->elements[$k]['value'] = $data[$k];
					break;
				case FRM_PASSWORD :
					$this->elements[$k]['style'] = $this->default_style;
					if(strlen($data[$k."_1"])>0 || strlen($data[$k."_2"])>0){
						if($data[$k."_1"]==$data[$k."_2"] && strlen($data[$k."_1"])>3){
							$this->elements[$k]['value'] = ($this->elements[$k]['list_values']['md5']==1?md5($data[$k."_1"]):$data[$k."_1"]);
							//$_POST[$k] = $data[$k."_1"];
							$_POST[$k] = $this->elements[$k]['value'];
						}else{
							$this->elements[$k]['style'] = $this->error_style;
							$this->error = 1;
						}
					}elseif($data['isNew']==1){
						$this->elements[$k]['style'] = $this->error_style;
						$this->error = 1;						
					}
					break;
				case FRM_CUSTOM :
					if ($v['require'] == 1) $this->set_element_prms($k);
					break;
				case FRM_DATE :
					$data[$k] = $data[$k].(strlen($data[$k."_hour"])?" ".$data[$k."_hour"].":".$data[$k."_minute"]:"");
				case FRM_TREE : 
				case FRM_TEXT :
				default:
					$this->elements[$k]['value'] = $data[$k];
					$this->elements[$k]['value'] = trim($this->elements[$k]['value']);
					$this->elements[$k]['value'] = preg_replace("/\'/", "&#39;", $this->elements[$k]['value']);
					$this->elements[$k]['value'] = addcslashes($this->elements[$k]['value'], "\\");
					$_POST[$k] = $this->elements[$k]['value'];
					if ($v['require'] == 1) $this->set_element_prms($k);
					$this->elements[$k]['value'] = stripslashes($this->elements[$k]['value']);
					break;
			}
		}
		
		if($this->error == 1){
			//$this->create_in_iframe = 1;
			$this->removeUploadedFiles();
		}
		global $RESTART_SESSION;
		if($RESTART_SESSION == 1) $this->error = 1;
	    //pae($this->elements);
	}
	
	
	function removeUploadedFiles(){
		foreach($this->uploadedFiles['files'] as $key => $val){
			$this->file[$key]->remove($val['new']);
			$this->elements[$key]['value'] = $this->uploadedFiles['files'][$key]['old'];
		}
	}
	
	function construct_form() {
	    //pa($this->elements);
	    $form = '';
	    
	    if($this->formHTML != ''){
			$tpl_module_html = & new template();
			$tpl_module_html->vars = $this->formHTML_vars;
		}	    
	    
	    foreach ($this->elements as $k => $v) {
		    
		    if($this->error != 1 && $v['edited']!=1) $v['edited'] = 0;
		    
		    $this->tpl[$v['column_name']] = & new template($this->tpl_path.$v['type'].".tpl");
		    
		    if(!is_array($v['list_values']) && strlen($v['list_values'])){
		    	$v['list_values'] = record::parseString2Array($v['list_values']);
		    }
			
			if(strlen($v['list_values']['inc_file']) && file_exists(MODULESDIR.$v['list_values']['inc_file'])){
				include(MODULESDIR.$v['list_values']['inc_file']);
			}
			if(strlen($v['list_values']['tpl_file']) && file_exists(MODULESDIR.$v['list_values']['tpl_file'])){
				$this->tpl[$v['column_name']]->setFile(MODULESDIR.$v['list_values']['tpl_file']);
			}
			
		    $this->tpl[$v['column_name']]->setVar('phrases', $GLOBALS['cms_phrases']['main']);
		    $this->tpl[$v['column_name']]->setVar('config', $this->config->variable);
		    $this->tpl[$v['column_name']]->setVar('module_config', $this->config->variable);
		    $this->tpl[$v['column_name']]->setVar('easyweb', $_SESSION['easy']);
		    $this->tpl[$v['column_name']]->setVar('form.name', $this->formName);
		    $this->tpl[$v['column_name']]->setVar('lng', $_SESSION['site_lng']);
		    $this->tpl[$v['column_name']]->setVar('data', $this->elements);
		    $this->tpl[$v['column_name']]->setVar('get', $_GET);
		    
		    $v['extra_params'] = ereg_replace("&quot;", "\"", $v['extra_params']);
		    $v['extra_params'] = str_replace("&#39;", "'", $v['extra_params']);
		    $v['field_extra_params'] = ereg_replace("&quot;", "\"", $v['field_extra_params']);
		    //pa($v); continue;
		    switch ($v['type']) {
				case FRM_DATE :
					if($v['list_values']['time']){
				    	$v['value'] = strlen($v['value'])>0?$v['value']:date("Y-m-d H:i");
				    	$arr = explode(" ", $v['value']);
				    	$v['value'] = $arr[0];
				    	$arr1 = explode(":", $arr[1]);
				    	for($i=0, $hours=array(); $i<24; $i++){
				    		$hours[] = array('title'=>$i, 'value'=>$i, 'selected'=>((int)$arr1[0]==$i?1:0));
				    	}
				    	$this->tpl[$v['column_name']]->setVar('minute', $arr1[1]);
				    	$this->tpl[$v['column_name']]->setLoop('hours', $hours);
				    }
				    $v['value'] = strlen($v['value'])>0?$v['value']:date("Y-m-d");			    
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    break;
				case FRM_HTML :
				    //$v['value'] = str_replace("'", "&#039;", $v['value']);
				    //if($v['list_values']['mode'] != 'popup'){
						
						include_once(FCKDIR."fckeditor.php");
						
						$fck = new FCKeditor($v['name'], '');
						$fck->Value = $v['value'];
						$fck->ToolbarSet = $v['list_values']['toolbar'];
						$fck->Height = (isset($v['list_values']['height'])?$v['list_values']['height']:"100%");
						$fck->BasePath	= FCKBASEPATH ;
	
						$fck->Config['DlgLnkTargetTab'] = 0;
						$fck->Config['DlgLnkUpload'] = false;
						$fck->Config['DlgAdvancedTag'] = 0;
						//$fck->Config['LinkDlgHideTarget'] = true;
						//$fck->Config['LinkDlgHideAdvanced'] = true;
						//$fck->Config['LinkBrowser'] = false;
						//$fck->Config['LinkUpload'] = false;
						$fck->Config['DefaultLanguage'] = $_SESSION['admin_interface_language'];
						$fck->Config['GoogleMaps_Key'] = $GLOBALS['XML_CONFIG']['google_map_code'];
						$fck->Config['GoogleMaps_CenterLat'] = $GLOBALS['XML_CONFIG']['googlemaps_centerLat'];
						$fck->Config['GoogleMaps_CenterLon'] = $GLOBALS['XML_CONFIG']['googlemaps_centerLon'];
						$fck->Config['GoogleMaps_Zoom'] = $GLOBALS['XML_CONFIG']['googlemaps_zoom'];
						
						
					    $v['editor'] = $fck->CreateHtml();
						
					//}
					$this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    break;
				case FRM_FILE :
				case FRM_IMAGE :
					
					$this->createFileObj($v['column_name'], ($v['type']==FRM_IMAGE?"images":"files"));
					
					$v['url'] = $this->file[$v['column_name']]->url;
					
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $this->tpl[$v['column_name']]->setVar('resize_image', $this->file[$v['column_name']]->resize_image);
				    
				    $v['image_extra'] = getValueParamsImages($v['extra_params']);
				    $this->tpl[$v['column_name']]->setLoop('image_extra', $v['image_extra']);
				    
				    
				    if(strlen($v['value'])>0 && file_exists($this->file[$v['column_name']]->path.$v['value'])){
				        //echo file_exists(UPLOADDIR.$v['value']);
				        $this->tpl[$v['column_name']]->setVar('is_img', 1);
				        if(file_exists($this->file[$v['column_name']]->path.$v['image_extra'][0]['prefix'].$v['value']))
				        	$this->tpl[$v['column_name']]->setVar('show_thumbnail', 1);
				        $arr = explode(".", $v['value']);
				        $v['file_extension'] = $arr[(count($arr)-1)];
				        if(!file_exists(DOCROOT.$this->config->variable['admin_dir']."images/extension_icons/".$v['file_extension'].".ico")){
				        	$v['file_extension'] = 'default';
				        }
				    }
				    
				    
					if((int)$this->php_ini_array['upload_max_filesize']['local_value']<(int)$this->php_ini_array['post_max_size']['local_value']){
						$max_post_file_size = (int)$this->php_ini_array['upload_max_filesize']['local_value'];
					}else{
						$max_post_file_size = (int)$this->php_ini_array['post_max_size']['local_value'];
					}
					$this->tpl[$v['column_name']]->setVar('max_file_size', $max_post_file_size);
					
					if(!isset($v['list_values']['dir'])){
						$v['list_values']['dir'] = ereg_replace(DOCROOT, "", UPLOADDIR);
					}
					
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    break;
				case FRM_CHECKBOX :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    break;
				case FRM_TEXTAREA :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    break;
				case FRM_RADIO :
				case FRM_CHECKBOX_GROUP :
				case FRM_SELECT :
				    $arr = explode(" ", $v['extra_params']);
				    if(in_array("multiple", $arr)){
				    	$v['multiple'] = 1;
				    }
				   
					$this->tpl[$v['column_name']]->setVar('form_name', $this->formName);
					
					$elm_list = $this->getSelectItems($v);
					$l_arr = array();
					foreach($elm_list as $i=>$l_val){
						$l_arr[] = "<option value=\"{$l_val['value']}\" ".($l_val['checked']==1?"selected":"").">{$l_val['title']}</option>";
					}
					$v['options_list'] = implode("", $l_arr);
					
					$this->tpl[$v['column_name']]->setLoop('list', $elm_list);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    break;
				case FRM_AUTOCOMPLETE :
				    $arr = explode(" ", $v['extra_params']);
				    if(in_array("multiple", $arr)){
				    	$v['multiple'] = 1;
				    }else{
				    	$v['multiple'] = 0;
				    }
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setLoop('list', $this->main_object->call($v['list_values']['module'], "listAutocompleteValues", array($v['value'])));
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
					break;
				case FRM_PASSWORD :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    break;
				case FRM_HIDDEN :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    break;
				case FRM_SUBMIT :
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    break;
				case FRM_LIST :
					$v['value'] = $_GET['id'];
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $this->getSelectItems($v);
				    break;
				case FRM_TREE :
				    $v['property'] = $this->getTreeParams($v);
				    $this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    $this->tpl[$v['column_name']]->setVar('form_name', $this->formName);
				    break;
				case FRM_CUSTOM :
					$html_content = "";
					break;
				case FRM_SEPARATOR :
				case FRM_NUMBER :
				case FRM_FLOAT :
				case FRM_TEXT :
				default:
					$this->tpl[$v['column_name']]->setVar('elm', $v);
				    $this->tpl[$v['column_name']]->setVar('style', $this->field_style);
				    break;
		    }
		    
		    $str = $this->tpl[$v['column_name']]->parse();
		    
		    $form .= $str;
		    if($this->formHTML != ''){
				if(isset($v['id']) && is_numeric($v['id'])){
					$tpl_module_html->setVar('tpl.'.$v['column_name'], $str);
				}else{
					$otherfields .= $str;
				}
		    }
		    
		}
		//$this->tpl->setFile($this->tpl_path."main.tpl");
		
		if($this->formHTML != ''){
			$tpl_module_html->source = $this->formHTML;
			$form = $otherfields.$tpl_module_html->parse();
		} 
		
		$this->tpl_main->setVar('form.name', $this->formName);
		$this->tpl_main->setVar('form.action', $this->formAction);
		$this->tpl_main->setVar('form_content', $form);

	    $this->tpl_main->setVar('phrases', $GLOBALS['cms_phrases']['main']);
	    $this->tpl_main->setVar('config', $this->config->variable);
	    $this->tpl_main->setVar('module_config', $this->config->variable);
	    $this->tpl_main->setVar('easyweb', $_SESSION['easy']);
	    $this->tpl_main->setVar('lng', $_SESSION['site_lng']);
		
		
		
		$frm_content = $this->tpl_main->parse(1);
		
		if($this->create_in_iframe == 1){
			return $frm_content.($this->iframe_load_action!=""?$this->iframe_load_action:"<script type=\"text/javascript\"> if(parent.document.getElementById('formContent_$this->formName')) parent.document.getElementById('formContent_$this->formName').innerHTML = document.getElementById('formContent_$this->formName').innerHTML; </script>");
		}else{
			return $frm_content."<iframe src=\"\" name=\"formSumbitFrame_$this->formName\" ".($this->debug==1?"style=\"display:block;\"":"style=\"display:none;\"")." onload=\"javascript: closeLoading();\" width=\"100%\" height=\"250\"></iframe>";
		}
		
	}
	
	function createFileObj($column, $class){
		if(is_object($this->file[$column])) return false;
		$this->file[$column] = new $class();
		if(isset($this->elements[$column]['list_values']['dir']) && file_exists(DOCROOT_.$this->elements[$column]['list_values']['dir'])){
			$this->file[$column]->path = DOCROOT_.$this->elements[$column]['list_values']['dir'];
			$this->file[$column]->url = $this->config->variable['site_url'].$this->elements[$column]['list_values']['dir'];
		}elseif(isset($this->elements[$column]['list_values']['abs_dir']) && file_exists($this->elements[$column]['list_values']['abs_dir'])){
			$this->file[$column]->path = $this->elements[$column]['list_values']['abs_dir'];
		}else{
			$this->file[$column]->path = $this->imgDir;
			$this->file[$column]->url = $this->imgUrl;
		}
	}
	
	function getTreeParams($v){
	    $arr = array(); $elm_list = array();
	    if(is_array($v['list_values'])){
	    	return $v['list_values'];
	    }else{
		    $arr = split("::", $v['list_values']);
		   	foreach($arr as $key => $val){
		    	$__arr__ = explode("||", $val);
		    	$treeParams[$__arr__[0]] = $__arr__[1];
		    }
			return $treeParams;
	    }
	}
	
	function getSelectItems($v){
	    $arr = array(); $elm_list = array();
	    //$arr__ = split("}}", $v['list_values']);
	    $v['checked'] = explode("::", $v['value']);
	    if($v['list_values']['source']=="DB"){
		    if($this->tpl[$v['column_name']]) $this->tpl[$v['column_name']]->setVar('add_new_item_button', 1);
		    $record_obj = $this->main_object->create($v['list_values']['module']);
		    if($this->tpl[$v['column_name']]) $this->tpl[$v['column_name']]->setVar('select_list_module', $record_obj->module_info['table_name']);

	    	if(strlen($array_params['get_category'])>0){

	    	}
	    	if($this->tpl[$v['column_name']]) $this->tpl[$v['column_name']]->setVar('record_data_id', $this->elements['id']['value']);
	    	
		    if(isset($v['list_values']['parent_id'])&&is_numeric($v['list_values']['parent_id'])){
		    	if($this->tpl[$v['column_name']]) $this->tpl[$v['column_name']]->setVar('select_list_parent_id', $v['list_values']['parent_id']);
		    	if(strlen($v['list_values']['list_columns'])>0){
		    		$v['list_values']['list_columns'] = explode(",", $v['list_values']['list_columns']);	
		    	}else{
		    		$v['list_values']['list_columns'] = array();
		    	}
		    	//if(count($array_params['list_columns'])==0) $array_params['list_columns'] = array('title');
		    	$record_obj->getTableFields($v['list_values']['is_category']);
		    	$record_obj->sqlQueryWhere = " R.parent_id={$v['list_values']['parent_id']} AND ";
		    	$elm_list = $record_obj->listSearchItems();
		    }
		    
		    $array_relations = $record_obj->getRelations($this->config->variable['sb_relations'], $this->elements['id']['value'], $v);
		    foreach($array_relations as $val){
		    	$v['checked'][] = $val['value'];
		    }
		    $n = count($elm_list);
			for($i=0; $i<$n; $i++){
				//if(strlen($elm_list[$i]['value'])==0)
				$elm_list[$i]['value'] = $elm_list[$i]['id'];
				if(in_array($elm_list[$i]['value'], $v['checked'])){
					$elm_list[$i]['checked'] = 1;
				}else{
					$elm_list[$i]['checked'] = 0;
				}
			}
			
		}elseif($v['list_values']['source']=="ARRAY"){
		    global ${$v['list_values']['array']};
		    $arr = ${$v['list_values']['array']};
		    $n = count($arr);
		    foreach($arr as $key=>$val){
				//$arr[$i]['value'] = $arr[$i]['title'];
				if(in_array($arr[$key]['value'], $v['checked'])){
					$arr[$key]['checked'] = 1;
				}else{
					$arr[$key]['checked'] = 0;
				}
				if($arr[$key]['superadmin']!=1){
					$elm_list[] = $arr[$key];
				}
			}
		}elseif($v['list_values']['source']=="CALL"){
		    
		    $par = $v['list_values'];
		    $par['param2'] = $this->getParam($par['param2']);
		    if(!is_object($GLOBALS[$par['object']])){
		    	$GLOBALS[$par['object']] = $this->main_object->create($par['object']);
		    }
		    
		    if(method_exists($GLOBALS[$par['object']], $par['method'])){
		    	$elm_list = call_user_method($par['method'], $GLOBALS[$par['object']], $par['param1'], $par['param2'], $par['param3']);
		    }
		    
		    $n = count($elm_list);
		    //$array_relations = $record_obj->getRelations($this->config->variable['sb_relations'], $this->elements['id']['value'], $v);
		    foreach($array_relations as $val){
		    	$v['checked'][] = $val['value'];
		    }
		    $n = count($elm_list);
			for($i=0; $i<$n; $i++){
				//if(strlen($elm_list[$i]['value'])==0)
				$elm_list[$i]['value'] = $elm_list[$i]['id'];
				if(in_array($elm_list[$i]['value'], $v['checked'])){
					$elm_list[$i]['checked'] = 1;
				}else{
					$elm_list[$i]['checked'] = 0;
				}
			}
			
	    }else{		
	    
	       if(!is_array($v['list_values'])){
		    	$arr = explode("---", $v['list_values']);
		    	foreach($arr as $ev){
		    		$elm_list[] = array('value'=>$ev, 'title'=>$ev);
		    	}
		    }else{
		    	$elm_list = $v['list_values'];
		    }
		    $n = count($elm_list);
		    for($i=0; $i<$n; $i++){
				if(in_array($elm_list[$i]['value'], $v['checked']) || $elm_list[$i]['checked']==1){
					$elm_list[$i]['checked'] = 1;
				}else{
					$elm_list[$i]['checked'] = 0;
				}
			}
		}
		return $elm_list;
	}
	
	function getParam($param){
		
		if(ereg("^[\$]{1}", $param)){
			$param = ereg_replace("^[\$]{1}", "", $param);
			$arr = preg_split("/[\[\]]+/", $param);
			$new_param = $GLOBALS[$arr[0]];
			$n = count($arr);
			for($i=1; $i<$n; $i++){
				if(strlen($arr[$i])>0){
					$new_param = $new_param[$arr[$i]];
				}
			}
		}
		return $new_param;
	
	}
	
	function getDefaultValue($arr){
		
		$arr1 = explode("::", $arr['default_value']);
		foreach($arr1 as $key=>$val){
			$_a = explode("||", $val);
			$arr2[$_a[0]] = $_a[1];
		}
		if($arr2['source']=="VAR"){
			$arr2['value'] = ereg_replace("&#39;", "'", $arr2['value']);
			return parse_default_value($arr2['value']);
		}elseif($arr2['source']=="CALL"){

			if(isset($arr2['object']) && is_object($GLOBALS[$arr2['object']]) && method_exists($GLOBALS[$arr2['object']], $arr2['method'])){
				$value = call_user_method($arr2['method'], $GLOBALS[$arr2['object']], $arr);
			}
			if(isset($arr2['function']) && function_exists($arr2['function'])){
				$value = call_user_func($arr2['function'], $arr);
			}

			return $value;
		}else{
			return $arr['default_value'];
		}
		
	}
	
}

?>
