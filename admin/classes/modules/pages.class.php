<?php

include_once(CLASSDIR."record.class.php");
class pages extends record {
	
	//var $mod_actions = array('module'=>array(), 'edit'=>array(), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array());
	
	function pages($module){
		
		$config = & $GLOBALS['configFile'];
		
		record::record($module);
		
		$this->table_text = $config->variable['sb_text'];
		$this->table_tpl = $config->variable['sb_template'];
		
	}
	
	function loadItem($id){
		$data = record::loadItem($id);
		if($this->xml_config['lng_in_url']==1) $data['page_url'] = $this->language.$data['page_url'];
		return $data;
	}
	
	function loadList($parent_id = 0){
		return $this->listAdminRights($this->config->variable['sb_admin_pages_rights'], $_SESSION['admin']['id'], $parent_id);
	}
	
	/*function getPath($id, $arr = array()){
		$sql = "SELECT id, parent_id, title FROM $this->table WHERE id=$id";
		$this->db->exec($sql);
		$row = $this->db->row();
		if(!empty($row)) $arr[] = $row;
		if($row['parent_id']!=0){
			$this->getPath($row['parent_id'], $arr);
		}else{
			$new_arr = array_reverse($arr);
			$GLOBALS['id_path'] = $new_arr;
		}
	}*/
	
	function loadHTML($page_id, $area_id){
		$sql = "SELECT text FROM $this->table_text WHERE page_id=$page_id AND area=$area_id";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		return $row;
	}

	function saveHTML($page_id, $area_id, $html){
		
	    if($this->loadAdminRights($this->admin['id'], $page_id)!=1) return $page_id;
	    
		$sql = "SELECT id FROM $this->table_text WHERE page_id=$page_id AND area=$area_id";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		if(empty($row)){
			$html = stripslashes($html);
			$html = addcslashes($html, "'");
			$sql = "INSERT INTO $this->table_text SET text='$html', page_id=$page_id, area=$area_id";
			$this->db->exec($sql, __FILE__, __LINE__);		
		}else{
			$html = stripslashes($html);
			$html = addcslashes($html, "'");
			$sql = "UPDATE $this->table_text SET text='$html' WHERE page_id=$page_id AND area=$area_id";
			$this->db->exec($sql, __FILE__, __LINE__);
		}
	}
	
	function getModulePageId($lng_id, $module){
		$path = $GLOBALS['id_path'];
		$sql = "SELECT P.id FROM $this->table_tpl T " .
				"LEFT JOIN $this->table P " .
				"ON (T.id=P.template) " .
				"WHERE T.name='$module'";
		$this->db->exec($sql, __FILE__, __LINE__);
		$ids = $this->db->arr();
		$n = count($ids);
		for($i=0; $i<$n; $i++){
			$this->getPath($ids[$i]['id']);
			if($GLOBALS['id_path'][0]['id']==$lng_id){
				return $ids[$i]['id'];
			}
		}
	}
	
	function loadTree($id, $tree=array(), $level=0, $index=-1){
		$sql = "SELECT id, parent_id, title, template, page_redirect, $level AS level, 0 AS sub, module_id, disabled, page_url, last_modif_date " .
				" FROM {$this->table} WHERE parent_id=$id ORDER BY order_id";
		$this->db->exec($sql, __FILE__, __LINE__);
		$arr = $this->db->arr();
		$n = count($arr);
		if($index!=-1){
			$tree[$index]['sub'] = ($n>0?1:0);
			$tree[$index]['space'] = str_repeat("&nbsp;", ($level-2)*4);
			$tree[$index]['opt_space'] = str_repeat("&nbsp;", ($level-1)*6);
		}
		for($i=0; $i<$n; $i++){
			$index = count($tree);
			$tree[$index] = $arr[$i];
			$this->loadTree($arr[$i]['id'], &$tree, ++$level, $index);
			--$level;
		}
		return $tree;
	}

	function saveItem($data){
		
		if($data['isNew'] != 1){
			$sql = "SELECT page_url FROM $this->table WHERE record_id={$data['id']} AND lng='$this->language'";
			$this->db->exec($sql, __FILE__, __LINE__);
			$row = $this->db->row();
			$old_link = $row['page_url'];
		}
		
		if($this->xml_config['lng_in_url']==1) $data['page_url'] = substr($data['page_url'], 2);
		
		if($data['generate_page_title']==1){
			$data['page_title'] = $data['title'];
		}
		if($data['generate_header_title']==1){
			$data['header_title'] = $data['title'];
		}
		
		$id = record::saveItem($data);
		
		/*
		pa($data);
		$this->loadItem($id);
		pae($this->data);
		*/
		
		if($data['generate_url']==1){

			if(isset($data['isNew']) && $data['isNew']==1){
				$title = $data['title'];
				$page_url = $this->generateUrl($id, $title)."/";
				$sql = "UPDATE $this->table SET page_url='$page_url' WHERE record_id=$id";
				$this->db->exec($sql, __FILE__, __LINE__);
				$data['page_url'] = $page_url;
			}else{
				$title = $data['title'];
				$page_url = $this->generateUrl($data['id'], $title)."/";
				$sql = "UPDATE $this->table SET page_url='$page_url' WHERE record_id=$id AND lng='$this->language'";
				$this->db->exec($sql, __FILE__, __LINE__);
				$data['page_url'] = $page_url;
			}
		}
		
		/*// reikia persaugot i kitoki URL kitose kalbose
		if($data['isNew'] != 1){
			foreach(){
				
			}
		}else{
		// persaugot vidiniu puslapiu url
			$this->replaceInnerPageUrls($data['id'], $old_link, $data['page_url']);
		}*/
		
		if($data['isNew'] != 1 && $data['page_url']!="") $this->replaceOldLinks($this->language.$old_link, $this->language.$data['page_url']);
		//pae($data);
	
		if($this->xml_config['toggler']==1) $this->generateSEO($data);
		
		return $id;
		
	}
	
	function replaceOldLinks($old_link, $new_link){
		if($old_link != $new_link){
			$mod_list = $this->module->listModules();
			foreach($mod_list as $val){
				$table_fields = $this->module->listColumns($val['id']);
				foreach($table_fields as $t_val){
					if($t_val['elm_type']==FRM_HTML){
						$sql = "UPDATE {$this->config->variable['pr_code']}_{$val['table_name']} SET {$t_val['column_name']}=REPLACE({$t_val['column_name']}, '$old_link', '$new_link')";
						$this->db->exec($sql, __FILE__, __LINE__);
					}
				}
			}
		}
	}
	
	function replaceLetters($str) {

		$str = ereg_replace("&#39;", "'", $str);
		$str = ereg_replace("[\'\<\>\"{`\!\%\(\);\{\}\+\-\*\&\#]", "-", $str);
		$str = ereg_replace("[\-]{1,}", "-", $str);

		$search_arr = array	("#", "ą", "č", "ę", "ė", "į", "š", "ų", "ū", "ž", " ", /* LT */ 
							"й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ", "э", "ж", "д", "л", "о", "р", "п", "а", "в", "ы", "ф", "я", "ч", "с", "м", "и", "т", "ь", "б", "ю", /* Russki */
							"ī", "ņ", "ā", "ē", "ļ", "ģ", /* Latviesu */
							"ä", "ö", "ü", "õ", "å", /* Eesti Swedish Suomi */
							"ç", "ë", "í", "ñ", "é", "è", "á", "à",  
							"ć", "ł", "ń", "ó", "ś", "ź", "ż", /* Poland */
							"ß", /* Deutche unliaut */
							"æ", "ø", "ê", "ò", "â", "ô" /* Norway */
							);
							
		$replace_arr = array("-", "a", "c", "e", "e", "i", "s", "u", "u", "z", "-", 
							"j", "c", "u", "k", "e", "n", "g", "s", "t", "z", "x", "j", "e", "z", "d", "l", "o", "r", "p", "a", "v", "i", "f", "a", "h", "s", "m", "i", "t", "j", "b", "j",
							"i", "n", "a", "e", "l", "g",
							"a", "o", "u", "o", "a", /* Eesti Swedish Suomi */
							"c", "e", "i", "n", "e", "e", "a", "a",  
							"c", "l", "n", "o", "s", "z", "z", /* Poland */
							"s", /* Deutche unliaut */
							"e", "o", "e", "o", "a", "o" /* Norway */
							);

		$str = stripslashes(mb_strtolower($str, "utf-8"));
		$n = mb_strlen($str, "utf-8");
		for ($i = 0; $i < $n; $i ++) {
			$let = mb_substr($str, $i, 1, "utf-8");
			if (in_array($let, $search_arr)) {
				$key = array_search($let, $search_arr);
				$str = mb_substr($str, 0, $i, "utf-8").$replace_arr[$key].mb_substr($str, $i +1, $n - $i, "utf-8");
			}
			elseif (preg_match("/[0-9a-zA-Z_.,-]/", $let) == 0) { //neatitinka
				$str = mb_substr($str, 0, $i, "utf-8").mb_substr($str, $i +1, $n - $i, "utf-8");
				$n --;
			}
		}
		$str = preg_replace("/\s/", "", $str);
		$str = ereg_replace("\.", "", $str);
		$str = ereg_replace(",", "", $str);
		$str = preg_replace("/-{2,}/", "-", $str);
		return $str;
	}

	function generateUrl($page_id, $title) {
		
		if ($page_id != '' && $page_id != 0) {

			$page_data = record::loadItem($page_id);
			$parent_id = $page_data['parent_id'];

			$url = $this->replaceLetters($title);
			$page_data = record::loadItem($parent_id);
			$parent_url = (substr($page_data['page_url'], strlen($page_data['page_url'])-1)=="/"?$page_data['page_url']:$page_data['page_url']."/");
			//$title = $page_data['title'];
			$url = ($page_data['parent_id']!=0?$parent_url:"/").$url;
			$url = $this->checkUrl($url, $page_id);

		}
		return $url;
		
	}
	
	function checkUrl($url, $id=0){
		$sql = "SELECT id FROM $this->table WHERE page_url='$url/' AND record_id!=$id AND lng='$this->language'";
		$this->db->exec($sql, __FILE__, __LINE__);
		if($this->db->count>0){
			$url .= "_";
			$url = $this->checkUrl($url, $id);
		}
		else
			return $url;
		
		return $url;
	}
	
	function validateUrl($url, $data=array()){
		
		if($data['generate_url']!=1){
			$error=0;
			if(isset($data['id'])&&is_numeric($data['id'])){
				$sql = "SELECT * FROM $this->table WHERE page_url='{$url['value']}' AND record_id!={$data['id']} AND lng='$this->language'";
			}else{
				$sql = "SELECT * FROM $this->table WHERE page_url='{$url['value']}' AND lng='$this->language'";
			}
			$this->db->exec($sql, __FILE__, __LINE__);
			$row = $this->db->row();
			if(!empty($row)) $error = 1;
			return $error;
		}

	}

/*	
    function checkRightsRecursive($id){

	    $admin_rights = $this->loadAdminPageRights($_SESSION['admin']['id'], $id);
	    if($admin_rights['rights']==1){ $this->arr = array(); return false; }

        $this->arr[] = "DELETE FROM $this->table_text WHERE page_id=$id";
        $this->arr[] = "DELETE FROM $this->table WHERE id=$id";
        $this->arr[] = "DELETE FROM {$this->config->variable['sb_admin_pages_rights']} WHERE page_id=$id";

        $sql = "SELECT id FROM $this->table WHERE parent_id=$id";
        $this->db->exec($sql);
        $id_arr = $this->db->arr();
        $n = count($id_arr);
        for($i=0; $i<$n; $i++){
        	$this->checkRightsRecursive($id_arr[$i]['id']);
        }
        
    }
*/    
    
	///// TEMPLATES
	function deleteTemplate($tplID){
		$sql = "DELETE FROM $this->table_tpl WHERE id=$tplID";
		$this->db->exec($sql, __FILE__, __LINE__);
	}

	function statusTemplate($tplID){
		$sql = "UPDATE $this->table_tpl SET disabled=IF(disabled=1, 0, 1) WHERE id=$tplID";
		$this->db->exec($sql, __FILE__, __LINE__);
	}
	
	function getTemplatesList(){
		$sql = "SELECT id, CONCAT(id, ' - ', name) AS title, IF(disabled=1, 0, 1) AS active, name, defaultas, 1 AS editorship FROM $this->table_tpl";
		$this->db->exec($sql, __FILE__, __LINE__);
		$arr = $this->db->arr();
		return $arr;
	}

	function getTemplatesList_(){
		$sql = "SELECT name AS id, CONCAT(id, ' - ', name) AS title FROM $this->table_tpl WHERE disabled!=1";
		$this->db->exec($sql, __FILE__, __LINE__);
		$arr = $this->db->arr();
		return $arr;
	}

	function getTemplateById($tplID){
		$sql = "SELECT id, name, file1, tmpl_image_map, defaultas FROM $this->table_tpl WHERE id='$tplID'";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		return $row;
	}
	
	function getTemplate($tplID){
		$sql = "SELECT id, name, file1, tmpl_image_map, defaultas FROM $this->table_tpl WHERE name='$tplID'";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		return $row;
	}
	
	function saveTemplate($data){
		if(isset($data['isNew']) && $data['isNew']==1){
			$sql = "INSERT INTO $this->table_tpl SET name='{$data['name']}', file1='{$data['file1']}', tmpl_image_map='{$data['tmpl_image_map']}', defaultas='{$data['defaultas']}'";
			$this->db->exec($sql, __FILE__, __LINE__);
			$data['id'] = $this->db->last_id;
		}else{
			$sql = "UPDATE $this->table_tpl SET name='{$data['name']}', file1='{$data['file1']}', tmpl_image_map='{$data['tmpl_image_map']}', defaultas='{$data['defaultas']}' WHERE id={$data['id']}";
			$this->db->exec($sql, __FILE__, __LINE__);
		}	
		if($data['defaultas']==1){
			$sql = "UPDATE $this->table_tpl SET defaultas=0 WHERE id!={$data['id']}";
			$this->db->exec($sql, __FILE__, __LINE__);
		}
		return $data['id'];	
	}
	
	function generateSEO($page_data){

		if($page_data['generate_keywords']==1 || $page_data['generate_description']==1){

			$curlVar = curl_init($this->config->variable['site_url'].$this->language.$page_data['page_url']);
			curl_setopt(CURLOPT_RETURNTRANSFER, 0);
			curl_exec($curlVar);
			curl_close($curlVar);
			$string = ob_get_contents();
			ob_clean();

			include_once(CLASSDIR_."seo.class.php");
			$seo_obj = new seo();

		}
		
		if($page_data['generate_keywords']==1){

			$keywords_arr = $seo_obj->getKeywords($string);
					
			$keywords = addcslashes(implode(", ", $keywords_arr), "\\'");
			
			$sql = "UPDATE $this->table SET keywords='$keywords' WHERE record_id={$page_data['id']} AND lng='$this->language'";
			$this->db->exec($sql, __FILE__, __LINE__);
			
			$page_data['keywords'] = $keywords;
			
		}
		
		if($page_data['generate_description']==1){

			$description = addcslashes($seo_obj->getDescription($string, $page_data, $this->getPageBlocks($page_data['id'])), "\\'");
					
			$sql = "UPDATE $this->table SET description='$description' WHERE record_id={$page_data['id']} AND lng='$this->language'";
			$this->db->exec($sql, __FILE__, __LINE__);
			
			$page_data['description'] = $description;
			
		}		
		
	}
	
	function getPageBlocks($page_id){
    	$blocks_obj = $this->main_object->create("blocks");
    	$blocks_obj->sqlQueryWhere = " page_id=$page_id AND ";
    	$arr = $blocks_obj->listSearchItems();
    	foreach($arr as $val){
    		$blocks[] = $val['title'];
    	}
    	return $blocks;
	}
	
	function getPagesTree($id, $selected=0){
		$this->sqlQueryWhere = " R.parent_id=$id AND ";
		$list = $this->listSearchItems();
		foreach($list as $i=>$val){
			$this->sqlQueryWhere = " R.parent_id={$val['id']} AND ";
			if(isset($selected) && is_numeric($selected)) $this->fields = " IF(R.id=$selected, 1, 0) AS selected, ";
			$list[$i]['sub'] = $this->listSearchItems();
		}
		return $list;
	}
	
	function listModulesPages(){
		return $this->module->listModulesPages($this->module_info['id']);
	}

    function getContextMenu($item){
    
		$CONTENT = ($this->module_info['tree']!=1?$this->module_info['table_name']:'catalog');
    	
    	$z_arr = array('edit','module','delete','fields','translate');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
    		if($item['parent_id']==0 && $_SESSION['admin']['permission']!=1 && $key=='delete') continue;
    		if($key=='fields' && ($item['template']!='products' || ($item['template']=='products' && (/*$item['parent_id']==3757 || */$item['id']==3757)))) continue;
    		$act = "getContextMenuContent(\'{$this->config->variable['site_admin_url']}\', \'$CONTENT\',\'{$this->module_info['table_name']}\',\'list\',\'{$item['id']}\',\'$key\');";
    		$context[] = array('img'=>(isset($val['img'])?$val['img']:$key), 'name'=>$key, 'title'=>(isset($val['title'][$_SESSION['admin_interface_language']])?$val['title'][$_SESSION['admin_interface_language']]:$this->cmsPhrases['modules']['context_menu'][$key.'_title']), 'action'=>$act, 'main_action'=>$act);
    	}
		
		return $context;
		
    }
    
    function listItemsElements($category=0, $order_by='R.sort_order', $order_direction='ASC', $offset=0, $paging=30){
    	$list = record::listItemsElements($category, $order_by, $order_direction, $offset, $paging);
    	if($this->xml_config['lng_in_url']==1){
    		foreach($list as $i=>$val){
    			$list[$i]['page_url'] = $this->language.$list[$i]['page_url'];
    		}
    	}
    	//pae($list);
    	return $list;
    }
    
}

?>
