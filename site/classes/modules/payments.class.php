<?php

include_once(CLASSDIR_."catalog.class.php");

class payments extends catalog {
	
	function payments(){
		catalog::catalog("payments");
	}
	
	function listPayments(){
		
		$list = $this->main_object->call($this->_table_fields['pay_type']['list_values']['module'], "listItems", $this->_table_fields['pay_type']['list_values']['parent_id']);
		foreach($list as $i=>$val){
			$this->sqlQueryWhere = " T.pay_type={$val['id']} AND ";
			if(is_numeric($_SESSION['order_payment'])) $this->fields = " IF(R.id={$_SESSION['order_payment']}, 1, 0) AS selected, ";
			$list[$i]['sub'] = $this->listSearchItems();
		}
		return $list;
		
	} 
	
	function setPay(){
		
		if(isset($_POST['payment'])){
			$_SESSION['order_payment'] = $_POST['payment'];
			redirect("{$this->config->variable['site_url']}{$this->language}/order/step/confirm/");
		}	
		
	}
	
}

?>