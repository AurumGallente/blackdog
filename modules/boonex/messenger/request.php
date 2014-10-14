<?php
/**
 *  
 *  
 */

require_once( BX_DIRECTORY_PATH_CLASSES . 'BxDolRequest.php' );
if(empty($aRequest[0]) || $aRequest[0] == 'index')
    BxDolRequest::processAsFile($aModule, $aRequest);
else
    echo BxDolRequest::processAsAction($aModule, $aRequest);
