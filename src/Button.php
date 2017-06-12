<?php 
namespace HB\Clementine
use \Exception;
class Button extends Element
{
	const BUTTON_BTN = 'button';
	const RESET_BTN = 'reset';
	const SUBMIT_BTN = 'submit';
	
	private $text = "";
	private $type = "button";
	
	public function __construct($text ="", $type=self::BUTTON_BTN){
		try{
			$this->setText($text);
			$this->setType($type);
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}	
	}
	
	public function __set($name, $value){
		return;
	}
	
	public function __get($name){
		return;
	}
	
	/**
	 * Set the text inside the button
	 * @param $text a string value
	 * @throws Exception
	 */
	public function setText($text){
		try {
			if(is_string($text)){
				$this->text = $text;
			}else{
				throw new Exception("text value must be a string, value provided was: ".$text);
			}
		} catch (Exception $e) {
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Set the button type
	 * @param $type a button type constant
	 * @throws Exception
	 */
	public function setType($type=self::BUTTON_BTN){
		try {
			if($this->checkButtonType($type)){
				$this->type = $type;
			}else{
				throw new Exception("type must be a button type constant, value provided was: ".$text);
			}
		} catch (Exception $e) {
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	
	public function getHTML(){
		return sprintf("<button type=\"%s\">%s</button>",$this->type, $this->text); 
	}
	
	/**
	 * Check if value provided is in button constant type
	 * @param  $value the value constant
	 * @return boolean
	 */
	protected function checkButtonType($value){
		if($value == self::BUTTON_BTN) return True;
		if($value == self::RESET_BTN_BTN) return True;
		if($value == self::SUBMIT_BTN_BTN) return True;
		return False;
	}
	
	
}
?>