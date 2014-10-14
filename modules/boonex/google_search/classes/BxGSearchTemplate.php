<?php
/**
 *  
 *  
 */

bx_import ('BxDolTwigTemplate');

/*
 * Map module View
 */
class BxGSearchTemplate extends BxDolTwigTemplate
{
    /**
     * Constructor
     */
    function BxGSearchTemplate(&$oConfig, &$oDb)
    {
        parent::BxDolTwigTemplate($oConfig, $oDb);
        $this->_iPageIndex = 401;
    }
}
