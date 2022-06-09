<?php
$image_borderwidth=50;
$wholewidth=0;
$error_string='';
if (! isset($_GET['offset']) || empty($_GET['offset'])){
	$offset = 0;
}
else{
	$offset = (int)$_GET['offset'];
}
if (! isset($_GET['galerie_id']) || empty($_GET['galerie_id'])){
	$error_string='keine Galerie gefunden';

}
else{
	$galerie_id = (int)$_GET['galerie_id'];
	if (!$galerie_id){
	    $error_string='keine Galerie gefunden';
	}
	    
}
if(!$error_string){
    //gesamtberite ermitteln
    $sql="SELECT text AS intro, COUNT(*) AS anzahl, SUM(breite) AS bilderbreite FROM galerien, images WHERE galerien.id = ".$galerie_id." AND images.galerien_id=galerien.id";
    if (!($res = $db->sql_query($sql)))
    {
	    print_r($db->sql_error());
	    print $sql;
    }
    else{
	    $breitendata = $db->sql_fetchrow($res);

	    $wholewidth = $breitendata['bilderbreite'] + $breitendata['anzahl']*$image_borderwidth +50+375;

	    $intro = $breitendata['intro'];
	    $tpl->setCurrentBlock("TEXT") ;
	    $tpl->setVariable('wholewidth', $wholewidth) ;
	    $tpl->setVariable('intro', $intro) ;
	    $tpl->parseCurrentBlock("TEXT") ;



    }

    //alle posts aus DB holen

    $sql="SELECT url, breite, hoehe, beschreibung AS caption, topdown FROM galerien, images WHERE galerien.id = ".$galerie_id." AND images.galerien_id=galerien.id AND images.del=0";


    if (!($res = $db->sql_query($sql)))
    {
	    print_r($db->sql_error());
	    print $sql;
    }

    else
    {
    ### bei unterschiedlichen  seiten kategorien kann hier noch ein oder mehrere parameter mitgegebn werden
	$browseString = 'id='.$id;
    }
    // wieviele Ergebniszeilen?
    $rowsFound = $db->sql_numrows($res);
    $keine = '';
    // Gibt es ein Ergebnis?
    if ($rowsFound != 0)
    {
	    // ja.
	    // Suche bis zum aktuellen offset
	    if (!$db->sql_rowseek($offset, $res))
	    {
		    echo 'Fehler2: ';
		    print_r($db->sql_error());
		    print $sql;
		    print mysql_error();
	    }

	    //  eine Seite ausgeben, oder weniger wenn letzte seite
	    for ( $rowCounter = 0;($rowCounter < $ROWS+$leer) && ($tabdata = $db->sql_fetchrow($res)) ; $rowCounter++)
	    {

	    $tpl->setCurrentBlock("cell") ;
	    foreach($tabdata as $key => $cell)
	    {
		    if($key == 'breite'){
			$divwidth= $cell +50;
			$tpl->setVariable('divwidth', $divwidth) ;
		    }

		    $tpl->setVariable($key, $cell) ;
	    }
	    $tpl->parseCurrentBlock("cell") ;


	    }
	    $tpl->setCurrentBlock("row") ;
	    $tpl->parseCurrentBlock("row") ;
	    // ende tabelle und fusszeile
	    //  angezeigte zeilen




    } // wenn keine gefunden
    else
    {
	    $keine= 'keine';
	    $rowCounter = 0;
    }
}
else{
    	    $tpl->setCurrentBlock("error") ;
	     $tpl->setVariable('fehlertext', $error_string) ;
	    $tpl->parseCurrentBlock("error") ;
}

$db->sql_close();


?>