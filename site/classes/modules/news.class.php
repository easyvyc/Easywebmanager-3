<?php

include_once(CLASSDIR_."catalog.class.php");

class news extends catalog{
	
	function news(){
		catalog::catalog("news");
	}
	
	function listItems($id, $offset, $paging){
		
		global $phrases;
		
		if(!isset($offset) || $offset==''){
			$offset = 0;
		}
		
		$this->sqlQueryWhere = " R.parent_id=$id AND ";
		$this->sqlQueryLimit = " LIMIT ".($offset*$paging).", $paging ";
		$this->news_count = $this->getCountSearchItems();
		$news_list = catalog::listSearchItems();
		
		foreach($news_list as $i=>$val){
			$arr = explode("-", $val['news_date']);
			$news_list[$i]['day'] = (int) $arr[2];
			$news_list[$i]['year'] = (int) $arr[0];
			$news_list[$i]['month'] = $phrases['month.'.$arr[1]];
		}
		
		return $news_list;
		
	}
	
	function pagingItems($offset, $paging, $RESULTS_PAGING){
		
		$paging_arr = generatePaging($offset, $this->news_count, $paging, $RESULTS_PAGING);
		return $paging_arr['loop'];
		
	}
	
    function doSearch($_arr_key, $key, $precise_key){
		
    	$news_page = $this->main_object->call("pages", "getPageByTemplate", array("news"));
    	
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
		$this->fields .= " '{$news_page['page_url']}' AS page_url, T.title AS _title_, ";
		$res = $this->listSearchItems();

    	return $res;
    	
    }  	
	
}

?>