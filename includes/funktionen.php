<?php
function clean_int($input)
{
  $input=trim($input);
  $input = preg_replace('/[^0-9]/','',$input);
  return ($input);
}


function sauber_csv($input, $laenge)
{
  //$input = strip_tags($input);
  $input = trim($input);
  $input = substr($input, 0, $laenge);
  $input = str_replace(",","",$input);
  return ($input);
}

function sauber($input, $laenge)
{
  //$input = strip_tags($input);
  $input = trim($input);
  $input = substr($input, 0, $laenge);
  //$input = htmlentities($input);
  $input = str_replace("\n","",$input);
  return ($input);
}

function authenticateUser ($username,$passwd,$link){
	//global $link;
	if (empty($username) || empty ($passwd)){
		return false;
	}
	$passwd = sha1($passwd);
	$sql="SELECT username FROM user WHERE username='".$username."' AND passwd='".$passwd."';";
	if (!$res=mysqli_query($link, $sql)){
		die("kann die Datenbank nicht abfragen".mysql_error());
	}

	if(mysqli_num_rows($res) !=1){
		return false;
	}
	else{
		return true;
	}
	
}
function nextRelease($releasestring){
    $parts= explode('/', $releasestring);
    $nummer=intval($parts[0]);
    $year=intval($parts[1]);
    $nummer++;      
    if($nummer>4){
        $nummer=1;
        $year++;
    }
    return '0'.$nummer.'/'.$year;
}

function makeUniqueName($filename){
    $filename = uniqid(rand(), true) . $filename;
    return $filename;
}
?>