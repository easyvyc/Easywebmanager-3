<?php

$BASE_URL = $configFile->variable['site_url'];

define('EASYWEBMANAGER_VERSION', "3.8");

// admin side
define('DOCROOT', $_SERVER['DOCUMENT_ROOT']."{$configFile->variable['project_dir']}");
define('INCDIR', DOCROOT.'inc/');
define('CLASSDIR', DOCROOT.$configFile->variable['admin_dir']."classes/");
define('NUSOAPDIR', CLASSDIR."nusoap/lib/");
define('TPLDIR', DOCROOT.'tpls/');
define('CACHETPLDIR', DOCROOT.$configFile->variable['admin_dir'].'cache/etpl/');
define('FUNCDIR', INCDIR.'functions/');
define('MODULESDIR', DOCROOT.$configFile->variable['admin_dir'].'modules/');
define('LANGUAGESDIR', DOCROOT.$configFile->variable['admin_dir'].'lib/languages/');


//set files directories
$PATH_FROM_BASE_DIR = $_SERVER['DOCUMENT_ROOT']."{$main_configFile->variable['project_dir']}";
define('FILESDIR', $PATH_FROM_BASE_DIR."files/");
define('FILESURL', $BASE_URL."files/");

define('AJAXDIR', $PATH_FROM_BASE_DIR."xml/");
define('AJAXURL', $configFile->variable['site_url']."xml/");

define('FCKDIR', $_SERVER['DOCUMENT_ROOT'].$configFile->variable['project_dir'].$configFile->variable['admin_dir'].'lib/fcked/');
define('FCKBASEPATH', $configFile->variable['project_dir'].$configFile->variable['admin_dir'].'lib/fcked/');
define('FCKFILESBASEPATH', $main_configFile->variable['project_dir'].'files/f/');

define('ADMIN_SESSION_TIMEOUT', 30);// minutes
define('ADMIN_LOGIN_STATS', 365);


// user side
define('DOCROOT_', ereg_replace($main_configFile->variable['admin_dir'], "", $_SERVER['DOCUMENT_ROOT'])."{$main_configFile->variable['project_dir']}");
define('INCDIR_', DOCROOT_.'inc/');
define('SITEDIR_', DOCROOT_.'site/');
define('CLASSDIR_', SITEDIR_.'classes/');
define('TPLDIR_', SITEDIR_.'tpl/');
define('PHPDIR_', SITEDIR_.'php/');
define('SCRIPTS_', SITEDIR_.'scripts/');

//set files directories
$PATH_FROM_BASE_DIR = "";


define('CACHEDIR', FILESDIR."cache/");
define('CACHETPLDIR_', CACHEDIR."tpl/");
define('CACHEDATADIR_', CACHEDIR."data/");
define('CACHEIMGDIR_', CACHEDIR."img/");


define('IMAGESDIR', FILESDIR."images/");
define('IMAGESURL', FILESURL."images/");

define('UPLOADDIR', FILESDIR."upload/");
define('UPLOADURL', FILESURL."upload/");

define('DOCUMENTSDIR', FILESDIR."documents/");
define('DOCUMENTSURL', FILESURL."documents/");

define('ICOTPLDIR', FILESDIR."ico_tpl/");
define('ICOTPLURL', FILESURL."ico_tpl/");

define('DATADIR', FILESDIR."data/");
define('DATAURL', FILESURL."data/");

define('FCKDIR_', DATADIR.'fcked/');
define('FCKBASEPATH_', $configFile->variable['project_dir'].'files/data/fcked/');

define('RESULTS_PAGING', 5);

// statistika
//define('STAT_DAY_VISITORS_PAGING_VALUE', 30); // statistikos irasu puslapiavimas
//define('HOURS_UNIQUE_VISITOR', 3); // po x val tas pats ip gali buti naujas unikalus lankytojas
//define('MONTHS_COUNT_STORING_STAT', 24); // x menesiu senumo irasai is statistiko pasalinami 
//define('MAX_STAT_ITEMS', 10); // skritulinese diagramose maximalus reikmsiu skaicius

define('CURRENT_URL', $configFile->variable['site_url'].$lng.$_SERVER['PATH_INFO']);

$default['page'] = "list";

// from class
$n = count($FORM_ELM_TYPES);
for($i=0; $i<$n; $i++){
	define('FRM_'.strtoupper($FORM_ELM_TYPES[$i]['value']), $FORM_ELM_TYPES[$i]['value']);	
}

define('PREFIX', '.php');



$valid_images = array('gif', 'png', 'jpg', 'jpeg');
$valid_archives = array('zip');
$denied_upload_files = array('php', 'pl', 'exe', 'phtml', 'php3', 'inc');

$BROWSERS = array (
   "MSIE",            // parent
	"FIREFOX",   
	"MOZILLA",        // parent	
	"OPERA",
   "NETSCAPE",
   "SAFARI"
);

//$IN_ONE_PAGE_LIST[] = array('value'=>3);
$IN_ONE_PAGE_LIST[] = array('value'=>10);
$IN_ONE_PAGE_LIST[] = array('value'=>20);
$IN_ONE_PAGE_LIST[] = array('value'=>30);
$IN_ONE_PAGE_LIST[] = array('value'=>50);
$IN_ONE_PAGE_LIST[] = array('value'=>100);
$IN_ONE_PAGE_LIST[] = array('value'=>150);
$IN_ONE_PAGE_LIST[] = array('value'=>200);

define('DEFAULT_PAGING', 20);

$FORM_TYPES_NON_EXPORT = array(FRM_SUBMIT, FRM_BUTTON, FRM_LIST, FRM_HIDDEN, FRM_PASSWORD, FRM_TREE);

include_once(dirname(__FILE__)."/func.inc.php");
include_once(dirname(__FILE__)."/variables.inc.php");

?>