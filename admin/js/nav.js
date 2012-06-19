
PageClass={};
PageClass.location = '';
PageClass.areas = Array;
PageClass.CONFIG_URL = '';
PageClass.requestMethod = 'GET';
PageClass.postParams = null;
PageClass.loadingHTML = '<center><img src="images/loading.gif" alt="" /></center>';
PageClass.loading = 0;

PageClass.init = function() {
	
	//PageClass.rewriteLinks(document);
	
	//PageClass.content = top.frames['content'];
		
}

PageClass.rewriteLinks = function(obj) {
	
	var arr = obj.getElementsByTagName('a');
	for(var i=0; i<arr.length; i++){
		if(arr[i].target != '_blank' && arr[i].className != '' && arr[i].rel == 'ajax') {
			tmp_href = arr[i].href;
			arr[i].href = "javascript: void(PageClass.getPageContent('" + arr[i].href + "', '" + arr[i].className + "'));";
			arr[i].onmouseover = function(){
				window.status=tmp_href; return true;			
			}
			arr[i].onmouseout = function(){
				window.status=''; return true;			
			}
		}
	}
	/*
	var arr = obj.getElementsByTagName('form');
	for(var i=0; i<arr.length; i++){
		if(arr[i].target != '_blank' && arr[i].className !='') {
			arr[i].action = "javascript: void(PageClass.getPageContent('" + arr[i].action + "', '" + arr[i].className + "'));";
		}
	}*/
	
}

function actionMenuDisactive(){

	for(var i=0; i<mod_actions.length; i++){
		if($('__'+mod_actions[i])) $('__'+mod_actions[i]).className = '';
	}

}

PageClass.getPageContent_action = function(location, areas, obj, loading){
	
	actionMenuDisactive();
	
	$('__'+obj).className = 'a';
	$(areas).style.display = 'block';

	//document.write(location);
	PageClass.getPageContent(location, areas, loading);
}

PageClass.getPageContent = function(location, areas, loading){
	//document.write(location);
	PageClass.location = location;
	if(typeof(areas)!='object') 
		PageClass.areas = areas.split(' ');
	else
		PageClass.areas = areas;
	
	PageClass.loading = (loading?loading:0);

	PageClass.startRequest();
	
	url = PageClass.location;

	 if (window.XMLHttpRequest) {
	     req = new XMLHttpRequest();
	     req.onreadystatechange = PageClass.processLoadPage;
	     req.open(PageClass.requestMethod, url, true);
		 if(PageClass.requestMethod == 'POST'){
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			req.setRequestHeader("Content-length", PageClass.postParams.length);
			req.setRequestHeader("Connection", "close");	     
		 }
	     req.send(PageClass.postParams);
	 } else if (window.ActiveXObject) {
	     isIE = true;
	     req = new ActiveXObject("Microsoft.XMLHTTP");
	     if (req) {
	         req.onreadystatechange = PageClass.processLoadPage;
	         req.open(PageClass.requestMethod, url, true);
			 if(PageClass.requestMethod == 'POST'){
				req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				req.setRequestHeader("Content-length", PageClass.postParams.length);
				req.setRequestHeader("Connection", "close");	     
			 }
	         req.send(PageClass.postParams);
	     }
	 }	
	
}

PageClass.formData2QueryString = function(docForm) {

        var strSubmit       = '';
        var formElem;
        var strLastElemName = '';
        
        for (i = 0; i < docForm.elements.length; i++) {
                formElem = docForm.elements[i];
                if(formElem.name!=''){
                switch (formElem.type) {
                        // Text, select, hidden, password, textarea elements
                        case 'text':
                        case 'hidden':
                        case 'password':
                        case 'textarea':
							strSubmit += formElem.name + '=' + formElem.value + '&';
                        break;
                        case 'select-one':
                        	if(formElem.options.length)
	                        	strSubmit += formElem.name + '=' + escape(formElem.options[formElem.selectedIndex].value) + '&';
                        break;
                        case 'checkbox':
                        	if(formElem.checked == true) strSubmit += formElem.name + '=' + escape(formElem.value) + '&';
                        break;
                        case 'radio':
	                        if(formElem.checked == true) strSubmit += formElem.name + '=' + escape(formElem.value) + '&';
                }
                }
        }
        return strSubmit;
}

PageClass.submitForm_ = function (location, areas, form, loading){
	
	PageClass.postParams = PageClass.formData2QueryString(form);
	PageClass.requestMethod = 'POST';
	PageClass.getPageContent(location, areas, loading);
	PageClass.requestMethod = 'GET';
	PageClass.postParams = null;
	
}

PageClass.submitForm = function (location, areas, form){
	
	PageClass.postParams = PageClass.formData2QueryString(form);
	PageClass.requestMethod = 'POST';
	PageClass.getPageContent(location, areas);
	PageClass.requestMethod = 'GET';
	PageClass.postParams = null;
	
}

PageClass.processLoadPage = function (){

	 if (req.readyState == 4) {

	     if (req.status == 200) {
	
			var html_arr = req.responseText.split(':::::::::::::::');
			
			if(typeof(PageClass.areas)!='object'){
				PageClass.areas.value = html_arr[0];
			}else{
				for(i=0; i<PageClass.areas.length; i++){
					$(PageClass.areas[i]).innerHTML = html_arr[i];
					//PageClass.rewriteLinks($(PageClass.areas[i]));
					evalScripts(html_arr[i]);
				}
			}
			PageClass.endRequest();
			
	      } else {

			top.content.showSystemMessage(0);
			
	         //alert("Serverio klaida:\n" + req.statusText);
	         //PageClass.endRequest();

	      }
	 }	
	
}


PageClass.startRequest = function (){
	if(PageClass.loading==1){
		for(i=0; i<PageClass.areas.length; i++){
			$(PageClass.areas[i]).innerHTML = PageClass.loadingHTML;
		}		
	}else{
		openLoading();
	}
}

PageClass.endRequest = function (){
	if(PageClass.loading==1){
	}else{
		closeLoading();
	}
}

PageClass.init();


function evalScripts(html){
	
	var script_fragment = '(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)';
	//replace(/<\/?[^>]+>/gi, '');
	var re = new RegExp(script_fragment, "g");
	var scripts = html.match(re);
	if(scripts){
		for(var i=0; i<scripts.length; i++){
			eval(scripts[i].replace(/<\/?[^>]+>/gi, ''));
		}
	}
	
}