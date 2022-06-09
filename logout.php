<?php
	// alle Sessions werden geloescht und der nutzer unangemeldet zur startseite geleleitet
	session_start();
	session_destroy();
	header("location: index.php")
	
?>
