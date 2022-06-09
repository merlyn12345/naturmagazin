<?php
class lin_menue extends sql_db
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


	function getMenue_vars($level='', $menu_table='lin_menue', $role_table='')
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
			    $where = " AND lin_menue.rollen_id = '".$level."' ";
		    }


		    //$sql = "SELECT id, text, url, topdown, view FROM ".$menu_table. $where." ORDER BY topdown";
		    $sql = "SELECT lin_menue.id, seiten_id, lin_menue.text, lin_menue.url, lin_menue.topdown, lin_menue.view, seiten.galerie_id FROM seiten, ".$menu_table." WHERE view ='1' AND seiten.id=lin_menue.seiten_id". $where." ORDER BY topdown";
		    if (!($res = $this->sql_query($sql)))
		    {
			    echo 'Fehler: '.print_r($this->sql_error());
			    echo 'sql: '.$sql;
			    return false;
		    }
		    $this->menue_vars=$this->sql_fetchrowset($res);
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