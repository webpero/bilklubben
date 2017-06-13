<?php
	/* Hent info om pålogget bruker 	
	 *
	 * GET-USERDATA (GET)
	 *		
	 *  RETURNS
	 *		JSON [{...}, {...}]	
	 *				
	 */	

	 /***** PHP-Konstanter *****/
	include "consts.php"; 	

	if ( isset($_SESSION['userid']) && $_SESSION['userid'] != "" )
	{
		$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
		if ( $con )
		{
			$userid = $_SESSION['userid'];
			$sql = "SELECT * FROM car_users WHERE userid = '$userid'";
			$res = mysqli_query($con, $sql); 

			if ( $res )
			{
				$res_array = array();
				$row_values = mysqli_fetch_assoc($res);
				foreach( $row_values as $key => $value ) {
					$res_array[$key] = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
				} 
				echo json_encode($res_array);
			}
			mysqli_close($con);
		}
	}
?>