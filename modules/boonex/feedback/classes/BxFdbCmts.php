<?php
/**
 *  
 *  
 */

bx_import('BxDolTextCmts');

class BxFdbCmts extends BxDolTextCmts
{
    function BxFdbCmts($sSystem, $iId, $iInit = 1)
    {
        parent::BxDolTextCmts($sSystem, $iId, $iInit);

        $this->_oModule = BxDolModule::getInstance('BxFdbModule');
    }
}
