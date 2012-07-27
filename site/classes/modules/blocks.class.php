<?php


include_once(CLASSDIR_."catalog.class.php");
class blocks extends catalog {

    function blocks() {
    	catalog::catalog("blocks");
    }
    
    function loadItem_byPageId($page_id, $block_name){
    	
    	$this->sqlQueryWhere = " page_id=$page_id AND block_name='$block_name' AND ";
    	$arr = $this->listSearchItems();
    	
    	return $arr[0]['description'];
    	
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
		$this->sqlQueryWhere .= " T.block_name='page' AND ";
		$this->sqlQueryJoins = " LEFT JOIN {$this->config->variable['pr_code']}_pages P ON (T.page_id=P.record_id AND P.lng='$this->language') ";
		$this->fields = (count($arr1)>0?"CONCAT(".implode(",", $arr1).") AS _description_, ":"");
		$this->fields .= " P.page_url, P.title AS _title_, ";
		$res = $this->listSearchItems();

    	return $res;
    	
    }    
    
}
?>