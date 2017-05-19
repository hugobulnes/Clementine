<?php

class StretchinessBehavior{
	private $direction = NULL;
	private $magnitud = NULL;
	
	public function __construct($dir, $mag){
		$this->direction = $dir;
		$this->magnitud = $mag;
	}
}

class PlacementBehavior{
	private $position = NULL;
	private $xAlign = NULL;
	private $yAlign = NULL;
	
	public function __construct($pos, $xAlign){
		$this->position = $pos;
		$this->yAlign = $xAlign;
	}
	
	public function __construct($pos, $xAlign, $yAlign){
		$this->position = $pos;
		$this->xAlign = $xAlign;
		$this->yAlign = $yAlign;
	}
	
}

class ContainerBehavior{
	private $childs = array();
	
	public AddChild($element){
		array_push($this->childs, $element);
	}
}

class Element {
	public $id = NULL;
	public $width = NULL;
	public $height = NULL;
	public $sb = NULL;
	public $pb = NULL;
	public $cb = NULL;
	
	private $properties = array();
	private $actions = array();
	private $behaviors = array();
	
	public function AddProperty($property){
		array_push($this->properties, $property;
	}
	
	public function BackGroundColor($color){
		array_push($this->properties, new BackGroundColor($color);
	}
}

class BackGroundColor extends Property{
	public $color = NULL;
	
	public function __construct($color){
		$this->color = $color;
	}
}

class Shadow{
	public $color = NULL;
	public $opacity = "100%";
	//COMPLETE CLASS
	
	public function __construct($color, $opacity){
		$this->color = $color;
		$this->opacity;
	}
}


public class HeadNav extends Element{
	
	public __construct(){
		//$this->sb = new StretchinessBahavior('left','100%');
		$this->pb = new PlacementBahavior('absolute','left','top');
		$this->cb = new ContainerBehavior();
		$this->id = "nav000001";
		
		$this->width = '100%';
		$this->height = "70px";
		
		$this->BackGroundColor("white");
		$this->AddProperty(new Shadow("black","0.2"));
	}
	
	public function AddChild($object){
			$this->cb.AddChild($object);
	}
}


public class Builder{
	private $elements = array();
	
	public function Build(){
		
	}
}


$headNav = new HeadNav();
$builder = new Builder();

$builder.AddElement($headNav);
$builder->Build();

?>