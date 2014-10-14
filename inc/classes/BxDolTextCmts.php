<?php
/**
 *  
 *  
 */

bx_import('BxDolModule');
bx_import('BxTemplCmtsView');

class BxDolTextCmts extends BxTemplCmtsView
{
    var $_oModule;

    function BxDolTextCmts($sSystem, $iId, $iInit = 1)
    {
        parent::BxTemplCmtsView($sSystem, $iId, $iInit);

        $this->_oModule = null;
    }

    /**
     * get full comments block with initializations
     */
    function getCommentsShort($sType)
    {
        return array(
            'cmt_actions' => $this->getActions(0, $sType),
            'cmt_object' => $this->getId(),
            'cmt_addon' => $this->getCmtsInit()
        );
    }
}
