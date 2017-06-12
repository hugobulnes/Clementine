<?php 
namespace HB\Clementine;
interface iElement
{
	public function getHTML();
	public function __get($name);
	public function __set($name, $value);
}
?>