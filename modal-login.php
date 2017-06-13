	<!-- Innlogging -->
	<div id="loginModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Logg inn til Bilklubben</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="login.php" method="post">
					  <div class="form-group">
						<label for="username" class="col-sm-2 control-label">Brukernavn</label>
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="username" name="username" placeholder="Brukernavn" />
						</div>
					  </div>
					  <div class="form-group">
						<label for="password" class="col-sm-2 control-label">Passord</label>
						<div class="col-sm-10">
						  <input type="password" class="form-control" id="password" name="password" placeholder="Passord" />
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Logg inn</button>
						</div>
					  </div>
					  <!-- Redirect etter innlogging (settes fra kallstedet) -->
					  <input type='hidden' name='redirect' id='redirect' />
					</form>					
				</div>
				<div class="modal-footer">
					<span class="pull-left">Ikke medlem?&nbsp;&nbsp;<a class="btn btn-primary btn-md" href="medlem.php" role="button">Bli med i dag <span class="glyphicon glyphicon-road"></span></a></span>
				</div>
			</div>
		</div>
	</div>
