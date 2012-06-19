<?php

include_once(CLASSDIR_."basic.class.php");
include_once(CLASSDIR_."module.class.php");
class record extends basic {
    
    var $db;
    var $tables;
    var $module_info;
    var $table_fields;
    var $table_list;
    var $table;
    var $where_clause = "";
    var $shorten_texts = 0;
    
    var $path;
    
    var $data = array();
    var $imgobjects = array();
    var $xmlCfg;
    var $language = "";
    var $trash = 0;
    var $admin = array();
    var $viewAllItems = 1;
    var $Default_sqlQueryOrder = " ORDER BY R.sort_order ASC ";
    
    var $mod_actions = array('edit'=>array(), 'translate'=>array(), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array());
    
    function record($module){
        
        basic::basic();
        
        // DB tables
        $this->tables['module'] = $this->config->variable['sb_module'];
        $this->tables['module_info'] = $this->config->variable['sb_module_info'];
        $this->tables['record'] = $this->config->variable['sb_record'];
        $this->table = $this->config->variable['pr_code'].'_'.$module;
        $this->table_relations = $this->config->variable['sb_relations'];
        
        // Get module information
        $this->module_info = $this->info($module);
        // Get module table fields
        $this->getTableFields();
        
        // Module language
		$this->language = $_SESSION['site_lng'];
		
		// Administrator
		$this->admin = $_SESSION['admin'];
		
		$this->author['id'] = (isset($this->admin['id'])?$this->admin['id']:2);

		// Set default module items sort order
		if($this->module_info['no_record_table']==1 && $this->module_info['default_sort']=='R.sort_order'){
			$this->module_info['default_sort'] = "";
			$this->Default_sqlQueryOrder = "";
		}else{
			$this->Default_sqlQueryOrder = ((strlen(trim($this->module_info['default_sort']))==0)?$this->Default_sqlQueryOrder:" ORDER BY {$this->module_info['default_sort']} {$this->module_info['default_sort_direction']} ");
		}
		$this->sqlQueryOrder = $this->Default_sqlQueryOrder;
		
		$this->loadActions();
		
    	include_once(CLASSDIR."images.class.php");
    	$this->img = & new images();
		
    }
    
    function loadActions(){

    	if(file_exists(CLASSDIR."actions/actions_{$this->module_info['table_name']}.class.php")){
    		include_once(CLASSDIR."actions/actions_{$this->module_info['table_name']}.class.php");
    		$action_str = "actions_{$this->module_info['table_name']}";
    		$this->actions = & new $action_str();
    	}else{
    		include_once(CLASSDIR."actions.class.php");
    		$this->actions = & new actions($this->module_info['table_name']);
    	}

    	if(is_array($this->module_info['xml_settings'])){
    		$this->actions->mod_actions['settings'] = array();
    	}
    	
    	if($this->module_info['multilng']!=1 || count($this->config->variable['default_page'])==1){
    		unset($this->actions->mod_actions['translate']);
    	}
    	
    	$this->mod_actions = $this->actions->mod_actions;
    	
    }
    
    function info($module){
        // Load module info
        $data = $this->module->loadModuleByTablename($module);
        // Parse module xml settings
        if(strlen($data['additional_settings'])>0){
        	$data['xml_settings'] = File::xmlStringToArray(html_entity_decode($data['additional_settings']));
        }
        return $data;
    }
    
    function getTableFields(){
        
        // List module columns
        $table_fields = $this->module->listColumns($this->module_info['id']);
        $n = count($table_fields);
        for($i=0, $arr=array(), $arr1=array(); $i<$n; $i++){
        	// Parse list_values data string to array
        	$table_fields[$i]['list_values'] = $this->parseString2Array($table_fields[$i]['list_values']);
        	$table_fields[$i]['type'] = $table_fields[$i]['elm_type'];
        	if($table_fields[$i]['elm_type']==FRM_IMAGE){
        		// Parse image parametters from string to array
        		$table_fields[$i]['image_extra'] = getValueParamsImages($table_fields[$i]['extra_params']);
        	}
        	
			// Select module fields for superadmin
			$arr1[] = $table_fields[$i];
            if($table_fields[$i]['list']==1){
            	if($this->admin['permission']==1 || ($this->admin['permission']!=1 && $table_fields[$i]['super_user']!=1))
                	$arr[] = $table_fields[$i];            	
            }
            
        }
        // Create associative array
        foreach($arr1 as $key=>$val){
        	$arr2[$val['column_name']] = $val;
        }
        $this->table_list = $arr; // For items list
        $this->table_fields = $arr1; // For item data
        $this->_table_fields = $arr2; // For item data (assoc array)

    }
    
    function loadItem($id, $parent_id=0){
        
        if(!is_numeric($id) || $id<0) return false;
        
        $n = count($this->table_fields);
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= "".$this->table_fields[$i]['column_name'].", ";
        }
        
        $index_column_name = ($this->module_info['no_record_table']!=1?"record_id":"id");
        
        $sql = "SELECT $fields " .
        		" $index_column_name AS id, lng, lng_saved " .
        		" FROM $this->table " .
        		" WHERE $index_column_name=$id " .
        		($this->module_info['multilng']==1?"AND lng='$this->language'":"");
        $this->db->exec($sql);
        $data = $this->db->row();
        
        if(!empty($data)) {
            $data['isNew'] = 0;
            for($j=0; $j<$n; $j++){
        		if($this->table_fields[$j]['list_values']['source']=='DB'){
        			$relations_list = $this->getRelations($this->table_relations, $data['id'], $this->table_fields[$j], $this->language);
        			$c = count($relations_list); $value = ""; $title = "";
        			for($k=0; $k<$c; $k++){
        				$value .= $k!=0?"::":"";
        				$value .= $relations_list[$k]['value'];

        				$title .= $k!=0?";":"";
        				$title .= $relations_list[$k]['title'];
        			}
        			$data[$this->table_fields[$j]['column_name']."_list"] = $title;
        			$data[$this->table_fields[$j]['column_name']] = $value;
        		}
        	}
        	if($this->module_info['no_record_table']!=1){
		        $sql = "SELECT * FROM {$this->tables['record']} WHERE id=$id";
		        $this->db->exec($sql);
		        $arr = $this->db->row();
		        if(!empty($arr)) {
		            foreach($arr as $key=>$val) {
		            	$data[$key] = $val;
		            }
		        }
        	}
        } else {
            $data['id'] = 0;
            $data['parent_id'] = $parent_id;
            $data['isNew'] = 1;
        }
        
        return $data;
        
    }
    
    function getItemLangStatus($id){
    	if($id==0){
    		$dienied_admin_langs = $this->main_object->call("admins", "loadLanguageRights", array($_SESSION['admin']['id']));
    		foreach($this->config->variable['default_page'] as $key=>$val){
    			$arr[$key]['checked'] = (in_array($key, $dienied_admin_langs)?0:1);
    			$arr[$key]['disabled'] = 0;
    		}
    	}else{
	    	$sql = "SELECT lng_saved, lng FROM $this->table WHERE record_id=$id";
	    	$this->db->exec($sql, __FILE__, __LINE__);
	    	$l_arr = $this->db->arr();
	    	$saved_count = array();
    		foreach($this->config->variable['default_page'] as $key=>$val){
    			$arr[$key]['checked'] = 0;
    			$arr[$key]['disabled'] = 0;
    			foreach($l_arr as $l_val){
    				if($l_val['lng']==$key){
		    			$arr[$key]['checked'] = $l_val['lng_saved']==1?0:1;
		    			$arr[$key]['disabled'] = $l_val['lng_saved'];
		    			if($l_val['lng_saved']==1) $saved_count[] = $key;
		    			break;
    				}
    			}
    		}
    		$cnt = count($saved_count);
    		if($cnt==1){
    			if(!in_array($this->language, $saved_count)){
	    			foreach($arr as $key=>$val){
	    				$arr[$key]['checked'] = 0;
	    			}
    			}
    		}
    	    if($cnt>1){
    			foreach($arr as $key=>$val){
    				$arr[$key]['checked'] = 0;
    			}
    		}
    	
    	}
    	return $arr;
    }
    
    function loadItemAuthor($id){
 		
    	if($this->module_info['no_record_table']==1) return array();
    	
 		$sql = "SELECT M.* FROM {$this->tables['record']} R " .
 				" LEFT JOIN {$this->tables['module']} M ON (R.module_id=M.id) WHERE R.id=$id ";
 		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		
		if(!empty($row)){
			$author_obj = $this->main_object->create($row['table_name']);
			$author_data = $author_obj->loadItem($id);
			$author_data['module_title'] = $row['title'];
			if($row['table_name']=='admins') $author_data['title'] = $author_data['login'].", ".$author_data['firstname']." ".$author_data['lastname'];
			$data = $author_data;
		}else{
			$data['id'] = 0;
		}
		
		return $data;
			
    }
    
    function saveItem($data){
    	
        global $configFile;
        if($data['isNew']!=1){
        	if($this->loadAdminRights($this->admin['id'], $data['id'])!=1) return $data['id'];
        } else {
			if($this->module_info['disabled']==1 && is_numeric($_GET['parent_record_id']))
				if($this->loadAdminRights($this->admin['id'], $_GET['parent_record_id'])!=1) return $_GET['parent_record_id'];
			else
				if($this->loadAdminRights($this->admin['id'], $data['parent_id'])!=1) return $data['id'];
        }

        if($this->module_info['multilng']==1){
        	$languages_arr[$data['language']] = $configFile->variable['default_page'][$data['language']];
        	if(strlen($data['language_actions'])){
	        	$lang_arr = explode("::", $data['language_actions']);
	        	foreach($lang_arr as $val){
	        		$languages_arr[$val] = $configFile->variable['default_page'][$val];
	        	}
        	}
        }else{
        	$languages_arr[$configFile->variable['default_lng']] = $configFile->variable['default_page'][$configFile->variable['default_lng']];
        }

        if($this->module_info['no_record_table']==1){
        	$index_column_name = "id";
        }else{
        	$index_column_name = "record_id";
        }        
        
        if($data['isNew']==1){
            
        	if($this->module_info['no_record_table']==1){
            	$record_id = $data['id'];
            }else{
	            $sql = "SELECT IF(MAX(sort_order)+1 IS NOT NULL, MAX(sort_order)+1, 1) AS sorder FROM {$this->tables['record']} WHERE parent_id={$data['parent_id']}";
	            $this->db->exec($sql, __FILE__, __LINE__);
	            $sort = $this->db->row();
	            $sql = "INSERT INTO {$this->tables['record']} SET sort_order={$sort['sorder']}, parent_id={$data['parent_id']}, module_id={$this->module_info['id']}, create_by_ip='{$_SERVER['REMOTE_ADDR']}', create_by_admin={$this->author['id']}, create_date=NOW()";
	            $this->db->exec($sql, __FILE__, __LINE__);
	            $record_id = $this->db->last_id;
            }
            if($this->module_info['multilng']==1){
	            foreach($languages_arr as $key=>$val){
		            $sql = "INSERT INTO $this->table SET record_id=$record_id, lng='$key'";
		            $this->db->exec($sql, __FILE__, __LINE__);   
	            }
            }else{
            	if($this->module_info['no_record_table']==1){
	            	$sql = "INSERT INTO $this->table SET id=0";
		            $this->db->exec($sql, __FILE__, __LINE__);   
            		$record_id = $this->db->last_id;
            	}else{
	            	$sql = "INSERT INTO $this->table SET record_id=$record_id";
		            $this->db->exec($sql, __FILE__, __LINE__);   
            	}
            }
            
        }else{
            
            $sql = "SELECT id FROM $this->table WHERE $index_column_name={$data['id']} ".($this->module_info['multilng']==1?" AND lng='$this->language'":"");
            $this->db->exec($sql, __FILE__, __LINE__);
            if($this->db->count>0){
                $data_ = $this->db->row();
            }elseif($this->module_info['no_record_table']!=1){
                $sql = "INSERT INTO $this->table SET record_id={$data['id']} ".($this->module_info['multilng']==1?", lng='$this->language'":"");
                $this->db->exec($sql, __FILE__, __LINE__);
                $data_['id'] = $this->db->last_id;
            }
            $record_id = $data['id'];
            
        }
        
        $n = count($this->table_fields);
        //mail("vytautas@idp.lt", "sdfsd", print_r($data).print_r($_FILES));
        $non_multilng_fields=array();
        foreach($languages_arr as $key=>$val){
	        for($i=0, $fields=''; $i<$n; $i++){

            	if(($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && ($_FILES['file_'.$this->table_fields[$i]['column_name']]['size']>0)){
                    //if(is_uploaded_file($_FILES[$column_name]['tmp_name'])) $this->img->remove($data['old_'.$k]);
			    	$this->img->resize_params = $this->table_fields[$i]['image_extra'];
			    	$this->img->remove($data['old_'.$this->table_fields[$i]['column_name']]);
                }
                if(($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && (isset($data['delete_'.$this->table_fields[$i]['column_name']]))){
                	$this->img_delete($this->table_fields[$i], $data['id'], $key);
                    $data[$this->table_fields[$i]['column_name']] = '';
                }
	            if($this->table_fields[$i]['type'] == FRM_PASSWORD && $data[$this->table_fields[$i]['column_name']]==''){
                	continue;
                }                
                $fields .= $this->table_fields[$i]['column_name']."='".$data[$this->table_fields[$i]['column_name']]."', ";

                if(($this->table_fields[$i]['type'] == FRM_SELECT || $this->table_fields[$i]['type'] == FRM_CHECKBOX_GROUP || $this->table_fields[$i]['type'] == FRM_AUTOCOMPLETE || $this->table_fields[$i]['type'] == FRM_RADIO || $this->table_fields[$i]['type'] == FRM_CATEGORIES_TREE)){
                	$this->saveRelations($this->table_relations, $record_id, $data[$this->table_fields[$i]['column_name']], $this->table_fields[$i]);
                }
                
                if($this->table_fields[$i]['multilng']==0 && $key==$data['language']){
                	$non_multilng_fields[] = $this->table_fields[$i]['column_name']."='".$data[$this->table_fields[$i]['column_name']]."'";
                }


				/*
	            if($this->table_fields[$i]['multilng']==0){
	            	if(($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && ($_FILES['file_'.$this->table_fields[$i]['column_name']]['size']>0)){
	                    //if(is_uploaded_file($_FILES[$column_name]['tmp_name'])) $this->img->remove($data['old_'.$k]);
				    	$this->img->resize_params = $this->table_fields[$i]['image_extra'];
				    	$this->img->remove($data['old_'.$this->table_fields[$i]['column_name']]);
	                }
	                if(($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && (isset($data['delete_'.$this->table_fields[$i]['column_name']]))){
	                	$this->img_delete($this->table_fields[$i], $data['id'], $key);
	                    $data[$this->table_fields[$i]['column_name']] = '';
	                }
	                $fields .= $this->table_fields[$i]['column_name']."='".$data[$this->table_fields[$i]['column_name']]."', ";

	                if(($this->table_fields[$i]['type'] == FRM_SELECT || $this->table_fields[$i]['type'] == FRM_CHECKBOX_GROUP || $this->table_fields[$i]['type'] == FRM_RADIO || $this->table_fields[$i]['type'] == FRM_CATEGORIES_TREE)){
	                	$this->saveRelations($this->table_relations, $record_id, $data[$this->table_fields[$i]['column_name']], $this->table_fields[$i]);
	                }
	                
	            }elseif($key==$data['language']){
	                if(($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && ($_FILES['file_'.$this->table_fields[$i]['column_name']]['size']>0)){
	                    $this->img_delete($this->table_fields[$i], $data['id'], $key);
	                }
	                if(($this->table_fields[$i]['type'] == FRM_IMAGE || $this->table_fields[$i]['type'] == FRM_FILE) && (isset($data['delete_'.$this->table_fields[$i]['column_name']]))){
	                	$this->img_delete($this->table_fields[$i], $data['id'], $key);
	                    $data[$this->table_fields[$i]['column_name']] = '';
	                }
	                $fields .= $this->table_fields[$i]['column_name']."='".$data[$this->table_fields[$i]['column_name']]."', ";

	                if(($this->table_fields[$i]['type'] == FRM_SELECT || $this->table_fields[$i]['type'] == FRM_CHECKBOX_GROUP || $this->table_fields[$i]['type'] == FRM_RADIO || $this->table_fields[$i]['type'] == FRM_CATEGORIES_TREE)){
	                	$this->saveRelations($this->table_relations, $record_id, $data[$this->table_fields[$i]['column_name']], $this->table_fields[$i]);
	                }

	            }else{
	            	if($data['isNew'] == 1)
	            		$fields .= $this->table_fields[$i]['column_name']."='".$data[$this->table_fields[$i]['column_name']]."', ";
	            }
	            */

	        }
	        
	        if(isset($data['parent_id']) && is_numeric($data['parent_id'])){
		        $sql = "UPDATE {$this->tables['record']} SET parent_id={$data['parent_id']} WHERE id=$record_id";
		        $this->db->exec($sql, __FILE__, __LINE__);
	        }
	        
	        $this->registerLastEdit($record_id);
			
			if($this->module_info['multilng']==1){
				$sql = "SELECT * FROM $this->table WHERE record_id=$record_id AND lng='$key'";
				$this->db->exec($sql, __FILE__, __LINE__);
				$row = $this->db->row();
				if(empty($row)){
		            $sql = "INSERT INTO $this->table SET record_id=$record_id, lng='$key'";
		            $this->db->exec($sql, __FILE__, __LINE__);   
				}
			}
	        
	        $sql = "UPDATE $this->table SET $fields " .
	        		" lng=lng WHERE ".($this->module_info['multilng']==1?"lng='$key' AND":"")." $index_column_name=".$record_id."";
	        $this->db->exec($sql, __FILE__, __LINE__);
	        
	        if($this->module_info['multilng']==0 && $key==$data['language']) break;
	        
        }
        
        if(!empty($non_multilng_fields)){
	        $sql = "UPDATE $this->table SET ".implode(", ", $non_multilng_fields)." WHERE $index_column_name=$record_id";
	        $this->db->exec($sql, __FILE__, __LINE__);   
        }


        // pazymima kad sioj kalboj irasas redaguotas
        $sql = "UPDATE $this->table SET lng_saved=1 WHERE $index_column_name=$record_id ".($this->module_info['multilng']==1?" AND lng='$this->language'":"");
        $this->db->exec($sql, __FILE__, __LINE__);   
        
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->exec($sql, __FILE__, __LINE__);
        }
		
        return $record_id;
        
    }

    // import from csv
    function insertListItems($arr, $parent_id){
    	
    	if($this->loadAdminRights($this->admin['id'], $parent_id)!=1) return $parent_id;
    	
    	$n = count($arr);
    	for($i=0; $i<$n; $i++){
    		
    		$new_item = true; $data = array();
    		if(isset($arr[$i]['id']) && is_numeric($arr[$i]['id'])){
    			$item_data = $this->loadItem($arr[$i]['id'], $parent_id);
    			$new_item = ($item_data['isNew']==1?true:false);
    			$data = $item_data;
    		}
    		
    		foreach($arr[$i] as $key=>$val){
    			
    			$val = $this->db->escape($val);
    			
    			if($this->_table_fields[$key]['type'] == FRM_SELECT || $this->_table_fields[$key]['type'] == FRM_RADIO){
    				
    				$column_par = $this->_table_fields[$key]['list_values'];

    				if($column_par['module']){

	    				$list_record_obj = $this->main_object->create($column_par['module']);
	    				
	    				if(isset($column_par['list_columns']) && $column_par['list_columns']['source']=="DB"){
	    					$_arr = explode(",", $column_par['list_columns']);
	    					foreach($_arr as $k=>$v){
	    						$srt[] = " T.$v ";
	    					}
	    					$list_record_obj->sqlQueryWhere = " CONCAT(".implode(",", $srt).")='$val' AND ";
	    				}else{
	    					$list_record_obj->sqlQueryWhere = " T.title='$val' AND ";
	    				}
	    				
	    				$list_record_obj->sqlQueryWhere .= " R.parent_id={$column_par['parent_id']} AND ";
	    				$lst = $list_record_obj->listSearchItems();
	    				
	    				if(isset($lst[0]['id'])) $data[$key] = $lst[0]['id'];
    					
    				}else{
    					$data[$key] = $this->db->escape($arr[$i][$key]);
    				}
    				
    			}elseif($this->_table_fields[$key]['type'] == FRM_DATE){
    				
    				$data[$key] = str_replace(" ", "-", $this->db->escape($arr[$i][$key]));
    				
    			}else{
    				
    				$data[$key] = $this->db->escape($arr[$i][$key]);
    				
    			}
    		}
    		
    		if($new_item){
	    		$data['isNew'] = 1;
	    		$data['parent_id'] = $parent_id;
	    		$data['language'] = $this->language;
	    		
	    		foreach($this->config->variable['default_page'] as $key=>$val){
	    			$lang_arr[] = $key;
	    		}
	    		$data['language_actions'] = implode("::", $lang_arr);
	    		
    		}else{
	    		$data['isNew'] = 0;
	    		$data['id'] = $arr[$i]['id'];
	    		$data['parent_id'] = $parent_id;
	    		$data['language'] = $this->language;
    		}
    		$this->saveItem($data);
    	}

    }

    // use in saveItem when field FRM_SELECT, FRM_CHECKBOX_GROUP, FRM_RADIO, FRM_CATEGORIES_TREE
    function saveRelations($table, $id, $data, $params){
    	
    	$table = strlen($params['list_values']['relations_table'])>0?$params['list_values']['relations_table']:$table;
    	$sql = "DELETE FROM $table WHERE item_id=$id AND column_name='{$params['column_name']}'";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	if(!is_array($data)) 
    		$arr = explode("::", $data);
    	else
    		$arr = $data;
    	foreach($arr as $val){
    		if(is_numeric($val)){
	    		$sql = "SELECT COUNT(*) AS cnt FROM $table WHERE item_id=$id AND column_name='{$params['column_name']}' AND list_item_id=$val";
	    		$this->db->exec($sql, __FILE__, __LINE__);
	    		$row = $this->db->row();
	    		if($row['cnt']==0){
		    		$sql = "INSERT INTO $table SET item_id=$id, column_name='{$params['column_name']}', list_item_id=$val";
		    		$this->db->exec($sql, __FILE__, __LINE__);
	    		}
    		}
    	}
    	
    }
    
	function getRelations($table, $id, $params, $lng){
		
		$table = strlen($params['list_values']['relations_table'])>0?$params['list_values']['relations_table']:$table;
		if(isset($id) && is_numeric($id) && $id!=0){
			$arr = array();
			if(strlen($params['list_values']['list_columns'])>0 || !empty($params['list_values']['list_columns'])){
				if(is_array($params['list_values']['list_columns']))
					$arr = $params['list_values']['list_columns'];
				else
					$arr = explode(",", $params['list_values']['list_columns']);
			}
			
			$sql_str = "";
			if(strlen($params['list_values']['list_columns'])==0 || empty($params['list_values']['list_columns'])){
				$sql_str = "M.title AS title";
			}else{
				foreach($arr as $val){
					$sql_str .= " M.$val ','";
				}
				$sql_str = trim($sql_str);
				$sql_str = ereg_replace(" ", ", ", $sql_str);
				$sql_str = " CONCAT($sql_str) AS title ";
			}
			$sql = "SELECT DISTINCT(M.record_id), R.list_item_id AS value, $sql_str " .
					" FROM $table R " .
					" LEFT JOIN {$this->config->variable['pr_code']}_{$params['list_values']['module']} M " .
					" ON (M.record_id=R.list_item_id AND (M.lng='$lng' OR M.lng='' OR M.lng IS NULL)) " .
					" WHERE R.item_id=$id AND R.column_name='{$params['column_name']}'";
			$this->db->exec($sql, __FILE__, __LINE__);
			return $this->db->arr();
		}
	}
    
    function listItems($category=0){
        
        $this->sqlQueryWhere = " R.parent_id=$category AND ";
        if($this->module_info['no_record_table']!=1) $this->sqlQueryOrder = " ORDER BY R.sort_order ";
        return $this->listSearchItems();
        
    }
    
    /*function listItemsForSelect($category=0, $list_columns=array()){

		$arr = $this->listItemsElements($category, 'R.sort_order', 'ASC', 0, 100000000);
		
		$n = count($arr); $m = count($list_columns);
		for($i=0; $i<$n; $i++){
			$arr[$i]['title'] = $m>0?"":$arr[$i]['title'];
			for($j=0; $j<$m; $j++){
				$arr[$i]['title'] .= $arr[$i][$list_columns[$j]]."  ";
			}
		}
		return $arr;
    }*/
    
	function listItemsElementsCount($category=0){

        $this->sqlQueryWhere = $this->where_clause;
        if($this->module_info['no_record_table']!=1) $this->sqlQueryWhere .= " R.parent_id=$category AND ";
        $this->sqlQueryJoins = $this->JOINS;
        return $this->getCountSearchItems();

	}
	
    function setWhereClause($arr=array()){
    	$this->where_clause = "";
    	foreach($arr as $key => $val){
    		if(strlen($arr[$key]['filter_value'])==0) continue;
    		if(is_array($arr[$key]['filter_value'])){
    			$filter_value = $arr[$key]['filter_value'];
    		}else{
    			$filter_value = ereg_replace("\*", "%", $arr[$key]['filter_value']);
    		}
    		switch($arr[$key]['type']){
    			case FRM_HIDDEN :
    				$this->where_clause .= "T.{$arr[$key]['column_name']} = $filter_value AND ";
    			break;
    			case FRM_TEXTAREA :
    			case FRM_TEXT :
    				$operation = "LIKE";
    				$this->where_clause .= "T.{$arr[$key]['column_name']} $operation '%$filter_value%' AND ";
    			break;
    			case FRM_NUMBER :
    				$operation = "=";
    				if(ereg("^>", $filter_value)) $operation = ">";
    				if(ereg("^<", $filter_value)) $operation = "<";
    				if(ereg(">$", $filter_value)) $operation = "<";
    				if(ereg("<$", $filter_value)) $operation = ">";
    				if(ereg("([0-9]+)", $filter_value, $matches))
    					$this->where_clause .= "T.{$arr[$key]['column_name']} $operation {$matches[1]} AND ";
    			break;
    			case FRM_FLOAT :
    				$operation = "=";
    				if(ereg("^>", $filter_value)) $operation = ">";
    				if(ereg("^<", $filter_value)) $operation = "<";
    				if(ereg(">$", $filter_value)) $operation = "<";
    				if(ereg("<$", $filter_value)) $operation = ">";
    				if(ereg("([0-9]+[\.]{0,1}[0-9]*)", $filter_value, $matches))
    					$this->where_clause .= "T.{$arr[$key]['column_name']} $operation {$matches[1]} AND ";
    			break;
    			case FRM_DATE :
    			case FRM_DATETIME :
    				if(strlen($val['filter_value_from'])) $this->where_clause .= " T.{$arr[$key]['column_name']}>='{$val['filter_value_from']}' AND ";
	    			if(strlen($val['filter_value_to'])) $this->where_clause .= " T.{$arr[$key]['column_name']}<='{$val['filter_value_to']}' AND ";
    			break;
    			case FRM_CHECKBOX :
    				if(strlen($filter_value)){
	    				$operation = "=";
	    				$chk_where_clause = "(T.{$arr[$key]['column_name']} $operation '$filter_value') AND ";
	    				$this->where_clause .= $chk_where_clause;
    				}
    			break;
    			case FRM_RADIO :
    			case FRM_SELECT :
    			case FRM_CHECKBOX_GROUP :
    				
    				$list_values = $this->_table_fields[$arr[$key]['column_name']]['list_values'];
    				if($list_values['source']=="DB"){
	    				$operation = "LIKE";
	    				$this->where_clause .= "J1.title $operation '%$filter_value%' AND ";
	    				$this->JOINS .= " LEFT JOIN {$this->config->variable['pr_code']}_{$list_values['module']} J1 ON (J1.record_id=T.{$arr[$key]['column_name']} AND (J1.lng='' OR J1.lng IS NULL OR J1.lng='$this->language')) ";
    				}
    				break;
    				/*$operation = "=";
    				$this->JOINS .= " INNER JOIN {$this->table_relations} relation_$key " .
    								" ON (R.id=relation_$key.item_id AND relation_$key.column_name='$key') ";
    				$this->where_clause .= "relation_$key.list_item_id $operation '{$arr[$key]['value']}' AND ";*/
    			default: break;
    		}
    	}
    }
    
    function listItemsElements($category=0, $order_by='R.sort_order', $order_direction='ASC', $offset=0, $paging=30){

    	if($order_by=='') $order_by = $this->module_info['default_sort'];
    	if($order_direction=='') $order_direction = $this->module_info['default_sort_direction'];
    	
    	if($this->module_info['no_record_table']==1 && $order_by=='R.sort_order'){
    		$order_by = "";
    	}
    	
        $this->sqlQueryJoins = $this->JOINS;
        $this->sqlQueryWhere = " $this->where_clause ";
        if($this->module_info['no_record_table']!=1) $this->sqlQueryWhere .= " R.parent_id=$category AND ";
        $this->sqlQueryLimit = " LIMIT $offset, $paging ";
        if($order_by!='') $this->sqlQueryOrder = " ORDER BY $order_by $order_direction ";
        $list = $this->listSearchItems();
		
		$n = count($list);
		for($i=0; $i<$n; $i++){

			$CONTENT = ($this->module_info['catalog']==1?'catalog':$this->module_info['table_name']);
			$list[$i]['main_action'] = "main.php?content=$CONTENT&module={$this->module_info['table_name']}&page=list&id={$list[$i]['id']}";	
			$list[$i]['action'] = "main.php?content=$CONTENT&module={$this->module_info['table_name']}&page=list&id={$list[$i]['id']}#edit";
			
			$list[$i]['context'] = $this->getContextMenu($list[$i]);
			if(!isset($list[$i]['parent_id'])) $list[$i]['parent_id'] = 0;
			
		}   
		
		return $list;     

    }    

    function searchItems($searchParams=array(), $order_by='R.sort_order', $order_direction='ASC'){
    	
    	if($this->module_info['no_record_table']==1 && $order_by=='R.sort_order'){
    		$order_by = '';
    	}
    	
    	foreach($searchParams as $key => $val){
    		if($key=="parent_id")
    			$where_clause .= " R.$key='$val' AND ";
    		else
    			$where_clause .= " T.$key='$val' AND ";
    	}
        $n = count($this->table_list); $JOINS="";
        for($i=0, $fields=''; $i<$n; $i++){
            if($this->table_list[$i]['list_values']['source']=='DB'){
            	$array_params = $this->table_list[$i]['list_values'];
        		$JOINS .= "LEFT JOIN {$this->config->variable['pr_code']}_{$array_params['module']} {$array_params['module']}_$i " .
        				  " ON (T.{$this->table_list[$i]['column_name']}={$array_params['module']}_$i.record_id AND {$array_params['module']}_$i.lng='$lng') ";
        		$fields.= "{$array_params['module']}_$i.title AS {$this->table_list[$i]['column_name']}, ";
            }else{
            	$fields.= "T.".$this->table_list[$i]['column_name'].", ";
            }
        }        

        $this->sqlQueryJoins = $JOINS;
        $this->sqlQueryWhere = $where_clause;
        if($order_by!='') $this->sqlQueryOrder = " ORDER BY $order_by $order_direction ";
        return $this->getCountSearchItems();

    }    

    
    function searchItems_list($searchParams=array(), $order_by='R.sort_order', $order_direction='ASC'){
    	
    	if(strlen($order_by)==0) $order_by='R.sort_order';
    	
    	if($this->module_info['no_record_table']==1 && $order_by=='R.sort_order'){
    		$order_by = "";
    	}
    	
    	foreach($searchParams as $key => $val){
    		if($key=="parent_id")
    			$where_clause .= " R.$key='$val' AND ";
    		else
    			$where_clause .= " T.$key='$val' AND ";
    	}
        $n = count($this->table_list); $JOINS="";
        for($i=0, $fields=''; $i<$n; $i++){
            if($this->table_list[$i]['list_values']['source']=='DB'){
            	$array_params = $this->table_list[$i]['list_values'];
        		$JOINS .= "LEFT JOIN {$this->config->variable['pr_code']}_{$array_params['module']} {$array_params['module']}_$i " .
        				  " ON (T.{$this->table_list[$i]['column_name']}={$array_params['module']}_$i.record_id AND {$array_params['module']}_$i.lng='$lng') ";
        		$fields.= "{$array_params['module']}_$i.title AS {$this->table_list[$i]['column_name']}, ";
            }else{
            	$fields.= "T.".$this->table_list[$i]['column_name'].", ";
            }
        }        

        $this->sqlQueryJoins = $JOINS;
        $this->sqlQueryWhere = $where_clause;
        if($order_by!='') $this->sqlQueryOrder = " ORDER BY $order_by $order_direction ";
        $list = $this->listSearchItems();
        
        return $list;

    }  
     
    
    // 
    function getPath($id, $_data = array()){
        if($id!=0){
            $n = count($this->table_fields);
            for($i=0, $fields=''; $i<$n; $i++){
                $fields.= "".$this->table_fields[$i]['column_name'].", ";
            }            
            $sql = "SELECT R.id, R.parent_id, $fields T.lng, T.lng_saved, 1 AS not_last FROM $this->table T" .
		    		" LEFT JOIN {$this->tables['record']} R" .
		    		" ON (T.record_id=R.id)" .
		    		" WHERE R.id=$id ".($this->module_info['multilng']==1?" AND T.lng='{$this->language}' ":"")."";
		    $this->db->exec($sql, __FILE__, __LINE__);
		    
		    $row = $this->db->row();
		    $_data[] = $row;
		    
		    /*$arr = $this->db->arr();
		    $n = count($arr);
		    for($i=0; $i<$n; $i++){
			    if(empty($_data)){
			        $arr[$i]['not_last'] = 0;
			    }else{
			        $arr[$i]['not_last'] = 1;
			    }
			    $_data[] = $arr[$i];
		    }
		    $empty_arr = array('title'=>'', 'not_last'=>0, 'id'=>0);
	        if(empty($_data)){
	            $_data[] = $empty_arr;
	        }*/
		    //$_data = $new_data;
		    $this->getPath($row['parent_id'], $_data);
        }else{
            //pa($languages);
            $_data = @array_reverse($_data);
            $this->path = $_data;
            return $_data;
        }
    }
    
    // Remove item to trash 
    function delete($id){
    	
        if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
        
        if($this->module_info['no_record_table']==1){
        	$this->deleteFromTrash($id);
        }else{
	    	$sql = "UPDATE {$this->tables['record']} SET trash=1 WHERE id=$id";
	    	$this->db->exec($sql, __FILE__, __LINE__);
	
	        $this->registerLastEdit($id);
        }
        
    	
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->exec($sql, __FILE__, __LINE__);
        }
        
        return $id;
    	
    }
    
    function deleteLang($id, $lang_arr){
    	foreach($lang_arr as $val){
    		$sql = "DELETE FROM $this->table WHERE record_id=$id AND lng='$val'";
    		$this->db->exec($sql, __FILE__, __LINE__);
    	}
    	
    	// Jei istrintos visos kalbos tai ir record lentelej reikia naikint irasa
		$sql = "SELECT * FROM $this->table WHERE record_id=$id";
		$this->db->exec($sql, __FILE__, __LINE__);
		if($this->db->count==0){
    		// i siukslyne ismest nebera prasmes, tai remove nafik visai 
    		$this->deleteFromTrash($id);
		}
    }
    
    // Reset(back) item from trash
    function resetFromTrash($id){
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	
    	$sql = "UPDATE {$this->tables['record']} SET trash=0 WHERE id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);

		$this->registerLastEdit($id);	
    	
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->exec($sql, __FILE__, __LINE__);
        }
    	
    }
    
    // Delete item from DB
    function deleteFromTrash($id){
    	
    	if($id==0) return $id;
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	//pae($this->table_fields);
    	foreach($this->table_fields as $key => $val){
    		if($val['elm_type'] == FRM_IMAGE || $val['elm_type'] == FRM_FILE){
		        if($val['multilng']==1){
			        foreach($this->config->variable['default_page'] as $lng=>$lng_id){
			        	$this->img_delete($val, $id, $lng);
			        }
		        }else{
			        $this->img_delete($val, $id, $this->language);
		        }
    		}
    		if($val['elm_type'] == FRM_LIST){

				if($val['list_values']['source']=="DB"){
					$record_list_obj = $this->main_object->create($val['list_values']['module']);
					$record_list_obj->sqlQueryWhere = " T.{$val['list_values']['get_category']}=$id AND T.{$val['list_values']['get_column_name']}='{$val['column_name']}' AND ";
					$search_list = $record_list_obj->listSearchItems();
					foreach($search_list as $val){
						$record_list_obj->deleteFromTrash($val['id']);
					}
				}
    		}
    	}
    	
    	if($this->module_info['no_record_table']!=1){
        	$sql = "DELETE FROM $this->table WHERE record_id=$id";
        }else{
        	$sql = "DELETE FROM $this->table WHERE id=$id";
        }
        $this->db->exec($sql, __FILE__, __LINE__);
        
        if($this->module_info['no_record_table']!=1){
        	$sql = "DELETE FROM {$this->tables['record']} WHERE id=$id";
	        $this->db->exec($sql, __FILE__, __LINE__);
	        $sql = "SELECT id, module_id FROM {$this->tables['record']} WHERE parent_id=$id";
	        $this->db->exec($sql, __FILE__, __LINE__);
        }
        $id_arr = $this->db->arr();
        $n = count($id_arr);
        for($i=0; $i<$n; $i++){
        	if($id_arr[$i]['module_id'] != $this->module_info['id']){
        		$mod_obj = $this->main_object->call($id_arr[$i]['module_id'], 'deleteFromTrash', array($id_arr[$i]['id']));
        	}else{
        		$this->deleteFromTrash($id_arr[$i]['id']);
        	}
        }
        
        if($this->module_info['no_record_table']!=1){
	        $sql = "DELETE FROM {$this->config->variable['sb_admin_module_rights']} WHERE record_id=$id";
	        $this->db->exec($sql, __FILE__, __LINE__);
        }
        
    }
    
    // Register last editor
    function registerLastEdit($id){
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	
    	if($this->module_info['no_record_table']==1) return $id;
    	
    	$sql = "UPDATE {$this->tables['record']} SET last_modif_by_ip='{$_SERVER['REMOTE_ADDR']}', last_modif_by_admin={$this->author['id']}, last_modif_date=NOW() WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
    }
    
    function changeFieldStatus($lng, $column, $id){
        
        if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
        
        foreach($this->table_fields as $key => $val){
        	if($this->table_fields[$key]['column_name']==$column){
        		$index = $key;
        	}
        }
        if($this->table_fields[$index]['multilng']==1)
        	$sql = "UPDATE $this->table SET $column=IF($column=1, 0, 1) WHERE record_id=$id ".($this->module_info['multilng']==1?" AND lng='$lng' ":"")."";
        else
        	$sql = "UPDATE $this->table SET $column=IF($column=1, 0, 1) WHERE record_id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->exec($sql, __FILE__, __LINE__);
        }
        
        $this->registerLastEdit($id);
        
    }
    
    function updateField($id, $field, $value){
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	
    	$sql = "UPDATE $this->table set $field='$value'";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	
    	$this->registerLastEdit($id);

        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->exec($sql, __FILE__, __LINE__);
        }
    	
    }
    
    function changeOrder($lastid, $firstid){
        $sql = "SELECT sort_order, parent_id FROM {$this->tables['record']} WHERE id=$firstid";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sort1 = $this->db->row();
        $sql = "SELECT sort_order, parent_id FROM {$this->tables['record']} WHERE id=$lastid";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sort2 = $this->db->row();

        if($sort1['sort_order']>$sort2['sort_order'])
        	$sql = "UPDATE {$this->tables['record']} SET sort_order=sort_order-1 WHERE sort_order<={$sort1['sort_order']} AND sort_order>={$sort2['sort_order']} AND parent_id={$sort2['parent_id']} AND module_id={$this->module_info['id']}";//"UPDATE {$this->tables['record']} SET sort_order={$sort2['sort_order']} WHERE id=$firstid";
        else
        	$sql = "UPDATE {$this->tables['record']} SET sort_order=sort_order+1 WHERE sort_order>={$sort1['sort_order']} AND sort_order<={$sort2['sort_order']} AND parent_id={$sort2['parent_id']} AND module_id={$this->module_info['id']}";//"UPDATE {$this->tables['record']} SET sort_order={$sort2['sort_order']} WHERE id=$firstid";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sql = "UPDATE {$this->tables['record']} SET sort_order={$sort1['sort_order']} WHERE id=$lastid";
        $this->db->exec($sql, __FILE__, __LINE__);
        
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->exec($sql, __FILE__, __LINE__);
        }
    }

	function checkRecordParentId($column, $data){

		$tmp = $this->path;
		if(is_numeric($column['value'])) $this->getPath($column['value']);
		$post_value = $this->path;
		if(is_numeric($data['id'])) $this->getPath($data['id']);
		$data_value = $this->path;
		$this->path = $tmp;
		
		$index = count($data_value)-1;
		
		if($index<0) return false;
		
		if($data_value[$index]['id'] != $post_value[$index]['id']){
			return false;
		}else{
			return true;
		}
		
	}
    
    function changeParentId($id, $parent_id){
    	
    	if($this->loadAdminRights($this->admin['id'], $id)!=1) return $id;
    	
    	$sql = "UPDATE {$this->tables['record']} SET parent_id=$parent_id WHERE id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	
        if($this->module_info['cache']==1){
        	$sql = "UPDATE {$this->tables['module']} SET last_modify_time=NOW() WHERE id={$this->module_info['id']}";
        	$this->db->exec($sql, __FILE__, __LINE__);
        }
        
        $this->registerLastEdit($id);
        
    }
    
    function img_delete($column, $id, $lng){
    	
    	if(!is_numeric($id)) return false;

    	// patikrinama ar nera daugiau irasu kuriems yra priskirtas tas img
    	$sql = "SELECT {$column['column_name']} AS img FROM $this->table WHERE record_id=$id ";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$arr = $this->db->arr();

    	if(count($arr)<2 || $column['multilng']==0){
	    	$sql = "SELECT {$column['column_name']} AS img FROM $this->table WHERE record_id=$id ".($column['multilng']==1?" AND lng='$lng' ":"");
	    	$this->db->exec($sql, __FILE__, __LINE__);
	    	$row = $this->db->row();
	    	
	    	$this->img->resize_params = $column['image_extra'];
	    	$this->img->remove($row['img']);
    	}
    	
    }
    
	function checkDataExistInCategory($elm_data, $data){

		$sql = "SELECT R.id FROM {$this->tables['record']} R " .
				" LEFT JOIN $this->table T " .
				" ON (T.record_id=R.id) " .
				" WHERE R.id!={$data['id']} AND R.parent_id={$data['parent_id']} AND T.{$elm_data['column_name']}='{$elm_data['value']}' AND R.trash!=1 ";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		if(empty($row))
			return 0;
		else
			return 1;

	}

    function checkDataExist($value, $data){

    	if(isset($data['id']) && is_numeric($data['id'])){
	    	$sql = "SELECT R.id, R.trash FROM $this->table T " .
	    			" INNER JOIN {$this->tables['record']} R " .
	    			" ON (R.id=T.record_id) " .
	    			" WHERE T.{$value['column_name']}='{$value['value']}' AND T.record_id!={$data['id']} ";
	    	$this->db->exec($sql, __FILE__, __LINE__);
	    	$row = $this->db->row();
	    	if(empty($row)){
	    		return 0;
	    	}else{
	    		if($row['trash']==1){
	    			$this->deleteFromTrash($row['id']);
	    			return 0;
	    		}else{
	    			return 1;
	    		}
	    	}
    	}else{
    		return 1;
    	}
    }
	
	function loadAdminRights($admin_id, $record_id){
		
		//pae($_SESSION);
		
		global $RESTART_SESSION;
		if($RESTART_SESSION == 1) return;
		
		if(!isset($admin_id)) return 0;
		
		// always have permission to change owner account
		if($admin_id==$record_id) return 1;
		
		$sql = "SELECT * FROM {$this->config->variable['sb_record']} WHERE id=$record_id";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();

		if(is_numeric($row['module_id'])){
			$sql = "SELECT * FROM {$this->config->variable['sb_module']} WHERE id={$row['module_id']}";
			$this->db->exec($sql, __FILE__, __LINE__);
			$mod = $this->db->row();
		}
		//if($row['is_category']==0) $record_id = $row['parent_id'];
		
		// Put admin rights to array 
		$arr = strlen($this->admin['mod_rights'])?explode("::", $this->admin['mod_rights']):array();
		// If item module is disabled
		if($mod['disabled']==1 || $this->module_info['disabled']==1){
			if(in_array($_SESSION['filter_item']['list_values']['get_category']['value'], $arr)){
				return 0;
			}
		}else{
			// If module blocks then always have permission
			if($this->module_info['table_name']=='blocks'){
				return 1;
			}
			if(in_array($this->module_info['id'], $arr) && is_numeric($this->module_info['id'])){
				return 0;
			}
		}
		
		// If item is new
		if(!isset($record_id)) return 1;
		
		$sql = "SELECT * FROM {$this->config->variable['sb_admin_module_rights']} WHERE admin_id=$admin_id AND record_id=$record_id ";
		$this->db->exec($sql, __FILE__, __LINE__);
		$arr = $this->db->row();
		if(empty($arr)) return 1;
		else return 0;
		
	}
	
	function listAdminRights($rights_table, $admin_id, $module_id, $parent_id=0, $offset=0, $paging=20){

		global $RESTART_SESSION;
		if($RESTART_SESSION == 1) return;

        $n = count($this->table_fields); $fields="";
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= " T.".$this->table_fields[$i]['column_name'].", ";
        }

		$start = $offset * $paging;
		$sql = "SELECT R.parent_id, R.id, $fields U.rights, IF(U.rights IS NULL, 0, U.rights) AS prm, T.lng_saved " .
				" FROM {$this->tables['record']} R " .
				" LEFT JOIN {$this->table} T " .
				" ON (R.id=T.record_id) " .
				" LEFT JOIN $rights_table U " .
				" ON (R.id=U.record_id AND U.admin_id=$admin_id) " .
				" WHERE R.parent_id=$parent_id AND R.trash!=1 ".($this->module_info['multilng']==1?" AND T.lng='$this->language' ":"")." ";
		if($this->module_info['no_record_table']!=1) $sql .= " ORDER BY R.sort_order ASC ";
		$sql .= " LIMIT $start, $paging ";
		$this->db->exec($sql, __FILE__, __LINE__);
		$arr = $this->db->arr();
		return $arr;		
	}
	
	function getCountAdminRights($rights_table, $admin_id, $module_id, $parent_id=0){

		global $RESTART_SESSION;
		if($RESTART_SESSION == 1) return;

        $n = count($this->table_fields); $fields="";
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= " T.".$this->table_fields[$i]['column_name'].", ";
        }

		$sql = "SELECT R.parent_id, R.id, U.rights, IF(U.rights IS NULL, 0, U.rights) AS prm, T.lng_saved " .
				" FROM {$this->tables['record']} R " .
				" LEFT JOIN {$this->table} T " .
				" ON (R.id=T.record_id) " .
				" LEFT JOIN $rights_table U " .
				" ON (R.id=U.record_id AND U.admin_id=$admin_id) " .
				" WHERE R.parent_id=$parent_id AND R.trash!=1 ".($this->module_info['multilng']==1?" AND T.lng='$this->language' ":"")." ";
		$this->db->exec($sql, __FILE__, __LINE__);
		return $this->db->count;		
	}
	
	
    function getCountSearchItems(){
    	if($this->module_info['no_record_table']!=1){
    		$sql = "SELECT COUNT(DISTINCT R.id) as cnt " .
        		" FROM $this->table T " .
        		" LEFT JOIN {$this->tables['record']} R " .
        		" ON (R.id=T.record_id ".($this->module_info['multilng']==1?"AND T.lng='$this->language'":"").") " .
        		$this->sqlQueryJoins .     	
    			" WHERE R.trash!=1 AND ".$this->sqlQueryWhere." ".($this->viewAllItems==1?"1=1":"T.active=1")." ".($this->module_info['multilng']==1?" AND T.lng='$this->language' ":"");
    		
    	}else{
    		$sql = "SELECT COUNT(DISTINCT T.id) as cnt " .
        		" FROM $this->table T " .
        		$this->sqlQueryJoins .     	
    			" WHERE ".$this->sqlQueryWhere." ".($this->viewAllItems==1?"1=1":"T.active=1")." ".($this->module_info['multilng']==1?" AND T.lng='$this->language' ":"");
    		
    	}
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$row = $this->db->row();
    	return $row['cnt'];
    }
    
    function listSearchItems(){
    	
		$n = count($this->table_fields); $JOINS="";
        for($i=0, $fields=$this->fields; $i<$n; $i++){
            $fields.= "T.".$this->table_fields[$i]['column_name'].", ";
        }
        if($this->module_info['mod_pages']==81){ // if parent module 'pages' then get url & other seo
        	$this->sqlQueryJoins .= " LEFT JOIN {$this->config->variable['pr_code']}_pages PG ON (R.id=PG.record_id AND PG.lng='$this->language') ";
        	$fields .= " PG.page_url, PG.page_title, ";
        }
        if($this->module_info['no_record_table']!=1){
        	$sql = "SELECT $fields R.id, R.parent_id, R.sort_order, T.active, R.is_category, R.create_date, R.last_modif_date, T.lng, T.lng_saved, 1 AS editorship FROM {$this->tables['record']} R " .
        		" INNER JOIN $this->table T " .
        		" ON (R.id=T.record_id ".($this->module_info['multilng']==1?"AND T.lng='$this->language'":"").")" .
        		$this->sqlQueryJoins . 
				" WHERE R.trash!=1 AND ".$this->sqlQueryWhere." ".($this->viewAllItems==1?"1=1":"T.active=1")." ".($this->module_info['multilng']==1?"AND T.lng='$this->language'":"").
        		" ".$this->sqlQueryGroup.
				" ".$this->sqlQueryOrder.
        		" ".$this->sqlQueryLimit;
        }else{
        	$sql = "SELECT $fields T.id AS id, T.active, T.lng, T.lng_saved, 1 AS editorship FROM $this->table T " .
        		$this->sqlQueryJoins . 
				" WHERE ".$this->sqlQueryWhere." ".($this->viewAllItems==1?"1=1":"T.active=1")." ".($this->module_info['multilng']==1?"AND T.lng='$this->language'":"").
        		" ".$this->sqlQueryGroup.
				" ".$this->sqlQueryOrder.
        		" ".$this->sqlQueryLimit;
        }
		//echo $sql."<br>";
		
		$this->db->exec($sql, __FILE__, __LINE__);
        $arr = $this->db->arr();

        $m = count($arr);
        for($i=0; $i<$m; $i++){
        	for($j=0; $j<$n; $j++){
        		if($this->table_fields[$j]['list_values']['source']=='DB'){
        			$relations_list = $this->getRelations($this->config->variable['sb_relations'], $arr[$i]['id'], $this->table_fields[$j], $this->language);
        			$c = count($relations_list); $value = ""; $ids = "";
        			for($k=0; $k<$c; $k++){
        				$ids .= $k!=0?"::":"";
        				$value .= $k!=0?"; ":"";
        				$value .= $relations_list[$k]['title'];
        				$ids .= $relations_list[$k]['value'];
        			}
        			$arr[$i][$this->table_fields[$j]['column_name']] = $value;
        			$arr[$i][$this->table_fields[$j]['column_name'].'_ids'] = $ids;
        		}
        		if($this->table_fields[$j]['elm_type']==FRM_TEXTAREA){
        			$arr[$i][$this->table_fields[$j]['column_name']] = nl2br($arr[$i][$this->table_fields[$j]['column_name']]);
        		}
        	}
        }
        
        $this->sqlQueryJoins = "";
        $this->fields = "";
        $this->sqlQueryWhere = "";
        $this->sqlQueryOrder = $this->Default_sqlQueryOrder;
        $this->sqlQueryLimit = "";
        return $arr;
    }
    
    function getContextMenu($item){
    
    	//$p_list = $this->module->listModulesPages();
    	
		$CONTENT = ($this->module_info['tree']!=1?$this->module_info['table_name']:'catalog');
		//$item['main_action'] = "javascript: void(getContextMenuContent('$CONTENT','{$this->module_info['table_name']}','list','{$item['id']}'));";	
		//$item['action'] = "main.php?content=$CONTENT&module={$this->module_info['table_name']}&page=list&id={$item['id']}#edit";
    	
    	$z_arr = array('edit','module','delete','translate');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
    		if($_GET['page']=='filters'){
    			if($item['id']==$_SESSION[$_GET['filters']]['filter']['category_id'] && in_array($key, $z_arr)) continue;
    		}
    		$act = "getContextMenuContent(\'{$this->config->variable['site_admin_url']}\', \'$CONTENT\',\'{$this->module_info['table_name']}\',\'".(($_GET['page']=='filters')?"filters":"list")."\',\'{$item['id']}\',\'$key\'".(($_GET['page']=='filters')?",\'{$_GET['filters']}\'":"").");";
    		$context[] = array('img'=>$key, 'name'=>$key, 'title'=>$this->cmsPhrases['modules']['context_menu'][$key.'_title'], 'action'=>$act, 'main_action'=>$act);
    	}
    	/*
    	$context[] = array('img'=>($item['lng_saved']==1?'edit':'not_saved'), 'title'=>$this->cmsPhrases['modules']['context_menu']['edit'], 'action'=>$item['main_action']."#edit");
		
		$context[] = array('img'=>'new_element', 'title'=>$this->cmsPhrases['modules']['context_menu']['create_inner'], 'action'=>$item['main_action']."#new");
		//$context[] = array('img'=>'duplicate', 'title'=>$this->cmsPhrases['main']['common']['duplicate_title'], 'action'=>$item['main_action']."#new_inner");
		
		$context[] = array('img'=>'module', 'title'=>$this->cmsPhrases['modules']['context_menu']['module'], 'action'=>$item['main_action']."#module");
		
		$context[] = array('img'=>'delete', 'title'=>$this->cmsPhrases['modules']['context_menu']['delete'], 'action'=>$item['main_action']."#delete");
		*/
		
		return $context;
		
    }
    
    function listAutocompleteValues($ids){
    	$arr = explode("::", $ids);
    	$n = array();
    	foreach($arr as $val) {
    		if(is_numeric($val)) $n[] = " T.record_id=$val ";
    	}
    	if(count($n)>0){
    		$this->sqlQueryWhere = "(".implode(" OR ", $n).") AND ";
    		return $this->listSearchItems();
    	}	
    	return array();
    }

	function get_autocomplete_list($field, $code, $limit, $left=true, $right=true){
		$code = addcslashes($code, "\\'");
		$fields = explode(",", $field);
		$arr = array();
		foreach($fields as $val){
			$arr[] = "T.$val LIKE '".($left?"%":"")."$code".($right?"%":"")."'";
		}
		$this->sqlQueryWhere = "(".implode(" OR ", $arr).") AND ";
		if(is_numeric($limit)) $this->sqlQueryLimit = " LIMIT 0, $limit ";
		$list = $this->listSearchItems();
		
		foreach($list as $val){
			$list_[] = "{$val['title']} ---{$val['id']}";
		}
		
		return $list_;
	}    
    
    
}        
        
?>