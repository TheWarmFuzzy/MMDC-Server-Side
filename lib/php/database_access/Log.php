<?php

	//namespace JT_Nelson;
	
	class Log{
		private $logFunctionName = "";
		private $logParameters = array();
		private $logArguments = array();
		private $logContents = array();
		public function __construct($name){
			$this->logFunctionName = $name;
		}
		public function setParameters(){
			for($i = 0; $i < func_num_args();$i++){
				array_push($this->logParameters, func_get_arg($i));
			}
		}
		public function setArguments(){
			for($i = 0; $i < func_num_args();$i++){
				array_push($this->logArguments, func_get_arg($i));
			}
		}
		public function add(){
			for($i = 0; $i < func_num_args();$i++){
				array_push($this->logContents, func_get_arg($i));
			}
		}
		public function display(){
?>
	<div class = "">
		<div class = "">
<?php 
			echo $this->logFunctionName . "(";
			$paramCount = count($this->logParameters);
			if($paramCount > 0){
				echo $this->logParameters[0];
				for($i = 1; $i < $paramCount; $i++){
					echo ", " . $this->logParameters[$i];
				}
			}
?>){
			<div class = "">
			Arguments:
			<br/>
<?php
				for($i = 0; $i < count($this->logArguments); $i++){
					try{
						echo $this->logParameters[$i] . ": ";
						print_r($this->logArguments[$i]);
						echo "<br/>";
					}catch(Exception $e){
					
					}
					
				}
?>
			<br/>
			Additional logs:
			<br/>
<?php
			foreach($this->logContents as $value){
				print_r($value);
				echo "<br/>";
			}
?>
			</div>
			}
		</div>
		
	</div>
<?php
		}
	}
?>