<?php

ob_start();
session_start();

// Set variable to user side
$user_side = true;
ini_set('display_errors', true);

header('Content-type: text/html; charset=UTF-8');

// Config
include("inc/config.inc.php");

// Set default language
if(!isset($lng)){
	$lng = $configFile->variable['default_lng'];
}

//error_reporting(E_ALL);

$TIME_START = getmicrotime();

// Cache object
$cache_obj = & new cache(CACHEDIR."data/");


// Debug mode
if(isset($_GET['debug']) && $_GET['debug']==1 && $_SESSION['admin']['permission']==1){
	$_SESSION['debug']['enabled'] = 1;
}

include_once(CLASSDIR_."object.class.php");


include_once(CLASSDIR_."easytpl.class.php");
$tpl = & new easytpl(TPLDIR_."content.tpl", "templateVariables", CACHETPLDIR_);

// Underconstruction
if($XML_CONFIG['toggler']!=1/* site disabled */ && !isset($_SESSION['admin']['id']) /* view website for admin */){
	$tpl->setFile(TPLDIR_."underconstruction.tpl", "templateVariables", CACHETPLDIR_);
	$tpl->setVar('underconstruction', $XML_CONFIG['underconstruction']);
	$tpl->setVar('lang_lt', $lng=='lt'?1:0);
	$tpl->setVar('config', $configFile->variable);
	include $tpl->parse();
	exit;
}


$main_object = & new object();

$_SERVER['PATH_INFO'] = addcslashes($_SERVER['PATH_INFO'], "'\\");
if(ereg("\-([0-9]{1,})\.html$", $_SERVER['PATH_INFO'], $regs)){
	$_GET['id'] = $regs[1];
	$arr = explode("/", $_SERVER['PATH_INFO']);
	unset($arr[count($arr)-1]);
	$_SERVER['PATH_INFO'] = implode("/", $arr)."/";
}
$data = $main_object->call("pages", "getPageByUrl", array($_SERVER['PATH_INFO']));
$page_id = $data['id'];

if(isset($_GET['page_id'])){
	$page_id = $_GET['page_id'];
}
if(isset($_GET['content'])){
	$content = $_GET['content'];
}

if(isset($_GET['logout'])){
	unset($_SESSION['simple_user']);
	redirect($configFile->variable['site_url']);
}


$SELFURL = $configFile->variable['site_url'].$lng.$_SERVER['PATH_INFO'];

foreach($reserved_url_words as $key=>$val){
	if(ereg("^(/".$val."/)", $_SERVER['PATH_INFO'])){
		$content = $key;
		$page_id = $configFile->variable['default_page'][$lng];
	}
}


$tpl->setVar('self_url', $lng.$_SERVER['PATH_INFO']);

include(SCRIPTS_."users.php");



if(!$main_object->call("pages", "checkPageExist", array($page_id))){
	redirect("{$configFile->variable['site_url']}");
}


if(isset($data['page_redirect']) && is_numeric($data['page_redirect']) && $data['page_redirect']>0 && $data['page_redirect']!=$data['id']){
	$redirect_page_data = $main_object->call("pages", "loadItem", array($data['page_redirect']));
	if(strlen($redirect_page_data['page_url'])>0 && $redirect_page_data['page_redirect']!=$data['id'] && !isset($content)){
		redirect($configFile->variable['site_url'].$redirect_page_data['lng'].$redirect_page_data['page_url']);
	}
}

$main_object->call("pages", "getPath", array($page_id));
$id_path = $main_object->get("pages", "path");


$mn = $main_object->call("pages", "listItems", array(3345));


include(SCRIPTS_."phrases.php");
//include(INCDIR."scripts/currencies.php");

$tpl->setVar('url_prefix', $url_prefix);

if(isset($content)){

	$tpl_inner = & new easytpl(TPLDIR_."$content.tpl", "templateVariables", CACHETPLDIR_);

	if (file_exists(PHPDIR_.$content.".php")) {
		include(PHPDIR_.$content.".php");
	} else {
		//print (PHPDIR_.$content.".php LOAD FILE ERROR");
	}

	$tpl_inner->parse();
	$tpl->setCodeBlock('page_content', "include \$tpl_inner->cacheFile;");

}else{

	$tpl_inner = & new easytpl(TPLDIR_."{$data['template']}.tpl", "templateVariables", CACHETPLDIR_);

	if (file_exists(PHPDIR_.$data['template'].".php")) {
		include(PHPDIR_.$data['template'].".php");
	}

	$tpl_inner->setVar('data', $data);
	$tpl->setVar('page_data', $data);
	$tpl_inner->setVar('mod_page', '');

	$tpl_inner->parse();
	$tpl->setCodeBlock('page_content', "include \$tpl_inner->cacheFile;");

}


// Languages loop
foreach($XML_CONFIG['languages'] as $key => $val){
	if($val==1){
		$arr['title'] = strtoupper($key);
		$arr['value'] = strtolower($key);
		$arr['active'] = ($lng==$key?1:0);
		$languages[] = $arr;
	}
}
$tpl->setLoop('languages', $languages);

$tpl->setVar('lng', $lng);
$tpl->setVar('lng_'.$lng, 1);

$tpl->setVar('email', $configFile->variable['pr_email']);


// statistics
if(!isset($_SESSION['admin']['id'])) include("inc/visitor.inc.php");


include(SCRIPTS_."rss.php");
include("ajax/cart.php");

$tpl->setVar('currency', $main_object->get("products", "currency"));

$tpl->setVar('page_data', $data);

$tpl->setVar('loged_user', $_SESSION['simple_user']);

$tpl->setVar('phrases', $phrases);
$tpl->setVar('upload_url', UPLOADURL);
$tpl->setVar('upload_dir', ereg_replace(DOCROOT, "", UPLOADDIR));
$tpl->setVar('reserved_url_words', $reserved_url_words);
if(!empty($id_path)){
	$id_path[(count($id_path)-1)]['last'] = 1;
	$id_path[0]['first'] = 1;
}
$tpl->setVar('id_path', $id_path);
$tpl->setLoop('id_path', $id_path);
$tpl->setVar('config', $configFile->variable);

if(!isset($_GET['q'])) $_GET['q'] = '';
$tpl->setVar('get', $_GET);

$tpl->setVar('xml_config', $XML_CONFIG);


//ob_clean();

$_SESSION['site_lng'] = $lng;

$tpl_start_time = getmicrotime();
$tpl->parse();
include $tpl->cacheFile;
$tpl_end_time = getmicrotime();
$_SESSION['tpl_debugger_all_time'] = $tpl_end_time - $tpl_start_time;

if($_SESSION['debug']['enabled']==1){
	include_once("debug.php");
}

ob_flush();

?>
