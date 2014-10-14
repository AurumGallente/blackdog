<?php
/**
 *  
 *  
 */

bx_import('BxTemplVotingView');

class BxGroupsVoting extends BxTemplVotingView
{
    /**
     * Constructor
     */
    function BxGroupsVoting($sSystem, $iId)
    {
        parent::BxTemplVotingView($sSystem, $iId);
    }

    function getMain()
    {
        return BxDolModule::getInstance('BxGroupsModule');
    }

    function checkAction ()
    {
        if (!parent::checkAction())
            return false;
        $oMain = $this->getMain();
        $aDataEntry = $oMain->_oDb->getEntryById($this->getId ());
        return $oMain->isAllowedRate($aDataEntry);
    }
}
