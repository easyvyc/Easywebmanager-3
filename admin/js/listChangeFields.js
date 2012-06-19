

function editField_date(id, column_name, show, hide, data){
	show_hide(show, hide);
	document.getElementById('id_' + column_name + '_' + id).value = document.getElementById(hide).innerHTML;
}

function editField_select(id, column_name, show, hide, data){
	show_hide(show, hide);
	//document.getElementById('id_' + column_name + '_' + id).value = document.getElementById(hide).innerHTML;
	document.getElementById('id_' + column_name + '_' + id).options[0] = new Option('------', 0, false, false);
	for(i=1, index=0; i<data.length+1; i++){
		document.getElementById('id_' + column_name + '_' + id).options[i] = new Option(data[(i-1)].title, data[(i-1)].id, false, data[(i-1)].title==document.getElementById(hide).innerHTML?true:false);
		if(document.getElementById('fieldContent_'+id+'_'+column_name+'_tmp').value==data[(i-1)].id){
			index = i-1;//alert(data[i].title);
		}
		document.getElementById('id_' + column_name + '_' + id).selectedIndex = index;
	}
}

function editField_radio(id, column_name, show, hide, data){
	show_hide(show, hide);
	//document.getElementById('id_' + column_name + '_' + id).value = document.getElementById(hide).innerHTML;
	document.getElementById('id_' + column_name + '_' + id).options[0] = new Option('------', 0, false, false);
	for(i=1, index=0; i<data.length+1; i++){
		document.getElementById('id_' + column_name + '_' + id).options[i] = new Option(data[(i-1)].title, data[(i-1)].id, false, data[(i-1)].title==document.getElementById(hide).innerHTML?true:false);
		if(document.getElementById('fieldContent_'+id+'_'+column_name+'_tmp').value==data[(i-1)].id){
			index = i-1;//alert(data[i].title);
		}
		document.getElementById('id_' + column_name + '_' + id).selectedIndex = index;
	}
}

function editField_checkbox_group(id, column_name, show, hide, data){
	show_hide(show, hide);
	//document.getElementById('id_' + column_name + '_' + id).value = document.getElementById(hide).innerHTML;
	document.getElementById('id_' + column_name + '_' + id).options[0] = new Option('------', 0, false, false);
	for(i=1, index=0; i<data.length+1; i++){
		document.getElementById('id_' + column_name + '_' + id).options[i] = new Option(data[(i-1)].title, data[(i-1)].id, false, data[(i-1)].title==document.getElementById(hide).innerHTML?true:false);
		if(document.getElementById('fieldContent_'+id+'_'+column_name+'_tmp').value==data[(i-1)].id){
			index = i-1;//alert(data[i].title);
		}
		document.getElementById('id_' + column_name + '_' + id).selectedIndex = index;
	}
}

field = new Object();

var xmlFunc;

//xmlFunc = new function(data){
function xmlFunc(data){
	if(data){
		if(data.xmlAttr["/items"].error==0){
			if(data.xmlAttr["/items/item"].elm_type!="checkbox"){
				if(data.xmlText["/items/item/title"]){
					if(typeof(data.xmlText["/items/item/title"])!="undefined")
						document.getElementById("value___"+field.column+"___"+field.id).innerHTML = data.xmlText["/items/item/title"];
					else
						document.getElementById("value___"+field.column+"___"+field.id).innerHTML = "";
				}else{
					if(typeof(data.xmlCData["/items/item/title"])!="undefined")
						document.getElementById("value___"+field.column+"___"+field.id).innerHTML = data.xmlCData["/items/item/title"];
					else
						document.getElementById("value___"+field.column+"___"+field.id).innerHTML = "";
				}
				show_hide("value___"+field.column+"___"+field.id, "edit___"+field.column+"___"+field.id);
			}else{
				document.getElementById("buttonImg_"+field.id+"_"+field.column).src = document.getElementById("buttonImg_"+field.id+"_"+field.column).src.replace("status_1.", "status_"+data.xmlText["/items/item/title"]+".");
				document.getElementById("buttonImg_"+field.id+"_"+field.column).src = document.getElementById("buttonImg_"+field.id+"_"+field.column).src.replace("status_0.", "status_"+data.xmlText["/items/item/title"]+".");
				document.getElementById("buttonImg_"+field.id+"_"+field.column).src = document.getElementById("buttonImg_"+field.id+"_"+field.column).src.replace("status_.", "status_"+data.xmlText["/items/item/title"]+".");
				document.getElementById("chk_"+field.id+"_"+field.column).value = document.getElementById("chk_"+field.id+"_"+field.column).value==1?0:1;
			}
		}else{
			if(data.xmlAttr["/items"].error==1){
				alert(data.xmlText["/items/error"]);
			}else{
				alert(data.xmlText["/items/error"]);
				document.location.reload();
			}
		}
	}
};

//ajaxObj.prototype.xmlFunc = xmlFunc;

function ajaxChangeFieldSelect(url, script, value, id, parent_id, column, module, lng, evt){
	//startAjax();
	var ajax = new ajaxObj();
	field.column = column;
	field.id = id;
	
	ajax.xmlFunc = xmlFunc;

	ajax.loadDoc(url + "xml.php?get=" + script + "&module="+module+"&column="+column+"&value="+value+"&id="+id+"&parent_id="+parent_id+"&lng="+lng);
	
	$('edititemvalue___'+column+'___'+id+'').value = value;
	
}


function isCtrlKeyPressed(evt){
	
	ctrlKeyPressed=0;

	if(typeof(evt)=="object") {
		if(evt.ctrlKey) ctrlKeyPressed=1;
	}else{
		if(window.event.ctrlKey) ctrlKeyPressed=1;
	}

	return ctrlKeyPressed;
	
}


function getKeyCode(evt){

	if(typeof(evt)=="object") {
		if(evt.which){
			keyCode = evt.which;
		}else{
			keyCode = evt.keyCode;
		}
	}else{
		keyCode = window.event.keyCode;
	}	
	return keyCode;
}

function ajaxChangeFieldText(url, script, value, id, parent_id, column, module, lng, evt){

	//keyCode = getKeyCode(evt);
	
	//if(ctrlKeyPressed == 1 && String.fromCharCode(keyCode)=='s'){
	//if(keyCode == 13){
	

		var ajax = new ajaxObj();
		field.column = column;
		field.id = id;
		
		ajax.xmlFunc = xmlFunc;
		
		ajax.loadDoc(url + "xml.php?get="+script+"&module="+module+"&column="+column+"&value="+encodeURI(value)+"&id="+id+"&parent_id="+parent_id+"&lng="+lng);

	//}
	/*if(keyCode == 27){
		show_hide("fieldContent_"+id+"_"+column, "fieldEdit_"+id+"_"+column);
	}*/
}

function ajaxChangeFieldTextarea(url, script, value, id, parent_id, column, module, lng, evt){

	ajaxChangeFieldText(url, script, value, id, parent_id, column, module, lng, evt);
	
	/*if(window.event.keyCode == 13){
		var ajax = new ajaxObj();
		field.column = column;
		field.id = id;
		
		ajax.xmlFunc = xmlFunc;
		
		ajax.loadDoc(url + "xml.php?get=change_catalog_item_field&module="+module+"&column="+column+"&value="+encodeURI(value)+"&id="+id+"&parent_id="+parent_id+"&lng="+lng);
	}
	if(window.event.keyCode == 27){
		show_hide("fieldContent_"+id+"_"+column, "fieldEdit_"+id+"_"+column);
	}*/
}

function ajaxChangeFieldDate(url, script, value, id, parent_id, column, module, lng, evt){
	//startAjax();
	var ajax = new ajaxObj();
	field.column = column;
	field.id = id;
	
	ajax.xmlFunc = xmlFunc;
	
	ajax.loadDoc(url + "xml.php?get="+script+"&module="+module+"&column="+column+"&value="+value+"&id="+id+"&parent_id="+parent_id+"&lng="+lng);
	
}

function ajaxChangeFieldCheckbox(url, script, value, id, parent_id, column, module, lng, evt){
	//startAjax();
	value = (value==0 || value=='')?1:0;
	var ajax = new ajaxObj();
	field.column = column;
	field.id = id;
	
	ajax.xmlFunc = xmlFunc;

	ajax.loadDoc(url + "xml.php?get="+script+"&module="+module+"&column="+column+"&value="+value+"&id="+id+"&parent_id="+parent_id+"&lng="+lng);
}

function ajaxChangeFieldImage(url, script, value, id, parent_id, column, module, lng, evt){
	
	old_value = $('img___'+column+'___'+id).src;
	if(value!=''){
		$('img___'+column+'___'+id).src="images/loading.gif";
		
	}else{
		
	}
	
}