<?php
namespace HB\Clementine;

use HB\Clementine\Color;
use HB\Clementine\ImageResource;

class Background{
	
	const X_REP = 1001;
	const Y_REP = 1002;
	
	public $color = NULL;
	public $imgResource = NULL;
	public $repeat = NULL;
	public $position = NULL;
	public $attachment = NULL;
	
	public function __construct(){
		
	}
	
	public function SetBackgroundColor($color){
		$this->color = new Color($color);		
	}
	
	public function SetBackgroundImage($url){
		$this->imgResource = new ImageResource($url);
	}
	
	public function RepeatImage($dir){
		if($dir != self::X_REP || $dir != self::Y_REP){
			return FALSE;
		}
		$this->repeat = $dir;
		return TRUE;
	}
	
	public function SetImagePosition($x, $y){
		
	}
}
?>