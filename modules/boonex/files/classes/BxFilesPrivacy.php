<?php
/**
 *  
 *  
 */

bx_import('BxDolPrivacy');

class BxFilesPrivacy extends BxDolPrivacy
{
    /**
     * Constructor
     */
    function BxFilesPrivacy($sTable = 'bx_files_main', $sId = 'ID', $sOwner = 'Owner')
    {
        parent::BxDolPrivacy($sTable, $sId, $sOwner);
    }

    function getFieldAction($sAction)
    {
        return 'Allow' . str_replace(' ', '', ucwords(str_replace('_', ' ', $sAction)));
    }
}
