<?php

/**
 *  
 *  
 */

require_once( '../inc/header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'utils.inc.php' );

if ( $_POST['post_data'] ) echo process_pass_data( $_POST['post_data'] );
