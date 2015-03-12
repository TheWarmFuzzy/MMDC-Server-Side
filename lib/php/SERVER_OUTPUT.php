<?php
	namespace JT_Nelson;
	
	$ROOT = dirname(__FILE__);
	echo $ROOT;
	require_once($ROOT.'/Constants.php');
	require_once($ROOT.'/database_access/SQLServerCredentials.php');
	require_once($ROOT.'/database_access/Log.php');
	require_once($ROOT.'/database_access/PDOConnection.php');
	require_once($ROOT.'/database_access/SQLControls.php');
	require_once($ROOT.'/database_access/TableReader.php');
	
	$table_list = TableReader::get_tables("table_list.js");
	$input_structure = TableReader::get_tables("structure.js");
	
	var_dump($table_list);
	
	
?>