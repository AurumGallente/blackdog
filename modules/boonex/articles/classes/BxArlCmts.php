<?php
/**
 *  
 *  
 */

bx_import('BxDolTextCmts');

class BxArlCmts extends BxDolTextCmts
{
    function BxArlCmts($sSystem, $iId, $iInit = 1)
    {
        parent::BxDolTextCmts($sSystem, $iId, $iInit);

        $this->_oModule = BxDolModule::getInstance('BxArlModule');
    }
}
