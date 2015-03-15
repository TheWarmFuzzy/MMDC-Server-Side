<html>
	<head>
	
	</head>
	<body>
		<?php
			$ROOT = dirname(__FILE__);
			require_once($ROOT.'/lib/php/Constants.php');
			require_once($ROOT.'/lib/php/database_access/SQLServerCredentials.php');
			require_once($ROOT.'/lib/php/database_access/Log.php');
			require_once($ROOT.'/lib/php/database_access/PDOConnection.php');
			require_once($ROOT.'/lib/php/database_access/SQLControls.php');
			require_once($ROOT.'/lib/php/database_access/TableReader.php');
			
			
			use \JT_Nelson as JN;
			
			$Table_List = JN\TableReader::get_tables("table_list.js");
			$Structure = JN\TableReader::get_tables("structure-a.js");
			$Populate_List = JN\TableReader::get_tables("populate_data-a.js");

			
			/*JN\SQLControls::create_table($Table_List["SCHOOLS"]);
			JN\SQLControls::create_table($Table_List["REPRESENTATIVES"]);
			JN\SQLControls::create_table($Table_List["TEAMS"]);
			JN\SQLControls::create_table($Table_List["DANCERS"]);
			JN\SQLControls::create_table($Table_List["ROUTINES"]);*/
			/*foreach($Table_List as $t){
				JN\SQLControls::create_table($t);
			}*/
			
			$filter["ID"] = 2;
			$data["NAME"] = "Mine";
			$data["PAID"] = 1;
			$data["EARLY_BI"] = "DA FUCK";
			echo JN\SQLControls::modify($filter,$data,$Table_List["TEAMS"]);
			
		?>
	</body>
</html>