<?php
/**
 *  
 *  
 */

bx_import('BxTemplCmtsView');

class BxDolCmtsProfile extends BxTemplCmtsView
{
    /**
     * Constructor
     */
    function BxDolCmtsProfile($sSystem, $iId, $iInit = 1)
    {
        parent::BxTemplCmtsView($sSystem, $iId, $iInit);
    }

    function isRemoveAllowedAll()
    {
        if($this->_iId == $this->_getAuthorId() && getParam('enable_cmts_profile_delete') == 'on')
           return true;

        return parent::isRemoveAllowedAll();
    }
}
