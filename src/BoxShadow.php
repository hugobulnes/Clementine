<?php
namespace HB\Clementine;
use \Exception;

class BoxShadow extends Shadow{
	function getCSS(){
		try{
			return "box-shadow: " . parent::getCSS();
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}

}