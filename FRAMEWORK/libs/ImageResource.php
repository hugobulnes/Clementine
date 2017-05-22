<?php
namespace HB\Clementine;

class ImageResource{
	private $url = NULL;
	
	public function __construct($url){
		$this->url = $url;
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
}