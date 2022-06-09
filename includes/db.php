<?php
/***************************************************************************
 *                                 db.php
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('INI_LOADED') )
{
	die('Hacking attempt');
}



switch($dbms)
{
	case 'mysql3':
		include($params['paths']['includes'] . 'db/mysql3.'.$phpEx);
		break;

	case 'mysql':
		include($params['paths']['includes'] . 'db/mysql.'.$phpEx);
		break;

	case 'postgres':
		include($params['paths']['includes'] . 'db/postgres7.'.$phpEx);
		break;

	case 'mssql':
		include($params['paths']['includes']. 'db/mssql.'.$phpEx);
		break;

	case 'oracle':
		include($params['paths']['includes'] . 'db/oracle.'.$phpEx);
		break;

	case 'msaccess':
		include($params['paths']['includes']. 'db/msaccess.'.$phpEx);
		break;

	case 'mssql-odbc':
		include($params['paths']['includes'] . 'db/mssql-odbc.'.$phpEx);
		break;
}



// Make the database connection.
$db = new sql_db($params['db']['host'], $params['db']['user'], $params['db']['passwd'], $params['db']['name'], false);

//echo 'yeeeha';
//echo 'id'.$db->db_connect_id;
if(!$db->db_connect_id)
{
   die("Could not connect to the database");
}
//echo 'id'.$db->db_connect_id;

?>