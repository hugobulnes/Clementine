<?php
namespace HB\Clementine;
use \Exception;
class ImageResource{
	private $url = NULL;
	
	public function __construct($url){
		try {
			if(is_string($url)){
				$this->url = $url;
			}else{
				throw new Exception(
						'Invalid argument type, accepts String only, value sent '. $url);
			}
		} catch (Exception $e) {
			throw  new Exception(ErrorHelper::formatMessage(__FUNCTION__,__CLASS__,$e));
		}
		
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
	
	public function __toString(){
		return $this->url;
	}
}