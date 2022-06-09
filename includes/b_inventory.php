<?php
/***************************************************************************
 *                               b_inventory.php
 *                            -------------------
 *   begin                : Samstag 22.11. 2003
 *   copyright            : (C) 2003 The Georg Lange
 *   email                : solutions@polynomic.de
 *
 *
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

include $params['paths']['includes'].'sicher_user.php';

$pic_path = $params['paths']['images'];
$linkwrap_st='<a href="javascript:void(null)" name="';
$linkwrap_en='" onclick="update_main(this.name)">';
define('ROWS', 10);
$leer = 0;
$scriptName = basename($_SERVER['PHP_SELF']);



############## userdaten


$user_name=$_SESSION['aut_user'];
$sql="SELECT * FROM ".$params['tables']['user']." WHERE username='".$user_name."'";
//daten des users werden aus DB geholt
	if (!$res=$db->sql_query($sql)){
		if($test){
			print_r($db->sql_error());
			die("kann die Datenbank nicht abfragen".$sql);
		}
		else{
			die("Zur Zeit keine Verbindung zur Datenbank");
		}
	}
	//daten des users werden aus DB geholt
	$tabdata=$db->sql_fetchrow();
	$user_id=$tabdata['id'];


#####################################
#IT
#
//require_once "includes/IT_mod.php";
/*
  $tpl->setCurrentBlock("ueberschrift") ;
  $tpl->setVariable('username', $user_name) ;
  $tpl->parseCurrentBlock();
 * 
 */
if (! isset($_GET['offset']) || empty($_GET['offset'])){
	$offset = 0;
}
else{
	$offset = (int)$_GET['offset'];
}

$sql = "SELECT b.id, b.url, b.size, b.date, b.user_id, b.breite, b.hoehe,  b.beschreibung FROM ".$params['tables']['images']." b ORDER BY b.date desc";
if (!$res=$db->sql_query($sql)){
	if($test){
		print_r($db->sql_error());
		die("kann die Datenbank nicht abfragen".$sql);
	}
	else{
		die("Zur Zeit keine Verbindung zur Datenbank");
	}
}
else
{

	$browseString = 'id=25&galerie_id=0';

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



###############################AAAALLLLTTTT
for ( $rowCounter = 0;($rowCounter < ROWS) && ($row = $db->sql_fetchrow($res)) ; $rowCounter++)
{
  //  print_r($row);
  $tpl->setCurrentBlock("cell") ;
    // zeile ausgeben
 $schalter=0;
 $groesse=round(($row['size']/1024),1);
 $jahr=substr($row['date'],0,4);
 $monat=substr($row['date'],5,2);
 $tag=substr($row['date'],8,2);
 $stunde=substr($row['date'],11,2);
 $minute=substr($row['date'],14,2);
 $sekunde=substr($row['date'],17,2);
 $datum=$tag.".".$monat.".".$jahr." ".$stunde.":".$minute.":".$sekunde;


$tpl->setVariable('url', $row['url']) ;
$tpl->setVariable('id', $row['id']) ;
$tpl->setVariable('groesse', $groesse) ;
$tpl->setVariable('datum', $datum) ;
$tpl->setVariable('beschreibung', $row['beschreibung']) ;
$tpl->setVariable('breite', $row['breite']) ;
$tpl->setVariable('hoehe', $row['hoehe']) ;
$schalter++;
$tpl->parseCurrentBlock("cell") ;

$tpl->setCurrentBlock("row") ;
$tpl->parseCurrentBlock("row") ;
}

// ende zeilen in der Seite


	// ende tabelle und fusszeile
	//  angezeigte zeilen

	$von = $offset + 1;
	$bis = $rowCounter + $offset;
	$alle = $rowsFound;
	$tpl->setCurrentBlock("browse") ;
	$tpl->setVariable("VON", $von) ;
	$tpl->setVariable("BIS", $bis) ;
	$tpl->setVariable("ALLE", $alle) ;

	/* *********************************************** */

	//  die vorangehende seite faengt mit dem aktuellen offset weniger
	// der anzahl von zeilen an
	$previousOffset = $offset - (ROWS +$leer);
	if ($previousOffset < 0)
	{
		$previousOffset = 0;
	}

	//   die naechst seite faengt mit dem aktuellen offset plus
	// der anzahl von zeilen an
	$nextOffset = $offset + (ROWS +$leer);

	/* *********************************************** */

	// ( vorhergehende seiten?
	if ($offset > 0)
	{
		// ja, also: link
		$zurueck= "<a href=\"" .  $scriptName . "?offset=" . rawurlencode($previousOffset) . "&amp;" . $browseString ."\">zur&uuml;ck</a> ";
	}
	else
	{
		// nein, kein link

		$zurueck= "<span style=\"font-size:10px;font-weight:normal;\">zur&uuml;ck </span>";
		//------seitenzahlen

		// seitenzahlen als links
		// zaehle seiten
	}

	$tpl->setVariable("zurueck", $zurueck) ;
	//  weitere seiten?
	if (($tabdata != false) && ($rowsFound > $nextOffset))
	{
		// ja, also: link
		$vor= "<a href=\"" .  $scriptName ."?offset=" . rawurlencode($nextOffset) . "&amp;" . $browseString . "\">weiter</a> &nbsp;";
	}
	else
	{
		// nein, kein link

		$vor= "<span style=\"font-size:10px;font-weight:normal;\">weiter</span>&nbsp;";
	}
	//echo '</div>';
	$tpl->setVariable("vor", $vor) ;

} // wenn keine gefunden
else
{
	$keine= 'keine';
	$rowCounter = 0;
}
$tpl->setVariable("keine", $keine) ;

$db->sql_close();
?>
