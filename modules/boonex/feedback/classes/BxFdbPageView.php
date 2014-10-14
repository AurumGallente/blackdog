<?php
/**
 *  
 *  
 */

bx_import('BxDolTextPageView');

class BxFdbPageView extends BxDolTextPageView
{
    function BxFdbPageView($sName, &$oObject)
    {
        parent::BxDolTextPageView('feedback', $sName, $oObject);
    }
}
