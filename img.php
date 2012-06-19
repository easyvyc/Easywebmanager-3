<?php

error_reporting(0);
ob_start();
session_start();

// Set variable to user side
$user_side = true;

// Config
include("inc/config.inc.php");


if(isset($_GET['img'])){
	redirect($_GET['img']);
}

$TIME_START = getmicrotime();


include_once(CLASSDIR_."images.class.php");
$img_obj = & new images();


//$img_obj->dir


?>