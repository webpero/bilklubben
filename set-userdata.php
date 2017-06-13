<?php
	/*	Hvis ingen brukersesjon: Opprett ny bruker, ellers: Oppdater brukerdata 	
	 *
	 *	SET-USER-DATA (POST)
	 *		navn*			Navn
	 *		adresse			Adresse
	 *		postnr*			Postnr
	 *		poststed*		Poststed
	 * 		mobil*			Mobiltelefonnr
	 *		epost*			E-postadresse 
	 *		poeng*			Avtalt månedlig innskudd
	 *		owner*			Navn på kredittkort
	 *		cardnumber*		Kredittkortnummer
	 *		expmonth*		Utløpsdato: måned
	 *		expyear*		Utløpsdato: år
	 *		username		Brukernavn (* hvis ny bruker)
	 *		password 		Brukers passord (* hvis ny bruker)
	 *		redirect_user	URL som skal kalles hvis OK
	 *
	 *  RETURNS
	 *		Feilmelding ELLER redirect til redirect-URL
	 */	
	 
	/***** PHP-Konstanter *****/
	include "consts.php"; 
	
	//Tilkobling til database
	$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
	if ( $con )
	{
		//Sjekk at alle påkrevde data finnes
		if 	( 	isset($_POST['navn']) && isset($_POST['postnr']) && isset($_POST['poststed']) && 
				isset($_POST['mobil']) && isset($_POST['epost']) && isset($_POST['poeng']) &&
				isset($_POST['owner']) && isset($_POST['cardnumber']) && isset($_POST['expmonth']) && isset($_POST['expyear'])
			)
		{
			//Henter ut data, fjerner forsøk på XSS og SQL-injection
			$name =  mysqli_real_escape_string( $con, htmlentities($_POST['navn'],ENT_QUOTES) );
			$address = mysqli_real_escape_string( $con, htmlentities($_POST['adresse'],ENT_QUOTES) );
			$zip = mysqli_real_escape_string( $con, htmlentities($_POST['postnr'],ENT_QUOTES) );		
			$city = mysqli_real_escape_string( $con, htmlentities($_POST['poststed'],ENT_QUOTES) );
			$mobile = mysqli_real_escape_string( $con, htmlentities($_POST['mobil'],ENT_QUOTES) );
			$mail = mysqli_real_escape_string( $con, htmlentities($_POST['epost'],ENT_QUOTES) );
			$monbalance = mysqli_real_escape_string( $con, htmlentities($_POST['poeng'],ENT_QUOTES) );
			$card_owner = mysqli_real_escape_string( $con, htmlentities($_POST['owner'],ENT_QUOTES) );
			$card_number = mysqli_real_escape_string( $con, htmlentities($_POST['cardnumber'],ENT_QUOTES) );
			$card_expmonth = mysqli_real_escape_string( $con, htmlentities($_POST['expmonth'],ENT_QUOTES) );
			$card_expyear = mysqli_real_escape_string( $con, htmlentities($_POST['expyear'],ENT_QUOTES) );
			if ( isset($_POST['username']) && $_POST['username'] != "" ) {
				//Brukernavn er sendt med, opprett variabel
				$username = mysqli_real_escape_string( $con, htmlentities($_POST['username'],ENT_QUOTES) );
			}
			if ( isset($_POST['password']) && $_POST['password'] != "" ) {
				//Passord er sendt med, opprett variabel
				$userpass = mysqli_real_escape_string( $con, htmlentities($_POST['password'],ENT_QUOTES) );
			}
			if ( isset($_POST['redirect_user']) && $_POST['redirect_user'] != "" ) {
				$redir = mysqli_real_escape_string( $con, htmlentities($_POST['redirect_user'],ENT_QUOTES) );
			} else {
				$redir = HOME_URL;
			}
			if ( isset($_SESSION['userid']) )
			{
				/*** Brukersesjon finnes: Oppdater brukerdata ***/
				$userid = $_SESSION['userid'];
				// Bygg opp SQL-streng av felter med eller uten brukernavn og passord
				$sql = "UPDATE car_users SET ";
				$sql .= "name='{$name}', address='{$address}', zip='{$zip}', city='{$city}', mobile='{$mobile}', mail='{$mail}', monbalance='{$monbalance}', ";
				$sql .= "card_owner='{$card_owner}', card_number='{$card_number}', card_expmonth='{$card_expmonth}', card_expyear='{$card_expyear}'";
				if ( isset($username) ) {
					$sql .= ", username='{$username}'";	//Brukernavn skal oppdateres
				}
				if ( isset($userpass) ) {
					$sql .= ", userpass='{$userpass}'";	//Passord skal oppdateres
				}
				$sql .= " WHERE userid = '$userid'";
				$res = mysqli_query($con, $sql); 
				
				// Redirect tilbake til opprinnelig kallsted
				echo "<script>window.location.href = '$redir'</script>";
			}
			else
			{
				/*** Brukersesjon finnes IKKE: Opprett bruker ***/
				
				if ( isset($username) && isset($userpass) )
				{
					// Bygg opp SQL-streng av alle felter (inkludert brukernavn og passord)
					// Setter brukers saldo lik bestilt abonnement (forutsetter at betaling er gjennomført)
					$sql = "INSERT INTO car_users";
					$sql .= " (name, address, zip, city, mobile, mail, monbalance, userbalance";
					$sql .= ", card_owner, card_number, card_expmonth, card_expyear, username, userpass)";
					$sql .= " VALUES ('{$name}', '{$address}', '{$zip}', '{$city}', '{$mobile}', '{$mail}', '{$monbalance}', '{$monbalance}'";
					$sql .= ", '{$card_owner}', '{$card_number}', '{$card_expmonth}', '{$card_expyear}', '{$username}', '{$userpass}')";
					$res = mysqli_query($con,$sql); 
					if ( $res )	
					{
						// Bruker er opprettet: redirect og trigg pålogging
						echo "<script>window.location.href = '$redir?login'</script>";
					}
					else
					{
						echo ERROR_."Databasefeil: Kan ikke skrive til database"._ERROR;
					}
				}
				else
				{
					echo ERROR_."Mangler brukernavn og passord"._ERROR;
				}
			}
		}
		else
		{
			echo ERROR_."Mangler påkrevde input-data"._ERROR;		
		}
		//Lukk databasetilkoblingen
		mysqli_close($con);
	}
	else
	{
		echo ERROR_."Databasefeil: Kan ikke koble til database"._ERROR;
	}
?>