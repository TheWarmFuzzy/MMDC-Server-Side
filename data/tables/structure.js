{
	"TEAMS":{
		"TABLE":"TEAMS",
		"ARRAY":true,
		"SCHOOL":{
			"TABLE":"SCHOOLS",
			"REPRESENTATIVE":{
				"TABLE":"REPRESENTATIVES"
			}
		},
		"CHOREOGRAPHER":{
			"TABLE":"REPRESENTATIVES"
		},
		"DANCERS":{
			"TABLE":"DANCERS",
			"ARRAY":true,
			"TEAM":"PARENT"
		},
		"ROUTINES":{
			"TABLE":"ROUTINES",
			"ARRAY":true,
			"TEAM":"PARENT"
		}
	}
}