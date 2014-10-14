<?php
/**
 *  
 *  
 */

bx_import('BxDolModuleDb');

/*
 * Map module Data
 */
class BxGSearchDb extends BxDolModuleDb
{
    /*
     * Constructor.
     */
    function BxGSearchDb(&$oConfig)
    {
        parent::BxDolModuleDb();
        $this->_sPrefix = $oConfig->getDbPrefix();
    }

    function getSettingsCategory()
    {
        return $this->getOne("SELECT `ID` FROM `sys_options_cats` WHERE `name` = 'Google Search' LIMIT 1");
    }
}
