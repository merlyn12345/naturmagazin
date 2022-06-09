<?php
require('ini.php');
require('includes.php');

$magazinid=filter_input(INPUT_GET, 'magazinid', FILTER_VALIDATE_INT);
$response=array();
$positionset='';
if($magazinid){
    $sql="SELECT positionId FROM images WHERE galerien_id = '".$magazinid."'";
    if (!($res = $db->sql_query($sql))){
        if($test){
            echo 'Fehler: '.print_r($this->sql_error());
            echo 'sql: '.$sql;
            exit;
        }    
    }else{
        $positionset=$db->sql_fetchrowset();
        foreach($positionset as $key => $value){
            $response[] = $value['positionId'];
        }
    }
    echo json_encode($response);
}else{
    echo 'false';
}
