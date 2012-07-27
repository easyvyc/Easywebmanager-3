var selected_color = '#eecc99'
var old_color = '#DDDDDD';
var origCols; // global to save previous setting

var build_function = "buildTopicList";


// resize lefthand franem
/*function resizeLeftFrame(left) {
    var frameset = document.getElementById("main");
    arr = frameset.cols.split(",");
    frameset.cols = "2,15,0,"+left+","+arr[4]+","+arr[5]+","+arr[6]+","+arr[7]+","+arr[8]+"";
}*/

/*function restoreFrame() {
    document.getElementById("main").cols = origCols;
    origCols = null;
}*/


function get_geoipStat(country, city){

	document.getElementById('filteritem___country').value=country;
	document.getElementById('filteritem___city').value=city;
	document.forms['filter'].submit();

}


function toggleFrame(element) {

    var frameset = document.getElementById("main");
    
    arr = frameset.cols.split(",");
    
    if (arr[2]==0) {
        frameset.cols = arr[0]+","+arr[1]+",2,270"+","+arr[4]+","+arr[5]+","+arr[6]+","+arr[7]+"";
         element.innerHTML="«";
    } else {
        frameset.cols = arr[0]+","+arr[1]+",0,0"+","+arr[4]+","+arr[5]+","+arr[6]+","+arr[7]+"";
         element.innerHTML="»";
    }
    
}


// resize main frame
function toggleDesktopFrame(action) {

    var frameset = document.getElementById("main");
    arr = frameset.cols.split(",");
    
    if (action==0) {
        frameset.cols = ""+arr[0]+","+arr[1]+","+arr[2]+","+arr[3]+","+arr[4]+",*,2,0,0";
    } else {
        frameset.cols = ""+arr[0]+","+arr[1]+","+arr[2]+","+arr[3]+","+arr[4]+",0,0,*,2";
    }
}



function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	return [curleft,curtop];
}

function show_hide(show, hide)
{
	var obj = document.getElementById(show);
	obj.style.display = 'block';
	obj = document.getElementById(hide);
	obj.style.display = 'none';
}

function show(elm){
	var obj = document.getElementById(elm);
	if(obj) obj.style.display = 'block';
}

function hide(elm){
	var obj = document.getElementById(elm);
	if(obj) obj.style.display = 'none';
}

function setStyle(elm, style){
	var obj = document.getElementById(elm);
	if(obj) obj.className = style;	
}

function change_language(lng){
	var n = languages.length;
	var obj;
	for(i=1; i<n; i++){
		hide('lng_' + languages[i]);
		obj = parent.tree.document.getElementById('lng_' + languages[i]);
		if(obj) obj.className = 'visible_no';
	}
	show('lng_' + lng);
	obj = document.getElementById('form_language');
	if(obj)	obj.value = lng;
	obj = parent.tree.document.getElementById('lng_' + lng);
	if(obj) obj.className = 'visible_yes';
}

function setEdited(column_name){
    var obj = document.getElementById('area_id_'+column_name);
    obj.className = obj.className + ' edited';
    document.getElementById('edited_field_'+column_name).value = 1;
    edited_element = true;
}

function is_edited_element(txt){
    if(top.content.edited_element){
        event.returnValue = txt;
    }
}

function switchMode(str){
    var obj = document.getElementById(str);
    var img_obj = document.getElementById('img_' + str);
    if(obj.style.display=='none'){
    	obj.style.display='block';
        if(img_obj) img_obj.src = 'images/minus.gif'; 
    }else{
        obj.style.display='none';
        if(img_obj) img_obj.src = 'images/plus.gif'; 
    }
}


/*function togglePanel(str, btn){
    var obj = document.getElementById(str);
    var obj1 = document.getElementById(btn);
    if(obj1.className=='switch_area_close'){
    	obj1.className = 'switch_area_open';
    }else{
    	obj1.className = 'switch_area_close';
    }
}*/

function format_float(number)
{
	var str = new String();
	str = number + "";
	arr = str.split(/\./);
	if(arr.length>1)
	{
		if((arr[1]).length<2)
			str = str + "0";
		if((arr[1]).length>2)
			str = Math.round(str*100)/100;
	}
	else
	{
		str = str + ".00";
	}
	return str;
}

function checkNumber(number){
	if(!number.match(/^\d+$/)){
		return false;
	}else{
		return true;
	}
}

function URLEncode( str )
{
	// The Javascript escape and unescape functions do not correspond
	// with what browsers actually do...
	var SAFECHARS = "0123456789" +					// Numeric
					"ABCDEFGHIJKLMNOPQRSTUVWXYZ" +	// Alphabetic
					"abcdefghijklmnopqrstuvwxyz" +
					"-_.!~*'()";					// RFC2396 Mark characters
	var HEX = "0123456789ABCDEF";

	var plaintext = str;
	var encoded = "";
	for (var i = 0; i < plaintext.length; i++ ) {
		var ch = plaintext.charAt(i);
	    if (ch == " ") {
		    encoded += "+";				// x-www-urlencoded, rather than %20
		} else if (SAFECHARS.indexOf(ch) != -1) {
		    encoded += ch;
		} else {
		    var charCode = ch.charCodeAt(0);
			if (charCode > 255) {
			    /*alert( "Unicode Character '" 
                        + ch 
                        + "' cannot be encoded using standard URL encoding.\n" +
				          "(URL encoding only supports 8-bit characters.)\n" +
						  "A space (+) will be substituted." );*/
				encoded += ch;
			} else {
				encoded += "%";
				encoded += HEX.charAt((charCode >> 4) & 0xF);
				encoded += HEX.charAt(charCode & 0xF);
			}
		}
	} // for

	return encoded;
};


function selectAll(name, index){
	var obj;
	var i = 1;
	var checked;
	obj = document.getElementById(name + '_' + index);
	if(obj.checked==false)
		checked = false;
	else
		checked = true;
	while(obj = document.getElementById(name + '_' + index + '_' + i)){
		i++;
		if(checked == 1)
			obj.checked = true;
		else
			obj.checked = false;
	}
}

function submitCatalogItemsForm(elm){
	if(elm.value=='') return false;
	if(elm.value!='delete'){
		elm.form.submit();
	}else{
		if(confirm("Ar tikrai norite ištrinti pažymėtus elementus?")){
			elm.form.submit();
		}else{
			elm.selectedIndex = 0;
		}
	}
}

function setValues(formName, elmName){
	var options = document.forms[formName].elements[elmName+'_tmp'].options;
	for(var i=0, j=0, ids=""; i<options.length; i++){
		if(options[i] && options[i].selected){
			if(j!=0) ids += "::";
			ids += options[i].value;
			j++;
		}
	}
	document.forms[formName].elements[elmName].value = ids;
	return ids;
}

function setAllSelected(checkbox, formName, elmName){
	var values = document.forms[formName].elements[elmName];
	var options = document.forms[formName].elements[elmName+'_tmp'].options;
	for(var i=1, j=0; i<options.length; i++){
		options[i].selected = (checkbox.checked==true) ? true : false;
	}
	setValues(formName, elmName);
}

function selectItemCheckbox(id){
	var obj = document.getElementById('h_chk_' + id);
	if(obj.value == 1){
		obj.value = 0;
	}else{
		obj.value = 1;
	}
}

function changeImageSrc(imgObj, elmName){
	if(window.navigator.userAgent.toLowerCase().indexOf('msie')){
		if(navigator.version < 7){
			var tbl = document.getElementById('img_table_'+elmName);
			var img = document.getElementById('img_src_'+elmName);
			var img_src_value = document.getElementById('img_src_value_'+elmName);
			tbl.style.display = 'block';
			img.src = "file://" + imgObj.value;
			img_src_value.value = escape("file://" + imgObj.value);
			changeImageDisplaySize(img);
		}
	}
}

function changeImageDisplaySize(img){
	if(img.width>img.height){
		if(img.width>150){
			img.width = 150;
		}
	}else{
		if(img.height>150){
			img.height = 150;
		}
	}
}

function changeImageLink(fileObj, elm){
	var obj = document.getElementById('img_src_'+elm);
	obj.value = fileObj.value;
}

function changeCheckboxFilterValue(obj, formElm, value){
	var arr = document.forms['filter'].elements[formElm].value.split("::");
	if(arr[value]==value){
		arr[value] = "";
		obj.src = obj.src.replace("status_"+value+"_checked.gif", "status_"+value+".gif");
	}else{
		arr[value] = value;
		obj.src = obj.src.replace("status_"+value+".gif", "status_"+value+"_checked.gif");
	}
	document.forms['filter'].elements[formElm].value = arr[0]+"::"+arr[1];
}

function inputFocus(field){
	if(document.getElementById(field.name + '_').value != 1) 
		field.value='';
}

function inputBlur(field, text){
	if(document.getElementById(field.name + '_').value != 1 && field.value != '') 
		document.getElementById(field.name + '_').value = 1;
	if(document.getElementById(field.name + '_').value != 1) 
		field.value = text;
}

function openLoading(){
	document.getElementById('LOADING_overlay').style.display = 'block';
}

function closeLoading(){
	document.getElementById('LOADING_overlay').style.display = 'none';
}

function getMouseXY(e) {
  if (document.all) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft
    tempY = event.clientY + document.body.scrollTop
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX
    tempY = e.pageY
  }  
  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0}
  if (tempY < 0){tempY = 0}  
  // show the position values in the form named Show
  // in the text fields named MouseX and MouseY
  return { x:tempX, y:tempY }
}


function getParentNodeByClassName(targ, className){
	
	if(typeof(targ.className)!='string') return false;
	
	var arr = targ.className.split(' ');
	for(i=0; i<arr.length; i++){
		if(className==arr[i]){ return targ; }
	}
	if(targ.parentNode){
		targ = getParentNodeByClassName(targ.parentNode, className);
		return targ;
	}else{
		return false;
	}

}


function setReadonly(pageurl, chk, bool, style, elm_type){

	if(bool){
		pageurl.setAttribute('readOnly', true);
		pageurl.className = style + '_' + elm_type + ' readonly';
	}else{
		pageurl.removeAttribute('readOnly');
		pageurl.className = style + '_' + elm_type;
	}
	chk.checked = bool;
	
}

function getContextMenuContent(url, content, module, page, id, act, frame_name){
	//if(top.content.frames['list_iframe_fields']) alert(typeof(top.content.frames['list_iframe_fields']['list_iframe_'+frame_name]));
	
	//if(typeof(top.content.frames['list_iframe_'+frame_name])=='undefined') frame = top.content;
	//else frame = top.content.frames['list_iframe_'+frame_name];
	
	frame = top.content;
	
	if(parent.frames['list_iframe_'+frame_name]) frame = parent.frames['list_iframe_'+frame_name];
	
	loc = url+"main.php?content="+content+"&module="+module+"&page="+page+"&id="+id+(frame_name!=''?"&filters="+frame_name:"");
	hash = frame.location.hash;
	reg = hash;
	loc1 = (frame.location+'').replace(reg, '');
	
	if(loc!=loc1){
		frame.location = loc + "#" + act;
		return false;
	}
	
	if(('#'+act)!=hash){
		frame.location = loc + "#" + act;
	}
	
	frame.PageClass.getPageContent_action(url+'ajax.php?get='+content+'/actions&action='+act+'&content='+content+'&module='+module+'&id='+id+''+(page=='filters'?'&filters='+frame_name:''), 'EDIT_area__action', act);
	
}

function showSystemMessage(msg_code){
	$('SysMsg').style.left = parseInt(((document.body.scrollWidth > document.body.offsetWidth ? (document.body.scrollWidth) : (document.body.offsetWidth))-300)/2) + 'px';
	$('SysMsg').style.top = parseInt((document.body.scrollHeight > document.body.offsetHeight ? (document.body.scrollHeight ) : (document.body.offsetHeight ))/4) + 'px';
	$('SysMsg').style.display = 'block';
	//if(typeof(top.content.SystemMessages[msg_code])!='undefined')
	if($('SysMsg_text')) $('SysMsg_text').innerHTML = top.content.SystemMessages[msg_code];
}

function closeSystemMessage(){
	$('SysMsg').style.display = 'none';
	$('NORIGHTS_overlay').style.display = 'none';
	$('LOADING_overlay').style.display = 'none';
}

function showLoginForm(){
	showSystemMessage(0);
	PageClass.getPageContent('login.php?session_restart=1', 'SysMsg', 1);
	$('NORIGHTS_overlay').innerHTML = '';
	$('NORIGHTS_overlay').style.display = 'block';
}

function showItemCombination_kiekis(item_id, kombinacija, kombinacija_title, act){
	$('storage_actions_area').style.left = parseInt(((document.body.scrollWidth > document.body.offsetWidth ? (document.body.scrollWidth) : (document.body.offsetWidth))-300)/2) + 'px';
	$('storage_actions_area').style.top = parseInt((document.body.scrollHeight > document.body.offsetHeight ? (document.body.scrollHeight ) : (document.body.offsetHeight ))/4) + 'px';
	$('storage_actions_area').style.display = 'block';
	$('storage_kombinacija').value=kombinacija;
	$('storage_title').innerHTML=kombinacija_title;
	$('storage_action_title').innerHTML=act;
	$('storage_action').value=act;
}

function closeItemCombination_kiekis(){
	$('storage_actions_area').style.display = 'none';
}


function add_autocomplete(module, column, title, id, multiple){

	document.getElementById('auto_text_'+column).value = '';

	if(multiple=='1'){
		hobj = document.getElementById('ELMID_'+column);
		arr = hobj.value.split("::");
		for(i=0, is=false; i<arr.length; i++){
			if(arr[i]==id){
				is=true;
				break;
			}
		}
		if(!is){
			hobj.value = (hobj.value+(hobj.value!=''?"::":"")+id);
			document.getElementById('autocomplete_'+column).innerHTML += "<div id=\"autocomplete_"+column+"_"+id+"\" class=\"autocomplete_values\"><a href=\"javascript: void(delete_autocomplete('"+column+"', "+id+"));\" class='close'>x</a><a href=\"javascript: void();\">"+title+"</a></div>";
		}
	}else{
		document.getElementById('ELMID_'+column).value = id;
		document.getElementById('autocomplete_'+column).innerHTML = "<div id=\"autocomplete_"+column+"_"+id+"\" class=\"autocomplete_values\"><a href=\"javascript: void(delete_autocomplete('"+column+"', "+id+"));\" class='close'>x</a><a href=\"javascript: void();\">"+title+"</a></div>";
	}

}

function delete_autocomplete(column, id){
	document.getElementById('autocomplete_'+column+'_'+id).style.display = 'none';
	hobj = document.getElementById('ELMID_'+column);
	arr = hobj.value.split("::");
	for(i=0, j=0, narr=[]; i<arr.length; i++){
		if(arr[i]!=id){
			narr[j++] = arr[i];
		}
	}
	hobj.value = narr.join("::");
}