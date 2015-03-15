<?php
	namespace JT_Nelson;
	
	$ROOT = dirname(__FILE__);

	require_once($ROOT.'/Constants.php');
	require_once($ROOT.'/database_access/SQLServerCredentials.php');
	require_once($ROOT.'/database_access/Log.php');
	require_once($ROOT.'/database_access/PDOConnection.php');
	require_once($ROOT.'/database_access/SQLControls.php');
	require_once($ROOT.'/database_access/TableReader.php');
	
	$table_list = TableReader::get_tables("table_list-a.js");
	$input_structure = TableReader::get_tables("structure-a.js");
	
	//Recursive function for requesting data
	function get_data($structure, $t_list, $id = 0){
		$data = null;
		
		//Loops through provided request structure
		foreach($structure as $s_key => $s){
		
			//Checks if structure element is an array
			if(is_array($s)){
			
				//Prepares sql statement
				$sql = "SELECT * FROM " . $s["TABLE"];
				
				//Checks if id was provided
				if($id > 0){ //Id provided
					
					//Gets primary key
					$id_name =  $t_list[$s["TABLE"]]["COLUMNS"]["ID"]["NAME"];
					
					//Searches for foreign key
					foreach($s as $s2_key => $s2){
					
						//Checks if foreign key
						if(is_string($s2) && $s2 == "PARENT"){
						
							//Sets search id to foreign key
							$id_name = $t_list[$s["TABLE"]]["COLUMNS"][$s2_key]["NAME"];
							
						}
					}
					
					//Adds id to sql request
					$sql .= " WHERE " . $id_name . " = ?";
					
					//Runs query
					$data = SQLControls::query($sql,$id);
					
				}else{ //No id
				
					//Runs query
					$data = SQLControls::query($sql);
				}
				
				//Checks if any results have been returned
				if(is_array($data)){					
					
					//Loops through the results
					foreach($data as $d_key => $d){
						$parent = false;
						
						//Loops through the children in the structure
						foreach($structure[$s_key] as $s2_key => $s2){
							
							//resets temporary array
							$tmp_struct = null;
							
							//separates 1 specific element from the structure
							$tmp_struct[$s2_key] = $s2;
							
							//checks if the element key belongs to the associated table
							if(isset($t_list[$s["TABLE"]]["COLUMNS"][$s2_key])){
							
								//Store the element's name in the table in a temporary variable
								$elem = $t_list[$s["TABLE"]]["COLUMNS"][$s2_key]["NAME"];
								
								//Runs function again for child with child id
								$result = get_data($tmp_struct, $t_list, $d[$elem]);
								
								//Checks if there's a result
								if(is_array($result)){
									
									//Adds the result to the data
									$data[$d_key][$s2_key] = $result;
									
									//Unset the previously used key
									unset($data[$d_key][$elem]);
									
								}else{
									
									//Adds the current value to the data
									$data[$d_key][$s2_key] = $data[$d_key][$elem];
									
									//Unset the previously used key
									unset($data[$d_key][$elem]);
									
								}
								
							}elseif(is_array($s2)){
								
								//Runs function again for child with parent id
								$data[$d_key][$s2_key] =  get_data($tmp_struct, $t_list, $d[0]);
								
							}
						}
					}
					
					//Lets clean up the array shall we?
					foreach($data as $d_key => $d){
						foreach($data[$d_key] as $d2_key => $d2){
						
							//Remove numeric elements
							if(is_numeric($d2_key)){
							
								//To prevent any issues with removing elements while counting though
								if(isset($data[$d_key][$d2_key])){
								
									//Removes the element
									unset($data[$d_key][$d2_key]);
									
									continue;
								}
								
							}
							
							foreach($t_list[$s["TABLE"]]["COLUMNS"] as $t_key => $t){
								if($d2_key == $t["NAME"]){
									
									//Switches key if the element is not the primary key
									if($t_key != "ID"){
									
										//Switches key for element
										$data[$d_key][$t_key] = $data[$d_key][$d2_key];
								
									}
									
									//Removes previous named element
									unset($data[$d_key][$d2_key]);
									
									continue;
								}
							}
							
						}
					}
					
					if(isset($s["ARRAY"])){
						if($s["ARRAY"] != true){
							$data = $data[0];
						}
					}else{
						$data = $data[0];
					}
					
				}else{
					//You broke physics, or there were no results
					//Whichever is more likely
					return null;
				}
			}
		}

		return $data;
	}
	
	$data = get_data($input_structure, $table_list);
	
	echo json_encode($data);

?>