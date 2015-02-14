<?php
	
	namespace JT_Nelson;
	
	///////////////////////////
	//T-Reader Page Constants//
	//If Pre-page fails////////
	///////////////////////////
		
	defined("TABLE_LOCATION") or define("TABLE_LOCATION","bin/tables/");

	///////////////////////////
	//TableReader Class////////
	///////////////////////////
	
	class TableReader{
		public static function get_table($table){
			$fileDir = TABLE_LOCATION . $table;
			
			$myfile = fopen($fileDir, "r") or die("Unable to open file!");
			
			$data = fread($myfile,filesize($fileDir));
			
			fclose($myfile);
			
			return json_decode($data, true);
		}
	}
?>