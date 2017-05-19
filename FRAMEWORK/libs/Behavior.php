<?php

class Behavior{
	
	const LEFT = "Left";
	const TOP = "Top";
	const BOTTOM = "Bottom";
	const RIGHT = "Right";
	
	public function Build(){
		return 0;
	}
	
	/*
	 * This function checks if value is in direction format
	 * @param $value: in CONST or String format.
	 * @return Boolean
	 */ 
	public function MatchDirection($value){
		if($value == self::LEFT) return true;
		if($value == self::TOP) return true;
		if($value == self::BOTTOM) return true;
		if($value == self::RIGHT) return true;
		return false;
	}
	
	/*
	 * This function check if the value is a number
	 * @param $value: in String or number format
	 * @param $digits: The number of digits it must have in Num format
	 * @return Boolean
	 */ 
	public function MatchNumber($value, $digits){
		#TODO: improve for security
		if(!is_numeric($value)) return false;
		if(strlen($value) != $digits) return false;
		return true;		
	}
	
	/*
	 * This function check for color
	 * 
	 */
	public function MatchColor($color){		
		return Color::MatchColor($color);		
	}
}
