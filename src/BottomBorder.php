<?php
namespace HB\Clementine;
use \Exception;
class BottomBorder extends Border{
	
	//Document
	public function __construct($width = self::MEDIUM_SIZE, $style = self::SOLID_BORDER, $color = "black"){
		try{
			parent::__construct(self::BOTTOM_SIDE, $width, $style, $color);
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
}
?>