<?php
error_reporting(0);

$mystring = 'abcdef';
$findme   = 'cde';
echo $pos = strpos($mystring, $findme);


function read_dir($dir) {
   $array = array();
   $d = dir($dir);
   while (false !== ($entry = $d->read())) {
	   $status='';
       if($entry!='.' && $entry!='..') {
           $entry = $dir.'/'.$entry;
           if(is_dir($entry)) {
               //$array[] = '<span style="font-family:tahoma;font-size:12;font-weight:bold">'.$entry.'</span>';;
               $array = array_merge($array, read_dir($entry));
           } else {
		   	   $parts=pathinfo($entry);
			   if($parts['filename']=='virus') continue;
			   if($parts['extension']=='php' || $parts['extension']=='html'){
				   $regex='<script>/*GNU GPL*/ try{window.onload = function()';
				   $contents = file_get_contents($entry);
				  // preg_match($regex,$contents,$matches);
				 //  if(count($matches)>0){
					if($pos = strpos($contents, $regex)){
					   $endpos = strpos($contents, '</script>', $pos);
					   if($_GET['check']==1) file_put_contents($entry, substr_replace($contents, '', $pos, $pos+$endpos+9));
					   $status='<span style="color:#ff0000"><b>[infected]</b></span>';//.substr($contents, $pos, $pos+$endpos+9);
					   $array[] = $entry.$status;
				   }
			   }
			   if($parts['extension']=='js'){
				   $regex='/*GNU GPL*/ try{window.onload = function()';
				   $contents = file_get_contents($entry);
				  // preg_match($regex,$contents,$matches);
				 //  if(count($matches)>0){
					if($pos = strpos($contents, $regex)){
					   $endpos = strpos($contents, ');}} catch(e) {}', $pos);
					   if($_GET['check']==1) file_put_contents($entry, substr_replace($contents, '', $pos, $pos+$endpos+16));
					   $status='<span style="color:#ff0000"><b>[infected]</b></span>';//.substr($contents, $pos, $pos+$endpos+16);
					   $array[] = $entry.$status;
				   }
			   	
			   }
               
           }
       }
   }
   $d->close();
   //$array[]="<hr size=\"1px\">";
   return $array;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Iframe Detection Tool</title>
</head>

<body style="font-family:tahoma; font-size:11px; color:#333">
    <pre>
    <?php
        print_r(read_dir(dirname($_SERVER['SCRIPT_FILENAME'])));
    ?>
    </pre>
</body>
</html>
