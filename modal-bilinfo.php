	<!-- Informasjon om en bil -->
	<div id="carInfoModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					  <div class="form-group">
						<label for="bilinfo-type" class="col-sm-4 control-label">Type</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="bilinfo-type" disabled />
						</div>
					  </div>
					  <div class="form-group">
						<label for="bilinfo-merke" class="col-sm-4 control-label">Merke</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="bilinfo-merke" disabled />
						</div>
					  </div>
					  <div class="form-group">
						<label for="bilinfo-aar" class="col-sm-4 control-label">Årsmodell</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="bilinfo-aar" disabled />
						</div>
					  </div>
					  <div class="form-group">
						<label for="bilinfo-seter" class="col-sm-4 control-label">Seter</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="bilinfo-seter" disabled />
						</div>
					  </div>
					  <div class="form-group">
						<label for="bilinfo-last" class="col-sm-4 control-label">Last (liter)</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="bilinfo-last" disabled />
						</div>
					  </div>
					  <div class="form-group">
						<label for="bilinfo-kost" class="col-sm-4 control-label">Kost/døgn (poeng)</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="bilinfo-kost" disabled />
						</div>
					  </div>
					  <div class="form-group">
						<label for="bilinfo-beskrivelse" class="col-sm-4 control-label">Ekstra info</label>
						<div class="col-sm-6">
						  <textarea rows=3 class="form-control" id="bilinfo-beskrivelse" disabled></textarea>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-8">
						  <img class="img-responsive img-rounded" id="bilinfo-bilde"/>
						</div>
					  </div>
					</form>					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Lukk</button>
				</div>
			</div>
		</div>
	</div>
