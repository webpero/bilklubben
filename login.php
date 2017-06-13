<?php 
	/*	Logg inn bruker 	
	 *
	 *	LOGIN	(POST)
	 * 		username*	 
	 *		password*	
	 * 		redirect	Redirect-URL. Returnerer hit ved gylig pålogging	
	 *  RETURNS
	 *		Feilmelding eller redirect tilbake til angitt side (HOME_URL hvis ikke redirect er angitt)
	 */
	 include "consts.php";

	//Sjekk at brukernavn og passord er fylt ut
	if ( $_POST['username'] != "" && $_POST['password'] != "" )
	{
		//Tilkobling til database
		$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
		$user = mysqli_real_escape_string($con, $_POST['username']);	
		$password = mysqli_real_escape_string($con, $_POST['password']);	

		//Hent ut passord og tilganger for aktuell bruker
		$sql = "SELECT username, userpass, name, userid FROM car_users WHERE username = '$user'";
		$res = mysqli_query($con, $sql); 
		
		if ( $res )
		{
			$rad = mysqli_fetch_assoc($res);
			if( $rad['userpass'] == $password )
			{
				// Brukers passord er godkjent, sett brukersesjon
				$_SESSION['username'] = $rad['username'];
				$_SESSION['password'] = "OK";
				$_SESSION['name'] = $rad['name'];	
				$_SESSION['userid'] = $rad['userid'];
			}
			else
			{
				echo ERROR_."Feil brukernavn/passord"._ERROR;
			}
		}
		else
		{
			echo ERROR_."Databasefeil[".mysqli_errno($con)."]: ".mysqli_error($con)._ERROR;
		}
		//Lukk databasetilkoblingen
		mysqli_close($con);
			
		if ( $res )
		{		
			/* Redirect tilbake til opprinnelig kallsted */
			if( isset($_POST['redirect']) && $_POST['redirect'] != "" ) {
				$redir = $_POST['redirect'];
			} else {
				$redir = HOME_URL;
			}
			echo "<script>window.location.href = '$redir'</script>";
		}
	}
	else
	{
		echo ERROR_."Brukernavn og passord må fylles ut!"._ERROR;
	}
?>
