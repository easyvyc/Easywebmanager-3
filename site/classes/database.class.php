<?php

// TODO error'u kaupimas pranesimu apie juos siuntimas

class database {
	
	var $error_mail = false;
	var $error_return = false;
	var $error_show = false;
	var $version = "";
	
	function database($host, $user, $pass, $db){
		
		$this->connect = mysql_connect($host, $user, $pass);
		$this->select_db = mysql_select_db($db, $this->connect);

		//mysql_query('SET NAMES utf8');
		mysql_query('SET CHARACTER SET utf8', $this->connect);
		
		$sql = "SELECT VERSION() AS version";
		$this->exec($sql);
		$row = $this->row();
		
		$this->version = $row['version'];
		
	}
	
	function exec($sql, $filename=__FILE__, $linenum=__LINE__){
		
		$this->sql = $sql;
		$time_start = getmicrotime();
		
		$this->result = mysql_query($sql, $this->connect);
		
		if(!$this->result){
			trigger_error("MySql Query: ".$sql." - Error:".mysql_error()."\nFile - $filename; Line - $linenum", E_USER_ERROR);
		}

		$time_end = getmicrotime();
		$this->counter++;
		
		if($_SESSION['debug']['enabled']==1){
			$time = $time_end - $time_start;
			$this->debugger['info']['query'] .= "<b>".$this->counter."</b> Time: $time Query: ".$sql."<br>";
			$this->debugger['info']['time'] += $time;
		}
		
		$arr = split(" ", trim($sql));
		switch(strtoupper($arr[0]))
		{
			case "SELECT":
				$this->count = mysql_num_rows($this->result);
				break;
			case "UPDATE":
			case "DELETE":
				$this->count = mysql_affected_rows();
				break;
			case "INSERT":
				$this->last_id = mysql_insert_id();
				break;
			default:
				break;
		}		
	}
	
	function escape($sql){
		return mysql_real_escape_string($sql, $this->connect);
	}
	
	
	// return mysql query results by array
	function arr($sql=''){
		if($sql!='') $this->db->exec($sql);
		$arr = array();
		$n = mysql_num_rows($this->result);
		for($i=0; $i<$n; $i++){
			$arr[] = $this->row();
		}
		mysql_free_result($this->result);
		return $arr;
	}
	
	// return mysql query results by one row
	function row($sql=''){
		if($sql!='') $this->db->exec($sql);
		$row = mysql_fetch_assoc($this->result);
		return $row;
	}
	
	function close(){
		mysql_close($this->connect);
	}

}

?>
