<?php

/**
 *  
 *  
 */

require_once( '../inc/header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'design.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'admin.inc.php' );

$logged['admin'] = member_auth( 1, true, true );

phpinfo();
