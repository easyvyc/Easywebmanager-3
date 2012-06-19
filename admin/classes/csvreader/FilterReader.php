<?php
require_once( dirname( __FILE__ ). '/Reader.php' );

class FilterReader extends Reader
{
   var $reader = NULL;
	
	function FilterReader( &$reader )
	{
		parent::Reader();
		if ( Reader::is( $reader ) )
      		$this->reader =& $reader;
	}
	
	function read()
   	{
      return $this->reader->read();
   	}
	
   	function ready()
   	{
		return $this->reader->ready();
   	}
	
   	function close()
   	{
      	$this->reader->close();
   	}
	
   	function skip( $counter = 1 )
   	{
      	$this->reader->skip($counter);
   	}
	
   	function reset()
   	{
      	$this->reader->reset();
   	}
   
   	function is(&$object)
   	{
      	return is_subclass_of( $object, __CLASS__ );
   	}
}
?>