    <!-- Fixed navbar -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Bytt navigasjon</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">Bilklubben AS</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Forsiden</a></li>
					<li><a href="finn.php">Finn bil</a></li>
					<li><a href="medlem.php">Medlem</a></li>
					<li><a href="siste.php">Siste nytt</a></li>
					<li><a href="om.php">Om Bilklubben</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right"> 
<?php 
/***** Brukerprofil ELLER Logg inn *****/
if ( isset($_SESSION['username']) && $_SESSION['username'] != "" )
{
	echo "<li><a href='medlem.php'><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;".$_SESSION['username']."</a></li>\n";
}
else
{
	echo "<li><button data-toggle='modal' data-target='#loginModal' class='btn btn-primary btn-md'><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Logg inn</button></li>\n";
}
?>
				</ul>
			</div>
		</div>
	</nav>