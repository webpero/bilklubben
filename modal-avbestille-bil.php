	<!-- Avbestilling av bil -->
	<div id="carCancelModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="set-cancel-car-booking.php" method="post">
						<div class="form-group">
							<label for="cancel-date" class="col-sm-4 control-label">Dato:</label>
							<div class="col-sm-4">
								<input  class="form-control" name="cancel-date" id="cancel-date" type="date" disabled />
							</div>
						</div>
						<input name="car_id" id="car_id" type="hidden">
						<input name="res_id" id="res_id" type="hidden">
					</form>					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Lukk</button>
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ban-circle"></span>&nbsp;&nbsp;Avbestill</button>
				</div>
			</div>
		</div>
	</div>
