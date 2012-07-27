<?php
class Reader
{
	function Reader()
	{
		
	}
	
	function read(){}
	function ready(){}
	function close(){}
	function skip($counter=1){}
	function reset(){}
   
   	function is( &$object )
   	{
   		return is_subclass_of( $object, __CLASS__ );
   	}
}
?>