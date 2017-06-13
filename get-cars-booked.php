<?php
	/* Hent ut alle bilreservasjoner for angitt periode 	
	 *
	 *	GET-CARS-BOOKED	(GET)
	 *		date	Første dato i perioden
	 *		days 	Antall dager i perioden
	 *  RETURNS
	 *		JSON [{"id":"car_id", "dates":"YYYY-MM-DD, ..." }, {...} ]	
	 *				Bil-objekter med bilens id og datoer bilen er reservert
	 */	

	 /***** PHP-Konstanter *****/
	include "consts.php"; 

	if ( isset($_SESSION['userid']) )
	{
		//Tilkobling til database
		$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
		if ( $con )
		{
			// Sett startdato 
			if ( isset( $_GET['date'] ) ) {
				$start_date = mysqli_real_escape_string($con, htmlentities($_GET['date']));
			} else {
				$start_date = date("Y-m-d");
			}
			// Sett antall dager framover og stoppdato
			if ( isset( $_GET['days'] ) ) {
				$days = mysqli_real_escape_string($con, htmlentities($_GET['days']));
			} else {
				$days = 1;
			}	
			$stop_date = date('Y-m-d', strtotime($start_date . " +$days day"));
			$cars_booked = array();		//Biler [id][dato]
			$return = ""; 				//Returstreng (JSON)
			
			//Hent ut reservasjonene på alle biler for angitt periode
			$sql = "SELECT * FROM car_inuse WHERE date >= '$start_date' AND date <= '$stop_date' ORDER BY car_id, date";
			$res = mysqli_query($con, $sql); 
			if ( $res )
			{
				//Hent ut hver reservasjon og legge denne inn på aktuell bil i listen
				$last_id = 0;
				while ( $rad = mysqli_fetch_array($res) ) { 
					if ( $rad['car_id'] > $last_id ) {
						//Bil har ikke reservasjon fra før, opprett ny rad i tabellen
						$cars_booked[] = array( $rad['car_id'], $rad['date'] );
						$last_id = $rad['car_id'];
					} else {
						//Bil har reservasjon fra før, legg til en ny dato i reservasjonslisten
						$cars_booked[count($cars_booked)-1][1] .= (",".$rad['date']);
					}
				} 
				//Bygg opp returstreng (JSON)
				foreach ( $cars_booked as &$value ) {
					$return.= '{"id":"'.$value[0].'","dates":"'.$value[1].'"},';
				}
			}
			// Returner tabellen som en JSON-tabell
			echo "[".rtrim("$return",",")."]";

			//Lukk databasetilkoblingen
			mysqli_close($con);
		}	
	}
	else
	{
		echo ERROR_."Ingen gyldig brukersesjon!"._ERROR;
	}
?>