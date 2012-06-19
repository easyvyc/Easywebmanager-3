<?php

error_reporting(0);
ob_start();

if (empty($content)) {$content = "pages";}
session_start();
$user_side = true;
include("inc/config.inc.php");

if(isset($_GET['lng'])){
	$lng = $_GET['lng'];
}else{
	$lng = $configFile->variable['default_lng'];
}

include_once(CLASSDIR_."easytpl.class.php");

$time_start = getmicrotime();

include_once(CLASSDIR_."object.class.php");
$main_object = new object();

include(SCRIPTS_."phrases.php");

if(isset($_GET['content'])){
	$ajax_content = true;
	include("ajax/{$_GET['content']}.php");
}

$time_end = getmicrotime();

header("Content-Type: text/html; charset=utf-8");
echo $part_content;

ob_flush();

?>
