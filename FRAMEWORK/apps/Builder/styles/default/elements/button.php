<?php

/*
 * button.php
 * Style: Default
 * This class construct a button
 */
class Button{
	
	public $width;
	public $height;
	public $shadow;
	public $image;
	public $text;
	
	public function __construct($width=38, $height=38){
			
			$this->width = $width;
			$this->height = $height;
		
	}
	
	public function AddText($text){
		
	}
	
	public function ModifyShadow($hor, $ver, $blur, $color, $opacity){
		if($shadow!=true){
			$this->shadow = new Shadow();
		}		
		$this->shadow.SetOpacity($opacity);					
	}
	
	public function Resize($w=NULL, $h=NULL){
		if($w===NULL){
			if($h!==NULL){
				$this->height = $h;
			}
		}else{
			if($w!==NULL){
				$this->width = $w;
			}
		}
	}
	
	public function AddImage($image){
		$this->image = new Image($image);
	}
	
	public function Build(){
		$html = "";
		$js
		$css
		
		return $html;
		
	}
	
}

?>
