<?php
	/* Hent info om alle biler 	
	 *
	 * GET-CARS (GET)
	 *		
	 *  RETURNS
	 *		JSON [{...}, {...} ]	
	 *				Bil-objekter (alle data om en bil)
	 */	

	 /***** PHP-Konstanter *****/
	include "consts.php"; 	
	
	$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
	if ( $con )
	{
		$sql = "SELECT * FROM car_cars ORDER BY model_type, maker, model";
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
?>