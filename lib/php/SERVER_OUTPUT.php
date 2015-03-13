<?php
	namespace JT_Nelson;
	
	$ROOT = dirname(__FILE__);

	require_once($ROOT.'/Constants.php');
	require_once($ROOT.'/database_access/SQLServerCredentials.php');
	require_once($ROOT.'/database_access/Log.php');
	require_once($ROOT.'/database_access/PDOConnection.php');
	require_once($ROOT.'/database_access/SQLControls.php');
	require_once($ROOT.'/database_access/TableReader.php');
	
	$table_list = TableReader::get_tables("table_list.js");
	$input_structure = TableReader::get_tables("structure.js");
	
	var_dump($input_structure);
	
	//Recursive function for requesting data
	function get_data($structure, $t_list, $id = -1){
		$data = null;
		
		//Loops through provided request structure
		foreach($structure as $s_key => $s){
		
			//Checks if structure element is an array
			if(is_array($s)){
			
				//Prepares sql statement
				$sql = "SELECT * FROM " . $s["TABLE"];
				
				//Checks if id was provided
				if($id >= 0){ //Id provided
				
					//Adds id to sql request
					$sql .= " WHERE ID = ?";
					
					//Runs query
					$data[$s["TABLE"]] = SQLControls::query($sql,$id);
					
				}else{ //No id
				
					//Runs query
					$data[$s["TABLE"]] = SQLControls::query($sql);
				}
				
				//Checks if any results have been returned
				if(is_array($data[$s["TABLE"]])){					
					
					//Loops through the results
					foreach($data[$s["TABLE"]] as $d_key => $d){
						$parent = false;
						
						//Loops through the children in the structure
						foreach($structure[$s_key] as $s2_key => $s2){
							
							//resets temporary array
							$tmp_struct = null;
							
							//separates 1 specific element from the structure
							$tmp_struct[$s2_key] = $s2;
							
							//checks if the element key belongs to the associated table
							if(isset($t_list[$s_key]["COLUMNS"][$s2_key])){
							
								//Store the element's name in the table in a temporary variable
								$elem = $t_list[$s_key]["COLUMNS"][$s2_key]["NAME"];
																
								//Runs function again for child with child id
								$result = get_data($tmp_struct, $t_list, $d[$elem]);
								
								//Checks if there's a result
								if(is_array($result)){
									
									//Adds the result to the data
									$data[$s["TABLE"]][$d_key][$s2_key] = $result;
									
									//Unset the previously used key
									unset($data[$s["TABLE"]][$d_key][$elem]);
									
								}else{
									
									//Adds the current value to the data
									$data[$s["TABLE"]][$d_key][$s2_key] = $data[$s["TABLE"]][$d_key][$elem];
									
									//Unset the previously used key
									unset($data[$s["TABLE"]][$d_key][$elem]);
									
								}
								
							}elseif(is_array($s2)){
								
								//Runs function again for child with parent id
								$data[$s["TABLE"]][$d_key][$s2_key] =  get_data($tmp_struct, $t_list, $d[0]);
								
							}
							
							
						}
					}
					
				}else{
					return null;
				}
			}
		}
		//echo "ID - " . $id;
		//var_dump($structure);
		return $data;
	}
	
	$data = get_data($input_structure,$table_list);
	var_dump($data["TEAMS"]);
?>