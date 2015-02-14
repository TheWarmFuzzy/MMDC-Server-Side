{
	"ALLOW_TABLE_CREATION":{
		"VALUE":true,
		"RECOMMENDED_VALUE":false,
		"EXPECTED_TYPE":"boolean",
		"DESCRIPTION":
			"Allows the creation of database tables."
	},
	
	"ALLOW_AUTO_TABLE_CREATION":{
		"VALUE":true,
		"RECOMMENDED_VALUE":false,
		"EXPECTED_TYPE":"boolean",
		"DESCRIPTION":
			"Allows the creation of multiple tables at the same time. Used to create the database."
	},
	
	"ALLOW_TABLE_DROP":{
		"VALUE":true,
		"RECOMMENDED_VALUE":false,
		"EXPECTED_TYPE":"boolean",
		"DESCRIPTION":
			"Allows the deletion of database tables."
	},
	
	"ALLOW_AUTO_TABLE_DROP":{
		"VALUE":true,
		"RECOMMENDED_VALUE":false,
		"EXPECTED_TYPE":"boolean",
		"DESCRIPTION":
			"Allows the deletion of multiple tables at the same time. Used during testing."
	},
	
	"ALLOW_TABLE_POPULATE":{
		"VALUE":false,
		"RECOMMENDED_VALUE":false,
		"EXPECTED_TYPE":"boolean",
		"DESCRIPTION":
			"Allows for tables to be filled with test data."
	},
	
	"EMAIL_AS_LOGIN":{
		"VALUE":true,
		"EXPECTED_TYPE":"boolean",
		"DESCRIPTION":
			"If email counts as the user name."
	},
	
	"LOGIN_REDIRECT_LOCATION":{
		"SUCCESS":{
			"VALUE":"index.php",
			"EXPECTED_TYPE":"string",
			"DESCRIPTION":
				"On login go here."
		},
		"FAILURE":{
			"VALUE":"login_passive.php",
			"EXPECTED_TYPE":"string",
			"DESCRIPTION":
				"On login rejection go here."
		}
	},
	
	"CREATION_REDIRECT_LOCATION":{
		"SUCCESS":{
			"VALUE":"index.php",
			"EXPECTED_TYPE":"string",
			"DESCRIPTION":
				"When user is created, go here."
		},
		"FAILURE":{
			"VALUE":"DEMO_create_user.php",
			"EXPECTED_TYPE":"string",
			"DESCRIPTION":
				"When user creation fails, go here."
		}
	},
	
	"DEBUG":{
		"VALUE":false,
		"RECOMMENDED_VALUE":false,
		"EXPECTED_TYPE":"boolean",
		"DESCRIPTION":
			"Causes debug data to be displayed on screen."
	},
	
	"DEBUG_DUMP":{
		"VALUE":false,
		"RECOMMENDED_VALUE":false,
		"EXPECTED_TYPE":"boolean",
		"DESCRIPTION":
			"Causes select variables to be displayed on screen."
	}
}