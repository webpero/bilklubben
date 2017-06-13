<?php 
	//Sesjonshåndtering på
	session_start();
	
	//Konstanter for Databaseoppkobling (host, userid, password, database)
	const DB = array("mysql.stud.iie.ntnu.no", "peroma", "dJf8skcp", "peroma");
	
	//Konstanter for visning av feilmeldinger
	const ERROR_ = "ERROR: [";
	const _ERROR = "]";

	//Home-URL for prosjektet
	const HOME_URL = "https://stud.iie.ntnu.no/~peroma/wtr/prosjekt/index.php";
?>