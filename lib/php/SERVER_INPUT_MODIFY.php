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
	
	echo modify_data($input_data, $input_structure, $table_list);
	
	function modify_data($data, $structure, $t_list){	

		
		$cur_table = null;
		$correct_inputs = 0;
		$filter = null;
		//Checks for a valid table name
		foreach($data as $d_key => $d){
			if(isset($structure[$d_key]["TABLE"])){
				$cur_table = $structure[$d_key]["TABLE"];				
			}
			if(isset($d["FILTER"])){
				$filter = $d["FILTER"];
			}
		}
		if($correct_inputs > 0){
			return JN\SQLControls::modify($filter, $data, $t_list[$cur_table]);
		}
		return null;
	}
	
	
?>