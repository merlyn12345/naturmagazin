<?php
require('ini.php');
require('includes.php');
$status='200';
$found='false';
$ausgabe=filter_input(INPUT_GET, 'ausgabe', FILTER_SANITIZE_STRING);
$response=array();
if($ausgabe){
    $sql="SELECT ausgabe FROM galerien WHERE ausgabe = '".$ausgabe."'";
    if (!($res = $db->sql_query($sql))){
        if($test){
            echo 'Fehler: '.print_r($this->sql_error());
            echo 'sql: '.$sql;
            exit;
        }  
        $status = '500';
    }elseif($db->sql_numrows() < 1) {
        $status = '400';
        $found = 'true';
    }else{
       $tabdata=$db->sql_fetchrow(); 
       $found='true';
    }
    $response=Array(
        'status'=>$status,
        'found'=>$found,
        'ausgabe'=>$tabdata['ausgabe']
    );    
    echo json_encode($response);
}else{
    echo 'false';
}
