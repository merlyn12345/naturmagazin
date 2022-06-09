<?php
/***************************************************************************
 *                                includes.php
 *                            -------------------
 *   begin                : Freitag, 13.01.06
 *   copyright            : (C) 2006 Georg Lange
 *   email                : lange@polynomic.de
 *
 * 
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
	die("go hacking elsewhere");
}


//require $params['paths']['includes'].'IT_mod.'.$phpEx;

require($params['paths']['includes'].'funktionen.'.$phpEx);
//echo 'yeeeha';
require($params['paths']['includes'].'db.'.$phpEx);
//echo 'yeeeha';
//require($params['paths']['includes'].'sauber.'.$phpEx);
//require($params['paths']['includes'].'parse_class.'.$phpEx);

require($params['paths']['includes'].'lin_menue_adv.'.$phpEx);

require($params['paths']['includes'].'seite.'.$phpEx);
#####################################
#IT
#
//

require_once "includes/ITX.php";


//include($root_path . 'includes/konstanten.'.$phpEx);
//include($root_path . 'includes/language.'.$phpEx);
//include($root_path . 'includes/sessions.'.$phpEx);

//
//include($root_path . 'includes/functions_validate.'.$phpEx);
//include($root_path . 'includes/zip_create_class.'.$phpEx);




?>