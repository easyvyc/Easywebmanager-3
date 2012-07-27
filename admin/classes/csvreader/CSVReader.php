<?php
/**
 * @author Nicolas BUI <nbui@wanadoo.fr>
 * 
 * Copyright: 2002 Vitry sur Seine/FRANCE
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */
require_once( dirname( __FILE__ ) . '/FilterReader.php' );

define( 'CSV_EOL', 1 );	// end of the line
define( 'CSV_EOF', 2 ); // end of the file
define( 'CSV_EOC', 0 ); // end of the cell

class CSVReader extends FilterReader
{
	var $separator		= ',';
	
	var $lineCount		= 0;
	var $convertEscape	= true;
	
	function CSVReader( &$reader )
	{
		parent::FilterReader( $reader );
	}
	
	function setSeparator( $c )
	{
		$this->separator = substr( $c , 0, 1 );	
	}
	
	function getSeparator()
	{
		return $this->separator;	
	}
	
	// skip current line
	function _skipLine()
	{
		$c = $this->read();	
		while( $c != '' && $c != "\n" )
			$c = $this->read();	
		$this->lineCount++;
	}
		
	function all()
	{
		$res = array();
		while( false !== ( $cell = $t->next() ) )
		{
			$res[] = $cell;
		}
		$res;
	}

	function next()
	{
		$cell	= array();
		$c 		= $this->read();
		$p		= '';
		$buff 	= '';
		$quote 	= 0;
		while ( true )
		{
			if ( $c == '' )
			{
				if ( $buff != '' )
				{
					$cell[] = $buff;	
				}
				return sizeof( $cell ) != 0 ? $cell : false;	
			}
			elseif ( ( $c == $this->getSeparator() || $c == "\n" ) && 0 == ( $quote % 2 ) )
			{
				if ( $quote != 0 )
				{
					$i = strrpos( $buff, '"' );
					$buff = substr( $buff, 0, $i );
				}
				$cell[] = $buff;
				if ( $c == "\n" )
				{
					$this->lineCount++;
					return $cell;
				}
				$buff 	= '';
				$quote 	= 0;
			}
			elseif ( $c == "\\" && $this->convertEscape )
			{
				// slash
				$c = $this->read();
				switch ( $c )
				{
					case '"':
						$buff .= '"';
						break;
					case "'":
						$buff .= "'";
						break;
					case 'x':
						// hex
						$c = $this->read();
						$_tmp = '';
						while ( ( ord( $c ) >= 48 && ord( $c ) <= 57 ) || ( ord( $c ) >= 65 && ord( $c ) <= 70 ) || ( ord( $c ) >= 97 && ord( $c ) <= 102 ) )
						{
							$_tmp .= $c;
						}
						eval( "\$_tmp = \\x{$_tmp};" );
						$buff .= $_tmp;
						break;
					case '0':
					case '1':
					case '2':
					case '3':
					case '4':
					case '5':
					case '6':
					case '7':
					case '8':
					case '9':
						$_tmp = $c;
						$c = $this->read();
						while ( ( ord( $c ) >= 48 && ord( $c ) <= 57 ) )
						{
							$_tmp .= $c;
							$c = $this->read();
						}
						eval( "\$_tmp = \\{$_tmp};" );
						$buff .= $_tmp;
						// octal
						break;
					default:
						$buff .= "\\".$c;
					
				}
			}
			elseif ( ( $c == '!' || $c == '#' || $c == ';' ) && $buff == '' ) 
			{
				// comment
				$this->_skipLine();
			}
			elseif ( $c == '"' ) 
			{
				if ( ( $quote % 2 ) != 0 )
					$buff .= $c;
				$quote++;				
			}
			else 
			{
				if ( $c != "\r" )
				{
					if ( $c == "\n" )
						$this->lineCount++;
					$buff .= $c;	
				}
			}
			$c = $this->read();
		}
	}
   
   function is(&$object)
   {
      return is_subclass_of( $object, __CLASS__ );
   }
}
?>
