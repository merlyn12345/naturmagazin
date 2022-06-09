<?php
include $params['paths']['includes'].'sicher_user.php';
$action=basename($_SERVER['PHP_SELF']);
$header = 'Dateiupload';
$title = 'Dateiupload';
$pfad="magazine/";
$message='';

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

##############################

	if(isset($_POST['submit'])){

		require("includes/httppostuploadclass_i.php");
                
		$ausgabe = filter_input(INPUT_POST, 'ausgabe', FILTER_SANITIZE_STRING);
                if(empty($ausgabe)){
                    $message .= 'Bitte die korrekte Ausgabe angeben<br>';
                }
                $titel = filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_STRING);
                if(empty($titel)){
                    $message .= 'Bitte einen Titel angeben<br>';
                }                
                $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);
                if(empty($text)){
                    $message .= 'Bitte das Editorial angeben<br>';
                }
                $text= nl2br($text);
                $text= str_replace("\n", '', $text);
                $voedate = filter_input(INPUT_POST, 'voedate', FILTER_SANITIZE_STRING);
                if(empty($voedate)){
                    $message .= 'Bitte das ungefähre Veröffentlichungsdatum angeben<br>';
                }                

		// calling the class
		$u = new HttpPostUpload();

		// path from this page to the destination
		// folder where the images should be saved in
		// dont forget to set the rights ;-)
		$u->destpath = $pfad;

		// name of the input field form tag, see below
		$u->formfieldname = "users_file";

		// howmuch files are allowed to upload
		$u->maxfiles = 1;

		// which types of files are allowed to upload
		$u->allowedtypes = array("pdf");
		$u->allowedmimetypes = array("application/pdf");

		// how big can each file be
		//$u->maxfilesize = 20000000;

		// sign that aren't allowed to use in filenames
		// this sign are replaced with "" if in the name
		// write it like an regex
		$u->verbosesign = "[\"\*\\\'\%\$\&\@\<\>]";

		// fine thing, if you need this class for puplic upload,
		// it can be usefull to be sure that each file has an unique filename
		// setting this to TRUE will generate unique name like 1321342342342.jpg
		// in the destpath, and save it in the log array
		$u->uniquefilenames = FALSE;
                if(empty($message)){
                    // und upwiththeshit
                    $u->ProceedUpload();
                }

		//insert info into db
		//hmm && $u->size > 0
		
		if ($u->log["status"][0]=="Erfolgreicher Upload" && empty($message))
		{

 			
			$sql= ( $_POST['submit'] ) ? "INSERT INTO galerien (titel, text, date, pdfurl, ausgabe, voedate) VALUES ('".$titel."', '".$text."', NOW(), '".sauber($u->filename,255)."', '".$ausgabe."', '".$voedate."')" : '';
			
			if (!$res=$db->sql_query($sql)){
				if($test){
					print_r($db->sql_error());
					die("kann die Datenbank nicht abfragen".$sql);
				}
				else{
					die("Zur Zeit keine Verbindung zur Datenbank");
				}
			}
			

			 $message="Erfolgreicher Upload!";
                         //######## Seite anlegen ##############
                         

                            $id=$db->sql_nextid();
                            $sql="INSERT INTO seiten (rollen_id, title, loadphp, loadhtml, created, user_id, meta, publish, editlock, galerie_id) VALUES ('1', '".$titel."','magazincontent','magazincontent', NOW(), '1', ' ', '1','0', '".$id."')";
                            if (!($res = $db->sql_query($sql)))
                            {
                            print_r($db->sql_error());
                                    die("Fehler, kann Datenbank nicht abfragen");
                            }
                            $id=$db->sql_nextid();
                            $sql="INSERT INTO lin_menue (text, url, rollen_id, topdown , view, seiten_id) VALUES ('".$titel."','index','1', '20', '1',  '".$id."')";
                            if (!($res = $db->sql_query($sql)))
                            {
                            print_r($db->sql_error());
                                    die("Fehler, kann Datenbank nicht abfragen");
                            }

                    

                         //###### END Seite anlegen
		}
		else{
                    if(empty($message)){
                        $message=$u->log["status"][0];
                    }
		}
}


	$tpl->setCurrentBlock('form');
	$tpl->setVariable('action', $action);
	$tpl->parseCurrentBlock('form');
	
	
	
	$tpl->setCurrentBlock('message');
        $tpl->setVariable('message', $message);
        $tpl->parseCurrentBlock('message');
	



?>