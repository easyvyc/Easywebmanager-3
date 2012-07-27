<?php
/*
 * Created on 2007.6.5
 * banner.php
 * Vytautas
 */

error_reporting(0);
ob_start();

if (empty($content)) {$content = "pages";}
session_start();
$user_side = true;
include("inc/config.inc.php");


include_once(CLASSDIR_."catalog.class.php");
$banner_obj = & new catalog("banners");

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['action']=='view'){
	
	$sql = "UPDATE $banner_obj->table SET view_count=view_count+1 WHERE record_id={$_GET['id']}";
	$banner_obj->db->exec($sql, __FILE__, __LINE__);
	exit;
	
}

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['action']=='click'){
	
	exit;
	$banner_data = $banner_obj->loadItem($_GET['id']);
	
	if(!in_array($banner_data['id'], $_SESSION['banners'])){
		$sql = "UPDATE $banner_obj->table SET click_count=click_count+1 WHERE record_id={$banner_data['id']}";
		$banner_obj->db->exec($sql, __FILE__, __LINE__);
		$_SESSION['banners'][] = $banner_data['id'];
	}
	
	redirect($banner_data['hiperlink']);
	
}

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['action']=='show'){
	
	echo "<body style=\"background-color:transparent\"><script src=\"{$configFile->variable['site_url']}banner.php?id={$_GET['id']}&action=out\"></script></body>";
	exit;
	
}

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['action']=='out'){
	
	$banner_data = $banner_obj->loadItem($_GET['id']);
	list($banner_data['width'], $banner_data['height']) = explode("x", $banner_data['banner_size']);
	echo "document.write('<object width=\"{$banner_data['width']}\" height=\"{$banner_data['height']}\" type=\"application/x-shockwave-flash\" " .
			" data=\"".UPLOADURL."{$banner_data['file']}\">" .
			"<param name=\"movie\" value=\"".UPLOADURL."{$banner_data['file']}\">" .
			"<param name=\"wmode\" value=\"transparent\">" .
			"<param name=\"FlashVars\" value=\"clickTag={$configFile->variable['site_url']}banner.php?id={$banner_data['id']}&action=click\"></object>');";
	exit;
	
}

?>