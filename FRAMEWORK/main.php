<?php 
namespace HB\Clementine;

//Check if windows system
if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
	require_once("config/win.php");	
} else {
	require_once("config/unix.php");
}
require_once("config/global.php");

if(!is_file(DIR_GLIBS.DIR_SLASH."autoload.php")){
	//SEND ERROR AND TERMINATE
}

require_once(DIR_GLIBS.DIR_SLASH."autoload.php");

$register = new AutoloaderPsr4();

//Create file if not found
if(!is_file(DIR_CONFIG.DIR_SLASH."register.json")){
	$register->registerClasses();
	$register->registerTemplates();
}

$register->registerAutoloader();


if(is_dir(DEF_TEMPLATE)){
	if(is_file(DEF_TEMPLATE.DIR_SLASH."Init.php")){
		require DEF_TEMPLATE.DIR_SLASH."Init.php";
		$color = new \Init();
		//$template = Init();
		
	}
}

//$color = new Init();




?>