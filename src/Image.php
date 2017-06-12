<?php
namespace HB\Clementine;
class Image{
	
	const DOTTED = 1001;
	const DASHED = 1002;
	const SOLID = 1003;
	const DOUBLE = 1004;
	const GROOVE = 1005;
	const RIDGE = 1006;
	const INSET = 1007;
	const OUTSET = 1008;
	const NON = 1009;
	const HIDDEN = 1010;
	
	public $color = new Color("black");
	public $style = self::SOLID;
	public $width = 5;
	
	public function __construct($width){
		$this->width = $width;
	}
	
	public function __construct($width, $color){
		$this($width);
		$this->color = new Color($color);
	}
	
	public function __construct($width, $color, $style){
		$this($width, $color);
		$this->style = $style;
	}
	
}
?>