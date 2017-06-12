<?php 
namespace HB\Clementine;
class Property implements iProperty{
	const LEFT_SIDE = 'left';
	const TOP_SIDE= 'top';
	const RIGHT_SIDE= 'right';
	const CENTER_SIDE= 'center';
	const BOTTOM_SIDE= 'bottom';	
	
	const MEDIUM_SIZE = 'medium';
	const THIN_SIZE= 'thin';
	const THICK_SIZE= 'thick';	
	const NW_CORNER = 1000;
	const NE_CORNER = 1001;
	const SE_CORNER = 1002;
	const SW_CORNER = 1003;
	const ALL_CORNER = 1004;
	
	const X_REP = 'x-repeat';
	const Y_REP = 'y-repeat';
	const N_REP = 'no-repeat';
	const A_REP = 'x-repeat y-repeat';
	
	const SCROLL_ATT = 'scroll';
	const FIXED_ATT = 'fixed';
	const LOCAL_ATT = 'local';
	
	const DOTTED_BORDER = "dotted";
	const DASHED_BORDER= "dashed";
	const SOLID_BORDER= "solid";
	const DOUBLE_BORDER= "double";
	const GROOVE_BORDER= "groove";
	const RIDGE_BORDER= "ridge";
	const INSET_BORDER= "inset";
	const OUTSET_BORDER= "outset";
	const NON_BORDER= "none";
	const HIDDEN_BORDER= "hidden";
	
	private $id = "";
	private $class = "";
	private $rules = array();
	private $properties = array();
	
	
	
	
	protected function checkUnit($value, $units="px|\%"){
		if(is_numeric($value)) return True;
		$units = explode("|", $units);
		$pass = FALSE;		
		foreach ($units as $unit){
			$pattern = '/^\d+'.$unit.'$/';			
			if(preg_match($pattern, $value)){
				$pass = TRUE;
			}
		}		
		return $pass;		
	}
	
	protected function checkRepetitionConst($value){
		if($value == self::X_REP) return True;
		if($value == self::Y_REP) return True;
		if($value == self::N_REP) return True;
		if($value == self::A_REP) return True;
		return False;
	}
	
	protected function checkAttachmentConst($value){
		if($value == self::SCROLL_ATT) return True;
		if($value == self::FIXED_ATT) return True;
		if($value == self::LOCAL_ATT) return True;		
		return False;
	}
	
	protected function checkPositionConst($value){
		if($value == self::TOP_SIDE) return True;
		if($value == self::BOTTOM_SIDE) return True;
		if($value == self::LEFT_SIDE) return True;
		if($value == self::RIGHT_SIDE) return True;
		if($value == self::CENTER_SIDE) return True;
		return False;
	}
	
	protected function checkBorderStyleConst($value){
		if(self::DOTTED_BORDER) return True;
		if(self::DASHED_BORDER) return True;
		if(self::SOLID_BORDER) return True;
		if(self::DOUBLE_BORDER) return True;
		if(self::GROOVE_BORDER) return True;
		if(self::RIDGE_BORDER) return True;
		if(self::INSET_BORDER) return True;
		if(self::OUTSET_BORDER) return True;
		if(self::NON_BORDER) return True;
		if(self::HIDDEN_BORDER) return True;
		return False;
		
	}
		
	protected function checkLengthConst($value){
		if($value == self::MEDIUM_SIZE) return True;
		if($value == self::THIN_SIZE) return True;
		if($value == self::THICK_SIZE) return True;				
		return False;
	}
	
	protected function checkCornerFormat($value){
		if($value == self::NW_CORNER) return True;
		if($value == self::NE_CORNER) return True;
		if($value == self::SE_CORNER) return True;
		if($value == self::SW_CORNER) return True;
		if($value == self::ALL_CORNER) return True;
		return False;
	}
	
	protected function checkGreaterZero($value){
		if(is_string($value)){
			if(preg_match('/^[1-9]([0-9]*)\%$/', $value))return True;
			if(preg_match('/^[1-9]([0-9]*)px$/', $value)) return True;
			if(preg_match('/^[1-9]([0-9]*)$/', $value)) return True;
		}else{
			if($value > 0) return True;
		}
		return False;
	}
	
	function getCSS(){
		return "";
	}
	
	function __get($name){
		return False;
	}
	
	function __set($name, $value){
		return False;
	}
	
	function transmute($element){
		return false;
	}
	
}


?>