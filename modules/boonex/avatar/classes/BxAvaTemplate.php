<?php
/**
 *  
 *  
 */

bx_import ('BxDolTwigTemplate');

/*
 * Avatar module View
 */
class BxAvaTemplate extends BxDolTwigTemplate
{
    /**
     * Constructor
     */
    function BxAvaTemplate(&$oConfig, &$oDb)
    {
        parent::BxDolTwigTemplate($oConfig, $oDb);
        $this->_iPageIndex = 500;
    }
}
