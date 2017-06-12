<?php
namespace HB\Clementine;
use \Exception;
class LeftBorder extends Border{
	
	//Document
	public function __construct($width = self::MEDIUM_SIZE, $style = self::SOLID_BORDEr, $color = "black"){
		try{
			parent::__construct(self::LEFT_SIDE, $width, $style, $color);
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
}
?>