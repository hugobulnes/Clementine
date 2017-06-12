<?php
namespace HB\Clementine;
use \Exception;
class Border extends Property{
	
	private $side;		
	private $color = NULL;
	private $style;
	private $width;
	private $radius;
	
	/**
	 * Creates a one side border with two points indicating the side in which the border
	 * is been created a width a style and a color
	 *
	 * Posible constants for side are:
	 *
	 *     LEFT_SIDE | TOP_SIDE | RIGHT_SIDE | BOTTOM_SIDE
	 *
	 * Posible constants for width to use are (optional):
	 *
	 *     MEDIUM_SIZE | THIN_SIZE | THICK_SIZE
	 *
	 * Posible constanst for border style to use are:
	 *
	 *     DOTTED_BORDER | DASHED_BORDER | SOLID_BORDER | DOUBLE_BORDER | GROOVE_BORDER
	 *     RIDGE_BORDER | INSET_BORDER | OUTSET_BORDER | NON_BORDER | HIDDEN_BORDER 
	 *
	 * @param $side a side constant value
	 * @param $width a string size formatted value ("#","#px") or int value or size 
	 * constant value
	 * @param @style a style constant value
	 * @color a color string, rgb color array or a Color object
	 *
	 */
	public function __construct($side = NULL, $width = self::MEDIUM_SIZE, 
			$style = self::SOLID_BORDER, $color = "black"){
		try{																	
			$this->setSide($side);
			$this->setWidth($width);						
			$this->setStyle($style);			
			$this->setColor($color);
			$this->setRadius();
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	public function __set($name, $value){
		try{
			if($name == "width"){
				$this->setWidth($value);
			}else if($name == "style"){
				$this->setStyle($value);
			}else if($name == "aRadius"){
				$this->setRadius(array($value, $this->radius[1]));
			}else if($name == "bRadius"){
				$this->setRadius(array($this->radius[0], $value));
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}		
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	public function __get($name){
		try{
			if($name == "side"){
				return $this->side;
			}
			else if($name == "css"){
				return $this->getCSS();
			}
			else if($name == "width"){
				return $this->width;
			}
			else if($name == "color"){
				return $this->color;
			}
			else if($name == "style"){									
				return $this->style;
			}else if($name == "radius"){
				return $this->radius;
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Set the border color or clear the border color. Send a NULL parameter to 
	 * clear the color or call the function without a parameter.
	 *
	 * @param $color a color string, RGB array format or Color object
	 * @param $opacity, a float value opacity value must be between 0.0 to 1.0
	 */
	public function setColor($color = null, $opacity = 1.0){
		try{
			if(!is_null($color)){
				if($color instanceof Color){
					$this->color = $color;
				}else{
					if(is_null($this->color)){
						$this->color = new Color($color, $opacity);
					}else{
						$this->color->setColor($color);
					}
				}
			}else{
				$this->color = NULL;
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	

	/**
	 * Set the position of the border, possible constants are:
	 *
	 * 		TOP_SIDE | BOTTOM_SIDE | LEFT_SIDE | RIGHT_SIDE
	 * 
	 * @param $side the side constant
	 */
	public function setSide($side){
		try{
			if($this->checkPositionConst($side) && $side!= self::CENTER_SIDE){
				$this->side = $side;
			}else{
				throw new Exception("border side needs to be a position constant, value provided was: ".$side);
			}
		}catch (Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Set the style of the border, possible constants are:
	 *
	 * 		DOTTED_BORDER|DASHED_BORDER|SOLID_BORDER|DOUBLE_BORDER|GROOVE_BORDER|RIDGE_BORDER
	 *		INSET_BORDER|OUTSET_BORDER|NON_BORDER|HIDDEN_BORDER
	 *
	 *@param $style: the style constant of the border
	 */
	public function setStyle($style = self::SOLID_BORDER){
		try{
			if($this->checkBorderStyleConst($style)){
				$this->style = $style;
			}else{
				throw new Exception("border style needs to be a border style constant, value provided was: ".$style);
			}
		}catch (Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}	
	
	/**
	 * Set the border width, it can use one of the size constants:
	 *
	 * 		MEDIUM_SIZE | THIN_SIZE | THICK_SIZE
	 *
	 * @param $width if string provided it must be in unit format (#|#px|#%)
	 */
	public function setWidth($width = self::MEDIUM_SIZE){
		try{
			if($this->checkLengthConst($width) || $this->checkUnit($width)){
				$this->width = $width;
			}else{
				throw new Exception(
						"border width width needs to be a size formatted value or a length constant, value provided was: ".$width);
			}						
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Set the radius of the border
	 * @param $aEdge one of the edges of the border line, must be in unit formated style string or int
	 * @param $bEdge, one of the edges of the border line, must be in unit formated style string or int
	 */
	public function setRadius($aEdge=0, $bEdge=0){
		try{
			if($this->checkUnit($aEdge) && $this->checkUnit($bEdge)){
				$this->radius = array($aEdge, $bEdge);
			}else{
				throw new Exception(
						sprintf("radius values needs to be in unit formatted value, values provided was: (%s,%s)", $aEdge, $bEdge));
			}								
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Overrides parent method, get css values for builder
	 * @return String
	 */
	public function getCSS(){			
		if($this->side == self::TOP_SIDE) $css = "border-top: ";
		if($this->side == self::BOTTOM_SIDE) $css = "border-bottom: ";
		if($this->side == self::LEFT_SIDE) $css = "border-left: ";
		if($this->side == self::RIGHT_SIDE) $css = "border-right: ";
		$css = sprintf("%s%s ", $css, $this->width);
		$css = sprintf("%s%s ", $css, $this->style);		
		$css = (is_null($this->color)? $css : sprintf("%s%s;", $css, $this->color->getCSS()));
		if($this->radius[0] > 0 || $this->radius[1] > 0){
			if($this->side == self::TOP_SIDE){
				$css = $css . "\nborder-top-left: ". $this->radius[0].";";
				$css = $css . "\nborder-top-right: ". $this->radius[1].";";
			}
			if($this->side == self::BOTTOM_SIDE){
				$css = $css . "\nborder-bottom-left ". $this->radius[0].";";
				$css = $css . "\nborder-bottom-right: ". $this->radius[1].";";
			}
			if($this->side == self::LEFT_SIDE){
				$css = $css . "\nborder-top-left ". $this->radius[0].";";
				$css = $css . "\nborder-bottom-left: ". $this->radius[1].";";
			}
			if($this->side == self::RIGHT_SIDE){
				$css = $css . "\nborder-top-right ". $this->radius[0].";";
				$css = $css . "\nborder-bottom-right: ". $this->radius[1].";";
			}									
		}		
		return $css;				
	}
}
?>
