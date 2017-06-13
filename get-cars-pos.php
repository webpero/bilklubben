<?php
	/*  Hent alle tilgjengelige bilers posisjon (lat,lng) 	
	 *	Hvis en bil ikke er tilgengelig, settes NULL som verdi for lat og lng
	 *		
	 *	GET-CARS-POS (GET)
	 *		
	 *  RETURNS
	 *		JSON [ {"car_id":"car_id1", "car_lat":"lat_car1", "car_lng":"lng_car1"}, {...} ]	
	 *				Bilposisjons-objekter, null i lat og lng hvis bilen er reservert
	 */	

	 /***** PHP-Konstanter *****/
	include "consts.php"; 	
	
	$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
	if ( $con )
	{
		$sql = "SELECT * FROM car_position ORDER BY car_id";
		$res = mysqli_query($con, $sql); 

		if ( $res )
		{
			$today = date("Y-m-d");
			$res_array = array();
			while ( $row = mysqli_fetch_assoc($res) ) {
				//Legg bilen i array
				$res_array[] = $row;					
				//Må sjekke om aktuell bil er reservert i dag
				$carid = $row['car_id'];
				$sql = "SELECT car_id FROM car_inuse WHERE date = '$today' AND car_id = '$carid'";
				$res2 = mysqli_query($con, $sql); 
				if ( $res2 && mysqli_fetch_assoc($res2) ) 
				{
					//Bilen er resrevert, legg tom posisjon for bilen i retur-array
					$i = count($res_array)-1;
					$res_array[$i]['car_lng'] = null;
					$res_array[$i]['car_lat'] = null;
				} 
			} 
			echo json_encode($res_array);
		}
		mysqli_close($con);
	}
?>