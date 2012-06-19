<?php

include_once(CLASSDIR_."catalog.class.php");

class currencies extends catalog{
	
	var $default_id = 14343;
	
	function currencies(){
		catalog::catalog("currencies");
		$this->current = (isset($_SESSION['current_currency'])?$_SESSION['current_currency']:$this->default_id);
	}
	
	function loadCurrencies(){
		if(isset($_GET['curr'])){
			$this->setCurrent($_GET['curr']);
			redirect(CURRENT_URL);
		}
		$this->fields = " IF(R.id=$this->current, 1, 0) AS current, ";
		return $this->listSearchItems();
	}
	
	function setCurrent($currency_id){
		$this->current = $_SESSION['current_currency'] = $currency_id;
	}
	
	function getCurrent(){
		return $this->loadItem($this->current);
	}
	
}

?>