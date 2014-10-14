<?php
/**
 *  
 *  
 */

bx_import('BxDolTextPageView');

class BxNewsPageView extends BxDolTextPageView
{
    function BxNewsPageView($sName, &$oObject)
    {
        parent::BxDolTextPageView('news_single', $sName, $oObject);
    }
}
