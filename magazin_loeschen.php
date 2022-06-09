<?php
error_reporting(0);
require('ini.php');
require('includes.php');
$galerien_id='';
$seitenid='';
$lin_menueid='';
$imagesid=[];
$imagesurl=[];
$pdfurl='';
$fail_login = '';
$login_error = '';
$phpEx = 'php';
$user_id = '';
$fehler = false;
$id = '';
$headline = '';
$text = '';
$fehlermeldung = 'Es ist ein Fehler bei der Verarbeitung aufgetreten: <br>';
$pdfdel='NO';
$seitedel='NO';
$menuedel='NO';
$imgdel='NO';
$magazindel='NO';
$ausgabe='';
### Id des Posts einlesen und ueberpruefen
if (filter_input(INPUT_GET, 'magazinid', FILTER_VALIDATE_INT)) {
    $galerien_id = filter_input(INPUT_GET, 'magazinid', FILTER_VALIDATE_INT);
    if (is_int($galerien_id)) {
        // Seitenid herausfinden 
        $sql = "SELECT id as seitenid FROM seiten WHERE galerie_id = '" . $galerien_id."'";
        if (!($res = $db->sql_query($sql))) {
            $fehler = true;
            $fehlermeldung .= 'Es wurde kein Seiteneintrag zur Id ' . $galerien_id . ' gefunden <br> ';
            if($test){
                print_r($db->sql_error());
            }
        } else {
            if ($tabdata = $db->sql_fetchrow()) {
                $seitenid = $tabdata['seitenid'];
            } else {
                $fehler = true;
                $fehlermeldung .= 'Es wurde kein Naturmagazin zur Id ' . $id . ' gefunden <br /> ';
            }
        }
    }else {
        $fehler = true;
        $fehlermeldung .= 'Die Id muss eine ganze Zahl sein. <br> ';
    } 
} else {
    $fehler = true;
    $fehlermeldung .= 'Es wurde keine Id uebergeben';
}
###### Menuepunkt id herausfinden
$sql = "SELECT id as lin_menueid FROM lin_menue WHERE seiten_id = '" . $seitenid."'";
if (!($res = $db->sql_query($sql))) {
    $fehler = true;
    $fehlermeldung .= 'Es wurde kein Seiteneintrag zur Id ' . $galerien_id . ' gefunden <br> ';
    if($test){
        print_r($db->sql_error());
    }
} else {
    if ($tabdata = $db->sql_fetchrow()) {
        $lin_menueid = $tabdata['lin_menueid'];
    } else {
        $fehler = true;
        $fehlermeldung .= 'Es wurde kein Menuepunkt zum Naturmagazin mit der Id ' . $id . ' gefunden <br> ';
    }
}

################ Bild id und dateiname auslesen
$sql = "SELECT id as imagesid, url FROM images WHERE galerien_id = '" . $galerien_id."'";
if (!($res = $db->sql_query($sql))) {
    $fehler = true;
    $fehlermeldung .= 'Es wurden keine Bilder zur Id ' . $galerien_id . ' gefunden <br> ';
    if($test){
        print_r($db->sql_error());
    }
} else {
    while ($tabdata = $db->sql_fetchrow()) {
        $imagesid[]=$tabdata['imagesid'];
        $imagesurl[]=$tabdata['url'];
    } 
}

############# Dateiname pdf herausfinden
$sql = "SELECT pdfurl, ausgabe FROM galerien WHERE id = '" . $galerien_id."'";
if (!($res = $db->sql_query($sql))) {
    $fehler = true;
    $fehlermeldung .= 'Es wurde kein Seiteneintrag zur Id ' . $galerien_id . ' gefunden <br> ';
    if($test){
        print_r($db->sql_error());
    }
} else {
    if ($tabdata = $db->sql_fetchrow()) {
        $pdfurl = $tabdata['pdfurl'];
        $ausgabe = $tabdata['ausgabe'];
    } else {
        $fehler = true;
        $fehlermeldung .= 'Es wurde kein Menuepunkt zum Naturmagazin mit der Id ' . $id . ' gefunden <br> ';
    }
}


#### Let the loeschen begin....
## BILDER
## Bilder aus dem Dateisystem loeschen

foreach($imagesurl as $index => $url){
    if(is_file($params['paths']['images'].$url)){
        unlink($params['paths']['images'].$url);
    }
    if(is_file($params['paths']['thumbnail'].$url)){
        unlink($params['paths']['thumbnail'].$url);
    }    
}
## Eintraege aus images loeschen wenn es welche gibt
if(count($imagesid) > 0){
    $where='';
    $sql="DELETE FROM images WHERE id IN (";
    foreach($imagesid as $index => $imageid){
        if(strlen($where > 0)){
            $where.=', '.$imageid;
        }else{
            $where.=$imageid;
        }
    }
    $sql=$sql.$where.')';
    //doit.....
    if (!($res = $db->sql_query($sql))) {
        $fehler = true;
        $fehlermeldung .= 'Es wurde kein Bildeintrag zur Id ' . $galerien_id . ' gefunden <br> ';
        if($test){
            print_r($db->sql_error());
        }
    } else {
        $imgdel='OK';
    }
}
## Eintrag aus lin_menue loeschen
$sql="DELETE FROM lin_menue WHERE id ='".$lin_menueid."'";
// doit
if (!($res = $db->sql_query($sql))) {
    $fehler = true;
    $fehlermeldung .= 'Es wurde kein Menue zur Id ' . $lin_menueid . ' gefunden <br> ';
    if($test){
        print_r($db->sql_error());
    }
} else {
    $menuedel='OK';
}

## Eintrag aus seiten löschen
$sql="DELETE FROM seiten WHERE id ='".$seitenid."'";
// doit
if (!($res = $db->sql_query($sql))) {
    $fehler = true;
    $fehlermeldung .= 'Es wurde keine Seite zur Id ' . $seitenid . ' gefunden <br> ';
    if($test){
        print_r($db->sql_error());
    }
} else {
    $seitedel='OK';
}
## Eintrag aus galerien löschen
$sql="DELETE FROM galerien WHERE id ='".$galerien_id."'";
// doit
if (!($res = $db->sql_query($sql))) {
    $fehler = true;
    $fehlermeldung .= 'Es wurde keine Seite zur Id ' . $seitenid . ' gefunden <br> ';
    if($test){
        print_r($db->sql_error());
    }
} else {
    $magazindel='OK';
}
## PDF löschen

if(is_file($params['paths']['magazine'].$pdfurl)){
    unlink($params['paths']['magazine'].$pdfurl);
    $pdfdel='OK';
}



$response=array(
    'status'=>'200',
    'galerien_id' => $galerien_id,
    'seitenid' => $seitenid,
    'lin_menueid' => $lin_menueid,
    'imagesid' => $imagesid,
    'imagesurl' => $imagesurl,
    'pdfurl' => $pdfurl,
    'pdfdel'=> $pdfdel,
    'seitedel' => $seitedel,
    'menuedel' => $menuedel,
    'imgdel' => $imgdel,
    'magazindel'=> $magazindel,
    'error'=>$fehlermeldung,
    'ausgabe'=>$ausgabe
); 

echo json_encode($response);
/*
print_r($imagesid);
print_r($imagesurl);
*/
//header('Location: index.php?id=14');
?>