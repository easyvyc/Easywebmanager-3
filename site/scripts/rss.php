<?php
/*
 * Created on 2008.02.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once(CLASSDIR."module.class.php");
$mod_obj = & new module();
$list = $mod_obj->listModules(); 
$n_list = array();
foreach($list as $val){
	if($val['disabled']!=1 && $val['rss']==1)
		$n_list[] = $val;
}
$tpl->setLoop('rss_mod_list', $n_list);

?>