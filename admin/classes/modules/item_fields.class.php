<?php

include_once(CLASSDIR."record.class.php");
class item_fields extends record {
	
	function item_fields($module){
		
		record::record($module);
		
	}
	
	function getFields(){
		$fields[] = array('id'=>FRM_TEXT, 'title'=>FRM_TEXT);
		$fields[] = array('id'=>FRM_TEXTAREA, 'title'=>FRM_TEXTAREA);
		$fields[] = array('id'=>FRM_SELECT, 'title'=>FRM_SELECT);
		$fields[] = array('id'=>FRM_CHECKBOX, 'title'=>FRM_CHECKBOX);
		$fields[] = array('id'=>FRM_RADIO, 'title'=>FRM_RADIO);
		$fields[] = array('id'=>FRM_IMAGE, 'title'=>FRM_IMAGE);
		$fields[] = array('id'=>FRM_DATE, 'title'=>FRM_DATE);
		return $fields;
	}	
	
}

?>