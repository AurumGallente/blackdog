<?php
/**
 *  
 *  
 */

require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolFilesPageAlbumsOwner.php');

class BxFilesPageAlbumsOwner extends BxDolFilesPageAlbumsOwner
{
    function BxFilesPageAlbumsOwner(&$oShared, $aParams = array())
    {
        parent::BxDolFilesPageAlbumsOwner('bx_files_albums_owner', $oShared, $aParams);
    }
}
