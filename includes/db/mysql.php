<?php

/* * *************************************************************************
 *                                 mysql4.php
 *                            -------------------

 *
 * 
 *
 * ************************************************************************* */

/* * *************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 * ************************************************************************* */

if (!defined("SQL_LAYER")) {

    define("SQL_LAYER", "mysql");

    class sql_db {

        public $db_connect_id;
        public $query_result;
        public $row = array();
        public $rowset = array();
        public $num_queries = 0;
        public $in_transaction = 0;

        //
        // Constructor
        //
        function __construct($server, $user, $password, $database) {
            $this->user = $user;
            $this->password = $password;
            $this->server = $server;
            $this->dbname = $database;

            $this->db_connect_id = mysqli_connect($this->server, $this->user, $this->password, $this->dbname);

            if ($this->db_connect_id) {
                return $this->db_connect_id;
            } else {
                return false;
            }
        }

        //
        // Other base methods
        //
        function sql_close() {
            if ($this->db_connect_id) {
                //
                // Commit any remaining transactions
                //
                if ($this->in_transaction) {
                    mysql_query("COMMIT", $this->db_connect_id);
                }

                return mysqli_close($this->db_connect_id);
            } else {
                return false;
            }
        }

        //
        // Base query method43
        //  
        //
        function sql_query($query = "", $transaction = FALSE) {
            //
            // Remove any pre-existing queries
            //
            unset($this->query_result);

            if ($query != "") {
                $this->num_queries++;
                $this->query_result = mysqli_query($this->db_connect_id, $query);
            } 

            if ($this->query_result) {

                return $this->query_result;
            } else {

                  return false;
            }
        }

        //
        // Other query methods
        //
        function sql_numrows($query_id = 0) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }

            return ( $query_id ) ? mysqli_num_rows($query_id) : false;
        }

        function sql_affectedrows() {
            return ( $this->db_connect_id ) ? mysql_affected_rows($this->db_connect_id) : false;
        }

        function sql_numfields($query_id = 0) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }

            return ( $query_id ) ? mysql_num_fields($query_id) : false;
        }

        function sql_fieldname($offset, $query_id = 0) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }

            return ( $query_id ) ? mysql_field_name($query_id, $offset) : false;
        }

        function sql_fieldtype($offset, $query_id = 0) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }

            return ( $query_id ) ? mysql_field_type($query_id, $offset) : false;
        }

        //function sql_fetch_array($query_id = 0, $arraytype= MYSQL_ASSOC)
        function sql_fetchrow($query_id = 0, $arraytype = MYSQLI_ASSOC) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }

            if ($query_id) {
                //var_dump($query_id);
                $this->row = mysqli_fetch_array($query_id, $arraytype); #################
                
                return $this->row; ######################################################
            } else {
                return false;
            }
        }

        function sql_fetchrowset($query_id = 0, $arraytype = MYSQLI_ASSOC) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }
           
            if ($query_id) {
                //unset($this->rowset["$query_id"]); ########################################
                //unset($this->row["$query_id"]); ###########################################

                while ($this->rowset = mysqli_fetch_array($query_id, $arraytype)) {##############
                    
                    $result[] = $this->rowset;

                }
                return $result;
            } else {
                return false;
            }
        }

        function sql_fetchfield($field, $rownum = -1, $query_id = 0) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }

            if ($query_id) {
                if ($rownum > -1) {
                    $result = mysql_result($query_id, $rownum, $field);
                } else {
                    if (empty($this->row[$query_id]) && empty($this->rowset[$query_id])) {
                        if ($this->sql_fetchrow()) {
                            $result = $this->row[$query_id][$field];
                        }
                    } else {
                        if ($this->rowset[$query_id]) {
                            $result = $this->rowset[$query_id][$field];
                        } else if ($this->row[$query_id]) {
                            $result = $this->row[$query_id][$field];
                        }
                    }
                }

                return $result;
            } else {
                return false;
            }
        }

        function sql_rowseek($rownum, $query_id = 0) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }

            return ( $query_id ) ? mysqli_data_seek($query_id, $rownum) : false;
        }

        function sql_nextid() {
            return ( $this->db_connect_id ) ? mysqli_insert_id($this->db_connect_id) : false;
        }

        function sql_freeresult($query_id = 0) {
            if (!$query_id) {
                $query_id = $this->query_result;
            }

            if ($query_id) {
                unset($this->row[$query_id]);
                unset($this->rowset[$query_id]);

                mysql_free_result($query_id);

                return true;
            } else {
                return false;
            }
        }

        function sql_error() {

            return $message = mysqli_error($this->db_connect_id);
        }

    }

    // class sql_db
} // if ... define
?>
