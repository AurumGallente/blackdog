<?php

/**
 *  
 *  
 */

bx_import('BxDolTextTemplate');

class BxArlTemplate extends BxDolTextTemplate
{
    function BxArlTemplate(&$oConfig, &$oDb)
    {
        parent::BxDolTextTemplate($oConfig, $oDb);

        $this->sCssPrefix = 'arl';
    }
}
