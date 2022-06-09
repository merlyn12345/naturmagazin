<?php

class seite extends sql_db {

    /**
     * menue variables
     *
     * @var array
     */
    protected $seiten_vars;
    protected $roles;

    /**
     * Constructor
     */
    function __construct($dbhost = 'localhost', $dbuser = 'root', $dbpass = '', $database = 'blog') {
        parent::__construct($dbhost, $dbuser, $dbpass, $database, $persistency = false);
        $this->seiten_vars = array();
    }

    /**
     * 	*
     * @param  menu_table  Tablename in DB
     * @return none
     */
    function getRoles($role_table = '') {
        $sql = "SELECT rolle FROM " . $role_table;
        if (!($res = $this->sql_query($sql))) {
            echo 'Fehler: ' . print_r($this->sql_error());
            echo 'sql: ' . $sql;
            return false;
        }
        $rollenset = $this->sql_fetchrowset();
        foreach ($rollenset as $key => $value) {
            $this->roles[] = $value['rolle'];
        }

        return true;
    }

    function getSeiten_vars($id = '1', $seiten_table = 'seiten', $special = '') {
        global $params;
        if ('' == $seiten_table) {
            $seiten_table = $params['tables']['seiten'];
        }

        $sql = "SELECT * FROM " . $seiten_table . " WHERE id = " . $id;
        if (!($res = $this->sql_query($sql))) {
            echo 'Fehler: ' . print_r($this->sql_error());
            echo 'sql: ' . $sql;
            return false;
        } else {
            $this->seiten_vars = $this->sql_fetchrow();
            return true;
        }
    }

    /**
     * Output 
     *
     * @param string accesslevel
     */
    function output($id = '1') {


        if ($this->getSeiten_vars($id)) {
            return $this->seiten_vars;
        } else {
            return false;
        }
    }

}

?>