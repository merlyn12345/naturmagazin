<?php
	session_start();
        require_once('ini.php');       
        require_once('includes.php');
        
	$authenticated=false;
	$username= filter_input(INPUT_POST,'username', FILTER_SANITIZE_STRING);
	$passwd=filter_input(INPUT_POST,'passwd', FILTER_SANITIZE_STRING); 
	$authenticated=authenticateUser($username,$passwd,$db->db_connect_id); 
	if($authenticated){
		$_SESSION['aut_user']=$username;
		$_SESSION['login_ip_adress']=$_SERVER['REMOTE_ADDR'];
		$sql="SELECT id FROM user WHERE username='".$username."'";
		//daten des users werden aus DB geholt
		if(! $result= mysqli_query($db->db_connect_id, $sql)){
			print mysqli_error ();
		}
		$datensatz = mysqli_fetch_array($result);
		$user_id = $datensatz['id'];
		$sql="SELECT rollen_id FROM user_rollen WHERE user_id=".$user_id; 
		if(! $res=mysqli_query($db->db_connect_id, $sql)){
			
			echo mysqli_error();
			die('Fehler bei der Datenbank-Abfrage');
			//bei entwicklung hier immer mysql fehlermeldung ausgeben lassen
		}
		$rollen = array();
		$rollenbeschreibung = array();
		while ($datensatz = mysqli_fetch_array($res)){
			$rollen[] = $datensatz['rollen_id'];
		}
		foreach($rollen as $rollenid){
			
			$sql = "SELECT rolle FROM rollen WHERE id =".$rollenid;
			$result = mysqli_query($db->db_connect_id, $sql);
			$datensatz = mysqli_fetch_array($result);
			$rollenbeschreibung[] = $datensatz['rolle'];
		}
		$_SESSION['rollenbeschreibung']=$rollenbeschreibung;
		$_SESSION['rollen_ids'] = $rollen;

		//if(in_array('admin', $rollenbeschreibung)){
		if(in_array('admin', $_SESSION['rollenbeschreibung'])){
			header("Location: index.php?id=8"); 
		
		}
		elseif(in_array('user', $_SESSION['rollenbeschreibung'])){
			header("Location: index.php?id=8"); 
		
		}
		else{
		header("Location: index.php");
		}
	}
	else {
		$_SESSION['fail_login']="FEHLER: Ihr Username <span style=\"color:#96B566;\">".$username."</span> oder Passwort ist nicht korrekt. <br />";
		header("Location: index.php");
	}
	
	mysqli_close($db->db_connect_id);
?>