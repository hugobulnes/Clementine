<?php
namespace HB\Clementine;

use \Exception;

class Shadow extends Property{

	const INSET_DIR = "inset";
	const OUTSET_DIR = "outset";
	
	/// the color object holder for the shadow
	private $color = NULL;
	/// the horizontal and Vertical position of the shadow
	private $position;	
	/// the blur of the shadow
	private $blur;
	/// the spread value of the shadow
	private $spread;
	/// The direction of the shadow
	private $direction;
	
	
	/**
	 * This class is used to create a shadow in elements,it behaves differently if the
	 * shadow is for a text or a non text element 
	 * @param $hPos int or a string unit, set the horizontal position
	 * @param $vPos int or a string unit, set the vertical position
	 * @param $blur int or a string unit, set the blur of the shadow
	 * @param $spread int or a string unit, set the spread area
	 * @param $direction shadow direction constant, set the direction of the shadow
	 */
	public function __construct($hPos, $vPos, $blur=0, $spread=0, $color="black", $direction=self::OUTSET_DIR){
		try{
			$this->setPosition($hPos, $vPos);
			$this->setBlur($blur);
			$this->setSpread($spread);
			$this->setDirection($direction);
			$this->color = new Color($color);
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e)); 
		}		
	}
	
	public function __get($name){
		try{
			if($name == "position"){
				return $this->position;
			}else if($name == "blur"){
				return $this->blur;
			}else if($name == "spread"){
				return $this->spread;
			}else if($name == "color"){
				return $this->color;
			}else if($name == "direction"){
				return $this->direction;
			}else if($name == "css"){
				return $this->getCSS();
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	public function __set($name, $value){
		try {
			if($name == "color"){
				$this->color->setColor($value);
			}else if($name == "blur"){
				$this->setBlur($value);
			}elseif($name == "spread"){
				$this->setSpread($value);
			}elseif($name == "hPos"){
				$this->setPosition($value, $this->position[1]);			
			}elseif($name == "vPos"){
				$this->setPosition($this->position[0], $value);
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		} catch (Exception $e) {
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Set the vertical and horizontal position of the shadow
	 * @param $hPos int or a string unit, set the horizontal position
	 * @param $vPos int or a string unit, set the vertical position
	 */
	public function setPosition($hPos, $vPos){
		try{	
			if(is_null($hPos) || is_null($vPos)){
				throw new Exception("horizontal and vertical position must be indicated, values ".$hPos.",".$vPos);
				return False;
			}
			$this->position = array($hPos, $vPos);			
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Set the blur of the shadow	  
	 * @param $blur int or string unit value
	 */
	public function setBlur($blur=0){
		try{			
			if($this->checkUnit($blur)){
				$this->blur = $blur;
			}else{
				throw new Exception("blur value must be in unit format (\"#px\",\"#%\",#), value provided was: ".$blur);
			}			
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Set the spread area of the shadow
	 * @param $spread int or string unit 
	 */
	public function setSpread($spread=0){
		try{
			if($this->checkUnit($spread)){
				$this->spread = $spread;
			}else{
				throw new Exception("spread value must be in unit format (\"#px\",\"#%\",#), value provided was: ".$spread);
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}		
	}
	
	/**
	 * Set the direction of the shadow, inside or outside, not providing a value set the direction to default 
	 * 
	 * 		INSET_DIR | OUTSET_DIR
	 * 	  
	 * @param $direction shadow direction constant	 
	 */
	public function setDirection($direction = self::OUTSET_DIR){
		try{
			if($this->checkShadowDirectionConst($direction)){
				$this->direction = $direction;
			}else{
				throw new Exception("direction must be a shadow direction constant, value provided was: ".$direction);
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}					
	}
	
	/**
	 * Check if value is one of the Shadow constants
	 * @param $value the shadow constant value
	 * @return bool
	 */
	protected function checkShadowDirectionConst($value){
		if($value == self::INSET_DIR) return True;
		if($value == self::OUTSET_DIR) return True;
		return False;
	}		

	/**
	 * Transform a shadow into a text shadow or a box shadow depending the element
	 * @param $element and element object
	 * @return TextShadow() or BoxShadow() 
	 */
	function transmute($element){
		try{	
			if($element instanceof Text){
				return new TextShadow($this->position[0], $this->position[1], $this->blur,
						$this->spread, $this->color, $this->direction);
			}else{
				return new BoxShadow($this->position[0], $this->position[1], $this->blur,
						$this->spread, $this->color, $this->direction);
			}		
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	function getCSS(){
		try{				
			$css = sprintf("%s %s",$this->position[0],$this->position[1]);
			if($this->checkGreaterZero($this->blur)){
				$css = sprintf("%s %s",$css, $this->blur);
			}
			if($this->checkGreaterZero($this->spread)){
				$css = sprintf("%s %s",$css, $this->spread);
			}			
			$css = sprintf("%s %s",$css, $this->color->getCSS());
			if($this->direction != self::OUTSET_DIR){
				$css = sprintf("%s %s",$css, $this->direction);
			}			
			return $css.";";
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
}
?>
