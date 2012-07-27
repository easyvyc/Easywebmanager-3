	var jcropApi;
	var jcropApi_coords = {x:0, y:0, w:200, h:150};
	
function start(){
		jcropApi = $('#cropbox').Jcrop({
			aspectRatio: 0,
			allowMove: 1,
			onChange: showPreview_size,
			setSelect:   [ 0, 0, $('#cropbox').width(), $('#cropbox').height()],
			onSelect: showPreview_size
		});
	}

/*	var jcropApi = $.Jcrop('#cropbox',{
					aspectRatio: 0,
					allowMove: 1,
					onChange: showPreview_size,
					setSelect:   [ 0, 0, document.getElementById('cropbox').width, document.getElementById('cropbox').height ],
					onSelect: showPreview_size
				});	
*/
    function selectFile(fileUrl, url, project_dir, path){
    	try{
    		if(window.top.opener.Gallery_mode)
	    		window.top.opener.SetUrl( encodeURI( fileUrl ).replace( '#', '%23' ), url, project_dir, path ) ;
	    	else
	    		window.top.opener.SetUrl( encodeURI( project_dir+path+fileUrl ).replace( '#', '%23' ), url, project_dir, path ) ;
			window.top.close() ;
			window.top.opener.focus() ;    
   		}catch(e){
    
    	}
    }
    
	function updateCoords(c)
	{
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
	
	function checkCoords()
	{
		if (parseInt($('#w').val())) return true;
		alert('Please select a crop region then press submit.');
		return false;
	};

	// Our simple event handler, called from onChange and onSelect
	// event handlers, as per the Jcrop invocation above
	function showPreview(coords)
	{
		if (parseInt(coords.w) > 0)
		{
			$('#cropbox').css({
				width: Math.round(coords.w) + 'px',
				height: Math.round(coords.h) + 'px'
			});
		}
	}
	
	function showPreview_size(coords)
	{
		if (parseInt(coords.w) > 0)
		{	
			jcropApi_coords = coords;
			sizing_val_x = document.getElementById('img_sizing_value_x').value;
			sizing_val_y = document.getElementById('img_sizing_value_y').value;
			imgObj = document.getElementById('cropbox');
			var rx = sizing_val_x / coords.w;
			var ry = sizing_val_y / coords.h;
			
			if(rx<ry){
				$('#preview_container').css({
					width: sizing_val_x + 'px',
					height: rx * coords.h + 'px'
				});
				$('#preview').css({
					width: Math.round(rx * imgObj.width) + 'px',
					height: Math.round(rx * imgObj.height) + 'px',
					marginLeft: '-' + Math.round(rx * coords.x) + 'px',
					marginTop: '-' + Math.round(rx * coords.y) + 'px'
				});
			}else{
				$('#preview_container').css({
					height: sizing_val_y + 'px',
					width: ry * coords.w + 'px'
				});
				$('#preview').css({
					width: Math.round(ry * imgObj.width) + 'px',
					height: Math.round(ry * imgObj.height) + 'px',
					marginLeft: '-' + Math.round(ry * coords.x) + 'px',
					marginTop: '-' + Math.round(ry * coords.y) + 'px'
				});
			}
			$('#preview_box').css({
				width: (parseInt($('#preview_container').css('width'))>199?parseInt($('#preview_container').css('width')):200) + 'px'
			});
			
		}
		updateCoords(coords);
	};	


	function filesContextMenu(e){
		
		if (!e) var e = window.event;
		var targ;
		if (e.target) targ = e.target;
		else if (e.srcElement) targ = e.srcElement;
		if (targ.nodeType == 3) // defeat Safari bug
			targ = targ.parentNode;

	   if(targ = getParentNodeByClassName(targ, 'thumb')){
		    arr = targ.id.split('_');
		    arr1 = targ.className.split(' ');
		    for(i=0, uic=0, ui=false; i<arr1.length; i++){
		    	if(arr1[i]=='ui-selected'){
	    			ui=true;
	    			break;
		    	}
		    }
		    if(ui && $('li.ui-selected').length>1){
		    	showItemContextMenu_multiple(arr[1]);
		    }else{
		    	$('li.ui-selected').attr('class', 'thumb float');
		    	$('#file_'+arr[1]).attr('class', $('#file_'+arr[1]).attr('class')+' ui-selected');
		    	showItemContextMenu(arr[1]);
		    }
			return true;
		}

		return true;
	
	}
	
	function showItemContextMenu_multiple(id){
		//$('li.ui-selected').length

		$('#contextMenuArea').html($('#contextmenu_multiple').html());
		var arr = findPos(document.getElementById('file_' + id));
		$('#contextMenuArea').css({ 'left':arr[0] + 25 + 'px', 'top':arr[1] + 15 + 'px' });
		$('#contextMenuArea').show(500);
		return false;
	}
	
	function showItemContextMenu(id){
		
		//if(this.context!=1) return false;
		
		//if(!$('contextmenu_'+id)) return false;
		$('#contextMenuArea').html($('#contextmenu_'+id).html());
		var arr = findPos(document.getElementById('file_' + id));
		$('#contextMenuArea').css({ 'left':arr[0] + 25 + 'px', 'top':arr[1] + 15 + 'px' });
		$('#contextMenuArea').show(500);
		return false;
		
	}    

	if(typeof(HTMLElement)!='undefined'){
		HTMLElement.prototype.contains = function(node) {
			if (node == null)
				return false;
			if (node == this)
				return true;
			else
				return this.contains(node.parentNode);
		}
	}
	
	function hideItemContenxtMenu(){
		
			$('#contextMenuArea').hide(500);
			return false;
		
	}
	
	function editImageForm(fileUrl, path){
		location='main.php?content=filemanager&page=edit&path='+path+'&file='+fileUrl;
	}
	
	function getSelectedFiles(){
		var str ='::';
		//alert($('li.ui-selected').length);
		$('li.ui-selected input').each(function(i, obj){ str += obj.value + '::' });
		return str;
	}
	
	function selectMultilpe(url, project_dir, path){
		str = getSelectedFiles();
    	try{
    		window.top.opener.SetUrl( encodeURI( str ).replace( '#', '%23' ), url, project_dir, path ) ;
			window.top.close() ;
			window.top.opener.focus() ;    
   		}catch(e){
    
    	}		
	}