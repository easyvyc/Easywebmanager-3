<?php

include_once(CLASSDIR_."record.class.php");
class catalog extends record {

	var $sqlQueryWhere="";
	var $sqlQueryOrder="";
	var $viewAllItems = 0;

    function catalog($module) {
    	
    	global $lng, $cache_obj;
    	record::record($module);
    	$this->language = $lng;
    	
    	if(is_object($cache_obj))
    		$this->cache = $cache_obj;
    	else{
    		$this->module_info['cache'] = 0;
    	}

    }
    
    function saveItem($data){
    	$this->admin['id'] = 1;
    	$id = record::saveItem($data);
    	foreach($this->table_fields as $i=>$val){
    		if($val['elm_type']==FRM_LIST){
    			if($val['list_values']['source'] == 'DB') {
    				$list_obj = $this->main_object->create($val['list_values']['module']);
    				foreach($data[$val['column_name']] as $list_data){
    					$list_data[$val['list_values']['get_category']] = $id;
    					$list_data[$val['list_values']['get_column_name']] = $val['column_name'];
    					$list_data['active'] = 1;
    					$list_obj->insert($list_data);
    				}
    			}
    		}
    	}
    	return $id;
    }
    
    function insert($data){
    	$data['isNew'] = 1;
    	$data['id'] = 0;
    	$data['parent_id'] = 0;
    	$data['language'] = $this->language;
    	return $this->saveItem($data);
    }  
    
    function setSqlQuery($data){
    	$where_clause=array();
    	foreach($data as $key=>$val){
    		if(isset($data[$key]['value'])&&strlen($data[$key]['value'])>0){
	    		switch($data[$key]['elm_type']){
	    			case FRM_SELECT :
	    			case FRM_CHECKBOX_GROUP :
	    				$arr = explode("::", $data[$key]['value']);
	    				$n = count($arr);
			    		$arr_ = explode("::", $data[$key]['operation']);

			    		for($i=0, $str_=""; $i<$n; $i++){

			    			$str = $arr_[1];
			    			$str = ereg_replace("{name}", "T.".$key, $str);
			    			$str = ereg_replace("{value}", $arr[$i], $str);
							if($data[$key]['elm_type'] == FRM_SELECT)
								$str_ .= ($i==0?"":" OR ").$str;
							else
								$str_ .= ($i==0?"":" AND ").$str;

							$where_['str'] = $str_;//$_SESSION['search'][$key]['operation'];
		    				$where_['column_name'] = $key;
		    				$where_['column_value'] = $arr[$k];
		    				//$where_clause[] = $where_;
						}
						$where_['str'] = "{$arr_[0]}::({$where_['str']})";
						$where_clause[] = $where_;
	    			break;
	    			default:
	    				$where_['str'] = $data[$key]['operation'];
	    				$where_['column_name'] = $key;
	    				$where_['column_value'] = $data[$key]['value'];
	    				$where_clause[] = $where_;
	    		}
    		}
    	}
    	foreach($where_clause as $key=>$val){
    		$arr = explode("::", $where_clause[$key]['str']);
    		if($arr[0]=="WHERE"){
    			$str = $arr[1];
    			$str = ereg_replace("{name}", "T.".$where_clause[$key]['column_name'], $str);
    			$str = ereg_replace("{value}", $where_clause[$key]['column_value'], $str);
    			$this->sqlQueryWhere .= $str." AND ";
    		}
    		if($arr[0]=="ORDER"){
    			$str = $arr[1];
    			$str = ereg_replace("{name}", "T.".$where_clause[$key]['column_name'], $str);
    			$str = ereg_replace("{value}", $where_clause[$key]['column_value'], $str);
    			$this->sqlQueryOrder .= $str;
    		}
    	}
    	if(strlen($this->sqlQueryOrder)>0)
    		$this->sqlQueryOrder = " ORDER BY ".$this->sqlQueryOrder;
    	
    }

    function listAllItems($parent_id=0, $is_category=0){
    	
    	$this->viewAllItems = 1; 
    	$this->sqlQueryWhere = " R.is_category=$is_category AND R.parent_id=$parent_id AND ";
    	if(strlen($this->module_info['default_sort'])>0)
    		$this->sqlQueryOrder = " ORDER BY {$this->module_info['default_sort']} {$this->module_info['default_sort_direction']} ";
    	$list = $this->listSearchItems();
    	$this->viewAllItems = 0;
    	return $list;
    	
    }
    
    function listItems($parent_id=0, $is_category=0){
    	
		if($this->module_info['cache']==1){
			$create_cache = false;
			$cache_file = CACHEDIR."data/cache_{$this->module_info['table_name']}.$this->language.$parent_id.$is_category.php";
			$cached_function = "getCacheData_{$this->module_info['table_name']}_".$this->language."_".$parent_id."_".$is_category."";
			if($this->cache->is_loadCache($cache_file, $this->module_info['last_modify_time'])){
				include_once($cache_file);
				return $cached_function();
			}
			$create_cache = true;
    	}
		
    	$this->sqlQueryWhere = " R.parent_id=$parent_id AND ";
    	
//    	if(strlen($this->module_info['default_sort'])>0)
//    		$this->sqlQueryOrder = " ORDER BY {$this->module_info['default_sort']} {$this->module_info['default_sort_direction']} ";
//    	else
//    		$this->sqlQueryOrder = " ORDER BY R.sort_order ASC ";
    	$list = $this->listSearchItems();
    	
    	
    	if($this->module_info['cache']==1 && $create_cache===true){
    		$this->cache->setFilename($cache_file);
    		$this->cache->setFunctionname($cached_function);
    		$this->cache->generateCache($list);
    	}
    	
    	return $list;
    	
    	
    	
    }

    function getItemsByParams($params){
    	foreach($params as $key=>$val){
    		$val = $this->db->escape($val);
    		$this->sqlQueryWhere .= " LOWER(T.$key)=LOWER('$val') AND ";
    	}
    	return $this->listSearchItems();
    }
    
	function loadItem($id){
		
        $item_data = record::loadItem($id);

		foreach($this->table_fields as $key=>$val){
			// sita geriau uzsikraut tada kada tikrai reikia, beto no_record_table blogai veiks del R.is_category
			/*
			if($val['elm_type']==FRM_LIST){
				if($val['list_values']['source']=='DB' && isset($val['list_values']['module']) && isset($val['list_values']['get_category']) && isset($val['list_values']['get_column_name'])){
					
					$r_obj = & new catalog($val['list_values']['module']);
					$r_obj->sqlQueryWhere = " R.is_category=0 AND T.{$val['list_values']['get_category']}=$id AND T.{$val['list_values']['get_column_name']}='{$val['column_name']}' AND ";
					$list = $r_obj->listSearchItems();
					
					$item_data[$val['column_name']] = $list;
				}
			}
			*/
			if($val['elm_type']==FRM_TEXTAREA){
				$item_data[$val['column_name']] = nl2br($item_data[$val['column_name']]);
			}
		}
		
		return $item_data;
		
	}

    function updateField($column, $value, $id){
    	$sql = "UPDATE $this->table SET $column='$value' WHERE record_id=$id";
    	$this->db->exec($sql, __FILE__, __LINE__);
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
    
    function generateSitemap(){
    	
    	$lng = isset($this->language)?$this->language:$this->config->variable['default_lng'];
    	include_once(CLASSDIR."xmlini.class.php");
		$arr2xml = new xmlIni();
		$tree = $this->listSearchItems();
		
		$n = count($tree);
		$arr2xml->xmlTree->name = "urlset";
		$arr2xml->xmlTree->attributes = array("xmlns"=>"http://www.google.com/schemas/sitemap/0.84");
		for($i=0; $i<$n; $i++){
			$arr->name = "url";
			
			$arr->children[0]->name = "loc";
			$arr->children[0]->content = $this->config->variable['site_url'].$lng."/".$GLOBALS['reserved_url_words']['search']."/".urlencode($tree[$i]['title']);
			
			$arr->children[1]->name = "lastmod";
			$arr->children[1]->content = substr($tree[$i]['last_modif_date'], 0, 10)."T".substr($tree[$i]['last_modif_date'], 11)."+00:00";//"2005-02-19T02:10:08+00:00";
			
			$arr2xml->xmlTree->children[] = $arr;
		}
		$xml = $arr2xml->objToXml($arr2xml->xmlTree);
		return $xml;
		 	    	
    }
    
    function generateRSS(){
		
		global $search_engines;
		
    		$lng = isset($this->language)?$this->language:$this->config->variable['default_lng'];
	    	include_once(CLASSDIR."xmlini.class.php");
		$arr2xml = new xmlIni();
		
		foreach($this->table_fields as $key=>$val){
			if($val['elm_type']==FRM_TEXTAREA || $val['elm_type']==FRM_HTML){
				$_a[] = " T.{$val['column_name']} ";
			}
		}
		$this->fields = (count($_a)?" CONCAT(".implode(",", $_a).") AS description, ":"");
		$tree = $this->listSearchItems();
		
		$arr2xml->xmlTree->name = "rss";
		$arr2xml->xmlTree->attributes["version"] = "2.0";
		
		$arr2xml->xmlTree->children[0]->name = "channel";
		
		$arr[0]->name = "title";
		$arr[0]->content = $this->config->variable['pr_url'];

		$arr[1]->name = "link";
		$arr[1]->content = $this->config->variable['site_url'];

		$arr[2]->name = "generator";
		$arr[2]->content = "easywebmanager ".EASYWEBMANAGER_VERSION;
		
		$n = count($tree);
		for($i=0, $j=3; $i<$n; $i++, $j++){

			$arr[$j]->name = "item";

			$arr[$j]->children[0]->name = "title";
			$arr[$j]->children[0]->content = $tree[$i]['title'];

			$arr[$j]->children[1]->name = "link";
			$arr[$j]->children[1]->content = $this->language.$tree[$i]['page_url'];

			$arr[$j]->children[2]->name = "description";
			$arr[$j]->children[2]->content = mb_substr(strip_tags($tree[$i]['description']), 0, 500, "UTF-8");

			$arr[$j]->children[3]->name = "pubDate";
			$arr[$j]->children[3]->content = $tree[$i]['last_modif_date'];

		}
		$arr2xml->xmlTree->children[0]->children = $arr;
		$xml = $arr2xml->objToXml($arr2xml->xmlTree);
				
		return $xml;
    	
    }
    
	function replaceLetters($str) {

		$str = ereg_replace("&#39;", "'", $str);
		$str = ereg_replace("[\'\<\>\"{`\!\%\(\);\{\}\+\-\*\&\#]", "-", $str);

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
		$str = ereg_replace("\.", "", $str);
		$str = ereg_replace(",", "", $str);
		return $str;
	}	    

	function pagingItems($offset, $RESULTS_PAGING=20){
		$paging_arr = generatePaging($offset, $this->items_count, $this->paging, $RESULTS_PAGING);
		$this->is_paging = $paging_arr['is_paging'];
		return $paging_arr['loop'];
	}
	
	function is_pagingItems(){
		return $this->is_paging;
	}
    
}
?>
