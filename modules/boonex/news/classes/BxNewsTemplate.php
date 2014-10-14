<?php

/**
 *  
 *  
 */

bx_import('BxDolTextTemplate');

class BxNewsTemplate extends BxDolTextTemplate
{
    function BxNewsTemplate(&$oConfig, &$oDb)
    {
        parent::BxDolTextTemplate($oConfig, $oDb);

        $this->sCssPrefix = 'news';
    }
}
