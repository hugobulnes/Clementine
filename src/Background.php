<?php
namespace HB\Clementine;

use \Exception;

class Background extends Property{

	/// the color object holder for the background	
	private $color = NULL;
	/// the image resource object holder for the background
	private $imgResource = NULL;	
	/// holds the value for the repetition of the image
	private $imgRepetition;
	/// An array holding the image position in coord format (#,#)
	private $imgPosition;
	/// holds the image attachment value
	private $imgAttachment;
	
	/**
	 * This class is used to create a background for an element, you can add an image 
	 * or a color to the background. You can sent a color object as a color parameter 
	 * @param $color [Color|int[3]|String] this is the color value for the background
	 * @param $url [String], this is the url of the image
	 * @param $imgRepeat [const] the repeat of the image
	 * @param $imgPosition [array[2]], the start position of the image background
	 * @param $imgFix [const], the attachment of the image background
	 */
	public function __construct($color = NULL, $url = NULL){
		try{
			if(is_null($color) && is_null($url)) throw new Exception(
				'Invalid argument, you must provide at least a color or a url');
			if(!is_null($url)){
				$this->setImage($url);
				$this->setImageRepetition();
				$this->setImageAttachment();
				$this->setImagePosition();							
			}
			if(!is_null($color)){
				$this->setColor($color);
			}			
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e)); 
		}		
	}
	
	public function __get($name){
		try{
			if($name == "color"){
				return $this->color;
			}else if($name == "imageUrl"){
				return $this->imgResource;
			}else if($name == "position"){
				return $this->imgPosition;
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
				$this->setColor($value);
			}else if($name == "imageUrl"){
				$this->setImage($value);
			}elseif($name == "xpos"){
				$this->setImagePosition($value, $this->imgPosition[1]);
			}else if($name == "ypos"){
				$this->setImagePosition($this->imgPosition[0], $value);
			}
		} catch (Exception $e) {
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Set the background color or clear the background color
	 * 
	 * Send a NULL parameter to clear the color or call the 
	 * function without a parameter.
	 *
	 * @param $color [Color|int[3]|String] in RGB array format or string or Color object
	 * @param $opacity [float] opacity value must be between 0.0 to 1.0
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
	 * Set a background Image or clear a background Image, sending NULL to the
	 * url parameter clears the background image 
	 * @param $url a url path string Clear the color
	 */
	public function setImage($url= NULL){
		try{
			if(!is_null($url)){
				$this->imgResource = new ImageResource($url);				
			}else{
				$this->setImageRepetition();
				$this->setImageAttachment();
				$this->setImagePosition();
				$this->imgResource = NULL;				
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Repeats the background image along the x and y axis, it can repeat using
	 * the following constans:
	 * 
	 *     X_REP = repeat horizontally (x)
	 *     Y_REP = repeat vertically (y)
	 *     N_REP = none repeat   
	 *     A_REP = repeat both (x&y)
	 * 
	 * To use this method first there has to be an image on the background,
	 * use first setImage() to set an image in the background. 
	 * 
	 * @param $dir a direction constant
	 */
	public function setImageRepetition($dir = self::N_REP){
		try{
			if(is_null($this->imgResource)){
				throw new Exception(
						'to use this method first there has to be an image on the background');
			}
			if(self::checkRepetitionConst($dir)){
				$this->imgRepetition= $dir;
			}else{
				throw new Exception('direction of repetition needs to be in repetition constant value'.
						"value provided was, ".$dir);
			}			
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}		
	}
	
	/**
	 * Set the background image position, to use this method first there has to 
	 * be an image on the background. Sending NULL to both x and y parameters 
	 * reset the position to (0,0). Position constants that can be used are:
	 * 
	 * 		LEFT_SIDE|TOP_SIDE|RIGHT_SIDE|CENTER_SIDE|BOTTOM_SIDE
	 * 	  
	 * @param $x a x coord in "#%" or "#px" string format, # (int) or a position constant
	 * @param $y a x coord in "#%" or "#px" string format, # (int) or a position constant
	 */
	public function setImagePosition($x = null, $y = null){
		try{
			if(is_null($x) && is_null($y)){
				$this->imgPosition = array('0','0');
			}else{
				if(is_null($x) || is_null($y)){
					throw new Exception(sprintf("x pos and y pos must be provided, values (%s,%s)",$x, $y));
				}
				if(!$this->checkPositionConst($x) && !$this->checkUnit($x)){
					throw new Exception("x pos must be a position const or position format (#%|#px|#), value provided was: ".$x);
				}
				if(!$this->checkPositionConst($y) && !$this->checkUnit($y)){
					throw new Exception("y pos must be a position const or position format (#%|#px|#), value provided was: ".$y);
				}
				$this->imgPosition = array($x, $y);								
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}					
	}
	
	/**
	 * Set the background image Attachment, to use this method first there has to
	 * be an image on the background. Attachment constants that can be used are:
	 *
	 *     SCROLL_ATT|FIXED_ATT|LOCAL_ATT
	 *     
	 * @param $attachment: an attachment constant
	 */     
	public function setImageAttachment($attachment = self::SCROLL_ATT){
		try{
			if($this->checkAttachmentConst($attachment)){
				$this->imgAttachment = $attachment;
			}else{
				throw new Exception("Attachment must be one of the Attachment constants, value provided was: ".$attachment);
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
		
	}
	
	/**
	 * Set the opacity of the background
	 * @param $opacity the float value for opacity from 0.0 to 1.0
	 */
	public function setOpacity($opacity=1.0){
		try{
			if(!is_float($value))
				throw new Exception("opacity value must be a float number, value provided is ".$opacity);
				if($opacity< 0.0 || $opacity> 1)
					throw new Exception("opacity value must be between 0.0 to 1.0, value provided is ".$opacity);
					$this->opacity = $opacity;
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/**
	 * Overrides parent method, get css values for builder
	 * @return String
	 */
	public function getCSS(){
		try{			
			$color = (is_null($this->color)? "" : $this->color->getCSS());
			if(is_null($this->imgResource)){
				$css = sprintf("background: %s ", $color);
			}else{			 			
				$pos = sprintf("%s %s", $this->imgPosition[0], $this->imgPosition[0]);
				$css = sprintf("background: %s url(\"%s\") %s %s %s", $color, 
						$this->imgResource, $pos, $this->imgRepetition, $this->imgAttachment);
			}
			return $css.";";
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
}
?>
