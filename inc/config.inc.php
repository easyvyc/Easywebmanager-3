<?php
/** config.inc.php
	The class for storing the site configuration values
*/

error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
#session_regenerate_id();

function strip_slashes_gpc(&$data){
	foreach($data as $key=>$val){
		if(is_array($val)){
			strip_slashes_gpc($val);
		}else{
			$data[$key] = stripslashes($val);
		}
	}
}


if(get_magic_quotes_gpc()==1){
	//strip_slashes_gpc($_REQUEST);
	@strip_slashes_gpc($_POST);
	@strip_slashes_gpc($_GET);
	@strip_slashes_gpc($_COOKIES);	
}

foreach($_SERVER as $key=>$val){
	$$key = $val;
}



class ConfigFile{

	var $variable;
    var $strings;

	function ConfigFile(){
		
		/*if(isset($_SESSION['site_config']['dirpath']) && file_exists($_SESSION['site_config']['dirpath'])){
			$this->configFile = $_SESSION['site_config']['dirpath'].'/inc/settings.inc.php';
		}else{
			$this->configFile = dirname(__FILE__).'/settings.inc.php';
		}*/
		
	}
	
	function loadConfig($var){
		
		$this->variable = $var;
		
		$this->variable['site_url'] = "http://".$this->variable['pr_url'].$this->variable['project_dir'];
		$this->variable['site_admin_url'] = $this->variable['site_url'].$this->variable['admin_dir'];

		$this->variable['sb_template'] = $this->variable['pr_code']."_template";
		$this->variable['sb_text'] = $this->variable['pr_code']."_texts";
		$this->variable['sb_stat_visitor'] = $this->variable['pr_code']."_stat_visitors";
		$this->variable['sb_stat_visitor_temp'] = $this->variable['pr_code']."_stat_visitors_temp";
		$this->variable['sb_stat_visitor_path'] = $this->variable['pr_code']."_stat_visitor_path";
		$this->variable['sb_stat_country2ip'] = $this->variable['pr_code']."_stat_country2ip";
		$this->variable['sb_admins'] = $this->variable['pr_code']."_admins";
		$this->variable['sb_admin_module_rights'] = $this->variable['pr_code']."_admin_module_rights";
		$this->variable['sb_admin_stat'] = $this->variable['pr_code']."_admin_stat";
		$this->variable['sb_admin_lang_rights'] = $this->variable['pr_code']."_admin_lang_rights";
		$this->variable['sb_users_module_rights'] = $this->variable['pr_code']."_users_module_rights";
		$this->variable['sb_users_pages_rights'] = $this->variable['pr_code']."_users_pages_rights";
		$this->variable['sb_module'] = $this->variable['pr_code']."_module";
		$this->variable['sb_module_info'] = $this->variable['pr_code']."_module_info";
		$this->variable['sb_record'] = $this->variable['pr_code']."_record";
		$this->variable['sb_relations'] = $this->variable['pr_code']."_relations";
		
		
		$this->variable['show_sql_error'] = 1;
		$this->variable['update_server'] = "http://update.easywebmanager.com/update.php?wsdl";
		
	}
    
}


$main_configFile = new ConfigFile();
$configFile = new ConfigFile();
include_once(dirname(__FILE__).'/settings.inc.php');
$configFile->loadConfig($variable);

//print_r($_SESSION['site_config']);
if(isset($_SESSION['site_config']['dirpath']) && file_exists($_SESSION['site_config']['dirpath'])){
	unset($variable);
	include_once($_SESSION['site_config']['dirpath'].'/inc/settings.inc.php');
	$main_configFile->loadConfig($variable);
}else{
	$main_configFile = $configFile;
}


class tplObject {
	
	var $loops=array();
	var $vars=array();
	function tplObject(){}
	
	function set_loop($name, $value){
	    if(!empty($value)){
	    	$n = count($value);
	    	for($i=0; $i<$n; $i++){
	    		if(is_array($value)){
		    		if(!empty($value[$i])){
		    			$value[$i]['_INDEX'] = $i+1;
		    			if($i==0){
		    				$value[$i]['_FIRST'] = 1;
		    			}
		    		}
		    	}
	    	}
	     	$this->loops[$name] = $value;
	    }		
	}

	function set_var($name, $value){
	    if(is_array($value)){
	        // jei registruojamas variablas masyvas, registruojamas kiekvienas masyvas elementas
//	        $index = 1;
	        foreach($value as $k=>$v){
//	        	$v['_INDEX'] = $index++;
//	        	$v['_FIRST'] = ($index==1?1:0);
 	        	$this->set_var($name.".".$k, $v);
	        }
	    }
	    else
	        $this->vars[$name] = $value;		
	}

	function set_codeblock($name, $value){
		$this->blocks[$name] = $value;
	}
	
}

$templateVariables = new tplObject();

//$lngstr = new Language('config.inc.php');

$DB_COLS_TYPES = array(
   'VARCHAR',
   'TINYINT',
   'TEXT',
   'DATE',
   'SMALLINT',
   'MEDIUMINT',
   'INT',
   'BIGINT',
   'FLOAT',
   'DOUBLE',
   'DECIMAL',
   'DATETIME',
   'TIMESTAMP',
   'TIME',
   'YEAR',
   'CHAR',
   'TINYBLOB',
   'TINYTEXT',
   'BLOB',
   'MEDIUMBLOB',
   'MEDIUMTEXT',
   'LONGBLOB',
   'LONGTEXT',
   'ENUM',
   'SET',
   'BOOL'
);



$FORM_ELM_TYPES[] = array('value'=>'text', 'id'=>'text', 'superadmin'=>0, 'title'=>'TEXT(Trumpas tekstinis laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'textarea', 'id'=>'textarea', 'superadmin'=>0, 'title'=>'TEXTAREA(Išsamus tekstinis laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'html', 'id'=>'html', 'superadmin'=>0, 'title'=>'HTML(WYSIWYG redaktorius)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'date', 'id'=>'date', 'superadmin'=>0, 'title'=>'DATE(Datos laukelis)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'image', 'id'=>'image', 'superadmin'=>0, 'title'=>'IMAGE(Paveikslėlis)', 'w'=>3);
$FORM_ELM_TYPES[] = array('value'=>'file', 'id'=>'file', 'superadmin'=>0, 'title'=>'FILE(Failas)', 'w'=>3);
$FORM_ELM_TYPES[] = array('value'=>'radio', 'id'=>'radio', 'superadmin'=>0, 'title'=>'RADIO(Perjungiklių pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'checkbox', 'id'=>'checkbox', 'superadmin'=>0, 'title'=>'CHECKBOX(Pasirinkimas)', 'w'=>1);
$FORM_ELM_TYPES[] = array('value'=>'checkbox_group', 'id'=>'checkbox_group', 'superadmin'=>0, 'title'=>'CHECKBOX_GROUP(Daugybinis pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'select', 'id'=>'select', 'superadmin'=>0, 'title'=>'SELECT(Pasirinkimas iš sąrašo)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'autocomplete', 'id'=>'autocomplete', 'superadmin'=>0, 'title'=>'AUTOCOMPLETE(Pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'hidden', 'id'=>'hidden', 'superadmin'=>1, 'title'=>'HIDDEN(Paslėptas laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'password', 'id'=>'password', 'superadmin'=>1, 'title'=>'PASSWORD(Slaptažodis)', 'w'=>10);
//$FORM_ELM_TYPES[] = array('value'=>'icon', 'id'=>'icon', 'superadmin'=>1, 'title'=>'Ikona(file)', 'w'=>3);
$FORM_ELM_TYPES[] = array('value'=>'submit', 'id'=>'submit', 'superadmin'=>0, 'title'=>'SUBMIT(Formos patvirtinimo mygtukas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'button', 'id'=>'button', 'superadmin'=>1, 'title'=>'BUTTON(Mygtukas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'list', 'id'=>'list', 'superadmin'=>1, 'title'=>'LIST(Sąrašas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'tree', 'id'=>'tree', 'superadmin'=>1, 'title'=>'TREE(Medis)', 'w'=>2);
//$FORM_ELM_TYPES[] = array('value'=>'custom', 'id'=>'custom', 'superadmin'=>1, 'title'=>'Custom(custom)', 'w'=>10);
//$FORM_ELM_TYPES[] = array('value'=>'separator', 'id'=>'separator', 'superadmin'=>1, 'title'=>'Skirtukas(separator)', 'w'=>1);

include(dirname(__FILE__).'/defines.inc.php');
include(dirname(__FILE__).'/systemfunc.inc.php');


$old_error_handler = set_error_handler("errorHandler");

// if install.php file exist, site not work
if(file_exists(DOCROOT."install.php")){
	trigger_error("Please remove or rename install.php file", E_USER_ERROR);
}


include_once(CLASSDIR_."xmlfile.class.php");

include_once(CLASSDIR_."cache.class.php");

//if($configFile->variable['installed']==1){
	include_once(CLASSDIR_."database.class.php");
	$database = & new database($main_configFile->variable['hostname'], $main_configFile->variable['username'], $main_configFile->variable['password'], $main_configFile->variable['database']) or die("Mysqlerr ".mysql_error());
/*}else{
	if(!$install) redirect("../{$configFile->variable['admin_dir']}install.php");
}*/

include_once(CLASSDIR_."module.class.php");
$module = new module();

if(!isset($user_side) || $user_side==false){
	
	ini_set("session.gc_maxlifetime", ADMIN_SESSION_TIMEOUT * 60);
	
	if(!isset($_SESSION['admin_interface_language'])) $_SESSION['admin_interface_language'] = 'lt';
	include_once(LANGUAGESDIR.$_SESSION['admin_interface_language'].".php");
	
}

$xmlFile = DOCROOT.'files/data/search.xml';
$xmlFileObj = new File;
$XML_CONFIG = $search_engines = $xmlFileObj->xmlFileToArray($xmlFile);		

//$xmlFile = DATADIR.'config.xml';
//$configModule = File::xmlFileToArray($xmlFile); 

?>
