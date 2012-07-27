<?php

include_once(CLASSDIR_."search.class.php");
$search = new search();

if($_GET['q']==$phrases['search_default_value']) $_GET['q'] = '';

$key = trim(urldecode($_GET['q']));
$key = addslashes($key);

if(strlen($key)>2){
	
	include_once(CLASSDIR."module.class.php");
	$module_obj = & new module();
	
	$list = $module_obj->listModules();
	$n = count($list);
	for($i=0, $not_empty=false, $urls=array(), $search_results=array(), $id_array=array(), $mod_index=0; $i<$n; $i++){
		if($list[$i]['search']==1){
			$results_news = $search->getResultsFromModule($key, $list[$i]['table_name']);
			$results_news_ = array();
			if(!empty($results_news)){
				$tikrinimas = false;
				$item_index = 0;
				foreach($results_news as $j=>$val){
					if(!in_array($val['page_url'], $urls)){
						$search_results[] = $val;
						$urls[] = $val['page_url'];
					}
				}
				
			}
		}
	}
	//pae($search_results);
	$tpl_inner->setLoop('search_results', $search_results);
	
	if(empty($search_results)){
		$tpl_inner->setVar('no_results', 1);
	}

}else{

	$tpl_inner->setVar('short_key', 1);

}

$tpl_inner->setVar('search_phrase', $key);


parse_str($_SERVER['QUERY_STRING'], $get);
unset($get['offset']);
$tpl_inner->setVar('query_url', http_build_query($get)."&");

?>