<?php 
namespace HB\Clementine;
use \Exception;
class ErrorHelper{
	
	public static function formatMessage($fun, $clas, $message){
		if($message instanceof Exception){
			return sprintf("\nfunction %s on class %s caught an error -> %s",$fun,$clas,$message->getMessage());
		}
		return sprintf("\nfunction %s on class %s caught an error -> %s",$fun,$clas,$message);
		
	}
}
?>