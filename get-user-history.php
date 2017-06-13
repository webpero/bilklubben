<?php
	/* Hent ut alle historiske bilreservasjoner for pålogget bruker	(nyeste først)
	 *
	 *	GET-USER-HISTORY	(GET)
	 *
	 *  RETURNS
	 *		JSON [{...}, {...}]	
	 *		Alle data om alle historiske reservasjoner gjort av bruker		
	 */	

	 /***** PHP-Konstanter *****/
	include "consts.php"; 

	if ( isset($_SESSION['userid']) )
	{
		//Tilkobling til database
		$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
		if ( $con )
		{
			$userid = $_SESSION['userid'];
			$date = date("Y-m-d");
			$sql = "SELECT * FROM car_inuse WHERE user_id='$userid' AND date < '$date' ORDER BY date DESC LIMIT 1000";
			$res = mysqli_query($con, $sql); 
			if ( $res )
			{
				$res_array = array();
				while ( $row = mysqli_fetch_assoc($res) ) { 
					$res_array[] = $row;
				} 
				echo json_encode($res_array);
			}
			mysqli_close($con);		
		}	
		else
		{
			echo ERROR_."Databasefeil: Kan ikke koble til database"._ERROR;
		}
	}
	else
	{
		echo ERROR_."Ingen gyldig brukersesjon!"._ERROR;
	}
?>