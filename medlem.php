<!DOCTYPE html>
<?php 
	/***** PHP-Konstanter *****/
	include "consts.php"; 
?>
<html lang="no">

<head>
	<title>Bilklubben - Medlem</title>
<?php 
	/***** Header: CSS *****/
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
	if ( !isset($_SESSION['userid']) )
	{
		/***** IKKE logget inn *****/
?>	
		<!-- Innsalg av tjenesten for anonyme brukere -->
		<div class="jumbotron">
			<div class="container">
				<h1>Bli med i Bilklubben!</h1>
				<p>Du betaler en avtalt sum i måneden for et gitt antall poeng (kan endres når som helst). Disse poengene benytter du til å låne en bil akkurat når du trenger det. Ubenyttet saldo videreføres til neste måned.</p>
				<p>Fyll ut skjemaet og gjør veien til et enklere bil-liv så kort som mulig.
					<span class="pull-right">
						Allerede medlem?
						<a data-toggle='modal' data-target='#loginModal' class='btn btn-primary btn-md'><span class='glyphicon glyphicon-user'></span> Logg inn</a>
					</span>
				</p>
			</div>
		</div>
		<!-- . jumbotron -->
<?php 
	}
	else
	{
		/***** Bruker er logget inn *****/
		include "brukerinfo.php";
?>	

		<!-- Sidemeny -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="nav nav-pills">
					<li role="presentation" data-nav="member-bookings" class="active"><a href="#"><span class='glyphicon glyphicon-th-list' aria-hidden='true'></span>&nbsp;&nbsp;Bestillinger</a></li>
					<li role="presentation" data-nav="member-history"><a href="#"><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span>&nbsp;&nbsp;Historikk</a></li>
					<li role="presentation" data-nav="member-form"><a href="#"><span class='glyphicon glyphicon-user' aria-hidden='true'></span>&nbsp;&nbsp;Brukerprofil</a></li>
					<li role="presentation" data-nav="member-tip"><a href="#"><span class='glyphicon glyphicon-send' aria-hidden='true'></span>&nbsp;&nbsp;Tips en venn</a></li>
					<li role="presentation" data-nav="member-end"><a href="#"><span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span>&nbsp;&nbsp;Avslutt abonnement</a></li>
				</ul>
			</div>
			<div class="panel-body">
<?php 	
	}
		/***** For både anonyme og påloggede brukere ***/
?>		
		<!-- Form for brukerdata -->
		<form class="form-horizontal" action="set-userdata.php" method="post" id="member-form">
			<div id="step1">
				<div class="col-sm-offset-3 col-sm-9">
					<h2>Abonnement og personopplysninger</h2>
				</div>
				<div class="form-group">
					<label for="poeng" class="col-sm-3 control-label">* Poeng per måned</label>
					<div class="col-sm-4 required">
						<select class="form-control" id="poeng" name="poeng">
							<option value="100" selected>100 poeng = 399,-</option>
							<option value="200">200 poeng = 749,-</option>
							<option value="500">500 poeng = 1 799,-</option>
							<option value="1000">1000 poeng = 3 499,-</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="navn" class="col-sm-3 control-label">* Navn</label>
					<div class="col-sm-6 required">
					  <input type="text" class="form-control" id="navn" name="navn" placeholder="Ola Nordmann" />
					</div>
				</div>
				<div class="form-group">
					<label for="adresse" class="col-sm-3 control-label">Adresse</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Veien 12" />
					</div>
				</div>				
				<div class="form-group inline">
					<label for="postnr" class="col-xs-12 col-sm-3 control-label">* Postadresse</label>
					<div class="col-xs-4 col-sm-2 required">
					  <input type="text" class="form-control" id="postnr" name="postnr" placeholder="1234" />
					</div>
					<div class="col-xs-8 col-sm-4 required">
					  <input type="text" class="form-control" id="poststed" name="poststed" placeholder="Stedet" />
					</div>
				</div>					
				<div class="form-group">
					<label for="mobil" class="col-sm-3 control-label">* Mobiltelefon</label>
					<div class="col-sm-4 required">
					  <input type="text" class="form-control" id="mobil" name="mobil" placeholder="+47xxxxxxxx" />
					</div>
				</div>		
				<div class="form-group">
					<label for="epost" class="col-sm-3 control-label">* E-postadresse</label>
					<div class="col-sm-4 required">
					  <input type="mail" class="form-control" id="epost" name="epost" placeholder="ola@nordmann.no" />
					</div>
				</div>					
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<button class="btn btn-default" id="next1">Bruker og Betaling&nbsp;&nbsp;<span class='glyphicon glyphicon-circle-arrow-right' aria-hidden='true'></span></button>
<?php 
				if ( isset($_SESSION['userid']) )
				{
					/***** Logget inn *****/
?>
						<button type="submit" class="btn btn-primary pull-right" id="submit1">Oppdater&nbsp;&nbsp;<span class='glyphicon glyphicon-circle-arrow-up' aria-hidden='true'></span></button>
<?php
				}
?>			
					</div>
				</div>
			</div>
			<div id="step2">
				<div class="col-sm-offset-3 col-sm-9">
					<h2>Brukernavn og passord</h2>
				</div>
				<div class="form-group">
					<label for="username" class="col-sm-3 control-label">* Brukernavn</label>
					<div class="col-sm-4 required">
					  <input type="text" class="form-control" id="username" name="username" placeholder="Brukernavn" />
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-3 control-label">* Passord</label>
					<div class="col-sm-4 required">
					  <input type="password" class="form-control" id="password" name="password" placeholder="Passord" />
					</div>
				</div>
				<div class="form-group">
					<!-- Tom linje -->
					<p class="form-tom-linje">&nbsp;</p>
				</div>
				<div class="form-group">
					<!-- Tom linje -->
					<p class="form-tom-linje">&nbsp;</p>
				</div>
				<div class="form-group">
					<!-- Tom linje -->
					<p class="form-tom-linje">&nbsp;</p>
				</div>
				<div class="form-group">
					<!-- Tom linje -->
					<p class="form-tom-linje">&nbsp;</p>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<button class="btn btn-default" id="prev2"><span class='glyphicon glyphicon-circle-arrow-left' aria-hidden='true'></span>&nbsp;&nbsp;Profil</button>&nbsp;&nbsp;
						<button class="btn btn-default" id="next2">Betaling&nbsp;&nbsp;<span class='glyphicon glyphicon-circle-arrow-right' aria-hidden='true'></span></button>
<?php 
				if ( isset($_SESSION['userid']) )
				{
					/***** Logget inn *****/
?>
						<button type="submit" class="btn btn-primary pull-right" id="submit2">Oppdater&nbsp;&nbsp;<span class='glyphicon glyphicon-circle-arrow-up' aria-hidden='true'></span></button>
<?php
				}
?>			
					</div>
				</div>
			</div>
			<div id="step3">
				<div class="col-sm-offset-3 col-sm-9">
					<h2>Betaling</h2>
				</div>
				<div class="form-group inline">
					<div class="col-sm-offset-3 col-sm-9" id="credit_cards">
						<img src="visa.jpg" id="visa">
						<img src="mastercard.jpg" id="mastercard">
						<img src="amex.jpg" id="amex">
						<span>Månedlig betaling skjer ved belastning av registrert kredittkort</span>
					</div>
				</div>
				<div class="payment">
                    <div class="form-group">
                        <label for="owner" class="col-sm-3 control-label">* Korteier</label>
						<div class="col-sm-6 required">
							<input type="text" class="form-control" name="owner" id="owner" placeholder="Ola Nordmann" />
						</div>							
                    </div>
                     <div class="form-group" id="card-number-field">
                        <label for="cardnumber" class="col-sm-3 control-label">* Kortnummer</label>
						<div class="col-sm-4 required">
							<input type="text" class="form-control" name="cardnumber" id="cardnumber" placeholder="xxxx xxxx xxxx xxxx" />
						</div>							
                    </div>
                    <div class="form-group inline" id="expiration-date">
                        <label for="expmonth" class="col-xs-12 col-sm-3 control-label">* Utløpsdato</label>
						<div class="col-xs-6 col-sm-2 required">
							<select name="expmonth" id="expmonth" class="form-control">
								<option value="01">Januar</option>
								<option value="02">Februar </option>
								<option value="03">Mars</option>
								<option value="04">April</option>
								<option value="05">Mai</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>
						<div class="col-xs-6 col-sm-2 required">
							<select name="expyear" id="expyear"  class="form-control" >
								<option value="2017"> 2017</option>
								<option value="2018"> 2018</option>
								<option value="2019"> 2019</option>
								<option value="2020"> 2020</option>
								<option value="2021"> 2021</option>
								<option value="2022"> 2022</option>
							</select>
							</div>
                    </div>
 					<div class="form-group">
                        <label for="cvv" class="col-xs-12 col-sm-3 control-label">* CVV</label>
						<div class="col-xs-6 col-sm-2 required">
							<input type="text" class="form-control" id="cvv" placeholder="xxx" />
						</div>							
                    </div>
					<div class="form-group">
						<!-- Tom linje -->
						<p class="form-tom-linje">&nbsp;</p>
					</div>
				</div>			
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<button class="btn btn-default" id="prev3"><span class='glyphicon glyphicon-circle-arrow-left' aria-hidden='true'></span>&nbsp;&nbsp;Profil og Bruker</button>
<?php 
	if ( !isset($_SESSION['userid']) )
	{
		/***** IKKE logget inn *****/
?>	
						<button type="submit" class="btn btn-primary pull-right" id="submit3">Registrer og betal&nbsp;&nbsp;<span class='glyphicon glyphicon-circle-arrow-up' aria-hidden='true'></span></button>
<?php 
	}	
	else
	{
		/***** Logget inn *****/
?>
						<button type="submit" class="btn btn-primary  pull-right" id="submit3">Oppdater&nbsp;&nbsp;<span class='glyphicon glyphicon-circle-arrow-up' aria-hidden='true'></span></button>
<?php
	}
?>
					</div>
				</div>
			</div>
			<input type="hidden" id="redirect_user" name="redirect_user" />				
		</form>					
<?php 
	if ( isset($_SESSION['userid']) )
	{
		/***** Innlogget bruker *****/
?>
				<!-- Vis bookinger  -->
				<div id="member-bookings">
					<div class="row">
						<div class="col-sm-5 col-sm-push-7">
							<div class="well">
								<p>Melde inn feil og mangler på en bil du har lånt: Velg <mark>Historikk</mark></p>
								<p>Ved behov for veihjelp, ring NAF: <a href="tel:08505"><span class='glyphicon glyphicon-phone' aria-hidden='true'></span>08505</a></p>
							</div>
						</div>
						<div class="col-sm-7 col-sm-pull-5">
							<h2>Alle mine bestillinger</h2>
							<p>Klikk på kolonneoverskriftene for å sortere (stigende/synkende).<br/>
							Klikk på en rad for å avbestille aktuell bil.</p>
						</div>
					</div>
					<table class="table table-striped table-condensed table-responsive table-hover tablesorter" id="table-bookings">
						<thead>
							<tr>
								<th title="Klikk for sortering">Dato</th>
								<th title="Klikk for sortering">Type - merke (årsmodell)</th>
								<th title="Klikk for sortering">Bil #</th>
								<th title="Klikk for sortering">Reservasjons #</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				
				<!-- Vis historikk  -->
				<div id="member-history">
					<h2>Min historikk</h2>
					<p>Klikk på kolonneoverskriftene for å sortere (stigende/synkende).<br/>
					Klikk på en rad for å sende inn en rapport om feil/mangler e.l. på aktuell bil.</p>
					<table class="table table-striped table-condensed table-responsive table-hover tablesorter" id="table-history">
						<thead>
							<tr>
								<th title="Klikk for sortering">Dato</th>
								<th title="Klikk for sortering">Type - merke (årsmodell)</th>
								<th title="Klikk for sortering">Bil #</th>
								<th title="Klikk for sortering">Reservasjons #</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				
				<!-- Tips en venn -->
				<form  class="form-horizontal" action="" id="member-tip">
					<div class="col-sm-offset-3 col-sm-9">
						<h2>Tips en venn om Bilklubben</h2>
					</div>
					<div class="form-group">
						<label for="tips-navn" class="col-sm-3 control-label">* Mottakers navn</label>
						<div class="col-xs-6 col-sm-4 required">
							<input type="text" class="form-control" id="tips-navn" name="tips-navn" placeholder="Ola Nordmann" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="tips-epost" class="col-sm-3 control-label">* Mottakers e-post</label>
						<div class="col-xs-6 col-sm-4 required">
							<input type="mail" class="form-control" id="tips-epost" name="tips-epost" placeholder="ola@nordmann.no" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="tips-melding" class="col-sm-3 control-label">* Din melding</label>
						<div class="col-xs-12 col-sm-6 required">
							<textarea class="form-control" rows="6" id="tips-melding" name="tips-melding" required>Hei, jeg vil gjerne fortelle deg om Bilklubben!</textarea>
						</div>
						<span class="help-block">Vi legger en lenke til våre sider i e-posten som sendes. Takk for at du sprer det glade budskap!</span>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Send&nbsp;&nbsp;<span class='glyphicon glyphicon-send' aria-hidden='true'></span></button>
						</div>
					</div>
				</form>					

				<!-- Avslutt abonnement -->
				<form class="form-horizontal" action="" method="post" id="member-end">
					<div class="col-sm-offset-3 col-sm-9">
						<h2>Avslutt abonnement</h2>
					</div>
					<div class="form-group">
						<span class="col-sm-3 control-label"><strong>* Bekreftelse</strong></span>
						<div class="col-sm-9 checkbox required">
						  <label><input type="checkbox" id="confirm" name="confirm" required/>Ja, jeg vil avslutte mitt abonnement i Bilklubben AS</label>
						</div>
					</div>
					<div class="form-group">
						<label for="avslutt-melding" class="col-sm-3 control-label">Hvorfor forlater du oss?</label>
						<div class="col-xs-12 col-sm-6 required">
							<textarea class="form-control" rows="6" id="avslutt-melding" name="avslutt-melding"></textarea>
						</div>
						<span class="help-block">Vi setter stor pris på dine tilbakemeldinger!</span>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							<button class="btn btn-default" id="submit-end"><span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span>&nbsp;&nbsp;Avslutt mitt abonnement</button>
						</div>
					</div>
				</form>

			</div>
		</div>
		<!-- .panel -->
<?php
	}
?>		
	</div>		<!-- END: .container -->
	
	<!-- Modal-dialoger -->
<?php
	include "modal-login.php";
	include "modal-avbestille-bil.php";
	include "modal-rapportere-bil.php";
	
	/***** Footer og Javascript *****/
	include "tail.php";
?>
	<!-- Init av siden -->
	<script>
		$(function(){
			initPage();
<?php
	if ( isset($_SESSION['userid']) )
	{
			/***** Bruker er logget inn *****/
?>
			// Hent data om alle biler (trengs til tabell over brukers bookinger)
			getCarInfo();
			
			// Hent og vis brukerdata
			getMember( updateUserForm );
<?php 	
	}
	else
	{
			/***** IKKE pålogget bruker *****/
?>			
			//Sett opp input-form for brukerdata (felles for ny og eksisterende bruker)
			initMember( window.location.href );	
<?php
	}
?>			
		});
		// initMember() er avhengig av at både bil-info og user-info er hentet
		var userOK = false;
		var carsOK = false;
		var initOK = false;
		$(document).ajaxComplete(function( event, xhr, settings ) {
			if ( !initOK )
			{
				if ( settings.url.includes("get-cars.php") ) {
					carsOK = true;
				}
				if ( settings.url.includes("get-userdata.php") ) {
					userOK = true;
				}
				if ( carsOK && userOK ) {
					initMember( window.location.href );	
					initOK = true;
				}
			}
		});
	</script>
</body>
</html>