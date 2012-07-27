<?php
/*
 * Created on 2007.08.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$main_object->call("metatags", "loadItem", array($page_id));

$tbl_fields = $main_object->get("metatags", "table_fields");
$meta_data = $main_object->get("metatags", "data");

$n = count($tbl_fields);
for($i=0; $i<$n; $i++){
	if($tbl_fields[$i]['elm_type']!='submit' && $tbl_fields[$i]['column_name']!='active'){
		$meta_tags_list[] = array('value'=>$tbl_fields[$i]['column_name'], 'content'=>$meta_data[$tbl_fields[$i]['column_name']]);
	}
}


$tpl->setLoop('meta_tags', $meta_tags_list);

?>