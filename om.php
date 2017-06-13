<!DOCTYPE html>
<?php 
	/***** PHP-Konstanter *****/
	include "consts.php";
?>
<html lang="no">

<head>
	<title>Bilklubben - Hvem er vi?</title>
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
	<div class="container margin-top">
<?php 
	/***** IKKE logget inn *****/
	if ( !isset($_SESSION['username']) )
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
		<!-- Rad 1: Bilde og intro-tekst -->
		<div class="row">
			<div class="col-sm-5">
				<img class="img-responsive img-rounded" src="img/teslaX.jpg" />
			</div>
			<div class="col-sm-7">
				<article>
					<h2>Om Bilklubben</h2>
					<p class="ingress">Bilklubben starter opp i Stavanger i mai 2017 og vil revulosjonere bilbruken i Norge! Bli med på eventyret som kan gi deg et enklere og billigere billiv; OG gi byene våre renere luft.</p>
					<p>Duis tellus ante, placerat tincidunt risus nec, laoreet porttitor felis. Fusce eu ante vitae lorem ornare blandit id ut tortor. Fusce non quam dui. Fusce vestibulum hendrerit tincidunt. Suspendisse pharetra massa porta, tempus mauris vel, interdum arcu. Nulla nec quam elementum, sodales magna ut, rhoncus nunc. Nulla ac lorem ac elit semper rhoncus.</p>
					<p>Integer porta felis eu ex mollis finibus. Nullam sagittis ante id velit feugiat sodales. Nam elementum finibus lacus ut condimentum. Morbi efficitur nulla porttitor, lobortis mi in, pulvinar magna. Quisque vestibulum sapien sed libero dapibus cursus.<p>
				</article>
			</div>
		</div>

		<!-- Rad 2: Kontaktinfo -->
		<div class="row" id="row2">
			<div class="col-sm-5">
				<div class="well">
					<p>
						Melde inn feil og mangler på en bil du har lånt:<br/>
						Velg <mark>Historikk</mark> på <a href="medlem.php">medlemssiden</a>
					</p>
					<p>Ved behov for veihjelp, ring NAF: <a href="tel:08505"><span class='glyphicon glyphicon-phone' aria-hidden='true'></span>08505</a></p>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-6">
						<div class="well">
							<h3>Bilklubben AS</h3>
							<address>
								<p>
									Strandkaien 1<br/>
									4005 STAVANGER
								</p>
								<p>
									<a href="tel:+4744444444"><span class='glyphicon glyphicon-phone' aria-hidden='true'></span>&nbsp;&nbsp;444 44 444</a><br/>
									<a href="mailto:post@bilklubben.no"><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>&nbsp;&nbsp;post@bilklubben.no</a>
								</p>
							</address>
						</div>
						<p>
							<a class="btn btn-primary btn-lg" href="siste.php" role="button">Siste nytt&nbsp;&nbsp;<span class='glyphicon glyphicon-comment' aria-hidden='true'></span></a>
						</p>
					</div>
					<div class="col-sm-6">
						<p>
							<a target="_blank" href="https://goo.gl/maps/KrZohQCWVUG2">
							<img class="img-responsive img-thumbnail" src="img/strandkaien.jpg" />Vis på Google Maps</a>
						<p>
					</div>
				</div>
			</div>
		</div>
		
	</div>		<!-- END: .container -->

	<!-- Modal-dialoger -->
	
<?php
	/***** Innlogging *****/
	include "modal-login.php";
?>
<?php
	/***** Footer og Javascript for init av side *****/
	include "tail.php";
?>
	<!-- Init av siden -->
	<script>
		$(function(){
			initPage();
		});
	</script>
</body>
</html>