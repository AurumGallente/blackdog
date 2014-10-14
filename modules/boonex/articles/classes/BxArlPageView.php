<?php
/**
 *  
 *  
 */

bx_import('BxDolTextPageView');

class BxArlPageView extends BxDolTextPageView
{
    function BxArlPageView($sName, &$oObject)
    {
        parent::BxDolTextPageView('articles_single', $sName, $oObject);
    }
}
