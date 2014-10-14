<?php
/**
 *  
 *  
 */

bx_import('BxDolTextVoting');

class BxFdbVoting extends BxDolTextVoting
{
    function BxFdbVoting($sSystem, $iId, $iInit = 1)
    {
        parent::BxDolTextVoting($sSystem, $iId, $iInit);

        $this->_oModule = BxDolModule::getInstance('BxFdbModule');
    }
}
