<?php 
namespace HB\Clementine;

class AutoloaderPsr4 {

	/**
	 * String holding the file path containing the libs directories
	 * @var String
	 */
	private $registerFile = DIR_CONFIG.DIR_SLASH."register.json";
	
	/**
	 * Create register file if not exists
	 * @param $fileName: The file path name
	 * @return bool: true if success false if failure
	 * @TODO: Condition for failure
	 */
	private function createRegister($fileName){
		if(!file_exists($fileName)){
			$json = array("libs"=>array(), "templates"=>array());
			$this->jEncode($json, $fileName);
		}
		return TRUE;
	}
	
	/**
	 * Returns an array from json
	 * @param string $fileName: File name and path
	 * @return array
	 * @TODO: Return True or False
	 */
	private function jDecode($fileName){
		$contents = file_get_contents($fileName);
		$json = json_decode($contents, true);
		return $json;
	}
	
	/**
	 * Edit a json file
	 * @param $jsonArray:array The array with values to encode
	 * @param $fileName: string The json file path 
	 * @return 
	 * @TODO: Return true or false
	 */
	private function jEncode($jsonArray, $fileName){
		$json = json_encode($jsonArray, JSON_PRETTY_PRINT);
		file_put_contents($fileName, $json);		
	}
	
	/**
	 * look for __init__.json files through file structure  and register classes by
	 * creating the config/libs.json file
	 * @eturn
	 * @TODO: Check for errors
	 * @extra
	 * 		//Write the libs.json file
	 *	/*$fp = fopen($this->registerFile, 'w');
	 *	fwrite($fp, json_encode($namespaces, JSON_PRETTY_PRINT));
	 *	fclose($fp);
	 */
	public function registerClasses(){
		if(!$this->createRegister($this->registerFile)){
			return FALSE;
		}		
		$jRegister = $this->jDecode($this->registerFile);		
		$classesPaths = $this->searchFolders(DIR_ROOT, "__init__.json");				
		foreach($classesPaths as $classPath){
			$jClassDetails = $this->jDecode($classPath.DIR_SLASH."__init__.json");			
			if(!array_key_exists($jClassDetails['namespace'], $jRegister['libs'])){
				$jRegister['libs'][$jClassDetails['namespace']] = array();				
			}			
			foreach($jClassDetails["__all__"] as $className){
				if(!in_array($classPath.DIR_SLASH.$className, $jRegister['libs'][$jClassDetails['namespace']])){
					array_push($jRegister['libs'][$jClassDetails['namespace']], $classPath.DIR_SLASH.$className);
				}								
			}
		}				
		$this->jEncode($jRegister, $this->registerFile);		
	}
	
	/**
	 * Register templates in register
	 * @return bool True if succ, False if Fails
	 * @TODO: Conditional bool
	 */
	public function registerTemplates(){
		if(!$this->createRegister($this->registerFile)){
			return FALSE;
		}	
		$jRegister = $this->jDecode($this->registerFile);
		$templatePaths = $this->searchFolders(DIR_TEMPLATES, "init.php" );
		foreach($templatePaths as $templatePath){
			if(!in_array($templatePath, $jRegister['templates'])){
				array_push($jRegister['templates'], $templatePath);
			}
		}
		$this->jEncode($jRegister, $this->registerFile);	
		return TRUE;
	}
	
	
	/**
	 * Search Recursively for lookup in file structure
	 * @param string $path: the root path of the search
	 * @param string $lookup: the search file
	 * @returns array with directories found
	 */
	public function searchFolders($path, $lookup){
		$filesNPath = scandir($path);
		$foundPaths = array();
		foreach($filesNPath as $file){
			$pointer = $path.DIR_SLASH.$file;
			if(!in_array($file, [".","..",".DS_Store"])){
				if(is_dir($pointer)){
					$return = $this->searchFolders($pointer, $lookup);
					if(sizeof($return) > 0){
						$foundPaths = array_merge($foundPaths, $return);
					}
				}elseif($file == $lookup){
					array_push($foundPaths, $path);
				}
			}
		}
		return $foundPaths;
	}
	
	/**
	 * finds a path of a full-qualified class name from the register file
	 * @param string $className: The class name to search
	 * @return array of paths if success or false if failed
	 */
	public function findClassGlobal($className){
				
		$namespace = substr($className, 0, strrpos($className, "\\"));
		$baseClassName = substr($className, strrpos($className, "\\")+1);
		
		$json = $this->jDecode($this->registerFile);
		
		if(array_key_exists($namespace, $json["libs"])){
			foreach ($json["libs"][$namespace] as $path){
				if($baseClassName == substr($path, strrpos($path, DIR_SLASH)+1)){
					return $path;
				}
			}
		}
		return false;
	}

	/**
	 * finds a path of a full-qualified class name from the local path searching
	 * the __init__.json file
	 * @param $className String, the class name to search
	 * @return array of paths if success or false
	 */
	public function findClassLocal($className){
		
		$namespace = substr($className, 0, strrpos($className, "\\"));
		$baseClassName = substr($className, strrpos($className, "\\")+1);
		
		if(file_exists(__DIR__.DIR_SLASH.$baseClassName.".php")){
			return __DIR__.DIR_SLASH.$baseClassName;
		}
		
		
		/*
		if(file_exists(__DIR__ .DIR_SLASH."__init__.json")){
			$namespace = substr($className, 0, strrpos($className, "\\"));
			$baseClassName = substr($className, strrpos($className, "\\")+1);
			
			$json = $this->jDecode(__DIR__.DIR_SLASH."__init__.json");
						
			foreach ($json["__all__"] as $path){
				if($baseClassName == $path){					
					return __DIR__.DIR_SLASH.$baseClassName;
				}
			}
					
		}*/				
		return false;
	}
	
	
	
	/**
	 * Register loader with sp_autoloader
	 */
	public function registerAutoloader(){
		spl_autoload_register(array($this, 'loader'));
	}
	
	/**
	 * Loads the class file from the class name
	 * @param string $className: The fully-qualified name
	 * @return boolean: True if sucess, false if fail
	 * @TODO: remove prefix and return TRUE if is class in case of default classnames
	 */
	public function loader($className){					
		
		$path = $this->findClassLocal($className);	

		if($path == False){
			$path = $this->findClassGlobal($className);
		}		
		if(!$path == false){
			$filename = $path . ".php";			
			if(file_exists($filename)){				
				require $filename;
				if(class_exists($className)) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}
}
?>
