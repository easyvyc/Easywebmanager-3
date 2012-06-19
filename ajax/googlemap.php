<?php
/*
 * Created on 2009.09.08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


include_once(CLASSDIR_."easytpl.class.php");
$tpl = & new easytpl("ajax/googlemap.tpl", "templateVariables");


$tpl->setVar('get', $_GET);
$tpl->setVar('xml_config', $XML_CONFIG);

include $tpl->parse();
exit;

?>