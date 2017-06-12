<?php
namespace HB\Clementine;
use \Exception;

class Text extends Element{
	private $label = "";
	
	function __construct($text){
		try{
			if(is_string($text) || is_numeric($text)){
				$this->label = $text;
				$this->color = new Color("black");
			}else{
				throw new Exception("text parameter must be a string or a numeric value");
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	function __set($name, $value){
		try{
			if($name == "label"){
				$this->label = $value;	
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	function __get($name){
		try{
			if($name == "label"){
				return $this->label;
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	function getHTML(){
		return $this->label;
	}
	
	
}
?>