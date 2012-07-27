<?php

include_once(CLASSDIR_."catalog.class.php");
class subscribers extends catalog {

    function subscribers() {
    	catalog::catalog("subscribers");
    }

	function insertEmail($email, $category=0){
		// valid email 
		if(valid_email($email)){
			return false;
		}
		
		// email exist
		if($this->checkDataExist(array('column_name'=>'title', 'value'=>$email), array('id'=>0))==1){
			return false;
		}
		
		$data['isNew'] = 1;
		$data['id'] = 0;
		$data['parent_id'] = 0;
		
		$data['title'] = $email;
		$data['category'] = $category;
		$data['active'] = 1;
		
		return $this->saveItem($data);
		
	}
}

?>