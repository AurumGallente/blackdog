<?php

/**
 *  
 *  
 */

require_once('inc/header.inc.php' );
require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolGzip.php');

$sFile = strip_tags($_GET['file']);
BxDolGzip::load($sFile);
