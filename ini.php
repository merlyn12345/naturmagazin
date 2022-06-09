<?php
/***************************************************************************
 *                                ini.php
 *                            -------------------
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

define('INI_LOADED', true);
$dbms = 'mysql';
$phpEx = 'php';
//test im prod-betrieb auskommentieren
$test = false;
$ROWS=150;



if (isset($test)) 
{
  error_reporting(E_ALL | E_NOTICE | E_DEPRECATED | E_STRICT);
}
else{
  error_reporting(0);
}
/*---------------------------------------------------------------
* Auf lokalem Testserver laufen lassen
* Fuer Produktionsbetrieb auskommentieren
---------------------------------------------------------------*/
//$testserver='localhost';
//$testserver='server00x.webpack.hosteurope.de';

/*---------------------------------------------------------------
* Debug Modus
* Ausgabe am Seitenende von
* GET und POST Variablen, SMTP-Prozedur bei Mailversand
* Fuer Produktionsbetrieb auskommentieren
---------------------------------------------------------------*/
$debug='
<div id="debug" style="position:absolute;left:20;top:1200;z-index:100">
Page-Info:<br>';

/*---------------------------------------------------------------
* 1. MySQL-Zugang
* Geben Sie hier die Zugangsdaten zu Ihrer Datenbank ein.
---------------------------------------------------------------*/
if (isset($testserver)) {
  if ($testserver=='server00x.webpack.hosteurope.de') {
  	$params['db']['host'] = '';
  	$params['db']['user'] = '';
  	$params['db']['passwd'] = '';
  	$params['db']['name'] = '';
  }
  else {
  	$params['db']['host'] = 'localhost';
  	$params['db']['user'] = 'root';
  	$params['db']['passwd'] = '1dwidz2';
  	$params['db']['name'] = 'naturmagazin';
  }
}
else {
  	$params['db']['host'] = 'rdbms.strato.de';
  	$params['db']['user'] = 'dbu1556333';
  	$params['db']['passwd'] = 'lascar-neon-rancho';
  	$params['db']['name'] = 'dbs3523574';
}

/*---------------------------------------------------------------
* 2. Verzeichnis- und Dateipfade
* Passen Sie die Verzeichnis-Pfade an Ihr System an.



---------------------------------------------------------------*/
$params['paths']['root'] = "./";
$params['paths']['includes'] = $params['paths']['root']. 'includes/';
$params['paths']['images'] = $params['paths']['root']. 'images/';
$params['paths']['thumbnail'] = $params['paths']['images']. 'thumbnails/TN_';
$params['paths']['avatar'] = $params['paths']['images']. 'avatar/';
$params['paths']['magazine'] = $params['paths']['root']. 'magazine/';

##### Seitenid für einzelmagaine aus dem Archiv

$seiten_id=35;

/*Dateien*/
$file['index']=$params['paths']['root'].'index.php';
//$file['go']=$params['paths'].'go.php';
$file['standard_tpl']='index.tpl.html';


/*---------------------------------------------------------------
 mailadressen 
---------------------------------------------------------------*/

//Automatische Benachrichtigung bei Registrierung
$params['register_mail']['from_addr']='postmaster@localhost';
$params['register_mail']['from_alias']='Webmaster';
$params['register_mail']['reply_to_addr']='';
$params['register_mail']['return_path']='';


/*---------------------------------------------------------------
Tabellennamen in der Datenbank
---------------------------------------------------------------*/
$table_prefix = '';

$params['tables']['posts']=$table_prefix.'posts';
$params['tables']['user']=$table_prefix.'user';
$params['tables']['rollen']=$table_prefix.'rollen';
$params['tables']['user_rollen']=$table_prefix.'user_rollen';
$params['tables']['lin_menue']=$table_prefix.'lin_menue';
$params['tables']['images']=$table_prefix.'images';


?>
