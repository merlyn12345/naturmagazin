<?php
include $params['paths']['includes'].'sicher_user.php';
$action=basename($_SERVER['PHP_SELF']);
$header = 'Dateiupload';
$title = 'Dateiupload';
$pfad="images/";
$message='';
$bposition=0;

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
		$bildbeschreibung = filter_input(INPUT_POST, 'bildbeschreibung', FILTER_SANITIZE_STRING);
  
		$bposition = filter_input(INPUT_POST, 'bposition', FILTER_VALIDATE_INT);
                if(! $bposition){
                    $message .= 'Bitte eine Position des Bildes angeben<br>';
                }                 
		$galerien_id=filter_input(INPUT_POST, 'galerie', FILTER_VALIDATE_INT);
                if(! $galerien_id){
                    $message .= 'Bitte ein Magazin auswählen<br>';
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
		$u->allowedtypes = array("jpg","png","gif");
		$u->allowedmimetypes = array("image/jpeg","image/png","image/gif", "image/jpeg");

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
		$u->uniquefilenames = TRUE;
                if(empty($message) && $galerien_id){
                    // und upwiththeshit
                    $u->ProceedUpload();
                }

		//insert info into db
		//hmm && $u->size > 0
		
		if ($u->log["status"][0]=="Erfolgreicher Upload" )
		{
			$size=getimagesize($pfad.sauber($u->filename,50));
			$breite=$size['0'];
			$hoehe=$size['1'];
			//$neuebreite=100;
			$neuehoehe = 50;
			$neuebreite=intval($breite*$neuehoehe/$hoehe);
			$typ= $size['2'];
 			
			$sql= ( $_POST['submit'] ) ? "INSERT INTO images (url, typ, date, size, user_id, del, breite, hoehe, beschreibung, galerien_id, topdown, positionId) VALUES ('".sauber($u->filename,50)."', '".$typ."', NOW(), '".$u->size."',   '".$user_id."','0','".$breite."','".$hoehe."','".$bildbeschreibung."','".$galerien_id."', '1', '".$bposition."')" : '';
			
			if (!$res=$db->sql_query($sql)){
				if($test){
					print_r($db->sql_error());
					die("kann die Datenbank nicht abfragen".$sql);
				}
				else{
					die("Zur Zeit keine Verbindung zur Datenbank");
				}
			}
			

			#Bildertypen jpg/png/gif behandeln
			switch($typ) {
			    case '1' :

				$altesbild=imagecreatefromgif($pfad.sauber($u->filename,50));
				$neuesbild=imagecreatetruecolor($neuebreite,$neuehoehe);
				imagecopyresized($neuesbild,$altesbild,0,0,0,0,$neuebreite,$neuehoehe,$breite,$hoehe);
				$dateiname= $pfad .'thumbnails/TN_'.sauber($u->filename,50);
				$bal=imagegif($neuesbild,$dateiname);
		   
			    break;
			    
			    case '2' :

				$altesbild=imagecreatefromjpeg($pfad.sauber($u->filename,50));
				$neuesbild=imagecreatetruecolor($neuebreite,$neuehoehe);
				imagecopyresized($neuesbild,$altesbild,0,0,0,0,$neuebreite,$neuehoehe,$breite,$hoehe);
				$dateiname= $pfad .'thumbnails/TN_'.sauber($u->filename,50);
				$bal=imagejpeg($neuesbild,$dateiname);
		   
			    break;
			    
			    case '3' :

				$altesbild=imagecreatefrompng($pfad.sauber($u->filename,50));
				$neuesbild=imagecreatetruecolor($neuebreite,$neuehoehe);
				imagecopyresized($neuesbild,$altesbild,0,0,0,0,$neuebreite,$neuehoehe,$breite,$hoehe);
				$dateiname= $pfad .'thumbnails/TN_'.sauber($u->filename,50);
				$bal=imagepng($neuesbild,$dateiname);
		   
			    break;
		  
			 }

			 $message="Erfolgreicher Upload!";
			 //unset($_SESSION['posts_id']);
			 //unset($action);
		}
		else{
                    if(empty($message)){
                        $message=$u->log["status"][0];
                    }
		}
}

$sql="SELECT galerien.id AS galerien_id, galerien.titel AS galerien_titel FROM galerien, seiten WHERE publish=1 AND seiten.galerie_id=galerien.id ORDER BY galerien.id DESC";

if (!($res = $db->sql_query($sql)))
{
	print_r($db->sql_error());
	print $sql;
}
else{
    	while($tabdata = $db->sql_fetchrow($res)) 
	{

	$tpl->setCurrentBlock("galerie") ;
	foreach($tabdata as $key => $cell)
	{
		$tpl->setVariable($key, $cell) ;
	}
	$tpl->parseCurrentBlock("galerie") ;


	}
	$tpl->setCurrentBlock("row") ;
	$tpl->parseCurrentBlock("row") ;
}


//########### Abfrage, welche Bildkategorien bereits vergeben sind

$sql="SELECT positionId FROM images WHERE galerien_id = '".$galerien_id."'";
if (!($res = $db->sql_query($sql))){
	print_r($db->sql_error());
	print $sql;
}
else{
    while($datensatz=$db->sql_fetchrow($res)){
        if($datensatz['positionId'] == 1){
            $tpl->setCurrentBlock('titelbild');
            $tpl->setVariable('disabled', ' disabled ');
            $tpl->parseCurrentBlock('titelbild');            
        }
        if($datensatz['positionId'] == 2){
            $tpl->setCurrentBlock('ausgabebild');
            $tpl->setVariable('disabled', ' disabled ');
            $tpl->parseCurrentBlock('titelbild');            
        }
        if($datensatz['positionId'] == 3){
            $tpl->setCurrentBlock('teaserbild');
            $tpl->setVariable('disabled', ' disabled ');
            $tpl->parseCurrentBlock('teaserbild');            
        }
        if($datensatz['positionId'] == 4){
            $tpl->setCurrentBlock('autorbild');
            $tpl->setVariable('disabled', ' disabled ');
            $tpl->parseCurrentBlock('autorbild');            
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