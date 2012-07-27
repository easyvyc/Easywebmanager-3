<?php
/*
 * Created on 2010.09.16
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once(CLASSDIR_."easytpl.class.php");
$users_tpl = & new easytpl(TPLDIR_."blocks/add2cartsuccess.tpl", "templateVariables");

$users_tpl->setVar('currency', $main_object->get("products", "currency"));

$users_tpl->setVar('reserved_url_words', $reserved_url_words);
$users_tpl->setVar('phrases', $phrases);
$users_tpl->setVar('lng', $_SESSION['site_lng']);
$users_tpl->setVar('get', $_GET);
$users_tpl->setVar('upload_url', UPLOADURL);
$users_tpl->setVar('upload_url', UPLOADURL);
$users_tpl->setVar('config', $configFile->variable);
$users_tpl->setVar('url_prefix', $url_prefix);

include $users_tpl->parse();
exit;

?>