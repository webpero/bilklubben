	<!-- Bestill bil -->
	<div id="carModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<!-- Tittel (settes ved kall på dialogen) -->
					<h4 class="modal-title" id="bil-info"></h4>
				</div>
				<div class="modal-body">
					<!-- Bilde av bilen -->
					<img id="bil-bilde" src="" />
					
					<!-- Viser data for bekreftelse (kan ikke endres) -->
					<form class="form-horizontal">
						<div class="form-group">
							<label for="bil-fra-dato" class="col-sm-4 control-label">Fra dato:</label>
							<div class="col-sm-4">
								<input  class="form-control" name="fra-dato" id="bil-fra-dato" type="date" disabled />
							</div>
						</div>
						<div class="form-group">
							<label for="bil-dager" class="col-sm-4 control-label">Til dato:</label>
							<div class="col-sm-4">
								<input class="form-control" name="til-dato" id="bil-til-dato" type="date" disabled />
							</div>
						</div>
						<div class="form-group">
							<label for="bil-dager" class="col-sm-4 control-label">Antall dager:</label>
							<div class="col-sm-3">
								<input class="form-control" name="dager" id="bil-dager" type="number" disabled />
							</div>
						</div>
						<div class="form-group">
							<label for="bil-kost" class="col-sm-4 control-label">Kostnad (poeng):</label>
							<div class="col-sm-3">
								<input class="form-control" name="kost" id="bil-kost" type="number" disabled />
							</div>
						</div>
						<div class="form-group">
							<label for="bil-saldo" class="col-sm-4 control-label">Saldo etter lån (poeng):</label>
							<div class="col-sm-3">
								<input class="form-control" name="saldo" id="bil-saldo" type="number" disabled />
							</div>
						</div>
						<input name="id" id="bil-id" type="hidden">
					</form>
					
					<!-- Tilbakemelding fra booking-tjenesten -->
					<p class="bg-info bg-melding" id="bil-ok"></p>
					<p class="bg-warning bg-melding" id="bil-error"></p>
				</div>
				<div class="modal-footer">
					<a role="button" class="btn btn-default pull-left" href="finn.php" id="leie-flere-dager">Leie flere dager <span class="glyphicon glyphicon-calendar"></span></a>
					<a role="button" class="btn btn-primary pull-left" href="" id="innskudd">Gjør et innskudd <span class="glyphicon glyphicon-credit-card"></span></a>
					<a role="button" class="btn btn-primary no-user pull-left" href="medlem.php">Bli medlem <span class='glyphicon glyphicon-road' aria-hidden='true'></span></a>
					<a role="button" class="btn btn-primary no-user pull-left" href="?login">Logg inn <span class="glyphicon glyphicon-user"></span></a>
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Lukk</button>
					<button type="button" class="btn btn-primary" id="carOrder"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Bestill</button>
				</div>		
			</div>
		</div>
	</div>
