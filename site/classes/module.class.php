<?php

include_once(CLASSDIR_."basic.class.php");
class module extends basic{
    
    var $table;
    var $module_fields_for_superadmin = array('parent_module', 'admin_catalog', 'multilng', 'tree', 'mod_pages', 'search', 'cache', 'forbid_delete', 'disabled', 'no_record_table');
    var $column_fields_for_superadmin = array('editable', 'superadmin', 'index', 'column_type', 'column_type_more', 'no_standart_tpl', 'field_html', 'function', 'class_method', 'error_message', 'htmlspecialchars', 'CE');
    
    function module(){

        basic::basic();
        
        $this->table = & $this->config->variable['sb_module'];
        $this->table_info = & $this->config->variable['sb_module_info'];
        $this->language = $_SESSION['admin_interface_language'];
        
        /*$sql = "EXPLAIN $this->table";
        $this->db->exec($sql, __FILE__, __LINE__);
        $arr = $this->db->arr();
        pa($arr);
        foreach($arr as $val){
        	if($val['Field']!='id') $this->table_fields[] =	$val['Field'];
        }
        $sql = "EXPLAIN $this->table_info";
        $this->db->exec($sql, __FILE__, __LINE__);
        $arr = $this->db->arr();
        pae($arr);
        foreach($arr as $val){
        	if($val['Field']!='id') $this->info_table_fields[] = $val['Field'];
        }*/
        
        $this->setModuleTableFields();
        $this->setModuleInfoTableFields();
        
        if(!isset($this->language)) $this->language = $this->config->variable['default_lng'];

    }
    
    function setModuleTableFields(){
    	$this->table_fields[] = "table_name";
    	$this->table_fields[] = "title";
    	$this->table_fields[] = "title_lt";
    	$this->table_fields[] = "title_en";
    	$this->table_fields[] = "tplico";
    	$this->table_fields[] = "multilng";
    	$this->table_fields[] = "category";
    	$this->table_fields[] = "tree";
    	$this->table_fields[] = "mod_pages";
    	$this->table_fields[] = "cache";
    	$this->table_fields[] = "mail";
    	$this->table_fields[] = "last_modify_time";
    	$this->table_fields[] = "default_sort";
    	$this->table_fields[] = "default_sort_direction";
    	$this->table_fields[] = "search";
    	$this->table_fields[] = "forbid_delete";
    	$this->table_fields[] = "forbid_sort";
    	$this->table_fields[] = "forbid_filter";
    	$this->table_fields[] = "sort_order";
    	$this->table_fields[] = "disabled";
    	$this->table_fields[] = "maxlevel";
    	$this->table_fields[] = "rss";
    	$this->table_fields[] = "additional_submit_action";
    	$this->table_fields[] = "additional_settings";
    	$this->table_fields[] = "no_standart_tpl";
    	$this->table_fields[] = "area_html";
    	$this->table_fields[] = "no_record_table";
    	$this->table_fields[] = "admin_catalog";
    	$this->table_fields[] = "html_tpl";
    	$this->table_fields[] = "parent_module";
    }

    function setModuleInfoTableFields(){
    	$this->info_table_fields[] = "module_id";
    	$this->info_table_fields[] = "title";
    	$this->info_table_fields[] = "title_lt";
    	$this->info_table_fields[] = "title_en";
    	$this->info_table_fields[] = "title_ru";
    	$this->info_table_fields[] = "description";
    	$this->info_table_fields[] = "column_name";
    	$this->info_table_fields[] = "column_type";
    	$this->info_table_fields[] = "column_type_more";
    	$this->info_table_fields[] = "elm_type";
    	$this->info_table_fields[] = "default_value";
    	$this->info_table_fields[] = "list_values";
    	$this->info_table_fields[] = "function";
    	$this->info_table_fields[] = "class_method";
    	$this->info_table_fields[] = "error_message";
    	$this->info_table_fields[] = "require";
    	$this->info_table_fields[] = "super_user";
    	$this->info_table_fields[] = "list";
    	$this->info_table_fields[] = "editable";
    	$this->info_table_fields[] = "htmlspecialchars";
    	$this->info_table_fields[] = "multilng";
    	$this->info_table_fields[] = "index";
    	$this->info_table_fields[] = "CE";
    	$this->info_table_fields[] = "lng";
    	$this->info_table_fields[] = "sort_order";
    	$this->info_table_fields[] = "field_html";
    	$this->info_table_fields[] = "extra_params";
    	$this->info_table_fields[] = "no_standart_tpl";
    }

    function listModulesPages($id){
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
    	$sql = "SELECT id, table_name, title_$lng AS title, multilng, category, tree, disabled " .
        		" FROM $this->table " .
        		" WHERE mod_pages=$id " .
        		" ORDER BY sort_order";
        $this->db->exec($sql, __FILE__, __LINE__);
        return $this->db->arr();
    }    
    
	/* kazkokie abejotino naudojimo metodai
	function listModulesTree(){
		$sql = "SELECT id, title_$this->language AS title, table_name, tplico, tree, category, multilng, disabled, maxlevel " .
				"FROM $this->table " .
				"WHERE disabled!=1 AND tree=1 " .
				"ORDER BY sort_order";
		$this->db->exec($sql);
		return $this->db->arr();
	}

	function listModulesNoTree(){
		$sql = "SELECT id, title_$this->language AS title, table_name, tplico, tree, category, multilng, disabled " .
				"FROM $this->table " .
				"WHERE disabled!=1 AND tree!=1 AND mod_pages!=1 " .
				"ORDER BY sort_order";
		$this->db->exec($sql);
		return $this->db->arr();
	}*/
    
    function listModules($sort_by="sort_order", $sort_direction="ASC"){
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
    	if($sort_by=='title') $sort_by = 'title_'.$lng;
        if($sort_by=='') $sort_by="sort_order";
        if($sort_direction=='') $sort_direction="ASC";
        $sql = "SELECT *, title_$lng AS title, 1 AS editorship FROM $this->table ORDER BY $sort_by $sort_direction";
        $this->db->exec($sql, __FILE__, __LINE__);
        return $this->db->arr();
    }

    function listAdminModules($admin_id, $sort_by="sort_order", $sort_direction="ASC"){
        $admin_modules_rights = $this->main_object->call("admins", "loadModuleRights", $admin_id);
        $items = $this->listModules($sort_by, $sort_direction);
		if($_SESSION['admin']['permission']!=1){
			$n = count($items);
			for($i=0; $i<$n; $i++){
				$items[$i]['lng_saved'] = 1;
				if($items[$i]['admin_catalog']==1 && !in_array($items[$i]['id'], $admin_modules_rights))
					$items_[] = $items[$i];
			}
		}else{
			$n = count($items);
			for($i=0; $i<$n; $i++){
				$items[$i]['lng_saved'] = 1;
				$items_[] = $items[$i];
			}
		}
        return $items_;
    }
    function getModule($id){
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
    	$sql = "SELECT *, title_$lng AS title FROM $this->table WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        return $this->db->row();
    }
    
    function loadModule($id){
        $this->data = $this->getModule($id);
    }
    
    function loadModuleByTablename($mod){
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
    	$sql = "SELECT *, title_$lng AS title FROM $this->table WHERE table_name='$mod'";
        $this->db->exec($sql, __FILE__, __LINE__);
        $this->data = $row = $this->db->row();
        return $row;
    }
    
    function changeStatus($table, $action, $id){
        
        $sql = "SELECT `$action` AS action FROM $table WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        $row = $this->db->row();
        $set = ($row['action']!=1?1:0);
        $sql = "UPDATE $table SET `$action`=$set WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
    }
    
    function changeOrder($lastid, $firstid){
        $sql = "SELECT sort_order FROM $this->table WHERE id=$firstid";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sort1 = $this->db->row();
        $sql = "SELECT sort_order FROM $this->table WHERE id=$lastid";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sort2 = $this->db->row();

        if($sort1['sort_order']>$sort2['sort_order'])
        	$sql = "UPDATE $this->table SET sort_order=sort_order-1 WHERE sort_order<={$sort1['sort_order']} AND sort_order>={$sort2['sort_order']}";
        else
        	$sql = "UPDATE $this->table SET sort_order=sort_order+1 WHERE sort_order>={$sort1['sort_order']} AND sort_order<={$sort2['sort_order']}";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sql = "UPDATE $this->table SET sort_order={$sort1['sort_order']} WHERE id=$lastid";
        $this->db->exec($sql, __FILE__, __LINE__);	
    }
    
    function saveModule($data, $default_columns=1){
        
        $data['table_name'] = strtolower($data['table_name']);
        
        if($data['isNew']==1){

			if($_SESSION['admin']['permission']!=1){
				$data['parent_module'] = 0;
				$data['admin_catalog'] = 1;
				$data['multilng'] = 1;
				$data['tree'] = 1;
				$data['mod_pages'] = 1;
				$data['search'] = 1;
				$data['cache'] = 1;
				$data['forbid_delete'] = 0;
				$data['disabled'] = 1;
				$data['no_record_table'] = 0;
				$data['no_standart_tpl'] = 0;
				$data['area_html'] = '';
				$data['additional_submit_action'] = '';
				$data['maxlevel'] = 0;
				$data['additional_settings'] = '';
			}

            //$sql = "SELECT * FROM $this->table WHERE id=";
            $sql = "SELECT MAX(sort_order) + 1 AS `new_order` FROM $this->table";
            $this->db->exec($sql, __FILE__, __LINE__);
            $row = $this->db->row();
            $data['sort_order'] = $row['new_order'];
            $sql = "CREATE TABLE `".$this->config->variable['pr_code']."_{$data['table_name']}` " .
            		"(`id` int(10) NOT NULL auto_increment, `record_id` int(10) NOT NULL default '0', " .
            		"`lng` varchar(255) default NULL, `lng_saved` tinyint(1) NOT NULL default '0', " .
            		"PRIMARY KEY  (`id`), " .
            		"KEY `record_id` (`record_id`) ) " .
            		"TYPE=MyISAM AUTO_INCREMENT=1 ;";
            $this->db->exec($sql, __FILE__, __LINE__);
            
            $arr = array();
            foreach($data as $key=>$val){
            	if(in_array($key, $this->table_fields))
            		$arr[] = " $key='".addcslashes($val, "'\\")."' ";
            }
            $str = implode(",", $arr);
            
            $sql = "INSERT INTO $this->table SET ".$str;
            $this->db->exec($sql, __FILE__, __LINE__);
            $id = $this->db->last_id;
            
            $this->saveSettings($data['additional_settings'], $id);
            
            if($default_columns==1){

	            unset($data);
				$data = array(	'module_id'=>$id, 
								'isNew'=>1, 
								'title_lt'=>'Pavadinimas',
								'title_en'=>'Title',  
								'column_name'=>'title', 
								'column_type'=>'varchar(255)', 
								'elm_type'=>'text', 
								'default_value'=>'', 
								'list_values'=>'',
								'extra_params'=>'', 
								'function'=>'', 
								'class_method'=>'', 
								'error_message'=>'', 
								'require'=>1,
								'list'=>1, 
								'editorship'=>1, 
								'htmlspecialchars'=>1, 
								'multilng'=>1, 
								'CE'=>2 );
				$this->saveColumn($data);
	
	            unset($data);
				$data = array(	'module_id'=>$id, 
								'isNew'=>1, 
								'title_lt'=>'Trumpas aprašymas',
								'title_en'=>'Short description',  
								'column_name'=>'short_description', 
								'column_type'=>'text', 
								'elm_type'=>'textarea', 
								'default_value'=>'', 
								'list_values'=>'',
								'extra_params'=>'', 
								'function'=>'', 
								'class_method'=>'', 
								'error_message'=>'', 
								'require'=>0,
								'list'=>0, 
								'editorship'=>1, 
								'htmlspecialchars'=>1, 
								'multilng'=>0, 
								'CE'=>2 );
				$this->saveColumn($data);
	
	            unset($data);
				$data = array(	'module_id'=>$id, 
								'isNew'=>1, 
								'title_lt'=>'Paveikslėlis',
								'title_en'=>'Image',  
								'column_name'=>'image', 
								'column_type'=>'varchar(255)', 
								'elm_type'=>'image', 
								'default_value'=>'', 
								'list_values'=>'',
								'extra_params'=>'prefix=thumb_||size=90x50||quality=80::prefix=||size=500x500||quality=80||water_sign=1', 
								'function'=>'', 
								'class_method'=>'', 
								'error_message'=>'', 
								'require'=>0,
								'list'=>0, 
								'editorship'=>1, 
								'htmlspecialchars'=>1, 
								'multilng'=>0, 
								'CE'=>2 );
				$this->saveColumn($data);
							
	            unset($data);
				$data = array(	'module_id'=>$id, 
								'isNew'=>1, 
								'title_lt'=>'Kaina',
								'title_en'=>'Price',  
								'column_name'=>'price', 
								'column_type'=>'decimal(10,2)', 
								'elm_type'=>'text', 
								'default_value'=>'', 
								'list_values'=>'',
								'extra_params'=>'', 
								'function'=>'function=valid_float::admin_error_msg=Wrong price', 
								'class_method'=>'', 
								'error_message'=>'', 
								'require'=>1,
								'list'=>1, 
								'editorship'=>1, 
								'htmlspecialchars'=>1, 
								'multilng'=>0, 
								'CE'=>2 );
				$this->saveColumn($data);
				            
	            unset($data);
				$data = array(	'module_id'=>$id, 
								'isNew'=>1, 
								'title_lt'=>'Aktyvus',
								'title_en'=>'Active',  
								'column_name'=>'active', 
								'column_type'=>'tinyint(1)', 
								'elm_type'=>'checkbox', 
								'default_value'=>'1', 
								'list_values'=>'',
								'extra_params'=>'', 
								'function'=>'', 
								'class_method'=>'', 
								'error_message'=>'', 
								'require'=>0,
								'list'=>1, 
								'editorship'=>1, 
								'htmlspecialchars'=>1, 
								'multilng'=>0, 
								'CE'=>2);
				$this->saveColumn($data);
	
	            unset($data);
				$data = array(	'module_id'=>$id, 
								'isNew'=>1, 
								'title_lt'=>'Submit',
								'title_en'=>'Submit',  
								'column_name'=>'submit', 
								'column_type'=>'tinyint(1)', 
								'elm_type'=>'submit', 
								'default_value'=>'', 
								'list_values'=>'',
								'extra_params'=>'', 
								'function'=>'', 
								'class_method'=>'', 
								'error_message'=>'', 
								'require'=>0,
								'list'=>0, 
								'editorship'=>0, 
								'htmlspecialchars'=>0, 
								'multilng'=>0,
								'CE'=>2);
				$this->saveColumn($data);
            	
            }

        }else{
            $sql = "SELECT table_name FROM $this->table WHERE id={$data['id']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            $row = $this->db->row();
            $sql = "ALTER TABLE `".$this->config->variable['pr_code']."_{$row['table_name']}` RENAME `".$this->config->variable['pr_code']."_{$data['table_name']}`";
            $this->db->exec($sql, __FILE__, __LINE__);
            
            $arr = array();
            foreach($data as $key=>$val){
            	if(in_array($key, $this->table_fields))
            		$arr[] = " $key='".addcslashes($val, "'\\")."' ";
            }
            $str = implode(",", $arr);
            
            $sql = "UPDATE $this->table SET ".$str." WHERE id={$data['id']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            $id = $data['id'];
            
            $this->saveSettings($data['additional_settings'], $id);
            
        }
        
        return $id;
        
    }
    
    function saveSettings($str, $module_id){
        $sql = "UPDATE $this->table " .
        		"SET additional_settings='".addcslashes($str, "'\\")."' WHERE id=$module_id";
        $this->db->exec($sql, __FILE__, __LINE__);
    }
    
    function importModule($data){
    	
    	$mod = $this->loadModuleByTablename($data['table_name']);
    	
    	if(!empty($mod)){
    		$data['isNew'] = 0;
    		$data['id'] = $mod['id'];
    	}else{
    		$data['isNew'] = 1;
    	}
    	
    	$id = $this->saveModule($data, 0);
    	
    	foreach($data['module_columns'] as $i=>$val){
    		if($data['isNew']==1){
    			$val['isNew'] = 1;
    			$val['module_id'] = $id;
    		}else{
    			$val['isNew'] = 1;
    			$val['module_id'] = $id;
    			
    			$columns = $this->listColumns($id);
    			foreach($columns as $j=>$column_val){
    				if($column_val['column_name']==$val['column_name']){
    					$val['id'] = $column_val['id'];
    					$val['isNew'] = 0;
    					break;
    				}
    			}
    		}    		
    		$this->saveColumn($val);
    	}
    	
    }
    
    function deleteModule($id){
        $sql = "SELECT table_name FROM $this->table WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        $row = $this->db->row();

        $sql = "SELECT id FROM {$this->config->variable['pr_code']}_record WHERE module_id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        $arr = $this->db->arr();
        foreach($arr as $key=>$val){
	        $sql = "DELETE FROM {$this->config->variable['sb_admin_module_rights']} WHERE record_id={$val['id']}";
	        $this->db->exec($sql, __FILE__, __LINE__);
		}

        $sql = "DELETE FROM {$this->config->variable['pr_code']}_record WHERE module_id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sql = "DELETE FROM $this->table_info WHERE module_id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sql = "DROP TABLE ".$this->config->variable['pr_code']."_{$row['table_name']}";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sql = "DELETE FROM $this->table WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
    }
    
    function loadColumn($id){
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
    	$sql = "SELECT *, title_$lng AS title FROM $this->table_info WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        return $this->data = $this->db->row();        
    }
    
    function listColumns($module_id, $sort_by="sort_order", $sort_direction="ASC"){
    	$lng = $this->language;
        if($this->language!='lt') $lng = "en"; 
    	if($sort_by=='title') $sort_by = "title_".$lng;
        $sql = "SELECT *, title_$lng AS title, 1 AS lng_saved, module_id AS parent_id, 1 AS editorship FROM $this->table_info WHERE module_id=$module_id ORDER BY $sort_by $sort_direction";
        $this->db->exec($sql, __FILE__, __LINE__);
        return $this->db->arr();
    }
    
    function saveColumn($data){
        
        $mod = $this->getModule($data['module_id']);
        
        if($data['isNew']==1){
			
			if($_SESSION['admin']['permission']!=1){
				$data['editorship'] = 1;
				$data['htmlspecialchars'] = 0;
				$data['super_user'] = 0;
				$data['function'] = '';
				$data['class_method'] = '';
				$data['error_message'] = '';
				$data['CE'] = 2;
				$data['no_standart_tpl'] = 0;
				$data['field_html'] = '';
			}
			
			$sql = "SELECT IF(MAX(sort_order)+1 IS NOT NULL, MAX(sort_order)+1, 1) AS sorder FROM $this->table_info WHERE module_id={$data['module_id']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            $sort = $this->db->row();
            $data['sort_order'] = $sort['sorder'];
            
            $sql = "ALTER TABLE `".$this->config->variable['pr_code']."_{$mod['table_name']}` ADD `{$data['column_name']}` {$data['column_type']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            
            $arr = array();
            foreach($data as $key=>$val){
            	if(in_array($key, $this->info_table_fields))
            		$arr[] = " `$key`='".addcslashes($val, "'\\")."' ";
            }
            $str = implode(",", $arr);
           	$sql = "INSERT INTO $this->table_info SET $str";
            $this->db->exec($sql, __FILE__, __LINE__);
            $id = $this->db->last_id;
            
            return $id;
            
        }else{
            
            $sql = "SELECT column_name FROM $this->table_info WHERE id={$data['id']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            $row = $this->db->row();
            $sql = "ALTER TABLE `".$this->config->variable['pr_code']."_{$mod['table_name']}` CHANGE `{$row['column_name']}` `{$data['column_name']}` {$data['column_type']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            $arr = array();
            foreach($data as $key=>$val){
            	if(in_array($key, $this->info_table_fields))
            		$arr[] = " `$key`='".addcslashes($val, "'\\")."' ";
            }
            $str = implode(",", $arr);
            $sql = "UPDATE $this->table_info " .
            		"SET $str WHERE id={$data['id']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            
            return $data['id'];
            
        } 
               
    }

    function deleteColumn($id){
        $sql = "SELECT I.column_name, T.table_name FROM $this->table_info I LEFT JOIN $this->table T ON (I.module_id=T.id) WHERE I.id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        $row = $this->db->row();
        $sql = "DELETE FROM $this->table_info WHERE id=$id";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sql = "ALTER TABLE ".$this->config->variable['pr_code']."_{$row['table_name']} DROP {$row['column_name']}";
        $this->db->exec($sql, __FILE__, __LINE__);
    }
    
    function changeColumnsOrder($lastid, $firstid){
        $sql = "SELECT sort_order, module_id FROM $this->table_info WHERE id=$firstid";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sort1 = $this->db->row();
        $sql = "SELECT sort_order, module_id FROM $this->table_info WHERE id=$lastid";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sort2 = $this->db->row();

        if($sort1['sort_order']>$sort2['sort_order'])
        	$sql = "UPDATE $this->table_info SET sort_order=sort_order-1 WHERE sort_order<={$sort1['sort_order']} AND sort_order>={$sort2['sort_order']} AND module_id={$sort2['module_id']}";
        else
        	$sql = "UPDATE $this->table_info SET sort_order=sort_order+1 WHERE sort_order>={$sort1['sort_order']} AND sort_order<={$sort2['sort_order']} AND module_id={$sort2['module_id']}";
        $this->db->exec($sql, __FILE__, __LINE__);
        $sql = "UPDATE $this->table_info SET sort_order={$sort1['sort_order']} WHERE id=$lastid";
        $this->db->exec($sql, __FILE__, __LINE__);	
    }
        
    function listAdminRights($rights_table, $id){
    	
    	return $this->listAdminModules($id);
    	
    	/*
    	sitas paseno lentele cms_admin_module_rights nebenaudojama, vietoj jos yra admins lenteles laukas mod_rights
    	$sql = "SELECT IF(rights IS NULL, 0, rights) AS prm FROM $rights_table " .
    			" WHERE admin_id=$id ";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$arr = $this->db->arr();
    	return $arr;
    	*/
    }
    
    function listSoapUsersRights($rights_table, $id){
    	$list = $this->listAdminRights($rights_table, $id);
    	foreach($list as $val){
    		if($val['table_name']!='soap_users' && $val['table_name']!='admins'){
    			if($val['rights']!=0) $val['readonly'] = 1;
    			$list_[] = $val;
    		}
    	}
    	return $list_;
    }
    
    function saveAdminRights($rights_table, $data){
    	foreach($data['module'] as $key=>$val){
    		$sql = "SELECT id FROM $rights_table WHERE admin_id={$data['admin_id']} AND module_id=$key";
    		$this->db->exec($sql, __FILE__, __LINE__);
    		$row = $this->db->row();
    		if(empty($row)){
    			$sql = "INSERT INTO $rights_table SET admin_id={$data['admin_id']}, rights={$data['module'][$key]}";
    			$this->db->exec($sql, __FILE__, __LINE__);
    		}else{
    			$sql = "UPDATE $rights_table SET rights={$data['module'][$key]} WHERE admin_id={$data['admin_id']}";
    			$this->db->exec($sql, __FILE__, __LINE__);
    		}
    	}
    }
    
    function loadAdminModuleRights($rights_table, $admin_id, $mod){
    	$module = $this->loadModuleByTablename($mod);
    	$sql = "SELECT rights FROM $rights_table WHERE admin_id=$admin_id AND module_id={$module['id']}";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$row = $this->db->row();
    	return $row['rights'];
    }
    
    function checkExistColumnName($value, $data){
    	
		$value = strtolower($value['value']);
		
		$mod = $this->getModule($data['module_id']);
		$table_name = $this->config->variable['pr_code']."_".$mod['table_name'];
		
    	if($data['isNew']==1){
    		
    		$result = mysql_list_fields($this->config->variable['database'], $table_name);
    		$columns = mysql_num_fields($result);
			for ($i = 0; $i < $columns; $i++) {
				$arr_tbl[] = mysql_field_name($result, $i);
			}
			if(in_array($value, $arr_tbl)){
				return true;
			}
    		
    	}else{
    		
    		$sql = "SELECT * FROM $this->table_info WHERE column_name='$value' AND module_id={$data['module_id']}";
            $this->db->exec($sql, __FILE__, __LINE__);
            $row = $this->db->row();
            if(!empty($row)){
    			if($row['id']!=$data['id']){
    				return true;
    			}	
    		}else{
	    		$result = mysql_list_fields($this->config->variable['database'], $table_name);
	    		$columns = mysql_num_fields($result);
				for ($i = 0; $i < $columns; $i++) {
					$arr_tbl[] = mysql_field_name($result, $i);
				}
				if(in_array($value, $arr_tbl)){
					return true;
				}
    		}
    		
    	}
    	
    	return false;
    
    }

    function checkExistTableName($value, $data){
		
		$value = strtolower($value['value']);
		
    	if($data['isNew']==1){
    		
    		$table_name = $this->config->variable['pr_code']."_".$value;
    		$result = mysql_list_tables($this->config->variable['database']);
    		while ($row = mysql_fetch_row($result)) {
				$arr_tbl[] = strtolower($row[0]);
			}
			if(in_array($table_name, $arr_tbl)){
				return true;
			}
    		
    	}else{
    		
    		$sql = "SELECT * FROM $this->table WHERE table_name='$value'";
            $this->db->exec($sql, __FILE__, __LINE__);
            $row = $this->db->row();
            if(!empty($row)){
    			if($row['id']!=$data['id']){
    				return true;
    			}	
    		}else{
	    		$table_name = $this->config->variable['pr_code']."_".$value;
	    		$result = mysql_list_tables($this->config->variable['database']);
	    		while ($row = mysql_fetch_row($result)) {
					$arr_tbl[] = strtolower($row[0]);
				}
				if(in_array($table_name, $arr_tbl)){
					return true;
				}
    		}
    		
    	}
    	
    	return false;
    	
    }

    
}
        
?>
