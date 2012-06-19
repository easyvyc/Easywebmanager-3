<?php
/*
 * Created on 2007.08.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


//$currencies_obj = & new catalog("currencies");
//$currencies_obj->listItems(0,0)


//include(CLASSDIR_."curr.class.php");
//$curr = & new curr("valiuta", "valiuta");
//pae($curr->get(array('LVL', 'USD', 'GBP')));


$tpl->setLoop('currencies', $main_object->call("currencies", "listItems", array(0,0)));

if(isset($_COOKIE['currency']) && is_numeric($_COOKIE['currency'])){
	//$currencies_obj->loadItem($_COOKIE['currency']);
	$curr_data = $main_object->call("currencies", "loadItem", array($_COOKIE['currency']));
	$tpl->setVar('current_currency', $curr_data);
}else{
	//$currencies_obj->loadItem(2387);
	$curr_data = $main_object->call("currencies", "loadItem", array(2387));
	$tpl->setVar('current_currency', $curr_data);
}


?>