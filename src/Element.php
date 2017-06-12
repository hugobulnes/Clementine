<?php
namespace HB\Clementine;

class Element implements iElement{
	
	protected $properties = array();
	protected $id = "";
	protected $class = array();

	
	public function getHTML(){
		return "";
	}
	
	public function __get($name){
		return False;
	}
	
	public function __set($name, $value){
		return False;
	}
	
	public function iterateProperty(){
		for($i = 0; $i<count($this->properties);$i++){
			yield $this->properties[$i];
		}
	}
	
	
	public function addProperty($property){
		$newProperty = Assembler::combine($this, $property);
		if($newProperty){
			array_push($this->properties, $newProperty);
		}else{
			array_push($this->properties, $property);
		}							
	}
	
}

?>
