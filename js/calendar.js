

function getCalendar(url, year, month, day){
	
	 var url = url + 'xml.php?get=calendar&year=' + year + '&month=' + month + '&day=' + day;
//	 try {
		 if (window.XMLHttpRequest) {
		     req = new XMLHttpRequest();
		     req.onreadystatechange = processReqChange;
		     req.open("GET", url, true);
		     req.send(null);
		 } else if (window.ActiveXObject) {
		     req = new ActiveXObject("Microsoft.XMLHTTP");
		     if (req) {
		         req.onreadystatechange = processReqChange;
		         req.open("GET", url, true);
		         req.send();
		     }
		 }

/*	 } catch(e) {
	     var msg = (typeof e == "string") ? e : ((e.message) ? e.message : "Unknown Error");
	     alert("Klaida. Negalima užkrauti duomenų iš serverio.\n");
	     return;
	 }
*/	
	
}


function processReqChange() {
	
 if (req.readyState == 4) {
     if (req.status == 200) {
		document.getElementById('calendarContent').innerHTML = req.responseText;
      } else {
         alert("There was a problem retrieving the XML data:\n" + req.statusText);
      }
 }
}