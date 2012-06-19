var HTML_OBJ;

function getDefaultFieldTemplate(elm_type, use_standart_tpl, fck, userside){
	
	HTML_OBJ = fck;
	
	if(use_standart_tpl.checked == true && elm_type.options[elm_type.selectedIndex].value != ''){
		
		document.getElementById('area_id_field_html').style.display = 'block';
		url = CONFIG_SITE_URL + "xml.php?get=DefaultFieldTemplate&tpl=" + elm_type.options[elm_type.selectedIndex].value + (userside==1?"&userside=1":"");
		
		 if (window.XMLHttpRequest) {
		     req = new XMLHttpRequest();
		     req.onreadystatechange = process_getDefaultFieldTemplate;
		     req.open("GET", url, true);
		     req.send(null);
		 } else if (window.ActiveXObject) {
		     isIE = true;
		     req = new ActiveXObject("Microsoft.XMLHTTP");
		     if (req) {
		         req.onreadystatechange = process_getDefaultFieldTemplate;
		         //alert(req.onreadystatechange);
		         req.open("GET", url, true);
		         req.send();
		     }
		 }		
		
	}else{
		document.getElementById('area_id_field_html').style.display = 'none';
	}
	
}

function process_getDefaultFieldTemplate(){

	if (req.readyState == 4) {
		if (req.status == 200) {
			//document.forms['save'].elements['field_html'].value = req.responseText;
			if(document.frames['field_html___FrameName'].FCK.EditMode == FCK_EDITMODE_WYSIWYG)
				document.frames['field_html___FrameName'].FCK.EditorDocument.body.innerHTML = req.responseText;
			else
				document.frames['___FrameName'].document.getElementById('eSourceField').value = req.responseText;
		}
	}
	
}

function getDefaultModuleTemplate(use_standart_tpl, fck, module_id){
	
	HTML_OBJ = fck;
	
	if(use_standart_tpl.checked == true){

		document.getElementById('area_id_area_html').style.display = 'block';
		url = CONFIG_SITE_URL + "xml.php?get=DefaultModuleTemplate&module_id=" + module_id;

		 if (window.XMLHttpRequest) {
		     req = new XMLHttpRequest();
		     req.onreadystatechange = process_getDefaultModuleTemplate;
		     req.open("GET", url, true);
		     req.send(null);
		 } else if (window.ActiveXObject) {
		     isIE = true;
		     req = new ActiveXObject("Microsoft.XMLHTTP");
		     if (req) {
		         req.onreadystatechange = process_getDefaultModuleTemplate;
		         //alert(req.onreadystatechange);
		         req.open("GET", url, true);
		         req.send();
		     }
		 }		
		
	}else{
		document.getElementById('area_id_area_html').style.display = 'none';
	}
	
}

function process_getDefaultModuleTemplate(){

	if (req.readyState == 4) {
		if (req.status == 200) {
			//document.forms['save'].elements['field_html'].value = req.responseText;
			if(document.frames['area_html___Frame'].FCK.EditMode == FCK_EDITMODE_WYSIWYG)
				document.frames['area_html___Frame'].FCK.EditorDocument.body.innerHTML = req.responseText;
			else
				document.frames['area_html___Frame'].document.getElementById('eSourceField').value = req.responseText;
		}
	}
	
}