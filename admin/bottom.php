<?php

ob_start();
session_start();
#session_regenerate_id();
header("Cache-control: private");
header("Content-Type: text/html; charset=utf-8");

include_once ('../inc/config.inc.php');

if(!isset($_SESSION["admin"]["id"])){
	redirect("login.php");
}

if($_SESSION['admin']['user_agent']!=$_SERVER['HTTP_USER_AGENT'] || $_SESSION['admin']['user_ip']!=$_SERVER['REMOTE_ADDR']){
	unset($_SESSION['admin']);
	redirect("login.php");
}

include_once(CLASSDIR."easytpl.class.php");
$tpl_main = & new easytpl("templates/bottom.tpl", "templateVariables");

$tpl_main->setVar('easyweb_version', EASYWEBMANAGER_VERSION);
$tpl_main->setVar('phrases', $cms_phrases['bottom']);

$tpl_main->setVar('admin', $_SESSION['admin']);

include $tpl_main->parse();
ob_end_flush();

?>