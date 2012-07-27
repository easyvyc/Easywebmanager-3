<?php
/*
 * Created on 2009.09.23
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once(CLASSDIR_."easytpl.class.php");
$users_tpl = & new easytpl(TPLDIR_."blocks/cart.tpl", "templateVariables");

if($_GET['order']==1){
	$users_tpl->setFile(TPLDIR_."order/cart.tpl");
}

if(isset($_GET['add'])){
	$main_object->call("orders", "add", array($_GET['add'], $_GET['kiekis']));
}
if(isset($_GET['remove'])){
	$main_object->call("orders", "remove", array($_GET['remove']));
}


$users_tpl->setVar('currency', $main_object->get("products", "currency"));

$users_tpl->setVar('reserved_url_words', $reserved_url_words);
$users_tpl->setVar('phrases', $phrases);
$users_tpl->setVar('lng', $lng);
$users_tpl->setVar('get', $_GET);
$users_tpl->setVar('upload_url', UPLOADURL);
$users_tpl->setVar('config', $configFile->variable);

if($_GET['ajax']==1){
	include $users_tpl->parse();
	exit;
}else{
	$users_tpl->parse();
	$tpl->setCodeBlock('cart_content', 'include $users_tpl->cacheFile;');
}

?>