<?php
/*
 * Created on 2009.07.07
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$required_extensions = array('iconv','mbstring','gd','xml');
define('OLDER_PHP_VERSION', "4.2.0");
define('OLDER_MYSQL_VERSION', "3.23.0");


$error = false;

$error = (version_compare(phpversion(), OLDER_PHP_VERSION)>-1?false:true);
echo "<br />";
echo $lang['check']['php_version'].": ".phpversion()." - ";
if(version_compare(phpversion(), OLDER_PHP_VERSION)>-1){
	echo "OK";
}else{
	echo "FAIL";
	$error = true;
}
echo "<br />";
echo $lang['check']['zend_version'].": ".zend_version()." - ";
if(true){
	echo "OK";
}else{
	echo "FAIL";
	$error = true;
}
echo "<br />";
echo $lang['check']['mysql']." - ";
if(function_exists('mysql_connect')){
	echo "OK";
}else{
	echo "FAIL";
	$error = true;
}

echo "<br />";
echo "<br />";


echo $lang['check']['config_file']." - ";
if(file_exists($CONFIGFILE) && @ is_writable($CONFIGFILE)){
	echo "OK";
}else{
	echo "FAIL";
	$error = true;
}

echo "<br />";
echo "<br />";


echo $lang['check']['php_extensions'].":<br /> ";
foreach($required_extensions as $val){
	if(extension_loaded($val)){
		echo "$val - OK<br />";
	}else{
		echo "$val - FAIL<br />";
		$error = true;
	}
}


echo "<br />";
if($error!==true){
	echo "<br /><input class=\"btn\" type=\"button\" onclick=\"javascript: location='install.php?step=config';\" value=\"{$lang['common']['next_step']}\" />";
}else{
	echo $lang['check']['check_configuration'];
}


?>