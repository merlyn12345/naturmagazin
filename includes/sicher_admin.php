<?php
$rolle_erlaubt = 'admin';
$loginScript = "index.php";
// generiere eine boolsche variable je nachdem ob eingeloggt oder nicht

// hat sich die ip geaendert?
$notLoginIp = isset($_SESSION["login_ip_address"]) && ($_SESSION["login_ip_address"] != $_SERVER['REMOTE_ADDR']);
// alles in ordnung?
if( !isset($_SESSION['aut_user'])){
	// nicht authentifiziert
	$_SESSION['login_error'] = "Sie sind nicht angemeldet f&uuml; den Zugriff auf: URL". $_SERVER['REQUEST_URI'];
	// zurueck zum login
	header("Location: " . $loginScript);
	exit;
}
else{
	
	if(!in_array($rolle_erlaubt, $_SESSION['rollenbeschreibung'])){
		
		$_SESSION['login_error'] = "Sie sind nicht autorisiert f&uuml; den Zugriff auf: URL". $_SERVER['REQUEST_URI'];
		header("Location: index.php");
		exit;
		
	}	
}


?>
