<?php
/**
 *  
 *  
 */

bx_import('BxDolTextVoting');

class BxNewsVoting extends BxDolTextVoting
{
    function BxNewsVoting($sSystem, $iId, $iInit = 1)
    {
        parent::BxDolTextVoting($sSystem, $iId, $iInit);

        $this->_oModule = BxDolModule::getInstance('BxNewsModule');
    }
}
