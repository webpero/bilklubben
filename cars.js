/* Bilklubben AS - Prosjektoppgave NTNU V2017 i Webutvikling 2
 * Forutsetter bruk av Bootstrap 3
 * Kode for validering av kredittkort har hentet inspirasjon fra: http://tutorialzine.com/2016/11/simple-credit-card-validation-form/
 *
 * Per Olav Mariussen
 * 22.05.2017
 */

/*************************** Global variable ************************/

let userInfo = {};			//Brukerdata for pålogget bruker
let userBookings = [];		//Tabell over alle brukers framtidige bookinger
let userHistory = [];		//Tabell over alle brukers historiske bookinger
let carBooked = [];			//Tabell over alle bestilte biler
let carInfo = [];			//Tabell over info om alle biler
let carPos = [];			//Tabell over alle bilers posisjon (inneholder NULL hvis bilen er reservert)
let carMarkers = [];		//Tabell over Google Maps Markers for hver bil
let lastClicked = null;		//jQuery obejct som ble det ble klikket på sist
var parkMap;				//Kartet over tilgjengelige biler

//Fargekoder ut fra biltype
const CAR_COLORS = [ 		
	{ id: "Familiebil", color: "#5781fc", marker: "blue50.png" }, 
	{ id: "Varebil", 	color: "#fc6355", marker: "red50.png" }, 
	{ id: "Liten bil", 	color: "#00e13c", marker: "green50.png" } 
];

//HTML ved ingen rader i tabeller for bestilinger og historikk
const NOUSE_HTML = "<td><a href='index.php'><span class='glyphicon glyphicon-map-marker' aria-hidden='true'></span> Finn bil i dag</a></td><td><a href='finn.php'><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> Finn bil fram i tid</a></td>";


/*************************** Datofunksjoner ************************/

// Retunerer dato på formatet d.m.yyyy som yyyy-mm-dd
function datoNoISO( no )
{
	let dato = no.split(".");
	return dato[2] + "-" + (dato[1].length===1?"0":"")+dato[1] + "-" + (dato[0].length===1?"0":"")+dato[0];
}

// Returnerer TRUE hvis target finnes i datelist
// target: JS dato
// datelist: streng-liste med datoer på formatet YYYY-MM-DD
function dateMatch( target, datelist )
{
	let datestr = target.toJSON().substr(0,10); // YYYY-MM-DD
	return( datelist.includes(datestr) );
}

/************** Funksjoner håndtering av brukerdata *****************/

// Hent medlemsdata 
function getMember( callback )
{
	$.getJSON("get-userdata.php" )
	.done( function(data){ 
		// Tøm tabellen data og fyll den på nytt
		userInfo.length = 0;
		userInfo = data;
		if ( callback !== undefined ) {
			// Kall callback-function (som er avhengig av dataene finnes før den kan kjøre)
			callback();
		}
	})
	.fail( function(jqxhr,textStatus,error) {
		var err = textStatus + ", " + error;
		console.log( "Request Failed: " + err );
	});
}

// Populer input-form for brukerinfo
function updateUserForm()
{
	$("#navn").val( userInfo.name );
	$("#adresse").val( userInfo.address );
	if ( userInfo.address === "" ) {
		//Fjern eksempeltekst fra adressefeltet (ser dumt ut hvis feltet er tomt)
		$("#adresse").attr("placeholder","");
	}
	$("#postnr").val( userInfo.zip );
	$("#poststed").val( userInfo.city );
	$("#mobil").val( userInfo.mobile );
	$("#epost").val( userInfo.mail );
	$("#username").val( userInfo.username );
	$("#password").val( userInfo.userpass );
	$("#poeng").val( userInfo.monbalance );
	$("#owner").val( userInfo.card_owner );
	$("#cardnumber").val( userInfo.card_number );
	$("#expmonth").val( userInfo.card_expmonth );
	$("#expyear").val( userInfo.card_expyear );
}

// Hent alle brukers framtidige bookinger 
function getUserBookings( callback )
{
	// Hent bookingdata
	$.getJSON("get-user-bookings.php" )
	.done( function(data){ 
		// Tøm tabellen for tilgjengelige bilder og fyll den på nytt
		userBookings.length = 0; 
		userBookings.push( data );
		if ( callback !== undefined ) {
			// Kall callback-function (som er avhengig av dataene finnes før den kan kjøre)
			callback();
		}
	})
	.fail( function(jqxhr,textStatus,error) {
		var err = textStatus + ", " + error;
		console.log( "Request Failed: " + err );
	});
}

// Hent alle brukers historiske bookinger 
function getUserHistory( callback )
{
	// Hent historiske bookingdata
	$.getJSON("get-user-history.php" )
	.done( function(data){ 
		// Tøm tabellen for tilgjengelige bilder og fyll den på nytt
		userHistory.length = 0; 
		userHistory.push( data );
		if ( callback !== undefined ) {
			// Kall callback-function (som er avhengig av dataene finnes før den kan kjøre)
			callback();
		}
	})
	.fail( function(jqxhr,textStatus,error) {
		var err = textStatus + ", " + error;
		console.log( "Request Failed: " + err );
	});
}

// Vis brukers framtidige bookinger i tabell
function showUserBookings()
{
	let html = "";

	//Gå igjennom alle bookinger og legg ut en linje i HTML-tabellen per booking
	if ( userBookings[0].length > 0 )
	{
		$.each( userBookings[0], function(i,v) {
			let car = $.grep(carInfo[0], function(e){ return e.id == v.car_id; })[0];  	//Hent ut aktuelt element fra carInfo-tabellen basert på bilens ID
			html += "<tr data-row='"+i+"'>";
			html += "<td>"+this.date+"</td>";
			html += "<td>"+car.model_type+" - "+car.maker+" "+car.model+" ("+car.model_year+")</td>";
			html += "<td>"+this.car_id+"</td>";
			html += "<td>"+this.reservation_id+"</td>";
			html += "</tr>";
		});
	}
	else
	{
		html = "<tr style='cursor:initial'><td colspan=2>Du har ingen bestillinger ennå.</td>" + NOUSE_HTML + "</tr>";
	}
	
	//Legg ut hele tabellen
	$("#table-bookings").append(html);
	$("#table-bookings").tablesorter();
	
	//Klikk på rad
	if ( userBookings[0].length > 0 )
	{
		$("#table-bookings > tbody tr").click( function() { 
			carCancel( $(this) );
		});
	}
}

// Vis brukers historiske bookinger i tabell
function showUserHistory()
{
	let html = "";

	if ( userHistory[0].length > 0 )
	{
		//Gå igjennom alle bookinger og legg ut en linje i HTML-tabellen per booking
		$.each( userHistory[0], function(i,v) {
			let car = $.grep(carInfo[0], function(e){ return e.id == v.car_id; })[0];  	//Hent ut aktuelt element fra carInfo-tabellen basert på bilens ID
			html += "<tr data-row='"+i+"'>";
			html += "<td>"+this.date+"</td>";
			html += "<td>"+car.model_type+" - "+car.maker+" "+car.model+" ("+car.model_year+")</td>";
			html += "<td>"+this.car_id+"</td>";
			html += "<td>"+this.reservation_id+"</td>";
			html += "</tr>";
		});
	}
	else
	{
		html = "<tr style='cursor:initial'><td colspan=2>Du har ikke brukt Bilklubben ennå.</td>" + NOUSE_HTML + "</tr>";
	}

	//Legg ut hele tabellen
	$("#table-history").append(html);
	$("#table-history").tablesorter();

	//Klikk på rad
	if ( userHistory[0].length > 0 ) 
	{
		$("#table-history > tbody tr").click( function() { 
			carReport( $(this) );
		});	
	}
}

/** Valideringsfunsjoner ***/
function validateEmail(email)
{
    let filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    return ( filter.test(email) )
}
function validateUsername(username)
{	
	return "";
}
function validatePassword(password)
{
	return "";
}
function setError( error, id, check )
{
	//Sett status til error eller success
	$(id).closest(".form-group").addClass( check ? "has-error" : "has-success" );
	if (!error) {
		//Dette er første feil, sett fokus til feltet
		$(id).focus();
	}
	return check;
}
//Sjekk om alle påkrevde brukerdata er fylt ut korrekt
function checkMember()
{
	let error = false;
	
	//Fjern alt som ikke er tall fra postnr og mobilnr
	$("#postnr").val( $("#postnr").val().replace(/\D/g,'') );  
	$("#mobil").val( $("#mobil").val().replace(/\D/g,'') );  

	//Fjern alle gamle statuser
	$("#member-form .form-group").removeClass("has-error has-success");	

	//Sjekk alle felter samlet
	error = setError( error, $("#navn"), 		$("#navn").val().length < 4 ) 		|| error;  
	error = setError( error, $("#postnr"),		$("#postnr").val().length !== 4 ) 	|| error;
	error = setError( error, $("#poststed"),	$("#poststed").val().length < 2 ) 	|| error;
	error = setError( error, $("#mobil"),		$("#mobil").val().length < 8 ) 		|| error;
	error = setError( error, $("#epost"),		!validateEmail($("#epost").val()) )	|| error; 

	//Fjern eksempeltekst fra adressefeltet (ser dumt ut hvis dette er tomt)
	$("#adresse").attr("placeholder","");
	
	return !error;
}
//Sjekk om brukernavn og passord er fylt ut korrekt
function checkUser()
{
	let msg = "";

	//Fjern alle gamle statuser og meldinger
	$("#member-form .form-group").removeClass("has-error has-success");	
	$("#username-msg").text("");
	$("#password-msg").text("");

	//Sjekk felter hver for seg
	msg = validateUsername($("#username").val())
	if ( msg !== "" )	
	{
		//Brukernavn er ikke godkjent
		$("#username").closest(".form-group").addClass("has-error");
		$("#username-msg").text(msg);
		return false;
	}
	msg = validatePassword($("#password").val())
	if ( msg !== "" )	
	{
		//Passsord er ikke godkjent
		$("#password").closest(".form-group").addClass("has-error");
		$("#password-msg").text(msg);
		return false;
	}
	return true;
}
//Sjekk av kredittkort. Bruker payform-plugin
function checkCreditCard()
{
	let error = false;

	//Fjern alle gamle statuser
	$("#member-form .form-group").removeClass("has-error has-success");	
	
	//Sjekk alle felter samlet
	error = setError( error, $('#owner'), 		$('#owner').val().length < 5 ) 							|| error;
	error = setError( error, $('#cardnumber'), 	!$.payform.validateCardNumber($('#cardnumber').val()) ) || error;
	error = setError( error, $("#cvv"), 		!$.payform.validateCardCVC($("#cvv").val())	) 			|| error;
	
	return !error;
}
//Init løpende sjekk av kredittkort ved inntasting. Bruker payform-plugin
function initCreditCard() 
{
	let cardNumber = $('#cardnumber');
	let cardNumberField = $('#card-number-field');
	let mastercard = $("#mastercard");
	let visa = $("#visa");
	let amex = $("#amex");
	
    cardNumber.payform('formatCardNumber');
    $("#cvv").payform('formatCardCVC');

	$("#member-form").keydown(function(ev) {
		if ( ev.which == 13 ) {
			ev.preventDefault();
		}
	});
    cardNumber.keyup(function() {

        amex.removeClass('transparent');
        visa.removeClass('transparent');
        mastercard.removeClass('transparent');

        if ($.payform.validateCardNumber(cardNumber.val()) == false) {
            cardNumberField.addClass('has-error');
        } else {
            cardNumberField.removeClass('has-error');
            cardNumberField.addClass('has-success');
        }

        if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
            mastercard.addClass('transparent');
            amex.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'amex') {
            mastercard.addClass('transparent');
            visa.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
            amex.addClass('transparent');
            visa.addClass('transparent');
        }
    });
}


/************** Funksjoner håndtering av biler *****************/

// Hent data om alle biler, utfør deretter callback-funksjon 
function getCarInfo( callback )
{
	// Hent bildata 
	$.getJSON("get-cars.php" )
	.done( function(data){ 
		// Tøm tabellen for tilgjengelige bilder og fyll den på nytt
		carInfo.length = 0; 
		carInfo.push( data );
		if ( callback !== undefined ) {
			// Kall callback-function (som er avhengig av dataene finnes før den kan kjøre)
			callback();
		}
	})
	.fail( function(jqxhr,textStatus,error) {
		var err = textStatus + ", " + error;
		console.log( "Request Failed: " + err );
	});
}

// Vis alle tilgengelige biler for i dag på kartet
function showCarPositions()
{
	let date = new Date();
	let today = date.toJSON().substr(0,10); // YYYY-MM-DD
	
	// Hent alle tilgjengelige bilers posisjon
	$.getJSON("get-cars-pos.php" )
	.done( function(data){ 
		// Tøm tabellen for bilenes posisjon og fyll den på nytt
		carPos.length = 0; 
		carPos.push( data );
		// Sett markører på kartet og sett opp klikk-funksjonalitet for bestilling
		$.each( carPos[0], function(i,v) {
			if(this.car_lat !== null && this.car_lng !== null )
			{
				let car = $.grep(carInfo[0], function(e){ return e.id == v.car_id; })[0];  					//Hent ut aktuelt element fra carInfo-tabellen basert på bilens ID
				let icon = $.grep(CAR_COLORS, function(e){ return e.id === car.model_type; })[0].marker;		//Ikon som skal vises basert på biltype
				let tmpMarker = new google.maps.Marker({
								position: new google.maps.LatLng( parseFloat(this.car_lat), parseFloat(this.car_lng) ),
								map: parkMap,
								icon: icon,
								label: this.car_id,
								title: car.id+": "+car.model_type+" - "+car.maker+" "+car.model+" ("+car.model_year+")"
							});
				tmpMarker.addListener('click', function() {
					setupCarModal( 
						this.title,
						today,
						today,
						1,
						this.label,
						false
					);
				});
				carMarkers.push(tmpMarker);
			}
		});
	})
	.fail( function(jqxhr,textStatus,error) {
		var err = textStatus + ", " + error;
		console.log( "Request Failed: " + err );
	});
	
	//Sett opp modal-dialog for mer info om en bil (gjør dette her for å sikre at carInfo har blitt oppdatert)
	initCarDialog( $("#cartable tr") ); //Parameter er targetobjekter som skal trigge dialogen

}

//Vis tilgjengeligheten til alle biler famover i en tabell
function showCarAvailability()
{
	let date = new Date();							// I dag
	let start_date = date.toJSON().substr(0,10); 	// YYYY-MM-DD
	let days = 30;									// Antall dager framover som skal vises
	
	// Hent booking av alle biler fra angitt dato (date) og (days) dager fremover
	$.getJSON("get-cars-booked.php", { date: start_date, days: days } )
	.done( function(data){ 
		let html = "";
		let datelist = [];
		let tmp_month, last_month = 0;
		
		carBooked.length = 0; 	// Tøm tabellen 
		carBooked.push( data );	// Legg alle data inn i tabellen

		//Opprett liste av alle datoer som er aktuelle (date + days dager framover)
		for ( var d=0; d<days; d++ ) {
			datelist[d] = new Date();
			datelist[d].setDate(date.getDate()+d);
		}
		//Legg datoliste som heading i HTML-tabellen
		html += "<thead><tr><th></th>";
		for ( var d=0; d<days; d++ ) {
			tmp_month = datelist[d].getMonth()+1;
			html += "<th"+(tmp_month>last_month?" class='nymnd'":"")+">"+datelist[d].getDate()+"."+(tmp_month>last_month?tmp_month:"")+"</th>";
			last_month = tmp_month;
		}
		html += "</tr></thead><tbody>";

		//Gå igjennom alle biler og legg ut en linje i HTML-tabellen med tilgjengeligheten per bil
		$.each( carInfo[0], function(i,v) {
			let booked = $.grep(carBooked[0], function(e){ return e.id == v.id; });  //Hent ut aktuelt element fra booking-tabellen basert på bilens ID
			tmp_month = last_month = 0;
			html += "<tr><td class='car-info' title='id:"+this.id+"'><a data-toggle='modal' data-id='"+this.id+"'data-target='#carInfoModal'>"+this.model_type+": "+this.maker+" "+this.model+" ("+this.model_year+")</a></td>";
			//Gå igjennom alle dagene for å se om bilen er booket, eller ikke
			for ( var d=0; d<days; d++ ) {
				tmp_month = datelist[d].getMonth()+1;
				html += "<td"+(tmp_month>last_month?" class='nymnd'":"")+"><div class='";
				//Hvis aktuell dato finnes i booked, sett bil opptatt, ellers ledig
				if( booked.length == 1 && dateMatch(datelist[d],booked[0].dates) ) {
					html += "car-booked";
				} else {
					html += "car-free' data-carid='" + this.id + "' data-date='" + datelist[d].toJSON().substr(0,10);
				} 
				html += "'></td>";
				last_month = tmp_month;
			}
			html += "</tr>";
		});
		html += "</tbody>";
		//Legg ut hele tabellen
		$("#caravail").append(html);

		//Legg på klikk-funksjonalitet
		$("#caravail .car-free").click( function(e) {
			if ( lastClicked !== null )
			{
				//Dette er klikk nummer to, sett opp range for booking
				let rad = $(this).closest("tr");
				
				if ( rad.is(lastClicked.closest("tr")) )
				{
					//Andre klikk på samme rad som første, prøv å booke alt i mellom cellene
					let start = -1;
					let stop = 0;
					let selection = rad.find("td");
					$(this).addClass("car-booking");
					selection.each( function(i,val) {
						//Gå igjennom alle celler for å finne start og stopp punkt for bookingforsøk
						if ( stop > 0 )
						{
							//Stopp er nådd, fjern eventuelle celler med status booking (bruker har klikket bak en dato som er opptatt)
							$(val).find(".car-free").removeClass("car-booking");
						}
						else
						{
							//Stopp er ikke satt
							if ( start >= 0 )
							{
								//Start-dato er satt, let etter sluttdato
								if ( $(val).html().includes("car-booking") ) 
								{	
									//Dette er siste dato i range
									stop = i;
								}
								else 
								{
									//Sjekk om aktuell dato er ledig, hvis OK: fortsett
									if ( $(val).html().includes("car-booked") )
									{
										//Har nådd en opptatt dato, stopp på forrige dato
										stop = i-1;
										$(val).fadeOut(function(){ $(val).fadeIn(); });
									}
									else
									{
										// Legg denne datoen til bookingen
										$(val).find(".car-free").addClass("car-booking");
									}
								}
							}
							else if ( $(val).html().includes("car-booking")  )
							{
								//Dette er første dato i range
								start = i;
							}
						}
					});
					if ( stop === 0 ) {
						//Fant aldri stopp, dvs. bruker har klikket start og stopp på samme dato
						stop = start;
						//Må løpe igjennom å fjerne markering av booking
						selection.each( function(i,val) {
							if ( i > start ) {
								$(val).find(".car-free").removeClass("car-booking");
							}
						});
					}
					//Nullstill klikksekvens og kall booking-dialogen
					lastClicked = null;
					setupCarModal( 
						$(this).closest("tr").children(":first").text(),
						$(selection[start]).find(".car-booking").data("date"),
						$(selection[stop]).find(".car-booking").data("date"),
						stop-start+1,
						$(selection[start]).find(".car-booking").data("carid"),
						true
					);
				}
				else
				{
					//Andre klikk er på en annen rad, start ny klikk-sekvens
					lastClicked.removeClass("car-booking");
					lastClicked = $(this);
					$(this).addClass("car-booking");
				}
			}
			else
			{
				//Dette er første klikk, start ny klikk-sekvens
				$(this).addClass("car-booking");
				lastClicked = $(this);
			}
		});
	})
	.fail( function(jqxhr,textStatus,error) {
		var err = textStatus + ", " + error;
		console.log( "Request Failed: " + err );
	});
	
	//Sett opp modal-dialog for mer info om en bil (gjør dette her for å sikre at carInfo har blitt oppdatert)
	initCarDialog(null); // Null angir at klikk ikke skal knyttes til kallstedet, men er en lenke som bruker Bootstrap data-target
}

// Send inn bestilling på en bil fra en dato og gitt antall dager framover
function bookCar( id, start_date, days, cost )
{
	// Send the request
	$.post('set-car-booking.php', { id: id, date: start_date, days: days, cost: cost } )
	.done( function(data){ 
		if ( data.includes("ERROR") ) {
			$("#bil-error").text(data).show();
		}
		else {
			$("#bil-ok").text( "Bestillingen er bekreftet" ).show();			
			//Hvordan vise reservasjons-id?
			
			//Oppdater knappene i dialogen
			$("#carOrder").hide();
			$("#carModalClose").text("OK");
		}
	})
	.fail( function(jqxhr,textStatus,error) {
		var err = textStatus + ", " + error;
		$("#bil-error").text(err).show();
	});
}

// Avbestilling - Parameter er raden fra booking-table som jQuery object 
function carCancel( row )
{
	let booking = userBookings[0][$(row).data("row")];
	let car = $.grep(carInfo[0], function(e){ return e.id == booking.car_id; })[0];  	//Hent ut aktuelt element fra carInfo-tabellen basert på bilens ID
	let title = "Avbestilling: " + car.model_type + " - " + car.maker + " " + car.model + " (" + car.model_year + ")";
	$("#carCancelModal .modal-title").text(title);
	$("#cancel-date").val(booking.date);
	$("#cancel-car_id").val(booking.car_id);
	$("#cancel-res_id").val(booking.reservation_id);
	$("#carCancelModal").modal('show');
}

// Send inn rapport på bil - Parameter er raden fra history-table som jQuery object 
function carReport( row )
{
	let booking = userHistory[0][$(row).data("row")];
	let car = $.grep(carInfo[0], function(e){ return e.id == booking.car_id; })[0];  	//Hent ut aktuelt element fra carInfo-tabellen basert på bilens ID
	let title = "Rapport på: " + car.model_type + " - " + car.maker + " " + car.model + " (" + car.model_year + ")";
	$("#carReportModal .modal-title").text(title);
	$("#report-car_id").val(booking.car_id);
	$("#report-msg").focus();
	$("#carReportModal").modal('show');	
}

// Sett opp modal-dialog for bestilling av bil
function setupCarModal( info, start_date, stop_date, days, id, hide_booking_btn )
{
	let car = $.grep(carInfo[0], function(e){ return e.id == id; })[0];
	let cost = car.cost*days;
	let user = (userInfo.userbalance !== undefined);	//Vi har en gyldig bruker
	let balance = (user ? userInfo.userbalance : 0);	//Brukers saldo
	
	$('#bil-info').text(info); 
	$('#bil-fra-dato').val(start_date);
	$('#bil-til-dato').val(stop_date);
	$('#bil-dager').val(days);
	if ( user && days === 1 ) {
		//Vis booking for flere dager
		$('.flere-dager').show();
	}
	$('#bil-kost').val(cost);
	$('#bil-saldo').val(balance-cost);	
	$('#bil-id').val(id);
	if ( !user || cost > userInfo.userbalance ) 
	{
		// Ingen bruker, eller bruker har ikke nok poeng til å leie bilen
		$('#carOrder').hide();
		$('#bil-kost, #bil-saldo').parent().addClass('has-error');
	}
	if ( !user ) 
	{	
		//Ingen bruker, vis melding og knapper for bli medlem og logg inn
		$("#bil-error").text("Bare medlemmer kan bestille bil.");
		$(".bg-warning").show();
		$(".no-user").show();
	}
	if ( cost > userInfo.userbalance )
	{
		//Ikke høy nok saldo, vis melding og knapp for ekstra innskudd
		$("#bil-error").text("Du har ikke høy nok saldo til dette lånet. Velg på nytt, eller gjør et innskudd.");
		$(".bg-warning").show();
		$("#innskudd").show();
	}
	if ( hide_booking_btn ) {
		//Skjul knapp for flere dagers leie
		$("#leie-flere-dager").hide();
	}
	
	// Vis dialogen
	$('#carModal').modal('show');
}

/*********** Init-funksjoner for funksjonalitet på de ulike sidene **************/

// Init felles for alle sider: meny og login
function initPage()
{
	//Sett aktivt menyvalg
	$(".navbar-nav > li > a").each( function() { 
		if(  window.location.href.includes($(this).attr("href")) ) { 
			$(this).parent().addClass("active");
		}
	});	
	// Modal dialog for innlogging, fjern eventuell login-parameter
	$('#loginModal').on('show.bs.modal', function (ev) {
		let url = window.location.href;
		let param = url.indexOf("?");
		if( param > 0 ) {
			url = url.slice(0,param);
		}
		$('#redirect').val(url);
	});
	//Kjør login hvis dette er angitt i URL-parameter
	if ( urlParams.login !== undefined )
	{
		// Kall pålogging
		$('#loginModal').modal('show');
	}
}	

// Viser kartet (callback-function til Google Javascript API)
function initMap()  
{
	let center = new google.maps.LatLng(58.965,5.729);
	parkMap = new google.maps.Map( $("#map")[0], {
		zoom: 14,
		center: center,
		mapTypeId: 'roadmap'
	});
}

function setupCarDialog( targetobj )
{
	let car = $.grep(carInfo[0], function(e){ return e.id == parseInt($(targetobj).data("id")); })[0];  	//Hent ut aktuelt element fra carInfo-tabellen basert på bilens ID
	$("#carInfoModal .modal-title").text("Bil #" + car.id );
	$("#bilinfo-type").val(car.model_type);
	$("#bilinfo-merke").val(car.maker+" "+car.model);
	$("#bilinfo-aar").val(car.model_year);
	$("#bilinfo-seter").val(car.num_pass);
	$("#bilinfo-last").val(car.capasity);
	$("#bilinfo-kost").val(car.cost);
	if( car.description !== null ) {
		$("#bilinfo-beskrivelse").val(car.description);
	}
	$("#bilinfo-bilde").attr( "src", "img/car"+car.id+".jpg" );
}
function initCarDialog( targetobj )
{
	// Modal dialog for info om bil
	if ( targetobj === null )
	{
		$('#carInfoModal').on('show.bs.modal', function (ev) {
			setupCarDialog( $(ev.relatedTarget) );
		});
	}
	else
	{
		$(targetobj).click( function (ev) {
			setupCarDialog( $(ev.currentTarget) );
			$('#carInfoModal').modal('show');
		});
	}
}

// Sett opp visning av biler på kartet og i tabellen
function initCars()
{
	// Hent info om biler og plasser tilgjengelige biler på kartet (via callback-function)
	getCarInfo( showCarPositions );
	
	// Sett opp sorteringsmulighet i tabellen for biler
	$("#cartable").tablesorter( { sortList: [[0,0], [1,0]] } );
	
	// Sett på riktig farge på biltype i tabellen
	$("#cartable span.glyphicon").each( function(i,val) {
		$(this).css( "color", $.grep(CAR_COLORS, function(e){ return e.id === $(val).data("type"); })[0].color );
	});
}

// Sett opp tilgjengeligheten til alle biler
function initCarAvail()
{
	// Hent info om biler og vis tilgjenghet i en tabell (via callback-function)
	getCarInfo( showCarAvailability );
}

// Sett opp håndtering av booking av bil
function initCarBooking()
{
	// Må hente brukerdata for å kunne sjekke saldo ved bestilling (hvis ikke brukersesjon: silent fail)
	getMember();
	
	// Submit av bestilling
	$("#carOrder").click( function(ev) { 
		bookCar( $("#bil-id").val(), $("#bil-fra-dato").val(), $("#bil-dager").val(), $("#bil-kost").val() );
	});
	$('#carModal').on('hidden.bs.modal', function () {
		//Last siden som kalte dialogen på nytt (data kan ha blitt oppdatert)
		window.location.reload();
    });
}

// Sett opp håndtering av form for medlemsdata (både om vi har en bruker, eller ikke)
function initMember( redirect )
{
	let user = (userInfo.userid !== undefined);
	if ( user )
	{
		/*** Vi har en pålogget bruker: Hent data, sett opp navigasjon og alle dialoger ***/
		
		// Hent alle brukers bookinger og vis disse (via callback-function)
		getUserBookings( showUserBookings );
	
		// Hent alle brukers historikk og vis disse (via callback-function)
		getUserHistory( showUserHistory );
	
		// Vis aktuell side i panel
		$("#"+$(".nav.nav-pills li.active").data("nav")).show();
	
		// Init av side-navigasjon
		$(".nav.nav-pills li").click( function() {
			//Skjul elementet som aktiv navigasjon peker til (data-attributten "nav") og sett nav-elementet inaktivt
			$("#"+$(".nav.nav-pills li.active").data("nav")).hide();
			$(".nav.nav-pills li.active").removeClass("active");
			//Vis elementet som ny navigering peker til (data-attributten "nav") og sett nav-elementet aktivt
			$(this).addClass("active");
			$("#"+$(this).data("nav")).show();
		});
	}
	else
	{
		/*** Ingen pålogget bruker: Vis form for å registrere bruker ***/
		$("#member-form").show();
	}
	
	/*** Felles: Form for userinfo ***/
	
	// Sett eventuell redirect URL som bruker skal sendes til etter submit
	if ( redirect !== undefined && redirect !== "" ) {
		$("#redirect_user").val(redirect);
	}

	//Håndtering av kredittkort (bruker payform plugin)
	initCreditCard();			
	
	// Sett fokus til første felt
	$("#navn").focus();
	
	// Klikk på knapper for forrige/neste
	$("#next1").click( function(ev) {
		ev.preventDefault();
		//Sjekk dataene
		if( checkMember() )
		{
			//Gå videre til neste steg
			$("#step1").hide();
			$("#step2").show();	
			$("#username").focus();
		}
	});
	$("#submit1").click( function(ev) {
		ev.preventDefault();
		//Sjekk dataene
		if ( checkMember() ) {
			$("#member-form").submit();
		}
	});
	$("#next2").click( function(ev) {
		ev.preventDefault();
		//Sjekk dataene
		if ( checkUser() ) 
		{
			//Gå videre til siste steg
			$("#step2").hide();	
			$("#step3").show();	
			$("#owner").focus();
		}
	});
	$("#prev2").click( function(ev) {
		ev.preventDefault();
		//Sjekk dataene
		if ( checkUser() ) 
		{
			$("#step2").hide();	
			$("#step1").show();	
			$("#navn").focus();
		}
	});
	$("#submit2").click( function(ev) {
		ev.preventDefault();
		//Sjekk dataene
		if ( checkUser() ) {
			$("#member-form").submit();
		}
	});
	$("#prev3").click( function(ev) {
		ev.preventDefault();
		//Sjekk dataene
		if ( checkCreditCard() ) 
		{
			$("#step3").hide();	
			$("#step2").show();	
			$("#username").focus();
		}
	});	
	$("#submit3").click( function(ev) {
		ev.preventDefault();
		//Sjekk dataene
		if ( checkCreditCard() ) {
			$("#member-form").submit();
		}
	});	
}