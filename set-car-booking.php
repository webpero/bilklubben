<?php
	/*	Legg inn reservasjon på angitt bil for angitt periode (hvis mulig) 	
	 *
	 *	SET-CAR-BOOKING	(POST)
	 * 		id*		Bildes id 
	 *		date	Første dato i reservasjonsperioden
	 *		days 	Antall dager i reservasjonsperioden
	 *		cost*	Total kostnad for hele reservasjonen  
					MERKNAD: Dette må endres til at tjenesten slår opp kostnaden per dag basert på antall dager og type dag, multiplisert med faktor fra oppslag i car_price
	 *  RETURNS
	 *		JSON [{"date":"date1"}, {...} ]		Liste av reservasjonsdatoer
	 */	
	 
	/***** PHP-Konstanter *****/
	include "consts.php"; 

	if ( isset($_SESSION['userid']) )
	{
		$userid = $_SESSION['userid'];
		// Sjekk bilens id
		if ( isset( $_POST['id'] ) && isset( $_POST['cost'] ) ) 
		{
			// Sett startdato 
			if ( isset( $_POST['date'] ) ) {
				$start_date = $_POST['date'];
			} else {
				$start_date = date("Y-m-d");
			}
			// Sett antall dager
			if ( isset( $_POST['days'] ) ) {
				$days = $_POST['days'];
			} else {
				$days = 1;
			}	
			//Tilkobling til database
			$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
			if ( $con )
			{
				//Henter ut data, fjerner forsøk på XSS og SQL-injection
				$id = mysqli_real_escape_string( $con, htmlentities($_POST['id'], ENT_QUOTES) );
				$cost = mysqli_real_escape_string( $con, htmlentities($_POST['cost'], ENT_QUOTES) );
				$stop_date = date('Y-m-d', strtotime($start_date . " +$days day"));

				//Sjekk om det finnes reservasjoner på aktuell bil i aktuell periode
				$sql = "SELECT car_id FROM car_inuse WHERE date >= '$start_date' AND date < '$stop_date' AND car_id = '$id'";
				$res = mysqli_query($con, $sql); 
				if ( $res && mysqli_fetch_assoc($res))
				{
					//Bilen er allerede reservert, returner feilmelding
					echo ERROR_."Bilen var allerede reservert minst en av dagene!"._ERROR;
				}
				else
				{
					//Ingen treff betyr at bilen er ikke reservert i perioden, opprett reservasjon(er)
					$return = "";
					for ( $i=0; $i<$days; $i++ )
					{
						$date = date('Y-m-d', strtotime($start_date . " +$i day"));
						$sql = "INSERT INTO car_inuse";
						$sql .= " (date, car_id, user_id)";
						$sql .= " VALUES ";
						$sql .= " ('{$date}', '{$id}', '{$userid}')";
						$res = mysqli_query($con,$sql); 
						if ( $res )	{
							//Legg til datoen i JSON retur-streng
							$return .= '{"date":"'.$date.'"},';
						}
					}
					//Trekk fra kostnaden på brukers saldo
					//MERKNAD: Dette må endres til å bli beregnet for hver enkelt dag basert på informasjon i car_price og hva slags dag det er 
					$sql = "SELECT userbalance FROM car_users WHERE userid = '$userid'";
					$res = mysqli_query($con, $sql); 
					if ( $res )
					{
						$rad = mysqli_fetch_array($res);
						if ( $rad )  
						{
							$saldo = $rad['userbalance'];
							$saldo = $saldo - $cost;
							if ( $saldo >= 0 )
							{
								$sql = "UPDATE car_users SET userbalance = '$saldo' WHERE userid = '$userid'";
								$res = mysqli_query($con, $sql); 
								if ( $res )
								{
								}
							}
						}
					}
					
					//Returner datoer bilen er booket som bekreftelse (JSON-tabell)
					echo "[".rtrim("$return",",")."]";
				}
				//Lukk databasetilkoblingen
				mysqli_close($con);
			}
			else
			{
				echo ERROR_."Databasefeil: Kan ikke koble til database"._ERROR;
			}
		}
		else
		{
			echo ERROR_."Må sende med bilens id + kostnad!"._ERROR;
		}
	}
	else
	{
		echo ERROR_."Ingen gyldig brukersesjon!"._ERROR;
	}
?>