<?php
namespace HB\Clementine;
use \Exception;

class TextShadow extends Shadow{
	function getCSS(){
		try{
			return "text-shadow: " . parent::getCSS();
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}	
}
?>