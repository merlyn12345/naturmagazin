<?php
include $params['paths']['includes'].'sicher_user.php';
$phpEx = 'php';
$fehler = false;
$id = '';
$beschreibung = '';
$fehlermeldung = 'Es ist ein Fehler bei der Verarbeitung aufgetreten: <br />';
$path = $params['paths']['images'];
 

#######################################


### Id des Posts einlesen und ueberpruefen
if(isset ($_GET['bild_id']) && !empty($_GET['bild_id'])){
    $bild_id = clean_int($_GET['bild_id']);
    $bild_id = intval($_GET['bild_id']);
    if(! is_int($bild_id)){
	$fehler = true;
	$fehlermeldung .= 'Die Id muss eine ganze Zahl sein. <br /> ';
    }
    else{
	$sql="SELECT id, url, del, beschreibung, galerien_id FROM images WHERE id = ".$bild_id;
	if (!($res = $db->sql_query($sql)))
	{
	    $fehler = true;
	    $fehlermeldung .= 'Es wurde kein Bild zur Id '.$bild_id.' gefunden <br /> ';
	    print_r($db->sql_error());
	}
	else
	{
	    if($tabdata=$db->sql_fetchrow()) {
		$bild_id = $tabdata['id'];
		$url = $tabdata['url'];
		$del = $tabdata['del'];
		$beschreibung = $tabdata['beschreibung'];
		$galerien_id = $tabdata['galerien_id'];
	    }
	    else{
		$fehler = true;
		$fehlermeldung .= 'Es wurde kein Bild zur Id '.$bild_id.' gefunden <br /> ';
	    }
	    
	    
	}

    }
}
else{
   // $fehler = true;
   // $fehlermeldung .= 'Es wurde keine Id uebergeben';
}
if(filter_input(INPUT_POST, 'bild_id', FILTER_VALIDATE_INT)){
    $bild_id = filter_input(INPUT_POST, 'bild_id', FILTER_VALIDATE_INT);
}

### Daten aus versendetem Formular verarbeiten
//wenn alle teile des formulars ausgefuellt sind wird beitrag in die DB geschrieben
if(isset($_POST['bild_id'])  ){
  
    $beschreibung=filter_input(INPUT_POST, 'beschreibung', FILTER_SANITIZE_STRING);
    $bild_id = filter_input(INPUT_POST, 'bild_id', FILTER_VALIDATE_INT);
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
    ///########## Bild löschen############################
    $del =0;
    if (isset( $_POST['del'])){
	$del = filter_input(INPUT_POST, 'del', FILTER_VALIDATE_INT);
        if(1==$del){
            $sql="DELETE FROM images WHERE images.id = ".$bild_id;
            //print $sql;
                if (!($res = $db->sql_query($sql)))
                {
                    $fehler = true;
                    $fehlermeldung .= 'Das Bild konnte nicht gelöscht werden <br /> ';
                    print_r($db->sql_error());
                }
                else{
                    ## Bild aus Dateisystem löschen

                    if(is_file($params['paths']['images'].$url)){
                        unlink($params['paths']['images'].$url);
                    }
                    if(is_file($params['paths']['thumbnail'].$url)){
                        unlink($params['paths']['thumbnail'].$url);
                    }                    
                      header('Location: index.php?id=25');
                }            
        }
    }else{
    
    $galerien_id = $_POST['galerie'];
  
    $sql="UPDATE images SET beschreibung ='".$beschreibung."', del = '".$del."', galerien_id = '".$galerien_id."' WHERE images.id = ".$bild_id;
    //print $sql;
	if (!($res = $db->sql_query($sql)))
	{
	    $fehler = true;
	    $fehlermeldung .= 'Das Bild konnte nicht geaendert werden <br /> ';
	    print_r($db->sql_error());
	}
	else{
	      header('Location: index.php?id=25');
	}
    }
  
}
if($fehler){
    $tpl->setCurrentBlock('fehlerausgabe');
    $tpl->setVariable('fehlermeldung',  $fehlermeldung);
    $tpl->parseCurrentBlock();
}



## Formularbearbeitung Ausgabe per Template-Klasse
#### Galerien select generieren

$sql="SELECT galerien.id AS galerien_id, galerien.titel AS galerien_titel, ausgabe FROM galerien, seiten WHERE publish=1 AND seiten.galerie_id=galerien.id ORDER BY galerien.id DESC";

if (!($res = $db->sql_query($sql)))
{
	print_r($db->sql_error());
	print $sql;
}
else{
    	while($tabdata = $db->sql_fetchrow($res)) 
	{

	$tpl->setCurrentBlock("galerie") ;
	foreach($tabdata as $key => $cell){
		$tpl->setVariable($key, $cell);
                //var_dump($galerien_id);
                //var_dump($key);
                //var_dump($cell);
                if($key=='galerien_id'  && $cell==$galerien_id){
                    
                    $tpl->setVariable('selected', ' selected="selected" ');
                }
	}
	$tpl->parseCurrentBlock("galerie") ;


	}
	$tpl->setCurrentBlock("row") ;
	$tpl->parseCurrentBlock("row") ;
}


###   Formular rest
$tpl->setCurrentBlock('formular');
$tpl->setVariable('bild_id', $bild_id);
$tpl->setVariable('path', $path);
$tpl->setVariable('url', $url);


if(1 == $del){
    $deltext='gelöscht';
    $delimage = 'pics/publish_x.png';
    $checked = 'checked="checked"';
}
else{
    $deltext='verwendet';
    $delimage = 'pics/tick.png';
    $checked = '';
}
$tpl->setVariable('checked', $checked);
$tpl->setVariable('delimage', $delimage);
$tpl->setVariable('deltext', $deltext);
$tpl->setVariable('error_text', '#ffffff');
$tpl->setVariable('beschreibung', $beschreibung);

$tpl->parseCurrentBlock();

?>