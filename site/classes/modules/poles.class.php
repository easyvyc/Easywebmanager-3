<?php

include_once(CLASSDIR_."catalog.class.php");
class poles extends catalog {

    function poles($module) {
    	
    	catalog::catalog($module);
    	
    }
    
    function saveVote($data){
    	
    	$sql = "UPDATE $this->table SET vote_count=vote_count+1 WHERE record_id={$data['vote']}";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	
    }
    
    function getResults($id){
    	
    }
    
}

?>
