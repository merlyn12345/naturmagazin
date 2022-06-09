<?php
include $params['paths']['includes'].'sicher_user.php';
$fail_login = '';
$login_error = '';
$phpEx = 'php';
$user_id = '';
$fehler = false;
$id = '';
$headline = '';
$text = '';
$fehlermeldung = 'Es ist ein Fehler bei der Verarbeitung aufgetreten: <br />';


### Id des Posts einlesen und ueberpruefen
if (filter_input(INPUT_GET, 'galerie_id', FILTER_VALIDATE_INT)) {
    $galerie_id = filter_input(INPUT_GET, 'galerie_id', FILTER_VALIDATE_INT);
    if (!is_int($galerie_id)) {
        $fehler = true;
        $fehlermeldung .= 'Die Id muss eine ganze Zahl sein. <br /> ';
    } else {
        $sql = "SELECT id, titel, text, ausgabe, del, vorschau FROM galerien WHERE id = " . $galerie_id;
        if (!($res = $db->sql_query($sql))) {
            $fehler = true;
            $fehlermeldung .= 'Es wurde kein Naturmagazin zur Id ' . $galerie_id . ' gefunden <br /> ';
            if($test){
                print_r($db->sql_error());
            }
        } else {
            if ($tabdata = $db->sql_fetchrow()) {
                $titel = $tabdata['titel'];
                $text = $tabdata['text'];
                $del = $tabdata['del'];
                $ausgabe = $tabdata['ausgabe'];
                $vorschau = $tabdata['vorschau'];
            } else {
                $fehler = true;
                $fehlermeldung .= 'Es wurde kein Naturmagazin zur Id ' . $id . ' gefunden <br /> ';
            }
        }
    }
} elseif (!filter_input(INPUT_POST, 'galerien_id', FILTER_VALIDATE_INT)) {
    $fehler = true;
    $fehlermeldung .= 'Es wurde keine Id uebergeben';
}
if (filter_input(INPUT_POST, 'galerien_id', FILTER_VALIDATE_INT)) {
    $galerie_id = filter_input(INPUT_POST, 'galerien_id', FILTER_VALIDATE_INT);
}

### Daten aus versendetem Formular verarbeiten
//wenn alle teile des formulars ausgefuellt sind wird beitrag in die DB geschrieben
if (filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING) && filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_STRING)) {
    $titel = sauber(filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_STRING), 255);
    $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);
    $text = nl2br($text);
    $text = sauber($text, 50000);
    $del = 0;
    $vorschau = filter_input(INPUT_POST, 'vorschau', FILTER_SANITIZE_STRING);
    $vorschau = nl2br($vorschau);
    if (isset($_POST['del'])) {
        $del = $_POST['del'];
    }
    $sql = "UPDATE galerien SET titel ='" . $titel . "', text = '" . $text . "', date = NOW(), del='" . $del . "' , vorschau='" . $vorschau . "' WHERE galerien.id = " . $galerie_id;
    //print $sql;
    if (!($res = $db->sql_query($sql))) {
        $fehler = true;
        $fehlermeldung .= 'Das Magazin konnte nicht geaendert werden <br /> ';
        if($test){
            print_r($db->sql_error());
        }
    } else {
        ###

        if (1 == $del) {
            $sql = "UPDATE lin_menue SET view = '0' WHERE lin_menue.text = '" . $titel . "'";
        } else {
            $sql = "UPDATE lin_menue SET view = '1' WHERE lin_menue.text = '" . $titel . "'";
        }
        if (!($res = $db->sql_query($sql))) {
            $fehler = true;
            $fehlermeldung .= 'Das Magazin konnte nicht angezeigt/versteckt werden <br /> ';
            if($test){
                print_r($db->sql_error());
            }
        }

        header('Location: index.php?id=14');
    }
}
if ($fehler) {
    $tpl->setCurrentBlock('fehlerausgabe');
    $tpl->setVariable('fehlermeldung', $fehlermeldung);
    $tpl->parseCurrentBlock();
}

## Formularbearbeitung Ausgabe per Template-Klasse
if (isset($_POST['titel']) && (empty($_POST['titel']) || empty($_POST['text']))) {

    if (empty($_POST['titel'])) {
        $tpl->setCurrentBlock('headline_error');
        $tpl->setVariable('headline_errortext', 'Bitte einen Titel eingeben!');
        $tpl->parseCurrentBlock();
    }
    if (empty($_POST['text'])) {
        $tpl->setCurrentBlock('text_error');
        $tpl->setVariable('text_errortext', 'Bitte einen Text eingeben!');
        $tpl->parseCurrentBlock();
    }
}
$tpl->setCurrentBlock('formular');
$tpl->setVariable('galerie_id', $galerie_id);
if (isset($_POST['titel']) && (empty($_POST['titel']) || empty($_POST['text']) )) {
    if (empty($_POST['titel'])) {

        $tpl->setVariable('error_head', '#ff0000');
    } else {
        $tpl->setVariable('titel', $_POST['titel']);
    }

    if (empty($_POST['text'])) {
        $tpl->setVariable('error_text', '#ff0000');
    } else {
        $tpl->setVariable('text', $_POST['text']);
    }
} else {
    $tpl->setVariable('error_head', '#ffffff');
    $tpl->setVariable('titel', $titel);
    $tpl->setVariable('error_text', '#ffffff');
    $tpl->setVariable('text', $text);
    $tpl->setVariable('ausgabe', $ausgabe);
    $tpl->setVariable('vorschau', $vorschau);
}
if (1 == $del) {
    $delimage = 'pics/publish_x.png';
    $checked = 'checked="checked"';
} else {
    $delimage = 'pics/tick.png';
    $checked = '';
}
$tpl->setVariable('checked', $checked);
$tpl->setVariable('delimage', $delimage);
?>