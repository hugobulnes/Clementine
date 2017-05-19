<?php

class Button extends Element{
	public $image;
	public $text;
	
	public function __construct($width=38, $height=38){
			$this->width = $width;
			$this->height = $height;
			
			$this->shadow = new Shadow();
	}
	
	public function SetImage($src){
		if($image===NULL){
			$image = new Image();
		}
		$image->SetImage($src);
	}
	
}


?>
