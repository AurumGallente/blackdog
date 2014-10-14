<?php
/**
 *  
 *  
 */

bx_import('BxDolModule');
bx_import('BxTemplVotingView');

class BxDolTextVoting extends BxTemplVotingView
{
    var $_oModule;

    function BxDolTextVoting($sSystem, $iId, $iInit = 1)
    {
        parent::BxTemplVotingView($sSystem, $iId, $iInit);

        $this->_oModule = null;
    }
}
