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
			
			$Table_List = TableReader::get_tables("table_list.js");
			
			SQLControls::create_table($Table_List["SCHOOLS"]);
			SQLControls::create_table($Table_List["REPRESENTATIVES"]);
			SQLControls::create_table($Table_List["TEAMS"]);
			SQLControls::create_table($Table_List["DANCERS"]);
			SQLControls::create_table($Table_List["ROUTINES"]);
		?>
	</body>
</html>