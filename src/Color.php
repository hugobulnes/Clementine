<?php
namespace HB\Clementine;
use \Exception;
class Color	extends Property 
{
	private $r = 0;
	private $g = 0;
	private $b = 0;
	private $opacity = 1.0;
	
	/*
	 * Create a color data, possible instantiation parameters are:
	 * 
	 * 		$color = new Color(); <- Default will create a black color
	 *      $color = new Color("black");
	 *      $color = new Color("#ffffff");
	 *      $color = new Color(array(0,0,0)); <- where arr[0]: Red, arr[1]: Green, arr[2]: Blue
	 * 	 
	 * @param int[]|string $color: String color name or string hexadecimal format or rgb array
	 * 								rgb array admints values from 0 to 255;
	 * @param float $opacity: The opacity of the color, possible values from 0.0 to 1.0	  
	 * @TODO: getColorList, remove hex and make RGB to ints array, then change code to 
	 * not convert RGB into a string and instead validate against the RGB array
	 */
	public function __construct($color=array(0,0,0), $opacity=1.0){			
		try{			
			$this->setColor($color, $opacity);			
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	public function __set($name, $value){
		try{
			if($name == "opacity"){
				$this->setOpacity($value);
			}else if($name == "r"){
				$this->setRGB($value,$this->g,$this->b);
			}else if($name == "g"){
				$this->setRGB($this->r,$value,$this->b);
			}else if($name == "b"){
				$this->setRGB($this->r,$this->g,$value);
			}else if($name == "name" || $name == "hex"){
				$this->setColor($value);
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		}catch(Exception $e){			
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	public function __get($name){
		try{
			if($name == "opacity"){
				return $this->opacity;
			}else if($name == "r"){
				return $this->r;
			}else if($name == "g"){
				return $this->g;
			}else if($name == "b"){
				return $this->b;
			}else if($name == "name"){
				return $this->getName();
			}else if($name == "hex"){
				return $this->getHex();
			}else if($name == "css"){
				return $this->getCSS();
			}else{
				throw new Exception(sprintf("Undefied property %s ", $name));
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	
	/*
	 * Get a color in rgb array format or string and opacity and assign the color value off
	 * the object and assign the opacity.
	 * @param array|String $color, in RGB array format or string
	 * @param float $opacity, opacity value
	 */
	public function setColor($color=NULL, $opacity=NULL){				
		try{	
			if(is_null($color) && is_null($opacity)){
				$color = array(0,0,0);
				$opacity = 1.0;
			}
			if(!is_null($opacity)){
				$this->setOpacity($opacity);
			}									
			if(is_array($color)){
				list($r, $g, $b) = $color;
				$this->setRGB($r, $g, $b);
			}else if(is_string($color)){
				$color = $this->matchColor($color);				
				if($color){
					list($r, $g, $b) = $this->strToRGB($color[2]);
					$this->setRGB($r, $g, $b);
				}else{
					throw new Exception("bad color name or hexadecimal format");
				}
			}else if($color instanceof Self){				
				$this->setRGB($color->r, $color->g, $color->b);
			}else{
				throw new Exception("color parameter needs array or string, value provided was : ". $color);
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}

	/*
	 * Validate if the color provided is in color data
	 * @param String $color || int[] $color
	 * @return Boolean || array
	 * (preg_match('/^[0-2]([0-5]{1,2})?,[0-2]([0-5]{1,2})?,[0-2]([0-5]{1,2})?$/', $color) 
	 * @TODO: in case of array sent, check if it has 3 values minimum
	 */ 
	public function matchColor($color){	
		if(is_array($color) || is_string($color)){
			$index = 0;		
			if(is_array($color)){
				$index= 2;
				$color = sprintf("%d,%d,%d", $color[0], $color[1], $color[2]);
			}else if(preg_match('/^#\w+$/', $color)){
				$color = "#".strtoupper(substr($color, 1));
				$index= 1;
			} else if(preg_match('/^\w+$/', $color)){
				$color = strtolower($color);
			}		
			foreach($this->getColorList() as $colorDTA){				
				if($colorDTA[$index] == $color){					
					return $colorDTA;
				}
			}
		}else{
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
		return FALSE;		
	}
	
	/*
	 * convert a string to an rgb array, string must be in the proper
	 * format (###,###,###)
	 * @param String color, the color string
	 * @return array	 
	 */
	public function strToRGB($color){
		try{
			if(is_string($color)){
				$rgb = explode(",", $color);
				return array(intval($rgb[0]), intval($rgb[1]), intval($rgb[2]));
			} else{
				throw new Exception("parameter need to be a string value, value provided was: ".$color); 
			}
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/*
	 * Set the opacity of the color
	 * @param float $value, opacity value 0.0 - 1.0 	 
	 */
	public function setOpacity($value = 1.0){
		try{
			if(!is_float($value))
				throw new Exception("opacity value must be a float number, value provided is ".$value);
			if($value < 0.0 || $value > 1)
				throw new Exception("opacity value must be between 0.0 to 1.0, value provided is ".$value);
			$this->opacity = $value;					
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
	/*
	 * Return the opacity level of the color
	 * @return float;
	 */
	public function getOpacity(){
		return $this->opacity;
	}
	
	/*
	 * Return the color Name
	 * @return String
	 */
	public function getName(){
		$color = $this->matchColor($this->getRGB());	
		if($color){
			return $color[0];
		}else{
			return "";
		}
	}
	
	/*
	 * Return the color in HexValue
	 * @return String
	 */
	public function getHex(){
		$color = $this->matchColor($this->getRGB());
		if($color){
			return $color[1];
		}else{
			return "";
		}
	}
	
	/*
	 * Return the color in RGB Value
	 * @return String
	 */
	public function getRGB(){
		return sprintf("%d,%d,%d", $this->r, $this->g, $this->b);
	}
	
	/*
	 * set the RGB values of the color
	 * @param int $r: the Red value of the color, possible values are from 0 - 255
	 * @param int $g: the Green value of the color, possible values are from 0 - 255
	 * @param int $b: the Blue value of the color, possible values are from 0 - 255	 
	 */
	public function setRGB($r=0, $g=0, $b=0){
		try{
			if(!is_int($r) || ($r < 0 && $r > 255)) 
				throw new Exception(sprintf(
					"r value must be a int between 0 to 255, value provided %s", $r));
			if(!is_int($g) || ($g < 0 && $g > 255))
				throw new Exception(sprintf(
					"g value must be a int between 0 to 255, value provided %s", $g));
			if(!is_int($b) || ($b < 0 && $b > 255))
				throw new Exception(sprintf(
					"b value must be a int between 0 to 255, value provided %s", $b));			
			$this->r = $r;			
			$this->g = $g;
			$this->b = $b;
		}catch(Exception $e){							
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));						
		}
	}
	
	/*
	 * Get a list of colors
	 * @return array
	 */
	private function getColorList(){
		$colorList = array();
		
		array_push($colorList, array("aliceblue", "#F0F8FF", "240,248,255"));
		array_push($colorList, array( "antiquewhite", "#FAEBD7", "250,235,215"));
		array_push($colorList, array( "aqua", "#00FFFF", "0,255,255"));
		array_push($colorList, array( "aquamarine", "#7FFFD4", "127,255,212"));
		array_push($colorList, array( "azure", "#F0FFFF", "240,255,255"));
		array_push($colorList, array( "beige", "#F5F5DC", "245,245,220"));
		array_push($colorList, array( "bisque", "#FFE4C4", "255,228,196"));
		array_push($colorList, array( "black", "#000000", "0,0,0"));
		array_push($colorList, array( "blanchedalmond", "#FFEBCD", "255,235,205"));
		array_push($colorList, array( "blue", "#0000FF", "0,0,255"));
		array_push($colorList, array( "blueviolet", "#8A2BE2", "138,43,226"));
		array_push($colorList, array( "brown", "#A52A2A", "165,42,42"));
		array_push($colorList, array( "burlywood", "#DEB887", "222,184,135"));
		array_push($colorList, array( "cadetblue", "#5F9EA0", "95,158,160"));
		array_push($colorList, array( "chartreuse", "#7FFF00", "127,255,0"));
		array_push($colorList, array( "chocolate", "#D2691E", "210,105,30"));
		array_push($colorList, array( "coral", "#FF7F50" ,"255,127,80"));
		array_push($colorList, array( "cornflowerblue", "#6495ED", "100,149,237"));
		array_push($colorList, array( "cornsilk", "#FFF8DC", "255,248,220"));
		array_push($colorList, array( "crimson", "#DC143C", "220,20,60"));
		array_push($colorList, array( "cyan", "#00FFFF", "0,255,255"));
		array_push($colorList, array( "darkblue", "#00008B", "0,0,139"));
		array_push($colorList, array( "darkcyan", "#008B8B", "0,139,139"));
		array_push($colorList, array( "darkgoldenrod", "#B8860B", "184,134,11"));
		array_push($colorList, array( "darkgray", "#A9A9A9", "169,169,169"));
		array_push($colorList, array( "darkgrey", "#A9A9A9", "169,169,169")); //Check this one
		array_push($colorList, array( "darkgreen", "#006400", "0,100,0"));
		array_push($colorList, array( "darkkhaki", "#BDB76B", "189,183,107"));
		array_push($colorList, array( "darkmagenta", "#8B008B", "139,0,139"));
		array_push($colorList, array( "darkolivegreen", "#556B2F", "85,107,47"));
		array_push($colorList, array( "darkorange", "#FF8C00", "255,140,0"));
		array_push($colorList, array( "darkorchid", "#9932CC", "153,50,204"));
		array_push($colorList, array( "darkred", "#8B0000", "139,0,0"));
		array_push($colorList, array( "darksalmon", "#E9967A", "233,150,122"));
		array_push($colorList, array( "darkseagreen", "#8FBC8F", "143,188,143"));
		array_push($colorList, array( "darkslateblue", "#483D8B", "72,61,139"));
		array_push($colorList, array( "darkslategray", "#2F4F4F", "47,79,79")); //Check this one
		array_push($colorList, array( "darkslategrey", "#2F4F4F", "47,79,79"));
		array_push($colorList, array( "darkturquoise", "#00CED1", "0,206,209"));
		array_push($colorList, array( "darkviolet", "#9400D3", "148,0,211"));
		array_push($colorList, array( "deeppink", "#FF1493", "255,20,147"));
		array_push($colorList, array( "deepskyblue", "#00BFFF", "0,191,255"));
		array_push($colorList, array( "dimgray", "#696969", "105,105,105"));
		array_push($colorList, array( "dimgrey", "#696969", "105,105,105"));
		array_push($colorList, array( "dodgerblue", "#1E90FF", "30,144,255"));
		array_push($colorList, array( "firebrick", "#B22222", "178,34,34"));
		array_push($colorList, array( "floralwhite", "#FFFAF0", "255,250,240"));
		array_push($colorList, array( "forestgreen", "#228B22", "34,139,34"));
		array_push($colorList, array( "fuchsia", "#FF00FF", "255,0,255"));
		array_push($colorList, array( "gainsboro", "#DCDCDC", "220,220,220"));
		array_push($colorList, array( "ghostwhite", "#F8F8FF", "248,248,255"));
		array_push($colorList, array( "gold", "#FFD700", "255,215,0"));
		array_push($colorList, array( "goldenrod", "#DAA520", "218,165,32"));
		array_push($colorList, array( "gray", "#808080", "128,128,128"));
		array_push($colorList, array( "grey", "#808080", "128,128,128"));
		array_push($colorList, array( "green", "#008000", "0,128,0"));
		array_push($colorList, array( "greenyellow", "#ADFF2F" , "173,255,47"));
		array_push($colorList, array( "honeydew", "#F0FFF0", "240,255,240"));
		array_push($colorList, array( "hotpink", "#FF69B4", "255,105,180"));
		array_push($colorList, array( "indianred", "#CD5C5C", "205,92,92"));
		array_push($colorList, array( "indigo", "#4B0082", "75,0,130"));
		array_push($colorList, array( "ivory", "#FFFFF0","255,255,240"));
		array_push($colorList, array( "khaki", "#F0E68C", "240,230,140"));
		array_push($colorList, array( "lavender", "#E6E6FA", "230,230,250"));
		array_push($colorList, array( "lavenderblush", "#FFF0F5","255,240,245"));
		array_push($colorList, array( "lawngreen", "#7CFC00", "124,252,0"));
		array_push($colorList, array( "lemonchiffon", "#FFFACD", "255,250,205"));
		array_push($colorList, array( "lightblue", "#ADD8E6", "173,216,230"));
		array_push($colorList, array( "lightcoral", "#F08080", "240,128,128"));
		array_push($colorList, array( "lightcyan", "#E0FFFF", "224,255,255"));
		array_push($colorList, array( "lightgoldenrodyellow", "#FAFAD2", "250,250,210"));
		array_push($colorList, array( "lightgray", "#D3D3D3", "211,211,211"));
		array_push($colorList, array( "lightgrey", "#D3D3D3", "211,211,211"));
		array_push($colorList, array( "lightgreen", "#90EE90", "144,238,144"));
		array_push($colorList, array( "lightpink", "#FFB6C1", "255,182,193"));
		array_push($colorList, array( "lightsalmon", "#FFA07A","255,160,122"));
		array_push($colorList, array( "lightseagreen", "#20B2AA", "32,178,170"));
		array_push($colorList, array( "lightskyblue", "#87CEFA", "135,206,250"));
		array_push($colorList, array( "lightslategray", "#778899", "119,136,153"));
		array_push($colorList, array( "lightslategrey", "#778899", "119,136,153"));
		array_push($colorList, array( "lightsteelblue", "#B0C4DE", "176,196,222"));
		array_push($colorList, array( "lightyellow", "#FFFFE0", "255,255,224"));
		array_push($colorList, array( "lime", "#00FF00", "0,255,0"));
		array_push($colorList, array( "limegreen", "#32CD32", "50,205,50"));
		array_push($colorList, array( "linen", "#FAF0E6", "250,240,230"));
		array_push($colorList, array( "magenta", "#FF00FF", "255,0,255"));
		array_push($colorList, array( "maroon", "#800000", "128,0,0"));
		array_push($colorList, array( "mediumaquamarine", "#66CDAA", "102,205,170"));
		array_push($colorList, array( "mediumblue", "#0000CD", "0,0,205"));
		array_push($colorList, array( "mediumorchid", "#BA55D3", "186,85,211"));
		array_push($colorList, array( "mediumpurple", "#9370DB", "147,112,219"));
		array_push($colorList, array( "mediumseagreen", "#3CB371", "60,179,113"));
		array_push($colorList, array( "mediumslateblue", "#7B68EE", "123,104,238"));
		array_push($colorList, array( "mediumspringgreen", "#00FA9A", "0,250,154"));
		array_push($colorList, array( "mediumturquoise", "#48D1CC", "72,209,204"));
		array_push($colorList, array( "mediumvioletred", "#C71585", "199,21,133"));
		array_push($colorList, array( "midnightblue", "#191970", "25,25,112"));
		array_push($colorList, array( "mintcream", "#F5FFFA", "245,255,250"));
		array_push($colorList, array( "mistyrose", "#FFE4E1", "255,228,225"));
		array_push($colorList, array( "moccasin", "#FFE4B5", "255,228,181"));
		array_push($colorList, array( "navajowhite", "#FFDEAD", "255,222,173"));
		array_push($colorList, array( "navy", "#000080", "0,0,128"));
		array_push($colorList, array( "oldlace", "#FDF5E6", "253,245,230"));
		array_push($colorList, array( "olive", "#808000", "128,128,0"));
		array_push($colorList, array( "olivedrab ", "#6B8E23", "107,142,35"));
		array_push($colorList, array( "orange", "#FFA500", "255,165,0"));
		array_push($colorList, array( "orangered", "#FF4500", "255,69,0"));
		array_push($colorList, array( "orchid", "#DA70D6", "218,112,214"));
		array_push($colorList, array( "palegoldenrod", "#EEE8AA", "238,232,170"));
		array_push($colorList, array( "palegreen", "#98FB98", "152,251,152"));
		array_push($colorList, array( "paleturquoise", "#AFEEEE", "175,238,238"));
		array_push($colorList, array( "palevioletred", "#DB7093", "219,112,147"));
		array_push($colorList, array( "papayawhip", "#FFEFD5", "255,239,213"));
		array_push($colorList, array( "peachpuff", "#FFDAB9", "255,218,185"));
		array_push($colorList, array( "peru", "#CD853F", "205,133,63"));
		array_push($colorList, array( "pink", "#FFC0CB", "255,192,203"));
		array_push($colorList, array( "plum", "#DDA0DD", "221,160,221"));
		array_push($colorList, array( "powderblue", "#B0E0E6", "176,224,230"));
		array_push($colorList, array( "purple", "#800080", "128,0,128"));
		array_push($colorList, array( "rebeccapurple", "#663399", "102,51,153"));
		array_push($colorList, array( "red", "#FF0000", "255,0,0"));
		array_push($colorList, array( "rosybrown", "#BC8F8F", "188,143,143"));
		array_push($colorList, array( "royalblue", "#4169E1", "65,105,225"));
		array_push($colorList, array( "saddlebrown", "#8B4513", "139,69,19"));
		array_push($colorList, array( "salmon", "#FA8072", "250,128,114"));
		array_push($colorList, array( "sandybrown", "#F4A460", "244,164,96"));
		array_push($colorList, array( "seagreen", "#2E8B57", "46,139,87"));
		array_push($colorList, array( "seashell", "#FFF5EE", "255,245,238"));
		array_push($colorList, array( "sienna", "#A0522D", "160,82,45"));
		array_push($colorList, array( "silver", "#C0C0C0", "192,192,192"));
		array_push($colorList, array( "skyblue", "#87CEEB", "135,206,235"));
		array_push($colorList, array( "slateblue", "#6A5ACD", "106,90,205"));
		array_push($colorList, array( "slategray", "#708090", "112,128,144"));
		array_push($colorList, array( "slategrey", "#708090", "112,128,144"));
		array_push($colorList, array( "snow", "#FFFAFA", "255,250,250"));
		array_push($colorList, array( "springgreen", "#00FF7F", "0,255,127"));
		array_push($colorList, array( "steelblue", "#4682B4", "70,130,180"));
		array_push($colorList, array( "tan", "#D2B48C", "210,180,140"));
		array_push($colorList, array( "teal", "#008080", "0,128,128"));
		array_push($colorList, array( "thistle", "#D8BFD8", "216,191,216"));
		array_push($colorList, array( "tomato", "#FF6347", "255,99,71"));
		array_push($colorList, array( "turquoise", "#40E0D0", "64,224,208"));
		array_push($colorList, array( "violet", "#EE82EE", "238,130,238"));
		array_push($colorList, array( "wheat", "#F5DEB3", "245,222,179"));
		array_push($colorList, array( "white", "#FFFFFF", "255,255,255"));
		array_push($colorList, array( "whitesmoke", "#F5F5F5", "245,245,245"));
		array_push($colorList, array( "yellow", "#FFFF00", "255,255,0"));
		array_push($colorList, array( "yellowgreen", "#9ACD32", "154,205,50"));
		
		return $colorList;				
	}
	
	/**
	 * Overrides parent method, get css values for builder	 
	 * @return String
	 */
	public function getCSS(){
		try{
			return sprintf("rgba(%s, %01.2f)", $this->getRGB(), $this->opacity);
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
	}
	
}


?>
