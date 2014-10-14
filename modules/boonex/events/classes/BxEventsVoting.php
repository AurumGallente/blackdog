<?php
/**
 *  
 *  
 */

bx_import('BxTemplVotingView');

class BxEventsVoting extends BxTemplVotingView
{
    /**
     * Constructor
     */
    function BxEventsVoting($sSystem, $iId)
    {
        parent::BxTemplVotingView($sSystem, $iId);
    }

    function getMain()
    {
        $aPathInfo = pathinfo(__FILE__);
        require_once ($aPathInfo['dirname'] . '/BxEventsSearchResult.php');
        return BxEventsSearchResult::getMain();
    }

    function checkAction ()
    {
        if (!parent::checkAction())
            return false;
        $oMain = $this->getMain();
        $aEvent = $oMain->_oDb->getEntryByIdAndOwner($this->getId (), 0, true);
        return $oMain->isAllowedRate($aEvent);
    }
}
