{
	"TEAMS":{
		"NAME":"teams",
		"DESCRIPTION":
			"Contains team information.",
		"COLUMNS":{
			"ID":{
				"NAME":"id",
				"TYPE":"SERIAL",
				"KEY":"PRIMARY"
			},
			"TEAM_NAME":{
				"NAME":"tm_name",
				"TYPE":"VARCHAR",
				"SIZE":64
			},
			"CHOREOGRAPHERS":{
				"NAME":"choreo",
				"TYPE":"VARCHAR",
				"SIZE":64
			},
			"SONG_NAME":{
				"NAME":"sg_name",
				"TYPE":"VARCHAR",
				"SIZE":2048
			},
			"SONG_ENTRANCE":{
				"NAME":"sg_entr",
				"TYPE":"VARCHAR",
				"SIZE":32
			},
			"SCHOOL_NAME":{
				"NAME":"s_name",
				"TYPE":"VARCHAR",
				"SIZE":64
			},
			"SCHOOL_ADDRESS":{
				"NAME":"s_addr",
				"TYPE":"VARCHAR",
				"SIZE":128
			},
			"SCHOOL_CITY":{
				"NAME":"s_city",
				"TYPE":"VARCHAR",
				"SIZE":32
			},
			"SCHOOL_PROVINCE":{
				"NAME":"s_prov",
				"TYPE":"VARCHAR",
				"SIZE":16
			},
			"SCHOOL_POSTALCODE":{
				"NAME":"s_pc",
				"TYPE":"VARCHAR",
				"SIZE":8
			},
			"SCHOOL_PHONE":{
				"NAME":"s_phone",
				"TYPE":"VARCHAR",
				"SIZE":16
			},
			"SCHOOL_FAX":{
				"NAME":"s_fax",
				"TYPE":"VARCHAR",
				"SIZE":32
			},
			"REP_NAME":{
				"NAME":"r_name",
				"TYPE":"VARCHAR",
				"SIZE":32
			},
			"REP_TITLE":{
				"NAME":"r_title",
				"TYPE":"VARCHAR",
				"SIZE":16
			},
			"REP_EMAIL":{
				"NAME":"r_email",
				"TYPE":"VARCHAR",
				"SIZE":64
			},
			"REP_DAYPHONE":{
				"NAME":"r_dphone",
				"TYPE":"VARCHAR",
				"SIZE":16
			},
			"REP_NIGHTPHONE":{
				"NAME":"r_nphone",
				"TYPE":"VARCHAR",
				"SIZE":16
			},
			"PAID":{
				"NAME":"paid",
				"TYPE":"BOOLEAN"
			},
			"SUBTOTAL":{
				"NAME":"sub_total",
				"TYPE":"DOUBLE",
				"SIZE":"6,2"
			}
		}
	},
	"DANCERS":{
		"NAME":"dancers",
		"DESCRIPTION":
			"Contains dancer information.",
		"COLUMNS":{
			"ID":{
				"NAME":"id",
				"TYPE":"SERIAL",
				"KEY":"PRIMARY"
			},
			"TEAM_ID":{
				"NAME":"teamid",
				"TYPE":"INT"
			},
			"FIRSTNAME":{
				"NAME":"firstname",
				"TYPE":"VARCHAR",
				"SIZE":64
			},
			"LASTNAME":{
				"NAME":"lastname",
				"TYPE":"VARCHAR",
				"SIZE":64
			},
			"AGE":{
				"NAME":"age",
				"TYPE":"INT"
			},
			"SHIRTSIZE":{
				"NAME":"shirtsize",
				"TYPE":"VARCHAR",
				"SIZE":32
			}
		}
	}
}