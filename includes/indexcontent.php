<?php

//alle posts aus DB holen
$leer =0;
$offset=0;
$sql="SELECT introtext FROM intro WHERE publish=1 ORDER BY id DESC";

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

	$tpl->setCurrentBlock("text") ;
	foreach($tabdata as $key => $cell)
	{
		$tpl->setVariable($key, $cell) ;
	}
	$tpl->parseCurrentBlock("text") ;


	}

	// ende tabelle und fusszeile
	//  angezeigte zeilen



} // wenn keine gefunden
else
{
	$keine= 'keine';
	$rowCounter = 0;
}
//$tpl->setVariable("keine", $keine) ;
//$tpl->parseCurrentBlock("browse") ;

$db->sql_close();


?>