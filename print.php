<?php
/*
 * Created on 2006.5.24
 * print.php
 * Vytautas
 */
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<script>

function setInfo(){
	var title = window.opener.document.getElementById('data_title');
	var text = window.opener.document.getElementById('data_text');
	//var mod = window.opener.document.getElementById('data_mod');
	if(title) document.getElementById('title').innerHTML = title.innerHTML;
	if(text) document.getElementById('text').innerHTML = text.innerHTML;// + mod.innerHTML;
	document.getElementById('source').innerHTML = "Source: " + window.opener.location.href;

	var arr_form = document.getElementsByTagName("form");
	for(var i=0; i<arr_form.length; i++){
		arr_form[i].outerHTML = '';
	}

	
	window.print();
}

</script>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="stylesheet" type="text/css" href="css/print.css" />

</head>
<body onload="javascript: setInfo();" topmargin="10" bottommargin="10" leftmargin="10" rightmargin="10" scroll="auto">
<div class="print_main">
<div id="text"></div>
<br><br>
<div id="source"></div>
</div>
</body>
