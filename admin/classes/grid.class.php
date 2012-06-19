<?php

include_once(CLASSDIR_."basic.class.php");
include_once(CLASSDIR."tpl.class.php");

class grid extends basic {

	var $paging_items = 20;
	var $grid_data = array();
	var $filterParams = array();

    function grid() {
    	
    	basic::basic();

    	$this->selected_paging = $_SESSION['order']['paging'];
    	$this->sort_by = $_GET['by'];
    	$this->sort_direction = $_GET['order'];
    	
    	$this->grid_data['list_page'] = 'list';
    	$this->grid_data['edit_page'] = 'edit';
    	$this->grid_data['script'] = 'change_catalog_item_field';
    	
    	$this->grid_data['edit_button'] = 1;
    	$this->grid_data['dublicate_button'] = 0;
    	$this->grid_data['delete_button'] = 1;
    	$this->grid_data['select_button'] = 1;
    	$this->grid_data['dragndrop'] = 1;
    	
    	$this->grid_data['filter_form'] = 1;
    	
    	$this->grid_data['grid_name'] = 'items_list';
    	
    	
    }
    
    function setTpl($file, $var){
    	global $cms_phrases;
    	$this->tpl = & new easytpl($file, $var);
    	$this->tpl->setVar('config', $this->config->variable);
    	$this->tpl->setVar('phrases', $cms_phrases['main']);
		$this->tpl->setVar('get', $_GET);
    }
    
    function setColumns($columns){
    	
    	//pa($this->filterParams);
		foreach($columns as $key=>$val){
			if(($columns[$key]['super_user']==0 || $columns[$key]['super_user']==1 && $_SESSION['admin']['permission']==1)){
				$columns[$key]['editable'] = $columns[$key]['editorship'];
				
				$columns[$key]['filter_value'] = $this->filterParams[$val['column_name']];
				//pa($this->filterParams[$val['column_name']]);
				switch($val['elm_type']){
					case FRM_TEXT:
					case FRM_TEXTAREA:
					case FRM_HTML:
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 10;
						$columns[$key]['elm_text'] = 1;
						break;
					case FRM_DATE:
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 2;
						$columns[$key]['elm_date'] = 1;
						$columns[$key]['filter_value_from'] = $columns[$key]['filter_value']['from'];
						$columns[$key]['filter_value_to'] = $columns[$key]['filter_value']['to'];
						if(strlen($columns[$key]['filter_value_from'])||strlen($columns[$key]['filter_value_to'])){
							$columns[$key]['filter_value'] = 1;
							if(strlen($columns[$key]['filter_value_from'])){
								$arr = explode("-", $columns[$key]['filter_value_from']);
								$columns[$key]['filter_value_back_from'] = date("Y-m-d", mktime(0,0,0,$arr[1],$arr[2]-1,$arr[0]));
								$columns[$key]['filter_value_fwd_from'] = date("Y-m-d", mktime(0,0,0,$arr[1],$arr[2]+1,$arr[0]));
							}
							if(strlen($columns[$key]['filter_value_to'])){
								$arr = explode("-", $columns[$key]['filter_value_to']);
								$columns[$key]['filter_value_back_to'] = date("Y-m-d", mktime(0,0,0,$arr[1],$arr[2]-1,$arr[0]));
								$columns[$key]['filter_value_fwd_to'] = date("Y-m-d", mktime(0,0,0,$arr[1],$arr[2]+1,$arr[0]));
							}
						}
						break;
					case FRM_BUTTON:
					case FRM_SUBMIT:
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 2;
						break;
					case FRM_LIST:
					case FRM_TREE:
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 2;
						break;
					case FRM_IMAGE:
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 3;
						if(isset($columns[$key]['list_values']['dir'])){
							$columns[$key]['path'] = $columns[$key]['list_values']['dir'];
						}elseif(isset($columns[$key]['list_values']['abs_dir'])){
							$columns[$key]['path'] = $columns[$key]['list_values']['abs_dir'];
							$columns[$key]['abs_path'] = 1;
						}else{
							$columns[$key]['path'] = ereg_replace(DOCROOT_, "", UPLOADDIR);
						}
						
						$columns[$key]['elm_image'] = 1;
						break;
					case FRM_FILE:
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 3;
						$columns[$key]['elm_file'] = 1;
						break;
					case FRM_RADIO:
					case FRM_SELECT:
					case FRM_CHECKBOX_GROUP:
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 5;
						$columns[$key]['elm_choice'] = 1;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
						include_once(CLASSDIR."forms.class.php");
						$form_obj = & new forms();
						$items_list = $form_obj->getSelectItems($columns[$key]);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						
						$columns[$key]['choice_arr'] = $items_list;
						break;
					case FRM_CHECKBOX:
						$columns[$key]['button'] = 1;
						$columns[$key]['elm_button'] = 1;
						$columns[$key]['value_'.$columns[$key]['filter_value']] = 1;
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 1;
						break;
					case FRM_CUSTOM:
						foreach($val['params'] as $k1=>$v1)
							$columns[$key][$k1] = $v1;
						//$columns[$key]['elm_text'] = 1;
						break;
					default: 
						$columns[$key]['elm_text'] = 1;
						if(!isset($columns[$key]['w'])) $columns[$key]['w'] = 10;
				}
				//$columns[$key-]['second_column_name'] = $columns[$key+1]['column_name'];
				//$columns[$key]['resizer'] = (strlen($columns[$key+1]['column_name'])?1:0);
				if($this->sort_by==$val['column_name'] && $this->sort_direction=='ASC'){
					$columns[$key]['sort_up'] = 1;
				}
				if($this->sort_by==$val['column_name'] && $this->sort_direction=='DESC'){
					$columns[$key]['sort_down'] = 1;
				}
				
				
				
				$columns[$key]['I'] = $key;
				$table_list[] = $columns[$key];
		
				if(count($table_list)>1)
					$table_list[count($table_list)-2]['second_column_name'] = $columns[$key]['column_name'];
				
			}
			
			
		}
		
		$this->columns = $table_list;
		//pae($this->columns);
		$this->tpl->setLoop('fields', $this->columns);
		
    }

    function setItemsCount($count, $all_count=1){
    	$this->count = $count;
    	$this->tpl->setVar('elements_count', $all_count);
    	$this->tpl->setVar('filter_elements_count', $this->count);

    	$this->tpl->setVar('not_empty_elements', $all_count);
    	$this->tpl->setVar('not_empty_filter_elements', $this->count);
    }

    function setItems($list_items){
    	
    	$n = count($list_items);
		$CONTENT = $_GET['content'];

		$this->items = $list_items;
		
		$this->tpl->setLoop('items', $this->items);

		
		
    }
    
    function paging($offset){
    	if(!isset($offset) || !is_numeric($offset)) $offset = 0;
    	$paging_arr = generatePaging($offset, $this->count, $this->paging_items, RESULTS_PAGING);
    	$this->tpl->setLoop('paging', $paging_arr['loop']);
		$this->tpl->setVar('paging', $paging_arr);
    }
    
    function pagingSelect($IN_ONE_PAGE_LIST){
		$this->tpl->setVar('items_in_one_page', 1);
		if($IN_ONE_PAGE_LIST==0){
			$this->tpl->setVar('items_in_one_page', 0); 
			return false;
		}
		$n = count($IN_ONE_PAGE_LIST);
		for($i=0; $i<$n; $i++){
			if($IN_ONE_PAGE_LIST[$i]['value']==$this->selected_paging){
				$IN_ONE_PAGE_LIST[$i]['active'] = 1;
			}
		}
		$this->tpl->setLoop('items_in_one_page', $IN_ONE_PAGE_LIST);    	
    }
    
    function action($obj, $method, $params=null){
    	return call_user_method($method, $obj, $params);
    }
    
    function generate(){
    	
    	// jei irasu yra, bet pagal paieskos filtrus nieko nerasta (kad rodytu filtru paieskos juosta)
    	if(count($this->filterParams)>0){
    		$this->tpl->setVar('not_empty_elements', 1);
    	}
    	
    	$this->tpl->setVar('grid_data', $this->grid_data);
    	$this->tpl->parse();
    }
    
    function set_filterParams($data){
    	foreach($data as $key=>$val){
    		$this->filterParams[$key] = $val;
    	}
    }
    

}
?>