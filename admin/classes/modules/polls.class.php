<?php

include_once(CLASSDIR."record.class.php");
class polls extends record {

    function polls($module) {
    
    	record::record($module);
    
    }
    
    function activateOnlyOneCategory($data){
    	
    	if($data['is_category']==1 && $data['activated']==1){
    		
    		$sql = "UPDATE $this->table SET activated=0 WHERE record_id!={$data['id']}";
    		$this->db->exec($sql, __FILE__, __LINE__);
    		
    	}
    	
    }
}
?>