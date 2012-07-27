<?php 

// wget http://www.url.com/cron.php?var=module-method-params

ob_start();
include("inc/config.inc.php");

$lng = $configFile->variable['default_lng'];

include_once(CLASSDIR_."object.class.php");
$main_object = new object();

// TODO: pratrinti uzklausimu laikinas bylas ir folderius

// TODO: newsletteriu siuntimas

// TODO: neapmoketu saskaitu siuntimas




$arr = explode("-", $_GET['var']);
echo $main_object->call($arr[0], $arr[1], $arr[2]);

?>