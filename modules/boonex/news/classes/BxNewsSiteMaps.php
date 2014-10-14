<?php
/**
 *  
 *  
 */

bx_import('BxDolPrivacy');
bx_import('BxDolTextSiteMaps');

/**
 * Sitemaps generator for News
 */
class BxNewsSiteMaps extends BxDolTextSiteMaps
{
    protected function __construct($aSystem)
    {
        parent::__construct($aSystem, BxDolModule::getInstance('BxNewsModule'));
    }
}
