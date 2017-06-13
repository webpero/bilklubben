<!DOCTYPE html>
<?php 
	/***** PHP-Konstanter *****/
	include "consts.php"; 
?>
<html lang="no">

<head>
	<title>Bilklubben - Finn bil</title>
<?php 
	/***** Header: CSS og Javascript *****/
	include "head.php"; 
?>
</head>

<body>
<?php 
	/***** Meny *****/
	include "navbar.php";
?>
	
	<!-- MAIN CONTENT -->
	<div class="container margin-top">
<?php 
	if ( !isset($_SESSION['userid']) )
	{
		/***** IKKE logget inn *****/
?>	
		<!-- Innsalg av tjenesten for anonyme brukere -->
		<div class="jumbotron">
		  <div class="container">
			<h1>Du må være medlem</h1>
			<p>For å finne en bil for lån, må du være medlem av Bilklubben.</p>
			<p>
				<a data-toggle='modal' data-target='#loginModal' class='btn btn-primary btn-lg'><span class='glyphicon glyphicon-user'></span> Logg inn</a>
				<a class="btn btn-primary btn-lg" href="medlem.php" role="button">Bli med i dag&nbsp;&nbsp;<span class='glyphicon glyphicon-road' aria-hidden='true'></span></a>
			</p>
		  </div>
		</div>
<?php
 	}
	else
	{
		/***** Innlogget bruker *****/
		include "brukerinfo.php";
?>
		<!-- Vis ledige biler framover -->
		<div class="well">
			<h2><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> Ledige biler framover</h2>
			<h4>Klikk én gang for å starte en periode, klikk én gang til på samme rad for å avslutte en periode</h4>
		</div>
		<table class="table table-condensed table-responsive" id="caravail">
		</table>
<?php
		/***** Slutt innlogget bruker *****/
	}
?>		
	
	</div>		<!-- END: .container -->
		
	<!------------- Modale dialoger ------------------>
<?php
	/***** Innlogging *****/
	include "modal-login.php";
	include "modal-leiebil.php";	

	/***** Informasjon om en bil *****/
	include "modal-bilinfo.php";
	
	/***** Footer og Javascript for init av side *****/
	include "tail.php";
?>
	<!-- Init av siden -->
	<script>
		$(function(){
			initPage();
<?php 
	if ( isset($_SESSION['userid']) )
	{
		/***** Pålogget bruker *****/
?>	
			initCarAvail();
			initCarBooking();		
<?php
		/***** Slutt pålogget bruker *****/
	}
?>			
		});
	</script>

</body>
</html>