<?php
/**
 *  
 *  
 */

bx_import('BxDolPrivacy');
bx_import('BxDolTextSiteMaps');

/**
 * Sitemaps generator for Articles
 */
class BxArlSiteMaps extends BxDolTextSiteMaps
{
    protected function __construct($aSystem)
    {
        parent::__construct($aSystem, BxDolModule::getInstance('BxArlModule'));
    }
}
