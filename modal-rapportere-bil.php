	<!-- Senede inn rapport på bil -->
	<div id="carReportModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="" method="post">
						<div class="form-group">
							<label for="report-car_id" class="col-sm-3 control-label">* Bil #:</label>
							<div class="col-sm-3">
								<input  class="form-control" name="report-car_id" id="report-car_id" type="number" disabled />
							</div>
						</div>
						<div class="form-group" >
							<label for="report-cat" class="col-sm-3 control-label">* Kategori:</label>
							<div class="col-sm-6 required">
								<select class="form-control" id="report-cat" name="report-cat">
									<option value="Mangel" selected>Mindre feil/mangel</option>
									<option value="Feil">Alvorlig feil - Må rettes!</option>
									<option value="Renhold">Dårlig renhold</option>
									<option value="Annet">Annet</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="report-msg" class="col-sm-3 control-label">* Din melding:</label>
							<div class="col-sm-9 required">
								<textarea class="form-control" rows="6" id="report-msg" name="report-msg"></textarea>
							</div>
						</div>
					</form>					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Lukk</button>
					<button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-send' aria-hidden='true'></span>&nbsp;&nbsp;Send inn</button>
				</div>
			</div>
		</div>
	</div>
