<?
    // Include Dolphin Core    
    include_once("../inc/header.inc.php");
    include_once("../inc/db.inc.php");
    require_once(BX_DIRECTORY_PATH_INC . 'admin.inc.php');
    
    // Incude Json controller    
    include_once(BX_DIRECTORY_PATH_ROOT . 'json/lib/json.class.php');
    
    // Defined global variable for modules
    define('API',true);
    
    // Iclude API classes
    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolJsonNews.php');
    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolJsonUtil.php');
    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolJsonUser.php');
//    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolXMLRPCMessages.php');
//    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolXMLRPCSearch.php');
//    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolXMLRPCFriends.php');
//    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolXMLRPCMedia.php');
//    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolXMLRPCImages.php');
//    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolXMLRPCMediaAudio.php');
//    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolXMLRPCMediaVideo.php');        
//    require_once(BX_DIRECTORY_PATH_ROOT . 'json/BxDolXMLRPCProfileView.php'); 
        
    $ApiJ->execute();