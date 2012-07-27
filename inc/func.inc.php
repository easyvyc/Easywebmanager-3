<?php
/*
 * Created on 2007.09.24
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


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

function str2ascii($str){
	$n = strlen($str);
	for($i=0, $new_str=""; $i<$n; $i++){
		$new_str .= ord($str{$i});
	}
	return $new_str;
}


function today($lan)
{
  $months = array('lt' => array('Sausio','Vasario','Kovo','Balandžio','Gegužės','Birželio','Liepos','Rugpjūčio','Rugsėjo','Spalio','Lapkričio','Gruodžio'),
                  'en' => array('January','February','March','April','May','June','July','August','September','October','November','December'),
                  'de' => array('January','February','March','April','May','June','July','August','September','October','November','December'),
                  'ru' => array('Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря'));

  $days = array('lt' => array('Sekmadienis','Pirmadienis','Antradienis','Trečiadienis','Ketvirtadienis','Penktadienis','Šeštadienis','Sekmadienis'),
                'en' => array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),
                'de' => array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),
                'ru' => array('Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'));
  
  $year = date('Y');
  $month = date('n') - 1;
  $day = date('d');
  $dow = date('w');
  
  switch($lan)
  {
    case 'lt': return $months[$lan][$month].' '.(int)$day.' d.'; break;
    case 'ru': return (int)$day.' '.$months[$lan][$month]; break;
    case 'en': return (int)$day.' '.$months[$lan][$month]; break;
    case 'de': return (int)$day.' '.$months[$lan][$month]; break;
    default: return (int)$day.' '.translate($lan,$months['lt'][$month]); break;
  }
}

function checkSendMail($post){
	
	$error = array();
	if($post['nm']=='') $error[] = array('column'=>'nm');
	if($post['em']=='') $error[] = array('column'=>'em');
	if($post['question']=='') $error[] = array('column'=>'question');
	return $error;
	
}

function sendMail($data){

	unset($data['post']['VIEWSTATE']);
	global $configFile;
	
	include_once(CLASSDIR_."phpmailer.class.php");
	$mailer = new PHPMailer();
	
	$mailer->CharSet = "windows-1257";
	$mailer->Subject = iconv('UTF-8', 'windows-1257', "\"{$data['params']['subject']}\" -> {$configFile->variable['pr_url']}");
	$message = date('Y-m-d H:i')."\r\n";
	$mailer->ContentType = "text/plain";
	foreach($data['post'] as $key=>$val){
		if($key!='action' && $key!='submit') $message .= "$key: $val\r\n";
	}
	foreach($data['files'] as $key=>$val){
		$mailer->AddAttachment($val['tmp_name'], $val['name']);
	}
	$mailer->Body = iconv('UTF-8', 'windows-1257', $message);
	
	$mailto = (strlen($data['params']['emails'])>0?$data['params']['emails']:$configFile->variable['pr_email']);
	$mailer->AddAddress($mailto);
	$mailer->From = isset($data['post']['em'])?iconv('UTF-8', 'windows-1257', $data['post']['em']):$mailto;
	$mailer->FromName = isset($data['post']['nm'])?iconv('UTF-8', 'windows-1257', $data['post']['nm']):$configFile->variable['pr_url'];
	$mailer->Send();			
	
	return "Užklausa išsiųsta sėkmingai.";
	
}


?>