<?php
/*
session_start();
require('ini.php');

include('includes.php');
*/
$galerienarray = array();
$scriptname = $_SERVER['PHP_SELF'];
$loginmessage = '';
$fail_login = '';
//$tpl = new HTML_Template_IT('./templates');
//$tpl->loadTemplatefile('galeriemanagercontent.html', true, true);

########Linkaenderungen auswerten


include('includes/galeriemanager.php');
								
$galerien = new galeriemanager($params['db']['host'],$params['db']['user'],$params['db']['passwd'],$params['db']['name'] );
//if(isset($_SESSION['rollen_ids'])){
 /*  
    foreach($_SESSION['rollen_ids'] as $rolle){
	
	$galerienarray = array_merge($galerienarray, $galerien->display($rolle));
    }
}
else{*/
    $galerienarray = $galerien -> display('1');
//}
   
########Anfang Ausgabe Menueitems

foreach ($galerienarray AS $entry){
	$tpl->setCurrentBlock('Menueitem');
	foreach($entry as $key => $value){

		if('url' == $key){
			//$value = $value.'.'.$phpEx;
			$tpl->setVariable($key, $params['paths']['thumbnail'].$value);
		}
		if('ausgabe' == $key){
			//$value = strtoupper($value);
			$tpl->setVariable($key, $value);
		}
		if('id' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}
		if('galerie_id' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}
		if('menue_id' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}
		if('topdown' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}
		if('text' == $key){
			//$value = to_upper($value);
			$tpl->setVariable($key, $value);
		}
		if('intro' == $key){
			$value = strip_tags($value);
			//$pos = @strpos($value," ",50);
			$value = substr($value,0,50);
			$tpl->setVariable($key, $value);
		}
		if('pdfurl' == $key){
			$value = strip_tags($value);
			//$pos = @strpos($value," ",50);
			//$value = substr($value,0,50);
			$tpl->setVariable($key, $params['paths']['magazine'].$value);
		}                
		
	}
	$tpl->setVariable('scriptname', $scriptname);
	$tpl->parseCurrentBlock();
	$tpl->setCurrentBlock('Menueadmin');
	$tpl->parseCurrentBlock();
}

$db->sql_close();


?>						
