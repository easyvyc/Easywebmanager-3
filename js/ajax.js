var isIE = false;

var req;

function ajaxObj(){

}

ajaxObj.prototype.data = new Object();

function func(){}


//ajaxObj.prototype.xmlFunc = function xmlFunc(data){};

ajaxObj.prototype.loadXMLDoc = function loadXMLDoc(url) {
	 if (window.XMLHttpRequest) {
	     req = new XMLHttpRequest();
	     req.onreadystatechange = this.processReqChange;
	     req.open("GET", url, true);
	     req.send(null);
	 } else if (window.ActiveXObject) {
	     isIE = true;
	     req = new ActiveXObject("Microsoft.XMLHTTP");
	     if (req) {
	         req.onreadystatechange = this.processReqChange;
	         //alert(req.onreadystatechange);
	         req.open("GET", url, true);
	         req.send();
	     }
	 }
}

ajaxObj.prototype.processReqChange = function processReqChange() {
	 if (req.readyState == 4) {
	     if (req.status == 200) {
	     	this.response = req.responseXML;
	        this.XML2JS("items");
	      } else {
	         alert("There was a problem retrieving the XML data:\n" + req.statusText);
	      }
	 }
}

ajaxObj.prototype.loadDoc = function loadDoc(evt, url) {
    evt = (evt) ? evt : ((window.event) ? window.event : null);
	if (evt) {
	    var elem = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	    if (elem) {
	        try {
	             this.loadXMLDoc(url);
		 	} catch(e) {
	             var msg = (typeof e == "string") ? e : ((e.message) ? e.message : "Unknown Error");
	             alert("Klaida. Negalima užkrauti duomenų iš serverio.\n"/* + msg + " - " + elem.selectedIndex*/);
	             return;
	        }
	    }
 	}
}

ajaxObj.prototype.XML2JS = function XML2JS(containerTag) {
    var output = new Array();
    var rawData = this.response.getElementsByTagName(containerTag)[0];
    //alert(req.responseXML);
    var i, j, oneRecord, oneObject;
    if(!rawData) return output;
    for (i = 0; i < rawData.childNodes.length; i++) {
        if (rawData.childNodes[i].nodeType == 1) {
            oneRecord = rawData.childNodes[i];
            oneObject = output[output.length] = new Object( );
            for (j = 0; j < oneRecord.childNodes.length; j++) {
                if (oneRecord.childNodes[j].nodeType == 1) {
                    oneObject[oneRecord.childNodes[j].tagName] = oneRecord.childNodes[j].firstChild.nodeValue;    
                }
            }
        }
    }
    this.data = output;
    this.xmlFunc(this.data);
}