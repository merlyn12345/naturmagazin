<?php
$fail_login = '';
$login_error = '';
$phpEx = 'php';
$user_id ='';
#####################################
#IT
#

### Daten aus versendetem Formular verarbeiten
//wenn alle teile des formulars ausgefuellt sind wird beitrag in die DB geschrieben
if(isset($_POST['titel']) && isset($_POST['text'])  && !empty($_POST['titel']) && !empty($_POST['text']) ){
    $titel=sauber($_POST['titel'],200);
    $text=sauber($_POST['text'],5000);
    $sql="INSERT INTO galerien(titel, text, date) VALUES ('".$titel."','".$text."', NOW())";
    //print $sql;

if (!($res = $db->sql_query($sql)))
{
	print_r($db->sql_error());
	print $sql;
}
else{
    
    

    	$id=mysql_insert_id();
	$sql="INSERT INTO seiten (rollen_id, title, loadphp, loadhtml, created, user_id, galerie_id, publish) VALUES ('1', '".$titel."','galeriecontent','galeriecontent', NOW(), '1', '".$id."','1')";
	if (!($res = $db->sql_query($sql)))
	{
	print_r($db->sql_error());
		die("Fehler, kann Datenbank nicht abfragen");
	}
	 $id=mysql_insert_id();
	$sql="INSERT INTO lin_menue (text, url, rollen_id, topdown , view, seiten_id) VALUES ('".$titel."','index','1', '20', '1',  '".$id."')";
	if (!($res = $db->sql_query($sql)))
	{
	print_r($db->sql_error());
		die("Fehler, kann Datenbank nicht abfragen");
	}
    
    header('Location: index.php?id=14');
    exit;
    
    }
}

## Formularbearbeitung Ausgabe per Template-Klasse
if(isset($_POST['titel']) && (empty($_POST['titel']) || empty($_POST['text']))){

    	if(empty($_POST['titel'])){
		$tpl->setCurrentBlock('headline_error');
		$tpl->setVariable('headline_errortext', 'Bitte einen Titel angeben!');
		$tpl->parseCurrentBlock();
	}
	    	if(empty($_POST['text'])){
		$tpl->setCurrentBlock('text_error');
		$tpl->setVariable('text_errortext', 'Bitte einen Text eingeben!');
		$tpl->parseCurrentBlock();
	}
}
$tpl->setCurrentBlock('formular');
if(isset($_POST['titel']) && (empty($_POST['titel']) || empty($_POST['text']) )){
	if(empty($_POST['titel'])){

		$tpl->setVariable('error_head', '#ff0000');
	}
	else{
		$tpl->setVariable('titel', $_POST['titel']);
	}

	if(empty($_POST['text'])){
		$tpl->setVariable('error_text', '#ff0000');
	}
	else{
		$tpl->setVariable('text', $_POST['text']);
	}
}
else{
	$tpl->setVariable('error_head', '#ffffff');
	$tpl->setVariable('titel', '');
	$tpl->setVariable('error_text', '#ffffff');
	$tpl->setVariable('text', '');
}
//$tpl->parseCurrentBlock();
//$tpl->show();
?>