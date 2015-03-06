<?php

	/*
	Author: Jeffrey Nelson
	Date Started: November 2014
	Description:
		Wrapper for PDOConnection.php
	*/
	
	namespace JT_Nelson;
	
	///////////////////////////
	//SQL Controls Constants///
	//If SQLSC fails///////////
	///////////////////////////

	defined("ALLOW_TABLE_CREATION") or define("ALLOW_TABLE_CREATION",false);
	defined("ALLOW_TABLE_DROP") or define("ALLOW_TABLE_DROP",false); 
	
	defined("DB_HOST") or define("DB_HOST","You may");
	defined("DB_NAME") or define("DB_NAME","want to");
	defined("DB_USERNAME") or define("DB_USERNAME","change these.");
	defined("DB_PASSWORD") or define("DB_PASSWORD","If you want to");
	
	///////////////////////////
	//SQLControls Class////////
	///////////////////////////

	class SQLControls{
		
		//Creates a table
		public static function create_table($table_info){

			//Check Permissions
			if(!ALLOW_TABLE_CREATION){
				return 0;
			}
			
			//Prepares parameters
			$redef_params = array();
			foreach($table_info["COLUMNS"] as $column){
			
				//Sets Name
				$param = $column["NAME"];
				
				//Sets Type
				$param .= " " . $column["TYPE"];
				
				//Sets Size
				$param .= isset($column["SIZE"]) ? ("(" . $column["SIZE"] . ")") : "";
				
				//Sets Key (DOES NOT SUPPORT FOREIGN)
				$param .= isset($column["KEY"]) ? (" " . $column["KEY"] . " KEY") : "";
				
				//Sets Collation
				$param .= isset($column["COLLATE"]) ? (" COLLATE " . $column["COLLATE"]) : "";
				
				//Sets Default
				
				if(isset($column["DEFAULT"])){
					if(is_string($column["DEFAULT"])){
					
						$param .= " DEFAULT '" . $column["DEFAULT"] . "'";
						
					}elseif(is_numeric($column["DEFAULT"])){
					
						$param .= " DEFAULT " . $column["DEFAULT"];
						
					}
				}
				
				//Sets Auto Increment
				$param .= isset($column["A_I"]) ? ($column["A_I"] == true ? " AUTO_INCREMENT" : "" ) : "";
				
				$redef_params[] = $param;
			}

			//Prepare SQL
			$sql = "CREATE TABLE IF NOT EXISTS " . $table_info["NAME"] . " (" . implode(", ",$redef_params) . ")";
			
			//Run query
			self::query($sql);
			
			return 1;
		}
		
		//Drops a table
		public static function drop_table($table_info){
			//Check Permissions
			if(!ALLOW_TABLE_DROP){
				return 0;
			}
			
			//Prepare SQL
			$sql = "DROP TABLE IF EXISTS " . $table_info["NAME"];
			
			//Run query
			self::query($sql);
			
			return 1;
		}
		
		//Sends a generic server query
		public static function query(){
		
			//Initializes debug
			if(DEBUG){
				$log = new Log("SQL::query");
				$log->setParameters("table_info");
			}
			
			//Ensures at least SQL statement
			$func_arg_count = func_num_args();
			if($func_arg_count < 1){
				if(DEBUG){
					$log->add("No arguments provided");
					$log->display();
					$log = null;
				}
				return 0;
			}
			
			//Prep sql statement
			$sql = func_get_arg(0);
			if(!is_string($sql)){
				if(DEBUG){
					$log->add("Invalid sql statement provided");
					$log->display();
					$log = null;
				}
				return 0;
			}
			
			$result = 0;
			//Checks for valid input
			if($func_arg_count > 1){//Input is expected
			
				//Secondary initialization of debug
				if(DEBUG){
					$log->setArguments(func_get_arg(0));
					for($i = 1; $i < func_num_args();$i++){
						$log->setParameters("argument-" . $i);
						$log->setArguments(func_get_arg($i));
					}
				}
				
				//Check if input is not in a proper array
				$arg = func_get_arg(1);
				if(!is_array($arg)){
				
					$arg = array();
					for($i = 1; $i < $func_arg_count; $i++){
					
						$arg_elem = func_get_arg($i);
						//Check if input element is array
						if(is_array($arg_elem)){
							if(DEBUG){
								$log->add("Invalid input type: array");
								$log->display();
								$log = null;
							}
							return 0;
						}
						$arg[] = $arg_elem;
						
					}
					if(DEBUG) $log->add("New array: array( " . implode( ", ",$arg) ." )");
				
				}else{
				
					for($i = 0; $i < count($arg); $i++){
					
						//Check if input element is array
						if(is_array($arg[$i])){
							if(DEBUG){
								$log->add("Invalid input type: array");
								$log->display();
								$log = null;
							}
							return 0;
						}
						
					}
				
				}
				
				//Runs query
				$connection = new PDOConnection(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				$result = $connection->query($sql, $arg);
				$connection->close();
				
			}else{//No input expected
			
				//Initialize debug
				if(DEBUG){
					for($i = 0; $i < func_num_args();$i++){
						$log->setArguments(func_get_arg($i));
					}
				}
				
				//Runs query
				$connection = new PDOConnection(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				$result = $connection->query($sql);
				$connection->close();
				
			}	
			
			//Displays debug message
			if(DEBUG){
				$log->display();
				$log = null;
			}
			return $result;
			
		}
		
		//Inserts an element into a table
		public static function insert($data, $table_info){
			
			//Initializes debug
			if(DEBUG){
				$log = new Log("SQL::insert");
				$log->setParameters("data","table_info");
			}
			
			
			$vt_input;
			$vt_qm;
			$vt_column;
			
			foreach($table_info["COLUMNS"] as $key => $column){
			
				//Check if it auto-increments
				if(isset($column["A_I"])){
					if($column["A_I"] == true){
					
						//If it does move to the next column
						continue;
						
					}
				}
				
				//If value doesn't exist check if default is present
				if(!isset($data[$key]) && !isset($column["DEFAULT"])){
					
					//If no default exists, exit function
					if(DEBUG){ 
						$log->add("Element '" . $key . "' not provided.");
						$log->display();
						$log = null;
					}
					
					return null;
					
				}
				
				
				//Future check for type?
				
				
				$vt_input[] = isset($data[$key]) ? $data[$key] : $column["DEFAULT"];
				$vt_qm[] =  "?";
				$vt_column[] = (string)$column["NAME"];
				
				
			}
			
			//Prepare SQL
			$sql = "INSERT INTO ". $table_info["NAME"] . "(" . implode(", ",$vt_column) . ") VALUES (" . implode(", ", $vt_qm) . ")";
			
			
			return self::query($sql,$vt_input);
			
		}
		
		//Deletes an element from a table
		public static function delete($table_info,$arg,$val){
			
			//Ensures arg is a string
			if(!is_string($arg)){
				return 0;
			}
			
			//Prepare SQL
			$sql = "DELETE FROM " . $table_info["NAME"] . " WHERE " . $arg . " = ?";
			
			//Run query
			self::query($sql,$val);
			
			return 1;
		}
		
		public static function does_exist($table_info,$arg,$val){
			
			//Ensures arg is a string
			if(!is_string($arg)){
				return 0;
			}
			
			//Prepare SQL
			$sql = "SELECT * FROM " . $table_info["NAME"] . " WHERE " . $arg . " = ?";
			
			//Run query
			$result = self::query($sql,$val);
			
			//Checks for return
			if(is_array($result)){
				return 1;
			}else{
				return 0;
			}
		}
	}

	?>