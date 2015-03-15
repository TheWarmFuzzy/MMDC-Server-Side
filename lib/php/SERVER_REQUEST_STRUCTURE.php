<?php
	namespace JT_Nelson;
	
	$ROOT = dirname(__FILE__);
	require_once($ROOT.'/Constants.php');
	require_once($ROOT.'/database_access/TableReader.php');
	
	
	/*
	if(!isset($_GET["mode"])){
		exit();
	}
	if(empty($_GET["mode"])){
		exit();
	}
	
	$mode = $_GET["mode"];
	*/
	
	$data=null;
	$d_team = null;
	$d_team["TEAM"] = null;
	$d_team["TEAM"]["ARRAY"] = true;
	$d_team["TEAM"]["TABLE"] = "TEAMS";
	
	$d_dancer = null;
	$d_dancer["DANCERS"] = null;
	$d_dancer["DANCERS"]["TABLE"] = "DANCERS";
	$d_dancer["DANCERS"]["ARRAY"] = true;
	$d_dancer["DANCERS"]["TEAM_ID"] = "PARENT";
	
	if(isset($_GET["target"])){
		switch($_GET["target"]){
			case "dancer":
				echo json_encode($d_dancer);
				break;
			case "team":
				echo json_encode($d_team);
				break;
			default:
				$d_team["TEAM"]["DANCERS"] = $d_dancer["DANCERS"];
				echo json_encode($d_team);
				break;
		}
		
	}else{
		$d_team["TEAM"]["DANCERS"] = $d_dancer["DANCERS"];
		echo json_encode($d_team);
	}
	exit();

?>