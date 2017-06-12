<?php 
namespace HB\Clementine;
interface iProperty
{
	public function getCSS();
	public function __get($name);
	public function __set($name, $value);
	public function transmute($element);
}


?>