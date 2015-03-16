<html>
	<head>
		<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
	</head>
	<body>
		<?php
			
			/*$ROOT = dirname(__FILE__);
			require_once($ROOT.'/lib/php/Constants.php');
			require_once($ROOT.'/lib/php/database_access/SQLServerCredentials.php');
			require_once($ROOT.'/lib/php/database_access/Log.php');
			require_once($ROOT.'/lib/php/database_access/PDOConnection.php');
			require_once($ROOT.'/lib/php/database_access/SQLControls.php');
			require_once($ROOT.'/lib/php/database_access/TableReader.php');
			
			
			use \JT_Nelson as JN;
			
			$Table_List = JN\TableReader::get_tables("table_list-a.js");
			//$Structure = JN\TableReader::get_tables("structure-a.js");
			//$Populate_List = JN\TableReader::get_tables("populate_data-a.js");

			foreach($Table_List as $t){
				JN\SQLControls::create_table($t);
			}*/
			
			/*$filter["ID"] = 2;
			$data["NAME"] = "Mine";
			$data["PAID"] = 1;
			$data["EARLY_BI"] = "DA FUCK";
			echo JN\SQLControls::modify($filter,$data,$Table_List["TEAMS"]);*/
			
		?>
		
		<script type="text/javascript">
			var my_table = null;
			var my_data = null;
			var my_structure = null;
			$(document).ready(function() {
				
				$("#doStuff").click(function(event){
					console.log("Button press");
					$.ajax({
						url:"data/tables/modify_data-a.js",
						dataType:"text",
						success:getTable,
						error:fail
					});
					
				});
			});
			function fail(a,b,c){
				console.log(c);
			}
			
			function getTable(data){
				$('#data').html(data);
				my_data = data;
				$.ajax({
					url:"data/tables/table_list-a.js",
					dataType:"text",
					success:getStructure,
					error:fail
				});
				
			}
			
			function getStructure(data){
				my_table = data;
				$('#table').html(data);
				$.ajax({
					url:"lib/php/SERVER_REQUEST_STRUCTURE.php",
					data:{
						target:"dancer"
					},
					success:thingsandstuff,
					error:fail
				});
			}
			function thingsandstuff(data){
				my_structure = data;
				$('#structure').html(data);
				$.ajax({
					type:"POST",
					url:"lib/php/SERVER_INPUT_MODIFY.php",
					data:{
					input:my_data,structure:my_structure},
					success:input,
					error:fail
				});
			}
			
			function input(data){
				$('#result').html(data);
			}
		</script>
		<button id="doStuff">Press me</button>
		<div id="data" style="border: 1px solid #000;"></div>
		<div id="table" style="border: 1px solid #000;"></div>
		<div id="structure" style="border: 1px solid #000;"></div>
		<div id="result" style="border: 1px solid #000;"></div>
	</body>
</html>