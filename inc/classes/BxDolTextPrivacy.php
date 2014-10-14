<?php
/**
 *  
 *  
 */

bx_import('BxDolPrivacy');

class BxDolTextPrivacy extends BxDolPrivacy
{
    var $_oModule;

    function BxDolTextPrivacy(&$oModule)
    {
        parent::BxDolPrivacy($oModule->_oDb->getPrefix() . 'entries', 'id', 'author_id');

        $this->_oModule = $oModule;
    }
}
