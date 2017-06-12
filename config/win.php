<?php 

$expPath = explode("\\", __DIR__);
array_pop($expPath);
define("DIR_ROOT", implode("\\", $expPath));
define("DIR_SLASH", "\\");

?>