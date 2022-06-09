<?php
session_start();
error_reporting(-1);
if(!isset($_SESSION['rollen_ids'])){
    $_SESSION['rollen_ids']=[];
}
require('ini.php');
require('includes.php');

$pfad='images/';
$tnpfad='images/thumbnails/TN_';
$loginmessage = '';
$fail_login = '';
$seitenvars= array();
$leer = 0;
$scriptName = basename($_SERVER['PHP_SELF']);
$menuearray = array();




if (!filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)){
	$id = 1;
}
else{
	$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
$seite = new seite($params['db']['host'],$params['db']['user'],$params['db']['passwd'],$params['db']['name'] );
$seitenvars=$seite->output($id);

##zugriffsschutz
if(in_array($seitenvars["rollen_id"], $_SESSION['rollen_ids']) || $seitenvars["rollen_id"]=='1'|| $seitenvars["rollen_id"]=='0'){
  $loadhtml=$seitenvars['loadhtml'].'.html';
  $loadphp=$seitenvars['loadphp'].'.'.$phpEx;
}else{
    $seitenvars=$seite->output(1); 
    $loadhtml=$seitenvars['loadhtml'].'.html';
    $loadphp=$seitenvars['loadphp'].'.'.$phpEx;
}



####################### ende seitenobjekt
$tpl = new HTML_Template_ITX('./templates');
$tpl->loadTemplatefile('index.html', true, true);


//########### Menueerweiterung	##################


/*
 *
 SET @c := 0;
UPDATE lin_menue SET topdown = ( SELECT @c := @c + 1 ) ORDER BY id ASC;
 *
 
*/
$menue = new lin_menue($params['db']['host'],$params['db']['user'],$params['db']['passwd'],$params['db']['name'] );
if(isset($_SESSION['rollen_ids']) && in_array('2', $_SESSION['rollen_ids'])){
    $menuearray = $menue -> display('2');
    
    foreach($_SESSION['rollen_ids'] as $rolle){
	//$menuearray = array_merge($menuearray, $menue->display($rolle));
        //$menuearray = array_merge($menuearray, $menue->display($rolle));
    }
}
else{

    //$menuearray = $menue -> display('2');
}
//$menuearray = $menue -> display();
foreach ($menuearray AS $entry){
	$tpl->setCurrentBlock('item');
	foreach($entry as $key => $value){

		if('url' == $key){
			$value = $value.'.'.$phpEx;
			$tpl->setVariable($key, $value);
		}
		if('text' == $key){
			$value = strtoupper($value);
			$tpl->setVariable($key, $value);
		}
		if('seiten_id' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}
		if('galerie_id' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}
		
		
	}
	$tpl->parseCurrentBlock();
	$tpl->setCurrentBlock('Menue');
	$tpl->parseCurrentBlock();
}


### Login-Formular / Meldung
//wenn der user angemeldet ist, dann bekommt er ein div angezeigt =>du bist als bla angemeldet & link zum ausloggen
if(isset($_SESSION['aut_user'])){
	$name=$_SESSION['aut_user'];
	$tpl->setCurrentBlock('logged_in');
	$tpl->setVariable('name', $name);
	$tpl->parseCurrentBlock();
        // Login-Toggle verstecken
 	$tpl->setCurrentBlock('toggleweg');
	$tpl->setVariable('flag', 'verstecken');
	$tpl->parseCurrentBlock();       
}
// wenn der user nicht angemeldet ist, 
elseif(!isset($_SESSION['aut_user'])){
	$tpl->setCurrentBlock('login_form');
//wenn der user nicht berechtigt ist: dann wird message (nicht angemeldet fuer zugriff) ausgeprintet || bei fehlerhafter eingabe (falscher username/passwort)
	
	if (isset($_SESSION['loginmessage'])){
		$loginmessage = $_SESSION['loginmessage'];
		unset($_SESSION['loginmessage']);
	}
	if (isset($_SESSION['fail_login'])){
		$fail_login = $_SESSION['fail_login'];
		unset($_SESSION['fail_login']);
	}
	$tpl->setVariable('fail_login', $fail_login);
	$tpl->setVariable('loginmessage', $loginmessage);
	$tpl->setVariable('login_aufforderung', 'Bitte einloggen');
	$tpl->parseCurrentBlock();
		
}	$tpl->setCurrentBlock("ueberschrift") ;
	$tpl->setVariable('ueberschrift', 'Neueste Beitr&auml;ge');
	$tpl->parseCurrentBlock();	
	//$tpl->touchBlock("ueberschrift") ;
	
####### Archiv direktlinks ##############
$sql="SELECT ausgabe, pdfurl, id AS magazinid FROM galerien ORDER BY voedate DESC LIMIT 4";
    if (!($res = $db->sql_query($sql))){
        if($test){
            echo 'Fehler: '.print_r($db->sql_error());
            echo 'sql: '.$sql;
            exit;
        }    
    }else{
        
        while($datensatz=$db->sql_fetchrow($res)){

            $tpl->setCurrentBlock('archivlink'); 
            $tpl->setVariable('pfad', $params['paths']['magazine']);
            $tpl->setVariable('pdfurl', $datensatz['pdfurl']);
            $tpl->setVariable('magazinid', $datensatz['magazinid']);
            $tpl->setVariable('seiten_id', $seiten_id);
            $tpl->setVariable('ausgabe', $datensatz['ausgabe']);
            $tpl->parseCurrentBlock();
            $tpl->setCurrentBlock('archiv');
            $tpl->parseCurrentBlock();            
        }

    }
    
//########## Headerkram ##################

$sql="SELECT galerien.id AS galerien_id, titel, text, pdfurl, ausgabe, url, positionId, vorschau FROM galerien INNER JOIN images ON galerien.id = images.galerien_id WHERE galerien.del = '0' ORDER BY galerien.voedate DESC LIMIT 1";

if (!($res = $db->sql_query($sql))){
	print_r($db->sql_error());
        echo mysqli_error($db->db_connect_id).'  hä?<br>';
	print $sql;
}


$tabdata = $db->sql_fetchrow($res);

$tpl->setCurrentBlock("header") ;

$tpl->setVariable('ausgabe', $tabdata['ausgabe']);


// Bilder rauspulen
$sql="SELECT url, positionId FROM images WHERE images.galerien_id = '".$tabdata['galerien_id']."'";
if (!($res = $db->sql_query($sql))){
	print_r($db->sql_error());
	print $sql;
}


while($imagedata = $db->sql_fetchrow($res)){

    if($imagedata['positionId'] == 1){
        $titelbild = $imagedata['url'];
    }
    if($imagedata['positionId'] == 2){
        $ausgabenbild = $imagedata['url'];
    }
    if($imagedata['positionId'] == 3){
        $teaserbild = $imagedata['url'];
    }
    if($imagedata['positionId'] == 4){
        $autorbild = $imagedata['url'];
    }    
}
$tpl->setVariable('ausgabenbild', $params['paths']['images'].$ausgabenbild);

$tpl->parseCurrentBlock("header");    

######### Magazindarstellung rechte Spalte#################

$tpl->setCurrentBlock("aktuellesMagazin");

$tpl->setVariable('ausgabe', $tabdata['ausgabe']);
$tpl->setVariable('pfad', $params['paths']['magazine']);
$tpl->setVariable('pdfurl', $tabdata['pdfurl']);
$tpl->setVariable('titelbild', $params['paths']['images'].$titelbild);

$tpl->parseCurrentBlock("aktuellesMagazin");

######## Vorschau-Block ###############################
$vorschaucontent = '';
$tpl->setCurrentBlock("vorschau");

$tpl->setVariable('ausgabe', nextRelease($tabdata['ausgabe']));
$tpl->setVariable('vorschaucontent', $tabdata['vorschau']);
$tpl->parseCurrentBlock("vorschau");
##################################CONTENT

$tpl->addBlockFile('CONTENT', 'SPECIALS', $loadhtml);
  
$tpl->setCurrentBlock('SPECIALS');
//$tpl->setVariable('SPECIAL', 'turtles');
include $params['paths']['includes'].$loadphp;
$tpl->parseCurrentBlock();






/*

$tpl->setCurrentBlock("main_content") ;
$tpl->setVariable('Content', 'Inhalt') ;
$tpl->parseCurrentBlock("main_content") ;
 
 */
$tpl->show();

?>						
