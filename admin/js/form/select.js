var overOptionCss = "background: highlight; color: highlighttext";
var sizedBorderCss = "2 inset buttonhighlight";

var globalSelect;	//This is used when calling an unnamed selectbox with onclick="this.PROPERTY"

var ie4 = (document.all != null);

var q = 0;


function initSelectBox(el) {
	copySelected(el);
	
	var size = el.getAttribute("size");

// These two lines combined with execution in optionClick() allow you to write:
//		onchange="alert(this.options[this.selectedIndex].value)"
	el.options = el.children[1].children;
	el.selectedIndex = findSelected(el);	//Set the index now!
// Some methods that are supported on the real SELECT box
	el.remove = new Function("i", "int_remove(this,i)");
	el.item   = new Function("i", "return this.options[i]");
	el.add    = new Function("e", "i", "int_add(this, e, i)");
// The real select box let you have lot of options with the same NAME. In that case the item
// needs two arguments. When using DIVs you can't have two with the same NAME (or ID) and
// then there is no need for the second argument
	
	el.options[el.selectedIndex].selected = true;

	dropdown = el.children[1];
	
	dropdown.style.position = 'absolute';

	if (size != null) {
		if (size > 1) {
			el.size = size;
			dropdown.style.zIndex = 0;
			initSized(el);
		}
		else {
			el.size = 1;
			dropdown.style.zIndex = 9999;
			if (dropdown.offsetHeight > 200) {
				dropdown.style.height = "200";
				dropdown.style.overflow = "auto";
			}
		}
	}
	
	highlightSelected(el,true);
}

function int_remove(el,i) {
	if (el.options[i] != null)
		el.options[i].outerHTML = "";
}

function int_add(el, e, i) {
	var html = "<div class='option' noWrap";
	if (e.value != null)
		html += " value='" + e.value + "'";
	if (e.style.cssText != null)
		html += " style='" + e.style.cssText + "'";
	html += ">";
	if (e.text != null)
		html += e.text;
	html += "</div>"

	if ((i == null) || (i >= el.options.length))
		i = el.options.length-1;

	el.options[i].insertAdjacentHTML("AfterEnd", html);
}
	
function initSized(el) {
//alert("initSized -------->");
	var h = 0;
	el.children[0].style.display = "none";

	dropdown = el.children[1];
	dropdown.style.visibility = "visible";

	if (dropdown.children.length > el.size) {
		dropdown.style.overflow = "auto";
		for (var i=0; i<el.size; i++) {
			h += dropdown.children[i].offsetHeight;
		}

		if (dropdown.style.borderWidth != null) {
			dropdown.style.pixelHeight = h + 4; //2 * parseInt(dropdown.style.borderWidth);
		}

		else
			dropdown.style.height = h;

	}

	dropdown.style.border = sizedBorderCss;


	el.style.height = dropdown.style.pixelHeight;
}

function copySelected(el) {
	var selectedIndex = findSelected(el);

	selectedCell = el.children[0].rows[0].cells[0];
	selectedDiv  = 	el.children[1].children[selectedIndex];
	
	selectedCell.innerHTML = selectedDiv.outerHTML;
}

// This function returns the first selected option and resets the rest
// in case some idiot has set more than one to selcted :-)
function findSelected(el) {
	var selected = null;


	ec = el.children[1].children;	//the table is the first child
	var ecl = ec.length;
	
	for (var i=0; i<ecl; i++) {
		if (ec[i].getAttribute("selected") != null) {
			if (selected == null) {	// Found first selected
				selected = i;
			}
			else
				ec[i].removeAttribute("selected");	//Like I said. Only one selected!
		}
	}
	if (selected == null)
		selected = 0;	//When starting this is the most logic start value if none is present

	return selected;
}

function toggleDropDown(el) {
	if (el.size == 1) {
		dropDown = el.children[1];
		
		if (dropDown.style.visibility == "")
			dropDown.style.visibility = "hidden";
			
		if (dropDown.style.visibility == "hidden")
			showDropDown(dropDown);
		else
			hideDropDown(dropDown);
	}
}

function optionClick() {
	el = getReal(window.event.srcElement, "className", "option");

	if (el.className == "option") {
		dropdown  = el.parentElement;
		selectBox = dropdown.parentElement;
		
		oldSelected = dropdown.children[findSelected(selectBox)]

		if(oldSelected != el) {
			oldSelected.removeAttribute("selected");
			el.setAttribute("selected", 1);
			selectBox.selectedIndex = findSelected(selectBox);
		}

		if (selectBox.onchange != null) {	// This executes the onchange when you chnage the option
			if (selectBox.id != "") {		// For this to work you need to replace this with an ID or name
				eval(selectBox.onchange.replace(/this/g, selectBox.id));
			}
			else {
				globalSelect = selectBox;
				eval(selectBox.onchange.replace(/this/g, "globalSelect"));
			}
		}
		
		if (el.backupCss != null)
			el.style.cssText = el.backupCss;
		copySelected(selectBox);
		toggleDropDown(selectBox);
		highlightSelected(selectBox, true);
	}
}

function optionOver() {
	var toEl = getReal(window.event.toElement, "className", "option");
	var fromEl = getReal(window.event.fromElement, "className", "option");
	if (toEl == fromEl) return;
	var el = toEl;
	
	if (el.className == "option") {
		if (el.backupCss == null)
			el.backupCss = el.style.cssText;
		highlightSelected(el.parentElement.parentElement, false);
		el.style.cssText = el.backupCss + "; " + overOptionCss;
		this.highlighted = true;
	}
}

function optionOut() {
	var toEl = getReal(window.event.toElement, "className", "option");
	var fromEl = getReal(window.event.fromElement, "className", "option");

	if (fromEl == fromEl.parentElement.children[findSelected(fromEl.parentElement.parentElement)]) {
		if (toEl == null)
			return;
		if (toEl.className != "option")
			return;
	}
	
	if (toEl != null) {
		if (toEl.className != "option") {
			if (fromEl.className == "option")
				highlightSelected(fromEl.parentElement.parentElement, true);
		}
	}
	
	if (toEl == fromEl) return;
	var el = fromEl;

	if (el.className == "option") {
		if (el.backupCss != null)
			el.style.cssText = el.backupCss;
	}

}

function highlightSelected(el,add) {
	var selectedIndex = findSelected(el);
	
	selected = el.children[1].children[selectedIndex];
	
	if (add) {
		if (selected.backupCss == null)
			selected.backupCss = selected.style.cssText;
		selected.style.cssText = selected.backupCss + "; " + overOptionCss;
	}
	else if (!add) {
		if (selected.backupCss != null)
			selected.style.cssText = selected.backupCss;
	}
}

function hideShownDropDowns() {
	var el = getReal(window.event.srcElement, "className", "select");
	
	var spans = document.all.tags("SPAN");
	var selects = new Array();
	var index = 0;
	
	for (var i=0; i<spans.length; i++) {
		if ((spans[i].className == "select") && (spans[i] != el)) {
			dropdown = spans[i].children[1];
			if ((spans[i].size == 1) && (dropdown.style.visibility == "visible"))
				selects[index++] = dropdown;
		}
	}
	
	for (var j=0; j<selects.length; j++) {
		hideDropDown(selects[j]);
	}	

}

function hideDropDown(el) {
	if (typeof(fade) == "function")
		fade(el, false);
	else
		el.style.visibility = "hidden";
}

function showDropDown(el) {
	if (typeof(fade) == "function")
		fade(el, true);
	else if (typeof(swipe) == "function")
		swipe(el, 2);
	else
		el.style.visibility = "visible";
}

function initSelectBoxes() {
	var spans = document.all.tags("SPAN");
	var selects = new Array();
	var index = 0;
	
	for (var i=0; i<spans.length; i++) {
		if (spans[i].className == "select")
			selects[index++] = spans[i];
	}
	
	for (var j=0; j<selects.length; j++) {
		initSelectBox(selects[j]);
	}	
}

function getReal(el, type, value) {
	temp = el;
	while ((temp != null) && (temp.tagName != "BODY")) {
		if (eval("temp." + type) == value) {
			el = temp;
			return el;
		}
		temp = temp.parentElement;
	}
	return el;
}

if (ie4) {
	window.onload = initSelectBoxes;
	document.onclick = hideShownDropDowns;
}


function insertSelectBox(matrix, id, obj, size, onchange, css) {
	var d = window.document;

	var ie4 = (document.all != null);

	if (ie4) {
//		alert("Before!");
		var s = createIEString(matrix, id, size, onchange, css);
		document.getElementById(obj).innerHTML = s;
//		alert("After!");
//		alert(s);
	}

	else {
		document.getElementById(obj).innerHTML = createXString(matrix, id, size, onchange, css);
		//document.write(createXString(matrix, id, size, onchange, css));
	}
}

function writeSelectBox(matrix, id, size, onchange, css) {
	var d = window.document;

	var ie4 = (document.all != null);

	if (ie4) {
//		alert("Before!");
		var s = createIEString(matrix, id, size, onchange, css);
		document.write(s);
//		alert("After!");
//		alert(s);
	}

	else {
		document.write(createXString(matrix, id, size, onchange, css));
	}
}

function createIEString(matrix, id, size, onchange, css) {
	var str = "";
	// Span startTag	
		str += '<span class="select"';
		if (size == null)
			size = 1;
		str += ' size="' + size + '"';	
		if (id != null)
			str += ' id="' + id + '"';
		if (onchange != null)
			str += ' onchange="' + onchange + '"';
		if (css != null)
			str += ' style="' + css + '"';
		str += '>\n';
	
	// Table Tag
		str += '<table class="selectTable" cellspacing="0" cellpadding="0"\n';
		str += ' onclick="toggleDropDown(this.parentElement)">\n';
		str += '<tr>\n';
		str += '<td class="selected">&nbsp;</td>\n';
		str += '<td align="CENTER" valign="MIDDLE" class="Button"\n';
		str += ' onmousedown="this.style.border=\'2 inset buttonhighlight\'"\n';
		str += ' onmouseup="this.style.border=\'2 outset buttonhighlight\'">\n';
		str += '<span style="position: relative; left: 0; top: -2; width: 100%;">6</span></td>\n';
		str += '</tr>\n';
		str += '</table>\n';
		
	// DropDown startTag
		str += '<div class="dropDown" onclick="optionClick()" onmouseover="optionOver()" onmouseout="optionOut()" style="position:absolute;">\n';
		
		for (var i=0; i<matrix.length; i++) {
			html     = matrix[i].html;
			value    = matrix[i].value;
			css      = matrix[i].css;
			selected = matrix[i].selected;
			
		// Write option starttag
			str += '<div class="option"';
			if (value != null)
				str += ' value="' + value + '"';
			if (css != null)
				str += ' style="' + css + '"';
			if (selected != null)
				str += ' selected';
			str += '>\n';
			
		// Write HTML contents
			str += html;
		// Write end tag
			str += '</div>\n';
		}
	
	//DropDown endtag
		str += '</div>\n';
		
	// Span endTag
		str += '</span>\n';
		
	return str;
}

function createXString(matrix, id, size, onchange, css) {
//	var str = "\n";
	// form startTag
	var str = '<form>\n';
	// Select startTag
	str += '<select';
	if (size == null)
		size = 1;
	str += ' size="' + size + '"';	
	if (id != null)
		str += ' id="' + id + '"';
	if (onchange != null)
		str += ' onchange="' + onchange + '"';
//	if (css != null)
//		str += ' style="' + css + '"';
	str += '>\n';
	// write options
	for (var i=0; i<matrix.length; i++) {
		html     = matrix[i].html;
		value    = matrix[i].value;
		css      = matrix[i].css;
		selected = matrix[i].selected;
		
	// Write option starttag
		str += '\n<option';
		if (value != null)
			str += ' value="' + value + '"';
//		if (css != null)
//			str += ' style="' + css + '"';
		if (selected != null)
			str += ' selected';
		str += '>';
		
	// Write HTML contents
		str += stripTags(html);
	// Write end tag
		str += '</option>\n';
	}
	str += '\n</select>\n';
	str += '</form>\n';

	return str;
}

function stripTags(str) {
	var s = 0;
	var e = -1;
	var r = "";

	s = str.indexOf("<",e);	

	do {
		r += str.substring(e + 1,s);
		e = str.indexOf(">",s);
		s = str.indexOf("<",e);
	}
	while ((s != -1) && (e != -1))

	r += str.substring(e + 1,str.length);

	return r;
}

function Option(html, value, css, selected) {
	this.html = html;
	this.value = value;
	this.css = css;
	this.selected = selected;
}
