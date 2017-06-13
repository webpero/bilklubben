<?php 
	include "consts.php";
	session_destroy();
	/* Redirect to home page */
	echo "<script>window.location.href = '".HOME_URL."'</script>";
?>
