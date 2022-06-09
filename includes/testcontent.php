<?php

//letztes mag aus DB holen

$sql="SELECT galerien.id AS galerien_id, titel, text, pdfurl, ausgabe, url, positionId FROM galerien INNER JOIN images ON galerien.id = images.galerien_id WHERE galerien.del = '0' ORDER BY galerien.voedate DESC LIMIT 1";

if (!($res = $db->sql_query($sql)))
{
	print_r($db->sql_error());
	print $sql;
}


$tabdata = $db->sql_fetchrow($res);

$tpl->setCurrentBlock("content") ;

$tpl->setVariable('ausgabe', $tabdata['ausgabe']);
$tpl->setVariable('titel', $tabdata['titel']);
$tpl->setVariable('text', $tabdata['text']);
$tpl->setVariable('pdfurl', $params['paths']['magazine'].$tabdata['pdfurl']);

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
$tpl->setVariable('titelbild', $params['paths']['images'].$titelbild);
$tpl->setVariable('ausgabenbild', $params['paths']['images'].$ausgabenbild);
$tpl->setVariable('teaserbild', $params['paths']['images'].$teaserbild);
$tpl->setVariable('autorbild', $params['paths']['images'].$autorbild);

$tpl->parseCurrentBlock("content") ;




	// ende tabelle und fusszeile
	//  angezeigte zeilen



//$tpl->setVariable("keine", $keine) ;
//$tpl->parseCurrentBlock("browse") ;

$db->sql_close();


?>