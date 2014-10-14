<?php
/**
 *  
 *  
 */

bx_import('BxDolTextVoting');

class BxArlVoting extends BxDolTextVoting
{
    function BxArlVoting($sSystem, $iId, $iInit = 1)
    {
        parent::BxDolTextVoting($sSystem, $iId, $iInit);

        $this->_oModule = BxDolModule::getInstance('BxArlModule');
    }
}
