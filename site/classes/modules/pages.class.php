<?php

include_once(CLASSDIR_."catalog.class.php");
class pages extends catalog {
	
	function pages($module){
		
		catalog::catalog($module);
		
		$this->table_text = $this->config->variable['sb_text'];
		$this->table_tpl = $this->config->variable['sb_template'];

	}
	
	function loadPage($id){
		$data = $this->loadItem($id);
		$data['description'] = $this->main_object->call("blocks", "loadItem_byPageId", array($id, "page"));
		return $data;
	}
	
	function getPageByTemplate($tpl){
		$this->sqlQueryWhere = " T.template='$tpl' AND ";
		$list = $this->listSearchItems();
		return $list[0];
	}
	
	function getPageByUrl($url){
		
		if($url=='') $url = "/";
		
		global $reserved_url_words;
		if($pos = strpos($url, "#")!==false){
			$url = substr($url, 0, $pos);
		}
		$url_arr = split("/", $url);
		$n = count($url_arr);
		$yra = false;
		foreach($reserved_url_words as $key=>$val){
			for($i=0; $i<$n; $i++){
				if($val==$url_arr[$i]){
					
					if(strlen($url_arr[($i+1)]))
						$GLOBALS['_GET'][$url_arr[$i]] = $url_arr[($i+1)];
					else
						$GLOBALS['_GET'][$url_arr[$i]] = 1;
					
					$url = substr($url, 0, strpos($url, "/".$val."/")+1).substr($url, strpos($url, "/".$val."/")+strlen($val)+strlen($url_arr[($i+1)])+3);
					
					break;
				}
			}
		}
		/*if(strlen($url)==0 || $url=="/"){
			return $this->config->variable['default_page'][$this->language];
		}*/
		$sql = "SELECT * FROM $this->table WHERE page_url='$url' AND lng='$this->language'";
		$this->db->exec($sql, __FILE__, __LINE__);
		$row = $this->db->row();
		$row['id'] = $row['record_id'];
		
//		$this->db->exec("SELECT last_modif_date FROM {$this->tables['record']} WHERE id={$row['record_id']}", __FILE__, __LINE__);
//		$row1 = $this->db->row();
//		$row['last_modif_date'] = substr($row1['last_modif_date'], 0, 10);
		
//		if(!in_array($row['record_id'], $_SESSION['visited_pages'])){
//			$sql = "UPDATE $this->table SET visited_count=visited_count+1 WHERE record_id={$row['record_id']} AND lng='$this->language'";
//			$this->db->exec($sql, __FILE__, __LINE__);
//			$_SESSION['visited_pages'][] = $row['record_id'];
//		}
		
		if(!isset($row['id']) || !is_numeric($row['id'])){
			$row = $this->loadItem($this->config->variable['default_page'][$this->language]);
		} 
		
		return $row;
		
	}
	
	function listMenu($id=''){
		
		global $id_path;
		
		if(isset($id) && is_numeric($id)){
			$this->sqlQueryWhere = " R.parent_id=$id AND ";
		}else{
			$this->sqlQueryWhere = " R.parent_id={$this->config->variable['default_page'][$this->language]} AND ";
		}
		
		if(!isset($_SESSION['user'])){
			$this->sqlQueryWhere .= " T.public_page!=1 AND ";
		}
		if(isset($id_path[1]['id']) && is_numeric($id_path[1]['id']))
			$this->fields = "IF({$id_path[1]['id']}=R.id, 1, 0) AS selected, ";
		$menu = $this->listSearchItems();
		
		if(!empty($menu)) $menu[0]['first'] = 1;
		return $menu;
		
	}
	
	function listMenu_($id){
		global $id_path;
		
		if(isset($id) && is_numeric($id)){
			$this->sqlQueryWhere = " R.parent_id=$id AND ";
		}else{
			$this->sqlQueryWhere = " R.parent_id={$this->config->variable['default_page'][$this->language]} AND ";
		}
		
		if(!isset($_SESSION['user'])){
			$this->sqlQueryWhere .= " T.public_page!=1 AND ";
		}
		if(isset($id_path[1]['id']) && is_numeric($id_path[1]['id']))
			$this->fields = "IF({$id_path[1]['id']}=R.id, 1, 0) AS selected, ";
		
		$menu = $this->listSearchItems();
		
		if(!empty($menu)) $menu[0]['first'] = 1;
		return $menu;		
	}
	
	function listMenu_user($id, $user_id){
		global $id_path;
		
		if(isset($id) && is_numeric($id)){
			$this->sqlQueryWhere = " R.parent_id=$id AND ";
		}else{
			$this->sqlQueryWhere = " R.parent_id={$this->config->variable['default_page'][$this->language]} AND ";
		}
		
		if(!isset($_SESSION['user'])){
			$this->sqlQueryWhere .= " T.public_page!=1 AND ";
		}
		if(isset($id_path[1]['id']) && is_numeric($id_path[1]['id']))
			$this->fields = "IF({$id_path[1]['id']}=R.id, 1, 0) AS selected, ";
		
		$this->fields = " COUNT(P.id) AS count, ";
		$this->sqlQueryJoins = " LEFT JOIN cms_products P ON (P.category=T.record_id AND P.pardavejas=$user_id AND P.lng='$this->language') ";
		$this->sqlQueryGroup = " GROUP BY R.id ";
		$menu = $this->listSearchItems();
		
		if(!empty($menu)) $menu[0]['first'] = 1;
		return $menu;		
	}
	
	function listCatalogMenu($id){
		global $id_path;

//		$cache_file = CACHEDIR."data/cache_{$this->module_info['table_name']}.$this->language.listCatalogMenu.$id.php";
//		$cached_function = "getCacheData_{$this->module_info['table_name']}_".$this->language."_listCatalogMenu_".$id."";
		$product_obj = $this->main_object->create("products");

//		if($this->cache->is_loadCache($cache_file, $this->module_info['last_modify_time']) && $this->cache->is_loadCache($cache_file, $product_obj->module_info['last_modify_time'])){
//			include_once($cache_file);
//			return $cached_function();
//		}
		
		$menu = $this->listMenu($id);
		foreach($menu as $i=>$val){
			$menu[$i]['sub'] = $this->listMenu_($val['id']);
			$menu[$i]['is_sub'] = (empty($menu[$i]['sub'])?0:1);
		}

//		$this->cache->setFilename($cache_file);
//		$this->cache->setFunctionname($cached_function);
//		$this->cache->generateCache($menu);
		
		return $menu;
	}
	
	function listCatalogMenu_user($id, $user_id){
		
		if(!is_numeric($user_id)) return false;
		
		global $id_path;
		
		$menu = $this->listMenu($id);
		foreach($menu as $i=>$val){
			$menu[$i]['sub'] = $this->listMenu_user($val['id'], $user_id);
			$count = 0;
			foreach($menu[$i]['sub'] as $val){
				$count += $val['count'];
			}
			$menu[$i]['count'] = $count;
		}
		return $menu;
			
	}
	
	function checkPageExist($id){
		if(isset($id) && is_numeric($id)){
			$sql = "SELECT id FROM $this->table WHERE record_id=$id ".(isset($_SESSION['user'])?"":" AND public_page!=1 ")." ";
			$this->db->exec($sql, __FILE__, __LINE__);
			$row = $this->db->row();
			if(empty($row))	return false;
			else			return true;
		}else{
			return false;
		}
	}
	
	function getBlocks($id){
		$sql = "SELECT title, text, area FROM $this->table_text WHERE page_id=$id";
		$this->db->exec($sql, __FILE__, __LINE__);
		$texts = $this->db->arr();
		$n = count($texts);
		for($i=0; $i<$n; $i++){
			$texts_n[$texts[$i]['area']] = $texts[$i];
		}
		return $texts_n;
	}

	function loadTree($id, $tree=array(), $level=0, $index=-1){
		global $lng, $search_engines;
		$sql = "SELECT R.id, R.parent_id, T.title, T.template, $level AS level, 0 AS sub, T.mod_id, T.active, IF('{$search_engines['show_friendly_url']}'='1', T.page_url, CONCAT('$lng.php?page_id=',R.id)) AS page_url, T.page_redirect, R.last_modif_date " .
		" FROM {$this->table} T LEFT JOIN cms_record R ON (R.id=T.record_id AND T.lng='$this->language') WHERE R.parent_id=$id AND active=1 AND R.trash!=1 ".(empty($_SESSION['user'])?" AND public_page!=1 ":"")." ORDER BY R.sort_order";
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

	function generateSitemap(){

		//$xmlFile = DOCROOT."sitemap.xml";
		include_once(CLASSDIR."xmlini.class.php");
		$arr2xml = new xmlIni();
		$this->sqlQueryWhere = " T.public_page!=1 AND ";
		$tree = $this->listSearchItems();
		//pae($tree);
		$n = count($tree);
		$arr2xml->xmlTree->name = "urlset";
		//$arr2xml->xmlTree->attributes[0]->name = "xmlns";
		//$arr2xml->xmlTree->attributes[0]->content = "http://www.google.com/schemas/sitemap/0.84";
		$arr2xml->xmlTree->attributes = array("xmlns"=>"http://www.google.com/schemas/sitemap/0.84");
		for($i=0; $i<$n; $i++){
			if($tree[$i]['disabled']!=1){
				unset($arr);
				$arr->name = "url";
				
				$arr->children[0]->name = "loc";
				$arr->children[0]->content = $this->config->variable['site_url'].$this->language.$tree[$i]['page_url'];
				
				$arr->children[1]->name = "lastmod";
				$arr->children[1]->content = substr($tree[$i]['last_modif_date'], 0, 10)."T".substr($tree[$i]['last_modif_date'], 11)."+00:00";//"2005-02-19T02:10:08+00:00";
				
				$arr2xml->xmlTree->children[] = $arr;
			}
		}
		//pae($arr2xml->xmlTree);
		$xml = $arr2xml->objToXml($arr2xml->xmlTree);
//		$file = fopen($xmlFile, "w");
//		fwrite($file, $xml);
//		fclose($file);
		return $xml; 	

	}
	
	function doSearch($_arr_key, $key, $precise_key){
		
    	$n = count($this->table_fields);
		for($i=0; $i<$n; $i++){
			if($this->table_fields[$i]['elm_type']==FRM_TEXT || $this->table_fields[$i]['elm_type']==FRM_TEXTAREA || $this->table_fields[$i]['elm_type']==FRM_HTML){
				$sql_query_where_arr = array();
				if($precise_key!==true){
					foreach($_arr_key as $k1=>$v1){
						$sql_query_where_arr[] = " LOWER(T.{$this->table_fields[$i]['column_name']}) LIKE LOWER('%$v1%') ";
					}
					$arr[]= " (".implode(" AND ", $sql_query_where_arr).") ";
				}else{
					$arr[] = " LOWER(T.{$this->table_fields[$i]['column_name']}) LIKE LOWER('%$key%')";
				}
				if($this->table_fields[$i]['elm_type']==FRM_TEXTAREA || $this->table_fields[$i]['elm_type']==FRM_HTML){
					$arr1[] = " T.{$this->table_fields[$i]['column_name']} ";
				}
			}
		}

		$where_clause = (!empty($arr))?"(".implode(" OR ", $arr).") AND ":"";
		//$description_fields = (count($arr1)>0?"CONCAT(".implode(",", $arr1).") AS description, ":"");

		$this->sqlQueryWhere = $where_clause;
		$this->fields = (count($arr1)>0?"CONCAT(".implode(",", $arr1).") AS _description_, ":"");
		$this->fields .= " T.title AS _title_, ";
		$res = $this->listSearchItems();

    	return $res;
    	
    }	

}

?>
