<?php
/**
 *  
 *  
 */

require_once( 'inc/header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'design.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'profiles.inc.php' );

// --------------- page variables and login

$_page['name_index'] 	= 17;

check_logged();

$_page['header'] = _t( "_ADVICE_H" );
$_page['header_text'] = _t( "_ADVICE_H1" );

// --------------- page components

$_ni = $_page['name_index'];
$_page_cont[$_ni]['page_main_code'] = PageCompMainCode();

// --------------- [END] page components

PageCode();

// --------------- page components functions

/**
 * page code function
 */
function PageCompMainCode()
{
    $sRet = '<div class="dbContent">' . str_replace( '<site_url>', $GLOBALS['site']['url'], _t( "_ADVICE" )) . '</div>';
    return DesignBoxContent( _t( "_ADVICE_H1" ), $sRet, $GLOBALS['oTemplConfig'] -> PageCompThird_db_num);
}