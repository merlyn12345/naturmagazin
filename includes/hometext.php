<?php
$fail_login = '';
$login_error = '';
$phpEx = 'php';
$user_id ='';
$fehler = false;
$id = '';
$headline = '';
$text = '';
$fehlermeldung = 'Es ist ein Fehler bei der Verarbeitung aufgetreten: <br />';


### Id des Posts einlesen und ueberpruefen

	$sql="SELECT id, introtext FROM intro";
	if (!($res = $db->sql_query($sql)))
	{
	    $fehler = true;
	    $fehlermeldung .= 'Es wurde keine Galerie zur Id '.$galerie_id.' gefunden <br /> ';
	    print_r($db->sql_error());
	}
	else
	{
	    if($tabdata=$db->sql_fetchrow()) {
		$id = $tabdata['id'];
		$introtext = $tabdata['introtext'];
	    }
	    else{
		$fehler = true;
		$fehlermeldung .= 'Es wurde keine Galerie zur Id '.$id.' gefunden <br /> ';
	    }
	    
	    
	}

    

if(isset ($_POST['id']) && !empty($_POST['id'])){
    $id = intval($_POST['id']);
}

### Daten aus versendetem Formular verarbeiten
//wenn alle teile des formulars ausgefuellt sind wird beitrag in die DB geschrieben
if(isset($_POST['introtext'])  && !empty($_POST['introtext']) ){
    $introtext=sauber($_POST['introtext'],50000);
    $sql="UPDATE intro SET introtext = '".$introtext."', date = NOW() WHERE id = ".$id;
    //print $sql;
	if (!($res = $db->sql_query($sql)))
	{
	    $fehler = true;
	    $fehlermeldung .= 'Der Text konnte nicht geaendert werden <br /> ';
	    print_r($db->sql_error());
	}
	else{
	      header('Location: index.php?id=24');
	}
  
}
if($fehler){
    $tpl->setCurrentBlock('fehlerausgabe');
    $tpl->setVariable('fehlermeldung',  $fehlermeldung);
    $tpl->parseCurrentBlock();
}

## Formularbearbeitung Ausgabe per Template-Klasse
if(isset($_POST['introtex']) &&  empty($_POST['introtext'])){


	    	if(empty($_POST['introtext'])){
		$tpl->setCurrentBlock('text_error');
		$tpl->setVariable('text_errortext', 'Bitte einen Text eingeben!');
		$tpl->parseCurrentBlock();
	}
}
$tpl->setCurrentBlock('formular');
$tpl->setVariable('id', $id);
if(isset($_POST['introtext']) && empty($_POST['introtext']) ){

	if(empty($_POST['introtext'])){
		$tpl->setVariable('error_text', '#ff0000');
	}
	else{
		$tpl->setVariable('introtext', $_POST['introtext']);
	}
	
}
else{
	$tpl->setVariable('error_head', '#ffffff');
	
	$tpl->setVariable('error_text', '#ffffff');
	$tpl->setVariable('introtext', $introtext);
}

?>