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
try{

	$txt = new Text("Hello World");	
	echo $txt->label. "\n";
	
	$shadow = new Shadow("15px", 15);
	$color = new Color("red");
	$txt->addProperty($shadow);
	$txt->addProperty($color);
	
	foreach($txt->iterateProperty() as $prop){
		echo $prop->getCSS() . "\n";
	}
	
	
 
}catch (\Exception $e){
	$error = $e->getMessage() . "\n";
	while($e = $e->getPrevious()) {
		$error = $error . 'Previous Error: '.$e->getMessage() . "\n";
	}	
	trigger_error($error,E_USER_NOTICE);
	/*
	 * $trace = debug_backtrace();
	trigger_error(
			$error .
			' in ' . $trace[0]['file'] . "\n" .
			' on line ' . $trace[0]['line'],
			E_USER_NOTICE);
			*/			
}
/*
//Aproach 1 - Adding property to element text
$shadow = new Shadow();
$text.AddProperty($shadow);

//Aproach 2 - Creating a asembler 
$shadow = new Shadow();
$text = new Label();

$textsshadow = Assembler::Combine($text, $shadow); 

*/



//var_dump(class_implements($back));

?>