<?php
namespace HB\Clementine;
use \Exception;
class Borders extends Property{
	
	private $top;
	private $right;
	private $bottom;
	private $left;
	private $radius = array(0,0,0,0);
	
	//Document
	public function __construct($width = self::MEDIUM_SIZE, $style = Border::SOLID_BORDER, 
			$color = "black", $radius = 0){
		try{
			$this->top = new TopBorder($width, $style, $color);			
			$this->right = new RightBorder($width, $style, $color);			
			$this->bottom = new BottomBorder($width, $style, $color);		
			$this->left = new LeftBorder($width, $style, $color);
			$this->setRadius($radius);
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
			}else if($name == "radius"){
				$this->setRadius($value);			
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	public function __get($name){
		try{
			if($name == "css"){
				return $this->getCSS();
			}else if($name == "top"){
				return $this->top;
			}if($name == "bottom"){
				return $this->bottom;
			}if($name == "left"){
				return $this->left;
			}if($name == "right"){
				return $this->right;
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	
	/*
	 * Set the border color or clear the border color
	 *
	 * Send a NULL parameter to clear the color or call the
	 * function without a parameter.
	 *
	 * @param Color|int[3]|String $color, in RGB array format or string or Color object
	 * @param float $opacity, opacity value must be between 0.0 to 1.0
	 */
	public function setColor($color = null, $opacity = 1.0){
		try{
			if(!is_null($color)){
				if($color instanceof Color){
					
					$this->top->setColor($color);
					$this->right->setColor($color);
					$this->bottom->setColor($color);
					$this->left->setColor($color);
										
				}else{
					$this->top->setColor($color, $opacity);
					$this->right->setColor($color, $opacity);
					$this->bottom->setColor($color, $opacity);
					$this->left->setColor($color, $opacity);
				}
			}else{
				$this->top->setColor(null);
				$this->right->setColor(null);
				$this->bottom->setColor(null);
				$this->left->setColor(null);				
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
			
	/*
	 * Set the style of the 4 borders, possible constant values are:
	 * 		DOTTED_BORDER|DASHED_BORDER|SOLID_BORDER|DOUBLE_BORDER|GROOVE_BORDER|RIDGE_BORDER
	 *		INSET_BORDER|OUTSET_BORDER|NON_BORDER|HIDDEN_BORDER
	 *
	 *@param const $style: the style of the border in border style constant format
	 */
	public function setStyle($style = Border::SOLID_BORDER){
		try{
			$this->top->setStyle($syle);
			$this->right->setStyle($syle);
			$this->bottom->setStyle($syle);
			$this->left->setStyle($syle);			
		}catch (Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}	
	
	/*
	 * Set the border width of the 4 sides, it can use one of the size constants:
	 * 		MEDIUM_SIZE|THIN_SIZE|THICK_SIZE
	 * @param const|String|int $width, the width of the border, if string provided it must be in unit format (#|#px|#%)
	 */
	public function setWidth($width = self::MEDIUM_SIZE){
		try{
			$this->top->setWidth($width);
			$this->right->setWidth($width);
			$this->bottom->setWidth($width);
			$this->left->setWidth($width);
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/*
	 * Set the radius of the a specific corner of all the corners,
	 * possible constant values for corner are:
	 * 
	 * 			NW_CORNER|NE_CORNER|SE_CORNER|SW_CORNER|ALL_CORNER
	 * 
	 * @param String|int $radius, the radius of the corner in unit format
	 * @param const $corner, the changed corner
	 */
	public function setRadius($radius = 0, $corner = self::ALL_CORNER){
		try{
			if($this->checkCornerFormat($corner)){
				if(!$this->checkUnit($radius)){
					throw new Exception(
							"parameter radius needs to be unit formatted value, value provided was: ".$radius);
				}								
				if($corner == self::ALL_CORNER){
					$this->radius = array($radius, $radius, $radius, $radius);
				}else{
					if($corner == self::NW_CORNER) $this->radius[0] = $radius;
					if($corner == self::NE_CORNER) $this->radius[1] = $radius;
					if($corner == self::SE_CORNER) $this->radius[2] = $radius;
					if($corner == self::SW_CORNER) $this->radius[3] = $radius;
				}
			}else{
				throw new Exception("corner parameter must be a corner constant, value : ".$corner);
			}						
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	private function checkPositiveRadius(){		
		for($i = 0; $i < 4; $i ++){			
			if($this->checkGreaterZero($this->radius[$i])){				
				return True;
			}
		}
		return False;				
	}
	
	/**
	 * Overrides parent method, get css values for builder
	 * @return String
	 */
	public function getCSS(){	
		try{
		
			$a = function($arr){
				if(sizeof(array_unique($arr)) > 1){
					if($arr[0] == $arr[1] && $arr[2] == $arr[3]){
						return sprintf("%s %s",$arr[0], $arr[2]);
					}else{
						return sprintf("%s %s %s %s",$arr[0], $arr[2], $arr[1], $arr[3]);
					}
				}else{
					return sprintf("%s",$arr[0]);
				}
			};		
			$css = "border: ";
			
			$borderWidth = array($this->top->width, $this->bottom->width, 
					$this->right->width, $this->left->width);		
			
			$css = $css . $a($borderWidth) . " ";		
			
			$borderStyle = array($this->top->style, $this->bottom->style,
					$this->right->style, $this->left->style);				
			
			$css = $css . $a($borderStyle) . " ";
			
			$borderColor = array($this->top->color->css, $this->bottom->color->css,
					$this->right->color->css, $this->left->color->css);
			
			$css = $css . $a($borderColor). ";";
			
			if($this->checkPositiveRadius()){
				if(sizeof(array_unique($this->radius)) > 1){
					if($arr[0] == $arr[2] && $arr[1] == $arr[3]){
						return sprintf("%s %s",$arr[0], $arr[1]);
					}else{
						return sprintf("%s %s %s %s",$arr[0], $arr[1], $arr[2], $arr[3]);
					}
				}else{
					$css = $css . "\nborder-radius: ". $this->radius[0] . ";";	
				}
			}		
			return $css;
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
}
?>