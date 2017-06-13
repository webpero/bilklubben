
<!-- JavaScript rammeverk: jQuery + Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- jQuery Plugins -->
<!-- Tablesorter -->
<script src="jquery.tablesorter.min.js"></script>
<!-- CreditCard -->
<script src="jquery.payform.min.js"></script>

<!-- Lokalt Javascript -->
<script src="cars.js"></script>

<!-- Uthenting av URL-parametere -->
<script>var urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;</script>
