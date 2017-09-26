<?php 
	//Sesjonshåndtering på
	session_start();
	
	//Databaseoppkobling 
	$dbopts = parse_url(getenv('DATABASE_URL'));
	/*$app->register(new Herrera\Pdo\PdoServiceProvider(),
               array(
                   'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
                   'pdo.username' => $dbopts["user"],
                   'pdo.password' => $dbopts["pass"]
               )
	);*/
	
	//Konstanter for visning av feilmeldinger
	const ERROR_ = "ERROR: [";
	const _ERROR = "]";

	//Home-URL for prosjektet
	const HOME_URL = "https://bilklubbenas.heroku.com/index.php";
?>
