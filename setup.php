<?php
/*
 * Created on 2007.1.28
 * setup.php
 * Vytautas
 */

error_reporting(0);

session_start();
if($_SESSION['admin']['permission']!=1){
	exit;
}

include("inc/config.inc.php");


$arr = file(DOCUMENTSDIR."ip-to-country.csv");
$n = count($arr);
for($i=0; $i<$n; $i++){
	$row = split(",", $arr[$i]);
	$row[2] = ereg_replace("\"", "", $row[2]);
	$sql = "INSERT INTO {$configFile->variable['sb_stat_country2ip']} SET ipfrom={$row[0]}, ipto={$row[1]}, code='".strtolower($row[2])."'";
	$database->exec($sql, __FILE__, __LINE__);
	
	$database->exec("TRUNCATE TABLE {$configFile->variable['sb_stat_visitor']}", __FILE__, __LINE__);
	$database->exec("TRUNCATE TABLE {$configFile->variable['sb_stat_visitor_path']}", __FILE__, __LINE__);
	
}

setPermissions("files/", 0777);
setPermissions("tpls/", 0777);

?>
