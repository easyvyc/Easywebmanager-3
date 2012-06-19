<?php

function required($val){
	if(strlen($val)==0) return true;
	return false;
}

function valid_email($email){
	if (ereg("^.+@.+\\..+$", $email))
		return false;
	else
		return true;
}

function valid_login($login){
	if (ereg("^[a-zA-Z0-9]{4,15}$", $login))
		return false;
	else
		return true;
}

function valid_time($time){
	if (ereg("^[0-9]{1,2}(:[0-9]{2}){1,2}$", $time))
		return false;
	else
		return true;
}

function valid_number($time){
	//echo $time; exit;
	if (ereg("^[0-9]{1,}$", $time))
		return false;
	else
		return true;
}

function valid_price($time){
	if (preg_match("/^[0-9]{1,}+(\.+[0-9]{1,2}){0,1}$/", $time))
		return false;
	else
		return true;
}

function valid_float($time){
	if (preg_match("/^[0-9]{1,}+(\.+[0-9]{1,}){0,1}$/", $time))
		return false;
	else
		return true;
}

function valid_banner($filename){
	
	$arr = explode(".", $filename);
	$VALID_BANNER_FORMAT[] = "jpg";
	$VALID_BANNER_FORMAT[] = "swf";
	$VALID_BANNER_FORMAT[] = "jpeg";
	$VALID_BANNER_FORMAT[] = "gif";
	$VALID_BANNER_FORMAT[] = "png";
	$VALID_BANNER_FORMAT[] = "bmp";
	if (in_array($arr[(count($arr)-1)], $VALID_BANNER_FORMAT))
		return false;
	else
		return true;
}

function valid_banner_size($time){
	if (preg_match("/^[0-9]{1,}+x{1}+[0-9]{1,}$/", $time))
		return false;
	else
		return true;
}

function valid_url($url){
  if (!eregi("^((ht|f)tp://)((([a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}))|(([0-9]{1,3}\.){3}([0-9]{1,3})))((/|\?)[a-z0-9~#%&'_\+=:\?\.-]*)*)$", $url)) { 
    return 1; 
  } else { 
    return 0; 
  } 
}

function valid_page_url($url){
  global $XML_CONFIG;
  if($_POST['generate_url']==1) return 0;
  if($XML_CONFIG['lng_in_url']==1) $url = substr($url, 2);
  if(!preg_match("/^\/{1}([a-zA-Z0-9\.\-]|_|\/){0,}$/", $url)){ 
    return 1; 
  } else { 
    return 0; 
  } 
}

function valid_card_number($time){
	if (preg_match("/^[0-9]{4}+\-[0-9]{4}+\-[0-9]{4}+\-[0-9]{4}$/", $time))
		return false;
	else
		return true;
}

function valid_card_expire_date($time){
	if (preg_match("/^20+[0-9]{2}+\-[0|1]{1}+[0-9]{1}$/", $time))
		return false;
	else
		return true;
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

function file_size_info($filesize) {
	global $configFile; 
 	$bytes = array('KB', 'KB', 'MB', 'GB', 'TB'); # values are always displayed  
 	if ($filesize < 1024) $filesize = 1; # in at least kilobytes. 
 	for ($i = 0; $filesize > 1024; $i++) 
 		$filesize /= 1024; 
 	$file_size_info['size'] = ceil($filesize); 
 	$file_size_info['type'] = $bytes[$i]; 
	return $file_size_info; 
}

function checkFloat($value){
	$val = is_array($value)?$value['value']:$value;
	if(!preg_match("/^(\d+)\.(\d+)$/", $val)
	&&	!preg_match("/^\d+$/", $val)) 			return 1;
	else										return 0;
}

function checkNumber($val){
	$val = is_array($value)?$value['value']:$value;
	if(!preg_match("/^\d+$/", $val))	return 1;
	else								return 0;
}

function isUploadedFile($value){
	$val = is_array($value)?$value['name']:$value;
	if(!is_uploaded_file($_FILES[$val]['tmp_name'])&&!file_exists(DOCUMENTSDIR."dump.sql"))
		return 1;
	else
		return 0;
}

function setPermissions($target, $prm){
	chmod($target, $prm);
	if(is_dir($target)){
		if ($handle = opendir($target)) {
		    while (false !== ($file = readdir($handle))) { 
		        if ($file != "." && $file != "..") {
		        	//echo $file." d<br>"; 
		            setPermissions($target."/".$file, $prm); 
		        } 
		    }
		    closedir($handle); 
		}		
	}
}

function getValueParams($string, $s1="::", $s2="=", $s3){
	
	$arr = explode($s1, $string);
	foreach($arr as $key=>$val){
		$_arr = explode($s2, $val);
		if($s3){
			$__arr = explode($s3, $_arr[1]);
			if(count($__arr)>1)
				$params[$_arr[0]] = $__arr;
			else
				$params[$_arr[0]] = $_arr[1];
		}else{
			$params[$_arr[0]] = $_arr[1];
		}
	}
	return $params;
	
}


function getValueParamsImages($string, $s1="::", $s2="||", $s3="="){
	
	$arr = explode($s1, $string);
	foreach($arr as $k1=>$v1){
	
			$_arr = explode($s2, $v1);
			//pa($arr);
			foreach($_arr as $k2=>$v2){
				$__arr = explode($s3, $v2);
				if($__arr[0]=="size"){
					$___arr = explode("x", $__arr[1]);
					$params[$k1][$__arr[0].'_width'] = $___arr[0];
					$params[$k1][$__arr[0].'_height'] = $___arr[1];
				}else{
					$params[$k1][$__arr[0]] = $__arr[1];	
				}
			}
	}
	return $params;
	
}


function parse_default_value($str){
	
	$str = preg_replace("/\\$/", "", $str);
	preg_match_all('/^([a-zA-Z0-9_]{1,})/i', $str, $matches);
	$value = $GLOBALS[$matches[1][0]];
	if(preg_match_all('/\\[\'([a-zA-Z0-9_]{1,})\'\\]/i', $str, $matches)){
		foreach($matches[1] as $val){
			$value = $value[$val];
		}
	}
	return $value;

}

function generatePassword($plength)
{

	// First we need to validate the argument that was given to this function
	// If need be, we will change it to a more appropriate value.
	if(!is_numeric($plength) || $plength <= 0)
    {
        $plength = 8;
    }
    if($plength > 32)
    {
        $plength = 32;
    }

	// This is the array of allowable characters.  The ones in this array
	// are restricted to alphanumeric.
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	
	// This is important:  we need to seed the random number generator
	mt_srand(microtime() * 1000000);

    // Now we simply generate a random string based on the length that was
    // requested in the function argument
    for($i = 0; $i < $plength; $i++)
    {
        $key = mt_rand(0,strlen($chars)-1);
        $pwd = $pwd . $chars{$key};
    }

    // Finally to make it a bit more random, we switch some characters around
    for($i = 0; $i < $plength; $i++)
    {
        $key1 = mt_rand(0,strlen($pwd)-1);
        $key2 = mt_rand(0,strlen($pwd)-1);

        $tmp = $pwd{$key1};
        $pwd{$key1} = $pwd{$key2};
        $pwd{$key2} = $tmp;
    }

    return $pwd;
}

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){ 
    $first_of_month = gmmktime(0,0,0,$month,1,$year); 
    #remember that mktime will automatically correct if invalid dates are entered 
    # for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998 
    # this provides a built in "rounding" feature to generate_calendar() 

    $day_names = array(); #generate all the day names according to the current locale 
    for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday 
        $day_names[$n-1] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name
    $day_names[7] = $day_names[-1];
    unset($day_names[-1]);

    list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month)); 
    $weekday = ($weekday + 7 - $first_day) % 7 - 1; #adjust for $first_day
    if($weekday == -1) $weekday = 6;
    $title   = ucfirst(iconv("windows-1257", "UTF-8", $month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names 

    #Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03 
    @list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable 
    if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;'; 
    if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>'; 
    $calendar = '<table class="calendar">'."\n". 
        '<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>"; 

    if($day_name_length){ #if the day names should be shown ($day_name_length > 0) 
        #if day_name_length is >3, the full name of the day will be printed
        foreach($day_names as $d) 
            $calendar .= '<th abbr="'.htmlentities($d).'">'.iconv("windows-1257", "UTF-8", $d).'</th>'; 
        $calendar .= "</tr>\n<tr>"; 
    } 

    if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days 
    for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){ 
        if($weekday == 7){ 
            $weekday   = 0; #start a new week 
            $calendar .= "</tr>\n<tr>"; 
        } 
        if(isset($days[$day]) and is_array($days[$day])){ 
            @list($link, $classes, $content, $value) = $days[$day]; 
            if(is_null($content))  $content  = $day; 
            $calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>'). 
                ($link ? '<input type=hidden name=date['.$year.'-'.$month.'-'.$day.'] value="'.$value.'" id=day_'.$year.'_'.$month.'_'.$day.'><a id="day_id_'.$year.'_'.$month.'_'.$day.'" href="'.htmlspecialchars($link).'" class="'.($value==1?'active':'passive').'">'.$content.'</a>' : $content).'</td>'; 
        } 
        else $calendar .= "<td>$day</td>"; 
    } 
    if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days 

    return $calendar."</tr>\n</table>\n"; 
} 


function output_file($content, $name){
	
	//do something on download abort/finish
	//register_shutdown_function( 'function_name'  );
	
	$size = mb_strlen($content);
	$name = rawurldecode($name);
	
	if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
		$UserBrowser = "Opera";
	elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
		$UserBrowser = "IE";
	else
		$UserBrowser = '';
	
	/// important for download im most browser
	$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
	@ob_end_clean(); /// decrease cpu usage extreme
	header('Content-Type: ' . $mime_type);
	header('Content-Disposition: attachment; filename="'.$name.'"');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header('Accept-Ranges: bytes');
	header("Cache-control: private");
	header('Pragma: private');
	
	/////  multipart-download and resume-download
	if(isset($_SERVER['HTTP_RANGE'])){
		list($a, $range) = explode("=",$_SERVER['HTTP_RANGE']);
		str_replace($range, "-", $range);
		$size2 = $size-1;
		$new_length = $size-$range;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range$size2/$size");
	}else{
		$size2=$size-1;
		header("Content-Length: ".$size);
	}
	
	print($content);//echo($buffer); // is also possible
	flush();
		
	
	die();
}

function createFolders($root, $path){
	
	clearstatcache();
	if(!file_exists($root.$path)){
		$arr = explode("/", $path);
		foreach($arr as $key=>$val){
			$n_path .= $val."/";
			if(!file_exists($root.$n_path)){
				mkdir($root.$n_path, 0777);
			}
		}
	}
	
}

function format_html_code($code){

	$code = preg_replace("/<a([^>]*?)>/si", "[a\\1]", $code);
	$code = preg_replace("/<\/a>/si", "[/a]", $code);

	$code = preg_replace("/<br([^>]*?)>/si", "[br]", $code);

	$code = preg_replace("/<b([^>]*?)>/si", "[b]", $code);
	$code = preg_replace("/<\/b>/si", "[/b]", $code);

	$code = preg_replace("/<strong([^>]*?)>/si", "[b]", $code);
	$code = preg_replace("/<\/strong>/si", "[/b]", $code);

	$code = preg_replace("/<em([^>]*?)>/si", "[i]", $code);
	$code = preg_replace("/<\/em>/si", "[/i]", $code);
	
	$code = preg_replace("/<i([^>]*?)>/si", "[i]", $code);
	$code = preg_replace("/<\/i>/si", "[/i]", $code);

	$code = preg_replace("/<u([^>]*?)>/si", "[u]", $code);
	$code = preg_replace("/<\/u>/si", "[/u]", $code);
	
	
	$code = preg_replace("/<p([^>]*?)>/si", "[p]", $code);
	$code = preg_replace("/<\/p>/si", "[/p]", $code);
	
	$code = addcslashes($code, "'");
	
	return $code;
	
}

function unformat_html_code($code){
	
	$code = preg_replace("/\[a([^>]*?)\]/si", "<a\\1 target=\"_blank\">", $code);
	$code = preg_replace("/\[\/a\]/si", "</a>", $code);

	$code = preg_replace("/\[br([^>]*?)\]/si", "<br>", $code);

	$code = preg_replace("/\[b([^>]*?)\]/si", "<b>", $code);
	$code = preg_replace("/\[\/b\]/si", "</b>", $code);

	$code = preg_replace("/\[i([^>]*?)\]/si", "<i>", $code);
	$code = preg_replace("/\[\/i\]/si", "</i>", $code);

	$code = preg_replace("/\[u([^>]*?)\]/si", "<u>", $code);
	$code = preg_replace("/\[\/u\]/si", "</u>", $code);


	$code = preg_replace("/\[p([^>]*?)\]/si", "<p>", $code);
	$code = preg_replace("/\[\/p\]/si", "</p>", $code);

	return $code;
	
}

function calculatePrice($price, $currency_course, $discount){
	
	if(isset($currency_course)) $price = $price/$currency_course;
	if(isset($discount)) $price = $price - $price*$discount/100;
	return number_format($price,2,'.','');
	
}


function generatePaging($offset, $count, $limit, $RESULTS_PAGING){

	$paging_count = ceil($count/$limit); $tmp_number = 0; $paging_start = 0; $paging_end = $paging_count;
	
	if($paging_count > $RESULTS_PAGING * 2){
		$paging_start = $offset - $RESULTS_PAGING;
		if($paging_start < 0){
			$tmp_number = -1 * $paging_start;
			$paging_arr['paging_end_arrow'] = 1;
		}
		$paging_end = $offset + $RESULTS_PAGING + $tmp_number;
		$tmp_number = 0;
		if($paging_end > $paging_count){
			$tmp_number = $paging_end - $paging_count;
		}
		$paging_start = $offset - $RESULTS_PAGING - $tmp_number;
		
		if(($offset - $RESULTS_PAGING)>0){
			$paging_arr['paging_start_arrow'] = 1;
		}
		if(($offset + $RESULTS_PAGING)<$paging_count){
			$paging_arr['paging_end_arrow'] = 1;
		}
	}

	$paging_arr['paging_end_arrow_value'] = $offset+1;
	$paging_arr['paging_start_arrow_value'] = $offset-1;
	
	for($i=0, $arr=array(), $paging=array(); $i<$paging_count && floor(($count-1)/$limit)>0; $i++){
		$arr['value'] = "$i";
		$arr['title'] = ($i * $limit + 1)."..".($i + 1)*$limit;
		$arr['active'] = $offset==$i?1:0;
		if($i>=$paging_start && $i<=$paging_end){
			$paging[] = $arr;	
		}
	}
	$paging_arr['is_paging'] = count($paging)>1?1:0;
	$paging_arr['loop'] = $paging;
	
	return $paging_arr;

}

function csv_to_arr($file, $separator=",", $encoding="windows-1257", $sep_title="***"){
	
	include_once(CLASSDIR.'csvreader/FileReader.php');
	include_once(CLASSDIR.'csvreader/CSVReader.php');

	$reader = new CSVReader( new FileReader($file) );

	$reader->setSeparator($separator);
	
	$row = 0; $_data = false;
	while( false != ( $cell = $reader->next() ) ){
		$n = count($cell);
		$csv_['error'] = "1";
		if($row == 0){
			for ($i=0; $i<$n; $i++ ){
				$columns[$i]['name'] = strtolower($cell[$i]);
//				if($encoding != "UTF-8")
//					$columns[$i]['name'] = iconv($encoding, "UTF-8", $columns[$i]['name']);
			}
		}
		if($row == 1){
			for ($i=0; $i<$n; $i++ ){
				if($encoding != "UTF-8")
					$columns[$i]['title'] = iconv($encoding, "UTF-8", $cell[$i]);
				else
					$columns[$i]['title'] = $cell[$i];
			}
		}
		if($_data === true){
			for ($i=0; $i<$n; $i++ ){
				if(isset($columns[$i]['name']) && strlen($columns[$i]['name']))
					if($encoding != "UTF-8")
						$data[$columns[$i]['name']] = iconv($encoding, "UTF-8", $cell[$i]);
					else
						$data[$columns[$i]['name']] = $cell[$i];
			}
			$csv[] = $data;
		}
		if($cell[0] == $sep_title){
			$_data = true;
			$csv_['error'] = "";
		}
		$row++;
		
	}
	$csv_['data'] = $csv;
	$csv_['cols'] = $columns;
	return $csv_;
}

function getDefaultFieldTemplate($column){
	//pae($column);
	$file = MODULESDIR."forms/".$column['elm_type'].".tpl";
	if(file_exists($file) && $column['elm_type']!=''){
		$h = fopen($file, "r");
		$str = fread($h, filesize($file));
		fclose($h);
	}
	return $str;
	
}

function comb($a){	
	$out = array();	
	if (count($a) == 1) {		
		$x = array_shift($a);		
		foreach ($x as $v) $out[] = array($v);		
		return $out;	
	}	
	foreach ($a as $k => $v){		
		$b = array_slice($a,$k+1);		
		$x = comb($b);		
		foreach ($v as $v1){			
			foreach ($x As $v2) {		
				$out[] = $test_arr = array_merge(array($v1), $v2);
			}
		}	
	}	
	return $out;
}


function combi($a){
	$x = comb($a);
	foreach($x as $val)
		if(count($val)==count($a)) $XX[] = $val;
	return $XX;
}

function errorHandler($errno, $errmsg, $filename, $linenum, $vars){
	
	global $main_configFile, $user_side;
	
    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s");

    // define an assoc array of error string
    // in reality the only entries we should
    // consider are 2,8,256,512 and 1024
    $errortype = array (
                1    =>  "Error",
                2    =>  "Warning",
                4    =>  "Parsing Error",
                8    =>  "Notice",
                16   =>  "Core Error",
                32   =>  "Core Warning",
                64   =>  "Compile Error",
                128  =>  "Compile Warning",
                256  =>  "User Error",
                512  =>  "User Warning",
                1024 =>  "User Notice",
                2048 =>  "Strict"
                );
    
    // set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

	if($errno!=8 && $errno!=1024 && $errno!=2048 && $errno!=2 && $errno!=512 && $errno!=8192){
		
		if($main_configFile->variable['send_error_email']==1){
			
			if(!in_array($_SERVER['REQUEST_URI'], $_SESSION['debug_errors'])){
				include_once(CLASSDIR_."phpmailer.class.php");
				$mailer = new PHPMailer();
				$mailer->CharSet = "UTF-8";
				$mailer->ContentType = "text/plain";
				$mailer->Subject = "ERROR {$main_configFile->variable['pr_url']}";
				$mailer->Body = "Date: $dt\nErrornum: $errno\nUrl: {$_SERVER['REQUEST_URI']}\nReferer: {$_SERVER['HTTP_REFERER']}\nErrortype: {$errortype[$errno]}\nErrormsg: $errmsg\nScriptname: $filename\nScriptlinenum: $linenum\n\nDebugtrace:\n".print_r(debug_backtrace(), true);
				$mailer->From = "no-reply@easywebmanager.com";
				$mailer->FromName = "Easywebmanager";
				$mailer->AddAddress($main_configFile->variable['error_email']);
				$mailer->Send();
				$_SESSION['debug_errors'][] = $_SERVER['REQUEST_URI'];
			}
						
			if($user_side==1) redirect($main_configFile->variable['site_url']);
			
		}else{

		    $err = "<errorentry>\n";
		    $err .= "\t<datetime>" . $dt . "</datetime>\n";
		    $err .= "\t<errornum>" . $errno . "</errornum>\n";
		    $err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
		    $err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
		    $err .= "\t<scriptname>" . $filename . "</scriptname>\n";
		    $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";
		
		    /*if (in_array($errno, $user_errors))
		        $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";*/
		    $err .= "</errorentry>\n\n";		

			ob_clean();
			header("Content-type: text/xml");
			header("Cache-Control: no-store, no-cache");
			header("Pragma: no-cache");
			header("Expires: 0");
		    echo $err;
		    exit;
		}
	}
	
}

?>
