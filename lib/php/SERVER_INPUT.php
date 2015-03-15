<?php
	namespace JT_Nelson;
	
	$ROOT = dirname(__FILE__);
	require_once($ROOT.'/Constants.php');
	require_once($ROOT.'/database_access/SQLServerCredentials.php');
	require_once($ROOT.'/database_access/Log.php');
	require_once($ROOT.'/database_access/PDOConnection.php');
	require_once($ROOT.'/database_access/SQLControls.php');
	require_once($ROOT.'/database_access/TableReader.php');
	
	if(!isset($_POST["input"])){
		exit();
	}
	if(empty($_POST["input"])){
		exit();
	}
	$input_data = json_decode($_POST["input"], true);
	if($input_structure == null){
		exit();
	}
	
	$input_structure;
	if(isset($_POST["structure"])){
		if(!empty($_POST["structure"])){
			$input_structure = json_decode($_POST["structure"], true);
		}else{
			$input_structure = TableReader::get_tables("structure-a.js");
		}
	}else{
		$input_structure = TableReader::get_tables("structure-a.js");
	}
	if($input_structure == null){
		exit();
	}
	
	$table_list = TableReader::get_tables("table_list-a.js");
	if($table_list == null){
		exit();
	}
	
	input_data($input_data, $input_structure, $table_list);
	
	function input_data($data, $structure, $t_list, $p_index = 0){	
		$matching_key = false;
		$all_numeric = true;
		$cur_table = null;
		
		//Checks for a valid table name
		if(isset($structure["TABLE"])){
			$cur_table = $structure["TABLE"];
			
			$correct_inputs = 0;
			//Tries to input table
			foreach($t_list[$cur_table]["COLUMNS"] as $t_key => $t){
			
				if(isset($data[$t_key])){
				
					if(is_array($data[$t_key])){
						//Runs function again if it matches
						$data[$t_key] = input_data($data[$t_key], $structure[$t_key], $t_list, $p_index);
					}

					$correct_inputs++;
				}						
			}
			if($correct_inputs > 0){
			
				//Replace terms with parent index
				foreach($t_list[$cur_table]["COLUMNS"] as $t_key => $t){
					if(isset($structure[$t_key])){
						if($structure[$t_key] == "PARENT"){
							$data[$t_key] = $p_index;
							$correct_inputs++;
						}
					}
				}
				
				//Input data no return
				$p_index = JN\SQLControls::insert($data,$t_list[$cur_table]);
				
				//Remove inserted elements
				foreach($t_list[$cur_table]["COLUMNS"] as $t_key => $t){
					if(isset($data[$t_key])){
						unset($data[$t_key]);
					}
				}
				
			}
		}
		
		
		
		//Searches for a matching key in structure
		//Also check if all the elements are numeric
		foreach($data as $d_key => $d){
		
			//Checks if key matches
			if(isset($structure[$d_key])){
			
				if(is_array($data[$d_key])){
					//Runs function again if it matches
					$data[$d_key] = input_data($d, $structure[$d_key], $t_list, $p_index);
					
				}
				
				$matching_key = true;
				
			}
			
			//Checks if the key is numeric
			if(!is_numeric($d_key)){
				$all_numeric = false;
			}
			
		}
		
		//If no matching key found and all elements are numeric (array)
		if($matching_key == false && $all_numeric){
		
			//Input each element
			for($i = 0; $i < count($data); $i++){
				input_data($data[$i], $structure, $t_list, $p_index);
			}
			
		}else{
			//Input data with return
			if($cur_table != null){
				return  JN\SQLControls::insert($data,$t_list[$cur_table]);
			}
		}
		
		return $p_index;
	}
	
	
?>