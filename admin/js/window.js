
function NewWindow(mypage, myname, w, h) {
var winl = (screen.width - w) / 2;
var wint = (screen.height - h) / 2;
winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars=no ,resizable=no'
win = window.open(mypage, myname, winprops)
if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}
//  End -->
/*******************************************************************************
Popup Window openers
*******************************************************************************/

var winReference = null;
// Open a window at a given position on the screen
function openPositionedWindow(url, name, width, height, x, y, status, scrollbars, moreProperties, openerName) {
	
	// ie 4.5 and 5.0 mac - windows are 2 pixels too short; if a statusbar is used, the window will be an additional 15 pixels short
	var agent = navigator.userAgent.toLowerCase();
	if (agent.indexOf("mac") != -1 && agent.indexOf("msie") != -1 && (agent.indexOf("msie 4") != -1 || agent.indexOf("msie 5.0") != -1) ) {
	height += (status) ? 17 : 2;
	}
	// Adjust width if scrollbars are used (pc places scrollbars inside the content area; mac outside) 
	width += (scrollbars != '' && scrollbars != null && agent.indexOf("mac") == -1) ? 16 : 0;
	var properties = 'width=' + width + ',height=' + height + ',screenX=' + x + ',screenY=' + y + ',left=' + x + ',top=' + y + ((status) ? ',status' : '') + ',scrollbars' + ((scrollbars) ? '' : '=no') + ((moreProperties) ? ',' + moreProperties : '');
	var reference = openWindow(url, name, properties, openerName);
	
	return reference;
}

// Open a window at the center of the screen
function openCenteredWindow(url, name, width, height, status, scrollbars, moreProperties, openerName) {
	var x, y = 0;
	if (screen) {
	x = (screen.availWidth - width) / 2;
	y = (screen.availHeight - height) / 2;
	}
	if (!status) status = '';
	if (!openerName) openerName = '';
	var reference = openPositionedWindow(url, name, width, height, x, y, status, scrollbars, moreProperties, openerName);
	return reference;
}

// Open a window at the center of the parent window
function openCenteredOnOpenerWindow(url, name, width, height, status, scrollbars, moreProperties, openerName) {
	var centerX = 0;
	var centerY = 0;
	if (window.screenX != null && window.outerWidth) {
	centerX = window.screenX + (window.outerWidth / 2);
	centerY = window.screenY + (window.outerHeight / 2);
	}
	else if (window.screenLeft) {
	if (document.documentElement) {
	centerX = window.screenLeft + (document.documentElement.offsetWidth / 2);
	centerY = window.screenTop + (document.documentElement.offsetHeight / 2);
	}
	else if (document.body && document.body.offsetWidth) {
	centerX = window.screenLeft + (document.body.offsetWidth / 2);
	centerY = window.screenTop + (document.body.offsetHeight / 2);
	}
	}
	
	if (centerX == 0) {
	openCenteredWindow(url, name, width, height, status, scrollbars, moreProperties, openerName);
	}
	var x = parseInt(centerX - (width / 2));
	var y = parseInt(centerY - (height / 2));
	if (!status) status = '';
	if (!openerName) openerName = '';
	var reference = openPositionedWindow(url, name, width, height, x, y, status, scrollbars, moreProperties, openerName);
	return reference;
}
// Open a full-screen window (different from IE's fullscreen option)
function openMaxedWindow(url, name, scrollbars, openerName) {
	var x, y = 0;
	var width  = 600;
	var height = 800;
	if (screen) {
	if (screen.availLeft) {
	x = screen.availLeft;
	y = screen.availTop;
	}
	width  = screen.availWidth - 6;
	height = screen.availHeight - 29;
	}
	var reference = openPositionedWindow(url, name, width, height, x, y, false, scrollbars, openerName);
	return reference;
}

// Open a full-chrome (all GUI elements) window
// This is like using a target="_blank" in a normal link but allows focussing the window
function openFullChromeWindow(url, name, openerName) {
	return openWindow(url, name, 'directories,location,menubar,resizable,scrollbars,status,toolbar');
}

// Open a sized full-chrome (all GUI elements) window 
function openSizedFullChromeWindow(url, name, width, height, openerName) {
	return openCenteredWindow(url, name, width, height, true, true, 'directories,location,menubar,resizable,toolbar', openerName)
}

// Core utility function that actually creates the window and gives focus to it
function openWindow(url, name, properties, openerName) {
	// ie4.x pc can't give focus to windows containing documents from a different domain
	// in this case, initially load a local interstisial page to allow focussing before loading final url
	var agent = navigator.userAgent.toLowerCase();
	if (agent.indexOf("msie") != -1 && parseInt(navigator.appVersion) == 4 && agent.indexOf("msie 5") == -1 && agent.indexOf("msie5") == -1 && agent.indexOf("win") != -1 && url.indexOf('http://') == 0) {
	winReference = window.open('about:blank', name, properties);
	
	setTimeout('if (winReference && !winReference.closed) winReference.location.replace("' + url + '")', 300);
	}
	else {
	winReference = window.open(url, name, properties);
	}
	// ie doesn't like giving focus immediately (to new window in 4.5 on mac; to existing ones in 5 on pc)
	setTimeout('if (winReference && !winReference.closed) winReference.focus()', 200);
	
	if (openerName) self.name = openerName;
	return winReference;
}

/*******************************************************************************
Modal Dialog controls
*******************************************************************************/
// Close a dialog
// Call from onunload event handler of any page that can create a dialog
function closeDialog(dialog) {
	if (dialog && dialog.closed != true) dialog.close();
}

// Close parent popup
// Call from onload event handler of any page that could be created from a dialog
function closeParentDialog() {
	if (top.opener && isWindowPopup(top.opener)) {
	root = top.opener.top.opener;
	top.opener.close();
	top.opener = root;
	}
}

// Check if a window is a popup
function isWindowPopup(win) {
	return ((win.opener) ? true : false);
}

/*******************************************************************************
	Additional functions
*******************************************************************************/

function openImagePopupID(id, width, height, title){
	var url = 'get.php?i.' + id;
	return openImagePopup(url, width, height, "image_" + id, title, 0);
}

function openFlashPopupID(id, width, height, title){
	var url = 'get.php?i.' + id;
	return openImagePopup(url, width, height, "image_" + id, title, 1);
}

function openImagePopup(url, width, height, extras, flash){
	if (typeof(extras) == 'undefined')
		extras = 'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,top=10,right=10,resizable=1';
	if (window.showModalDialog)
		window.showModalDialog(url, window, 'dialogHeight:'+height+'px; dialogWidth:'+width+'px; resizable:yes; status:no; help: no');
	else window.open(url, '', extras + ',width='+width+',height='+height);
}

function openWinInModal(url, width, height, params, title, charset){
	url = "index.php?page=services/window_frame&title=" + escape(title) + "&charset=" + charset + "&url=" + escape(url);
	return openDialog(url, width, height, params, params["scrollbars"], params["resizable"]);
}

function openDialog(url, width, height, param, scroll, resizable){
	if(scroll + "" == "undefined"){ scroll = 0 }
	if(resizable + "" == "undefined"){ resizable = 0 }
	
	var rnd = Math.round((Math.random()*999)+1);
	var r = showModalDialog(url, param, 'dialogWidth:' + width + 'px;dialogHeight:' + height + 'px;center:1;dialogHide:0;help:0;edge:raised;status:0;unadorned:1;resizable:' + resizable + ';scroll:' + scroll);
	
	if (typeof(r) != "undefined")
		return r;
	else 
		return true;
}
