<?php
use HB\Clementine\Color;

class Init{	
	public function init(){
		
		
		echo "Hello from init \n";				
		
		$colorA = new Color();
		$res = $colorA->MatchColor("0,0,0,0.6,00");		
		var_dump($res);		
	}
}	
?>
