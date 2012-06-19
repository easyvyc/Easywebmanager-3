<?php
/*
 * Created on 2007.08.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


//$banners_obj = & new catalog("banners");
//
//$banners_obj->sqlQueryWhere = " R.is_category=0 AND ";
//$banners_obj->fields = " T1.keyword AS parent_name, ";
//$banners_obj->sqlQueryJoins = " LEFT JOIN $banners_obj->table T1 ON (R.parent_id=T1.record_id AND T1.lng='$lng') ";
//$list = $banners_obj->listSearchItems();

$main_object->set("banners", "sqlQueryWhere", " R.is_category=0 AND ");
$main_object->set("banners", "fields", " T1.keyword AS parent_name, ");
$main_object->set("banners", "sqlQueryJoins", " LEFT JOIN ".$main_object->get("banners", "table")." T1 ON (R.parent_id=T1.record_id AND T1.lng='$lng') ");

$list = $main_object->call("banners", "listSearchItems");

$n = count($list);
for($i=0; $i<$n; $i++){
	$arr = explode("x", $list[$i]['banner_size']);
	$arr1 = explode(".", $list[$i]['file']);
	$list[$i]['width'] = $arr[0];
	$list[$i]['height'] = $arr[1];
	if($arr1[(count($arr1)-1)]=='swf'){
		$list[$i]['img'] = 0;
		$list[$i]['swf'] = 1;  
	}else{
		$list[$i]['img'] = 1;
		$list[$i]['swf'] = 0;  
	}
	
	if($list[$i]['parent_name']!='')
		$banners[$list[$i]['parent_name']][] = $list[$i];
	else
		$banners['root'][] = $list[$i];
	
}
foreach($banners as $key=>$val)
	$tpl->setLoop('banners_'.$key, $val);


?>