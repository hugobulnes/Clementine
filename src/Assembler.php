<?php 
namespace HB\Clementine;

class Assembler{
	
	private function __construct(){
	}
	
	function combine($element, $property){
		$transmuted = $property->transmute($element);
		if($transmuted){
			return $transmuted;
		}
		return False;
	}
	
}
?>