<?php
	
	//namespace JT_Nelson;
	
	///////////////////////////
	//Load Constants///////////
	///////////////////////////

	function load_constants($cf_name){
		
		$escape = -1;
		$c_dir = false;
		$dir = dirname(__FILE__);
		
		//Loops until it find the correct directory
		do{
			$dir .= "/..";
			//Scan Directory
			$directory = scandir($dir);	
			
			//Check results
			for($i = 0; $i < count($directory); $i++){
				if($directory[$i] == "data"){
					$c_dir = true;
				}
			}
			
			//We don't like infinite loops
			$escape++;
			
		}while($c_dir == false && $escape < 4); //4 is an arbitrary number just past the expected parent dirs
		
		//Open Constants File
		$file_dir = $dir . "/data/" . $cf_name;
		
		//Checks for valid file - Gives warning if no file
		if($c_file = fopen($file_dir, "r")){
		
			//Reads File
			$data = null;
			
			//Checks if file has contents
			if(($size = filesize($file_dir)) > 0){
			
				//Reads File
				$data = fread($c_file,$size);
			}
			
			//Closes file
			fclose($c_file);
			
			//Returns object array
			return json_decode($data, true);
			
		}else{
		
			//no valid file
			return false;
		}
		
	}
	
	$constants = load_constants("mmdc.js");
	
	///////////////////////////
	//SQL Server Permissions///
	///////////////////////////
	
	define("ALLOW_TABLE_CREATION",isset($constants["ALLOW_TABLE_CREATION"]) ? $constants["ALLOW_TABLE_CREATION"]["VALUE"]: false);
	define("ALLOW_AUTO_TABLE_CREATION",isset($constants["ALLOW_AUTO_TABLE_CREATION"]) ? $constants["ALLOW_AUTO_TABLE_CREATION"]["VALUE"]: false);
	define("ALLOW_TABLE_DROP",isset($constants["ALLOW_TABLE_DROP"]) ? $constants["ALLOW_TABLE_DROP"]["VALUE"]: false); 
	define("ALLOW_AUTO_TABLE_DROP",isset($constants["ALLOW_AUTO_TABLE_DROP"]) ? $constants["ALLOW_AUTO_TABLE_DROP"]["VALUE"]: false);
	define("ALLOW_TABLE_POPULATE",isset($constants["ALLOW_TABLE_POPULATE"]) ? $constants["ALLOW_TABLE_POPULATE"]["VALUE"]: false);
	
	///////////////////////////
	//SQL Server Permissions///
	///////////////////////////
	
	define("TABLE_LOCATION",isset($constants["TABLE_LOCATION"]) ? $constants["TABLE_LOCATION"]["VALUE"]: "data/tables/");
	
	///////////////////////////
	//User Login Functionality/
	///////////////////////////
	
	define("EMAIL_AS_LOGIN",isset($constants["ALLOW_TABLE_CREATION"]) ? $constants["ALLOW_TABLE_CREATION"]["VALUE"]: true);
	define("LOGIN_SUCCESS_REDIRECT_LOCATION",isset($constants["LOGIN_REDIRECT_LOCATION"]) ? $constants["LOGIN_REDIRECT_LOCATION"]["SUCCESS"]["VALUE"]: "index.php");
	define("LOGIN_FAILURE_REDIRECT_LOCATION",isset($constants["LOGIN_REDIRECT_LOCATION"]) ? $constants["LOGIN_REDIRECT_LOCATION"]["FAILURE"]["VALUE"]: "index.php");
	define("CREATION_SUCCESS_REDIRECT_LOCATION",isset($constants["CREATION_REDIRECT_LOCATION"]) ? $constants["CREATION_REDIRECT_LOCATION"]["SUCCESS"]["VALUE"]: "index.php");
	define("CREATION_FAILURE_REDIRECT_LOCATION",isset($constants["CREATION_REDIRECT_LOCATION"]) ? $constants["CREATION_REDIRECT_LOCATION"]["FAILURE"]["VALUE"]: "index.php");
	
	///////////////////////////
	//Debug////////////////////
	///////////////////////////
	
	define("DEBUG", isset($constants["DEBUG"]) ? $constants["DEBUG"]["VALUE"]: false);
	define("DEBUG_DUMP", isset($constants["DEBUG_DUMP"]) ? $constants["DEBUG_DUMP"]["VALUE"]: false);

?>