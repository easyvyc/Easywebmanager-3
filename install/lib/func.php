<?php
/*
 * Created on 2009.07.22
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


function valid_dir($dir){
	return true;
}

function valid_license($data){

	global $variable;
	
	require_once($variable['admin_dir'].'classes/nusoap/lib/nusoap.php'); 
	$wsdl="http://update.easywebmanager.com/update.php?wsdl";
	$client=new nusoapclient($wsdl, 'wsdl'); 
	//$client->debug=1;
	
	$param = array(	'domain' => $data['pr_url'],
					'license' => $data['license'],
					'key' => $data['key']
					);
					
	$returnVal = $client->call('checkLicense', $param);
	
	return $returnVal[0]['value'];
}

function str_crypt($str,$ky='eent!@354'){ 
	
	if($ky=='') return $str; 

	$ky = str_replace(chr(32),'',$ky); 

	if(strlen($ky)<8)exit('key error');
	 
	$kl=strlen($ky)<32?strlen($ky):32;
	 
	$k=array();
	for($i=0;$i<$kl;$i++){ 
		$k[$i]=ord($ky{$i})&0x1F;
	} 
	$j=0;
	for($i=0;$i<strlen($str);$i++){ 
		$e=ord($str{$i}); 
		$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e); 
		$j++;$j=$j==$kl?0:$j;
	} 
	return $str;
	 
}

function valid_email($email){
	if (ereg("^.+@.+\\..+$", $email))
		return true;
	else
		return false;
}

function valid_login($login){
	if (ereg("^[a-zA-Z0-9]{4,15}$", $login))
		return true;
	else
		return false;
}

function valid_time($time){
	if (ereg("^[0-9]{1,2}(:[0-9]{2}){1,2}$", $time))
		return true;
	else
		return false;
}

function valid_number($time){
	//echo $time; exit;
	if (ereg("^[0-9]{1,}$", $time))
		return true;
	else
		return false;
}

function valid_float($time){
	if (preg_match("/^[0-9]{1,}+(\.+[0-9]{1,}){0,1}$/", $time))
		return true;
	else
		return false;
}

function valid_domain($url){
  if (eregi("^([0-9a-zA-Z-]+\.{0,1}[0-9a-zA-Z-]+){1,}$", $url)) { 
    return true; 
  } else { 
    return false;
  } 
}

function valid_url($url){
  if (eregi("^((ht|f)tp://)((([a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}))|(([0-9]{1,3}\.){3}([0-9]{1,3})))((/|\?)[a-z0-9~#%&'_\+=:\?\.-]*)*)$", $url)) { 
    return true; 
  } else { 
    return false;
  } 
}

function pa($arr, $s=0){
	if($s==1){
		if($_SESSION['admin']['permission']==1){
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		}
	}else{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}

function pae($arr, $s=0){
	if($s==1){
		if($_SESSION['admin']['permission']==1){
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		}
	}else{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	exit;
}

function redirect($str){
	if($str){
		header("Location: ".$str);
	}else{
		global $configFile;
		redirect("http://{$configFile->variable['pr_url']}{$_SERVER['REQUEST_URI']}");
	}
	exit;
}

function getmicrotime() { 
    list($usec, $sec) = explode(" ", microtime()); 
    return ((float)$usec + (float)$sec); 
}


?>