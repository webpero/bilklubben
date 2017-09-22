<!DOCTYPE html>
<?php 
	/***** PHP-Konstanter *****/
	include "consts.php"; 
?>
<html lang="no">

<head>
	<title>Bilklubben - Veien til et enklere billiv</title>
<?php 
	/***** Header: CSS og Javascript *****/
	include "head.php"; 
?>
</head>

<body>
<?php 
	/***** Meny (Bootstrap navbar) *****/
	include "navbar.php";
?>
	
	<!-- MAIN CONTENT -->
	<div class="container-fluid margin-top">
<?php 
	/***** IKKE logget inn *****/
	if ( !isset($_SESSION['userid']) )
	{
?>	
		<!-- Innsalg av tjenesten for anonyme brukere -->
		<div class="jumbotron">
		  <div class="container">
			<h1>Bli med i Bilklubben!</h1>
			<p>Gjør veien til et enklere bil-liv så kort som mulig.</p>
			<p><a class="btn btn-primary btn-lg" href="medlem.php" role="button">Bli med i dag&nbsp;&nbsp;<span class='glyphicon glyphicon-road' aria-hidden='true'></span></a></p>
		  </div>
		</div>
<?php 
	}
?>		
		<div class="row">
			<!-- COL1: Kart med biler -->
			<div class="col-lg-7">
				<h2>Ledige biler i
					<select>
						<option value="Stavanger" selected>Stavanger</option>
						<option value="Oslo">Oslo (kommer)</option>
						<option value="Bergen">Bergen (kommer)</option>						
						<option value="Trondheim">Trondheim (kommer)</option>						
					</select>
					<span class="right"><a class="btn btn-primary btn-lg" href="finn.php" role="button">Finn bil fram i tid&nbsp;&nbsp;<span class='glyphicon glyphicon-calendar' aria-hidden='true'></span></a></span>
				</h2>
				<p>Klikk på ikonet til en bil for å leie denne i dag (hvis ingen vises, er alle biler opptatt)</p>
				<div id="map">
				</div>
			</div>
			
			<!-- COL2: Liste med biler -->
			<div class="col-lg-5">
				<h2>Våre biler i Stavanger</h2>
				<p>Klikk på kolonneoverskriftene for å sortere (stigende/synkende)<br/>
				Klikk på en rad for mer informasjon om aktuell bil</p>
				<table class="table table-striped table-condensed table-responsive tablesorter" id="cartable">
					<thead>
						<tr>
							<th title="Klikk for sortering">Type</th>
							<th title="Klikk for sortering">Merke (årsmodell)</th>
							<th title="Klikk for sortering">Seter</th>
							<th title="Klikk for sortering" class='text-right'>Last<br/>(liter)</th>
							<th title="Klikk for sortering" class='text-right'>Kost/døgn<br/>(poeng)</th>
							<th title="Klikk for sortering" class='text-right'>Bil #</th>
						</tr>
					</thead>
					<tbody>
	<?php
	/*** List ut tilgjengelige biler ***/
	$con = mysqli_connect(DB[0], DB[1], DB[2], DB[3]);    
	if ( $con )
	{
		$sql = "SELECT * FROM car_cars";
		$res = mysqli_query($con, $sql); 
		
		if ( $res )
		{
			while ( $rad = mysqli_fetch_array($res) ) { 
				$id = $rad['id'];
				$bilmerke = $rad['maker'];
				$bilmodell = $rad['model'];
				$bilpass = $rad['num_pass'];
				$billast = $rad['capasity'];
				$bilaarsmodell = $rad['model_year'];
				$biltype = $rad['model_type'];
				$bilkost = $rad['cost'];
				echo "<tr data-id='$id'>\n";
				echo "<td><span data-type='$biltype' class='glyphicon glyphicon-map-marker' aria-hidden='true'></span>&nbsp;$biltype</td>\n";
				echo "<td>$bilmerke $bilmodell ($bilaarsmodell)</td>\n";
				echo "<td class='text-center'>$bilpass</td>\n";
				echo "<td class='text-right'>$billast</td>\n";
				echo "<td class='text-right'>$bilkost</td>\n";
				echo "<td class='text-right'>$id</td>\n";
				echo "</a></tr>\n";
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
					</tbody>
				</table>		
				<!-- END: #cartable -->
				
				<h2>Hvem er vi?</h2>
				<p>
					<a class="btn btn-primary btn-lg" href="siste.php" role="button">Siste nytt&nbsp;&nbsp;<span class='glyphicon glyphicon-comment' aria-hidden='true'></span></a>&nbsp;&nbsp;&nbsp;
					<a class="btn btn-primary btn-lg" href="om.php" role="button">Om Bilklubben&nbsp;&nbsp;<span class='glyphicon glyphicon-leaf' aria-hidden='true'></span></a>
				</p>
				
			</div>		<!-- END: COL2 -->

		</div>  	<!-- END: .row -->
	</div>		<!-- END: .container-fluid -->
		
	<!------------- Modale dialoger ------------------>
<?php
	/***** Modal-dialoger for innlogging og bestilling *****/
	include "modal-login.php";
	include "modal-leiebil.php";	

	/***** Informasjon om en bil *****/
	include "modal-bilinfo.php";

	/***** Footer og Javascript *****/
	include "tail.php";
?>
	<!-- Init av siden -->
	
	<!-- Google Maps JavaScript API - API-key er generert fra kraftwerk68@gmail.com -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL58Of35Vjc2CeUAbSPXc1zd1ugUmYL4Q&callback=initMap">
		//Kaller initMap() som callback
	</script>
	<script>
		$(function(){
			initPage();
			initCars();
<?php 
	if ( isset($_SESSION['userid']) )
	{
		/***** Pålogget bruker *****/
?>	
			initCarBooking();		
<?php
		/***** Slutt pålogget bruker *****/
	}
?>			
		});
	</script>
</body>
</html>
