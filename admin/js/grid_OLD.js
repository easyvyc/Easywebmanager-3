function initGridObject(){
	
//	alert(document.documentElement.clientWidth);
//	alert(this.gridArea.clientWidth);
	
//	alert($('grid_area_inner').clip.width);

	//var plotis = $('grid_area_inner').offsetWidth;
	var plotis = document.documentElement.clientWidth - 22;

	var WIDTH = plotis-(this.columns.cols.length*8);//parseInt(document.documentElement.clientWidth)-(85+(this.columns.cols.length-5)*8);//parseInt(this.gridArea.offsetWidth);//
	if(WIDTH < this.minGridWidth) WIDTH = this.minGridWidth;
	var CH = WIDTH/this.columns.allColumnWidth;
	for(var i=0, all_length=0; i<this.columns.cols.length; i++){
		col_length = parseInt( this.columns.cols[i].width * CH );
		this.columns.cols[i].minGridCellWidth = this.minGridCellWidth;
		if((i+1)==this.columns.cols.length) col_length = WIDTH - all_length - 8;
		col_length = this.columns.cols[i].reset(col_length);
		all_length += col_length;
	}
	this.gridArea.style.width = plotis+'px';
	//alert(WIDTH + ' - ' + all_length + ' - ' + this.columns.cols.length);
	
}

function resetColumnWidth(value){
	
	if(!$('header_'+this.name)) return false;
	if(this.minGridCellWidth > value)
		value = this.minGridCellWidth;
	$('header_'+this.name).style.width = value + 'px';
	if($('filter_'+this.name)) $('filter_'+this.name).style.width = value + 'px';
	for(var i=0; i<this.cells.length; i++){
		$('item___'+this.name+'___'+this.cells[i]).style.width = value + 'px';
	}
	return value;
	
}


function fieldsColumnAdd(name, width, type){
	var i = this.cols.length;
	this.cols[i] = new Object;
	this.cols[i].name = name;
	this.cols[i].width = width;
	this.cols[i].reset = resetColumnWidth;
	this.cols[i].cells = new Array;
	if(type=='select' || type == 'checkbox_group' || type == 'radio'){
		this.cols[i].elm_choice = 1;
		this.cols[i].optionArray = new Array;
		this.cols[i].createSelectObject = function(obj, value){
			//if(!this.loadedItems){
				arr = value.split('::');
				obj.options.length = 0;
				var where = (navigator.appName == "Microsoft Internet Explorer") ? -1 : null;
				newElem = document.createElement("option");
			    newElem.text = "------";
		    	newElem.value = "0";
				obj.add(newElem, where);
				for(k=0, index=0; k<this.optionArray.length; k++){
					selected=false
					newElem = document.createElement("option");
				    newElem.text = this.optionArray[k].title;
			    	newElem.value = this.optionArray[k].id;
			    	for(j=0; j<arr.length; j++){
			    		if(arr[j]==this.optionArray[k].id){
			    			selected=true;
			    		}
			    	}
			    	newElem.selected = selected;
					obj.add(newElem, where);
				}
				//this.loadedItems=true;
			//}
		}
	}else{
		this.cols[i].elm_choice = 0;
	}

	this.allColumnWidth += width;
}

function gridClass(obj_id){
	
	this.minGridWidth = 300;
	this.minGridCellWidth = 15;
	
	this.gridArea = $(obj_id);

	this.columns = new Object;
	this.columns.cols = new Array;
	this.columns.add = fieldsColumnAdd;
	this.columns.allColumnWidth = 0;
	this.column_for_resize_left = '';
	
	this.cellBlurEvent = function(cell){
		var arr = cell.id.split("___");
		$('item___'+arr[1]+'___'+arr[2]).className = 'column';
		$('value___'+arr[1]+'___'+arr[2]).style.display = 'block';
		$('edit___'+arr[1]+'___'+arr[2]).style.display = 'none';
	}
	
	this.getColumnIndex = function(column_name){
		for(var i=0; i<this.columns.cols.length; i++){
			if(this.columns.cols[i].name==column_name) return i;
		}
	}
	
	this.cellEditItem_text = this.cellEditItem_textarea = function(cell){

		var arr = cell.id.split("___");

		str = document.getElementById('value___'+arr[1]+'___'+arr[2]).innerHTML.replace("&lt;", "<");
		str = str.replace("&gt;", ">");
		document.getElementById('edititem___' + arr[1] + '___' + arr[2]).value = str;

		$('item___'+arr[1]+'___'+arr[2]).className = 'column edit';
		$('value___'+arr[1]+'___'+arr[2]).style.display = 'none';
		$('edit___'+arr[1]+'___'+arr[2]).style.display = 'block';
		$('edititem___'+arr[1]+'___'+arr[2]).focus();
		
	}
	this.cellEditItem_checkbox = function(cell){
		return false;
	}
	this.cellEditItem_image = function(cell){
		return false;
	}
	this.cellEditItem_file = function(cell){
		return false;
	}
	this.cellEditItem_submit = function(cell){
		return false;
	}
	this.cellEditItem_button = function(cell){
		return false;
	}
	this.cellEditItem_hidden = function(cell){
		//alert('asdfds');
		return false;
	}
	this.cellEditItem_date = function(cell, event){
		var arr = cell.id.split("___");
		scwShow($('edititem___'+arr[1]+'___'+arr[2]), event);
		return false;
	}
	this.cellEditItem_select = function(cell){

		var arr = cell.id.split("___");

		$('item___'+arr[1]+'___'+arr[2]).className = 'column edit';
		$('value___'+arr[1]+'___'+arr[2]).style.display = 'none';
		$('edit___'+arr[1]+'___'+arr[2]).style.display = 'block';
		
		index = this.getColumnIndex(arr[1]);
		this.columns.cols[index].createSelectObject($('edititem___'+arr[1]+'___'+arr[2]), $('edititemvalue___'+arr[1]+'___'+arr[2]).value);
		
	}
		
	this.registerResizeColumn = function(e, column1, column2, column_index){
		this.column_for_resize_left = column1;
		this.column_for_resize_right = column2;
		this.column_index = column_index;
		var mousePos = mouseCoords(e);
		this.start_resize_x = mousePos.x;//(document.all?e.clientX + document.body.scrollLeft:e.pageX);
	}

	showItemContextMenu = function(id, e){
		
		if(!$('contextmenu_'+id)) return false;
		$('contextMenuArea').innerHTML = $('contextmenu_'+id).innerHTML;
		var Pos = getMouseXY(e);
		$('contextMenuArea').style.left = Pos.x + 'px';
		$('contextMenuArea').style.top = Pos.y + 'px';
		$('contextMenuArea').style.display = 'block';
		return false;
	
	}
	
	this.mouseRightClick = function(e){
		if (!e) var e = window.event;
		var targ;
		if (e.target) targ = e.target;
		else if (e.srcElement) targ = e.srcElement;
		if (targ.nodeType == 3) // defeat Safari bug
			targ = targ.parentNode;
		if(targ = getParentNodeByClassName(targ, 'item')){
			arr = targ.id.split('_');
			showItemContextMenu(arr[2], e);
			return false;
		}
		return true;		
	}

	this.hideItemContenxtMenu = function(event){
	
		if (!event) var event = window.event;
		if (!$('contextMenuArea').contains(event.relatedTarget || event.toElement)){ 
			$('contextMenuArea').style.display = 'none';
			return false;
		} 
	
	}
	
	
	
	this.init = initGridObject;		
	
}




var dragObject = null;
var mouseOffset = null;

function grid_mouseDownEvent(e, grid, column1, column2, column_index){

	dragObject  = true;
	
	grid.registerResizeColumn(e, column1, column2, column_index);
	//$('debug_info').innerHTML = column1 + ' ' + column2;
	return false;
}

function grid_mouseMoveEvent(e, grid){

	if (!e) var e = window.event;
	
	if(dragObject && typeof(gridObject)=='object'){
		
		var mousePos = mouseCoords(e);
		
		var mouseOffset = getMouseOffset(dragObject, e);
		
		column_width1 = parseInt($('header_'+gridObject.column_for_resize_left).style.width);
		column_width2 = parseInt($('header_'+gridObject.column_for_resize_right).style.width);
		
		diference = mousePos.x - gridObject.start_resize_x;
		
		if((column_width1 > 15 && diference < 0) || (column_width2 > 15 && diference > 0)){

			new_column_width = column_width1 + diference;// + mouseOffset.x;
			gridObject.start_resize_x = mousePos.x;
			
			index = gridObject.column_index-1;
			
			gridObject.columns.cols[index].reset(new_column_width);

			new_column_width2 = column_width2 - diference;// + mouseOffset.x;
			
			index = gridObject.column_index;
			//$('debug_info').innerHTML = new_column_width + ' ' + new_column_width2 + ' ' + diference + ' ' + column_width1 + ' ' + column_width2;
			gridObject.columns.cols[index].reset(new_column_width2);
		
		}

		return false;
	}
	
}


function selectAllItems(index, checked){
	var obj = document.getElementById('chk_' + index);
	if(obj){
		obj.checked = checked;
		selectAllItems(index+1, checked);
	}
}

function grid_mouseOverEvent(e, grid, column){
	mouseOffset = getMouseOffset(targ, e);
	return false;
}

function grid_mouseOutEvent(e, grid){
	//grid_mouseUpEvent(e, grid);
}

function grid_mouseUpEvent(e, grid){
	
	if (!e) var e = window.event;
	
	if(dragObject && typeof(gridObject)=='object'){
		gridObject.registerResizeColumn(e, '');
		dragObject = null;
	}
	
	//grid.columns.cols[0].resetColumnWidth(new_column_width);
	
}

document.onmousemove = grid_mouseMoveEvent;
document.onmouseup = grid_mouseUpEvent;


function getMouseOffset(target, ev){
	ev = ev || window.event;

	var docPos    = getPosition(target);
	var mousePos  = mouseCoords(ev);
	return {x:mousePos.x - docPos.x, y:mousePos.y - docPos.y};
}

function getPosition(e){
	var left = 0;
	var top  = 0;

	while (e.offsetParent){
		left += e.offsetLeft;
		top  += e.offsetTop;
		e     = e.offsetParent;
	}

	left += e.offsetLeft;
	top  += e.offsetTop;

	return {x:left, y:top};
}

function mouseCoords(ev){
	if(ev.pageX || ev.pageY){
		return {x:ev.pageX, y:ev.pageY};
	}
	return {
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
		y:ev.clientY + document.body.scrollTop  - document.body.clientTop
	};
}