<?php

include_once(CLASSDIR_."basic.class.php");
class search extends basic {
	
	var $path = array();
	var $description_length = 500;
	var $precise_key = false;
	var $highlight_search_result = "<span class='highlight_search_result'>\\0</span>";
	
	function search(){
		basic::basic();
		$this->lng = & $GLOBALS['lng'];
		$this->table_text = $this->config->variable['sb_text'];
	}
	
	function getResults($key, $table, $cols){
		
	}
	
	/*function getResultsFromPages($key){
		
		$key = addslashes($key);
		
		if($this->precise_key!==true){
			
			$arr_key = explode(" ", $key);
			foreach($arr_key as $k=>$v){
				if(strlen($v)>2){
					$sql_query_where_arr[] = "(LOWER(P.title) LIKE LOWER('%$v%') OR LOWER(T.text) LIKE LOWER('%$v%'))";
					$_arr_key[] = $v;
				}
			}
			$sql_query_where_str = " (".implode(" AND ", $sql_query_where_arr).") ";
			
		}else{
			
			$sql_query_where_str = " (LOWER(P.title) LIKE LOWER('%$key%') OR LOWER(T.text) LIKE LOWER('%$key%')) ";
			
		}
		
		$sql = "SELECT P.id, T.text AS description, P.parent_id, P.title, P.page_url FROM {$this->config->variable['sb_page']} P " .
				"LEFT JOIN {$this->config->variable['sb_text']} T " .
				"ON (P.id=T.page_id) " .
				"WHERE P.disabled!=1 ".(isset($_SESSION['user'])?"":" AND P.public_page!=1 ")." AND " .$sql_query_where_str .
				"GROUP BY P.id " .
				"ORDER BY P.parent_id, P.order_id";
		$this->db->exec($sql, __FILE__, __LINE__);
		$res = $this->db->arr();
		$n = count($res);
		$key = mb_strtolower($key, "UTF-8");
		for($i=0; $i<$n; $i++){
			
			$description = $res[$i]['description'];
			//$description = preg_replace("/<script([^>]*?)>([^(</script>)]*)<\/script>/si", "", $description);
			$description = strip_tags($description);
			$description_lower = mb_strtolower($description, "UTF-8");
			$description_value = "";
			
			if($this->precise_key!==true){
				$max_search_count = 0;
				foreach($_arr_key as $k=>$v){
					$pos = mb_strpos($description_lower, $v, 0, "UTF-8");
					$start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
					$str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
					$description = mb_substr($description, $start_pos, $str_len, "UTF-8");
					$search_count = 0;
					//pa($_arr_key);
					// iesko fragmento kuriame yra daugiausia rasta paieskos zodziu
					$pos = 0;
					foreach($_arr_key as $k1=>$v1){
						while($pos = mb_strpos($description, $v1, $pos + 1, "UTF-8")) $search_count++;
					}
					if($max_search_count < $search_count){
						$max_search_count = $search_count;
						$description_value = $description;
					}
					//echo "$max_search_count < $search_count<br>$description_value<br><br>";
					
				}
				if($max_search_count == 0) $description_value = $description;
				
				$description = "...".$description_value."...";
				
				foreach($_arr_key as $k=>$v){
					$description = eregi_replace("$v", $this->highlight_search_result, $description);
					$res[$i]['title'] = eregi_replace($v, $this->highlight_search_result, $res[$i]['title']);
				}
				
			}else{
				$pos = mb_strpos($description_lower, $key, 0, "UTF-8");
				$start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
				$str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
				$description = mb_substr($description, $start_pos, $str_len, "UTF-8");
				$description = "...".$description."...";
				$description = eregi_replace("$key", $this->highlight_search_result, $description);
				$res[$i]['title'] = eregi_replace($key, $this->highlight_search_result, $res[$i]['title']);
			}
			
			$res[$i]['description'] = $description;

			$this->getPath($res[$i]['id']);
			//pa($this->path);
			if($this->path[0]['id']==$this->config->variable['default_page'][$this->lng]){
				$n_res[] = $res[$i];
			}
			
		}
		//pa($id_arr);
		//pae($n_res);
		return $n_res;
	}*/

	function getResultsFromModule($key, $module){
		
		$n_res = array();
		
		$arr_key = preg_split('/[\s,]+/', $key);
		foreach($arr_key as $k=>$v){
			if(strlen($v)>2){
				$_arr_key[] = $v;
			}
		}
		
		$res = $this->main_object->call($module, "doSearch", array($_arr_key, $key, $this->precise_key));
		
		/*
		$n = count($record->table_fields);
		for($i=0; $i<$n; $i++){
			if($record->table_fields[$i]['elm_type']==FRM_TEXT || $record->table_fields[$i]['elm_type']==FRM_TEXTAREA || $record->table_fields[$i]['elm_type']==FRM_HTML){
				$sql_query_where_arr = array();
				if($this->precise_key!==true){
					foreach($_arr_key as $k1=>$v1){
						$sql_query_where_arr[] = " LOWER(T.{$record->table_fields[$i]['column_name']}) LIKE LOWER('%$v1%') ";
					}
					$arr[]= " (".implode(" AND ", $sql_query_where_arr).") ";
				}else{
					$arr[] = " LOWER(T.{$record->table_fields[$i]['column_name']}) LIKE LOWER('%$v%')";
				}
				if($record->table_fields[$i]['elm_type']==FRM_TEXTAREA || $record->table_fields[$i]['elm_type']==FRM_HTML){
					$arr1[] = " T.{$record->table_fields[$i]['column_name']} ";
				}
			}
		}

		$where_clause = (!empty($arr))?"(".implode(" OR ", $arr).") AND ":"";
		//$description_fields = (count($arr1)>0?"CONCAT(".implode(",", $arr1).") AS description, ":"");

		$record->sqlQueryWhere = $where_clause;
		$record->fields = (count($arr1)>0?"CONCAT(".implode(",", $arr1).") AS _description_, ":"");
		$res = $record->listSearchItems();
		
		
		if($module=='events'){
			$sql = "SELECT $description_fields R.id, M.title, M.lng, R.parent_id, CONCAT(P.page_url, 'id/', R.id) AS page_url FROM {$this->config->variable['pr_code']}_$module M " .
				"LEFT JOIN {$this->config->variable['pr_code']}_record R " .
				"ON (R.id=M.record_id) " .
				"LEFT JOIN {$this->config->variable['pr_code']}_pages P " .
				"ON (P.template='repertuaras' AND P.lng=M.lng) " .
				"WHERE $where_clause M.active=1 " .
				"GROUP BY R.id ";			
		}elseif($module=='news'){
			$sql = "SELECT $description_fields R.id, M.title, M.lng, R.parent_id, CONCAT(P.page_url, 'id/', R.id) AS page_url FROM {$this->config->variable['pr_code']}_$module M " .
				"LEFT JOIN {$this->config->variable['pr_code']}_record R " .
				"ON (R.id=M.record_id) " .
				"LEFT JOIN {$this->config->variable['pr_code']}_pages P " .
				"ON (P.template='archive' AND P.lng=M.lng) " .
				"WHERE $where_clause M.active=1 " .
				"GROUP BY R.id ";

		}elseif($module=='blocks'){
			$sql = "SELECT $description_fields R.id, P.title, M.lng, R.parent_id, P.page_url FROM {$this->config->variable['pr_code']}_$module M " .
				"LEFT JOIN {$this->config->variable['pr_code']}_record R " .
				"ON (R.id=M.record_id) " .
				"LEFT JOIN {$this->config->variable['pr_code']}_pages P " .
				"ON (M.page_id=P.record_id AND P.lng=M.lng) " .
				"WHERE $where_clause M.active=1 " .
				"GROUP BY R.id ";

		}else{
			$sql = "SELECT $description_fields R.id, M.title, M.lng, R.parent_id, P.page_url FROM {$this->config->variable['pr_code']}_$module M " .
				"LEFT JOIN {$this->config->variable['pr_code']}_record R " .
				"ON (R.id=M.record_id) " .
				"LEFT JOIN {$this->config->variable['pr_code']}_pages P " .
				"ON (R.id=P.record_id AND P.lng=M.lng) " .
				"WHERE $where_clause M.active=1 AND R.trash!=1 " .
				"GROUP BY R.id ";
		}
		$this->db->exec($sql);
		$res = $this->db->arr();
		*/
		
		$n = count($res);
		//pae($res);
		for($i=0; $i<$n; $i++){
			
			$description = $res[$i]['_description_'];
			//$description = preg_replace("/<script([^>]*?)>([^(</script>)]*)<\/script>/si", "", $description);
			$description = strip_tags($description);
			$description_lower = mb_strtolower($description, "UTF-8");
			
			if($this->precise_key!==true){
				$max_search_count = 0; $description_value = mb_substr($description, 0, $this->description_length, "UTF-8");;
				foreach($_arr_key as $k=>$v){
					$pos = mb_strpos($description_lower, $v, 0, "UTF-8");
					$start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
					$str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
					$description = mb_substr($description, $start_pos, $str_len, "UTF-8");
					$search_count = 0;
					foreach($_arr_key as $k1=>$v1){
						if(mb_strpos($description, $v1, 0, "UTF-8")) $search_count++;
					}
					if($max_search_count < $search_count){
						$max_search_count = $search_count;
						$description_value = $description;
					}
				}
				
				$description = $description_value;
				
				foreach($_arr_key as $k=>$v){
					$description = eregi_replace("$v", $this->highlight_search_result, $description);
					$res[$i]['title'] = eregi_replace($v, $this->highlight_search_result, $res[$i]['title']);
				}
			}else{
				$pos = mb_strpos($description_lower, $key, 0, "UTF-8");
				$start_pos = ($pos>($this->description_length/2)?$pos-($this->description_length/2):0);
				$str_len = (mb_strlen($description, "UTF-8")>($start_pos + $this->description_length)?$this->description_length:mb_strlen($description, "UTF-8") - $start_pos);	
				$description = mb_substr($description, $start_pos, $str_len, "UTF-8");
				//$description = $description;
				$description = eregi_replace("$key", $this->highlight_search_result, $description);
				$res[$i]['title'] = eregi_replace($key, $this->highlight_search_result, $res[$i]['title']);
			}
			
			$res[$i]['_description_'] = $description;
			
			/*$sql = "SELECT P.id FROM {$this->config->variable['sb_page']} P " .
					"WHERE P.module_id={$record->module_info['id']} AND P.disabled!=1 ";
			$this->db->exec($sql);
			$arr = $this->db->arr();
			foreach($arr as $row){
				$this->getPath($row['id']);
				if($this->path[0]['id']==$this->config->variable['default_page'][$this->lng]){
					$n_res[] = $res[$i];
					break;
				}
			}*/
		}
		return $res;
	}

}

?>