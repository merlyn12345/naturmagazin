<?php
$fehlermeldung='Es ist folgender Fehler aufgetreten:';
$fehler=false;
$username='';
$email='';
$passwd='';
$id='';
require_once 'ini.php';
require_once 'includes.php';

if(isset($_POST['username'])) {
    $username=sauber($_POST['username'],12);
    $passwd=sauber($_POST['passwd'],12);
    $email=sauber($_POST['email'],50);
    if(empty($username)){
	$fehler=true;
	$fehlermeldung .= 'der Username wurde nicht ausgefüllt <br />';
    }
        if(empty($email)){
	$fehler=true;
	$fehlermeldung .= 'die Email wurde nicht ausgefüllt <br />';
    }
        if(empty($passwd)){
	$fehler=true;
	$fehlermeldung .= 'das Passwort wurde nicht ausgefüllt <br />';
    }

    if(!$fehler){

	$confirm = md5(uniqid(rand()));
	$passwd = sha1($passwd);

	$sql="INSERT INTO user (username, passwd, email, confirm) VALUES ('".$username."', '".$passwd."', '".$email."','".$confirm."')";
	if ( !($res = mysqli_query($db->db_connect_id, $sql)) ){
		print(mysqli_error());
		die("Fehler, kann Datenbank nicht abfragen");
	}
	$id=mysqli_insert_id($db->db_connect_id);
	$sql="INSERT INTO user_rollen (user_id, rollen_id) VALUES ('".$id."', '1')";
	if ( !($res = mysqli_query($db->db_connect_id, $sql)) ){
		print(mysql_error());
		die("Fehler, kann Datenbank nicht abfragen");
	}
	mysqli_close($db->db_connect_id);
        
	//Mail erzeugen
	$sender = "postmaster@localhost.de";
	$empfaenger = $email;
	$betreff = "Registrierung beim Blog 'Projekt' bestaetigen";
	$mailtext = "Hallo $username, Sie wurden unter dieser Mailadresse auf der Website 'Projekt' registriert. Bitte folgen Sie dem untenstehenden Link um die Email-Adresse zu bestaetigen.\n";
	$mailtext .="Sollten sie sich nicht selbst angemeldet haben, dann ignorieren Sie diese Mail einfach.\n\n";
	$mailtext .="Link: http://127.0.0.1/blog_rbac/confirm.php?confirm=$confirm \n\n";
	if(!mail($empfaenger, $betreff, $mailtext, "From: $sender ")){
	#####################################################
	# alternativ: datei schreiben
		$datei = 'bestaetigung.html'; 
		
		$dateitext='<html><head><title>Bestaetigungsmail</title></head><body>'.$mailtext;
		$dateitext .= '<br /><br /><a href="http://127.0.0.1/blog_rbac/confirm.php?confirm='.$confirm.'">http://127.0.0.1/blog_rbac/confirm.php?confirm='.$confirm.'</a>';
		$dateitext .= '</body></html>';
		$fp=fopen($datei, 'w+');
		$erfolg = fwrite($fp, $dateitext);
		fclose($fp);
	}
	}	

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="projekt.css" type="text/css" media="all"/>
<title>Home</title></head>
<body>
<?php
if(!isset($_POST['username']) || $fehler){
	if($fehler){
		echo $fehlermeldung;
	}
?>
	<form action="regi.php" method="post">
	<table>
	<tr>
	<td>Username</td>
	<td><input type="text" name="username" size="12" maxlength="12" /></td>
	</tr>
	<tr>
	<td>Passwort</td>
	<td><input type="password" name="passwd" size="12" maxlength="12" /></td>
	</tr>
	<tr>
	<td>Email</td>
	<td><input type="text" name="email" size="12" maxlength="30" /></td>
	</tr>
	</table>
	<p><input type="submit" name="login" value="registrieren"/></p>
	<p><strong><a href="index.php">Abbrechen</a></strong></p>
	</form>
<?php
}
?>
 </body>
</html>


