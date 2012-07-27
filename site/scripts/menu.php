<?php
/*
 * Created on 2007.08.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$sqlQueryWhere  = "";
$sqlQueryWhere .= " R.parent_id={$__MENU['main']} AND ";
if(!isset($_SESSION['user'])){
	$sqlQueryWhere .= " T.public_page!=1 AND ";
}
if(isset($id_path[1]['id']) && is_numeric($id_path[1]['id']))
	$main_object->set("pages", "fields", " IF({$id_path[1]['id']}=R.id, 1, 0) AS selected, ");
$main_object->set("pages", "sqlQueryWhere", $sqlQueryWhere);
$main_object->set("pages", "sqlQueryOrder", " ORDER BY R.sort_order ASC ");
$menu = $main_object->call("pages", "listSearchItems", array());;
if(!empty($menu)) $menu[0]['first'] = 1;
$tpl->setLoop('menu', $menu);


$sqlQueryWhere  = "";
$sqlQueryWhere .= " R.parent_id={$__MENU['top']} AND ";
if(!isset($_SESSION['user'])){
	$sqlQueryWhere .= " T.public_page!=1 AND ";
}
if(isset($id_path[1]['id']) && is_numeric($id_path[1]['id']))
	$main_object->set("pages", "fields", " IF({$id_path[1]['id']}=R.id, 1, 0) AS selected, ");
$main_object->set("pages", "sqlQueryWhere", $sqlQueryWhere);
$main_object->set("pages", "sqlQueryOrder", " ORDER BY R.sort_order ASC ");
$menu = $main_object->call("pages", "listSearchItems", array());;
if(!empty($menu)) $menu[0]['first'] = 1;
$tpl->setLoop('top_menu', $menu);


if(isset($id_path[1]['id']) && is_numeric($id_path[1]['id']) && $id_path[0]['id']==$__MENU['main']){

	$sqlQueryWhere  = "";
	$sqlQueryWhere .= " R.parent_id={$id_path[1]['id']} AND ";	
	if(!isset($_SESSION['user'])){
		$sqlQueryWhere .= " T.public_page!=1 AND ";
	}
	if(isset($id_path[2]['id']) && is_numeric($id_path[2]['id']))
		$main_object->set("pages", "fields", " IF({$id_path[2]['id']}=R.id, 1, 0) AS selected, ");
	$main_object->set("pages", "sqlQueryWhere", $sqlQueryWhere);
	$main_object->set("pages", "sqlQueryOrder", " ORDER BY R.sort_order ASC ");
	$menu = $main_object->call("pages", "listSearchItems", array());;
	if(!empty($menu)) $menu[0]['first'] = 1;
	$tpl->setLoop('top_submenu', $menu);

	
}


?>