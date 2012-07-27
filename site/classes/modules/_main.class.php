<?php


include_once(CLASSDIR_."basic.class.php");
class _main extends basic {

    function _main() {
	basic::basic();	
	$this->module = $GLOBALS['module'];
    }
    
    function listRss(){
    	
    	$sql = "SELECT * FROM {$this->module->table} WHERE rss=1";
		$this->db->exec($sql, __FILE__, __LINE__);
		$arr = $this->db->arr();
    	return $arr;
    	
    }
    
    function loadItem($id){
    	if(!is_numeric($id)) return false;
    	$sql = "SELECT * FROM {$this->config->variable['pr_code']}_record WHERE id=$id";
    	$this->db->exec($sql);
    	$row = $this->db->row();
    	if(!empty($row)){
	    	$sql = "SELECT * FROM {$this->module->table} WHERE id={$row['module_id']}";
			$this->db->exec($sql, __FILE__, __LINE__);
			$mod_row = $this->db->row();
			$data = $this->main_object->call($mod_row['table_name'], "loadItem", array($id));
    		$data['_MODULE_'] = $mod_row['table_name'];
    		return $data;
    	}
    }    
    
}
?>
