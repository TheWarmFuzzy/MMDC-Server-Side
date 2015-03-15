<?php

	/*
	Author: Jeffrey Nelson
	Date Started: November 2014
	Description:
		Secure sql connections resistant to injections.
	*/
	
	namespace JT_Nelson;
	
	use \PDO;
	
	///////////////////////////
	//PDO Connection Constants/
	//If Pre-page fails////////
	///////////////////////////

	defined("DEBUG") or define("DEBUG",false);
	defined("CONNECT_WITHOUT_DB_NAME") or define("CONNECT_WITHOUT_DB_NAME",false);

	///////////////////////////
	//PDOConnection Class//////
	///////////////////////////
		
	class PDOConnection{
		private $pdoConnection;
		
		public function __construct(){ //dns_type, host, user_name, password [, database_name, port]
			//Initialize debug
			if(DEBUG){
				$log = new Log("pdoConnection::__construct");
				$log->setParameters("dns_type", "host","user_name","password","database", "port");
				for($i = 0; $i < func_num_args();$i++){
					//For censoring password
					if($i == 3){
						$log->setArguments("*");
					}else{
						$log->setArguments(func_get_arg($i));
					}
				}
			}
			
			//Preps DNS information
			$dns = func_get_arg(0) . ":host=" . func_get_arg(1);
			
			//Checks if port is set
			$tmp_port = func_get_arg(5);
			if(isset($tmp_port)){
				if($tmp_port != null){
					$dns .= ";port=" . $tmp_port;
				}
			}
			
			//Preps DNS information
			if(!CONNECT_WITHOUT_DB_NAME){
				$dns .= ';dbname=' . func_get_arg(4);
				if(func_get_arg(0) != "pgsql"){
					 $dns .= ';charset=utf8';
				}
			}
			
			//Starts connection
			$this->pdoConnection = new PDO($dns, func_get_arg(2), func_get_arg(3));
			if(DEBUG) $log->add("Connection made to server");
			
			//Sets attributes for later use and/or safety
			$this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->pdoConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			if(DEBUG) $log->add("Connection attributes changed");
			
			try{
				
				if(CONNECT_WITHOUT_DB_NAME){
					//Creates Database if it doesn't exist
					$sqlStatement = "CREATE DATABASE IF NOT EXISTS " . func_get_arg(4);
					$this->pdoConnection->exec($sqlStatement);
					if(DEBUG) $log->add("Created database if it didn't exist");
					
					//Ends connection
					$this->pdoConnection = null;
					if(DEBUG) $log->add("Connection closed");
					
					//Preps DNS information
					$dns .= ';dbname=' . func_get_arg(4);
					if(func_get_arg(0) != "pgsql"){
						$dns .= ';charset=utf8';
					}
				
					//Reconnects to new/pre-existing database
					$this->pdoConnection = new PDO($dns, func_get_arg(2), func_get_arg(3));
					if(DEBUG) $log->add("Connection made to database");
					
					//Sets attributes for later use and/or safety
					$this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$this->pdoConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				}
				
				if(DEBUG) $log->add("Connection attributes changed");
				
			}catch(PDOException $ex){
				//Prints exception
				if(DEBUG) $log->add($ex->getMessage());		
			}	
			//Displays log message
			if(DEBUG){
				$log->display();
				$log = null;
			}
		}
		
		public function query($sqlStatement, $arguments = null){
			//Initialize debug
			if(DEBUG){
				$log = new Log("pdoConnection::query");
				$log->setParameters("sqlStatement","arguments");
				for($i = 0; $i < func_num_args();$i++){
					$log->setArguments(func_get_arg($i));
				}
			}
			try{
				//Prepares statement
				$cleanPDO = $this->pdoConnection->prepare($sqlStatement);
				if(DEBUG) $log->add("Prepared SQL statement");
				
				//Runs statement replacing arguments
				$cleanPDO->execute($arguments);
				if(DEBUG) $log->add("Executed statement with arguments");
				
				//Collects results
				$result = $cleanPDO->fetchAll();
				if(DEBUG) $log->add("Retrieved results","-----",$result,"-----");
				
				//Destroys cleanPDO
				$cleanPDO = null;
				
				//Replaces result with id of last value
				if(count($result)<1){
					$result = $this->pdoConnection->lastInsertId();
					if(DEBUG) $log->add("Replaced result with ID");
				}
				
				//Displays log message
				if(DEBUG){
					$log->display();
					$log = null;
				}
				
				return $result;
				
			}catch(PDOException $ex){
				//Exception
				if(DEBUG){
					switch($this->errorCode()){
						case "42S02":	//no table
							$log->add("Table not found");
							break;
						default:
							//Unexpected error
							$log->add($ex);
							break;
					}
				}
				
				//Displays log message
				if(DEBUG){
					$log->display();
					$log = null;
				}
				
				return null;
			}
		}
		
		//Closes the pdo connection
		public function close(){
			//Initialize debug
			if(DEBUG){
				$log = new Log("pdoConnection::close");
			}
			
			//Close the Connections
			$this->pdoConnection = null;
			if(DEBUG) $log->add("Connection closed");
			
			//Displays log message
			if(DEBUG){
				$log->display();
				$log = null;
			}
		}
		
		public function errorInfo(){
			return $this->pdoConnection->errorInfo();
		}
		public function errorCode(){
			return $this->pdoConnection->errorCode();
		}
	}
?>
