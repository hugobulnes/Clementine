<?php 
namespace HB\Clementine;

use \Exception;

class Shadows extends Property{
	
	private $position = 0;
	private $shadows = array();
	
	public function __construct($shadows){
		try{
			
		}catch(Exception $e){
			throw new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}	
	}
	
	public function iterShadows(){		
		for($i = 0; $i < count($shadows); $i++){
			yield $shadows[$i];			
		}
	}
		
	function addShadow($shadow){
		if($shadow instanceof Shadow){
			array_push($this->shadows, $shadow);
		}
	}
	
	function addShadow($hPos, $vPos, $blur=0, $spread=0, $color="black", $direction=self::OUTSET_DIR){
		$shadow = new Shadow($hPos, $vPos, $blur, $spread, $color, $direction);
		array_push($this->shadows, $shadow);
	}
	
	function setShadow($index, $shadow){
		if($shadow instanceof Shadow){
			$this->shadow[$index] = $shadow;
		}
	}
	
	function removeShadow($index){
		unset($this->shadows[$index]);
	}
	
	function getCSS(){
		
	}
	
}


?>