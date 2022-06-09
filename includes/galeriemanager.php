<?php
class galeriemanager extends sql_db
{
	/**
	* menue variables
	*
	* @var array
	*/
	protected $menue_vars;
	protected $roles;
	/**
	* Constructor
	*/
	function __construct($dbhost='localhost',$dbuser='root',$dbpass='',$database='blog')
	{
		parent::__construct($dbhost, $dbuser, $dbpass, $database, $persistency = false);
		$this->menue_vars = array();
	}

	/**
	* 	*
	* @param  menu_table  Tablename in DB
	* @return none
	*/
	function getRoles($role_table='')
	{
	    	$sql = "SELECT id FROM ".$role_table;
		if (!($res = $this->sql_query($sql)))
		{
			echo 'Fehler: '.print_r($this->sql_error());
			echo 'sql: '.$sql;
			return false;
		}
		$rollenset=$this->sql_fetchrowset();
		foreach($rollenset as $key => $value){
		    $this->roles[] = $value['id'];
		}

		return true;
	}


	function getMenue_vars($level='', $menu_table='lin_menue', $role_table='', $seiten_table='seiten', $galerie_table='galerien', $images_table='images')
	{
		global $params;
		$where = '';
		if(''== $role_table){
		    $role_table = $params['tables']['rollen'];
		}
		if($this->getRoles($role_table))
		{
		    if(!empty($level) && in_array($level, $this->roles)){
			 //   $where = " WHERE edit = '".$level."' ";
			    $where = " AND  ".$menu_table.".rollen_id = '".$level."' ";
		    }


		    //$sql = "SELECT id, text, url, topdown, view FROM ".$menu_table. $where." ORDER BY topdown";
		    $sql = "SELECT ".$menu_table.".id AS menue_id, ".$menu_table.".seiten_id AS id,  ".$menu_table.".text,  ".$menu_table.".url,  ".$menu_table.".topdown,  ".$menu_table.".view, ".$galerie_table.".titel AS intro , ".$galerie_table.".id AS galerie_id, ".$galerie_table.".ausgabe, ".$galerie_table.".pdfurl, ".$images_table.".url  FROM ".$galerie_table.", ".$menu_table.", ".$seiten_table.", ".$images_table." WHERE  ".$seiten_table.".id = ".$menu_table.".seiten_id  AND ".$seiten_table.".galerie_id > 0 AND ".$galerie_table.".id = ".$seiten_table.".galerie_id AND ".$images_table.".galerien_id = ".$galerie_table.".id AND ".$images_table.".positionId = '3' ". $where." ORDER BY voedate DESC";
		    //echo 'SQLLL:'.$sql;
		    if (!($res = $this->sql_query($sql)))
		    {
			    echo 'Fehler: '.print_r($this->sql_error());
			    echo 'sql: '.$sql;
			    return false;
		    }
		   
		    $this->menue_vars=$this->sql_fetchrowset($res);
		    //print_r($this->menue_vars);
		    return true;
		}
		else{
		    return false;
		}
	}


	/**
	* Output 
	*
	* @param string accesslevel
	*/
	function display($level='')
	{

	  
		if($this->getMenue_vars($level)){
		    return $this->menue_vars;
		}
		else{
		    return false;
		}
	 


	 
	}
}

?>