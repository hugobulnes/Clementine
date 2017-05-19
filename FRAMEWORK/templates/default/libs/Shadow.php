<?php

class Shadow extends Behavior{
	
	private $color;
	private $direction;
	private $expansion;
	private $blur;
	
	/*
	 * Constructor
	 * Property 
	 * @param: $col [REQ]. color of the shadow in color format
	 * @param: $opa [REQ]. percentage of opacity in number format ##
	 * @param: $dir. Direction of the shadow, posible values: Top/Bottom/Left/Right 
	 * @param: $exp. Expansion of the shadow, in number format ##
	 * @param: $blur. The blur of the sadow, in number format ##
	 * @CSS: hr, ver, blur, exp, rgba(0,0,0,0.per)
	 */ 
	public function __construct($col=NULL, $dir=NULL, $exp=NULL, $blur=NULL){
		#TODO: check if values are given if not assign default values
		#TODO: Check if parameters are in correct format
		$this->color = new Color($col);
		$this->direction = $dir;
		$this->expansion = $exp;
		$this->blur = $blur;		
	}
		 
	public function setColor($color){
		$this->color = new Color($col);
	}
	
	public function getColor(){
		return $this->color;
	}
	
	public function setDirection($direction){
		#TODO: Error message in case direction not in format
		if($this->MatchDirection($direction) == true){
			$this->direction = $direction;
		}
	}
	
	public function setExpansion($expansion){
		#TODO: Error message in case direction not in format
		if($this->MatchNumber($expansion, 2)){
			$this->expansion = $expansion;
		}
	}
	
	public function setBlur($blur){
		#TODO: Error message in case direction not in format
		if($this->MatchNumber($blur, 2) == true){
			$this->blur = $blur;
		}
	}
	
	
}


?>
