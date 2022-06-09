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
	    	$sql = "SELECT rolle FROM ".$role_table;
		if (!($res = $this->sql_query($sql)))
		{
			echo 'Fehler: '.print_r($this->sql_error());
			echo 'sql: '.$sql;
		}
		$this->roles=$this->sql_fetchrow();
	}


	function getMenue_vars($level='', $menu_table='lin_menue', $role_table='')
	{
		global $params;
		$where = '';
		if(''== $role_table){
		    $role_table = $params['tables']['rollen'];
		}
		$this->getRoles($role_table);
		if(!empty($level) && in_array($level, $this->roles)){
			$where = " WHERE edit = '".$level."' ";
		}
		
		$sql = "SELECT id, text, url, topdown, view FROM ".$menu_table. $where." ORDER BY topdown";
		if (!($res = $this->sql_query($sql)))
		{
			echo 'Fehler: '.print_r($this->sql_error());
			echo 'sql: '.$sql;
		}
		$this->menue_vars=$this->sql_fetchrowset($res);
	}


	/**
	* Output 
	*
	* @param string accesslevel
	*/
	function display($level='')
	{
		$this->getMenue_vars($level);
		return $this->menue_vars;
	}
}

?>