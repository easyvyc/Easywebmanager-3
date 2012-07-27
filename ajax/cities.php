<?php
/*
 * Created on 2009.09.14
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



include_once(CLASSDIR_."cache.class.php");
$cache_obj = & new cache(CACHEDIR."data/");

$filters_obj = $main_object->create("filters");

$cache_file = CACHEDIR."data/cities.json.data";

if($cache_obj->is_loadCache($cache_file, $filters_obj->module_info['last_modify_time'])){
	echo $cache_obj->getContent($cache_file);
}else{
	$res = $filters_obj->listItems(3803);
	$data_content = "["; $first = true;
	foreach($res as $i=>$val1){
		if(!$first) $data_content .= ",";
		$first = false;
		$data_content .= "{value:\"{$val1['id']}\", text:\"{$val1['title']}\"}";
	}
	$data_content .= "]";
	$cache_obj->createCache($cache_file, $data_content);
	echo $data_content;
}
exit;

?>