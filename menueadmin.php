<?php
session_start();
require('ini.php');
require $params['paths']['includes'].'sicher_user.php';
include('includes.php');

$scriptname = $_SERVER['PHP_SELF'];
$loginmessage = '';
$fail_login = '';
$tpl = new HTML_Template_IT('./templates');
$tpl->loadTemplatefile('menueadmin.tpl.html', true, true);

########Linkaenderungen auswerten
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['richtung']) && !empty($_GET['richtung'])){
	$id=sauber($_GET['id'],3);
	$richtung=sauber($_GET['richtung'],6);
	if('hoch' == $richtung){
		$sql="SELECT topdown FROM ".$params['tables']['lin_menue']." WHERE id = ".$id;
		if (!$res=$db->sql_query($sql)){
			if($test){
				print_r($db->sql_error());
				die("kann die Datenbank nicht abfragen".$sql);
			}
			else{
				die("Zur Zeit keine Verbindung zur Datenbank");
			}
		}
		$menuedata = $db->sql_fetchrow();
		$topdown_geklickt = $menuedata['topdown'];
		if($topdown_geklickt > 0){
			$topdown_neu = $topdown_geklickt -1;
			$sql = "UPDATE ".$params['tables']['lin_menue']." SET topdown = '".$topdown_geklickt."' WHERE topdown = ".$topdown_neu;
			if (!$res=$db->sql_query($sql)){
				if($test){
					print_r($db->sql_error());
					die("kann die Datenbank nicht abfragen".$sql);
				}
				else{
					die("Zur Zeit keine Verbindung zur Datenbank");
				}
			}
			$sql = "UPDATE ".$params['tables']['lin_menue']." SET topdown = '".$topdown_neu."' WHERE id = ".$id;
			if (!$res=$db->sql_query($sql)){
				if($test){
					print_r($db->sql_error());
					die("kann die Datenbank nicht abfragen".$sql);
				}
				else{
					die("Zur Zeit keine Verbindung zur Datenbank");
				}
			}
		}
	}
	if('runter' == $richtung){
		$sql="SELECT topdown FROM ".$params['tables']['lin_menue']." WHERE id = ".$id;
		if (!$res=$db->sql_query($sql)){
			if($test){
				print_r($db->sql_error());
				die("kann die Datenbank nicht abfragen".$sql);
			}
			else{
				die("Zur Zeit keine Verbindung zur Datenbank");
			}
		}
		$menuedata = $db->sql_fetchrow();
		$topdown_geklickt = $menuedata['topdown'];
		$sql="SELECT COUNT(*) FROM ".$params['tables']['lin_menue'];
		if (!$res=$db->sql_query($sql)){
			if($test){
				print_r($db->sql_error());
				die("kann die Datenbank nicht abfragen".$sql);
			}
			else{
				die("Zur Zeit keine Verbindung zur Datenbank");
			}
		}
		$data = $db->sql_fetchrow();
		$max= $data['COUNT(*)'];
		if($topdown_geklickt < $max -1){
			$topdown_neu = $topdown_geklickt +1;
		
			$sql = "UPDATE ".$params['tables']['lin_menue']." SET topdown = '".$topdown_geklickt."' WHERE topdown = ".$topdown_neu;
			if (!$res=$db->sql_query($sql)){
				if($test){
					print_r($db->sql_error());
					die("kann die Datenbank nicht abfragen".$sql);
				}
				else{
					die("Zur Zeit keine Verbindung zur Datenbank");
				}
			}
			$sql = "UPDATE ".$params['tables']['lin_menue']." SET topdown = '".$topdown_neu."' WHERE id = ".$id;
			if (!$res=$db->sql_query($sql)){
				if($test){
					print_r($db->sql_error());
					die("kann die Datenbank nicht abfragen".$sql);
				}
				else{
					die("Zur Zeit keine Verbindung zur Datenbank");
				}
			}
		}
	}

}

//include('includes/lin_menue.php');
								

$menue = new lin_menue($params['db']['host'],$params['db']['user'],$params['db']['passwd'],$params['db']['name'] );
$menue -> getMenue_vars();
$menuearray = $menue -> display();
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
		if('id' == $key){
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
		
}
########Anfang Ausgabe Menueitems

foreach ($menuearray AS $entry){
	$tpl->setCurrentBlock('Menueitem');
	foreach($entry as $key => $value){

		if('url' == $key){
			$value = $value.'.'.$phpEx;
			$tpl->setVariable($key, $value);
		}
		if('text' == $key){
			$value = strtoupper($value);
			$tpl->setVariable($key, $value);
		}
		if('id' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}

		if('topdown' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}
		
	}
	$tpl->setVariable('scriptname', $scriptname);
	$tpl->parseCurrentBlock();
	$tpl->setCurrentBlock('Menueadmin');
	$tpl->parseCurrentBlock();
}

$db->sql_close();
$tpl->show();

?>						
