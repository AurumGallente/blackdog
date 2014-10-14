<?php
/**
 *  
 *  
 */

bx_import('BxDolTextCmts');

class BxNewsCmts extends BxDolTextCmts
{
    function BxNewsCmts($sSystem, $iId, $iInit = 1)
    {
        parent::BxDolTextCmts($sSystem, $iId, $iInit);

        $this->_oModule = BxDolModule::getInstance('BxNewsModule');
    }
}
