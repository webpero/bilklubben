<?php 
		/*** Hent pålogget brukers poengsaldo ***/
		$username = $_SESSION['username'];
		$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
		if ( $con )
		{
			$sql = "SELECT * FROM car_users WHERE username = '$username'";
			$res = mysqli_query($con, $sql); 
			if ( $res )
			{
				$rad = mysqli_fetch_array($res);
				if ( $rad )  
				{
					$saldo = $rad['userbalance'];
					$name = $_SESSION['name'];
					echo "<h1>$name<span class='header-right'><small>Poengsaldo: $saldo</small>&nbsp;<a href='logout.php' role='button' class='btn btn-primary'><span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp;&nbsp;Logg ut</a></span></h1>";
				}
			}
			else
			{
				echo ERROR_."Databasefeil[".mysqli_errno($con)."]: ".mysqli_error($con)._ERROR;
			}
		}
		else
		{
			echo ERROR_."Databasefeil: Kan ikke koble til database"._ERROR;
		}
?>
