<?php
	
	namespace JT_Nelson;
	
	///////////////////////////
	//T-Reader Page Constants//
	//If Pre-page fails////////
	///////////////////////////
		
	defined("TABLE_LOCATION") or define("TABLE_LOCATION","data/tables/");

	///////////////////////////
	//TableReader Class////////
	///////////////////////////
	
	class TableReader{
		public static function get_tables($table){
			
			
			$r = dirname(__FILE__) ;
			$tmp_dir = explode("/",TABLE_LOCATION);
			$des_dir = $tmp_dir[0];
			$escape = 0;
			
			do{
				$found = false;
				$escape++;
				$cur_dir = scandir($r);
				
				foreach($cur_dir as $d){
					if($d == $des_dir){
						$found = true;
					}
				}
				if($found != true){
					$r .= "/..";
				}
				
			}while($found==false && $escape < 5);
			
			$fileDir = $r . "/" . TABLE_LOCATION . $table;
			
			$myfile = fopen($fileDir, "r") or die("Unable to open file!");
			
			$data = fread($myfile,filesize($fileDir));
			
			fclose($myfile);
			
			return json_decode($data, true);
		}
	}
?>