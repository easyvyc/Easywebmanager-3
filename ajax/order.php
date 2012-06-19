<?php
/*
 * Created on 2009.09.29
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once(CLASSDIR_."easytpl.class.php");
$tpl_inner = & new easytpl(TPLDIR_."order.tpl", "templateVariables");

$tpl_inner->setVar('reserved_url_words', $reserved_url_words);
$tpl_inner->setVar('phrases', $phrases);
$tpl_inner->setVar('lng', $lng);
$tpl_inner->setVar('get', $_GET);
$tpl_inner->setVar('upload_url', UPLOADURL);
$tpl_inner->setVar('config', $configFile->variable);


include(PHPDIR_."order.php");

include $tpl_inner->parse();
exit;


?>