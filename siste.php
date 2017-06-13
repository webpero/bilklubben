<!DOCTYPE html>
<?php 
	/***** PHP-Konstanter *****/
	include "consts.php"; 
?>
<html lang="no">

<head>
	<title>Bilklubben - Siste nytt!</title>
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
			<p><a class="btn btn-primary btn-lg" href="medlem.php" role="button">Bli med i dag&nbsp;&nbsp;<span class='glyphicon glyphicon-road' aria-hidden='true'></a></p>
		  </div>
		</div>
<?php 
	}
?>		
		<!-- Rad 1: Hovedartikkel -->
		<div class="row article" >
			<div class="col-sm-6 col-md-5 col-lg-4">
				<img class="img-responsive img-rounded img-main" src="img/teslaX.jpg" />
			</div>
			<div class="col-sm-6 col-md-7 col-lg-8">
				<article>
					<h2>Om Bilklubben</h2>
					<p class="byline">12.05.2017 - Nils Billøs (medeier i Bilklubben AS)</p>
					<p class="ingress">Bilklubben starter opp i Stavanger i mai 2017 og vil revolusjonere bilbruken i Norge! Bli med på eventyret som kan gi deg et enklere og billigere billiv; OG gi byene våre renere luft.</p>
					<p>Nam elementum finibus lacus ut condimentum. Morbi efficitur nulla porttitor, lobortis mi in, pulvinar magna. Quisque vestibulum sapien sed libero dapibus cursus.<p>
					<p>Duis tellus ante, placerat tincidunt risus nec, laoreet porttitor felis. Fusce eu ante vitae lorem ornare blandit id ut tortor. Fusce non quam dui. Fusce vestibulum hendrerit tincidunt. Suspendisse pharetra massa porta, tempus mauris vel, interdum arcu. Nulla nec quam elementum, sodales magna ut, rhoncus nunc. Nulla ac lorem ac elit semper rhoncus.</p>
				</article>
			</div>
		</div>

		<!-- Rad 2: Artikkel 2 og 3 -->
		<div class="row article" id="row2">
			<div class="col-sm-6">
				<article>
					<h3>Alle kan ikke lenger eie sin egen bil</h3>
					<p class="byline">11.05.2017 - Oddvar Fotformsko (President i Naturvernforbundet)</p>
					<img class="img-responsive img-rounded pull-left" src="img/trafikk.jpg" />
					<p class="ingress">Privatbilismen nærmer seg sitt lenge varslede endelikt. La oss hoppe av før vi kjører utfor stupet.</p>
					<p>Sed molestie nulla nec tortor egestas scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris in fringilla ipsum. Vestibulum placerat est at ante tristique, quis ultrices turpis volutpat.<p>
					<p>Vivamus et ex augue. Sed porta in lectus vitae varius. Praesent posuere orci lacus, vel maximus mauris vehicula nec. Suspendisse sit amet auctor tortor. Proin maximus ligula at justo tempor, at rhoncus est sollicitudin. Quisque ac dui ante. Duis dapibus euismod tellus, nec tempor odio convallis mattis</p>
				</article>
			</div>
			<div class="col-sm-6">
				<article>
					<h3>Bilklubber bidrar bedre miljø</h3>
					<p class="byline">10.05.2017 - Nils-Petter Reagensrør (Professor ved NTNU Sintef Miljøforsk)</p>
					<img class="img-responsive img-rounded pull-left" src="img/eksos.jpg" />
					<p class="ingress">80% av alle biler står stille 80% av tiden. Dette er dårlig ressurs-utnyttelse og økonomisk sett en katastrofe.</p>
					<p>Integer porta felis eu ex mollis finibus. Nullam sagittis ante id velit feugiat sodales. Nam elementum finibus lacus ut condimentum. Morbi efficitur nulla porttitor, lobortis mi in, pulvinar magna. Quisque vestibulum sapien sed libero dapibus cursus.<p>
					<p>Duis tellus ante, placerat tincidunt risus nec, laoreet porttitor felis. Fusce eu ante vitae lorem ornare blandit id ut tortor. Fusce non quam dui. Fusce vestibulum hendrerit tincidunt. Suspendisse pharetra massa porta, tempus mauris vel, interdum arcu. Nulla nec quam elementum, sodales magna ut, rhoncus nunc. Nulla ac lorem ac elit semper rhoncus.<p>
					<p>Phasellus ornare neque tempus venenatis congue. In vitae rhoncus augue, dictum pharetra nisl. Sed molestie nulla nec tortor egestas scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris in fringilla ipsum. Vestibulum placerat est at ante tristique, quis ultrices turpis volutpat. Vivamus et ex augue. Sed porta in lectus vitae varius. Praesent posuere orci lacus, vel maximus mauris vehicula nec. Suspendisse sit amet auctor tortor. Proin maximus ligula at justo tempor, at rhoncus est sollicitudin. Quisque ac dui ante. Duis dapibus euismod tellus, nec tempor odio convallis mattis.</p>
				</article>
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