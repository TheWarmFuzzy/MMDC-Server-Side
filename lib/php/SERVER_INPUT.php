<?php
	namespace JT_Nelson
	
	if(!isset($_POST["input"])){
		exit();
	}
	if(empty($_POST["input"])){
		exit();
	}
	
	$ROOT = dirname(__FILE__);
	require_once($ROOT.'Constants.php');
	require_once($ROOT.'/database_access/SQLServerCredentials.php');
	require_once($ROOT.'/database_access/Log.php');
	require_once($ROOT.'/database_access/PDOConnection.php');
	require_once($ROOT.'/database_access/SQLControls.php');
	require_once($ROOT.'/database_access/TableReader.php');
	
	$table_list = JN\TableReader::get_tables("table_list.js");
	
	$input_structure = TableReader::get_tables("structure.js");
	$input_structure = json_decode($input_structure, true);
	
	function input_data($data, $structure){
		$output;
		
		foreach($data as $d_key => $d){
		
			if(isset($structure[$d_key])){
				if($structure[$d_key]["ARRAY"]){
					//Array

					$output[] = input_data($d, $structure[$d_key]);
				
				}
			}else{
				//Object
					
					
					
			}
				
			foreach($d as $de_key => $de){
				if(is_array($de)){
					$de = input_data($de, $structure[$d_key][$de_key]);
				}
			}
		
			$table = $table_list[$d["TABLE"]];
			SQLControls::insert($d,$table);
		}
		
		return count($output) > 1 ? $output : $output[0];
		
	}
	
	
?>